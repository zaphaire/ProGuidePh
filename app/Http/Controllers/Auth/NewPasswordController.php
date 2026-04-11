<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    public function create(Request $request)
    {
        $token = $request->route('token');

        $record = DB::table('password_reset_tokens')
            ->where('token', $token)
            ->first();

        if (!$record) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Invalid password reset link.']);
        }

        $user = User::where('email', $record->email)->first();

        if (!$user) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'User not found.']);
        }

        $request->session()->put('reset_password_user_id', $user->id);
        $request->session()->put('reset_password_token', $token);

        return view('auth.reset-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $userId = $request->session()->get('reset_password_user_id');
        $token = $request->session()->get('reset_password_token');

        if (!$userId || !$token) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Password reset session expired.']);
        }

        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'User not found.']);
        }

        $record = DB::table('password_reset_tokens')
            ->where('token', $token)
            ->where('email', $user->email)
            ->first();

        if (!$record) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Invalid token.']);
        }

        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();

        DB::table('password_reset_tokens')
            ->where('email', $user->email)
            ->delete();

        $request->session()->forget('reset_password_user_id');
        $request->session()->forget('reset_password_token');

        event(new PasswordReset($user));

        return redirect()->route('login')->with('status', 'Password has been reset successfully.');
    }
}