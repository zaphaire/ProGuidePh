<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::latest()->get();
        return view('admin.media.index', compact('media'));
    }

    public function store(Request $request)
    {
        $uploadDir = base_path('../public_html/public/uploads');
        
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                return back()->with('error', 'Cannot create upload directory. Please check folder permissions.');
            }
        }

        if (!is_writable($uploadDir)) {
            return back()->with('error', 'Upload directory is not writable. Please check folder permissions.');
        }
        
        $count = 0;
        $files = $request->file('files');
        
        if (!is_array($files)) {
            $files = [$files];
        }
        
        foreach ($files as $file) {
            if (!$file) continue;
            
            $name = $file->getClientOriginalName();
            $ext = strtolower($file->getClientOriginalExtension() ?: 'jpg');
            $base = pathinfo($name, PATHINFO_FILENAME);
            $newName = time() . '_' . substr(md5($base), 0, 6) . '.' . $ext;
            
            $fullPath = $uploadDir . '/' . $newName;
            
                if (copy($file->getPathname(), $fullPath)) {
                Media::create([
                    'user_id' => Auth::id(),
                    'filename' => $newName,
                    'original_name' => $name,
                    'path' => 'public/uploads/' . $newName,
                    'url' => '/public/uploads/' . $newName,
                    'mime_type' => 'image/jpeg',
                    'size' => filesize($fullPath),
                    'disk' => 'public',
                ]);
                $count++;
            }
        }

        return back()->with('success', $count . ' file(s) uploaded!');
    }

    public function destroy(Media $medium)
    {
        $path = base_path('../public_html/public/' . $medium->path);
        if (file_exists($path)) {
            unlink($path);
        }
        $medium->delete();
        return back()->with('success', 'File deleted');
    }
}