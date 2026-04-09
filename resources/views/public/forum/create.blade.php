@extends('layouts.app')

@section('title', 'Create New Topic - Forum')

@section('content')

<div style="background:var(--primary);color:#fff;padding:2rem 1rem" class="forum-header">
    <div class="container">
        <h1 style="font-family:'Poppins',sans-serif;font-size:1.75rem;font-weight:700;margin-bottom:.5rem">💬 Start New Discussion</h1>
        <p style="color:rgba(255,255,255,.7);font-size:.95rem">Share your thoughts with the community.</p>
    </div>
</div>

<div class="container section">
    <div style="max-width:700px;margin:0 auto" class="forum-create-form">
        <a href="{{ route('forum.index') }}" style="display:inline-flex;align-items:center;gap:.5rem;color:var(--primary);margin-bottom:1.5rem;font-weight:500">
            ← Back to Forum
        </a>

        <div style="background:#fff;border-radius:16px;padding:2rem;box-shadow:var(--shadow-card)">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('forum.store') }}">
                @csrf
                <div style="margin-bottom:1.25rem">
                    <label style="display:block;font-size:.85rem;font-weight:600;color:var(--text);margin-bottom:.4rem">Your Name (optional)</label>
                    <input type="text" name="author_name" value="{{ old('author_name') }}" 
                        placeholder="Anonymous"
                        style="width:100%;padding:.65rem 1rem;border:2px solid var(--border);border-radius:10px;font-family:inherit;font-size:.9rem">
                </div>

                <div style="margin-bottom:1.25rem">
                    <label style="display:block;font-size:.85rem;font-weight:600;color:var(--text);margin-bottom:.4rem">Topic Title *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                        placeholder="What's on your mind?"
                        class="forum-input"
                        style="width:100%;padding:.65rem 1rem;border:2px solid var(--border);border-radius:10px;font-family:inherit;font-size:.9rem">
                    @error('title')<div style="color:#dc2626;font-size:.8rem;margin-top:.3rem">{{ $message }}</div>@enderror
                </div>

                <div style="margin-bottom:1.5rem">
                    <label style="display:block;font-size:.85rem;font-weight:600;color:var(--text);margin-bottom:.4rem">Your Message *</label>
                    <textarea name="body" rows="6" required
                        placeholder="Share your thoughts..."
                        style="width:100%;padding:.65rem 1rem;border:2px solid var(--border);border-radius:10px;font-family:inherit;font-size:.9rem;resize:vertical">{{ old('body') }}</textarea>
                    @error('body')<div style="color:#dc2626;font-size:.8rem;margin-top:.3rem">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn-primary" style="width:100%;justify-content:center">Post Discussion</button>
            </form>
        </div>
    </div>
</div>

@endsection
