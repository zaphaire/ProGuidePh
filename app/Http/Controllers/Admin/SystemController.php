<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class SystemController extends Controller
{
    public function index()
    {
        $dbStats = $this->getDatabaseStats();
        $systemStats = $this->getSystemStats();
        $cacheStats = $this->getCacheStats();
        $loginLogs = $this->getRecentLoginLogs();
        
        return view('admin.system', compact('dbStats', 'systemStats', 'cacheStats', 'loginLogs'));
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
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size'),
        ];
    }
    
    private function getCacheStats()
    {
        return [
            'driver' => config('cache.default'),
            'prefix' => config('cache.prefix'),
        ];
    }
    
    private function getRecentLoginLogs()
    {
        return DB::table('login_logs')
            ->orderByDesc('created_at')
            ->take(20)
            ->get();
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