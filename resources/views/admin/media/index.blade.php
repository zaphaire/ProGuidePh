@extends('layouts.admin')

@section('title', 'Media Library')

@section('content')

<div class="page-header">
    <div>
        <h1>Media Library</h1>
        <p>Upload and manage images and files</p>
    </div>
</div>

{{-- Upload Form --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <h3 style="font-size:1rem;font-weight:700;color:var(--text-header);margin-bottom:1.25rem">Upload Files</h3>
    <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data">
        @csrf
        <div id="dropZone" style="border:2px dashed rgba(255,255,255,.15);border-radius:12px;padding:2.5rem;text-align:center;cursor:pointer;transition:all .2s;margin-bottom:1rem" onclick="document.getElementById('fileInput').click()">
            <div style="font-size:2.5rem;margin-bottom:.75rem">📁</div>
            <div style="color:var(--text-main);font-size:.925rem">Click to browse or drag & drop files here</div>
            <div style="font-size:.8rem;color:var(--text-muted);margin-top:.4rem">Images, documents — max 5MB each</div>
            <input type="file" name="files[]" id="fileInput" multiple accept="image/*,.pdf,.doc,.docx" style="display:none" onchange="previewFiles(this)">
        </div>
        <div id="filePreviewList" style="display:flex;gap:.75rem;flex-wrap:wrap;margin-bottom:1rem"></div>
        <button type="submit" class="btn btn-primary-admin">⬆️ Upload Files</button>
    </form>
</div>

{{-- Media Grid --}}
<div class="admin-card">
    <h3 style="font-size:1rem;font-weight:700;color:var(--text-header);margin-bottom:1.25rem">All Files ({{ $media->total() }})</h3>
    @if($media->isNotEmpty())
        <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(160px, 1fr));gap:1rem">
            @foreach($media as $file)
            <div style="background:#0f172a;border-radius:10px;overflow:hidden;border:1px solid var(--border-subtle)">
                @if($file->isImage())
                    <img src="{{ asset('storage/'.$file->path) }}" alt="{{ $file->original_name }}" style="width:100%;height:120px;object-fit:cover" onclick="window.open('{{ asset('storage/'.$file->path) }}', '_blank')">
                @else
                    <div style="width:100%;height:120px;display:flex;align-items:center;justify-content:center;font-size:2.5rem;background:#1e293b">📄</div>
                @endif
                <div style="padding:.65rem">
                    <div style="font-size:.75rem;color:var(--text-main);white-space:nowrap;overflow:hidden;text-overflow:ellipsis" title="{{ $file->original_name }}">{{ $file->original_name }}</div>
                    <div style="font-size:.72rem;color:var(--text-muted);margin-top:.2rem">{{ $file->formatted_size }}</div>
                    <div style="display:flex;gap:.4rem;margin-top:.6rem">
                        <button onclick="navigator.clipboard.writeText('{{ asset('storage/'.$file->path) }}')" class="btn btn-ghost btn-sm" style="flex:1;justify-content:center" title="Copy URL">📋</button>
                            <form id="delete-media-{{ $file->id }}" action="{{ route('admin.media.destroy', $file) }}" method="POST" style="display: none;">
                                @csrf @method('DELETE')
                            </form>
                            <button type="button" onclick="openDeleteModal('delete-media-{{ $file->id }}', 'Delete this file permanently from storage? This cannot be undone and may break posts using this image.')" class="btn btn-danger btn-sm" title="Delete">🗑</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div style="margin-top:1.5rem">{{ $media->links() }}</div>
    @else
        <div style="text-align:center;padding:3rem;color:var(--text-muted)">
            <div style="font-size:3rem;margin-bottom:1rem">🖼️</div>
            <p>No files uploaded yet.</p>
        </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
function previewFiles(input) {
    const list = document.getElementById('filePreviewList');
    list.innerHTML = '';
    Array.from(input.files).forEach(file => {
        const div = document.createElement('div');
        div.style.cssText = 'background:#0f172a;border-radius:8px;padding:.6rem .85rem;font-size:.8rem;color:var(--text-main);border:1px solid rgba(255,255,255,.08)';
        div.textContent = '📄 ' + file.name;
        list.appendChild(div);
    });
}
const dropZone = document.getElementById('dropZone');
dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.style.borderColor = '#3b82f6'; });
dropZone.addEventListener('dragleave', () => { dropZone.style.borderColor = 'rgba(255,255,255,.15)'; });
dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.style.borderColor = 'rgba(255,255,255,.15)';
    document.getElementById('fileInput').files = e.dataTransfer.files;
    previewFiles(document.getElementById('fileInput'));
});
</script>
@endpush
