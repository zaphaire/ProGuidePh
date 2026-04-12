<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $count = 0;
        $files = $request->file('files');
        
        if (!is_array($files)) {
            $files = [$files];
        }
        
        foreach ($files as $file) {
            if (!$file) continue;
            
            $path = $file->store('uploads', 'public');
            
            Media::create([
                'user_id' => Auth::id(),
                'filename' => basename($path),
                'original_name' => $file->getClientOriginalName(),
                'path' => $path,
                'url' => '/storage/' . $path,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'disk' => 'public',
            ]);
            $count++;
        }

        return back()->with('success', $count . ' file(s) uploaded!');
    }

    public function destroy(Media $medium)
    {
        if ($medium->path && \Storage::disk('public')->exists($medium->path)) {
            \Storage::disk('public')->delete($medium->path);
        }
        $medium->delete();
        return back()->with('success', 'File deleted');
    }
}