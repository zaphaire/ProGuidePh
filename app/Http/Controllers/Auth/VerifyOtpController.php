<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\LoginOtpCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\View\View;

class VerifyOtpController extends Controller
{
    private const MAX_OTP_ATTEMPTS = 5;
    private const OTP_LOCKOUT_SECONDS = 900;

    public function show(): View|RedirectResponse
    {
        if (!session()->has('pending_user_id')) {
            return redirect()->route('login');
        }

        $attemptsKey = 'otp_attempts_' . session('pending_user_id');
        $lockedUntil = session('otp_locked_until');

        if ($lockedUntil && now()->timestamp < $lockedUntil) {
            $remaining = $lockedUntil - now()->timestamp;
            return view('auth.verify-otp')->with('locked', true)->with('remaining', $remaining);
        }

        return view('auth.verify-otp');
    }

    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'otp_code' => ['required', 'string', 'size:6'],
        ]);

        $userId = session('pending_user_id');
        $boundIp = session('otp_ip_bound');

        if (!$userId) {
            return redirect()->route('login');
        }

        $attemptsKey = 'otp_attempts_' . $userId;
        $attempts = session($attemptsKey, 0);
        $lockedUntil = session('otp_locked_until');

        if ($lockedUntil && now()->timestamp < $lockedUntil) {
            $remaining = $lockedUntil - now()->timestamp;
            return back()->withErrors(['otp_code' => 'Too many failed attempts. Try again in ' . ceil($remaining / 60) . ' minutes.']);
        }

        $user = \App\Models\User::find($userId);

        if (!$user) {
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

        session()->forget('pending_user_id');
        session()->forget('otp_ip_bound');
        session()->forget('otp_generated_at');
        session(['otp_verified' => true]);

        Auth::login($user);
        $request->session()->regenerate();

        $intended = $user->isAdmin() ? route('admin.dashboard') : route('home');

        return redirect()->intended($intended);
    }

    public function resend(Request $request): RedirectResponse
    {
        $userId = session('pending_user_id');
        $lockedUntil = session('otp_locked_until');

        if ($lockedUntil && now()->timestamp < $lockedUntil) {
            return back()->withErrors(['otp_code' => 'Too many failed attempts. Please wait before requesting a new code.']);
        }

        if (!$userId) {
            return redirect()->route('login');
        }

        $user = \App\Models\User::find($userId);

        if (!$user) {
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

        session(['otp_attempts_' . $userId => 0]);

        return back()->with('status', 'A new verification code has been sent to your email.');
    }

    private function generateSecureOtp(): string
    {
        $bytes = random_bytes(4);
        $hex = bin2hex($bytes);
        $int = hexdec($hex);
        $otp = $int % 1000000;
        return str_pad($otp, 6, '0', STR_PAD_LEFT);
    }
}