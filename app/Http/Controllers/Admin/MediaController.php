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
        $media = Media::with('user')->latest()->paginate(24);
        return view('admin.media.index', compact('media'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'files'   => 'required',
            'files.*' => 'file|max:5120',
        ]);

        foreach ($request->file('files') as $file) {
            $path = $file->store('media', 'public');

            Media::create([
                'user_id'       => auth()->id(),
                'filename'      => basename($path),
                'original_name' => $file->getClientOriginalName(),
                'path'          => $path,
                'url'           => Storage::disk('public')->url($path),
                'mime_type'     => $file->getMimeType(),
                'size'          => $file->getSize(),
                'disk'          => 'public',
            ]);
        }

        return redirect()->route('admin.media.index')->with('success', 'Files uploaded successfully!');
    }

    public function destroy(Media $medium)
    {
        Storage::disk('public')->delete($medium->path);
        $medium->delete();

        return redirect()->route('admin.media.index')->with('success', 'File deleted!');
    }
}
