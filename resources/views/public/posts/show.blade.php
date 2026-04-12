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
    <div style="background:linear-gradient(-45deg, var(--primary-dark), var(--primary), var(--primary-light), var(--primary-dark)); background-size: 400% 400%; animation: gradientFlow 15s ease infinite; color:#fff; padding:5rem 0 4rem; position:relative; overflow:hidden">
        <div style="position:absolute;inset:0;background:url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E\"); opacity: 0.4;"></div>
        
        {{-- Floating shapes for depth --}}
        <div style="position:absolute; right:-5%; top:10%; width:300px; height:300px; background:radial-gradient(circle, rgba(232,160,32,0.1) 0%, transparent 70%); border-radius:50%; animation: floatSlow 8s ease-in-out infinite;"></div>
        <div style="position:absolute; left:-10%; bottom:0; width:400px; height:400px; background:radial-gradient(circle, rgba(36,56,104,0.2) 0%, transparent 70%); border-radius:50%; animation: floatSlow 12s ease-in-out infinite reverse;"></div>

        <div class="container" style="position:relative;z-index:1">
            <div class="reveal-scale active">
                @if($post->category)
                    <a href="{{ route('categories.show', $post->category->slug) }}" style="display:inline-flex;align-items:center;gap:.5rem;background:rgba(232,160,32,.15);backdrop-filter:blur(10px);border:1px solid rgba(232,160,32,.3);color:var(--accent-light);padding:.4rem 1rem;border-radius:999px;font-size:.8rem;font-weight:700;margin-bottom:1.5rem;text-transform:uppercase;letter-spacing:1px;transition:all 0.3s;" onmouseover="this.style.background='rgba(232,160,32,.25)';this.style.transform='translateY(-2px)'" onmouseout="this.style.background='rgba(232,160,32,.15)';this.style.transform='translateY(0)'">
                        {{ $post->category->icon }} {{ $post->category->name }}
                    </a>
                @endif
                <h1 style="font-family:'Playfair Display',serif;font-size:clamp(2rem, 5vw, 3.5rem);line-height:1.1;margin-bottom:1.5rem;max-width:900px;font-weight:700;color:#fff;text-shadow: 0 2px 10px rgba(0,0,0,0.2);">{{ $post->title }}</h1>
                
                <div style="display:flex;align-items:center;gap:2rem;flex-wrap:wrap;font-size:.95rem;color:rgba(255,255,255,0.85);margin-top:2rem;">
                    <div style="display:flex;align-items:center;gap:.75rem;padding:0.5rem 1rem;background:rgba(255,255,255,0.05);backdrop-filter:blur(5px);border-radius:999px;border:1px solid rgba(255,255,255,0.1);">
                        <img src="{{ $post->user->avatar_url }}" alt="{{ $post->user->name }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;border:2px solid var(--accent);">
                        <div style="display:flex;flex-direction:column;line-height:1.2">
                            <span style="font-weight:700;color:#fff;font-size:0.9rem">{{ $post->user->name }}</span>
                            <span style="font-size:0.75rem;opacity:0.8">Author</span>
                        </div>
                    </div>
                    
                    <div style="display:flex;gap:1.5rem;align-items:center">
                        <span style="display:flex;align-items:center;gap:.5rem">📅 {{ $post->published_at?->format('F d, Y') }}</span>
                        <span style="display:flex;align-items:center;gap:.5rem">👁 {{ number_format($post->views) }} Views</span>
                        <span style="display:flex;align-items:center;gap:.5rem">💬 {{ $post->approvedComments->count() }} Comments</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($post->featured_image_url)
        <div class="reveal-scale active" style="max-width:1000px;margin:2rem auto;padding:0 1.5rem;position:relative;z-index:2">
            <div style="background:rgba(255,255,255,0.1);padding:0.75rem;border-radius:24px;backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,0.2);box-shadow:0 30px 60px rgba(0,0,0,0.3);">
                <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" style="width:100%;border-radius:16px;max-height:550px;object-fit:cover;display:block;transition:all 0.5s ease;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
            </div>
        </div>
    @endif

    {{-- Content --}}
    <div class="container" style="padding-top:2rem;padding-bottom:3rem;position:relative;z-index:5">
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
            <aside style="position:relative;z-index:50">
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
                    {{-- Universal Share Button --}}
                    <button onclick="shareToTikTok(this)" id="universal-share-btn" 
                       style="display:flex;align-items:center;justify-content:center;gap:.6rem;background:linear-gradient(135deg, var(--primary), var(--primary-dark));color:#fff;padding:.8rem 1rem;border-radius:12px;text-align:center;font-size:.9rem;font-weight:700;transition:all 0.3s;box-shadow:0 8px 20px rgba(0,0,0,0.15);border:none;width:100%;cursor:pointer;position:relative;z-index:60;pointer-events:auto !important;"
                       onmouseover="this.style.transform='translateY(-2px) scale(1.02)';this.style.boxShadow='0 12px 25px rgba(0,0,0,0.2)'"
                       onmouseout="this.style.transform='translateY(0) scale(1)';this.style.boxShadow='0 8px 20px rgba(0,0,0,0.15)'">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                        Share it
                    </button>
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

@push('scripts')
<script>
/**
 * Universal Sharing Logic
 * Uses Native Share API (Mobile) or Clipboard Fallback (Desktop)
 */
function shareToTikTok(btn) {
    const url = window.location.href;
    const title = document.title;
    
    if (navigator.share) {
        navigator.share({
            title: title,
            url: url
        }).catch(err => {
            console.error('Share failed:', err);
            copyFallback(url, btn);
        });
    } else {
        copyFallback(url, btn);
    }
}

function copyFallback(text, btn) {
    const originalContent = btn.innerHTML;
    try {
        const textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.position = "fixed";
        textArea.style.left = "-9999px";
        textArea.style.top = "0";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        const successful = document.execCommand('copy');
        document.body.removeChild(textArea);
        
        if (successful) {
            btn.innerHTML = '<svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Link Copied!';
            btn.style.background = '#10b981';
            setTimeout(() => {
                btn.innerHTML = originalContent;
                btn.style.background = 'linear-gradient(135deg, var(--primary), var(--primary-dark))';
            }, 3000);
        }
    } catch (err) {
        window.prompt("Copy this link to share:", text);
    }
}
</script>
@endpush
