<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unsubscribed - {{ config('app.name') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; background: #f9fafb; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .container { width: 100%; max-width: 500px; margin: 20px; text-align: center; }
        .card { background: #fff; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.08); padding: 48px 32px; }
        .icon { width: 80px; height: 80px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; font-size: 40px; }
        h1 { font-size: 28px; font-weight: 700; color: #111; margin-bottom: 16px; }
        p { font-size: 16px; color: #666; margin-bottom: 24px; line-height: 1.6; }
        .btn { display: inline-block; background: #1a2744; color: #fff; padding: 12px 32px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s; }
        .btn:hover { background: #243868; transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="icon">✓</div>
            <h1>Successfully Unsubscribed</h1>
            <p>You have been removed from our newsletter. A confirmation email has been sent to your inbox.</p>
            <a href="{{ route('home') }}" class="btn">Back to Home</a>
        </div>
    </div>
</body>
</html>