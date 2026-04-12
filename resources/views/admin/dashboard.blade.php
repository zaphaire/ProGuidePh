@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="page-header">
    <div>
        <h1>Dashboard</h1>
        <p>Welcome back, {{ auth()->user()->name }}! Here's what's happening on ProGuidePh.</p>
    </div>
    <button onclick="openModal('createPostModal')" class="btn btn-primary-admin">+ New Post</button>
</div>

{{-- Create Post Modal (same as posts index) --}}
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
                                <option value="published">Published</option>
                                <option value="archived">Archived</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-control">
                                <option value="">— None —</option>
                                @foreach(\App\Models\Category::orderBy('name')->get() as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->icon }} {{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Featured Image</label>
                            <input type="file" name="featured_image" class="form-control" accept="image/*" id="dashboardImageInput">
                            <div id="dashboardImagePreview" style="margin-top:.75rem;display:none">
                                <img id="dashboardPreviewImg" src="" alt="Preview" style="width:100%;border-radius:8px;max-height:120px;object-fit:cover">
                            </div>
                        </div>

                        <div style="display:flex;align-items:center;gap:.75rem;padding:.5rem;background:rgba(245,158,11,.05);border-radius:8px">
                            <input type="checkbox" name="is_featured" id="dashIsFeatured" value="1" style="width:16px;height:16px;accent-color:#f59e0b">
                            <label for="dashIsFeatured" style="color:#f59e0b;font-weight:600;font-size:.85rem">Feature this post</label>
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

{{-- Stats Grid --}}
<div class="stats-grid">
    <div class="stat-card blue reveal-admin">
        <div class="stat-label">Total Posts</div>
        <div class="stat-value animate-fade">{{ $stats['total_posts'] }}</div>
        <div class="stat-icon">📝</div>
    </div>
    <div class="stat-card green reveal-admin delay-1">
        <div class="stat-label">Published</div>
        <div class="stat-value animate-fade">{{ $stats['published_posts'] }}</div>
        <div class="stat-icon">✅</div>
    </div>
    <div class="stat-card amber reveal-admin delay-2">
        <div class="stat-label">Drafts</div>
        <div class="stat-value animate-fade">{{ $stats['draft_posts'] }}</div>
        <div class="stat-icon">📋</div>
    </div>
    <div class="stat-card red reveal-admin delay-3">
        <div class="stat-label">Pending Comments</div>
        <div class="stat-value animate-fade">{{ $stats['pending_comments'] }}</div>
        <div class="stat-icon">💬</div>
    </div>
    <div class="stat-card purple reveal-admin delay-4">
        <div class="stat-label">Total Views</div>
        <div class="stat-value animate-fade">{{ number_format($stats['total_views']) }}</div>
        <div class="stat-icon">👁</div>
    </div>
    <div class="stat-card blue reveal-admin delay-5">
        <div class="stat-label">Users</div>
        <div class="stat-value animate-fade">{{ $stats['total_users'] }}</div>
        <div class="stat-icon">👥</div>
    </div>
</div>

<div class="grid-2">
    {{-- Recent Posts --}}
    <div class="admin-card reveal-admin">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem">
            <h3 style="font-size:1rem;font-weight:700;color:var(--text-header)">Recent Posts</h3>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-ghost btn-sm">View All</a>
        </div>
        <div class="admin-table-container">
            <table class="admin-table">
                <tbody>
                @foreach($recentPosts as $post)
                    <tr>
                        <td>
                            <div style="font-weight:600;color:var(--text-header);margin-bottom:.2rem">{{ Str::limit($post->title, 40) }}</div>
                            <div style="font-size:.78rem;color:var(--text-muted)">{{ $post->user->name }} · {{ $post->created_at->diffForHumans() }}</div>
                        </td>
                        <td>
                            <span class="badge badge-{{ $post->status }}">{{ ucfirst($post->status) }}</span>
                        </td>
                        <td style="display:flex;gap:.4rem">
                            <button onclick="openEditModal({{ $post->id }})" class="btn btn-ghost btn-sm">Edit</button>
                            <form id="delete-dash-post-{{ $post->id }}" action="{{ route('admin.posts.destroy', $post) }}" method="POST" style="display: none;">
                                @csrf @method('DELETE')
                            </form>
                            <button type="button" onclick="openDeleteModal('delete-dash-post-{{ $post->id }}', 'Delete this post from the dashboard?')" class="btn btn-danger btn-sm">Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Recent Comments --}}
    <div class="admin-card reveal-admin delay-1">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem">
            <h3 style="font-size:1rem;font-weight:700;color:var(--text-header)">Recent Comments</h3>
            <a href="{{ route('admin.comments.index') }}" class="btn btn-ghost btn-sm">View All</a>
        </div>
        @forelse($pendingComments as $comment)
            <div style="border-bottom:1px solid var(--border-subtle);padding:.85rem 0;">
                <div style="font-weight:600;color:var(--text-header);font-size:.875rem">{{ $comment->name }}</div>
                <div style="font-size:.8rem;color:var(--text-muted);margin:.2rem 0">on "{{ Str::limit($comment->post->title, 35) }}"</div>
                <div style="font-size:.82rem;color:var(--text-main)">{{ Str::limit($comment->body, 80) }}</div>
                <div style="display:flex;gap:.5rem;margin-top:.6rem">
                    <form method="POST" action="{{ route('admin.comments.approve', $comment) }}">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-success btn-sm">✓ Approve</button>
                    </form>
                    <form id="delete-dashboard-comment-{{ $comment->id }}" action="{{ route('admin.comments.destroy', $comment) }}" method="POST" style="display: none;">
                        @csrf @method('DELETE')
                    </form>
                    <button type="button" onclick="openDeleteModal('delete-dashboard-comment-{{ $comment->id }}', 'Delete this comment?')" class="btn btn-danger btn-sm">Delete</button>
                </div>
            </div>
        @empty
            <p style="color:var(--text-muted);font-size:.875rem;text-align:center;padding:1rem">🎉 No pending comments!</p>
        @endforelse
    </div>
