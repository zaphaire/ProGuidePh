<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Already Subscribed</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; background: #f9fafb; }
        .wrapper { width: 100%; max-width: 500px; margin: 0 auto; }
        .header { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); padding: 32px 24px; text-align: center; }
        .logo { font-size: 24px; font-weight: 800; color: #fff; }
        .content { background: #fff; padding: 32px 24px; }
        .title { font-size: 22px; font-weight: 700; color: #111; margin-bottom: 16px; }
        .text { font-size: 16px; color: #444; margin-bottom: 16px; line-height: 1.6; }
        .highlight { background: #fef3c7; padding: 16px; border-radius: 8px; border-left: 4px solid #f59e0b; margin: 20px 0; }
        .footer { background: #f3f4f6; padding: 24px; text-align: center; font-size: 14px; color: #666; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div class="logo">{{ config('app.name') }}</div>
        </div>
        
        <div class="content">
            <div class="title">You're Already Subscribed! 📬</div>
            
            <div class="text">
                It looks like you're already on our newsletter list.
            </div>
            
            <div class="highlight">
                The email <strong>{{ $email }}</strong> is already subscribed to {{ config('app.name') }}.
            </div>
            
            <div class="text">
                No need to subscribe again! You'll continue receiving our latest updates. If you didn't mean to subscribe, you can unsubscribe anytime using the link in our emails.
            </div>
            
            <p style="font-size:14px;color:#666;margin-top:20px">
                Best regards,<br>
                <strong>{{ config('app.name') }} Team</strong>
            </p>
        </div>
        
        <div class="footer">
            <p>You're receiving this because you're already subscribed to {{ config('app.name') }}.</p>
            <p style="margin-top:8px">
                <a href="{{ route('newsletter.unsubscribe.get', ['email' => $email]) }}" style="color:#666;text-decoration:underline">Unsubscribe</a>
            </p>
        </div>
    </div>
</body>
</html>