<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SystemController extends Controller
{
    public function index()
    {
        $dbStats = $this->getDatabaseStats();
        $systemStats = $this->getSystemStats();
        $cacheStats = $this->getCacheStats();
        $diskStats = $this->getDiskStats();
        $contentStats = $this->getContentStats();
        $userStats = $this->getUserStats();
        $securityStats = $this->getSecurityStats();
        $loginLogs = $this->getRecentLoginLogs();
        $recentErrors = $this->getRecentErrors();
        
        return view('admin.system', compact(
            'dbStats', 'systemStats', 'cacheStats', 'diskStats', 
            'contentStats', 'userStats', 'securityStats',
            'loginLogs', 'recentErrors'
        ));
    }
    
    public function clearCache()
    {
        Cache::flush();
        return redirect()->route('admin.system')->with('success', 'Cache cleared successfully!');
    }
    
    private function getDatabaseStats()
    {
        try {
            $tables = DB::select('SHOW TABLE STATUS');
            $totalSize = 0;
            foreach ($tables as $table) {
                $totalSize += $table->Data_length + $table->Index_length;
            }
            
            return [
                'database_size' => $this->formatBytes($totalSize),
                'total_tables' => count($tables),
                'connections' => DB::table('login_logs')->count(),
                'connected' => true,
            ];
        } catch (\Exception $e) {
            return [
                'connected' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
    
    private function getSystemStats()
    {
        return [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'os' => PHP_OS,
            'current_time' => now()->format('Y-m-d H:i:s'),
            'timezone' => config('app.timezone'),
            'max_execution_time' => ini_get('max_execution_time'),
            'memory_limit' => ini_get('memory_limit'),
            'memory_used' => $this->formatBytes(memory_get_usage(true)),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size'),
            'app_env' => config('app.env'),
            'app_debug' => config('app.debug') ? 'true' : 'false',
        ];
    }
    
    private function getCacheStats()
    {
        return [
            'driver' => config('cache.default'),
            'prefix' => config('cache.prefix'),
        ];
    }
    
    private function getDiskStats()
    {
        $basePath = base_path();
        $storagePath = storage_path();
        
        return [
            'app_size' => $this->formatBytes($this->getDirectorySize($basePath)),
            'storage_size' => $this->formatBytes($this->getDirectorySize($storagePath)),
            'logs_size' => $this->formatBytes($this->getDirectorySize(storage_path('logs'))),
            'bootstrap_cache' => $this->formatBytes($this->getDirectorySize(storage_path('framework/cache'))),
        ];
    }
    
    private function getContentStats()
    {
        return [
            'total_posts' => Post::count(),
            'published_posts' => Post::where('status', 'published')->count(),
            'draft_posts' => Post::where('status', 'draft')->count(),
            'total_comments' => Comment::count(),
            'pending_comments' => Comment::where('is_approved', false)->count(),
            'total_views' => Post::sum('views'),
        ];
    }
    
    private function getUserStats()
    {
        return [
            'total_users' => User::count(),
            'admin_users' => User::where('is_admin', true)->count(),
            'verified_users' => User::whereNotNull('email_verified_at')->count(),
            'recent_registrations' => User::where('created_at', '>=', now()->subDays(7))->count(),
        ];
    }
    
    private function getSecurityStats()
    {
        $failedLogins = DB::table('login_logs')
            ->where('success', false)
            ->where('failure_reason', '!=', 'Logout')
            ->where('created_at', '>=', now()->subHours(24))
            ->count();
            
        $failedLoginsWeek = DB::table('login_logs')
            ->where('success', false)
            ->where('failure_reason', '!=', 'Logout')
            ->where('created_at', '>=', now()->subDays(7))
            ->count();
            
        return [
            'failed_logins_24h' => $failedLogins,
            'failed_logins_week' => $failedLoginsWeek,
            'total_logins' => DB::table('login_logs')->count(),
        ];
    }
    
    private function getRecentLoginLogs()
    {
        return DB::table('login_logs')
            ->orderByDesc('created_at')
            ->take(15)
            ->get();
    }
    
    private function getRecentErrors()
    {
        $logFiles = [
            storage_path('logs/laravel.log'),
            storage_path('logs/laravel-' . date('Y-m-d') . '.log'),
        ];
        
        $errors = [];
        foreach ($logFiles as $file) {
            if (File::exists($file)) {
                $content = File::get($file);
                $lines = explode("\n", $content);
                foreach (array_reverse($lines) as $line) {
                    if (stripos($line, 'ERROR') !== false || stripos($line, 'EXCEPTION') !== false) {
                        $errors[] = [
                            'message' => trim($line),
                            'date' => date('Y-m-d H:i:s', filemtime($file)),
                        ];
                        if (count($errors) >= 10) break;
                    }
                }
            }
        }
        
        return collect($errors)->take(10);
    }
    
    private function getDirectorySize($path)
    {
        if (!File::exists($path)) return 0;
        
        $size = 0;
        if (is_dir($path)) {
            foreach (File::allFiles($path) as $file) {
                $size += $file->getSize();
            }
        }
        return $size;
    }
    
    private function formatBytes($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));
        return round($bytes, 2) . ' ' . $units[$pow];
    }
}