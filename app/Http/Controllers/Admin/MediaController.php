<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::latest()->get();
        return view('admin.media.index', compact('media'));
    }

    public function store(Request $request)
    {
        if (!$request->hasFile('files')) {
            return back()->with('error', 'No file selected');
        }

        $uploaded = 0;
        
        $files = $request->file('files');
        
        if (!is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $file) {
            if (!$file || !$file->isValid()) {
                continue;
            }
            
            $originalName = $file->getClientOriginalName();
            $extension = strtolower($file->getClientOriginalExtension() ?: 'jpg');
            $baseName = pathinfo($originalName, PATHINFO_FILENAME);
            $newFilename = time() . '_' . substr(md5($baseName), 0, 6) . '.' . $extension;
            
            $path = $file->storeAs('uploads', $newFilename, 'public');
            
            $fullPath = public_path($path);
            $fileSize = file_exists($fullPath) ? filesize($fullPath) : $file->getSize();
            
            Media::create([
                'user_id' => auth()->id(),
                'filename' => $newFilename,
                'original_name' => $originalName,
                'path' => $path,
                'url' => '/' . $path,
                'mime_type' => $file->getMimeType() ?: 'image/jpeg',
                'size' => $fileSize,
                'disk' => 'public',
            ]);
            
            $uploaded++;
        }

        return back()->with('success', $uploaded . ' file(s) uploaded!');
    }

    public function destroy(Media $medium)
    {
        $path = public_path($medium->path);
        if (file_exists($path)) {
            unlink($path);
        }
        $medium->delete();
        return back()->with('success', 'File deleted!');
    }
}