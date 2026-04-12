<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; background: #f9fafb; }
        .wrapper { width: 100%; max-width: 600px; margin: 0 auto; }
        .header { background: linear-gradient(135deg, #1a2744 0%, #243868 100%); padding: 24px; text-align: center; }
        .logo { font-size: 20px; font-weight: 800; color: #fff; }
        .content { background: #fff; padding: 32px 24px; }
        .label { font-size: 12px; font-weight: 600; color: #666; text-transform: uppercase; margin-bottom: 4px; }
        .value { font-size: 16px; color: #111; margin-bottom: 16px; }
        .divider { height: 1px; background: #e5e7eb; margin: 16px 0; }
        .footer { background: #f3f4f6; padding: 24px; text-align: center; font-size: 14px; color: #666; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div class="logo">{{ config('app.name') }} - New Contact Message</div>
        </div>
        
        <div class="content">
            <div class="label">From</div>
            <div class="value">{{ $data['name'] }} ({{ $data['email'] }})</div>
            
            <div class="divider"></div>
            
            <div class="label">Subject</div>
            <div class="value">{{ $data['subject'] }}</div>
            
            <div class="divider"></div>
            
            <div class="label">Message</div>
            <div class="value" style="white-space: pre-wrap;">{{ $data['message'] }}</div>
        </div>
        
        <div class="footer">
            <p>This message was sent from the {{ config('app.name') }} contact form.</p>
        </div>
    </div>
</body>
</html>