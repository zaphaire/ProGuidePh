<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; background: #fafafa; }
        .wrapper { width: 100%; max-width: 580px; margin: 0 auto; }
        .header { background: #1a1a2e; padding: 24px; text-align: center; }
        .logo { font-size: 18px; font-weight: 700; color: #fff; }
        .content { background: #fff; padding: 28px 24px; border-top: 3px solid #2563eb; }
        .badge { display: inline-block; background: #eff6ff; color: #2563eb; font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 4px; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px; }
        .title { font-size: 22px; font-weight: 700; color: #111; margin-bottom: 12px; line-height: 1.35; }
        .meta { font-size: 13px; color: #666; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 16px; }
        .meta span { margin-right: 12px; }
        .image { width: 100%; border-radius: 8px; margin-bottom: 20px; }
        .image img { width: 100%; height: auto; border-radius: 8px; display: block; }
        .excerpt { font-size: 15px; color: #444; margin-bottom: 20px; }
        .button { display: inline-block; background: #2563eb; color: #fff; font-weight: 500; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-size: 14px; }
        .button:hover { background: #1d4ed8; }
        .footer { background: #f5f5f5; padding: 20px; text-align: center; font-size: 12px; color: #666; }
        .footer a { color: #2563eb; text-decoration: none; }
        hr { border: none; border-top: 1px solid #eee; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div class="logo">{{ config('app.name') }}</div>
        </div>
        
        <div class="content">
            <div class="badge">New Article</div>
            
            <div class="title">{{ $post->title }}</div>
            
            <div class="meta">
                <span>📅 {{ $post->published_at->format('F j, Y') }}</span>
                @if($post->category)
                <span>{{ $post->category->icon ?? '📁' }} {{ $post->category->name }}</span>
                @endif
            </div>
            
            @if($post->featured_image)
            <div class="image">
                <img src="{{ asset('storage/'.$post->featured_image) }}" alt="{{ $post->title }}">
            </div>
            @endif
            
            @if($post->excerpt)
            <div class="excerpt">{{ $post->excerpt }}</div>
            @endif
            
            <p><a href="{{ route('posts.show', $post->slug) }}" class="button">Read Full Article</a></p>
            
            <hr>
            
            <p style="font-size:13px;color:#666">
                Thanks for reading!<br>
                <strong>{{ config('app.name') }}</strong>
            </p>
        </div>
        
        <div class="footer">
            <p>You're receiving this because you subscribed to {{ config('app.name') }}.</p>
            <p style="margin-top:8px">
                <a href="{{ route('newsletter.unsubscribe', ['email' => $subscriber?->email]) }}">Unsubscribe</a> · 
                <a href="{{ route('home') }}">Visit Website</a>
            </p>
        </div>
    </div>
</body>
</html>