@extends('layouts.admin')

@section('title', 'System Monitoring')

@section('content')

<div class="page-header">
    <div>
        <h1>System Monitoring</h1>
        <p>Monitor your application performance, health, and security.</p>
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
        <div class="stat-label">Database Size</div>
        <div class="stat-value">{{ $dbStats['database_size'] ?? 'N/A' }}</div>
        <div class="stat-icon">💾</div>
    </div>
    <div class="stat-card purple reveal-admin delay-3">
        <div class="stat-label">Storage</div>
        <div class="stat-value">{{ $diskStats['storage_size'] }}</div>
        <div class="stat-icon">📦</div>
    </div>
    <div class="stat-card red reveal-admin delay-4">
        <div class="stat-label">App Size</div>
        <div class="stat-value">{{ $diskStats['app_size'] }}</div>
        <div class="stat-icon">📁</div>
    </div>
    <div class="stat-card blue reveal-admin delay-5">
        <div class="stat-label">Tables</div>
        <div class="stat-value">{{ $dbStats['total_tables'] ?? 0 }}</div>
        <div class="stat-icon">🔢</div>
    </div>
</div>

{{-- System Details Grid --}}
<div class="grid-2">
    <div class="admin-card reveal-admin">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem">
            <h3 style="font-size:1rem;font-weight:700;color:var(--text-header)">Server Information</h3>
            <span class="badge badge-success">Online</span>
        </div>
        <div class="admin-table-container">
            <table class="admin-table">
                <tbody>
                    <tr>
                        <td style="color:var(--text-muted)">Server Software</td>
                        <td style="font-weight:600;color:var(--text-header)">{{ $systemStats['server_software'] }}</td>
                    </tr>
                    <tr>
                        <td style="color:var(--text-muted)">Operating System</td>
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
            <h3 style="font-size:1rem;font-weight:700;color:var(--text-header)">PHP Settings</h3>
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
                        <td style="color:var(--text-muted)">Upload Max Size</td>
                        <td style="font-weight:600;color:var(--text-header)">{{ $systemStats['upload_max_filesize'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- App Config & Disk --}}
<div class="grid-2">
    <div class="admin-card reveal-admin">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem">
            <h3 style="font-size:1rem;font-weight:700;color:var(--text-header)">Application Config</h3>
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
            <h3 style="font-size:1rem;font-weight:700;color:var(--text-header)">Disk Usage</h3>
        </div>
        <div class="admin-table-container">
            <table class="admin-table">
                <tbody>
                    <tr>
                        <td style="color:var(--text-muted)">App Size</td>
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
</div>

{{-- Recent Errors --}}
@if($recentErrors->isNotEmpty())
<div class="admin-card">
    <h3 style="font-size:1rem;font-weight:700;color:var(--text-header);margin-bottom:1rem">⚠️ Recent Errors</h3>
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="color:var(--text-muted)">Error</th>
                    <th style="color:var(--text-muted)">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentErrors as $error)
                <tr>
                    <td style="color:#ef4444;font-weight:500">{{ Str::limit($error['message'], 60) }}</td>
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
    <h3 style="font-size:1rem;font-weight:700;color:var(--text-header);margin-bottom:1rem">Recent Login Activity</h3>
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>IP Address</th>
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
                    <td style="color:var(--text-muted)">{{ Str::limit($log->user_agent, 25) }}</td>
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
                    <td colspan="5" style="text-align:center;color:var(--text-muted);padding:2rem">No login activity yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection