@extends('layouts.admin')

@section('title', 'Pages')

@section('content')

<div class="page-header">
    <div>
        <h1>Pages</h1>
        <p>Manage static CMS pages (About, Contact, etc.)</p>
    </div>
    <button type="button" onclick="openCreateModal()" class="btn btn-primary-admin">+ New Page</button>
</div>

<div class="admin-card">
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr><th>Title</th><th>Slug</th><th>Author</th><th>Status</th><th>Order</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($pages as $page)
                <tr>
                    <td style="font-weight:600;color:var(--text-header)">{{ $page->title }}</td>
                    <td style="color:var(--text-muted)">/pages/{{ $page->slug }}</td>
                    <td style="color:var(--text-muted)">{{ $page->user->name }}</td>
                    <td>
                        <span class="badge {{ $page->is_published ? 'badge-published' : 'badge-draft' }}">
                            {{ $page->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </td>
                    <td style="color:var(--text-main)">{{ $page->order }}</td>
                    <td>
                        <div style="display:flex;gap:.4rem">
                            <a href="{{ route('pages.show', $page->slug) }}" target="_blank" class="btn btn-ghost btn-sm">View</a>
                            <button onclick="openEditModal({{ $page->id }})" class="btn btn-warning btn-sm">Edit</button>
                            <form id="delete-page-{{ $page->id }}" action="{{ route('admin.pages.destroy', $page) }}" method="POST" style="display: none;">
                                @csrf @method('DELETE')
                            </form>
                            <button type="button" onclick="openDeleteModal('delete-page-{{ $page->id }}', 'Are you sure you want to delete this page? This will remove the static content from the public site.')" class="btn btn-danger btn-sm">Delete</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;color:var(--text-muted);padding:2rem">No pages yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Create Modal --}}
<div id="createPageModal" class="modal" style="display:none;position:fixed;z-index:9999;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,.5);align-items:center;justify-content:center">
    <div class="modal-content" style="background:var(--bg-card);border-radius:12px;width:95%;max-width:700px;max-height:90vh;overflow-y:auto;margin:1rem">
        <div style="padding:1.5rem;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center">
            <h3 style="font-size:1.25rem;font-weight:700;color:var(--text-header)">Create Page</h3>
            <button onclick="closeModal('createPageModal')" style="background:none;border:none;font-size:1.5rem;cursor:pointer;color:var(--text-muted)">&times;</button>
        </div>
        <form method="POST" id="createPageForm" action="{{ route('admin.pages.store') }}" style="padding:1.5rem">
            @csrf
            <div class="form-group">
                <label class="form-label">Title *</label>
                <input type="text" name="title" id="createPageTitle" class="form-control" required placeholder="Page title">
            </div>
            <div class="form-group">
                <label class="form-label">Content *</label>
                <textarea name="body" id="createPageEditor" class="form-control" rows="10"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Meta Title</label>
                <input type="text" name="meta_title" id="createPageMetaTitle" class="form-control" placeholder="SEO title (optional)">
            </div>
            <div class="form-group">
                <label class="form-label">Meta Description</label>
                <textarea name="meta_description" id="createPageMetaDesc" class="form-control" rows="2" placeholder="SEO description (optional)"></textarea>
            </div>
            <div style="display:flex;gap:1rem">
                <div class="form-group" style="flex:1">
                    <label class="form-label">Order</label>
                    <input type="number" name="order" id="createPageOrder" class="form-control" value="0">
                </div>
                <div class="form-group" style="flex:1;display:flex;align-items:center;padding-top:1.5rem">
                    <input type="checkbox" name="is_published" id="createPagePublished" style="margin-right:0.5rem">
                    <label for="createPagePublished" style="margin:0">Publish immediately</label>
                </div>
            </div>
            <div style="display:flex;gap:1rem;margin-top:1.5rem">
                <button type="submit" class="btn btn-primary-admin" style="flex:1">Create Page</button>
                <button type="button" onclick="closeModal('createPageModal')" class="btn btn-ghost">Cancel</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div id="editPageModal" class="modal" style="display:none;position:fixed;z-index:9999;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,.5);align-items:center;justify-content:center">
    <div class="modal-content" style="background:var(--bg-card);border-radius:12px;width:95%;max-width:700px;max-height:90vh;overflow-y:auto;margin:1rem">
        <div style="padding:1.5rem;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center">
            <h3 style="font-size:1.25rem;font-weight:700;color:var(--text-header)">Edit Page</h3>
            <button onclick="closeModal('editPageModal')" style="background:none;border:none;font-size:1.5rem;cursor:pointer;color:var(--text-muted)">&times;</button>
        </div>
        <form method="POST" id="editPageForm" action="" style="padding:1.5rem">
            @csrf
            @method('PUT')
            <input type="hidden" id="editPageId">
            <div class="form-group">
                <label class="form-label">Title *</label>
                <input type="text" name="title" id="editPageTitle" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Content *</label>
                <textarea name="body" id="editPageEditor" class="form-control" rows="10"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Meta Title</label>
                <input type="text" name="meta_title" id="editPageMetaTitle" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Meta Description</label>
                <textarea name="meta_description" id="editPageMetaDesc" class="form-control" rows="2"></textarea>
            </div>
            <div style="display:flex;gap:1rem">
                <div class="form-group" style="flex:1">
                    <label class="form-label">Order</label>
                    <input type="number" name="order" id="editPageOrder" class="form-control">
                </div>
                <div class="form-group" style="flex:1;display:flex;align-items:center;padding-top:1.5rem">
                    <input type="checkbox" name="is_published" id="editPagePublished" style="margin-right:0.5rem">
                    <label for="editPagePublished" style="margin:0">Published</label>
                </div>
            </div>
            <div style="display:flex;gap:1rem;margin-top:1.5rem">
                <button type="submit" class="btn btn-primary-admin" style="flex:1">Update Page</button>
                <button type="button" onclick="closeModal('editPageModal')" class="btn btn-ghost">Cancel</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<script>
let createTinymceInitialized = false;
let editTinymceInitialized = false;

function openCreateModal() {
    document.getElementById('createPageForm').reset();
    document.getElementById('createPageModal').style.display = 'flex';
    setTimeout(() => {
        if (!createTinymceInitialized) {
            tinymce.init({
                selector: '#createPageEditor',
                skin: 'oxide-dark',
                content_css: 'dark',
                height: 300,
                menubar: false,
                plugins: 'lists link image code',
                toolbar: 'undo redo | blocks | bold italic | bullist numlist | link | code',
                promotion: false,
                setup: function(editor) {
                    editor.on('init', function() {
                        createTinymceInitialized = true;
                    });
                }
            });
        } else {
            tinymce.get('createPageEditor').setContent('');
        }
    }, 100);
}

function openEditModal(pageId) {
    fetch('/admin/get-page-data/' + pageId)
        .then(res => {
            if (!res.ok) throw new Error('Failed to load');
            return res.json();
        })
        .then(page => {
            document.getElementById('editPageId').value = page.id;
            document.getElementById('editPageTitle').value = page.title || '';
            document.getElementById('editPageMetaTitle').value = page.meta_title || '';
            document.getElementById('editPageMetaDesc').value = page.meta_description || '';
            document.getElementById('editPageOrder').value = page.order || 0;
            document.getElementById('editPagePublished').checked = page.is_published;
            document.getElementById('editPageForm').action = '/admin/pages/' + page.id;
            document.getElementById('editPageModal').style.display = 'flex';
            
            setTimeout(() => {
                if (!editTinymceInitialized) {
                    tinymce.init({
                        selector: '#editPageEditor',
                        skin: 'oxide-dark',
                        content_css: 'dark',
                        height: 300,
                        menubar: false,
                        plugins: 'lists link image code',
                        toolbar: 'undo redo | blocks | bold italic | bullist numlist | link | code',
                        promotion: false,
                        setup: function(editor) {
                            editor.on('init', function() {
                                editor.setContent(page.body || '');
                                editTinymceInitialized = true;
                            });
                        }
                    });
                } else {
                    tinymce.get('editPageEditor').setContent(page.body || '');
                }
            }, 100);
        })
        .catch(err => {
            console.error(err);
            alert('Failed to load page data. Please try again.');
        });
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
}
</script>
@endpush