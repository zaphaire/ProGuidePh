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
            'files.*' => 'max:5120',
        ]);

        $count = 0;
        
        foreach ($request->file('files') as $file) {
            $original = $file->getClientOriginalName();
            $ext = pathinfo($original, PATHINFO_EXTENSION);
            $base = pathinfo($original, PATHINFO_FILENAME);
            $filename = time() . '_' . substr(md5($base), 0, 8) . ($ext ? '.' . $ext : '');
            
            $path = $file->storeAs('', $filename, 'public');
            
            Media::create([
                'user_id' => auth()->id(),
                'filename' => $filename,
                'original_name' => $original,
                'path' => $path,
                'url' => Storage::disk('public')->url($path),
                'mime_type' => $file->getMimeType() ?: 'application/octet-stream',
                'size' => $file->getSize(),
                'disk' => 'public',
            ]);
            
            $count++;
        }
        
        return back()->with('success', $count . ' file(s) uploaded!');

        return back()->with('success', count($request->file('files')) . ' file(s) uploaded!');
    }

    public function destroy(Media $medium)
    {
        Storage::disk('public')->delete($medium->path);
        $medium->delete();
        return back()->with('success', 'File deleted!');
    }
}