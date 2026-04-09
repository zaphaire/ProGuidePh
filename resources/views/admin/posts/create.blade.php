@extends('layouts.admin')

@section('title', 'Create Post')

@section('content')

<div class="page-header">
    <div>
        <h1>Create Post</h1>
        <p>Write a new article with helpful tips or guides</p>
    </div>
    <a href="{{ route('admin.posts.index') }}" class="btn btn-ghost">← Back</a>
</div>

<form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid-2" style="align-items:start">
        <div>
            <div class="admin-card">
                <h3 style="font-size:.95rem;font-weight:700;color:var(--text-header);margin-bottom:1.25rem">Post Content</h3>

                <div class="form-group">
                    <label class="form-label">Title *</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-control" required placeholder="Article title...">
                    @error('title')<div style="color:#f87171;font-size:.8rem;margin-top:.3rem">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Excerpt</label>
                    <textarea name="excerpt" class="form-control" rows="3" placeholder="Short summary of the article...">{{ old('excerpt') }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Body *</label>
                    <textarea name="body" id="tinymce-editor" class="form-control" rows="15">{{ old('body') }}</textarea>
                    @error('body')<div style="color:#f87171;font-size:.8rem;margin-top:.3rem">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="admin-card">
                <h3 style="font-size:.95rem;font-weight:700;color:var(--text-header);margin-bottom:1.25rem">SEO Settings</h3>
                <div class="form-group">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title') }}" class="form-control" placeholder="Leave blank to use post title">
                </div>
                <div class="form-group">
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="3" placeholder="SEO description...">{{ old('meta_description') }}</textarea>
                </div>
            </div>
        </div>

        <div>
            <div class="admin-card">
                <h3 style="font-size:.95rem;font-weight:700;color:var(--text-header);margin-bottom:1.25rem">Post Settings</h3>

                <div class="form-group">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-control" required>
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-control">
                        <option value="">— None —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->icon }} {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Featured Image</label>
                    <input type="file" name="featured_image" class="form-control" accept="image/*" id="imageInput">
                    <div id="imagePreview" style="margin-top:.75rem;display:none">
                        <img id="previewImg" src="" alt="Preview" style="width:100%;border-radius:8px;max-height:200px;object-fit:cover">
                    </div>
                </div>

                <div style="display:flex;align-items:center;gap:.75rem;padding:.75rem;background:rgba(245,158,11,.05);border-radius:8px;border:1px solid rgba(245,158,11,.15)">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} style="width:18px;height:18px;accent-color:#f59e0b">
                    <label for="is_featured" style="color:#f59e0b;font-weight:600;cursor:pointer">⭐ Feature this post</label>
                </div>
            </div>

            <div style="display:flex;gap:1rem;margin-top:1rem">
                <button type="submit" class="btn btn-primary-admin" style="flex:1">Publish Post</button>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-ghost" style="flex:1;text-align:center">Cancel</a>
            </div>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector: '#tinymce-editor',
    skin: 'oxide-dark',
    content_css: 'dark',
    height: 500,
    menubar: true,
    plugins: ['advlist','autolink','lists','link','image','charmap','preview','anchor','searchreplace','visualblocks','code','fullscreen','insertdatetime','media','table','help','wordcount'],
    toolbar: 'undo redo | blocks | bold italic forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | image link | help',
    content_style: 'body { font-family: Inter, sans-serif; font-size: 15px; line-height: 1.7; }',
    promotion: false,
});

document.getElementById('imageInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            document.getElementById('previewImg').src = ev.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush
