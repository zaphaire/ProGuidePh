@extends('layouts.admin')

@section('title', 'Media Library')

@section('content')

<div class="page-header">
    <div>
        <h1>Media Library</h1>
        <p>Upload and manage images and files</p>
    </div>
</div>

<div class="admin-card" style="margin-bottom:1.5rem">
    <h3 style="font-size:1rem;font-weight:700;color:var(--text-header);margin-bottom:1.25rem">Upload Files</h3>
    <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="files[]" multiple accept="image/*,.pdf" class="form-input" style="margin-bottom:1rem">
        <button type="submit" class="btn btn-primary-admin">Upload</button>
    </form>
</div>

<div class="admin-card">
    <h3 style="font-size:1rem;font-weight:700;color:var(--text-header);margin-bottom:1.25rem">All Files ({{ $media->count() }})</h3>
    
    @if($media->count() > 0)
    <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(180px, 1fr));gap:1rem">
        @foreach($media as $file)
        <div style="background:#0f172a;border-radius:10px;overflow:hidden;border:1px solid var(--border-subtle);padding:1rem;text-align:center">
            <div style="font-size:3rem;margin-bottom:.5rem">
                @if(str_starts_with($file->mime_type, 'image/'))
                    🖼️
                @elseif($file->mime_type === 'application/pdf')
                    📕
                @else
                    📄
                @endif
            </div>
            <div style="font-size:.75rem;color:var(--text-main);word-break:break-all">{{ $file->original_name }}</div>
            <div style="font-size:.7rem;color:var(--text-muted);margin:.3rem 0">{{ round($file->size / 1024, 1) }} KB</div>
            <div style="font-size:.7rem;color:#64748b;margin-bottom:.5rem">{{ $file->mime_type }}</div>
            
            <div style="display:flex;gap:.5rem;justify-content:center">
                <button onclick="navigator.clipboard.writeText('{{ $file->url }}')" class="btn btn-ghost btn-sm">Copy URL</button>
                <form action="{{ route('admin.media.destroy', $file) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">Delete</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <p style="color:var(--text-muted);text-align:center;padding:2rem">No files uploaded.</p>
    @endif
</div>

@endsection