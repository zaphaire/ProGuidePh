@extends('layouts.admin')

@section('title', 'Forum Replies - Admin')

@section('header')
    <div style="display:flex;justify-content:space-between;align-items:center">
        <h2>Forum Replies</h2>
    </div>
@endsection

@section('content')
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Topic</th>
                <th>Author</th>
                <th>Reply</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($replies as $reply)
                <tr>
                    <td>
                        <a href="{{ route('forum.show', $reply->topic->slug) }}" target="_blank" style="font-weight:600;color:var(--primary)">
                            {{ Str::limit($reply->topic->title, 40) }}
                        </a>
                    </td>
                    <td>{{ $reply->author_name }}</td>
                    <td>{{ Str::limit($reply->body, 60) }}</td>
                    <td>{{ $reply->created_at->format('M d, Y') }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.forum.replies.destroy', $reply->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm" style="background:var(--danger);color:#fff" onclick="return confirm('Delete this reply?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:2rem;color:var(--text-muted)">No replies yet</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:1rem">
    {{ $replies->links() }}
</div>
@endsection
