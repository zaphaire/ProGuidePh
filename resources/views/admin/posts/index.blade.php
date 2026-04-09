@extends('layouts.admin')

@section('title', 'Posts')

@section('content')

<div class="page-header">
    <div>
        <h1>Posts</h1>
        <p>Manage all articles and content</p>
    </div>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary-admin">+ New Post</a>
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
                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-warning btn-sm">Edit</a>
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
