@extends('layouts.admin')

@section('title', 'Pages')

@section('content')

<div class="page-header">
    <div>
        <h1>Pages</h1>
        <p>Manage static CMS pages (About, Contact, etc.)</p>
    </div>
    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary-admin">+ New Page</a>
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
                            <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-warning btn-sm">Edit</a>
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

@endsection
