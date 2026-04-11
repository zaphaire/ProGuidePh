@extends('layouts.admin')

@section('title', 'System Monitoring')

@section('content')

<div class="page-header">
    <div>
        <h1>System Monitoring</h1>
        <p>Monitor your application performance and health.</p>
    </div>
    <form action="{{ route('admin.system.clear-cache') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-secondary" onclick="return confirm('Clear all cache?')">Clear Cache</button>
    </form>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="stats-grid">
    <div class="stat-card blue">
        <div class="stat-label">PHP Version</div>
        <div class="stat-value">{{ $systemStats['php_version'] }}</div>
    </div>
    <div class="stat-card green">
        <div class="stat-label">Laravel Version</div>
        <div class="stat-value">{{ $systemStats['laravel_version'] }}</div>
    </div>
    <div class="stat-card amber">
        <div class="stat-label">Database Size</div>
        <div class="stat-value">{{ $dbStats['database_size'] ?? 'N/A' }}</div>
    </div>
    <div class="stat-card purple">
        <div class="stat-label">Total Tables</div>
        <div class="stat-value">{{ $dbStats['total_tables'] ?? 0 }}</div>
    </div>
</div>

<div class="admin-grid">
    <div class="admin-card">
        <h3>Server Information</h3>
        <table class="table">
            <tr>
                <th>Server Software</th>
                <td>{{ $systemStats['server_software'] }}</td>
            </tr>
            <tr>
                <th>Operating System</th>
                <td>{{ $systemStats['os'] }}</td>
            </tr>
            <tr>
                <th>Timezone</th>
                <td>{{ $systemStats['timezone'] }}</td>
            </tr>
            <tr>
                <th>Current Time</th>
                <td>{{ $systemStats['current_time'] }}</td>
            </tr>
        </table>
    </div>

    <div class="admin-card">
        <h3>PHP Settings</h3>
        <table class="table">
            <tr>
                <th>Memory Limit</th>
                <td>{{ $systemStats['memory_limit'] }}</td>
            </tr>
            <tr>
                <th>Memory Used</th>
                <td>{{ $systemStats['memory_used'] }}</td>
            </tr>
            <tr>
                <th>Max Execution</th>
                <td>{{ $systemStats['max_execution_time'] }}s</td>
            </tr>
            <tr>
                <th>Upload Max Size</th>
                <td>{{ $systemStats['upload_max_filesize'] }}</td>
            </tr>
        </table>
    </div>
</div>

<div class="admin-grid">
    <div class="admin-card">
        <h3>Application Config</h3>
        <table class="table">
            <tr>
                <th>Environment</th>
                <td><span class="badge badge-{{ $systemStats['app_env'] === 'production' ? 'success' : 'warning' }}">{{ $systemStats['app_env'] }}</span></td>
            </tr>
            <tr>
                <th>Debug Mode</th>
                <td><span class="badge badge-{{ $systemStats['app_debug'] === 'true' ? 'danger' : 'success' }}">{{ $systemStats['app_debug'] }}</span></td>
            </tr>
            <tr>
                <th>Cache Driver</th>
                <td>{{ $cacheStats['driver'] }}</td>
            </tr>
            <tr>
                <th>Cache Prefix</th>
                <td>{{ $cacheStats['prefix'] }}</td>
            </tr>
        </table>
    </div>

    <div class="admin-card">
        <h3>Disk Usage</h3>
        <table class="table">
            <tr>
                <th>App Size</th>
                <td>{{ $diskStats['app_size'] }}</td>
            </tr>
            <tr>
                <th>Storage Size</th>
                <td>{{ $diskStats['storage_size'] }}</td>
            </tr>
            <tr>
                <th>Logs Size</th>
                <td>{{ $diskStats['logs_size'] }}</td>
            </tr>
            <tr>
                <th>Cache Size</th>
                <td>{{ $diskStats['bootstrap_cache'] }}</td>
            </tr>
        </table>
    </div>
</div>

@if($recentErrors->isNotEmpty())
<div class="admin-card">
    <h3>⚠️ Recent Errors</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Error Message</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentErrors as $error)
            <tr>
                <td class="text-red">{{ Str::limit($error['message'], 80) }}</td>
                <td>{{ $error['date'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<div class="admin-card">
    <h3>Recent Login Activity</h3>
    <table class="table">
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
                <td>{{ $log->email }}</td>
                <td>{{ $log->ip_address }}</td>
                <td>{{ Str::limit($log->user_agent, 30) }}</td>
                <td>
                    @if($log->success)
                        <span class="badge badge-success">Success</span>
                    @elseif($log->failure_reason === 'Logout')
                        <span class="badge badge-purple">Logged Out</span>
                    @else
                        <span class="badge badge-danger">Failed</span>
                    @endif
                </td>
                <td>{{ $log->created_at }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No login activity yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection