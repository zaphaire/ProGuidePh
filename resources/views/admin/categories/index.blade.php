@extends('layouts.admin')

@section('title', 'Categories')

@section('content')

<div class="page-header">
    <div>
        <h1>Categories</h1>
        <p>Manage content categories</p>
    </div>
</div>

<div class="admin-card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem">
        <h3 style="font-size:1rem;font-weight:700;color:var(--text-header)">All Categories</h3>
        <button type="button" onclick="openCreateModal()" class="btn btn-primary-admin">+ Add Category</button>
    </div>
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Color</th>
                    <th>Posts</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:.6rem">
                            <span>{{ $category->icon ?? '📌' }}</span>
                            <span style="font-weight:600;color:var(--text-header)">{{ $category->name }}</span>
                        </div>
                        <div style="font-size:.78rem;color:var(--text-muted)">/{{ $category->slug }}</div>
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;gap:.5rem">
                            <div style="width:18px;height:18px;border-radius:4px;background:{{ $category->color }}"></div>
                            <span style="color:var(--text-muted);font-size:.8rem">{{ $category->color }}</span>
                        </div>
                    </td>
                    <td style="color:var(--primary)">{{ $category->posts_count }}</td>
                    <td>
                        <div style="display:flex;gap:.4rem">
                            <button onclick="openEditModal({{ $category->id }})" class="btn btn-warning btn-sm">Edit</button>
                            <form id="delete-cat-{{ $category->id }}" action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display: none;">
                                @csrf @method('DELETE')
                            </form>
                            <button type="button" onclick="openDeleteModal('delete-cat-{{ $category->id }}', 'Are you sure you want to delete this category? This will also un-categorize all associated posts.')" class="btn btn-danger btn-sm">Delete</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;color:var(--text-muted)">No categories yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Create Modal --}}
<div id="createCategoryModal" class="modal" style="display:none;position:fixed;z-index:9999;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,.5);align-items:center;justify-content:center">
    <div class="modal-content" style="background:var(--bg-card);border-radius:12px;width:95%;max-width:500px;max-height:90vh;overflow-y:auto;margin:1rem">
        <div style="padding:1.5rem;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center">
            <h3 style="font-size:1.25rem;font-weight:700;color:var(--text-header)" id="createModalTitle">Add Category</h3>
            <button onclick="closeModal('createCategoryModal')" style="background:none;border:none;font-size:1.5rem;cursor:pointer;color:var(--text-muted)">&times;</button>
        </div>
        <form method="POST" id="createCategoryForm" action="{{ route('admin.categories.store') }}" style="padding:1.5rem">
            @csrf
            <div class="form-group">
                <label class="form-label">Name *</label>
                <input type="text" name="name" id="createCatName" class="form-control" required placeholder="e.g. Mathematics">
            </div>
            <div class="form-group">
                <label class="form-label">Icon (emoji)</label>
                <input type="text" name="icon" id="createCatIcon" class="form-control" placeholder="e.g. 📐">
            </div>
            <div class="form-group">
                <label class="form-label">Color</label>
                <div style="display:flex;gap:.75rem;align-items:center">
                    <input type="color" name="color" id="createCatColor" value="#3B82F6" style="width:50px;height:42px;border:none;background:none;cursor:pointer;border-radius:8px">
                    <input type="text" id="createCatColorText" value="#3B82F6" class="form-control" style="flex:1" placeholder="#3B82F6">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" id="createCatDescription" class="form-control" rows="3" placeholder="Optional description..."></textarea>
            </div>
            <div style="display:flex;gap:1rem;margin-top:1.5rem">
                <button type="submit" class="btn btn-primary-admin" style="flex:1">Save Category</button>
                <button type="button" onclick="closeModal('createCategoryModal')" class="btn btn-ghost">Cancel</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div id="editCategoryModal" class="modal" style="display:none;position:fixed;z-index:9999;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,.5);align-items:center;justify-content:center">
    <div class="modal-content" style="background:var(--bg-card);border-radius:12px;width:95%;max-width:500px;max-height:90vh;overflow-y:auto;margin:1rem">
        <div style="padding:1.5rem;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center">
            <h3 style="font-size:1.25rem;font-weight:700;color:var(--text-header)">Edit Category</h3>
            <button onclick="closeModal('editCategoryModal')" style="background:none;border:none;font-size:1.5rem;cursor:pointer;color:var(--text-muted)">&times;</button>
        </div>
        <form method="POST" id="editCategoryForm" action="{{ route('admin.categories.index') }}" style="padding:1.5rem">
            @csrf
            @method('PUT')
            <input type="hidden" id="editCatId">
            <div class="form-group">
                <label class="form-label">Name *</label>
                <input type="text" name="name" id="editCatName" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Icon (emoji)</label>
                <input type="text" name="icon" id="editCatIcon" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Color</label>
                <div style="display:flex;gap:.75rem;align-items:center">
                    <input type="color" name="color" id="editCatColor" value="#3B82F6" style="width:50px;height:42px;border:none;background:none;cursor:pointer;border-radius:8px">
                    <input type="text" id="editCatColorText" value="#3B82F6" class="form-control" style="flex:1">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" id="editCatDescription" class="form-control" rows="3"></textarea>
            </div>
            <div style="display:flex;gap:1rem;margin-top:1.5rem">
                <button type="button" onclick="submitCategoryForm()" class="btn btn-primary-admin" style="flex:1">Update Category</button>
                <button type="button" onclick="closeModal('editCategoryModal')" class="btn btn-ghost">Cancel</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openCreateModal() {
    document.getElementById('createCatName').value = '';
    document.getElementById('createCatIcon').value = '';
    document.getElementById('createCatColor').value = '#3B82F6';
    document.getElementById('createCatColorText').value = '#3B82F6';
    document.getElementById('createCatDescription').value = '';
    document.getElementById('createCategoryModal').style.display = 'flex';
}

function openEditModal(categoryId) {
    console.log('Opening edit modal for category:', categoryId);
    fetch('/admin/get-category-data/' + categoryId)
        .then(res => {
            console.log('Response status:', res.status);
            if (!res.ok) throw new Error('Failed to load: ' + res.status);
            return res.json();
        })
        .then(cat => {
            console.log('Category data:', cat);
            document.getElementById('editCatId').value = cat.id;
            document.getElementById('editCatName').value = cat.name || '';
            document.getElementById('editCatIcon').value = cat.icon || '';
            document.getElementById('editCatColor').value = cat.color || '#3B82F6';
            document.getElementById('editCatColorText').value = cat.color || '#3B82F6';
            document.getElementById('editCatDescription').value = cat.description || '';
            document.getElementById('editCategoryForm').action = '/admin/categories/' + cat.id;
            document.getElementById('editCategoryModal').style.display = 'flex';
            console.log('Modal should be visible now');
        })
        .catch(err => {
            console.error('Error:', err);
            alert('Failed to load category data. Please try again. Error: ' + err.message);
        });
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

function submitCategoryForm() {
    const catId = document.getElementById('editCatId').value;
    if (!catId) {
        alert('Error: Category ID not found. Please try again.');
        return;
    }
    const form = document.getElementById('editCategoryForm');
    form.action = '/admin/categories/' + catId;
    form.submit();
}

document.getElementById('createCatColor').addEventListener('input', function() {
    document.getElementById('createCatColorText').value = this.value;
});

document.getElementById('editCatColor').addEventListener('input', function() {
    document.getElementById('editCatColorText').value = this.value;
});

window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
}
</script>
@endpush