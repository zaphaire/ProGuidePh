<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Mail\ContactFormSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    public function show(Page $page)
    {
        if (!$page->is_published) {
            $user = auth()->user();
            abort_if(!$user || !in_array($user->role, ['admin', 'editor']), 404);
        }
        return view('public.pages.show', compact('page'));
    }

    public function contact()
    {
        $page = Page::where('slug', 'contact')->where('is_published', true)->first();
        return view('public.pages.contact', compact('page'));
    }

    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        try {
            Mail::to('info@proguideph.com')->send(new ContactFormSubmitted($validated));
            Log::info('Contact form email sent to info@proguideph.com', $validated);
        } catch (\Exception $e) {
            Log::error('Failed to send contact form email: ' . $e->getMessage());
        }

        return back()->with('success', 'Your message has been sent! We will get back to you shortly.');
    }
}
