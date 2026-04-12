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
    <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(200px, 1fr));gap:1.5rem">
        @foreach($media as $file)
        <div style="background:#0f172a;border-radius:12px;overflow:hidden;border:1px solid var(--border-subtle);display:flex;flex-direction:column;transition:transform 0.2s ease, box-shadow 0.2s ease;" class="media-card">
            <div style="height:150px;background:#1e293b;display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden;border-bottom:1px solid var(--border-subtle)">
                @if(str_starts_with($file->mime_type, 'image/'))
                    <img src="{{ $file->url }}" alt="{{ $file->original_name }}" style="width:100%;height:100%;object-fit:cover;">
                @elseif($file->mime_type === 'application/pdf')
                    <div style="font-size:3.5rem">📕</div>
                @else
                    <div style="font-size:3.5rem">📄</div>
                @endif
                
                <div style="position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.4);display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity 0.2s;" class="media-overlay">
                     <button onclick="navigator.clipboard.writeText('{{ url($file->url) }}'); alert('URL copied!')" class="btn btn-primary-admin btn-sm" style="padding:0.4rem 0.8rem">Copy URL</button>
                </div>
            </div>

            <div style="padding:1rem;flex-grow:1;display:flex;flex-direction:column;justify-content:space-between">
                <div style="margin-bottom:0.75rem">
                    <div style="font-size:.85rem;font-weight:600;color:var(--text-header);word-break:break-all;margin-bottom:0.25rem" title="{{ $file->original_name }}">
                        {{ Str::limit($file->original_name, 25) }}
                    </div>
                    <div style="font-size:.75rem;color:var(--text-muted);display:flex;justify-content:space-between">
                        <span>{{ round($file->size / 1024, 1) }} KB</span>
                        <span>{{ explode('/', $file->mime_type)[1] ?? $file->mime_type }}</span>
                    </div>
                </div>
                
                <div style="display:flex;gap:.5rem">
                    <form action="{{ route('admin.media.destroy', $file) }}" method="POST" style="width:100%">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" style="width:100%;background:rgba(239, 68, 68, 0.1);color:#ef4444;border:1px solid rgba(239, 68, 68, 0.2)" onclick="return confirm('Protect against accidental deletion?')">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <style>
        .media-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
            border-color: var(--accent-primary) !important;
        }
        .media-card:hover .media-overlay {
            opacity: 1 !important;
        }
    </style>
    @else
    <p style="color:var(--text-muted);text-align:center;padding:2rem">No files uploaded.</p>
    @endif
</div>

@endsection