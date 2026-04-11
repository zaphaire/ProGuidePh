<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Post Published</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #1f2937; background: #f3f4f6; }
        .email-wrapper { width: 100%; max-width: 600px; margin: 0 auto; }
        .email-header { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); padding: 32px 24px; text-align: center; }
        .email-logo { font-size: 24px; font-weight: 800; color: #fff; letter-spacing: -0.5px; }
        .email-tagline { color: #c7d2fe; font-size: 14px; margin-top: 4px; }
        .email-body { background: #fff; padding: 32px 24px; }
        .greeting { font-size: 16px; color: #6b7280; margin-bottom: 20px; }
        .notification-badge { display: inline-block; background: #eef2ff; color: #4f46e5; font-size: 12px; font-weight: 600; padding: 4px 12px; border-radius: 9999px; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px; }
        .post-title { font-size: 24px; font-weight: 700; color: #111827; margin-bottom: 12px; line-height: 1.3; }
        .post-meta { display: flex; flex-wrap: wrap; gap: 16px; font-size: 14px; color: #6b7280; margin-bottom: 20px; }
        .post-meta-item { display: flex; align-items: center; gap: 6px; }
        .post-category { background: #f3f4f6; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 500; }
        .post-image { width: 100%; border-radius: 12px; margin-bottom: 20px; overflow: hidden; }
        .post-image img { width: 100%; height: auto; display: block; }
        .post-excerpt { font-size: 16px; color: #4b5563; margin-bottom: 24px; line-height: 1.7; }
        .cta-button { display: inline-block; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: #fff; font-weight: 600; padding: 14px 28px; border-radius: 8px; text-decoration: none; transition: opacity 0.2s; }
        .cta-button:hover { opacity: 0.9; }
        .email-footer { background: #f9fafb; padding: 24px; text-align: center; }
        .footer-text { font-size: 14px; color: #6b7280; margin-bottom: 8px; }
        .footer-links { display: flex; justify-content: center; gap: 16px; font-size: 13px; }
        .footer-links a { color: #4f46e5; text-decoration: none; }
        .footer-links a:hover { text-decoration: underline; }
        .social-links { display: flex; justify-content: center; gap: 12px; margin-top: 16px; }
        .social-icon { width: 32px; height: 32px; background: #e5e7eb; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #6b7280; text-decoration: none; }
        .unsubscribe-notice { font-size: 12px; color: #9ca3af; margin-top: 16px; }
        .unsubscribe-notice a { color: #6b7280; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-header">
            <div class="email-logo">{{ config('app.name') }}</div>
            <div class="email-tagline">Practical Tips & Guides for Filipinos</div>
        </div>
        
        <div class="email-body">
            <div class="greeting">
                @if($subscriber && $subscriber->name)
                    Hello {{ $subscriber->name }},
                @else
                    Hello there,
                @endif
            </div>
            
            <div class="notification-badge">📢 New Article</div>
            
            <div class="post-title">{{ $post->title }}</div>
            
            <div class="post-meta">
                <span class="post-meta-item">
                    <span>📅</span> {{ $post->published_at->format('F j, Y') }}
                </span>
                @if($post->category)
                <span class="post-category">{{ $post->category->icon ?? '📁' }} {{ $post->category->name }}</span>
                @endif
                <span class="post-meta-item">
                    <span>👁</span> {{ number_format($post->views) }} views
                </span>
            </div>
            
            @if($post->featured_image)
            <div class="post-image">
                <img src="{{ asset('storage/'.$post->featured_image) }}" alt="{{ $post->title }}">
            </div>
            @endif
            
            @if($post->excerpt)
            <div class="post-excerpt">{{ $post->excerpt }}</div>
            @endif
            
            <p>
                <a href="{{ route('posts.show', $post->slug) }}" class="cta-button">Read Full Article →</a>
            </p>
        </div>
        
        <div class="email-footer">
            <div class="footer-text">
                Thanks for reading! 🙏
            </div>
            <div class="footer-links">
                <a href="{{ route('home') }}">Home</a>
                <span style="color: #d1d5db;">|</span>
                <a href="{{ route('posts.index') }}">All Articles</a>
                <span style="color: #d1d5db;">|</span>
                <a href="{{ route('pages.show', 'about') }}">About Us</a>
            </div>
            <div class="unsubscribe-notice">
                Received this email because you subscribed to our newsletter. 
                <a href="{{ route('newsletter.unsubscribe', ['email' => $subscriber?->email]) }}">Unsubscribe</a>
            </div>
        </div>
    </div>
</body>
</html>