<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Connection Error - ProGuidePh</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #1e3a5f, #2d5490); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem; }
        .error-container { background: #fff; border-radius: 20px; padding: 3rem; text-align: center; max-width: 500px; box-shadow: 0 25px 50px rgba(0,0,0,0.25); }
        .error-icon { font-size: 4rem; margin-bottom: 1rem; }
        h1 { color: #1e3a5f; font-size: 1.75rem; margin-bottom: 1rem; }
        p { color: #64748b; line-height: 1.6; margin-bottom: 1.5rem; }
        .btn { display: inline-block; background: linear-gradient(135deg, #f59e0b, #fbbf24); color: #1e3a5f; padding: 0.75rem 2rem; border-radius: 50px; font-weight: 600; text-decoration: none; transition: transform 0.2s; }
        .btn:hover { transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">⚠️</div>
        <h1>Database Connection Error</h1>
        <p>We're having trouble connecting to our database. This could be a temporary issue. Please try again in a few moments.</p>
        <a href="{{ url('/') }}" class="btn">Go to Homepage</a>
    </div>
</body>
</html>