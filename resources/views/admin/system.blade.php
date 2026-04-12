@extends('layouts.admin')

@section('title', 'System Monitoring')

@section('content')

<div class="page-header">
    <div>
        <h1>System Monitoring</h1>
        <p>Complete system overview, performance, and security metrics.</p>
    </div>
    <form action="{{ route('admin.system.clear-cache') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-secondary" onclick="return confirm('Clear all cache?')">Clear Cache</button>
    </form>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Stats Overview --}}
<div class="stats-grid">
    <div class="stat-card blue reveal-admin">
        <div class="stat-label">PHP Version</div>
        <div class="stat-value">{{ $systemStats['php_version'] }}</div>
        <div class="stat-icon">🐘</div>
    </div>
    <div class="stat-card green reveal-admin delay-1">
        <div class="stat-label">Laravel</div>
        <div class="stat-value">{{ $systemStats['laravel_version'] }}</div>
        <div class="stat-icon">🚀</div>
    </div>
    <div class="stat-card amber reveal-admin delay-2">
        <div class="stat-label">Database</div>
        <div class="stat-value">{{ $dbStats['database_size'] ?? 'N/A' }}</div>
        <div class="stat-icon">💾</div>
    </div>
    <div class="stat-card purple reveal-admin delay-3">
        <div class="stat-label">Storage</div>
        <div class="stat-value">{{ $diskStats['storage_size'] }}</div>
        <div class="stat-icon">📦</div>
    </div>
    <div class="stat-card red reveal-admin delay-4">
        <div class="stat-label">Failed Logins (24h)</div>
        <div class="stat-value" style="color:{{ $securityStats['failed_logins_24h'] > 5 ? '#ef4444' : '#22c55e'}}">
            {{ $securityStats['failed_logins_24h'] }}
        </div>
        <div class="stat-icon">🔒</div>
    </div>
    <div class="stat-card blue reveal-admin delay-5">
        <div class="stat-label">Failed This Week</div>
        <div class="stat-value">{{ $securityStats['failed_logins_week'] }}</div>
        <div class="stat-icon">⚠️</div>
    </div>
</div>

