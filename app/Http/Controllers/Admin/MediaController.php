<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::latest()->get();
        return view('admin.media.index', compact('media'));
    }

    public function store(Request $request)
    {
        $uploadDir = base_path('../public_html/uploads');
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
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
                    'user_id' => auth()->id(),
                    'filename' => $newName,
                    'original_name' => $name,
                    'path' => 'uploads/' . $newName,
                    'url' => '/uploads/' . $newName,
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
        $path = base_path('../public_html/' . $medium->path);
        if (file_exists($path)) {
            unlink($path);
        }
        $medium->delete();
        return back()->with('success', 'File deleted');
    }
}