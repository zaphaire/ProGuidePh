@extends('layouts.admin')

@section('title', 'Comments')

@section('content')

<div class="page-header">
    <div>
        <h1>Comments</h1>
        <p>Moderate user comments</p>
    </div>
    <div style="display:flex;gap:.75rem">
        <a href="{{ route('admin.comments.index') }}" class="btn {{ !request('status') ? 'btn-primary-admin' : 'btn-ghost' }}">All</a>
        <a href="{{ route('admin.comments.index', ['status' => 'pending']) }}" class="btn {{ request('status') === 'pending' ? 'btn-primary-admin' : 'btn-ghost' }}">Pending</a>
        <a href="{{ route('admin.comments.index', ['status' => 'approved']) }}" class="btn {{ request('status') === 'approved' ? 'btn-primary-admin' : 'btn-ghost' }}">Approved</a>
    </div>
</div>

<div class="admin-card">
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Author</th>
                    <th>Comment</th>
                    <th>Post</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($comments as $comment)
                <tr>
                    <td>
                        <div style="font-weight:600;color:var(--text-header)">{{ $comment->name }}</div>
                        <div style="font-size:.78rem;color:var(--text-muted)">{{ $comment->email }}</div>
                    </td>
                    <td style="max-width:280px;color:var(--text-main)">{{ Str::limit($comment->body, 80) }}</td>
                    <td>
                        <a href="{{ route('posts.show', $comment->post->slug) }}" target="_blank" style="color:var(--primary);font-size:.85rem">
                            {{ Str::limit($comment->post->title, 40) }}
                        </a>
                    </td>
                    <td style="color:var(--text-muted);font-size:.8rem">{{ $comment->created_at->format('M d, Y') }}</td>
                    <td>
                        @if($comment->is_approved)
                            <span class="badge badge-published">Approved</span>
                        @else
                            <span class="badge badge-draft">Pending</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:.4rem;flex-wrap:wrap">
                            @if(!$comment->is_approved)
                                <form method="POST" action="{{ route('admin.comments.approve', $comment) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">✓</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.comments.reject', $comment) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-warning btn-sm">✗</button>
                                </form>
                            @endif
                                <form id="delete-comment-{{ $comment->id }}" action="{{ route('admin.comments.destroy', $comment) }}" method="POST" style="display: none;">
                                    @csrf @method('DELETE')
                                </form>
                                <button type="button" onclick="openDeleteModal('delete-comment-{{ $comment->id }}', 'Delete this comment? This will permanently remove it from the post.')" class="btn btn-danger btn-sm">Del</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;color:var(--text-muted);padding:2rem">No comments found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:1rem">{{ $comments->links() }}</div>
</div>

@endsection
