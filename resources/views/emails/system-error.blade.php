<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Error</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; background: #fafafa; }
        .wrapper { width: 100%; max-width: 580px; margin: 0 auto; }
        .header { background: #dc2626; padding: 20px 24px; text-align: center; }
        .header-icon { font-size: 32px; }
        .header-text { font-size: 16px; font-weight: 600; color: #fff; margin-top: 4px; }
        .content { background: #fff; padding: 24px; }
        .greeting { font-size: 15px; color: #666; margin-bottom: 20px; }
        .severity { font-size: 18px; font-weight: 600; color: #dc2626; margin-bottom: 20px; }
        .details { background: #f9fafb; border-radius: 8px; padding: 16px; margin-bottom: 20px; }
        .detail-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee; font-size: 14px; }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { color: #666; }
        .detail-value { color: #111; font-weight: 500; }
        .error-box { background: #fef2f2; border: 1px solid #dc2626; border-radius: 6px; padding: 12px; font-size: 13px; color: #991b1b; margin-bottom: 20px; font-family: monospace; }
        .warning { background: #fef3c7; border: 1px solid #fbbf24; border-radius: 6px; padding: 12px; font-size: 13px; color: #92400e; margin-bottom: 20px; }
        .footer { padding: 16px; text-align: center; font-size: 12px; color: #999; }
        .footer a { color: #2563eb; text-decoration: none; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div class="header-icon">⚠️</div>
            <div class="header-text">System Error Detected</div>
        </div>
        
        <div class="content">
            <div class="greeting">Hello Admin,</div>
            
            <div class="severity">{{ $severity }} Error</div>
            
            <div class="details">
                <div class="detail-row">
                    <span class="detail-label">Time</span>
                    <span class="detail-value">{{ $time }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">IP Address</span>
                    <span class="detail-value">{{ $ipAddress }}</span>
                </div>
                @if($userEmail)
                <div class="detail-row">
                    <span class="detail-label">User Email</span>
                    <span class="detail-value">{{ $userEmail }}</span>
                </div>
                @endif
            </div>
            
            <div class="error-box">
                <strong>Error:</strong> {{ $errorMessage }}<br>
                <strong>Location:</strong> {{ $errorLocation }}
            </div>
            
            <div class="warning">
                Please investigate this error immediately to prevent further issues.
            </div>
        </div>
        
        <div class="footer">
            <a href="{{ route('admin.system') }}">View System Status</a>
        </div>
    </div>
</body>
</html>