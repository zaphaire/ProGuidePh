@extends('layouts.app')

@section('title', 'Articles')

@section('content')

<div class="posts-page-header" style="background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 50%, var(--primary-light) 100%); color: #fff; padding: 3rem 1rem; position: relative; overflow: hidden;">
    <div style="position: absolute; inset: 0; background: url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E\");"></div>
    <div class="container" style="position: relative; z-index: 1;">
        <h1 style="font-family:'Poppins',sans-serif;font-size:2.5rem;font-weight:800;margin-bottom:.5rem">📚 Articles</h1>
        <p style="color:rgba(255,255,255,.85);font-size:1.1rem;max-width:500px">Discover practical tips and helpful guides written by Filipinos, for Filipinos</p>
    </div>
</div>
</div>

<div class="container section">
    <div class="sidebar-layout-grid">
        {{-- Posts --}}
        <div>
            {{-- Search/Filter --}}
            <form method="GET" class="search-form-responsive" style="display:flex;gap:.75rem;margin-bottom:2rem;flex-wrap:wrap;align-items:stretch;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search articles..." style="flex:1;min-width:200px;padding:.75rem 1.25rem;border:2px solid var(--border);border-radius:12px;font-family:inherit;font-size:.95rem;background:#fff;transition:border-color .2s,box-shadow .2s;" onfocus="this.style.borderColor='var(--primary)';this.style.boxShadow='0 0 0 3px rgba(0,56,168,0.1)'" onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
                <button type="submit" class="btn-primary search-btn-mobile" style="padding:.75rem 1.5rem;">🔍 Search</button>
                @if(request('search') || request('category'))
                    <a href="{{ route('posts.index') }}" class="clear-btn" style="padding:.75rem 1.25rem;border:2px solid var(--border);border-radius:12px;color:var(--text-muted);font-size:.95rem;display:flex;align-items:center;background:#fff;transition:background .2s" onmouseover="this.style.background='var(--bg-soft)'" onmouseout="this.style.background='#fff'">✕ Clear</a>
                @endif
            </form>

            @if($posts->isNotEmpty())
                <div class="posts-grid" style="grid-template-columns:1fr;gap:1.5rem">
                    @foreach($posts as $post)
                        <a href="{{ route('posts.show', $post->slug) }}" class="post-card-horizontal" style="display:flex;flex-direction:row;overflow:hidden;background:var(--bg-card);border-radius:16px;border:1px solid var(--border-light);box-shadow:var(--shadow-card);transition:transform .3s,box-shadow .3s;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='var(--shadow-card-hover)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='var(--shadow-card)'">
                            <div class="post-card-horizontal-img" style="width:240px;flex-shrink:0;position:relative;overflow:hidden">
                                @if($post->featured_image)
                                    <img src="{{ asset('storage/'.$post->featured_image) }}" alt="{{ $post->title }}" style="width:100%;height:100%;object-fit:cover;min-height:180px;transition:transform .4s" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                @else
                                    <div style="width:100%;height:100%;min-height:180px;background:linear-gradient(135deg,var(--primary),var(--primary-light));display:flex;align-items:center;justify-content:center;font-size:3rem">
                                        {{ $post->category?->icon ?? '📖' }}
                                    </div>
                                @endif
                                @if($post->is_featured)
                                    <span style="position:absolute;top:12px;left:12px;background:var(--accent);color:var(--primary-dark);font-size:.7rem;font-weight:700;padding:.25rem .65rem;border-radius:999px">⭐ Featured</span>
                                @endif
                            </div>
                            <div class="card-body" style="flex:1;padding:1.5rem;display:flex;flex-direction:column;justify-content:center">
                                @if($post->category)
                                    <span class="card-category" style="background:{{ $post->category->color }}15;color:{{ $post->category->color }};font-size:.7rem;margin-bottom:.75rem;width:fit-content">
                                        {{ $post->category->name }}
                                    </span>
                                @endif
                                <div class="card-title" style="font-size:1.15rem;line-height:1.4;margin-bottom:.5rem">{{ $post->title }}</div>
                                <div class="card-excerpt" style="-webkit-line-clamp:2">{{ Str::limit($post->excerpt, 120) }}</div>
                                <div class="card-meta" style="margin-top:auto;padding-top:1rem">
                                    <span style="display:flex;align-items:center;gap:.35rem">👤 {{ $post->user->name }}</span>
                                    <span style="color:var(--text-muted)">·</span>
                                    <span>📅 {{ $post->published_at?->format('M d, Y') }}</span>
                                    <span style="color:var(--text-muted)">·</span>
                                    <span>👁 {{ number_format($post->views) }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div style="margin-top:2.5rem;display:flex;justify-content:center">{{ $posts->links() }}</div>
            @else
                <div style="text-align:center;padding:4rem 2rem;color:var(--text-muted);background:var(--bg-card);border-radius:16px;border:1px solid var(--border-light)">
                    <div style="font-size:4rem;margin-bottom:1rem">🔍</div>
                    <h3 style="margin-bottom:.5rem;color:var(--text);font-size:1.25rem">No articles found</h3>
                    <p>Try a different search term or browse by category</p>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <aside>
            <div class="card" style="padding:1.5rem;margin-bottom:1.5rem;border-radius:16px;border:1px solid var(--border-light)">
                <h3 style="font-family:'Poppins',sans-serif;font-weight:700;color:var(--primary);margin-bottom:1.25rem;font-size:1rem">📂 Browse by Subject</h3>
                @foreach($categories as $cat)
                    <a href="{{ route('posts.index', ['category' => $cat->slug]) }}"
                       style="display:flex;align-items:center;justify-content:space-between;padding:.65rem .75rem;border-radius:10px;margin-bottom:.4rem;transition:all .2s;{{ request('category') === $cat->slug ? 'background:linear-gradient(135deg, var(--primary), var(--primary-light));color:#fff' : 'color:var(--text)' }}" onmouseover="this.style.background='var(--bg-soft)'" onmouseout="this.style.background='transparent'">
                        <span style="font-weight:500">{{ $cat->icon ?? '📌' }} {{ $cat->name }}</span>
                        <span style="background:var(--bg-soft);color:var(--text-secondary);font-size:.75rem;font-weight:600;padding:.2rem .55rem;border-radius:999px">
                            {{ $cat->published_posts_count }}
                        </span>
                    </a>
                @endforeach
            </div>

            <div class="card" style="padding:1.5rem;border-radius:16px;border:1px solid var(--border-light);background:linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);color:#fff">
                <h3 style="font-family:'Poppins',sans-serif;font-weight:700;font-size:1rem;margin-bottom:.75rem">📬 Stay Updated!</h3>
                <p style="font-size:.875rem;opacity:.85;margin-bottom:1rem">Get the latest articles delivered to your inbox</p>
                <form style="display:flex;gap:.5rem">
                    <input type="email" placeholder="Your email" style="flex:1;padding:.6rem .9rem;border:none;border-radius:8px;font-size:.875rem">
                    <button type="button" style="background:var(--accent);color:var(--primary-dark);border:none;padding:.6rem 1rem;border-radius:8px;font-weight:600;cursor:pointer">Join</button>
                </form>
            </div>
        </aside>
    </div>
</div>

@endsection