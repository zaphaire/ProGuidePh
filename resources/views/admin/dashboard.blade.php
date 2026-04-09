@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="page-header">
    <div>
        <h1>Dashboard</h1>
        <p>Welcome back, {{ auth()->user()->name }}! Here's what's happening on ProGuidePh.</p>
    </div>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary-admin">+ New Post</a>
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
                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-ghost btn-sm">Edit</a>
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

@endsection
