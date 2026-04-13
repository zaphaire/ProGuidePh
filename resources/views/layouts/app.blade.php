<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @php
        $siteName = \App\Models\Setting::get('site_name', 'ProGuidePh');
        $siteTagline = \App\Models\Setting::get('site_tagline', '');
        $metaDesc = \App\Models\Setting::get('meta_description', 'ProGuidePh — your digital tambayan for practical tips and guides in the Philippines.');
        $metaKeywords = \App\Models\Setting::get('meta_keywords', 'tips, guides, filipino, philippines, tambayan, how-to');
        $ogImage = \App\Models\Setting::get('og_image', '');
        $pageTitle = trim(strip_tags(trim($__env->yieldContent('title'))));
        $pageDesc = trim(strip_tags(trim($__env->yieldContent('meta_description'))));
    @endphp
    <title>{{ $pageTitle ? $pageTitle . ' — ' . $siteName : $siteName . ($siteTagline ? ' | ' . $siteTagline : '') }}</title>
    <meta name="description" content="{{ $pageDesc ?: $metaDesc }}">
    <meta name="keywords" content="{{ trim(strip_tags(trim($__env->yieldContent('meta_keywords', $metaKeywords)))) }}">
    <meta name="author" content="{{ $siteName }}">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="{{ $pageTitle ?: $siteName }}">
    <meta property="og:description" content="{{ $pageDesc ?: $metaDesc }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:image" content="{{ $ogImage ?: (trim(strip_tags(trim($__env->yieldContent('og_image'))) ?: asset('images/og-default.png'))) }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle ?: $siteName }}">
    <meta name="twitter:description" content="{{ $pageDesc ?: $metaDesc }}">
    <meta name="twitter:image" content="{{ $ogImage ?: (trim(strip_tags(trim($__env->yieldContent('og_image'))) ?: asset('images/og-default.png'))) }}">
    <link rel="canonical" href="{{ url()->current() }}">
    @php
        $faviconLogo = \App\Models\Setting::get('site_logo');
        $faviconUrl = $faviconLogo && (str_starts_with($faviconLogo, 'http') || str_starts_with($faviconLogo, '//')) 
            ? $faviconLogo 
            : ($faviconLogo ? asset('storage/' . $faviconLogo) : asset('favicon.svg'));
    @endphp
    <link rel="icon" href="{{ $faviconUrl }}">
    <link rel="apple-touch-icon" href="{{ $faviconUrl }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: #1a2744;
            --primary-light: #243868;
            --primary-dark: #0d1630;
            --primary-glow: rgba(26, 39, 68, 0.25);
            --accent: #e8a020;
            --accent-light: #f5c060;
            --accent-glow: rgba(232, 160, 32, 0.4);
            --red: #CE1126;
            
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            
            --bg: #f8f9fc;
            --bg-white: #ffffff;
            --bg-dark: #0d1630;
            --bg-card: #ffffff;
            --bg-soft: #f0f2f8;
            
            --text: #1a2028;
            --text-secondary: #4a5568;
            --text-muted: #8896ab;
            --text-light: #c4cdd8;
            
            --border: #e0e6f0;
            --border-light: #f0f2f8;
            
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -2px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -4px rgba(0,0,0,0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1);
            --shadow-card: 0 4px 24px rgba(26, 39, 68, 0.08);
            --shadow-card-hover: 0 20px 40px rgba(26, 39, 68, 0.14);
            --shadow-glow: 0 0 30px rgba(232, 160, 32, 0.25);
            --shadow-primary: 0 4px 14px rgba(26, 39, 68, 0.35);
            
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 16px;
            --radius-xl: 24px;
            --radius-full: 9999px;
            
            --transition-fast: all 0.15s ease;
            --transition-base: all 0.25s ease;
            --transition-slow: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            --transition-bounce: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { overflow-x: hidden; width: 100%; max-width: 100%; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); line-height: 1.6; overflow-x: hidden; width: 100%; max-width: 100%; position: relative; }
        /* Override Tailwind container breakpoints to prevent white right-side gap on mobile */
        .container { width: 100% !important; max-width: 1200px !important; margin-left: auto !important; margin-right: auto !important; padding-left: 1.5rem !important; padding-right: 1.5rem !important; box-sizing: border-box !important; }
        a { text-decoration: none; color: inherit; transition: var(--transition-base); }
        img { max-width: 100%; height: auto; }

        
        .gradient-text {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 50%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .text-gradient-accent {
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Animation Library */
        @keyframes revealUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes revealLeft { from { opacity: 0; transform: translateX(-30px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes revealRight { from { opacity: 0; transform: translateX(30px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes float { 0%, 100% { transform: translateY(0) rotate(0); } 50% { transform: translateY(-15px) rotate(2deg); } }
        @keyframes floatSlow { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        @keyframes pulseGlow { 0%, 100% { box-shadow: 0 0 20px rgba(245, 158, 11, 0.1); } 50% { box-shadow: 0 0 40px rgba(245, 158, 11, 0.3); } }
        @keyframes slideDown { from { transform: translateY(-100%); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        @keyframes softPulse { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.9; transform: scale(0.98); } }
        @keyframes bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-5px); } }
        @keyframes sparkle { 0%, 100% { opacity: 0; transform: scale(0); } 50% { opacity: 1; transform: scale(1); } }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes gradientFlow { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
        @keyframes borderGlow { 0%, 100% { border-color: var(--border); } 50% { border-color: var(--accent); } }
        @keyframes iconBounce { 0%, 100% { transform: translateY(0); } 25% { transform: translateY(-4px); } 75% { transform: translateY(-2px); } }

        .reveal { opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease-out, transform 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal.active { opacity: 1; transform: translateY(0); }
        .reveal-left { opacity: 0; transform: translateX(-20px); transition: opacity 0.6s ease-out, transform 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal-left.active { opacity: 1; transform: translateX(0); }
        .reveal-right { opacity: 0; transform: translateX(20px); transition: opacity 0.6s ease-out, transform 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal-right.active { opacity: 1; transform: translateX(0); }
        .reveal-scale { opacity: 0; transform: scale(0.9); transition: opacity 0.6s ease-out, transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1); }
        .reveal-scale.active { opacity: 1; transform: scale(1); }

        .delay-1 { transition-delay: 0.1s; }
        .delay-2 { transition-delay: 0.2s; }
        .delay-3 { transition-delay: 0.3s; }
        .delay-4 { transition-delay: 0.4s; }
        .delay-5 { transition-delay: 0.5s; }

        .float-anim { animation: float 6s ease-in-out infinite; }
        .float-slow { animation: floatSlow 4s ease-in-out infinite; }
        .pulse-anim { animation: pulseGlow 4s ease-in-out infinite; }
        .spin-anim { animation: spin 1s linear infinite; }
        .bounce-anim { animation: bounce 2s ease-in-out infinite; }

        .shimmer {
            background: linear-gradient(90deg, var(--bg-soft) 25%, var(--bg-white) 50%, var(--bg-soft) 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        .announcement-bar { padding: .65rem 1rem; text-align: center; font-size: .875rem; font-weight: 600; position: relative; overflow: hidden; z-index: 1001; }
        
        .anim-slide-down { animation: slideDown 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .anim-shimmer::after { content: ''; position: absolute; top: 0; left: 0; width: 200%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent); animation: shimmer 4s infinite linear; pointer-events: none; }
        .anim-marquee { overflow: hidden; white-space: nowrap; }
        .anim-marquee .marquee-inner { display: inline-block; padding-left: 100%; animation: marquee 15s linear infinite; }
        .anim-marquee:hover .marquee-inner { animation-play-state: paused; }


        .announcement-info    { background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #1e40af; }
        .announcement-success { background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46; }
        .announcement-warning { background: linear-gradient(135deg, #fef3c7, #fde68a); color: #92400e; }
        .announcement-danger  { background: linear-gradient(135deg, #fee2e2, #fecaca); color: #991b1b; }
        .announcement-premium { background: linear-gradient(135deg, #1e3a5f, #2d5490, #1e3a5f); background-size: 200% 100%; color: #fff; animation: gradientFlow 6s ease infinite !important; }
        
        .announcement-bar .close-btn { position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); background: none; border: none; font-size: 1.25rem; cursor: pointer; opacity: 0.6; padding: .25rem; line-height: 1; transition: opacity .2s; border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; }
        .announcement-bar .close-btn:hover { opacity: 1; background: rgba(0,0,0,0.1); }
        .announcement-bar { position: relative; }

        .navbar { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-bottom: none; position: sticky; top: 0; z-index: 1000; box-shadow: 0 4px 30px rgba(26,39,68,0.2); transition: var(--transition-base); }
        .navbar.scrolled { background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%); box-shadow: 0 4px 30px rgba(26,39,68,0.3); }
        .nav-container { max-width: 1200px; margin: 0 auto; padding: .85rem 1.5rem; display: flex; align-items: center; justify-content: space-between; }
        .nav-brand { display: flex; align-items: center; gap: .75rem; transition: var(--transition-base); }
        .nav-brand:hover { transform: translateX(4px); }
        .nav-brand img { height: 44px; width: auto; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.2); }
        .nav-brand .logo-icon { width: 38px; height: 38px; background: var(--accent); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; font-weight: 800; color: var(--primary); box-shadow: 0 2px 10px var(--accent-glow); }
        .nav-brand .brand-name { font-family: 'Poppins', sans-serif; font-size: 1.2rem; font-weight: 700; color: #fff; letter-spacing: -.02em; }
        .nav-brand .brand-sub { font-family: 'Poppins', sans-serif; font-size: .6rem; color: rgba(255,255,255,.6); display: block; margin-top: -3px; letter-spacing: .5px; text-transform: uppercase; }
        .nav-links { display: flex; align-items: center; gap: .25rem; }
        .nav-links a { color: rgba(255,255,255,.85); font-family: 'Poppins', sans-serif; font-size: .9rem; font-weight: 500; padding: .5rem 1rem; border-radius: var(--radius-md); transition: var(--transition-base); position: relative; }
        .nav-links a::after { content: ''; position: absolute; bottom: .25rem; left: 1rem; right: 1rem; height: 2px; background: var(--accent); border-radius: 2px; transform: scaleX(0); transition: var(--transition-base); }
        .nav-links a:hover, .nav-links a.active { color: #fff; }
        .nav-links a:hover::after, .nav-links a.active::after { transform: scaleX(1); }
        .nav-btn { background: linear-gradient(135deg, var(--accent), var(--accent-light)) !important; color: var(--primary) !important; padding: .5rem 1.25rem !important; border-radius: var(--radius-full) !important; font-family: 'Poppins', sans-serif; font-weight: 600 !important; border-bottom: none !important; box-shadow: 0 4px 14px var(--accent-glow); transition: var(--transition-bounce) !important; }
        .nav-btn:hover { transform: translateY(-2px) scale(1.05) !important; box-shadow: 0 6px 20px var(--accent-glow) !important; }
        .nav-btn span::before { display: none; }
        .hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; padding: .5rem; border-radius: var(--radius-sm); transition: var(--transition-base); }
        .hamburger:hover { background: rgba(255,255,255,0.1); }
        .hamburger span { width: 24px; height: 2px; background: #fff; border-radius: 2px; transition: var(--transition-base); }
        .hamburger.active span:nth-child(1) { transform: rotate(45deg) translate(5px, 5px); }
        .hamburger.active span:nth-child(2) { opacity: 0; }
        .hamburger.active span:nth-child(3) { transform: rotate(-45deg) translate(5px, -5px); }

        .container { max-width: 1200px; margin: 0 auto; padding: 0 1rem; }
        .section { padding: 5rem 0; }

        .hero { background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 30%, var(--primary-light) 60%, var(--primary) 100%); background-size: 200% 200%; animation: gradientFlow 15s ease infinite; color: #fff; padding: 6rem 0 5rem; position: relative; overflow: hidden; }
        .hero::before { content: ''; position: absolute; inset: 0; background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); opacity: 0.5; }
        .hero-bg-shape { position: absolute; right: -100px; top: -100px; width: 600px; height: 600px; background: radial-gradient(circle, rgba(245,158,11,0.15) 0%, transparent 70%); border-radius: 50%; animation: floatSlow 8s ease-in-out infinite; }
        .hero-bg-shape2 { position: absolute; left: -80px; bottom: -150px; width: 450px; height: 450px; background: radial-gradient(circle, rgba(59,130,246,0.1) 0%, transparent 70%); border-radius: 50%; animation: floatSlow 10s ease-in-out infinite reverse; }
        .hero-bg-dots { position: absolute; right: 10%; top: 20%; width: 100px; height: 100px; background: radial-gradient(circle, var(--accent) 2px, transparent 2px); background-size: 20px 20px; opacity: 0.3; animation: float 6s ease-in-out infinite; }
        .hero-content { position: relative; z-index: 1; max-width: 720px; margin: 0 auto; text-align: center; }
        .hero-badge { display: inline-flex; align-items: center; gap: .5rem; background: rgba(245,158,11,.15); border: 1px solid rgba(245,158,11,.3); color: var(--accent-light); padding: .4rem 1rem; border-radius: var(--radius-full); font-family: 'Poppins', sans-serif; font-size: .8rem; font-weight: 600; margin-bottom: 1.5rem; animation: slideUp 0.8s ease forwards; }
        .hero-badge svg { animation: iconBounce 2s ease-in-out infinite; }
        .hero h1 { font-family: 'Poppins', sans-serif; font-size: 3.5rem; font-weight: 800; line-height: 1.15; margin-bottom: 1.5rem; animation: slideUp 0.8s ease 0.2s forwards; opacity: 0; }
        .hero h1 span { background: linear-gradient(135deg, var(--accent) 0%, var(--accent-light) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .hero p { font-family: 'Inter', sans-serif; font-size: 1.2rem; color: rgba(255,255,255,.85); margin-bottom: 2.5rem; line-height: 1.8; animation: slideUp 0.8s ease 0.4s forwards; opacity: 0; }
        .hero-actions { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; animation: slideUp 0.8s ease 0.6s forwards; opacity: 0; }
        .btn-primary { background: linear-gradient(135deg, var(--accent), var(--accent-light)); color: var(--primary); padding: .9rem 2rem; border-radius: var(--radius-full); font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1rem; transition: var(--transition-bounce); display: inline-flex; align-items: center; justify-content: center; gap: .5rem; box-shadow: 0 4px 20px var(--accent-glow); border: none; cursor: pointer; width: fit-content; max-width: 100%; }
        .btn-primary:hover { transform: translateY(-4px) scale(1.02); box-shadow: 0 8px 30px var(--accent-glow); }
        .btn-primary:active { transform: translateY(-2px) scale(0.98); }
        .btn-secondary { background: rgba(255,255,255,.1); backdrop-filter: blur(10px); color: #fff; padding: .9rem 2rem; border-radius: var(--radius-full); font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 1rem; transition: var(--transition-base); display: inline-flex; align-items: center; gap: .5rem; border: 2px solid rgba(255,255,255,.2); cursor: pointer; }
        .btn-secondary:hover { background: rgba(255,255,255,.2); border-color: rgba(255,255,255,.4); transform: translateY(-2px); }
        .hero-stats { display: flex; gap: 3rem; justify-content: center; margin-top: 4rem; padding-top: 2.5rem; border-top: 1px solid rgba(255,255,255,.1); animation: slideUp 0.8s ease 0.8s forwards; opacity: 0; }
        .stat-item { text-align: center; }
        .stat-item .num { font-family: 'Poppins', sans-serif; font-size: 2.5rem; font-weight: 800; background: linear-gradient(135deg, var(--accent) 0%, var(--accent-light) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .stat-item .label { font-family: 'Inter', sans-serif; font-size: .85rem; color: rgba(255,255,255,.6); margin-top: .25rem; }

        .card { background: var(--bg-white); border-radius: var(--radius-lg); box-shadow: var(--shadow-card); overflow: hidden; transition: var(--transition-slow); border: 1px solid var(--border-light); position: relative; }
        .card::before { content: ''; position: absolute; inset: 0; border-radius: inherit; padding: 2px; background: linear-gradient(135deg, var(--primary), var(--accent)); -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0); -webkit-mask-composite: xor; mask-composite: exclude; opacity: 0; transition: var(--transition-base); }
        .card:hover { transform: translateY(-10px); box-shadow: var(--shadow-card-hover); }
        .card:hover::before { opacity: 1; }
        .card-img { width: 100%; height: 200px; object-fit: cover; transition: var(--transition-slow); }
        .card:hover .card-img { transform: scale(1.08); }
        .card-img-placeholder { width: 100%; height: 200px; background: linear-gradient(135deg, var(--primary), var(--primary-light)); display: flex; align-items: center; justify-content: center; font-size: 3rem; position: relative; overflow: hidden; }
        .card-img-placeholder::after { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, transparent 40%, rgba(245,158,11,0.2)); }
        .card-body { padding: 1.5rem; }
        .card-category { display: inline-flex; align-items: center; gap: .4rem; font-family: 'Poppins', sans-serif; font-size: .7rem; font-weight: 600; padding: .35rem .85rem; border-radius: var(--radius-full); margin-bottom: 1rem; background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: #fff; text-transform: uppercase; letter-spacing: .5px; }
        .card-title { font-family: 'Poppins', sans-serif; font-size: 1.1rem; font-weight: 700; line-height: 1.4; margin-bottom: .75rem; color: var(--text); transition: var(--transition-base); }
        .card:hover .card-title { color: var(--primary); }
        .card-excerpt { font-family: 'Inter', sans-serif; font-size: .9rem; color: var(--text-secondary); line-height: 1.7; margin-bottom: 1.25rem; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        .card-meta { display: flex; align-items: center; gap: 1rem; font-family: 'Inter', sans-serif; font-size: .8rem; color: var(--text-muted); }
        .card-meta .dot { width: 4px; height: 4px; background: var(--text-light); border-radius: 50%; }

        .posts-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem; }
        .categories-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 1.25rem; }

        .cat-card { display: flex; flex-direction: column; align-items: center; gap: .75rem; padding: 2rem 1.25rem; background: var(--bg-white); border-radius: var(--radius-lg); box-shadow: var(--shadow-card); text-align: center; transition: var(--transition-slow); border: 2px solid transparent; position: relative; overflow: hidden; }
        .cat-card::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, var(--primary), var(--accent)); opacity: 0; transition: var(--transition-base); }
        .cat-card:hover { transform: translateY(-8px); border-color: transparent; box-shadow: var(--shadow-card-hover); }
        .cat-card:hover::before { opacity: 0.08; }
        .cat-icon { font-size: 2.5rem; margin-bottom: .5rem; transition: var(--transition-bounce); }
        .cat-card:hover .cat-icon { transform: scale(1.2) rotate(5deg); }
        .cat-name { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: .95rem; color: var(--text); transition: var(--transition-base); }
        .cat-card:hover .cat-name { color: var(--primary); }
        .cat-count { font-family: 'Inter', sans-serif; font-size: .8rem; color: var(--text-muted); }
        .cat-card .count-badge { position: absolute; top: 1rem; right: 1rem; background: var(--accent); color: var(--primary); font-family: 'Poppins', sans-serif; font-size: .7rem; font-weight: 700; padding: .25rem .6rem; border-radius: var(--radius-full); }

        .section-header { text-align: center; margin-bottom: 3.5rem; }
        .section-badge { display: inline-block; background: linear-gradient(135deg, rgba(44,76,59,0.08), rgba(245,158,11,0.08)); color: var(--primary); font-family: 'Poppins', sans-serif; font-size: .8rem; font-weight: 600; padding: .4rem 1rem; border-radius: var(--radius-full); margin-bottom: 1rem; border: 1px solid rgba(44,76,59,0.1); }
        .section-title { font-family: 'Poppins', sans-serif; font-size: 2.5rem; font-weight: 800; color: var(--text); margin-bottom: 1rem; line-height: 1.2; }
        .section-subtitle { font-family: 'Inter', sans-serif; font-size: 1.1rem; color: var(--text-secondary); max-width: 600px; margin: 0 auto; line-height: 1.7; }

        .footer { background: var(--primary); color: rgba(255,255,255,.75); padding: 4rem 0 2rem; position: relative; overflow: hidden; }
        .footer::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--accent), var(--accent-light), var(--accent)); }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 3rem; margin-bottom: 2.5rem; }
        .footer-brand { position: relative; }
        .footer-brand::after { content: ''; position: absolute; right: 0; top: 0; bottom: 0; width: 1px; background: linear-gradient(180deg, transparent, rgba(255,255,255,.15), transparent); }
        .footer-brand .brand-name { font-size: 1.3rem; font-weight: 800; color: #fff; margin-bottom: .75rem; display: flex; align-items: center; gap: .6rem; }
        .footer-brand .brand-name img { height: 36px; width: auto; }
        .footer-brand p { font-size: .875rem; line-height: 1.7; margin-bottom: 1.25rem; }
        .footer-social { display: flex; gap: .75rem; }
        .footer-social a { width: 38px; height: 38px; border-radius: 10px; background: rgba(255,255,255,.1); display: flex; align-items: center; justify-content: center; color: #fff; transition: all .3s; font-size: 1rem; }
        .footer-social a:hover { background: var(--accent); color: var(--primary); transform: translateY(-3px); }
        .footer-col h4 { color: #fff; font-weight: 700; margin-bottom: 1.25rem; font-size: .95rem; position: relative; padding-bottom: .5rem; }
        .footer-col h4::after { content: ''; position: absolute; bottom: 0; left: 0; width: 25px; height: 2px; background: var(--accent); border-radius: 2px; }
        .footer-col ul { list-style: none; }
        .footer-col ul li { margin-bottom: .6rem; }
        .footer-col ul li a { font-size: .875rem; transition: color .2s; display: inline-flex; align-items: center; gap: .35rem; }
        .footer-col ul li a:hover { color: var(--accent); }
        .footer-col ul li a::before { content: '›'; opacity: 0; transform: translateX(-5px); transition: all .2s; }
        .footer-col ul li a:hover::before { opacity: 1; transform: translateX(0); }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,.1); padding-top: 1.75rem; text-align: center; font-size: .825rem; }

        .alert { padding: .9rem 1.2rem; border-radius: 10px; margin-bottom: 1rem; font-size: .9rem; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
 
        /* Responsive Utilities */
        .sidebar-layout-grid { display: grid; grid-template-columns: 1fr 280px; gap: 2.5rem; align-items: start; }
        .sidebar-layout-grid > * { max-width: 100%; }
        .grid-2-responsive { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: start; }
 
        @media (max-width: 900px) {
            .sidebar-layout-grid { grid-template-columns: 1fr; gap: 2rem; }
        }
 
        @media (max-width: 768px) {
            .nav-links { position: absolute; top: 100%; left: 0; right: 0; background: var(--primary); flex-direction: column; padding: 0 1.5rem; gap: .5rem; max-height: 0; overflow: hidden; transition: all .4s cubic-bezier(0.16, 1, 0.3, 1); border-bottom: 2px solid transparent; opacity: 0; }
            .nav-links.open { padding: 1rem; max-height: 500px; border-bottom-color: var(--accent); opacity: 1; }
            .nav-links a { width: 100%; text-align: center; padding: .75rem 1rem !important; }
            .hamburger { display: flex; }
            .hero { padding: 3rem 0 2rem; }
            .hero h1 { font-size: 1.75rem; line-height: 1.3 !important; }
            .hero p { font-size: .95rem; line-height: 1.6 !important; padding: 0 0.5rem; }
            .hero-actions { flex-direction: column; gap: .75rem; align-items: center; }
            .hero-actions a { width: auto; justify-content: center; text-align: center; max-width: 280px; }
            .container { max-width: 100% !important; padding: 0 1rem !important; }
            .section { padding: 2rem 0.5rem !important; }
            .forum-page-container > div, .forum-page-container > div > div { max-width: 100% !important; padding-left: 0.5rem !important; padding-right: 0.5rem !important; }
            .hero-stats { gap: 1.5rem; flex-wrap: wrap; justify-content: center; }
            .hero-stats .stat-item { flex: 1 1 45%; min-width: 80px; }
            .footer-grid { grid-template-columns: 1fr; gap: 2rem; }
            .footer-brand::after { display: none; }
            .posts-grid { grid-template-columns: 1fr; gap: 1.5rem; }
            .posts-grid .card { margin: 0 -0.5rem; width: calc(100% + 1rem); }
            .sidebar-layout-grid, .grid-2-responsive { grid-template-columns: 1fr !important; gap: 2rem !important; }
            .sidebar-layout-grid > * { max-width: 100%; overflow-x: hidden; }
            .section { padding: 2rem 0; }
            .section-header { margin-bottom: 2rem; text-align: center; }
            .section-title { font-size: 1.75rem; line-height: 1.3; }
            .section-subtitle { padding: 0 0.5rem; }
            .categories-grid { grid-template-columns: repeat(2, 1fr); gap: 1rem; }
            .cat-card { padding: 1.25rem; text-align: center; }
            .cat-card .cat-icon { font-size: 2rem; }
            .card-body { padding: 1rem; }
            .card-title { font-size: 1rem; line-height: 1.4; }
            .card-meta { flex-wrap: wrap; gap: 0.5rem !important; font-size: 0.75rem !important; }
            .btn-primary, .btn-secondary { padding: .75rem 1.5rem; font-size: .9rem; width: auto; max-width: 280px !important; display: inline-flex !important; }
            .post-card-horizontal { flex-direction: column !important; }
            .post-card-horizontal-img { width: 100% !important; min-height: 180px !important; }
            .search-form-responsive { flex-direction: column !important; gap: 0.5rem !important; display: flex !important; flex-wrap: wrap !important; align-items: stretch !important; padding: 0 0.5rem !important; box-sizing: border-box !important; }
            .search-form-responsive input { width: 100% !important; flex: none !important; max-width: calc(100% - 1rem) !important; margin: 0 auto !important; }
            .search-form-responsive button[type="submit"], .search-form-responsive .search-btn-mobile { width: auto !important; flex: none !important; min-width: 120px !important; margin: 0 auto !important; }
            .search-form-responsive .clear-btn { width: auto !important; flex: none !important; min-width: 100px !important; margin: 0 auto !important; }
            .contact-info-card { flex-direction: column !important; text-align: center !important; align-items: center !important; gap: 0.75rem !important; }
            .contact-page-heading { text-align: center !important; }
            .forum-topic-card { flex-direction: column !important; }
            .forum-topic-card .reply-count { width: 100% !important; flex-direction: row !important; justify-content: center; gap: 0.5rem !important; margin-top: 0.75rem; }
            .forum-topic-content { flex-direction: column !important; }
            .forum-topic-content > div:first-child { width: 100% !important; }
            .forum-topic-content .reply-count { width: auto !important; margin-top: 0.75rem; align-self: center; }
            .forum-header { padding: 1.5rem 1rem !important; }
            .forum-header h1 { font-size: 1.5rem !important; word-wrap: break-word !important; }
            .forum-header p { font-size: .85rem !important; }
            .forum-topic-body { padding: 1rem !important; margin-left: 0 !important; margin-right: 0 !important; word-wrap: break-word !important; overflow-wrap: break-word !important; }
            .forum-topic-body p { word-wrap: break-word !important; overflow-wrap: break-word !important; }
            .forum-reply-card { padding: 1rem !important; word-wrap: break-word !important; }
            .forum-reply-card p { word-wrap: break-word !important; overflow-wrap: break-word !important; }
            .forum-page-container { max-width: 100% !important; padding: 0 0.5rem !important; }
            .forum-page-container > div { max-width: 100% !important; padding-left: 0.5rem !important; padding-right: 0.5rem !important; margin-left: 0 !important; margin-right: 0 !important; }
            .forum-reply-form-box { margin-left: 0 !important; margin-right: 0 !important; }
            .forum-replies-container { padding: 0 0.5rem !important; }
            .forum-replies-container > div { margin-left: 0 !important; margin-right: 0 !important; }
            .forum-replies-section { max-height: 300px !important; overflow-y: auto !important; padding: 0.75rem !important; background: #e5e5e5 !important; }
            .forum-replies-section .forum-reply-card { padding: 0.5rem 0.75rem !important; margin-bottom: 0.5rem !important; background: #fff !important; border-radius: 10px 10px 10px 4px !important; max-width: 90% !important; float: left !important; clear: both !important; }
            .forum-replies-section .forum-reply-card .chat-author { font-size: 0.65rem !important; margin-bottom: 0.15rem !important; }
            .forum-replies-section .forum-reply-card .chat-date { font-size: 0.6rem !important; }
            .forum-replies-section .forum-reply-card p { font-size: 0.85rem !important; line-height: 1.4 !important; margin-bottom: 0.15rem !important; }
.forum-replies-section::after { content: ''; display: table; clear: both; }
            .telegram-reply-form { padding: 0.75rem !important; }
            .telegram-reply-form form { flex-direction: column !important; gap: 0.5rem !important; }
            .telegram-reply-form input, .telegram-reply-form textarea { font-size: 0.9rem !important; padding: 0.5rem 0.75rem !important; }
            .telegram-send-btn { width: auto !important; height: auto !important; min-width: 100px !important; border-radius: 20px !important; display: inline-flex !important; justify-content: center !important; padding: 0.6rem 1.25rem !important; font-size: 0.85rem !important; }
            .forum-replies-section .forum-reply-card { max-width: 90% !important; }
            .forum-replies-section .forum-reply-card:nth-child(odd) { float: left !important; }
            .forum-replies-section .forum-reply-card:nth-child(even) { float: right !important; background: #e1ffc7 !important; }
            .forum-topic-header { flex-direction: column !important; align-items: center !important; gap: 1rem !important; text-align: center !important; }
            .forum-topic-header h2 { text-align: center !important; font-size: 1.25rem !important; width: 100% !important; margin-bottom: 0.5rem !important; }
            .forum-topic-header .btn-primary { width: 100% !important; max-width: 200px !important; display: flex !important; justify-content: center !important; }
            .forum-create-form { padding: 1rem !important; }
            .forum-create-form input, .forum-create-form textarea { font-size: 1rem !important; padding: 0.75rem !important; }
            .forum-create-form button { width: 100% !important; }
            .forum-reply-form { padding: 1rem !important; width: 100% !important; max-width: 100% !important; }
            .forum-reply-form-box { padding: 1rem !important; }
            .forum-reply-form-title { text-align: center !important; }
            .forum-reply-btn { width: 100% !important; display: flex !important; justify-content: center !important; margin-left: 0 !important; margin-right: 0 !important; text-align: center !important; }
            button.forum-reply-btn { width: 100% !important; display: flex !important; justify-content: center !important; }
            .forum-reply-form button { width: 100% !important; margin-left: auto !important; margin-right: auto !important; text-align: center !important; justify-content: center !important; }
            .forum-reply-form .btn-primary { width: 100% !important; margin-left: auto !important; margin-right: auto !important; text-align: center !important; }
            .forum-replies-header { flex-direction: column !important; align-items: center !important; gap: 0.5rem !important; }
            .forum-replies-title { text-align: center !important; }
            .forum-input, .forum-create-form input, .forum-create-form textarea { font-size: 1rem !important; padding: 0.75rem !important; }
        }
        
        /* Forum - Telegram Chat Style */
        .forum-replies-section { max-height: 600px; overflow-y: auto; padding: 1rem; background: #e5e5e5; }
        .forum-replies-section .forum-reply-card { margin-bottom: 0.5rem; padding: 0.5rem 0.75rem; background: #fff; border-radius: 12px 12px 12px 4px; box-shadow: 0 1px 0.5px rgba(0,0,0,0.1); max-width: 80%; clear: both; float: left; }
        .forum-replies-section .forum-reply-card:nth-child(odd) { float: left; background: #fff; border-radius: 12px 12px 12px 4px; }
        .forum-replies-section .forum-reply-card:nth-child(even) { float: right; background: #e1ffc7; border-radius: 12px 12px 4px 12px; }
        .forum-replies-section .forum-reply-card .chat-author { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.25rem; font-size: 0.7rem; font-weight: 700; color: var(--primary); }
        .forum-replies-section .forum-reply-card:nth-child(even) .chat-author { color: #1a7a00; }
        .forum-replies-section .forum-reply-card .reply-author { font-weight: 700; }
        .forum-replies-section .forum-reply-card .chat-date { font-size: 0.65rem; color: var(--text-muted); margin-left: auto; }
        .forum-replies-section .forum-reply-card:nth-child(even) .chat-date { color: #1a7a00; }
        .forum-replies-section .forum-reply-card p { font-size: 0.9rem; line-height: 1.4; color: #000; margin-bottom: 0; }
        .forum-replies-section .forum-reply-card:nth-child(even) p { color: #000; }
        .forum-replies-section::-webkit-scrollbar { width: 5px; }
        .forum-replies-section::-webkit-scrollbar-track { background: transparent; }
        .forum-replies-section::-webkit-scrollbar-thumb { background: #999; border-radius: 3px; }
        .forum-replies-section::after { content: ''; display: table; clear: both; }
        
        /* About Page Premium Sections */
        
        .about-section { margin-bottom: 3rem; }
        .about-section h2 { font-family: 'Merriweather', serif; font-size: 1.5rem; color: var(--primary); margin-bottom: 1.25rem; display: flex; align-items: center; gap: .75rem; }
        .about-section h2 .icon { font-size: 1.25rem; }
        .about-section > p { font-size: 1rem; color: var(--text-muted); line-height: 1.8; max-width: 800px; }
        
        .values-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; margin-top: 1.5rem; }
        .value-card { background: linear-gradient(135deg, #f8fafc, #fff); border: 1px solid var(--border); border-radius: 16px; padding: 1.75rem; text-align: center; transition: all .3s; }
        .value-card:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(44,76,59,.12); border-color: var(--accent); }
        .value-icon { font-size: 2.5rem; margin-bottom: 1rem; display: block; }
        .value-card h3 { font-family: 'Merriweather', serif; font-size: 1.1rem; color: var(--primary); margin-bottom: .75rem; }
        .value-card p { font-size: .875rem; color: var(--text-muted); line-height: 1.6; }
        
        .why-grid { display: flex; flex-direction: column; gap: 1.25rem; margin-top: 1.5rem; }
        .why-item { display: flex; gap: 1.25rem; padding: 1.5rem; background: #fff; border-radius: 14px; border: 1px solid var(--border); transition: all .3s; }
        .why-item:hover { border-color: var(--accent); box-shadow: 0 8px 25px rgba(44,76,59,.08); }
        .why-number { width: 40px; height: 40px; min-width: 40px; background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: #fff; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1rem; }
        .why-item h3 { font-size: 1rem; font-weight: 700; color: var(--text); margin-bottom: .4rem; }
        .why-item p { font-size: .875rem; color: var(--text-muted); line-height: 1.6; }
        
        @media (max-width: 768px) {
            .about-hero { padding: 2.5rem 1.5rem; }
            .about-hero h1 { font-size: 1.75rem; }
            .values-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 480px) {
            .values-grid { grid-template-columns: 1fr; }
            .about-hero h1 { font-size: 1.5rem; }
        }
    </style>
    @stack('styles')
</head>
<body>

@if(isset($announcement))
    <div id="announcementBar" class="announcement-bar {{ $announcement->style_class }} anim-{{ $announcement->animation_type }}" data-announcement-id="{{ $announcement->id }}">
        <div class="marquee-inner" style="display:flex;align-items:center;justify-content:center;gap:.5rem;max-width:1200px;margin:0 auto;padding:0 1rem">
            <span style="flex:1;text-align:center"><strong>{{ $announcement->title }}</strong>: {!! $announcement->content !!}</span>
            <button type="button" class="close-btn" onclick="dismissAnnouncement('{{ $announcement->id }}')" aria-label="Dismiss announcement">&times;</button>
        </div>
    </div>
@endif

<nav class="navbar">
    <div class="nav-container">
        <a href="{{ route('home') }}" class="nav-brand">
            @php 
$siteLogo = \App\Models\Setting::get('site_logo');
$logoSrc = $siteLogo && (str_starts_with($siteLogo, 'http') || str_starts_with($siteLogo, '//')) ? $siteLogo : ($siteLogo ? asset('storage/' . $siteLogo) : null);
@endphp
            @if($logoSrc)
                <img src="{{ $logoSrc }}" alt="{{ $siteName }}" style="height:44px;width:auto;max-width:100px;object-fit:contain;border-radius:8px;">
            @else
                <img src="{{ asset('images/icon.svg') }}" alt="{{ $siteName }}" style="height:44px;width:44px;border-radius:8px;object-fit:cover;">
            @endif
            <div>
                <span class="brand-name">{{ $siteName }}</span>
                <span class="brand-sub">{{ \App\Models\Setting::get('site_tagline', 'Practical Tips & Guides') }}</span>
            </div>
        </a>
        <div class="nav-links" id="navLinks">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('posts.index') }}" class="{{ request()->routeIs('posts.*') ? 'active' : '' }}">Articles</a>
            <a href="{{ route('pages.show', 'free-services') }}" class="{{ request()->is('pages/free-services') ? 'active' : '' }}">Free Services</a>
            <a href="{{ route('forum.index') }}" class="{{ request()->routeIs('forum.*') ? 'active' : '' }}">Forum</a>
            <a href="{{ route('pages.show', 'about') }}" class="{{ request()->is('pages/about') ? 'active' : '' }}">About</a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
        </div>
        <div class="hamburger" onclick="document.getElementById('navLinks').classList.toggle('open')">
            <span></span><span></span><span></span>
        </div>
    </div>
</nav>

@if(session('success'))
    <div class="container" style="padding-top:1rem">
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    </div>
@endif
@if(session('error'))
    <div class="container" style="padding-top:1rem">
        <div class="alert alert-error">❌ {{ session('error') }}</div>
    </div>
@endif

<main>
    @yield('content')
</main>

<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="brand-name">
                    @php 
$siteLogo = \App\Models\Setting::get('site_logo');
$logoSrc = $siteLogo && (str_starts_with($siteLogo, 'http') || str_starts_with($siteLogo, '//')) ? $siteLogo : ($siteLogo ? asset('storage/' . $siteLogo) : null);
@endphp
                    @if($logoSrc)
                        <img src="{{ $logoSrc }}" alt="{{ $siteName }}" style="height:36px;width:auto;max-width:90px;object-fit:contain;border-radius:8px;">
                    @else
                        <img src="{{ asset('images/icon.svg') }}" alt="{{ $siteName }}" style="height:36px;width:36px;border-radius:8px;object-fit:cover;">
                    @endif
                    <span>{{ $siteName }}</span>
                </div>
                <p>Your digital tambayan for practical tips and helpful guides written by Filipinos, for Filipinos. We share useful information you can apply in your daily life.</p>
                <div class="footer-social">
                    @php
                        $facebook = \App\Models\Setting::get('social_facebook', 'https://facebook.com');
                        $twitter = \App\Models\Setting::get('social_twitter', 'https://twitter.com');
                        $tiktok = \App\Models\Setting::get('social_tiktok', 'https://tiktok.com');
                        $linkedin = \App\Models\Setting::get('social_linkedin', 'https://linkedin.com');
                        $instagram = \App\Models\Setting::get('social_instagram', 'https://instagram.com');
                    @endphp
                        <a href="{{ $facebook }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="{{ $twitter }}" target="_blank" rel="noopener noreferrer" aria-label="Twitter/X">
                            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        <a href="{{ $tiktok }}" target="_blank" rel="noopener noreferrer" aria-label="TikTok">
                            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                        </a>
                        <a href="{{ $linkedin }}" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                        <a href="{{ $instagram }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                </div>
                <div class="footer-newsletter" style="margin-top:1.5rem" x-data="footerNewsletter()">
                    <p style="color:rgba(255,255,255,.7);font-size:.875rem;margin-bottom:.75rem">Subscribe to our newsletter:</p>
                    
                    <div x-show="message" x-text="message" :style="messageType === 'success' ? 'color:#4ade80' : 'color:#f87171'" style="font-size:.875rem;margin-bottom:.5rem"></div>
                    
                    <form @submit.prevent="submit" style="display:flex;gap:.5rem">
                        @csrf
                        <input type="email" x-model="email" placeholder="Your email" required style="flex:1;padding:.5rem .875rem;border-radius:8px;border:1px solid rgba(255,255,255,.2);background:rgba(255,255,255,.1);color:#fff;font-size:.875rem;outline:none" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='rgba(255,255,255,.2)'">
                        <button type="submit" :disabled="loading" style="padding:.5rem 1rem;border-radius:8px;background:var(--primary);color:#fff;font-size:.875rem;font-weight:600;border:none;cursor:pointer;transition:background .2s" onmouseover="this.style.background='var(--primary-dark)'" onmouseout="this.style.background='var(--primary)'">
                            <span x-show="!loading">Subscribe</span>
                            <span x-show="loading">...</span>
                        </button>
                    </form>
                </div>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('posts.index') }}">Articles</a></li>
                    <li><a href="{{ route('pages.show', 'about') }}">About</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Categories</h4>
                <ul>
                    @foreach(\App\Models\Category::orderBy('order')->limit(5)->get() as $footerCategory)
                        <li><a href="{{ route('categories.show', $footerCategory->slug) }}">{{ $footerCategory->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>{{ \App\Models\Setting::get('footer_text', '© ' . date('Y') . ' ' . $siteName . '. All rights reserved.') }}</p>
            <p style="margin-top:.75rem;font-size:.78rem">
                <a href="{{ route('privacy-policy') }}" style="color:rgba(255,255,255,.55);margin:0 .6rem;transition:color .2s" onmouseover="this.style.color='#f59e0b'" onmouseout="this.style.color='rgba(255,255,255,.55)'">Privacy Policy</a>
                <span style="opacity:.4">|</span>
                <a href="{{ route('terms') }}" style="color:rgba(255,255,255,.55);margin:0 .6rem;transition:color .2s" onmouseover="this.style.color='#f59e0b'" onmouseout="this.style.color='rgba(255,255,255,.55)'">Terms of Service</a>
            </p>
        </div>
    </div>
</footer>

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale').forEach(el => observer.observe(el));
            
            if (sessionStorage.getItem('announcement_dismissed')) {
                const bar = document.getElementById('announcementBar');
                if (bar) bar.style.display = 'none';
            }
            
            const navbar = document.querySelector('.navbar');
            if (navbar) {
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 50) {
                        navbar.classList.add('scrolled');
                    } else {
                        navbar.classList.remove('scrolled');
                    }
                });
            }
            
            const hamburger = document.querySelector('.hamburger');
            if (hamburger) {
                hamburger.addEventListener('click', () => {
                    hamburger.classList.toggle('active');
                });
            }
        });
        
        function dismissAnnouncement(id) {
            sessionStorage.setItem('announcement_dismissed', id);
            const bar = document.getElementById('announcementBar');
            if (bar) {
                bar.style.transition = 'all 0.4s cubic-bezier(0.16, 1, 0.3, 1)';
                bar.style.opacity = '0';
                bar.style.transform = 'translateY(-100%)';
                setTimeout(() => bar.style.display = 'none', 400);
            }
        }
        
        function animateCounter(element, target, duration = 2000) {
            let start = 0;
            const increment = target / (duration / 16);
            const timer = setInterval(() => {
                start += increment;
                if (start >= target) {
                    element.textContent = target.toLocaleString();
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(start).toLocaleString();
                }
            }, 16);
        }
        
        document.querySelectorAll('[data-counter]').forEach(el => {
            const target = parseInt(el.dataset.counter);
            const observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting) {
                    animateCounter(el, target);
                    observer.disconnect();
                }
            }, { threshold: 0.5 });
            observer.observe(el);
        });
    </script>

    {{-- Cookie Consent Banner --}}
    <div id="cookieConsent" style="display:none;position:fixed;bottom:0;left:0;right:0;z-index:9999;background:#1e293b;border-top:2px solid #f59e0b;padding:1rem 1.5rem;box-shadow:0 -4px 20px rgba(0,0,0,.3)">
        <div style="max-width:1200px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;gap:1.5rem;flex-wrap:wrap">
            <div style="flex:1;min-width:200px">
                <p style="color:#e2e8f0;font-size:.875rem;margin:0;line-height:1.6">
                    🍪 We use cookies to enhance your experience and to show you personalized ads through Google AdSense.
                    By continuing to use this site, you consent to our use of cookies.
                    <a href="{{ route('privacy-policy') }}" style="color:#f59e0b;text-decoration:underline">Learn more</a>
                </p>
            </div>
            <div style="display:flex;gap:.75rem;flex-shrink:0">
                <a href="{{ route('privacy-policy') }}" style="padding:.5rem 1rem;font-size:.8rem;color:#94a3b8;border:1px solid rgba(255,255,255,.15);border-radius:8px;white-space:nowrap">Privacy Policy</a>
                <button onclick="acceptCookies()" style="padding:.5rem 1.25rem;background:#f59e0b;color:#1e3a5f;border:none;border-radius:8px;font-weight:700;font-size:.875rem;cursor:pointer;white-space:nowrap">Accept All</button>
            </div>
        </div>
    </div>
    <script>
        function acceptCookies() {
            localStorage.setItem('ecph_cookie_consent', 'accepted');
            document.getElementById('cookieConsent').style.display = 'none';
        }
        (function() {
            if (!localStorage.getItem('ecph_cookie_consent')) {
                document.getElementById('cookieConsent').style.display = 'block';
            }
        })();
        
        function footerNewsletter() {
            return {
                email: '',
                loading: false,
                message: '',
                messageType: '',
                timeout: null,
                async submit() {
                    this.loading = true;
                    this.message = '';
                    if (this.timeout) clearTimeout(this.timeout);
                    try {
                        const response = await fetch('{{ route("newsletter.subscribe") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ email: this.email })
                        });
                        const data = await response.json();
                        if (response.ok) {
                            this.message = data.message || 'Thanks for subscribing!';
                            this.messageType = 'success';
                            this.email = '';
                            this.timeout = setTimeout(() => {
                                this.message = '';
                            }, 10000);
                        } else {
                            this.message = data.message || 'Already subscribed!';
                            this.messageType = 'error';
                            this.timeout = setTimeout(() => {
                                this.message = '';
                            }, 10000);
                        }
                    } catch (e) {
                        console.error('Newsletter error:', e);
                        this.message = 'Network error. Please try again.';
                        this.messageType = 'error';
                    }
                    this.loading = false;
                }
            }
        }
    </script>
</body>
</html>
