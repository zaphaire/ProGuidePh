<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Verification Code</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .container { background: #f9f9f9; padding: 30px; border-radius: 8px; }
        .otp-code { font-size: 32px; font-weight: bold; color: #1e3a5f; letter-spacing: 8px; text-align: center; padding: 20px; background: #fff; border-radius: 8px; margin: 20px 0; }
        .footer { margin-top: 20px; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hello {{ $userName }},</h2>
        
        <p>Your login verification code is:</p>
        
        <div class="otp-code">{{ $otpCode }}</div>
        
        <p>This code will expire in <strong>10 minutes</strong>.</p>
        
        <p>If you didn't attempt to log in, please ignore this email or change your password immediately.</p>
        
        <div class="footer">
            <p>{{ config('app.name') }} - Security Team</p>
        </div>
    </div>
</body>
</html>