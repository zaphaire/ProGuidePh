<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <title>@yield('title', 'Admin') — {{ \App\Models\Setting::get('site_name', 'ProGuidePh') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Apply theme immediately to prevent flicker
        (function() {
            const savedTheme = localStorage.getItem('admin-theme') || 'dark';
            if (savedTheme === 'light') {
                document.documentElement.classList.add('light-mode');
            }
        })();
    </script>
    <style>
        :root {
            /* Dark Mode (Default) */
            --bg-body: #0f172a;
            --bg-sidebar: #1e293b;
            --bg-topbar: #1e293b;
            --bg-card: #1e293b;
            --bg-input: #0f172a;
            --text-main: #e2e8f0;
            --text-header: #f1f5f9;
            --text-muted: #64748b;
            --border-subtle: rgba(255,255,255,.07);
            --border-strong: rgba(255,255,255,.12);
            --bg-subtle: rgba(255,255,255,.03);
            --nav-hover: rgba(255,255,255,.04);
            --shadow-card: none;
            --shadow-sm: none;
            --primary: #2c4c3b;
            --accent: #d6a848;
        }

        .light-mode {
            /* Light Mode Overrides */
            --bg-body: #f8fafc;
            --bg-sidebar: #ffffff;
            --bg-topbar: #ffffff;
            --bg-card: #ffffff;
            --bg-input: #ffffff;
            --text-main: #334155;
            --text-header: #0f172a;
            --text-muted: #64748b;
            --border-subtle: rgba(0,0,0,.06);
            --border-strong: rgba(0,0,0,.1);
            --bg-subtle: rgba(0,0,0,.02);
            --nav-hover: rgba(0,0,0,.04);
            --shadow-card: 0 10px 25px -5px rgba(0,0,0,0.05), 0 8px 10px -6px rgba(0,0,0,0.05);
            --shadow-sm: 0 1px 2px 0 rgba(0,0,0,0.05);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; transition: background 0.25s ease, border-color 0.25s ease; }
        body { font-family: 'Inter', sans-serif; background: var(--bg-body); color: var(--text-main); display: flex; min-height: 100vh; overflow-x: hidden; }
        a { text-decoration: none; color: inherit; transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
 
        /* Animations */
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes scaleUp {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
 
        .animate-fade { animation: fadeIn 0.5s ease-out forwards; }
        .animate-slide { animation: slideInRight 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-scale { animation: scaleUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
 
        .reveal-admin { opacity: 0; transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal-admin.active { opacity: 1; transform: none !important; }

        /* Sidebar */
        .sidebar { width: 260px; background: var(--bg-sidebar); display: flex; flex-direction: column; position: fixed; top: 0; left: 0; height: 100vh; z-index: 100; border-right: 1px solid var(--border-subtle); overflow-y: auto; }
        .sidebar-header { padding: 1.5rem 1.25rem; border-bottom: 1px solid var(--border-subtle); }
        .sidebar-logo { display: flex; align-items: center; gap: .75rem; }
        .sidebar-logo .icon { width: 40px; height: 40px; background: linear-gradient(135deg, var(--accent), #fbbf24); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.1rem; color: #1e3a5f; }
        .sidebar-logo .name { font-size: 1rem; font-weight: 700; color: var(--text-header); transition: color 0.15s; }
        .sidebar-logo:hover .name { color: var(--accent); }
        .sidebar-logo .sub { font-size: .72rem; color: var(--text-muted); display: block; }
        .sidebar-user { padding: 1rem 1.25rem; border-bottom: 1px solid var(--border-subtle); display: flex; align-items: center; gap: .75rem; }
        .user-avatar { width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 2px solid var(--border-subtle); transition: border-color 0.15s; }
        .user-avatar:hover { border-color: var(--accent); }
        .user-info .name { font-size: .875rem; font-weight: 600; color: var(--text-main); display: flex; align-items: center; gap: .4rem; }
        .user-info .role { font-size: .75rem; color: var(--text-muted); text-transform: capitalize; }
        .sidebar-nav { padding: .75rem 0; flex: 1; }
        .nav-section { padding: .5rem 1.25rem; font-size: .7rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: .08em; margin-top: .75rem; }
        .nav-item { display: flex; align-items: center; gap: .75rem; padding: .65rem 1.25rem; font-size: .875rem; color: var(--text-muted); transition: all .15s; border-left: 3px solid transparent; cursor: pointer; }
        .nav-item:hover { background: var(--nav-hover); color: var(--text-header); border-left-color: rgba(245,158,11,.4); padding-left: 1.5rem; }
        .nav-item.active { background: rgba(245,158,11,.08); color: var(--accent); border-left-color: var(--accent); font-weight: 600; padding-left: 1.5rem; }
        .nav-item .icon { font-size: 1rem; width: 20px; text-align: center; }
        .nav-badge { margin-left: auto; background: #ef4444; color: #fff; font-size: .7rem; font-weight: 600; padding: .15rem .45rem; border-radius: 999px; }

        /* Main */
        .main { margin-left: 260px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
        .topbar { background: var(--bg-topbar); border-bottom: 1px solid var(--border-subtle); padding: .85rem 1.75rem; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
        .topbar-title { font-size: 1.1rem; font-weight: 700; color: var(--text-header); }
        .topbar-right { display: flex; align-items: center; gap: 1rem; position: relative; }
        .topbar-link { font-size: .8rem; color: var(--text-muted); background: var(--nav-hover); padding: .4rem .85rem; border-radius: 8px; transition: all .15s; }
        .topbar-link:hover { color: var(--text-header); background: var(--border-subtle); }
        .content { padding: 2rem 1.75rem; flex: 1; }

        /* Cards */
        .admin-card { background: var(--bg-card); border-radius: 14px; border: 1px solid var(--border-subtle); padding: 1.5rem; margin-bottom: 1.5rem; transition: all 0.3s ease; box-shadow: var(--shadow-card); }
        .admin-card:hover { border-color: var(--border-strong); box-shadow: 0 10px 30px rgba(0,0,0,.1); }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.75rem; }
        .stat-card { background: var(--bg-card); border-radius: 14px; border: 1px solid var(--border-subtle); padding: 1.4rem; position: relative; overflow: hidden; box-shadow: var(--shadow-card); }
        .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; border-radius: 14px 14px 0 0; }
        .stat-card.blue::before   { background: #3b82f6; }
        .stat-card.green::before  { background: #10b981; }
        .stat-card.amber::before  { background: #f59e0b; }
        .stat-card.red::before    { background: #ef4444; }
        .stat-card.purple::before { background: #8b5cf6; }
        .stat-card .stat-label { font-size: .78rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: .06em; margin-bottom: .5rem; }
        .stat-card .stat-value { font-size: 2rem; font-weight: 800; color: var(--text-header); }
        .stat-card .stat-icon { position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); font-size: 2.5rem; opacity: .1; color: var(--text-muted); }

        /* Table */
        .admin-table { width: 100%; border-collapse: collapse; font-size: .875rem; }
        .admin-table th { padding: .75rem 1rem; text-align: left; font-size: .75rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: .05em; border-bottom: 1px solid var(--border-subtle); }
        .admin-table td { padding: .85rem 1rem; border-bottom: 1px solid var(--border-subtle); color: var(--text-main); vertical-align: middle; }
        .admin-table tr:hover td { background: var(--nav-hover); }

        /* Buttons */
        .btn { display: inline-flex; align-items: center; gap: .4rem; padding: .5rem 1rem; border-radius: 8px; font-size: .85rem; font-weight: 600; cursor: pointer; transition: all .15s ease; border: none; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .btn-sm { padding: .3rem .7rem; font-size: .78rem; }
        .btn-primary-admin { background: var(--primary); color: #fff; }
        .btn-primary-admin:hover { opacity: .9; }
        .btn-success { background: #10b981; color: #fff; }
        .btn-success:hover { background: #059669; }
        .btn-warning { background: #f59e0b; color: #000; }
        .btn-warning:hover { background: #d97706; }
        .btn-danger { background: #ef4444; color: #fff; }
        .btn-danger:hover { background: #dc2626; }
        .btn-ghost { background: var(--nav-hover); color: var(--text-muted); }
        .btn-ghost:hover { background: var(--border-subtle); color: var(--text-header); }

        /* Forms */
        .form-group { margin-bottom: 1.25rem; }
        .form-label { display: block; font-size: .83rem; font-weight: 600; color: var(--text-muted); margin-bottom: .45rem; }
        .form-control { width: 100%; background: var(--bg-input); border: 1px solid var(--border-subtle); border-radius: 8px; padding: .65rem .9rem; color: var(--text-main); font-size: .9rem; font-family: inherit; transition: border-color .15s; }
        .form-control:focus { outline: none; border-color: var(--primary); }
        select.form-control { cursor: pointer; }
        textarea.form-control { resize: vertical; min-height: 120px; }

        /* Badges */
        .badge { display: inline-flex; align-items: center; padding: .25rem .65rem; border-radius: 999px; font-size: .75rem; font-weight: 600; }
        .badge-published { background: rgba(16,185,129,.15); color: #10b981; }
        .badge-draft     { background: rgba(245,158,11,.15); color: #f59e0b; }
        .badge-archived  { background: rgba(100,116,139,.15); color: #64748b; }
        .badge-admin     { background: rgba(239,68,68,.15); color: #ef4444; }
        .badge-editor    { background: rgba(59,130,246,.15); color: #60a5fa; }
        .badge-viewer    { background: rgba(100,116,139,.15); color: #94a3b8; }
        .badge-green     { background: rgba(16,185,129,.15); color: #10b981; }
        .badge-gray     { background: rgba(100,116,139,.15); color: #94a3b8; }

        /* Alert */
        .flash-success { background: rgba(16,185,129,.1); border: 1px solid rgba(16,185,129,.2); color: #10b981; padding: .85rem 1rem; border-radius: 10px; margin-bottom: 1.25rem; font-size: .9rem; }
        .flash-error   { background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.2); color: #f87171; padding: .85rem 1rem; border-radius: 10px; margin-bottom: 1.25rem; font-size: .9rem; }

        /* Page header */
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.75rem; }
        .page-header h1 { font-size: 1.4rem; font-weight: 700; color: var(--text-header); }
        .page-header p { font-size: .875rem; color: var(--text-muted); margin-top: .2rem; }

        /* Two col */
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
        .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem; }
 
        .sidebar { transform: translateX(0); transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 90; backdrop-filter: blur(2px); }
        .hamburger-btn { display: none; background: transparent; border: none; font-size: 1.25rem; color: #f1f5f9; cursor: pointer; padding: .2rem; margin-top: -3px; }
        .admin-table-container { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }

        @media(max-width:768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .sidebar-overlay.show { display: block; }
            .main { margin-left: 0; }
            .grid-2, .grid-3 { grid-template-columns: 1fr; }
            .hamburger-btn { display: block; }
            .content { padding: 1rem; }
            .page-header { flex-direction: column; align-items: flex-start; gap: 1rem; }
            .page-header .btn { width: 100%; justify-content: center; }
            .admin-card { padding: 1rem; }
            .admin-table { font-size: .8rem; }
            .admin-table th, .admin-table td { padding: .5rem; }
            .topbar { padding: .75rem 1rem; }
            .topbar-right { gap: .5rem; }
            .topbar-link { padding: .35rem .6rem; font-size: .75rem; }
            .stats-grid { grid-template-columns: 1fr 1fr; gap: .75rem; }
            .stat-card { padding: 1rem; }
            .stat-card .stat-value { font-size: 1.5rem; }
            .delete-modal { padding: 1.5rem; }
            .delete-modal-actions { flex-direction: column; }
            .delete-modal-actions .btn { width: 100%; }
        }
        
        @media(max-width:480px) {
            .stats-grid { grid-template-columns: 1fr; }
            .page-header h1 { font-size: 1.2rem; }
            .btn { padding: .6rem 1rem; font-size: .8rem; }
        }

        /* Delete Modal Styles */
        .modal-backdrop { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.7); backdrop-filter: blur(4px); z-index: 10000; align-items: center; justify-content: center; padding: 1rem; }
        .modal-backdrop.show { display: flex; }
        .delete-modal { background: var(--bg-card); border-radius: 20px; width: 400px; max-width: 100%; border: 1px solid var(--border-subtle); padding: 2rem; text-align: center; transform: scale(.9); transition: transform .2s ease; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); }
        .modal-backdrop.show .delete-modal { transform: scale(1); }
        .delete-modal-icon { width: 64px; height: 64px; background: rgba(239,68,68,.1); color: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1.5rem; }
        .delete-modal h3 { color: var(--text-header); font-size: 1.25rem; font-weight: 700; margin-bottom: .75rem; }
        .delete-modal p { color: var(--text-muted); font-size: .9rem; margin-bottom: 2rem; line-height: 1.5; }
        .delete-modal-actions { display: flex; gap: 1rem; }
        .delete-modal-actions .btn { flex: 1; justify-content: center; padding: .75rem; }
    </style>
    @stack('styles')
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

@php
$siteLogo = \App\Models\Setting::get('site_logo');
$logoSrc = $siteLogo && (str_starts_with($siteLogo, 'http') || str_starts_with($siteLogo, '//')) ? $siteLogo : ($siteLogo ? asset('storage/' . $siteLogo) : null);
@endphp

<aside class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('home') }}" class="sidebar-logo" style="text-decoration:none;">
            @if($logoSrc)
                <img src="{{ $logoSrc }}" alt="Logo" style="height:40px;width:auto;max-width:80px;border-radius:10px;object-fit:contain;">
            @else
                <img src="{{ asset('images/icon.svg') }}" alt="Logo" style="height:40px;width:40px;border-radius:10px;object-fit:cover;">
            @endif
            <div>
                <span class="name">{{ \App\Models\Setting::get('site_name', 'ProGuidePh') }}</span>
                <span class="sub">Admin Panel</span>
            </div>
        </a>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">Overview</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="icon">📊</span> Dashboard
        </a>
        <a href="{{ route('admin.system') }}" class="nav-item {{ request()->routeIs('admin.system') ? 'active' : '' }}">
            <span class="icon">⚙️</span> System
        </a>

        <div class="nav-section">Content</div>
        <a href="{{ route('admin.posts.index') }}" class="nav-item {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
            <span class="icon">📝</span> Posts
        </a>
        <a href="{{ route('admin.categories.index') }}" class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <span class="icon">🏷️</span> Categories
        </a>
        <a href="{{ route('admin.pages.index') }}" class="nav-item {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
            <span class="icon">📄</span> Pages
        </a>

        <div class="nav-section">Community</div>
        <a href="{{ route('admin.comments.index') }}" class="nav-item {{ request()->routeIs('admin.comments.*') ? 'active' : '' }}">
            <span class="icon">💬</span> Comments
            @php $pending = \App\Models\Comment::where('is_approved', false)->count(); @endphp
            @if($pending > 0)
                <span class="nav-badge">{{ $pending }}</span>
            @endif
        </a>
        <a href="{{ route('admin.announcements.index') }}" class="nav-item {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
            <span class="icon">📢</span> Announcements
        </a>
        <a href="{{ route('admin.forum.topics') }}" class="nav-item {{ request()->routeIs('admin.forum.*') ? 'active' : '' }}">
            <span class="icon">💬</span> Forum
        </a>

        <div class="nav-section">Admin</div>
        <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <span class="icon">👥</span> Users
        </a>
        <a href="{{ route('admin.settings.index') }}" class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <span class="icon">⚙️</span> Settings
        </a>

        <div style="padding: 1rem 1.25rem; margin-top: 1rem; border-top: 1px solid rgba(255,255,255,.06);">
            <a href="{{ route('home') }}" class="nav-item" style="border-radius: 8px;">
                <span class="icon">🌐</span> View Website
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-item" style="width:100%; background:none; border:none; cursor:pointer; color:#94a3b8; border-radius:8px;">
                    <span class="icon">🚪</span> Logout
                </button>
            </form>
        </div>
    </nav>
</aside>

<div class="main">
    <div class="topbar">
        <div class="topbar-title" style="display:flex;align-items:center;gap:.75rem;">
            <button class="hamburger-btn" onclick="toggleSidebar()">☰</button>
            @yield('title', 'Dashboard')
        </div>
        <div class="topbar-right">
            <button onclick="toggleTheme()" class="topbar-link" style="border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;width:34px;height:34px;padding:0;" title="Toggle Theme">
                <span id="themeIcon">🌙</span>
            </button>
            <a href="{{ route('home') }}" class="topbar-link">🌐 View Site</a>
            <div style="display:flex;align-items:center;gap:.6rem;padding:.35rem .75rem;background:var(--nav-hover);border-radius:8px;cursor:pointer;" onclick="toggleUserMenu()">
                <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" style="width:28px;height:28px;border-radius:50%;border:2px solid var(--border-subtle);">
                <span style="font-size:.8rem;font-weight:500;color:var(--text-main);">{{ auth()->user()->name }}</span>
                <span style="font-size:.7rem;color:var(--text-muted);">▼</span>
            </div>
            <div id="userDropdown" style="display:none;position:absolute;top:60px;right:1.75rem;background:var(--bg-card);border:1px solid var(--border-subtle);border-radius:12px;padding:.5rem;min-width:180px;box-shadow:0 10px 30px rgba(0,0,0,.2);z-index:100;">
                <div style="padding:.5rem .75rem;border-bottom:1px solid var(--border-subtle);margin-bottom:.5rem;">
                    <div style="font-weight:600;font-size:.875rem;color:var(--text-header);">{{ auth()->user()->name }}</div>
                    <div style="font-size:.75rem;color:var(--text-muted);">{{ auth()->user()->email }}</div>
                </div>
                <a href="{{ route('admin.users.index') }}" style="display:flex;align-items:center;gap:.5rem;padding:.5rem .75rem;border-radius:8px;font-size:.85rem;color:var(--text-main);transition:background 0.15s;" onmouseover="this.style.background='var(--nav-hover)'" onmouseout="this.style.background='transparent'">
                    👤 Manage Users
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="width:100%;display:flex;align-items:center;gap:.5rem;padding:.5rem .75rem;border-radius:8px;font-size:.85rem;color:#ef4444;background:none;border:none;cursor:pointer;text-align:left;transition:background 0.15s;" onmouseover="this.style.background='rgba(239,68,68,0.1)'" onmouseout="this.style.background='transparent'">
                        🚪 Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="content">
        @if(session('success'))
            <div class="flash-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="flash-error">❌ {{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div id="deleteConfirmModal" class="modal-backdrop">
    <div class="delete-modal">
        <div class="delete-modal-icon">🗑</div>
        <h3 id="deleteModalTitle">Are you sure?</h3>
        <p id="deleteModalMessage">This action cannot be undone. This will permanently delete the selected item.</p>
        <div class="delete-modal-actions">
            <button type="button" class="btn btn-ghost" onclick="closeDeleteModal()">Cancel</button>
            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Yes, Delete</button>
        </div>
    </div>
</div>

<form id="globalDeleteForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<script>
    let pendingDeleteFormId = null;

    function openDeleteModal(formId, message = null) {
        pendingDeleteFormId = formId;
        if(message) document.getElementById('deleteModalMessage').innerText = message;
        document.getElementById('deleteConfirmModal').classList.add('show');
    }

    function closeDeleteModal() {
        document.getElementById('deleteConfirmModal').classList.remove('show');
        pendingDeleteFormId = null;
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if(pendingDeleteFormId) {
            document.getElementById(pendingDeleteFormId).submit();
        }
    });

    function toggleSidebar() {
        document.querySelector('.sidebar').classList.toggle('show');
        document.getElementById('sidebarOverlay').classList.toggle('show');
    }

    function toggleTheme() {
        const root = document.documentElement;
        const body = document.body;
        const icon = document.getElementById('themeIcon');
        const isLight = root.classList.toggle('light-mode');
        
        localStorage.setItem('admin-theme', isLight ? 'light' : 'dark');
        icon.innerText = isLight ? '☀️' : '🌙';
    }
    
    function toggleUserMenu() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
    }
    
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('userDropdown');
        const trigger = e.target.closest('[onclick="toggleUserMenu()"]');
        if (!trigger && dropdown.style.display === 'block') {
            dropdown.style.display = 'none';
        }
    });

    // Initialize theme icon on load
    document.addEventListener('DOMContentLoaded', function() {
        const savedTheme = localStorage.getItem('admin-theme') || 'dark';
        const icon = document.getElementById('themeIcon');
        if (savedTheme === 'light') {
            document.documentElement.classList.add('light-mode'); // Double check
            icon.innerText = '☀️';
        } else {
            icon.innerText = '🌙';
        }
    });

    // intersection observer for admin
    document.addEventListener('DOMContentLoaded', function() {
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal-admin').forEach(el => obs.observe(el));
    });
</script>

@stack('scripts')
</body>
</html>
