@extends('layouts.admin')

@section('title', 'Categories')

@section('content')

<div class="page-header">
    <div>
        <h1>Categories</h1>
        <p>Manage content categories</p>
    </div>
</div>

<div class="grid-2" style="align-items:start">
    {{-- Category List --}}
    <div class="admin-card">
        <h3 style="font-size:1rem;font-weight:700;color:var(--text-header);margin-bottom:1.25rem">All Categories</h3>
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
                                <button onclick="editCategory('{{ $category->slug }}', '{{ str_replace("'", "\'", $category->name) }}', '{{ $category->color }}', '{{ $category->icon }}', '{{ str_replace("'", "\'", $category->description) }}')" class="btn btn-warning btn-sm">Edit</button>
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

    {{-- Create/Edit Form --}}
    <div class="admin-card">
        <h3 style="font-size:1rem;font-weight:700;color:var(--text-header);margin-bottom:1.25rem" id="formTitle">Add Category</h3>
        <form method="POST" id="categoryForm" action="{{ route('admin.categories.store') }}">
            @csrf
            <span id="methodField"></span>
            <div class="form-group">
                <label class="form-label">Name *</label>
                <input type="text" name="name" id="catName" value="{{ old('name') }}" class="form-control" required placeholder="e.g. Mathematics">
            </div>
            <div class="form-group">
                <label class="form-label">Icon (emoji)</label>
                <input type="text" name="icon" id="catIcon" value="{{ old('icon') }}" class="form-control" placeholder="e.g. 📐">
            </div>
            <div class="form-group">
                <label class="form-label">Color</label>
                <div style="display:flex;gap:.75rem;align-items:center">
                    <input type="color" name="color" id="catColor" value="{{ old('color', '#3B82F6') }}" style="width:50px;height:42px;border:none;background:none;cursor:pointer;border-radius:8px">
                    <input type="text" id="catColorText" value="{{ old('color', '#3B82F6') }}" class="form-control" style="flex:1" placeholder="#3B82F6">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" id="catDescription" class="form-control" rows="3" placeholder="Optional description...">{{ old('description') }}</textarea>
            </div>
            <div style="display:flex;gap:1rem">
                <button type="submit" class="btn btn-primary-admin" style="flex:1">Save Category</button>
                <button type="button" onclick="resetForm()" class="btn btn-ghost">Reset</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function editCategory(slug, name, color, icon, description) {
    document.getElementById('formTitle').textContent = 'Edit Category';
    document.getElementById('catName').value = name;
    document.getElementById('catColor').value = color;
    document.getElementById('catColorText').value = color;
    document.getElementById('catIcon').value = icon;
    document.getElementById('catDescription').value = description;
    document.getElementById('categoryForm').action = '/admin/categories/' + slug;
    document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    window.scrollTo(0, document.getElementById('formTitle').offsetTop - 100);
}
function resetForm() {
    document.getElementById('formTitle').textContent = 'Add Category';
    document.getElementById('categoryForm').action = '{{ route('admin.categories.store') }}';
    document.getElementById('methodField').innerHTML = '';
    document.getElementById('categoryForm').reset();
}
document.getElementById('catColor').addEventListener('input', function() {
    document.getElementById('catColorText').value = this.value;
});
</script>
@endpush
