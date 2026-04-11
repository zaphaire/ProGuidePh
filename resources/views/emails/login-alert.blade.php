<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Alert</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; background: #fafafa; }
        .wrapper { width: 100%; max-width: 580px; margin: 0 auto; }
        .header { @if($success) background: #059669; @else background: #dc2626; @endif padding: 20px 24px; text-align: center; }
        .header-icon { font-size: 32px; }
        .header-text { font-size: 16px; font-weight: 600; color: #fff; margin-top: 4px; }
        .content { background: #fff; padding: 24px; }
        .greeting { font-size: 15px; color: #666; margin-bottom: 20px; }
        .status { font-size: 18px; font-weight: 600; color: #111; margin-bottom: 20px; }
        .status.success { color: #059669; }
        .status.failed { color: #dc2626; }
        .details { background: #f9fafb; border-radius: 8px; padding: 16px; margin-bottom: 20px; }
        .detail-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee; font-size: 14px; }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { color: #666; }
        .detail-value { color: #111; font-weight: 500; }
        .warning { background: #fef3c7; border: 1px solid #fbbf24; border-radius: 6px; padding: 12px; font-size: 13px; color: #92400e; margin-bottom: 20px; }
        .button { display: inline-block; background: #2563eb; color: #fff; font-weight: 500; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-size: 14px; }
        .footer { padding: 16px; text-align: center; font-size: 12px; color: #999; }
        .footer a { color: #2563eb; text-decoration: none; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div class="header-icon">@if($success)✅@else⚠️@endif</div>
            <div class="header-text">@if($success)Successful Login @else Failed Login @endif</div>
        </div>
        
        <div class="content">
            <div class="greeting">Hello {{ $user->name }},</div>
            
            <div class="status {{ $success ? 'success' : 'failed' }}">
                @if($success)
                    You successfully logged into your account.
                @else
                    Someone tried to log into your account.
                @endif
            </div>
            
            <div class="details">
                <div class="detail-row">
                    <span class="detail-label">Time</span>
                    <span class="detail-value">{{ $time }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">IP Address</span>
                    <span class="detail-value">{{ $ipAddress }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Device</span>
                    <span class="detail-value">{{ $userAgent }}</span>
                </div>
            </div>
            
            @if(!$success)
            <div class="warning">
                <strong>Warning:</strong> If this wasn't you, please reset your password immediately or contact support.
            </div>
            @endif
        </div>
        
        <div class="footer">
            <p style="margin-bottom:8px">You're receiving this because you have login notifications enabled.</p>
            <a href="{{ route('home') }}">{{ config('app.name') }}</a>
        </div>
    </div>
</body>
</html>