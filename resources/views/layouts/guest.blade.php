<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Login - {{ \App\Models\Setting::get('site_name', 'ProGuidePh') }}</title>
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
            .login-left img { width: 120px; height: auto; margin: 0 auto 1.5rem auto; display: block; }
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
            .form-checkbox { display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; }
            .form-checkbox input { width: 18px; height: 18px; border-radius: 4px; border: 1px solid #d1d5db; }
            .form-checkbox label { font-size: 0.875rem; color: #6b7280; user-select: none; cursor: pointer; }
            .btn-login { width: 100%; padding: 0.875rem; background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: #fff; border: none; border-radius: 10px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; }
            .btn-login:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(26,39,68,0.3); }
            .forgot-link { display: block; text-align: center; color: var(--primary); font-size: 0.875rem; margin-top: 1.5rem; text-decoration: none; }
            .forgot-link:hover { text-decoration: underline; }
            .error-message { color: var(--red); font-size: 0.875rem; margin-top: 0.5rem; }
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
        @php 
$siteLogo = \App\Models\Setting::get('site_logo');
$logoSrc = $siteLogo && (str_starts_with($siteLogo, 'http') || str_starts_with($siteLogo, '//')) ? $siteLogo : ($siteLogo ? asset('storage/' . $siteLogo) : null);
@endphp
        <div class="login-container">
            <div class="login-left">
                <div class="login-left-content">
                    @if($logoSrc)
                        <img src="{{ $logoSrc }}" alt="ProGuidePh" style="max-width: 150px; height: auto;">
                    @else
                        <img src="{{ asset('images/icon.svg') }}" alt="ProGuidePh">
                    @endif
                    <h1><span>Pro</span><span>GuidePh</span></h1>
                    <p>Your digital tambayan for practical tips and helpful guides written by Filipinos, for Filipinos.</p>
                    
                    <div style="margin-top: 2.5rem; display: flex; gap: 1rem; justify-content: center;">
                        @php 
                            $facebook = \App\Models\Setting::get('social_facebook', 'https://facebook.com');
                            $twitter = \App\Models\Setting::get('social_twitter', 'https://twitter.com');
                            $tiktok = \App\Models\Setting::get('social_tiktok', 'https://tiktok.com');
                            $linkedin = \App\Models\Setting::get('social_linkedin', 'https://linkedin.com');
                            $instagram = \App\Models\Setting::get('social_instagram', 'https://instagram.com');
                        @endphp
                        <a href="{{ $facebook }}" target="_blank" rel="noopener noreferrer" style="width: 44px; height: 44px; border-radius: 50%; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.background='var(--primary-dark)'; this.style.transform='translateY(-3px)';" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.transform='translateY(0)';">
                            <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="{{ $twitter }}" target="_blank" rel="noopener noreferrer" style="width: 44px; height: 44px; border-radius: 50%; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.background='var(--primary-dark)'; this.style.transform='translateY(-3px)';" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.transform='translateY(0)';">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        <a href="{{ $tiktok }}" target="_blank" rel="noopener noreferrer" style="width: 44px; height: 44px; border-radius: 50%; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.background='var(--primary-dark)'; this.style.transform='translateY(-3px)';" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.transform='translateY(0)';">
                            <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                        </a>
                        <a href="{{ $linkedin }}" target="_blank" rel="noopener noreferrer" style="width: 44px; height: 44px; border-radius: 50%; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.background='var(--primary-dark)'; this.style.transform='translateY(-3px)';" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.transform='translateY(0)';">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                        <a href="{{ $instagram }}" target="_blank" rel="noopener noreferrer" style="width: 44px; height: 44px; border-radius: 50%; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.background='var(--primary-dark)'; this.style.transform='translateY(-3px)';" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.transform='translateY(0)';">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="login-right">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>