<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::with('user')->latest()->get();
        $totalMedia = Media::count();
        
        return view('admin.media.index', compact('media', 'totalMedia'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'files'   => 'required',
            'files.*' => 'file|max:5120',
        ]);

        $uploadedCount = 0;

        foreach ($request->file('files') as $file) {
            $mimeType = $file->getMimeType();
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $newFilename = time() . '_' . uniqid() . '.' . $extension;
            $path = $file->storeAs('media', $newFilename, 'public');
            
            Media::create([
                'user_id'       => auth()->id(),
                'filename'      => $newFilename,
                'original_name' => $originalName,
                'path'          => $path,
                'url'           => Storage::disk('public')->url($path),
                'mime_type'     => $mimeType,
                'size'          => $file->getSize(),
                'disk'          => 'public',
            ]);
            $uploadedCount++;
        }

        return redirect()->route('admin.media.index')->with('success', $uploadedCount . ' file(s) uploaded successfully!');
    }

    private function convertToWebP($file)
    {
        try {
            $image = imagecreatefromstring(file_get_contents($file->getRealPath()));
            
            if (!$image) {
                return false;
            }

            $width = imagesx($image);
            $height = imagesy($image);
            
            $webpImage = imagecreatetruecolor($width, $height);
            $white = imagecolorallocate($webpImage, 255, 255, 255);
            imagefill($webpImage, 0, 0, $white);
            imagecopy($webpImage, $image, 0, 0, 0, 0, $width, $height);
            
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.webp';
            $path = 'media/' . $filename;
            
            $fullPath = storage_path('app/public/' . $path);
            
            $dir = dirname($fullPath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            
            imagewebp($webpImage, $fullPath, 85);
            
            imagedestroy($image);
            imagedestroy($webpImage);
            
            $webpSize = filesize($fullPath);
            
            Media::create([
                'user_id'       => auth()->id(),
                'filename'      => $filename,
                'original_name' => $file->getClientOriginalName(),
                'path'          => $path,
                'url'           => Storage::disk('public')->url($path),
                'mime_type'     => 'image/webp',
                'size'          => $webpSize,
                'disk'          => 'public',
            ]);
            
            return $path;
            
        } catch (\Exception $e) {
            Log::error('WebP conversion failed: ' . $e->getMessage());
            
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
            
            return $path;
        }
    }

    public function destroy(Media $medium)
    {
        Storage::disk('public')->delete($medium->path);
        $medium->delete();

        return redirect()->route('admin.media.index')->with('success', 'File deleted!');
    }
}
