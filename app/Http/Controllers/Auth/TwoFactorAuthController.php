<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\LoginAlertMail;
use App\Mail\LoginOtpCode;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class TwoFactorAuthController extends Controller
{
    private const MAX_OTP_ATTEMPTS = 5;

    private const OTP_LOCKOUT_SECONDS = 900;

    public function showSelection(): View|RedirectResponse
    {
        if (! session()->has('pending_user_id')) {
            return redirect()->route('login');
        }

        return view('auth.2fa-select');
    }

    public function selectMethod(Request $request): RedirectResponse
    {
        if (! session()->has('pending_user_id')) {
            return redirect()->route('login');
        }

        $method = $request->input('method');

        if ($method === 'authenticator') {
            return $this->showAuthenticatorVerify();
        }

        return $this->sendEmailOtp();
    }

    public function sendEmailOtp(): RedirectResponse
    {
        $userId = session('pending_user_id');
        $user = User::find($userId);

        if (! $user) {
            return redirect()->route('login');
        }

        $otpCode = $this->generateSecureOtp();
        $hashedOtp = hash('sha256', $otpCode);

        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'otp_code' => $hashedOtp,
                'otp_expires_at' => now()->addMinutes(10),
                'is_otp_verified' => false,
            ]);

        Mail::to($user)->send(new LoginOtpCode($otpCode, $user->name));

        session([
            '2fa_method' => 'email',
            'otp_generated_at' => time(),
        ]);

        return redirect()->route('otp.verify');
    }

    public function showAuthenticatorVerify(): View|RedirectResponse
    {
        if (! session()->has('pending_user_id')) {
            return redirect()->route('login');
        }

        $userId = session('pending_user_id');
        $user = User::find($userId);

        if (! $user || ! $user->two_factor_enabled) {
            return back()->withErrors(['authenticator' => 'Authenticator is not set up for this account.']);
        }

        session(['2fa_method' => 'authenticator']);

        return view('auth.verify-authenticator');
    }

    public function verifyAuthenticator(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        $userId = session('pending_user_id');

        if (! $userId) {
            return redirect()->route('login');
        }

        $user = User::find($userId);

        if (! $user || ! $user->two_factor_enabled || ! $user->two_factor_secret) {
            return redirect()->route('2fa.select');
        }

        $code = $request->input('code');

        if (! $this->verifyTotp($user->two_factor_secret, $code)) {
            return back()->withErrors(['code' => 'Invalid authentication code.']);
        }

        return $this->completeLogin($request, $user);
    }

    public function verifyEmailOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'otp_code' => ['required', 'string', 'size:6'],
        ]);

        $userId = session('pending_user_id');
        $boundIp = session('otp_ip_bound');

        if (! $userId) {
            return redirect()->route('login');
        }

        $attemptsKey = 'otp_attempts_'.$userId;
        $attempts = session($attemptsKey, 0);
        $lockedUntil = session('otp_locked_until');

        if ($lockedUntil && now()->timestamp < $lockedUntil) {
            $remaining = $lockedUntil - now()->timestamp;

            return back()->withErrors(['otp_code' => 'Too many failed attempts. Try again in '.ceil($remaining / 60).' minutes.']);
        }

        $user = User::find($userId);

        if (! $user) {
            return redirect()->route('login');
        }

        $providedOtp = $request->otp_code;
        $hashedOtp = hash('sha256', $providedOtp);

        if ($user->otp_code !== $hashedOtp) {
            $newAttempts = $attempts + 1;
            session([$attemptsKey => $newAttempts]);

            if ($newAttempts >= self::MAX_OTP_ATTEMPTS) {
                $lockUntil = now()->timestamp + self::OTP_LOCKOUT_SECONDS;
                session(['otp_locked_until' => $lockUntil]);

                DB::table('login_logs')->insert([
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'success' => false,
                    'failure_reason' => 'OTP brute force lockout',
                    'created_at' => now(),
                ]);
            }

            return back()->withErrors(['otp_code' => 'Invalid verification code.']);
        }

        if ($user->otp_expires_at && now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors(['otp_code' => 'Verification code has expired.']);
        }

        session([$attemptsKey => 0, 'otp_locked_until' => null]);

        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'otp_code' => null,
                'otp_expires_at' => null,
                'is_otp_verified' => true,
            ]);

        return $this->completeLogin($request, $user);
    }

    public function resendOtp(Request $request): RedirectResponse
    {
        $userId = session('pending_user_id');
        $lockedUntil = session('otp_locked_until');

        if ($lockedUntil && now()->timestamp < $lockedUntil) {
            return back()->withErrors(['otp_code' => 'Too many failed attempts. Please wait before requesting a new code.']);
        }

        if (! $userId) {
            return redirect()->route('login');
        }

        $user = User::find($userId);

        if (! $user) {
            return redirect()->route('login');
        }

        $otpCode = $this->generateSecureOtp();
        $hashedOtp = hash('sha256', $otpCode);

        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'otp_code' => $hashedOtp,
                'otp_expires_at' => now()->addMinutes(10),
            ]);

        Mail::to($user)->send(new LoginOtpCode($otpCode, $user->name));

        session(['otp_attempts_'.$userId => 0]);

        return back()->with('status', 'A new verification code has been sent to your email.');
    }

    public function cancel(Request $request): RedirectResponse
    {
        $userId = session('pending_user_id');

        if ($userId) {
            DB::table('users')
                ->where('id', $userId)
                ->update([
                    'otp_code' => null,
                    'otp_expires_at' => null,
                    'is_otp_verified' => false,
                ]);
        }

        session()->forget([
            'pending_user_id',
            'otp_ip_bound',
            'otp_generated_at',
            'otp_verified',
            'otp_attempts_'.$userId,
            'otp_locked_until',
            '2fa_method',
        ]);

        return redirect()->route('login');
    }

    private function completeLogin(Request $request, User $user): RedirectResponse
    {
        session()->forget([
            'pending_user_id',
            'otp_ip_bound',
            'otp_generated_at',
            'otp_verified',
            'otp_attempts_'.$user->id,
            'otp_locked_until',
            '2fa_method',
        ]);

        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'otp_code' => null,
                'otp_expires_at' => null,
                'is_otp_verified' => true,
            ]);

        Auth::login($user);
        $request->session()->regenerate();

        DB::table('login_logs')->insert([
            'user_id' => $user->id,
            'email' => $user->email,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'success' => true,
            'failure_reason' => null,
            'created_at' => now(),
        ]);

        Mail::to($user)->send(new LoginAlertMail(
            $user,
            true,
            $request->ip(),
            $request->userAgent(),
            now()->format('F j, Y g:i A')
        ));

        $intended = $user->isAdmin() ? route('admin.dashboard') : route('home');

        return redirect()->intended($intended);
    }

    private function generateSecureOtp(): string
    {
        $bytes = random_bytes(4);
        $hex = bin2hex($bytes);
        $int = hexdec($hex);
        $otp = $int % 1000000;

        return str_pad($otp, 6, '0', STR_PAD_LEFT);
    }

    private function verifyTotp(string $secret, string $code): bool
    {
        $codes = $this->generateTotpCodes($secret);

        return in_array($code, $codes);
    }

    private function generateTotpCodes(string $secret): array
    {
        $secret = str_replace(' ', '', $secret);
        $secretKey = $this->base32Decode($secret);

        $timeSlot = floor(time() / 30);
        $codes = [];

        for ($i = -1; $i <= 1; $i++) {
            $time = $timeSlot + $i;
            $hmac = hash_hmac('sha1', pack('J', $time), $secretKey, true);
            $offset = ord(substr($hmac, -1)) & 0x0F;
            $code = (unpack('J', substr($hmac, $offset, 4))[1] & 0x7FFFFFFF);
            $codes[] = str_pad($code % 1000000, 6, '0', STR_PAD_LEFT);
        }

        return $codes;
    }

    private function base32Decode(string $input): string
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $input = str_replace('=', '', $input);
        $input = strtoupper($input);
        $binary = '';

        foreach (str_split($input) as $char) {
            $val = strpos($alphabet, $char);
            if ($val === false) {
                continue;
            }
            $binary .= str_pad(decbin($val), 5, '0', STR_PAD_LEFT);
        }

        return pack('B*', $binary);
    }
}
