@extends('layouts.app')

@section('title', $post->meta_title ?? $post->title)
@section('meta_description', $post->meta_description ?? $post->excerpt)
@section('og_image', $post->featured_image_url)

@push('styles')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "{{ addslashes($post->title) }}",
  "description": "{{ addslashes($post->excerpt) }}",
  "datePublished": "{{ $post->published_at?->toIso8601String() }}",
  "dateModified": "{{ $post->updated_at->toIso8601String() }}",
  "author": {
    "@type": "Person",
    "name": "{{ addslashes($post->user->name) }}"
  },
  "publisher": {
    "@type": "Organization",
    "name": "ProGuidePh",
    "logo": {
      "@type": "ImageObject",
      "url": "{{ asset('images/og-default.png') }}"
    }
  },
  "image": "{{ $post->featured_image_url }}"
}
</script>
@endpush

@section('content')
<article>
    {{-- Hero --}}
    <div style="background:linear-gradient(135deg,var(--primary-dark) 0%, var(--primary) 50%, var(--primary-light) 100%);color:#fff;padding:4rem 0 3rem;position:relative;overflow:hidden">
        <div style="position:absolute;inset:0;background:url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E\");"></div>
        <div class="container" style="position:relative;z-index:1">
            @if($post->category)
                <a href="{{ route('categories.show', $post->category->slug) }}" style="display:inline-flex;align-items:center;gap:.4rem;background:rgba(251,209,22,.15);border:1px solid rgba(251,209,22,.3);color:var(--accent);padding:.35rem .85rem;border-radius:999px;font-size:.8rem;font-weight:600;margin-bottom:1rem">
                    {{ $post->category->icon }} {{ $post->category->name }}
                </a>
            @endif
            <h1 style="font-family:'Poppins',sans-serif;font-size:2.5rem;line-height:1.2;margin-bottom:1.25rem;max-width:800px;font-weight:800">{{ $post->title }}</h1>
            <div style="display:flex;align-items:center;gap:1.5rem;flex-wrap:wrap;font-size:.9rem;color:rgba(255,255,255,.75)">
                <div style="display:flex;align-items:center;gap:.5rem">
                    <img src="{{ $post->user->avatar_url }}" alt="{{ $post->user->name }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid var(--accent)">
                    <span style="font-weight:600">{{ $post->user->name }}</span>
                </div>
                <span style="display:flex;align-items:center;gap:.35rem">📅 {{ $post->published_at?->format('F d, Y') }}</span>
                <span style="display:flex;align-items:center;gap:.35rem">👁 {{ number_format($post->views) }} views</span>
                <span style="display:flex;align-items:center;gap:.35rem">💬 {{ $post->approvedComments->count() }} comments</span>
            </div>
        </div>
    </div>

    @if($post->featured_image_url)
        <div style="max-width:900px;margin:0 auto;padding:0 1.5rem;transform:translateY(-1.5rem)">
            <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" style="width:100%;border-radius:16px;box-shadow:0 20px 50px rgba(0,0,0,.2);max-height:450px;object-fit:cover">
        </div>
    @endif

    {{-- Content --}}
    <div class="container" style="padding-top:2rem;padding-bottom:3rem">
        <div class="post-layout-grid">
            <div>
                {{-- Excerpt --}}
                @if($post->excerpt)
                    <div style="font-size:1.1rem;color:var(--text-muted);line-height:1.8;margin-bottom:2rem;padding:1.25rem 1.5rem;border-left:4px solid var(--accent);background:rgba(245,158,11,.05);border-radius:0 10px 10px 0;">
                        {{ $post->excerpt }}
                    </div>
                @endif

                {{-- Body --}}
                <div style="font-size:1rem;line-height:1.85;color:var(--text)" class="post-body">
                    {!! $post->body !!}
                </div>

                {{-- In-Article Ad Unit | Replace ca-pub-XXXXXXXXXXXXXXXXX and data-ad-slot value with your real IDs --}}
                {{-- Uncomment after AdSense approval:
                <div style="margin:2rem 0;text-align:center">
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-XXXXXXXXXXXXXXXXX"
                         data-ad-slot="XXXXXXXXXX"
                         data-ad-format="auto"
                         data-full-width-responsive="true"></ins>
                    <script>(adsbygoogle = window.adsbygoogle || []).push({});<\/script>
                </div>
                --}}

                {{-- Comments --}}
                <div style="margin-top:3rem;border-top:2px solid var(--border);padding-top:2rem">
                    <h3 style="font-family:'Merriweather',serif;font-size:1.4rem;color:var(--primary);margin-bottom:1.5rem">
                        💬 Comments ({{ $comments->count() }})
                    </h3>

                    @forelse($comments as $comment)
                        <div style="background:#fff;border-radius:12px;padding:1.25rem;margin-bottom:1rem;box-shadow:var(--card-shadow)">
                            <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:.75rem">
                                <div style="width:40px;height:40px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:1rem">
                                    {{ strtoupper(substr($comment->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight:700;color:var(--text)">{{ $comment->name }}</div>
                                    <div style="font-size:.78rem;color:var(--text-muted)">{{ $comment->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            <p style="color:var(--text);line-height:1.7">{{ $comment->body }}</p>
                        </div>
                    @empty
                        <p style="color:var(--text-muted)">No comments yet. Be the first to comment!</p>
                    @endforelse

                    {{-- Comment Form --}}
                    <div style="background:#fff;border-radius:14px;padding:1.75rem;box-shadow:var(--card-shadow);margin-top:2rem">
                        <h4 style="font-size:1.05rem;font-weight:700;color:var(--primary);margin-bottom:1.25rem">Leave a Comment</h4>
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <form method="POST" action="{{ route('posts.comments.store', $post->slug) }}">
                            @csrf
                            <div class="comment-form-grid">
                                <div style="margin-bottom:1rem">
                                    <label style="display:block;font-size:.85rem;font-weight:600;color:var(--text);margin-bottom:.4rem">Name *</label>
                                    <input type="text" name="name" value="{{ old('name') }}" required style="width:100%;padding:.65rem 1rem;border:2px solid var(--border);border-radius:10px;font-family:inherit;font-size:.9rem;transition:border .2s" class="input-focus">
                                    @error('name')<div style="color:#dc2626;font-size:.8rem;margin-top:.3rem">{{ $message }}</div>@enderror
                                </div>
                                <div style="margin-bottom:1rem">
                                    <label style="display:block;font-size:.85rem;font-weight:600;color:var(--text);margin-bottom:.4rem">Email *</label>
                                    <input type="email" name="email" value="{{ old('email') }}" required style="width:100%;padding:.65rem 1rem;border:2px solid var(--border);border-radius:10px;font-family:inherit;font-size:.9rem">
                                    @error('email')<div style="color:#dc2626;font-size:.8rem;margin-top:.3rem">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div style="margin-bottom:1.25rem">
                                <label style="display:block;font-size:.85rem;font-weight:600;color:var(--text);margin-bottom:.4rem">Comment *</label>
                                <textarea name="body" rows="4" required style="width:100%;padding:.65rem 1rem;border:2px solid var(--border);border-radius:10px;font-family:inherit;font-size:.9rem;resize:vertical">{{ old('body') }}</textarea>
                                @error('body')<div style="color:#dc2626;font-size:.8rem;margin-top:.3rem">{{ $message }}</div>@enderror
                            </div>
                            <p style="font-size:.8rem;color:var(--text-muted);margin-bottom:1rem">Your comment will be reviewed before publishing.</p>
                            <button type="submit" class="btn-primary">Submit Comment</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <aside style="position:sticky;top:100px">
                @if($relatedPosts->isNotEmpty())
                    <div class="card" style="padding:1.4rem;margin-bottom:1.5rem">
                        <h3 style="font-weight:700;color:var(--primary);margin-bottom:1rem;font-size:.95rem">Related Articles</h3>
                        @foreach($relatedPosts as $related)
                            <a href="{{ route('posts.show', $related->slug) }}" style="display:flex;gap:.75rem;margin-bottom:1rem;padding-bottom:1rem;border-bottom:1px solid var(--border)">
                                <div style="width:70px;height:55px;border-radius:8px;overflow:hidden;flex-shrink:0;background:var(--primary);display:flex;align-items:center;justify-content:center;font-size:1.5rem">
                                    {{ $related->category?->icon ?? '💡' }}
                                </div>
                                <div>
                                    <div style="font-size:.85rem;font-weight:600;color:var(--text);line-height:1.4">{{ Str::limit($related->title, 55) }}</div>
                                    <div style="font-size:.78rem;color:var(--text-muted);margin-top:.25rem">{{ $related->published_at?->format('M d, Y') }}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif

                <div class="card" style="padding:1.4rem;background:linear-gradient(135deg,var(--primary),var(--primary-light));color:#fff">
                    <div style="font-size:1.5rem;margin-bottom:.75rem">📢</div>
                    <h3 style="font-weight:700;margin-bottom:.5rem">Share this Article</h3>
                    <p style="font-size:.85rem;color:rgba(255,255,255,.7);margin-bottom:1rem">Help others find this content</p>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" style="display:block;background:rgba(255,255,255,.15);color:#fff;padding:.6rem 1rem;border-radius:8px;text-align:center;font-size:.875rem;font-weight:600;margin-bottom:.5rem">📘 Share on Facebook</a>
                </div>

                {{-- Sidebar Ad Unit | Replace ca-pub-XXXXXXXXXXXXXXXXX and data-ad-slot value with your real IDs --}}
                {{-- Uncomment after AdSense approval:
                <div style="margin-top:1.5rem">
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-XXXXXXXXXXXXXXXXX"
                         data-ad-slot="XXXXXXXXXX"
                         data-ad-format="auto"
                         data-full-width-responsive="true"></ins>
                    <script>(adsbygoogle = window.adsbygoogle || []).push({});<\/script>
                </div>
                --}}
            </aside>
        </div>
    </div>
</article>

<style>
.post-body h1,.post-body h2,.post-body h3 { font-family:'Merriweather',serif; color:var(--primary); margin:1.75rem 0 .75rem; }
.post-body h2 { font-size:1.5rem; }
.post-body h3 { font-size:1.2rem; }
.post-body p { margin-bottom:1.25rem; }
.post-body ul,.post-body ol { margin:1rem 0 1rem 2rem; }
.post-body li { margin-bottom:.4rem; }
.post-body blockquote { border-left:4px solid var(--accent); padding:1rem 1.5rem; background:rgba(245,158,11,.05); border-radius:0 10px 10px 0; margin:1.5rem 0; font-style:italic; }
.post-body img { border-radius:12px; box-shadow:0 8px 20px rgba(0,0,0,.1); margin:1.5rem 0; }
.post-body a { color:var(--primary); border-bottom:1px solid var(--accent); }
.post-body code { background:#f3f4f6; padding:.2rem .4rem; border-radius:4px; font-size:.9em; }
.post-body pre { background:#1e293b; color:#e2e8f0; padding:1.25rem; border-radius:10px; overflow-x:auto; margin:1.5rem 0; }
.post-layout-grid { display:grid; grid-template-columns:1fr 280px; gap:3rem; align-items:start; }
.comment-form-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
@media (max-width: 900px) {
    .post-layout-grid { grid-template-columns: 1fr; gap: 2rem; }
}
@media (max-width: 600px) {
    .comment-form-grid { grid-template-columns: 1fr; }
}
</style>

@endsection
