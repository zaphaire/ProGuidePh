@extends('layouts.admin')

@section('title', 'Create Page')

@section('content')

<div class="page-header">
    <div><h1>Create Page</h1></div>
    <a href="{{ route('admin.pages.index') }}" class="btn btn-ghost">← Back</a>
</div>

<form method="POST" action="{{ route('admin.pages.store') }}">
    @csrf
    <div class="grid-2" style="align-items:start">
        <div>
            <div class="admin-card">
                <div class="form-group">
                    <label class="form-label">Page Title *</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Body *</label>
                    <textarea name="body" id="page-editor" class="form-control" rows="15">{{ old('body') }}</textarea>
                </div>
            </div>
        </div>
        <div>
            <div class="admin-card">
                <div class="form-group">
                    <label class="form-label">Display Order</label>
                    <input type="number" name="order" value="{{ old('order', 0) }}" class="form-control" min="0">
                </div>
                <div class="form-group">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title') }}" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description') }}</textarea>
                </div>
                <div style="display:flex;align-items:center;gap:.75rem;padding:.75rem;background:rgba(16,185,129,.05);border-radius:8px;border:1px solid rgba(16,185,129,.15);margin-bottom:1.25rem">
                    <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published') ? 'checked' : '' }} style="width:18px;height:18px;accent-color:#10b981">
                    <label for="is_published" style="color:#10b981;font-weight:600;cursor:pointer">Publish immediately</label>
                </div>
                <button type="submit" class="btn btn-primary-admin" style="width:100%">Create Page</button>
            </div>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({ selector: '#page-editor', skin: 'oxide-dark', content_css: 'dark', height: 400, menubar: false, plugins: ['lists','link','image','code'], toolbar: 'undo redo | blocks | bold italic | bullist numlist | link image | code', promotion: false });
</script>
@endpush
