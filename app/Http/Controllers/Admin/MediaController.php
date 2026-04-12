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
        $request->validate([
            'files' => 'required',
            'files.*' => 'file|max:5120',
        ]);

        foreach ($request->file('files') as $file) {
            $filename = time() . '_' . md5($file->getClientOriginalName()) . '.' . ($file->getClientOriginalExtension() ?: 'jpg');
            
            // Store directly in the media disk root (which is public/media)
            $path = $file->storeAs('', $filename, 'public');
            
            $fullPath = public_path('media/' . $path);
            
            Media::create([
                'user_id' => auth()->id(),
                'filename' => $filename,
                'original_name' => $file->getClientOriginalName(),
                'path' => $path,
                'url' => Storage::disk('public')->url($path),
                'mime_type' => $file->getMimeType() ?: 'image/jpeg',
                'size' => filesize($fullPath),
                'disk' => 'public',
            ]);
        }

        return back()->with('success', count($request->file('files')) . ' file(s) uploaded!');
    }

    public function destroy(Media $medium)
    {
        Storage::disk('public')->delete($medium->path);
        $medium->delete();
        return back()->with('success', 'File deleted!');
    }
}