</div>

{{-- Top Posts --}}
<div class="admin-card">
    <h3 style="font-size:1rem;font-weight:700;color:var(--text-header);margin-bottom:1.25rem">Top Posts by Views</h3>
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Views</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topPosts as $i => $post)
                <tr>
                    <td style="color:var(--text-muted)">{{ $i + 1 }}</td>
                    <td><a href="{{ route('posts.show', $post->slug) }}" style="color:var(--primary);font-weight:600">{{ Str::limit($post->title, 50) }}</a></td>
                    <td style="color:var(--text-muted)">{{ $post->category?->name ?? '—' }}</td>
                    <td style="color:var(--accent);font-weight:600">{{ number_format($post->views) }}</td>
                    <td><span class="badge badge-{{ $post->status }}">{{ ucfirst($post->status) }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Edit Post Modal --}}
<div id="editPostModal" class="modal" style="display:none;position:fixed;z-index:9999;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,.5);align-items:center;justify-content:center">
    <div class="modal-content" style="background:var(--bg-card);border-radius:12px;width:95%;max-width:900px;max-height:90vh;overflow-y:auto;margin:1rem">
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
                </div>

                <div>
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

                    <div class="admin-card" style="margin-top:1rem">
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

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<script>
function openModal(id) {
    document.getElementById(id).style.display = 'flex';
    if (id === 'createPostModal' && !window.tinymceDashInitialized) {
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
                    window.tinymceDashInitialized = true;
                });
            }
        });
    }
}

let editTinymceInitialized = false;

function openEditModal(postId) {
    fetch('/admin/get-post-data/' + postId)
        .then(res => {
            if (!res.ok) throw new Error('Failed to load');
            return res.json();
        })
        .then(post => {
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

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}

document.getElementById('dashboardImageInput')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            document.getElementById('dashboardPreviewImg').src = ev.target.result;
            document.getElementById('dashboardImagePreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
}
</script>
@endpush
