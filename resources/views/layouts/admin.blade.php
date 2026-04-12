<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'Admin') — {{ \App\Models\Setting::get('site_name', 'ProGuidePh') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --bg: #0f172a;
            --card: #1e293b;
            --border: #334155;
            --text: #e2e8f0;
            --muted: #94a3b8;
            --primary: #22c55e;
            --primary-dark: #16a34a;
            --danger: #ef4444;
            --warning: #f59e0b;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); display: flex; min-height: 100vh; }
        
        /* Sidebar - Narrower & Cleaner */
        .sidebar { width: 220px; background: var(--card); height: 100vh; position: fixed; left: 0; top: 0; border-right: 1px solid var(--border); display: flex; flex-direction: column; }
        .logo { padding: 1.25rem 1rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: .75rem; font-weight: 700; font-size: 1.1rem; }
        .logo img { width: 32px; height: 32px; border-radius: 8px; }
        
        nav { flex: 1; padding: 1rem 0; overflow-y: auto; }
        .nav-section { padding: .5rem 1rem; font-size: .7rem; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: .05em; }
        .nav-link { display: flex; align-items: center; gap: .75rem; padding: .6rem 1rem; color: var(--muted); font-size: .875rem; transition: all .15s; }
        .nav-link:hover { background: rgba(255,255,255,0.05); color: var(--text); }
        .nav-link.active { background: rgba(34,197,94,0.1); color: var(--primary); border-right: 3px solid var(--primary); }
        .nav-link .badge { margin-left: auto; background: var(--danger); color: #fff; font-size: .7rem; padding: .1rem .4rem; border-radius: 999px; }
        
        .nav-footer { padding: 1rem; border-top: 1px solid var(--border); }
        .nav-btn { display: flex; align-items: center; gap: .5rem; padding: .5rem; color: var(--muted); font-size: .85rem; width: 100%; background: none; border: none; cursor: pointer; }
        .nav-btn:hover { color: var(--text); }

        /* Main */
        .main { margin-left: 220px; flex: 1; padding: 1.5rem 2rem; }
        
        header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        header h1 { font-size: 1.5rem; font-weight: 700; }
        header p { color: var(--muted); font-size: .875rem; margin-top: .25rem; }
        
        .header-actions { display: flex; gap: .75rem; align-items: center; }
        
        /* Cards - Simpler */
        .card { background: var(--card); border: 1px solid var(--border); border-radius: 12px; padding: 1.25rem; margin-bottom: 1.5rem; }
        .card h3 { font-size: .9rem; font-weight: 600; margin-bottom: 1rem; color: var(--text); }
        
        /* Stats Grid */
        .stats { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
        .stat { background: var(--card); border: 1px solid var(--border); border-radius: 12px; padding: 1.25rem; position: relative; }
        .stat-label { font-size: .75rem; color: var(--muted); }
        .stat-value { font-size: 1.75rem; font-weight: 700; margin-top: .25rem; }
        
        /* Buttons */
        .btn { display: inline-flex; align-items: center; gap: .5rem; padding: .5rem 1rem; border-radius: 8px; font-size: .85rem; font-weight: 500; border: none; cursor: pointer; }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-danger { background: var(--danger); color: #fff; }
        .btn-ghost { background: rgba(255,255,255,0.05); color: var(--muted); }
        
        /* Table */
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: .75rem; font-size: .75rem; font-weight: 600; color: var(--muted); border-bottom: 1px solid var(--border); }
        td { padding: .75rem; font-size: .875rem; border-bottom: 1px solid var(--border); }
        tr:hover td { background: rgba(255,255,255,0.02); }
        
        /* Badge */
        .badge { display: inline-block; padding: .2rem .6rem; border-radius: 999px; font-size: .75rem; font-weight: 500; }
        .badge-draft { background: rgba(245,158,11,0.2); color: var(--warning); }
        .badge-published { background: rgba(34,197,94,0.2); color: var(--primary); }
        .badge-admin { background: rgba(239,68,68,0.2); color: var(--danger); }

        /* Flash */
        .flash { padding: .75rem 1rem; border-radius: 8px; margin-bottom: 1rem; font-size: .875rem; }
        .flash-success { background: rgba(34,197,94,0.1); color: var(--primary); border: 1px solid rgba(34,197,94,0.2); }
        .flash-error { background: rgba(239,68,68,0.1); color: var(--danger); border: 1px solid rgba(239,68,68,0.2); }

        @media(max-width: 768px) {
            .sidebar { width: 60px; }
            .logo span, .nav-section, .nav-link span:not(.badge), .nav-btn span { display: none; }
            .nav-link { justify-content: center; padding: 1rem; }
            .main { margin-left: 60px; padding: 1rem; }
            .stats { grid-template-columns: 1fr 1fr; }
        }
    </style>
    @stack('styles')
</head>
<body>

<aside class="sidebar">
    <div class="logo">
        <img src="{{ asset('images/icon.svg') }}" alt="Logo">
        <span>{{ \App\Models\Setting::get('site_name', 'ProGuidePh') }}</span>
    </div>
    
    <nav>
        <div class="nav-section">Overview</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">📊 Dashboard</a>
        <a href="{{ route('admin.system') }}" class="nav-link {{ request()->routeIs('admin.system') ? 'active' : '' }}">⚙️ System</a>
        
        <div class="nav-section">Content</div>
        <a href="{{ route('admin.posts.index') }}" class="nav-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">📝 Posts</a>
        <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">🏷️ Categories</a>
        <a href="{{ route('admin.pages.index') }}" class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">📄 Pages</a>
        <a href="{{ route('admin.media.index') }}" class="nav-link {{ request()->routeIs('admin.media.*') ? 'active' : '' }}">🖼️ Media</a>
        
        <div class="nav-section">Community</div>
        <a href="{{ route('admin.comments.index') }}" class="nav-link {{ request()->routeIs('admin.comments.*') ? 'active' : '' }}">
            💬 Comments
            @php $pending = \App\Models\Comment::where('is_approved', false)->count(); @endphp
            @if($pending > 0)<span class="badge">{{ $pending }}</span>@endif
        </a>
        <a href="{{ route('admin.announcements.index') }}" class="nav-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">📢 Announcements</a>
        <a href="{{ route('admin.forum.topics') }}" class="nav-link {{ request()->routeIs('admin.forum.*') ? 'active' : '' }}">💬 Forum</a>
        
        <div class="nav-section">Manage</div>
        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">👥 Users</a>
        <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">⚙️ Settings</a>
    </nav>
    
    <div class="nav-footer">
        <a href="{{ route('home') }}" class="nav-btn">🌐 View Site</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-btn">🚪 Logout</button>
        </form>
    </div>
</aside>

<main class="main">
    <header>
        <div>
            <h1>@yield('title', 'Dashboard')</h1>
            @yield('header.subtitle')
        </div>
        <div class="header-actions">
            @yield('header.actions')
        </div>
    </header>
    
    @if(session('success'))
        <div class="flash flash-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash flash-error">{{ session('error') }}</div>
    @endif
    
    @yield('content')
</main>

@stack('scripts')
</body>
</html>