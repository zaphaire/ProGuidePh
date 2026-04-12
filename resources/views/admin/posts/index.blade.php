@extends('layouts.admin')

@section('title', 'Posts')

@section('content')

<div class="page-header">
    <div>
        <h1>Posts</h1>
        <p>Manage all articles and content</p>
    </div>
    <button onclick="openModal('createPostModal')" class="btn btn-primary-admin">+ New Post</button>
</div>

{{-- Create Post Modal --}}
<div id="createPostModal" class="modal" style="display:none;position:fixed;z-index:9999;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,.5);align-items:center;justify-content:center">
    <div class="modal-content" style="background:#fff;border-radius:12px;width:95%;max-width:900px;max-height:90vh;overflow-y:auto;margin:1rem">
        <div style="padding:1.5rem;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center">
            <h2 style="font-size:1.25rem;font-weight:700;color:var(--text-header)">Create New Post</h2>
            <button onclick="closeModal('createPostModal')" style="background:none;border:none;font-size:1.5rem;cursor:pointer;color:var(--text-muted)">&times;</button>
        </div>
        
        <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data" style="padding:1.5rem">
            @csrf
            <div class="grid-2" style="align-items:start">
                <div>
                    <div class="admin-card">
                        <h3 style="font-size:.95rem;font-weight:700;color:var(--text-header);margin-bottom:1.25rem">Post Content</h3>

                        <div class="form-group">
                            <label class="form-label">Title *</label>
                            <input type="text" name="title" value="{{ old('title') }}" class="form-control" required placeholder="Article title...">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Excerpt</label>
                            <textarea name="excerpt" class="form-control" rows="3" placeholder="Short summary...">{{ old('excerpt') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Body *</label>
                            <textarea name="body" id="tinymce-editor-modal" class="form-control" rows="12">{{ old('body') }}</textarea>
                        </div>
                    </div>

                    <div class="admin-card">
                        <h3 style="font-size:.95rem;font-weight:700;color:var(--text-header);margin-bottom:1.25rem">SEO Settings</h3>
                        <div class="form-group">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" value="{{ old('meta_title') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description') }}</textarea>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="admin-card">
                        <h3 style="font-size:.95rem;font-weight:700;color:var(--text-header);margin-bottom:1.25rem">Post Settings</h3>

                        <div class="form-group">
                            <label class="form-label">Status *</label>
                            <select name="status" class="form-control" required>
                                <option value="draft">Draft</option>
                                <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                                <option value="archived">Archived</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-control">
                                <option value="">— None —</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->icon }} {{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Featured Image</label>
                            <input type="file" name="featured_image" class="form-control" accept="image/*" id="modalImageInput">
                            <div id="modalImagePreview" style="margin-top:.75rem;display:none">
                                <img id="modalPreviewImg" src="" alt="Preview" style="width:100%;border-radius:8px;max-height:150px;object-fit:cover">
                            </div>
                        </div>

                        <div style="display:flex;align-items:center;gap:.75rem;padding:.5rem;background:rgba(245,158,11,.05);border-radius:8px">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1" style="width:16px;height:16px;accent-color:#f59e0b">
                            <label for="is_featured" style="color:#f59e0b;font-weight:600;font-size:.85rem">Feature this post</label>
                        </div>
                    </div>

                    <div style="display:flex;gap:1rem;margin-top:1rem">
                        <button type="submit" class="btn btn-primary-admin" style="flex:1">Publish Post</button>
                        <button type="button" onclick="closeModal('createPostModal')" class="btn btn-ghost" style="flex:1">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Edit Post Modal --}}
<div id="editPostModal" class="modal" style="display:none;position:fixed;z-index:9999;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,.5);align-items:center;justify-content:center">
    <div class="modal-content" style="background:#fff;border-radius:12px;width:95%;max-width:900px;max-height:90vh;overflow-y:auto;margin:1rem">
        <div style="padding:1.5rem;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center">
            <h2 style="font-size:1.25rem;font-weight:700;color:var(--text-header)">Edit Post</h2>
            <button onclick="closeModal('editPostModal')" style="background:none;border:none;font-size:1.5rem;cursor:pointer;color:var(--text-muted)">&times;</button>
        </div>
        
        <form method="POST" id="editPostForm" enctype="multipart/form-data" style="padding:1.5rem">
            @csrf
            @method('PUT')
            <input type="hidden" id="editPostId" value="">
            <div class="grid-2" style="align-items:start">
                <div>
                    <div class="admin-card">
                        <h3 style="font-size:.95rem;font-weight:700;color:var(--text-header);margin-bottom:1.25rem">Post Content</h3>

                        <div class="form-group">
                            <label class="form-label">Title *</label>
                            <input type="text" name="title" id="editTitle" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Excerpt</label>
                            <textarea name="excerpt" id="editExcerpt" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Body *</label>
                            <textarea name="body" id="tinymce-editor-edit" class="form-control" rows="12"></textarea>
                        </div>
                    </div>

                    <div class="admin-card">
                        <h3 style="font-size:.95rem;font-weight:700;color:var(--text-header);margin-bottom:1.25rem">SEO Settings</h3>
                        <div class="form-group">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" id="editMetaTitle" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" id="editMetaDescription" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="admin-card">
                        <h3 style="font-size:.95rem;font-weight:700;color:var(--text-header);margin-bottom:1.25rem">Post Settings</h3>

                        <div class="form-group">
                            <label class="form-label">Status *</label>
                            <select name="status" id="editStatus" class="form-control" required>
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                                <option value="archived">Archived</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Category</label>
                            <select name="category_id" id="editCategory" class="form-control">
                                <option value="">— None —</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->icon }} {{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Featured Image</label>
                            <div id="currentImage" style="margin-bottom:.5rem">
                                <img id="editCurrentImage" src="" alt="Current" style="width:100%;border-radius:8px;max-height:120px;object-fit:cover;display:none">
                            </div>
                            <input type="file" name="featured_image" class="form-control" accept="image/*" id="editImageInput">
                            <div id="editImagePreview" style="margin-top:.75rem;display:none">
                                <img id="editPreviewImg" src="" alt="Preview" style="width:100%;border-radius:8px;max-height:120px;object-fit:cover">
                            </div>
                        </div>

                        <div style="display:flex;align-items:center;gap:.75rem;padding:.5rem;background:rgba(245,158,11,.05);border-radius:8px">
                            <input type="checkbox" name="is_featured" id="editIsFeatured" value="1" style="width:16px;height:16px;accent-color:#f59e0b">
                            <label for="editIsFeatured" style="color:#f59e0b;font-weight:600;font-size:.85rem">Feature this post</label>
                        </div>
                    </div>

                    <div style="display:flex;gap:1rem;margin-top:1rem">
                        <button type="submit" class="btn btn-primary-admin" style="flex:1">Update Post</button>
                        <button type="button" onclick="closeModal('editPostModal')" class="btn btn-ghost" style="flex:1">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Filters --}}
