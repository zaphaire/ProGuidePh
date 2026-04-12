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
            'files.*' => 'file|max:5120',
        ]);

        $uploadDir = public_path('storage/media');
        if (!File::exists($uploadDir)) {
            File::makeDirectory($uploadDir, 0755, true);
        }

        foreach ($request->file('files') as $file) {
            try {
                $originalName = $file->getClientOriginalName();
                $pathInfo = pathinfo($originalName);
                $extension = isset($pathInfo['extension']) ? $pathInfo['extension'] : 'jpg';
                
                $filename = time() . '_' . substr(md5(uniqid()), 0, 8) . '.' . $extension;
                
                $file->copy($uploadDir . '/' . $filename);
                
                $fileUrl = url('storage/media/' . $filename);
                
                Media::create([
                    'user_id' => auth()->id(),
                    'filename' => $filename,
                    'original_name' => $originalName,
                    'path' => 'media/' . $filename,
                    'url' => $fileUrl,
                    'mime_type' => 'image/jpeg',
                    'size' => $file->getSize(),
                    'disk' => 'public',
                ]);
            } catch (\Exception $e) {
                continue;
            }
        }

        return back()->with('success', 'Files uploaded!');
    }

    public function destroy(Media $medium)
    {
        $filePath = public_path('storage/' . $medium->path);
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
        $medium->delete();
        return back()->with('success', 'File deleted!');
    }
}