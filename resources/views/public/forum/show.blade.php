@extends('layouts.app')

@section('title', $topic->title . ' - Forum')

@section('content')

<div style="background:var(--primary);color:#fff;padding:2rem 1rem" class="forum-header">
    <div class="container">
        <a href="{{ route('forum.index') }}" style="display:inline-flex;align-items:center;gap:.5rem;color:rgba(255,255,255,.7);margin-bottom:1rem;font-weight:500">
            ← Back to Forum
        </a>
        <h1 style="font-family:'Poppins',sans-serif;font-size:1.5rem;font-weight:700;margin-bottom:.5rem;line-height:1.3">{{ $topic->title }}</h1>
        <p style="color:rgba(255,255,255,.7);font-size:.9rem">
            👤 {{ $topic->author_name }} · {{ $topic->created_at->format('M d, Y \a\t g:i A') }}
        </p>
    </div>
</div>

<div class="container section forum-page-container">
    <div style="max-width:800px;margin:0 auto">
        <div class="forum-topic-body" style="background:#fff;border-radius:16px;padding:1.5rem 2rem;box-shadow:var(--shadow-card);margin-bottom:2rem">
            <p style="color:var(--text);line-height:1.8;font-size:1rem;white-space:pre-wrap">{{ $topic->body }}</p>
        </div>

        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem" class="forum-replies-header">
            <h2 style="font-family:'Poppins',sans-serif;font-size:1.25rem;color:var(--text);font-weight:700" class="forum-replies-title">
                💬 Replies ({{ $topic->replies->count() }})
            </h2>
        </div>

        @if($topic->replies->isEmpty())
            <div class="empty-replies" style="text-align:center;padding:2rem;background:var(--bg-soft);border-radius:12px;margin-bottom:2rem">
                <p style="color:var(--text-muted)">No replies yet. Be the first to reply!</p>
            </div>
        @else
            <div class="forum-replies-section" style="display:flex;flex-direction:column;gap:1rem;margin-bottom:2rem">
                @foreach($topic->replies as $reply)
                    <div class="forum-reply-card">
                        <div class="chat-author">
                            <span class="reply-author">{{ $reply->author_name }}</span>
                            <span class="chat-date">{{ $reply->created_at->format('g:i A') }}</span>
                        </div>
                        <p>{{ $reply->body }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="forum-reply-form telegram-reply-form" style="background:#fff;border-radius:16px;padding:1rem;box-shadow:var(--shadow-card);margin-top:1rem">
            <form id="telegramReplyForm" method="POST" action="{{ route('forum.reply.ajax', $topic->slug) }}" style="display:flex;gap:0.5rem;align-items:flex-end">
                @csrf
                <div style="flex:1">
                    <input type="text" name="author_name" id="replyAuthorName" value="{{ old('author_name') }}" 
                        placeholder="Your name (optional)"
                        style="width:100%;padding:.5rem .75rem;border:1px solid var(--border);border-radius:20px;font-family:inherit;font-size:.8rem;margin-bottom:.5rem">
                    <textarea name="body" id="replyBody" rows="2" required
                        placeholder="Type a message..."
                        style="width:100%;padding:.65rem 1rem;border:1px solid var(--border);border-radius:20px;font-family:inherit;font-size:.9rem;resize:none;background:#f9f9f9"></textarea>
                    <div id="replyError" style="color:#dc2626;font-size:.8rem;margin-top:.3rem;display:none"></div>
                </div>
                <button type="submit" class="btn-primary telegram-send-btn" style="padding:0.6rem 1.25rem;border-radius:20px;display:inline-flex;align-items:center;justify-content:center" id="sendBtn">
                    ➤ Send
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('telegramReplyForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const formData = new FormData(form);
    const sendBtn = document.getElementById('sendBtn');
    const errorDiv = document.getElementById('replyError');
    const repliesSection = document.querySelector('.forum-replies-section');
    const emptyMessage = document.querySelector('.empty-replies');
    const replyCountEl = document.querySelector('.forum-replies-title');
    
    sendBtn.disabled = true;
    sendBtn.innerHTML = '⏳';
    errorDiv.style.display = 'none';
    
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const reply = data.reply;
            
            if (emptyMessage) {
                emptyMessage.style.display = 'none';
            }
            
            if (!repliesSection) {
                const header = document.querySelector('.forum-replies-header');
                const newSection = document.createElement('div');
                newSection.className = 'forum-replies-section';
                newSection.style.cssText = 'display:flex;flex-direction:column;gap:1rem;margin-bottom:2rem';
                header.parentNode.insertBefore(newSection, header.nextSibling);
            }
            
            const repliesContainer = document.querySelector('.forum-replies-section');
            const cardDiv = document.createElement('div');
            cardDiv.className = 'forum-reply-card';
            cardDiv.style.cssText = reply.is_even 
                ? 'float:right;background:#e1ffc7;border-radius:12px 12px 4px 12px;padding:0.5rem 0.75rem;box-shadow:0 1px 0.5px rgba(0,0,0,0.1);max-width:80%;clear:both;margin-bottom:0.5rem' 
                : 'float:left;background:#fff;border-radius:12px 12px 12px 4px;padding:0.5rem 0.75rem;box-shadow:0 1px 0.5px rgba(0,0,0,0.1);max-width:80%;clear:both;margin-bottom:0.5rem';
            
            const authorColor = reply.is_even ? '#1a7a00' : 'var(--primary)';
            
            cardDiv.innerHTML = `
                <div class="chat-author">
                    <span class="reply-author" style="font-weight:700;color:${authorColor}">${reply.author_name}</span>
                    <span class="chat-date">${reply.created_at}</span>
                </div>
                <p>${reply.body}</p>
            `;
            
            repliesContainer.appendChild(cardDiv);
            repliesContainer.scrollTop = repliesContainer.scrollHeight;
            
            const currentCount = parseInt(replyCountEl.textContent.match(/\d+/)[0]);
            replyCountEl.textContent = '💬 Replies (' + (currentCount + 1) + ')';
            
            document.getElementById('replyBody').value = '';
        } else {
            errorDiv.textContent = 'Error posting reply';
            errorDiv.style.display = 'block';
        }
    })
    .catch(error => {
        errorDiv.textContent = 'Error posting reply';
        errorDiv.style.display = 'block';
    })
    .finally(() => {
        sendBtn.disabled = false;
        sendBtn.innerHTML = '➤ Send';
    });
});
</script>

@endsection