<div class="admin-card" style="margin-bottom:1.25rem">
    <form method="GET" style="display:flex;gap:1rem;flex-wrap:wrap;align-items:flex-end">
        <div style="flex:1;min-width:180px">
            <label class="form-label" style="margin-bottom:.3rem">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search posts..." class="form-control">
        </div>
        <div>
            <label class="form-label" style="margin-bottom:.3rem">Status</label>
            <select name="status" class="form-control">
                <option value="">All Status</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
            </select>
        </div>
        <div>
            <label class="form-label" style="margin-bottom:.3rem">Category</label>
            <select name="category" class="form-control">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary-admin">Filter</button>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-ghost">Reset</a>
    </form>
</div>

<div class="admin-card">
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Views</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                <tr>
                    <td>
                        <div style="font-weight:600;color:var(--text-header)">{{ Str::limit($post->title, 45) }}</div>
                        @if($post->is_featured)
                            <span style="font-size:.72rem;color:var(--accent)">⭐ Featured</span>
                        @endif
                    </td>
                    <td style="color:var(--text-muted)">{{ $post->category?->name ?? '—' }}</td>
                    <td style="color:var(--text-muted)">{{ $post->user->name }}</td>
                    <td><span class="badge badge-{{ $post->status }}">{{ ucfirst($post->status) }}</span></td>
                    <td style="color:var(--text-main)">{{ number_format($post->views) }}</td>
                    <td style="color:var(--text-muted);font-size:.8rem">{{ $post->created_at->format('M d, Y') }}</td>
                    <td>
                        <div style="display:flex;gap:.4rem">
                            <a href="{{ route('posts.show', $post->slug) }}" target="_blank" class="btn btn-ghost btn-sm">View</a>
                            <button type="button" onclick="openEditModal({{ $post->id }})" class="btn btn-warning btn-sm">Edit</button>
                            <form id="delete-post-{{ $post->id }}" action="{{ route('admin.posts.destroy', $post) }}" method="POST" style="display: none;">
                                @csrf @method('DELETE')
                            </form>
                            <button type="button" onclick="openDeleteModal('delete-post-{{ $post->id }}', 'Are you sure you want to delete this post? This will permanently remove it from the database.')" class="btn btn-danger btn-sm">Delete</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;color:var(--text-muted);padding:2rem">No posts found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:1rem">{{ $posts->links() }}</div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<script>
