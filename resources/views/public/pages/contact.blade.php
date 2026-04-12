@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')

    <div style="background:linear-gradient(135deg,var(--primary),#2d5490);color:#fff;padding:2rem 1rem" class="contact-page-header">
        <div class="container">
            <h1 style="font-family:'Merriweather',serif;font-size:1.75rem;font-weight:700;margin-bottom:.5rem;text-align:center">📬 Contact Us</h1>
            <p style="color:rgba(255,255,255,.75);font-size:.95rem;text-align:center">We'd love to hear from you</p>
        </div>
    </div>

    <div class="container section">
        <div class="grid-2-responsive" style="max-width:900px;margin:0 auto">
            <div>
                <h2 class="contact-page-heading" style="font-family:'Merriweather',serif;font-size:1.35rem;color:var(--primary);margin-bottom:1rem">Get in Touch</h2>
                @if($page)
                    <div style="color:var(--text-muted);margin-bottom:2rem">{!! $page->body !!}</div>
                @endif
                <div style="display:flex;flex-direction:column;gap:1.25rem">
                    <div class="contact-info-card" style="display:flex;align-items:center;gap:1rem;padding:1rem;background:#fff;border-radius:12px;box-shadow:var(--card-shadow)">
                        <span style="font-size:1.5rem">📧</span>
                        <div>
                            <div style="font-weight:600;color:var(--text)">Email</div>
                            <div style="color:var(--text-muted);font-size:.875rem">info@proguideph.com</div>
                        </div>
                    </div>
                    <div class="contact-info-card" style="display:flex;align-items:center;gap:1rem;padding:1rem;background:#fff;border-radius:12px;box-shadow:var(--card-shadow)">
                        <span style="font-size:1.5rem">📍</span>
                        <div>
                            <div style="font-weight:600;color:var(--text)">Location</div>
                            <div style="color:var(--text-muted);font-size:.875rem">
                                {{ \App\Models\Setting::get('site_address', 'Philippines') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="background:#fff;border-radius:20px;padding:2rem;box-shadow:var(--card-shadow)">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <h3 style="font-size:1.1rem;font-weight:700;color:var(--primary);margin-bottom:1.5rem">Send a Message</h3>
                <form method="POST" action="{{ route('contact.send') }}">
                    @csrf
                    <div style="margin-bottom:1rem">
                        <label
                            style="display:block;font-size:.85rem;font-weight:600;color:var(--text);margin-bottom:.4rem">Name
                            *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            style="width:100%;padding:.65rem 1rem;border:2px solid var(--border);border-radius:10px;font-family:inherit;font-size:.9rem">
                        @error('name')<div style="color:#dc2626;font-size:.8rem;margin-top:.3rem">{{ $message }}</div>
                        @enderror
                    </div>
                    <div style="margin-bottom:1rem">
                        <label
                            style="display:block;font-size:.85rem;font-weight:600;color:var(--text);margin-bottom:.4rem">Email
                            *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            style="width:100%;padding:.65rem 1rem;border:2px solid var(--border);border-radius:10px;font-family:inherit;font-size:.9rem">
                        @error('email')<div style="color:#dc2626;font-size:.8rem;margin-top:.3rem">{{ $message }}</div>
                        @enderror
                    </div>
                    <div style="margin-bottom:1rem">
                        <label
                            style="display:block;font-size:.85rem;font-weight:600;color:var(--text);margin-bottom:.4rem">Subject
                            *</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" required
                            style="width:100%;padding:.65rem 1rem;border:2px solid var(--border);border-radius:10px;font-family:inherit;font-size:.9rem">
                    </div>
                    <div style="margin-bottom:1.5rem">
                        <label
                            style="display:block;font-size:.85rem;font-weight:600;color:var(--text);margin-bottom:.4rem">Message
                            *</label>
                        <textarea name="message" rows="5" required
                            style="width:100%;padding:.65rem 1rem;border:2px solid var(--border);border-radius:10px;font-family:inherit;font-size:.9rem;resize:vertical">{{ old('message') }}</textarea>
                        @error('message')<div style="color:#dc2626;font-size:.8rem;margin-top:.3rem">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn-primary" style="justify-content:center">📨 Send
                        Message</button>
                </form>
            </div>
        </div>
    </div>

@endsection