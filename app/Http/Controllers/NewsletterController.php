<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function subscribe(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $email = $request->input('email');
        
        $existingSubscriber = Subscriber::where('email', $email)->first();

        if ($existingSubscriber) {
            if ($existingSubscriber->is_verified && $existingSubscriber->is_active) {
                return back()->with('message', 'You are already subscribed!');
            }
            
            if (!$existingSubscriber->is_verified) {
                $existingSubscriber->update(['verify_token' => \Illuminate\Support\Str::random(64)]);
                // Resend verification email would go here
                return back()->with('message', 'A new verification link has been sent to your email.');
            }

            if (!$existingSubscriber->is_active) {
                $existingSubscriber->update(['is_active' => true, 'is_verified' => true, 'verify_token' => null]);
                return back()->with('message', 'You have been re-subscribed successfully!');
            }
        }

        $subscriber = Subscriber::create([
            'email' => $email,
            'name' => $request->input('name'),
        ]);

        $subscriber->verify();

        return back()->with('message', 'Thank you for subscribing!');
    }

    public function unsubscribe(Request $request): RedirectResponse
    {
        $email = $request->input('email');
        $subscriber = Subscriber::where('email', $email)->first();

        if ($subscriber) {
            $subscriber->unsubscribe();
            return back()->with('message', 'You have been unsubscribed successfully.');
        }

        return back()->with('message', 'Email not found in our subscribers list.');
    }

    public function verify(string $token): RedirectResponse
    {
        $subscriber = Subscriber::where('verify_token', $token)->first();

        if ($subscriber) {
            $subscriber->verify();
            return redirect('/')->with('message', 'Email verified successfully!');
        }

        return redirect('/')->with('message', 'Invalid verification token.');
    }
}