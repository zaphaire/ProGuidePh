<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

        // Log contact to mail log (swap to real mailer in production)
        \Log::info('Contact Form Submission', $validated);

        return back()->with('success', 'Your message has been sent! We will get back to you shortly.');
    }
}
