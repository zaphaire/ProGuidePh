<?php

namespace App\Http\Controllers;

use App\Mail\NewsletterConfirmation;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function subscribe(Request $request): \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $email = $request->input('email');
        
        $existingSubscriber = Subscriber::where('email', $email)->first();

        if ($existingSubscriber) {
            if ($existingSubscriber->is_verified && $existingSubscriber->is_active) {
                $message = 'You are already subscribed!';
                if ($request->expectsJson()) {
                    return response()->json(['message' => $message], 400);
                }
                return back()->with('message', $message);
            }
            
            if (!$existingSubscriber->is_verified) {
                $existingSubscriber->update(['verify_token' => \Illuminate\Support\Str::random(64)]);
                $message = 'A new verification link has been sent to your email.';
                if ($request->expectsJson()) {
                    return response()->json(['message' => $message]);
                }
                return back()->with('message', $message);
            }

            if (!$existingSubscriber->is_active) {
                $existingSubscriber->update(['is_active' => true, 'is_verified' => true, 'verify_token' => null]);
                $message = 'You have been re-subscribed successfully!';
                if ($request->expectsJson()) {
                    return response()->json(['message' => $message]);
                }
                return back()->with('message', $message);
            }
        }

        $subscriber = Subscriber::create([
            'email' => $email,
            'name' => $request->input('name'),
        ]);

        $subscriber->verify();

        Mail::to($subscriber)->send(new NewsletterConfirmation($subscriber));

        $message = 'Thank you for subscribing! Check your email for confirmation.';
        
        if ($request->expectsJson()) {
            return response()->json(['message' => $message]);
        }
        
        return back()->with('message', $message);
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