<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unsubscribed</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; background: #f9fafb; }
        .wrapper { width: 100%; max-width: 500px; margin: 0 auto; }
        .header { background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%); padding: 32px 24px; text-align: center; }
        .logo { font-size: 24px; font-weight: 800; color: #fff; }
        .content { background: #fff; padding: 32px 24px; }
        .title { font-size: 22px; font-weight: 700; color: #111; margin-bottom: 16px; }
        .text { font-size: 16px; color: #444; margin-bottom: 16px; line-height: 1.6; }
        .highlight { background: #f3f4f6; padding: 16px; border-radius: 8px; border-left: 4px solid #6b7280; margin: 20px 0; }
        .footer { background: #f3f4f6; padding: 24px; text-align: center; font-size: 14px; color: #666; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div class="logo">{{ config('app.name') }}</div>
        </div>
        
        <div class="content">
            <div class="title">Goodbye! 👋</div>
            
            <div class="text">
                You have been successfully unsubscribed from our newsletter.
            </div>
            
            <div class="highlight">
                Your email <strong>{{ $email }}</strong> has been removed from our subscriber list.
            </div>
            
            <div class="text">
                We're sorry to see you go! If you change your mind, you can always subscribe again anytime.
            </div>
            
            <p style="font-size:14px;color:#666;margin-top:20px">
                Best regards,<br>
                <strong>{{ config('app.name') }} Team</strong>
            </p>
        </div>
        
        <div class="footer">
            <p>You're receiving this because you unsubscribed from {{ config('app.name') }}.</p>
        </div>
    </div>
</body>
</html>