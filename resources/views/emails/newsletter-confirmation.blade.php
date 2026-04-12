<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome!</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; background: #f9fafb; }
        .wrapper { width: 100%; max-width: 500px; margin: 0 auto; }
        .header { background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); padding: 32px 24px; text-align: center; }
        .logo { font-size: 24px; font-weight: 800; color: #fff; }
        .content { background: #fff; padding: 32px 24px; }
        .title { font-size: 22px; font-weight: 700; color: #111; margin-bottom: 16px; }
        .text { font-size: 16px; color: #444; margin-bottom: 16px; line-height: 1.6; }
        .highlight { background: #f0fdf4; padding: 16px; border-radius: 8px; border-left: 4px solid #16a34a; margin: 20px 0; }
        .button { display: inline-block; background: #16a34a; color: #fff; font-weight: 600; padding: 12px 24px; border-radius: 8px; text-decoration: none; margin: 16px 0; }
        .footer { background: #f3f4f6; padding: 24px; text-align: center; font-size: 14px; color: #666; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div class="logo">{{ config('app.name') }}</div>
        </div>
        
        <div class="content">
            <div class="title">Welcome! 🎉</div>
            
            <div class="text">
                Thank you for subscribing to our newsletter!
            </div>
            
            <div class="highlight">
                <strong>What to expect:</strong><br>
                📧 Latest blog posts and articles<br>
                📚 Helpful guides and tutorials<br>
                🔔 Community updates
            </div>
            
            <div class="text">
                We'll send you the latest content directly to your inbox. No spam, ever - you can unsubscribe anytime.
            </div>
            
            <p style="font-size:14px;color:#666;margin-top:20px">
                Best regards,<br>
                <strong>{{ config('app.name') }} Team</strong>
            </p>
        </div>
        
        <div class="footer">
            <p>You're receiving this because you subscribed to {{ config('app.name') }}.</p>
            <p style="margin-top:8px">
                <a href="{{ route('newsletter.unsubscribe.get', ['email' => $subscriber->email]) }}" style="color:#666;text-decoration:underline">Unsubscribe</a>
            </p>
        </div>
    </div>
</body>
</html>