@extends('layouts.app')

@section('title', $category->name . ' Articles')

@section('content')

<div style="background:linear-gradient(135deg,var(--primary),#2d5490);color:#fff;padding:3rem 0 2.5rem">
    <div class="container">
        <div style="font-size:3rem;margin-bottom:.75rem">{{ $category->icon ?? '💡' }}</div>
        <h1 style="font-family:'Merriweather',serif;font-size:2rem;margin-bottom:.5rem">{{ $category->name }}</h1>
        @if($category->description)
            <p style="color:rgba(255,255,255,.75);max-width:600px">{{ $category->description }}</p>
        @endif
        <div style="margin-top:1rem;font-size:.875rem;color:rgba(255,255,255,.5)">{{ $posts->total() }} articles found</div>
    </div>
</div>

<div class="container section">
    <div class="sidebar-layout-grid">
        <div>
            @if($posts->isNotEmpty())
                <div class="posts-grid">
                    @foreach($posts as $post)
                        <a href="{{ route('posts.show', $post->slug) }}" class="card">
                            @if($post->featured_image_url)
                                <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="card-img">
                            @else
                                <div class="card-img-placeholder" style="background:linear-gradient(135deg,{{ $category->color }},{{ $category->color }}aa)">{{ $category->icon ?? '💡' }}</div>
                            @endif
                            <div class="card-body">
                                <div class="card-title">{{ $post->title }}</div>
                                <div class="card-excerpt">{{ $post->excerpt }}</div>
                                <div class="card-meta">
                                    <span>{{ $post->user->name }}</span>
                                    <span>·</span>
                                    <span>{{ $post->published_at?->format('M d, Y') }}</span>
                                    <span>·</span>
                                    <span>{{ number_format($post->views) }} views</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div style="margin-top:2rem">{{ $posts->links() }}</div>
            @else
                <div style="text-align:center;padding:4rem;color:var(--text-muted)">
                    <div style="font-size:3rem;margin-bottom:1rem">📭</div>
                    <h3>No articles in this category yet</h3>
                </div>
            @endif
        </div>
        <aside>
            <div class="card" style="padding:1.4rem">
                <h3 style="font-weight:700;color:var(--primary);margin-bottom:1rem;font-size:.95rem">All Categories</h3>
                @foreach($categories as $cat)
                    <a href="{{ route('categories.show', $cat->slug) }}" style="display:flex;align-items:center;justify-content:space-between;padding:.55rem .6rem;border-radius:8px;margin-bottom:.3rem;background:{{ $cat->slug === $category->slug ? 'rgba(44,76,59,.08)' : 'transparent' }};font-weight:{{ $cat->slug === $category->slug ? '700' : '400' }}">
                        <span>{{ $cat->icon ?? '📌' }} {{ $cat->name }}</span>
                        <span style="background:{{ $cat->color }}22;color:{{ $cat->color }};font-size:.75rem;font-weight:600;padding:.15rem .5rem;border-radius:999px">{{ $cat->published_posts_count }}</span>
                    </a>
                @endforeach
            </div>
        </aside>
    </div>
</div>

@endsection
