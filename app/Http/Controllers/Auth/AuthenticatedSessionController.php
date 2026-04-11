<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\LoginAlertMail;
use App\Mail\LoginOtpCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->ensureIsNotRateLimited();

        $credentials = $request->only('email', 'password');
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();
        $email = $request->email;

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            \Illuminate\Support\Facades\RateLimiter::hit($request->throttleKey());

            DB::table('login_logs')->insert([
                'user_id' => null,
                'email' => $email,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'success' => false,
                'failure_reason' => 'Invalid credentials',
                'created_at' => now(),
            ]);

            $failedUser = \App\Models\User::where('email', $email)->first();
            if ($failedUser) {
                Mail::to($failedUser)->send(new LoginAlertMail(
                    $failedUser,
                    false,
                    $ipAddress,
                    $userAgent,
                    now()->format('F j, Y g:i A')
                ));
            }

            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        \Illuminate\Support\Facades\RateLimiter::clear($request->throttleKey());

        $user = Auth::user();

        $otpCode = $this->generateSecureOtp();
        $hashedOtp = hash('sha256', $otpCode);

        \Illuminate\Support\Facades\DB::table('users')
            ->where('id', $user->id)
            ->update([
                'otp_code' => $hashedOtp,
                'otp_expires_at' => now()->addMinutes(10),
                'is_otp_verified' => false,
            ]);

        Mail::to($user)->send(new LoginOtpCode($otpCode, $user->name));

        session([
            'pending_user_id' => $user->id,
            'otp_ip_bound' => $ipAddress,
            'otp_generated_at' => time(),
        ]);

        Auth::logout();

        return redirect()->route('otp.verify');
    }

    private function generateSecureOtp(): string
    {
        $bytes = random_bytes(4);
        $hex = bin2hex($bytes);
        $int = hexdec($hex);
        $otp = $int % 1000000;
        return str_pad($otp, 6, '0', STR_PAD_LEFT);
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}