function openModal(id) {
    document.getElementById(id).style.display = 'flex';
    if (id === 'createPostModal' && !window.tinymceModalInitialized) {
        tinymce.init({
            selector: '#tinymce-editor-modal',
            skin: 'oxide-dark',
            content_css: 'dark',
            height: 300,
            menubar: true,
            plugins: ['advlist','autolink','lists','link','image','charmap','preview','anchor','searchreplace','visualblocks','code','fullscreen','insertdatetime','media','table','help','wordcount'],
            toolbar: 'undo redo | blocks | bold italic forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | image link | help',
            content_style: 'body { font-family: Inter, sans-serif; font-size: 14px; }',
            promotion: false,
            setup: function(editor) {
                editor.on('init', function() {
                    window.tinymceModalInitialized = true;
                });
            }
        });
    }
}

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}

document.getElementById('modalImageInput')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            document.getElementById('modalPreviewImg').src = ev.target.result;
            document.getElementById('modalImagePreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

document.getElementById('editImageInput')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            document.getElementById('editPreviewImg').src = ev.target.result;
            document.getElementById('editImagePreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

let editTinymceInitialized = false;

function openEditModal(postId) {
    console.log('Opening edit modal for post:', postId);
    fetch('/admin/get-post-data/' + postId)
        .then(res => {
            console.log('Response status:', res.status);
            if (!res.ok) throw new Error('Network error: ' + res.status);
            return res.json();
        })
        .then(post => {
            console.log('Post data:', post);
            document.getElementById('editPostId').value = post.id;
            document.getElementById('editPostForm').action = '/admin/posts/' + post.id;
            document.getElementById('editTitle').value = post.title || '';
            document.getElementById('editExcerpt').value = post.excerpt || '';
            document.getElementById('editMetaTitle').value = post.meta_title || '';
            document.getElementById('editMetaDescription').value = post.meta_description || '';
            document.getElementById('editStatus').value = post.status || 'draft';
            document.getElementById('editCategory').value = post.category_id || '';
            document.getElementById('editIsFeatured').checked = post.is_featured == 1;
            
            if (post.featured_image) {
                document.getElementById('editCurrentImage').src = '/storage/' + post.featured_image;
                document.getElementById('editCurrentImage').style.display = 'block';
            } else {
                document.getElementById('editCurrentImage').style.display = 'none';
            }
            
            document.getElementById('editPostModal').style.display = 'flex';
            
            // Show modal first, then initialize TinyMCE
            setTimeout(() => {
                if (!editTinymceInitialized) {
                    tinymce.init({
                        selector: '#tinymce-editor-edit',
                        skin: 'oxide-dark',
                        content_css: 'dark',
                        height: 300,
                        menubar: false,
                        plugins: 'lists link preview anchor searchreplace visualblocks code fullscreen insertdatetime table help wordcount',
                        toolbar: 'undo redo | blocks | bold italic forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | link | help',
                        content_style: 'body { font-family: Inter, sans-serif; font-size: 14px; }',
                        promotion: false,
                        setup: function(editor) {
                            editor.on('init', function() {
                                editor.setContent(post.body || '');
                                editTinymceInitialized = true;
                            });
                        }
                    });
                } else {
                    tinymce.get('tinymce-editor-edit').setContent(post.body || '');
                }
            }, 200);
        })
        .catch(err => {
            console.error('Error fetching post:', err);
            alert('Failed to load post data. Please try again.');
        });
}

window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
}
</script>
@endpush