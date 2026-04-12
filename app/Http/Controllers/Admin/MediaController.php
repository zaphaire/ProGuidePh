<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::latest()->get();
        return view('admin.media.index', compact('media'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'files' => 'required',
        ]);

        $publicDir = public_path('uploads');
        
        if (!File::exists($publicDir)) {
            File::makeDirectory($publicDir, 0755, true);
        }

        $count = 0;
        
        foreach ($request->file('files') as $file) {
            if (!$file || !$file->isValid()) {
                continue;
            }
            
            $originalName = $file->getClientOriginalName();
            $baseName = pathinfo($originalName, PATHINFO_FILENAME);
            $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            
            $newFilename = time() . $count . '_' . substr(md5($baseName), 0, 6) . '.' . ($extension ?: 'jpg');
            
            $file->move($publicDir, $newFilename);
            
            Media::create([
                'user_id' => auth()->id(),
                'filename' => $newFilename,
                'original_name' => $originalName,
                'path' => 'uploads/' . $newFilename,
                'url' => '/uploads/' . $newFilename,
                'mime_type' => $file->getMimeType() ?: 'image/jpeg',
                'size' => filesize($publicDir . '/' . $newFilename),
                'disk' => 'public',
            ]);
            
            $count++;
        }

        if ($count > 0) {
            return back()->with('success', $count . ' file(s) uploaded!');
        }
        
        return back()->with('error', 'Upload failed. Please try again.');
    }

    public function destroy(Media $medium)
    {
        $filePath = public_path($medium->path);
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
        $medium->delete();
        return back()->with('success', 'File deleted!');
    }
}