<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\TwoFactorAuthController;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $secret = null;
        $qrCode = null;

        if (! $user->two_factor_enabled) {
            $twoFaController = app(TwoFactorAuthController::class);
            $secret = $twoFaController->generateSecret();
            $qrCodeUrl = sprintf(
                'otpauth://totp/%s:%s?secret=%s&issuer=%s',
                rawurlencode(config('app.name')),
                rawurlencode($user->email),
                $secret,
                rawurlencode(config('app.name'))
            );
            $pngData = base64_encode(file_get_contents('https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl='.urlencode($qrCodeUrl)));
            $qrCode = '<img src="data:image/png;base64,'.$pngData.'" alt="QR Code" />';
            $request->session()->put('2fa_secret', $secret);
        }

        return view('profile.edit', [
            'user' => $user,
            'secret' => $secret,
            'qrCode' => $qrCode,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
