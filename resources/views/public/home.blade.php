@extends('layouts.app')

@section('title', 'Home')

@section('content')

{{-- Hero Section --}}
<section class="hero">
    <div class="hero-bg-shape float-anim"></div>
    <div class="hero-bg-shape2 float-anim" style="animation-delay: -2s"></div>
    <div class="hero-bg-dots float-anim" style="animation-delay: -4s"></div>
    <div class="hero-content">
        <div class="hero-badge animate-fade">
            <span>🎯</span> {{ \App\Models\Setting::get('site_tagline', 'Practical Tips & Guides for Filipinos') }}
        </div>
        <h1 class="animate-slide">Know More, <span>Live Better</span></h1>
        <p class="animate-slide delay-1">Discover practical tips, helpful guides, and useful information written by Filipinos, for Filipinos. Your digital tambayan for everyday wisdom.</p>
        <div class="hero-actions animate-slide delay-2">
            <a href="{{ route('posts.index') }}" class="btn-primary"><span>📖</span> Explore Articles</a>
            <a href="{{ route('pages.show', 'about') }}" class="btn-secondary">About Us</a>
        </div>
        <div class="hero-stats animate-slide delay-3">
                <div class="stat-item">
                    <div class="num">{{ \App\Models\Post::where('status','published')->count() }}+</div>
                    <div class="label">Articles</div>
                </div>
                <div class="stat-item">
                    <div class="num">{{ \App\Models\Category::count() }}</div>
                    <div class="label">Categories</div>
                </div>
                <div class="stat-item">
                    <div class="num">Free</div>
                    <div class="label">Always</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Categories --}}
<section class="section" style="background: linear-gradient(180deg, #f8fafc 0%, rgba(0,56,168,0.03) 100%);">
    <div class="container">
        <div class="section-header reveal">
            <span class="section-badge">Explore</span>
            <h2 class="section-title">Browse by Category</h2>
            <p class="section-subtitle">Find practical tips and helpful guides on topics that matter to you.</p>
        </div>

        <div class="categories-grid">
            @foreach($categories as $cat)
                <a href="{{ route('categories.show', $cat->slug) }}" class="cat-card reveal">
                    <div class="cat-icon">{{ $cat->icon ?? '💡' }}</div>
                    <div class="cat-name" style="color:{{ $cat->color }}">{{ $cat->name }}</div>
                    <div class="cat-count">{{ $cat->published_posts_count }} articles</div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Featured Posts --}}
@if($featuredPosts->isNotEmpty())
<section class="section">
    <div class="container">
        <div class="section-header reveal">
            <span class="section-badge">Featured</span>
            <h2 class="section-title">Featured Articles</h2>
            <p class="section-subtitle">Handpicked tips and guides that our readers find most helpful.</p>
        </div>
        <div class="posts-grid">
            @foreach($featuredPosts as $post)
                <a href="{{ route('posts.show', $post->slug) }}" class="card reveal">
                    @if($post->featured_image)
                        <img src="{{ asset('storage/'.$post->featured_image) }}" alt="{{ $post->title }}" class="card-img">
                    @else
                        <div class="card-img-placeholder">{{ $post->category->icon ?? '💡' }}</div>
                    @endif
                    <div class="card-body">
                        @if($post->category)
                            <span class="card-category" style="background:{{ $post->category->color }}22; color:{{ $post->category->color }}">
                                {{ $post->category->icon ?? '📌' }} {{ $post->category->name }}
                            </span>
                        @endif
                        <div class="card-title">{{ $post->title }}</div>
                        <div class="card-excerpt">{{ $post->excerpt }}</div>
                        <div class="card-meta">
                            <span>{{ $post->user->name }}</span>
                            <span>·</span>
                            <span>{{ $post->published_at?->format('M d, Y') }}</span>
                            <span>·</span>
                            <span>👁 {{ number_format($post->views) }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Recent Posts --}}
<section class="section" style="background:#fff;">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">🕒 Latest</div>
            <h2 class="section-title">Recent Articles</h2>
        </div>
        @if($recentPosts->isNotEmpty())
            <div class="posts-grid">
                @foreach($recentPosts as $post)
                    <a href="{{ route('posts.show', $post->slug) }}" class="card">
                        @if($post->featured_image)
                            <img src="{{ asset('storage/'.$post->featured_image) }}" alt="{{ $post->title }}" class="card-img">
                        @else
                            <div class="card-img-placeholder">{{ $post->category?->icon ?? '📖' }}</div>
                        @endif
                        <div class="card-body">
                            @if($post->category)
                                <span class="card-category" style="background:{{ $post->category->color }}22; color:{{ $post->category->color }}">
                                    {{ $post->category->name }}
                                </span>
                            @endif
                            <div class="card-title">{{ $post->title }}</div>
                            <div class="card-excerpt">{{ $post->excerpt }}</div>
                            <div class="card-meta">
                                <span>{{ $post->user->name }}</span>
                                <span>·</span>
                                <span>{{ $post->published_at?->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div style="text-align:center; margin-top:2.5rem">
                <a href="{{ route('posts.index') }}" class="btn-primary" style="display:inline-flex;">View All Articles →</a>
            </div>
        @else
            <p style="text-align:center; color:#6b7280;">No articles published yet. Check back soon!</p>
        @endif
    </div>
</section>

{{-- Newsletter Section --}}
<section class="section" style="background: linear-gradient(180deg, rgba(0,56,168,0.03) 0%, #f8fafc 100%);">
    <div class="container">
        <div style="max-width: 600px; margin: 0 auto;">
            <x-newsletter-form />
        </div>
    </div>
</section>

@endsection
