<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Post Published</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .container { background: #f9f9f9; padding: 30px; border-radius: 8px; }
        .post-title { font-size: 24px; font-weight: bold; color: #1e3a5f; margin-bottom: 10px; }
        .post-meta { font-size: 14px; color: #666; margin-bottom: 20px; }
        .post-excerpt { font-size: 16px; color: #444; margin-bottom: 20px; }
        .button { display: inline-block; padding: 12px 24px; background: #1e3a5f; color: #fff; text-decoration: none; border-radius: 6px; margin-top: 10px; }
        .footer { margin-top: 20px; font-size: 12px; color: #666; }
        .unsubscribe { margin-top: 20px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <p>Hello{{ $subscriber && $subscriber->name ? ' ' . $subscriber->name : '' }},</p>
        
        <p>A new post has been published on {{ config('app.name') }}:</p>
        
        <div class="post-title">{{ $post->title }}</div>
        
        <div class="post-meta">
            @if($post->category)
            Category: {{ $post->category->name }} &bull;
            @endif
            Published: {{ $post->published_at->format('F j, Y') }}
        </div>
        
        @if($post->excerpt)
        <div class="post-excerpt">{{ $post->excerpt }}</div>
        @endif
        
        <p>
            <a href="{{ route('posts.show', $post->slug) }}" class="button">Read Full Post</a>
        </p>
        
        <div class="footer">
            <p>Thank you for being a subscriber!</p>
            <p>{{ config('app.name') }}</p>
        </div>
        
        <div class="unsubscribe">
            <p>Want to unsubscribe? <a href="{{ route('newsletter.unsubscribe', ['email' => $subscriber?->email]) }}">Click here</a></p>
        </div>
    </div>
</body>
</html>