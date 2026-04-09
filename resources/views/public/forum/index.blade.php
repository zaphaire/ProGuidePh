@extends('layouts.app')

@section('title', 'Forum - Community Discussions')

@section('content')

<div class="forum-header" style="background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 50%, var(--primary-light) 100%); color: #fff; padding: 3rem 1rem; position: relative; overflow: hidden;">
    <div style="position: absolute; inset: 0; background: url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E\");"></div>
    <div class="container" style="position: relative; z-index: 1;">
        <h1 style="font-family:'Poppins',sans-serif;font-size:2.5rem;font-weight:800;margin-bottom:.5rem">💬 Community Forum</h1>
        <p style="color:rgba(255,255,255,.85);font-size:1.1rem;max-width:500px">Join the conversation! Share your thoughts and connect with others anonymously.</p>
    </div>
</div>
</div>

<div class="container section">
    <div class="forum-topic-header" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;flex-wrap:wrap;gap:1rem">
        <h2 style="font-family:'Poppins',sans-serif;font-size:1.5rem;color:var(--text);font-weight:700">📝 Latest Discussions</h2>
        <a href="{{ route('forum.create') }}" class="btn-primary" style="display:inline-flex;align-items:center;gap:.5rem">➕ New Topic</a>
    </div>

    @if($topics->isEmpty())
        <div style="text-align:center;padding:4rem 2rem;background:var(--bg-card);border-radius:16px;box-shadow:var(--shadow-card);border:1px solid var(--border-light)">
            <div style="font-size:4rem;margin-bottom:1rem">💬</div>
            <h3 style="margin-bottom:.5rem;color:var(--text);font-size:1.5rem;font-weight:700">No discussions yet</h3>
            <p style="color:var(--text-muted);margin-bottom:1.5rem;font-size:1rem">Be the first to start a conversation!</p>
            <a href="{{ route('forum.create') }}" class="btn-primary">Start Discussion</a>
        </div>
    @else
        <div style="display:flex;flex-direction:column;gap:1rem">
            @foreach($topics as $topic)
                <a href="{{ route('forum.show', $topic->slug) }}" class="forum-topic-card" style="display:block;background:var(--bg-card);border-radius:16px;padding:1.5rem;box-shadow:var(--shadow-card);border:1px solid var(--border-light);transition:all .3s" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='var(--shadow-card-hover)';this.style.borderColor='var(--primary)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='var(--shadow-card)';this.style.borderColor='var(--border-light)'">
                    <div class="forum-topic-content" style="display:flex;justify-content:space-between;align-items:start;gap:1.5rem">
                        <div style="flex:1">
                            <h3 style="font-family:'Poppins',sans-serif;font-size:1.2rem;font-weight:600;color:var(--text);margin-bottom:.75rem;line-height:1.4">{{ $topic->title }}</h3>
                            <p style="color:var(--text-secondary);font-size:.95rem;line-height:1.6;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">{{ $topic->body }}</p>
                        </div>
                        <div class="reply-count" style="display:flex;flex-direction:column;align-items:center;min-width:70px;background:linear-gradient(135deg, var(--primary), var(--primary-light));padding:.75rem 1rem;border-radius:12px;color:#fff">
                            <span style="font-size:1.5rem;font-weight:700">{{ $topic->replies->count() }}</span>
                            <span style="font-size:.7rem;opacity:.85">replies</span>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:1rem;margin-top:1.25rem;font-size:.85rem;color:var(--text-muted);padding-top:1rem;border-top:1px solid var(--border-light)">
                        <span style="display:flex;align-items:center;gap:.35rem">👤 {{ $topic->author_name }}</span>
                        <span style="color:var(--border)">·</span>
                        <span>📅 {{ $topic->created_at->diffForHumans() }}</span>
                        @if($topic->replies->count() > 0)
                        <span style="color:var(--border)">·</span>
                        <span style="color:var(--primary)">💬 Last reply {{ $topic->replies->last()->created_at->diffForHumans() }}</span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>

        <div style="margin-top:2.5rem;display:flex;justify-content:center">
            {{ $topics->links() }}
        </div>
    @endif
</div>

@endsection