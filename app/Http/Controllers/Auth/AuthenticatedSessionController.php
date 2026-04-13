<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\LoginAlertMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
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

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::hit($request->throttleKey());

            DB::table('login_logs')->insert([
                'user_id' => null,
                'email' => $email,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'success' => false,
                'failure_reason' => 'Invalid credentials',
                'created_at' => now(),
            ]);

            $failedUser = User::where('email', $email)->first();
            if ($failedUser) {
                Mail::to($failedUser)->send(new LoginAlertMail(
                    $failedUser,
                    false,
                    $ipAddress,
                    $userAgent,
                    now()->format('F j, Y g:i A')
                ));
            }

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($request->throttleKey());

        $user = Auth::user();

        session([
            'pending_user_id' => $user->id,
            'otp_ip_bound' => $ipAddress,
            'otp_generated_at' => time(),
        ]);

        Auth::logout();

        return redirect()->route('2fa.select');
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
        $user = $request->user();

        if ($user) {
            $userAgent = $request->userAgent();
            $ipAddress = $request->ip();

            DB::table('login_logs')->insert([
                'user_id' => $user->id,
                'email' => $user->email,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'success' => false,
                'failure_reason' => 'Logout',
                'created_at' => now(),
            ]);

            Mail::to($user)->send(new LoginAlertMail(
                $user,
                false,
                $ipAddress,
                $userAgent,
                now()->format('F j, Y g:i A'),
                true
            ));
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
