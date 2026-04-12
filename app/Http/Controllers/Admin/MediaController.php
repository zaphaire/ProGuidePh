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
            'files.*' => 'max:5120',
        ]);

        $publicDir = public_path('uploads');
        if (!File::exists($publicDir)) {
            File::makeDirectory($publicDir, 0755, true);
        }

        $count = 0;
        
        foreach ($request->file('files') as $file) {
            $original = $file->getClientOriginalName();
            $ext = pathinfo($original, PATHINFO_EXTENSION);
            $base = pathinfo($original, PATHINFO_FILENAME);
            $filename = time() . '_' . substr(md5($base), 0, 8) . ($ext ? '.' . $ext : '');
            
            $file->move($publicDir, $filename);
            
            $url = '/uploads/' . $filename;
            
            Media::create([
                'user_id' => auth()->id(),
                'filename' => $filename,
                'original_name' => $original,
                'path' => 'uploads/' . $filename,
                'url' => $url,
                'mime_type' => $file->getMimeType() ?: 'application/octet-stream',
                'size' => $file->getSize(),
                'disk' => 'public',
            ]);
            
            $count++;
        }
        
        return back()->with('success', $count . ' file(s) uploaded!');
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