{{-- Content & User Stats --}}
<div class="grid-2">
    <div class="admin-card reveal-admin">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem">
            <h3 style="font-size:1rem;font-weight:700;color:var(--text-header)">📝 Content Statistics</h3>
        </div>
        <div class="admin-table-container">
            <table class="admin-table">
                <tbody>
                    <tr>
                        <td style="color:var(--text-muted)">Total Posts</td>
                        <td style="font-weight:600;color:var(--text-header)">{{ $contentStats['total_posts'] }}</td>
                    </tr>
                    <tr>
                        <td style="color:var(--text-muted)">Published</td>
                        <td style="font-weight:600;color:#22c55e">{{ $contentStats['published_posts'] }}</td>
                    </tr>
                    <tr>
                        <td style="color:var(--text-muted)">Drafts</td>
                        <td style="font-weight:600;color:#f59e0b">{{ $contentStats['draft_posts'] }}</td>
                    </tr>
                    <tr>
                        <td style="color:var(--text-muted)">Total Views</td>
                        <td style="font-weight:600;color:var(--text-header)">{{ number_format($contentStats['total_views']) }}</td>
                    </tr>
                    <tr>
                        <td style="color:var(--text-muted)">Pending Comments</td>
                        <td style="font-weight:600;color:{{ $contentStats['pending_comments'] > 0 ? '#ef4444' : 'var(--text-header)' }}">
                            {{ $contentStats['pending_comments'] }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="admin-card reveal-admin delay-1">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem">
            <h3 style="font-size:1rem;font-weight:700;color:var(--text-header)">👥 User Statistics</h3>
        </div>
        <div class="admin-table-container">
            <table class="admin-table">
                <tbody>
                    <tr>
                        <td style="color:var(--text-muted)">Total Users</td>
                        <td style="font-weight:600;color:var(--text-header)">{{ $userStats['total_users'] }}</td>
                    </tr>
                    <tr>
                        <td style="color:var(--text-muted)">Admins</td>
                        <td style="font-weight:600;color:#22c55e">{{ $userStats['admin_users'] }}</td>
                    </tr>
                    <tr>
                        <td style="color:var(--text-muted)">Verified Users</td>
                        <td style="font-weight:600;color:var(--text-header)">{{ $userStats['verified_users'] }}</td>
                    </tr>
                    <tr>
                        <td style="color:var(--text-muted)">New (7 days)</td>
                        <td style="font-weight:600;color:#f59e0b">{{ $userStats['recent_registrations'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Server & PHP --}}
<div class="grid-2">
    <div class="admin-card reveal-admin">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem">
            <h3 style="font-size:1rem;font-weight:700;color:var(--text-header)">🖥️ Server Info</h3>
            <span class="badge badge-success">Online</span>
        </div>
        <div class="admin-table-container">
            <table class="admin-table">
                <tbody>
                    <tr>
                        <td style="color:var(--text-muted)">Server</td>
                        <td style="font-weight:600;color:var(--text-header)">{{ $systemStats['server_software'] }}</td>
                    </tr>
                    <tr>
                        <td style="color:var(--text-muted)">OS</td>
                        <td style="font-weight:600;color:var(--text-header)">{{ $systemStats['os'] }}</td>
                    </tr>
                    <tr>
                        <td style="color:var(--text-muted)">Timezone</td>
                        <td style="font-weight:600;color:var(--text-header)">{{ $systemStats['timezone'] }}</td>
                    </tr>
                    <tr>
                        <td style="color:var(--text-muted)">Current Time</td>
                        <td style="font-weight:600;color:var(--text-header)">{{ $systemStats['current_time'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="admin-card reveal-admin delay-1">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem">
            <h3 style="font-size:1rem;font-weight:700;color:var(--text-header)">⚡ PHP Settings</h3>
        </div>
        <div class="admin-table-container">
            <table class="admin-table">
                <tbody>
                    <tr>
                        <td style="color:var(--text-muted)">Memory Limit</td>
                        <td style="font-weight:600;color:var(--text-header)">{{ $systemStats['memory_limit'] }}</td>
                    </tr>
                    <tr>
                        <td style="color:var(--text-muted)">Memory Used</td>
                        <td style="font-weight:600;color:var(--text-header)">{{ $systemStats['memory_used'] }}</td>
                    </tr>
                    <tr>
                        <td style="color:var(--text-muted)">Max Execution</td>
                        <td style="font-weight:600;color:var(--text-header)">{{ $systemStats['max_execution_time'] }}s</td>
                    </tr>
                    <tr>
                        <td style="color:var(--text-muted)">Upload Size</td>
                        <td style="font-weight:600;color:var(--text-header)">{{ $systemStats['upload_max_filesize'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- App Config & Security --}}
<div class="grid-2">
    <div class="admin-card reveal-admin">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem">
            <h3 style="font-size:1rem;font-weight:700;color:var(--text-header)">⚙️ Application Config</h3>
        </div>
        <div class="admin-table-container">
            <table class="admin-table">
                <tbody>
                    <tr>
                        <td style="color:var(--text-muted)">Environment</td>
                        <td>
                            <span class="badge badge-{{ $systemStats['app_env'] === 'production' ? 'success' : 'warning' }}">
                                {{ $systemStats['app_env'] }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="color:var(--text-muted)">Debug Mode</td>
                        <td>
                            <span class="badge badge-{{ $systemStats['app_debug'] === 'true' ? 'danger' : 'success' }}">
                                {{ $systemStats['app_debug'] }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="color:var(--text-muted)">Cache Driver</td>
                        <td style="font-weight:600;color:var(--text-header)">{{ $cacheStats['driver'] }}</td>
                    </tr>
                    <tr>
                        <td style="color:var(--text-muted)">Cache Prefix</td>
                        <td style="font-weight:600;color:var(--text-header)">{{ $cacheStats['prefix'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="admin-card reveal-admin delay-1">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem">
            <h3 style="font-size:1rem;font-weight:700;color:var(--text-header)">🔐 Security Overview</h3>
        </div>
        <div class="admin-table-container">
            <table class="admin-table">
                <tbody>
                    <tr>
                        <td style="color:var(--text-muted)">Failed Logins (24h)</td>
                        <td style="font-weight:600;color:{{ $securityStats['failed_logins_24h'] > 5 ? '#ef4444' : '#22c55e'}}">
                            {{ $securityStats['failed_logins_24h'] }}
                        </td>
                    </tr>
                    <tr>
                        <td style="color:var(--text-muted)">Failed This Week</td>
                        <td style="font-weight:600;color:{{ $securityStats['failed_logins_week'] > 10 ? '#ef4444' : 'var(--text-header)'}}">
                            {{ $securityStats['failed_logins_week'] }}
                        </td>
                    </tr>
                    <tr>
                        <td style="color:var(--text-muted)">Total Login Attempts</td>
                        <td style="font-weight:600;color:var(--text-header)">{{ $securityStats['total_logins'] }}</td>
                    </tr>
                    <tr>
                        <td style="color:var(--text-muted)">Tables</td>
                        <td style="font-weight:600;color:var(--text-header)">{{ $dbStats['total_tables'] ?? 0 }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Disk Usage --}}
<div class="admin-card">
    <h3 style="font-size:1rem;font-weight:700;color:var(--text-header);margin-bottom:1rem">💽 Disk Usage</h3>
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Location</th>
                    <th>Size</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="color:var(--text-muted)">Application</td>
                    <td style="font-weight:600;color:var(--text-header)">{{ $diskStats['app_size'] }}</td>
                </tr>
                <tr>
                    <td style="color:var(--text-muted)">Storage</td>
                    <td style="font-weight:600;color:var(--text-header)">{{ $diskStats['storage_size'] }}</td>
                </tr>
                <tr>
                    <td style="color:var(--text-muted)">Logs</td>
                    <td style="font-weight:600;color:var(--text-header)">{{ $diskStats['logs_size'] }}</td>
                </tr>
                <tr>
                    <td style="color:var(--text-muted)">Cache</td>
                    <td style="font-weight:600;color:var(--text-header)">{{ $diskStats['bootstrap_cache'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- Recent Errors --}}
@if($recentErrors->isNotEmpty())
<div class="admin-card">
    <h3 style="font-size:1rem;font-weight:700;color:var(--text-header);margin-bottom:1rem">⚠️ Recent Errors</h3>
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Error</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentErrors as $error)
                <tr>
                    <td style="color:#ef4444;font-weight:500">{{ Str::limit($error['message'], 50) }}</td>
                    <td style="color:var(--text-muted)">{{ $error['date'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Login Activity --}}
<div class="admin-card">
    <h3 style="font-size:1rem;font-weight:700;color:var(--text-header);margin-bottom:1rem">📋 Recent Login Activity</h3>
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>IP</th>
                    <th>Device</th>
                    <th>Status</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @forelse($loginLogs as $log)
                <tr>
                    <td style="font-weight:500">{{ $log->email }}</td>
                    <td style="color:var(--text-muted)">{{ $log->ip_address }}</td>
                    <td style="color:var(--text-muted)">{{ Str::limit($log->user_agent, 20) }}</td>
                    <td>
                        @if($log->success)
                            <span class="badge badge-success">Logged In</span>
                        @elseif($log->failure_reason === 'Logout')
                            <span class="badge" style="background:#7c3aed;color:#fff">Logged Out</span>
                        @else
                            <span class="badge badge-danger">Failed</span>
                        @endif
                    </td>
                    <td style="color:var(--text-muted)">{{ $log->created_at }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;color:var(--text-muted);padding:2rem">No activity</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection