<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\LoginOtpCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class VerifyOtpController extends Controller
{
    public function show(): View|RedirectResponse
    {
        if (!session()->has('pending_user_id')) {
            return redirect()->route('login');
        }

        return view('auth.verify-otp');
    }

    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'otp_code' => ['required', 'string', 'size:6'],
        ]);

        $userId = session('pending_user_id');
        
        if (!$userId) {
            return redirect()->route('login');
        }

        $user = \App\Models\User::find($userId);

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->otp_code !== $request->otp_code) {
            return back()->withErrors(['otp_code' => 'Invalid verification code.']);
        }

        if ($user->otp_expires_at && now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors(['otp_code' => 'Verification code has expired.']);
        }

        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null,
            'is_otp_verified' => true,
        ]);

        session()->forget('pending_user_id');
        session(['otp_verified' => true]);

        Auth::login($user);
        $request->session()->regenerate();

        $intended = $user->isAdmin() ? route('admin.dashboard') : route('home');

        return redirect()->intended($intended);
    }

    public function resend(Request $request): RedirectResponse
    {
        $userId = session('pending_user_id');

        if (!$userId) {
            return redirect()->route('login');
        }

        $user = \App\Models\User::find($userId);

        if (!$user) {
            return redirect()->route('login');
        }

        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user->update([
            'otp_code' => $otpCode,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($user)->send(new LoginOtpCode($otpCode, $user->name));

        return back()->with('status', 'A new verification code has been sent to your email.');
    }
}