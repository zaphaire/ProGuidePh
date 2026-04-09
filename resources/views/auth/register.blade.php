<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - {{ \App\Models\Setting::get('site_name', 'ProGuidePh') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: #1a2744;
            --primary-light: #243868;
            --primary-dark: #0d1630;
            --accent: #e8a020;
            --accent-light: #f5c060;
            --red: #CE1126;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 50%, var(--primary-light) 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-container { display: flex; width: 100%; max-width: 900px; background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 25px 50px rgba(0,0,0,0.25); }
        .login-left { flex: 1; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); padding: 3rem; display: flex; flex-direction: column; justify-content: center; align-items: center; position: relative; overflow: hidden; }
        .login-left::before { content: ''; position: absolute; inset: 0; background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); }
        .login-left-content { position: relative; z-index: 1; text-align: center; color: #fff; }
        .login-left img { width: 120px; height: auto; margin-bottom: 1.5rem; }
        .login-left h1 { font-family: 'Poppins', sans-serif; font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem; }
        .login-left h1 span:first-child { color: #fff; }
        .login-left h1 span:last-child { color: var(--accent); }
        .login-left p { font-size: 1rem; opacity: 0.9; max-width: 280px; }
        .login-right { flex: 1; padding: 3rem; display: flex; flex-direction: column; justify-content: center; }
        .login-right h2 { font-family: 'Poppins', sans-serif; font-size: 1.75rem; font-weight: 700; color: var(--primary); margin-bottom: 0.5rem; }
        .login-right .subtitle { color: #6b7280; margin-bottom: 2rem; }
        .form-group { margin-bottom: 1.25rem; }
        .form-label { display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem; }
        .form-input { width: 100%; padding: 0.75rem 1rem; border: 1px solid #e5e7eb; border-radius: 10px; font-size: 1rem; transition: border-color 0.2s, box-shadow 0.2s; }
        .form-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(26,39,68,0.1); }
        .btn-login { width: 100%; padding: 0.875rem; background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: #fff; border: none; border-radius: 10px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(26,39,68,0.3); }
        .login-link { display: block; text-align: center; color: var(--primary); font-size: 0.875rem; margin-top: 1.5rem; text-decoration: none; }
        .login-link:hover { text-decoration: underline; }
        .error-message { color: var(--red); font-size: 0.875rem; margin-top: 0.5rem; }
        .terms { font-size: 0.8rem; color: #6b7280; margin-top: 1rem; text-align: center; }
        .terms a { color: var(--primary); }
        @media(max-width: 768px) {
            .login-container { flex-direction: column; max-width: 400px; margin: 1rem; }
            .login-left { padding: 2rem; }
            .login-right { padding: 2rem; }
            .login-left img { width: 80px; }
            .login-left h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-left">
            <div class="login-left-content">
                <img src="{{ asset('images/logo.svg') }}" alt="ProGuidePh">
                <h1><span>Pro</span><span>GuidePh</span></h1>
                <p>Join our community of Filipino tip seekers and knowledge sharers!</p>
            </div>
        </div>
        <div class="login-right">
            <h2>Create Account</h2>
            <p class="subtitle">Join thousands of Filipinos sharing practical knowledge</p>

            @if($errors->any())
                <div style="background: #fee2e2; color: #991b1b; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1rem; font-size: 0.875rem;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-input" value="{{ old('name') }}" required autofocus placeholder="Juan dela Cruz">
                    @error('name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-input" value="{{ old('email') }}" required placeholder="you@example.com">
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-input" required placeholder="•••••••• (min 8 characters)">
                    @error('password')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-input" required placeholder="••••••••">
                    @error('password_confirmation')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="btn-login">Create Account</button>
                <p class="terms">By registering, you agree to our <a href="{{ route('terms') }}">Terms of Service</a> and <a href="{{ route('privacy-policy') }}">Privacy Policy</a></p>
            </form>

            <a href="{{ route('login') }}" class="login-link">Already have an account? Sign in</a>
        </div>
    </div>
</body>
</html>