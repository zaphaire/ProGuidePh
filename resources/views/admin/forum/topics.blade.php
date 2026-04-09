@extends('layouts.admin')

@section('title', 'Forum Topics - Admin')

@section('header')
    <div style="display:flex;justify-content:space-between;align-items:center">
        <h2>Forum Topics</h2>
    </div>
@endsection

@section('content')
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Replies</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topics as $topic)
                <tr>
                    <td>
                        <a href="{{ route('forum.show', $topic->slug) }}" target="_blank" style="font-weight:600;color:var(--primary)">
                            {{ Str::limit($topic->title, 50) }}
                        </a>
                    </td>
                    <td>{{ $topic->author_name }}</td>
                    <td>{{ $topic->replies->count() }}</td>
                    <td>
                        <span class="badge bg-{{ $topic->is_published ? 'success' : 'secondary' }}">
                            {{ $topic->is_published ? 'Published' : 'Hidden' }}
                        </span>
                    </td>
                    <td>{{ $topic->created_at->format('M d, Y') }}</td>
                    <td>
                        <div style="display:flex;gap:.5rem">
                            <form method="POST" action="{{ route('admin.forum.topics.toggle', $topic->id) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm" style="background:var(--info);color:#fff">
                                    {{ $topic->is_published ? 'Hide' : 'Show' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.forum.topics.destroy', $topic->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="background:var(--danger);color:#fff" onclick="return confirm('Delete this topic and all replies?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:2rem;color:var(--text-muted)">No topics yet</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:1rem">
    {{ $topics->links() }}
</div>
@endsection
