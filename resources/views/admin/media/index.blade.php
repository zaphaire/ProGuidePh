@extends('layouts.admin')

@section('title', 'Media Library')

@section('content')

<div class="page-header">
    <div>
        <h1>Media Library</h1>
        <p>Upload and manage files</p>
    </div>
</div>

<div class="admin-card" style="margin-bottom:1.5rem">
    <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="files[]" multiple style="margin-bottom:1rem">
        <button type="submit" class="btn btn-primary-admin">Upload Files</button>
    </form>
</div>

<div class="admin-card">
    <h3>All Files ({{ $media->count() }})</h3>
    
    @if($media->count() > 0)
    <table style="width:100%;border-collapse:collapse">
        <thead>
            <tr style="border-bottom:1px solid #e5e7eb">
                <th style="text-align:left;padding:0.75rem">Icon</th>
                <th style="text-align:left;padding:0.75rem">Filename</th>
                <th style="text-align:left;padding:0.75rem">Type</th>
                <th style="text-align:left;padding:0.75rem">Size</th>
                <th style="text-align:right;padding:0.75rem">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($media as $file)
            <tr style="border-bottom:1px solid #e5e7eb">
                <td style="padding:0.75rem;font-size:1.5rem">
                    @if(str_starts_with($file->mime_type, 'image/'))
                    <a href="{{ url($file->path) }}" target="_blank">🖼️</a>
                    @else
                    📄
                    @endif
                </td>
                <td style="padding:0.75rem">
                    <a href="{{ url($file->path) }}" target="_blank" style="color:#2563eb;text-decoration:none">{{ $file->original_name }}</a>
                </td>
                <td style="padding:0.75rem;color:#6b7280">{{ $file->mime_type }}</td>
                <td style="padding:0.75rem;color:#6b7280">{{ round($file->size / 1024, 1) }} KB</td>
                <td style="padding:0.75rem;text-align:right">
                    <button onclick="navigator.clipboard.writeText('{{ url($file->path) }}')" class="btn btn-ghost btn-sm">Copy URL</button>
                    <form action="{{ route('admin.media.destroy', $file) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p style="text-align:center;padding:2rem;color:#6b7280">No files uploaded yet.</p>
    @endif
</div>

@endsection