@extends('layouts.admin')

@section('title', 'Dashboard')

@section('header.subtitle')
<p>Welcome back, {{ auth()->user()->name }}!</p>
@endsection

@section('header.actions')
<a href="{{ route('admin.posts.create') }}" class="btn btn-primary">+ New Post</a>
@endsection

@section('content')

<div class="stats">
    <div class="stat">
        <div class="stat-label">Total Posts</div>
        <div class="stat-value">{{ $stats['total_posts'] }}</div>
    </div>
    <div class="stat">
        <div class="stat-label">Published</div>
        <div class="stat-value">{{ $stats['published_posts'] }}</div>
    </div>
    <div class="stat">
        <div class="stat-label">Drafts</div>
        <div class="stat-value">{{ $stats['draft_posts'] }}</div>
    </div>
    <div class="stat">
        <div class="stat-label">Comments</div>
        <div class="stat-value">{{ $stats['total_comments'] }}</div>
    </div>
    <div class="stat">
        <div class="stat-label">Users</div>
        <div class="stat-value">{{ $stats['total_users'] }}</div>
    </div>
    <div class="stat">
        <div class="stat-label">Views</div>
        <div class="stat-value">{{ number_format($stats['total_views']) }}</div>
    </div>
</div>

<div class="card">
    <h3>Recent Posts</h3>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Status</th>
                <th>Author</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentPosts as $post)
            <tr>
                <td>{{ Str::limit($post->title, 40) }}</td>
                <td><span class="badge badge-{{ $post->status }}">{{ $post->status }}</span></td>
                <td>{{ $post->user->name }}</td>
                <td>{{ $post->created_at->format('M j') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection