@extends('layouts.admin')

@section('title', 'Announcements')

@section('content')

<div class="page-header">
    <div>
        <h1>Announcements</h1>
        <p>Manage site-wide announcement banners</p>
    </div>
</div>

<div class="grid-2" style="align-items:start">
    {{-- List --}}
    <div class="admin-card">
        <h3 style="font-size:1rem;font-weight:700;color:var(--text-header);margin-bottom:1.25rem">Active Announcements</h3>
        @forelse($announcements as $ann)
        <div style="border:1px solid var(--border-subtle);border-radius:10px;padding:1rem;margin-bottom:1rem">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:.5rem">
                <div>
                    <span class="badge badge-{{ $ann->is_active ? 'published' : 'archived' }}" style="margin-bottom:.4rem">{{ $ann->is_active ? 'Active' : 'Inactive' }}</span>
                    <div style="font-weight:600;color:var(--text-header)">{{ $ann->title }}</div>
                </div>
                <div style="display:flex;flex-direction:column;align-items:flex-end;gap:.4rem">
                    <span style="font-size:.75rem;padding:.25rem .65rem;border-radius:999px;background:var(--bg-subtle);color:var(--text-muted)">{{ ucfirst($ann->style) }}</span>
                    <span style="font-size:.65rem;font-weight:600;color:var(--accent);text-transform:uppercase">{{ str_replace('-', ' ', $ann->animation_type) }}</span>
                </div>
            </div>
            <p style="font-size:.85rem;color:var(--text-muted);margin-bottom:.75rem">{{ Str::limit($ann->content, 80) }}</p>
            <div style="display:flex;gap:.5rem">
                    <form id="delete-ann-{{ $ann->id }}" action="{{ route('admin.announcements.destroy', $ann) }}" method="POST" style="display: none;">
                        @csrf @method('DELETE')
                    </form>
                    <button type="button" onclick="openDeleteModal('delete-ann-{{ $ann->id }}', 'Are you sure you want to delete this announcement? It will be removed from the public frontend immediately.')" class="btn btn-danger btn-sm">Delete</button>
            </div>
        </div>
        @empty
        <p style="color:var(--text-muted);text-align:center;padding:1rem">No announcements created yet.</p>
        @endforelse
        <div style="margin-top:1rem">{{ $announcements->links() }}</div>
    </div>

    {{-- Create Form --}}
    <div class="admin-card">
        <h3 style="font-size:1rem;font-weight:700;color:var(--text-header);margin-bottom:1.25rem">New Announcement</h3>
        <form method="POST" action="{{ route('admin.announcements.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Title *</label>
                <input type="text" name="title" class="form-control" required placeholder="Announcement title">
            </div>
            <div class="form-group">
                <label class="form-label">Content *</label>
                <textarea name="content" class="form-control" rows="4" required placeholder="Announcement message..."></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Style</label>
                <select name="style" class="form-control">
                    <option value="info">🔵 Info</option>
                    <option value="success">🟢 Success</option>
                    <option value="warning">🟡 Warning</option>
                    <option value="danger">🔴 Danger</option>
                    <option value="premium">⭐ Premium</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Animation Type</label>
                <select name="animation_type" class="form-control">
                    <option value="none">None (Static)</option>
                    <option value="fade">✨ Fade (Breathing)</option>
                    <option value="slide-down">🔽 Slide Down (Smooth Entry)</option>
                    <option value="pulse">💗 Pulse (Attention)</option>
                    <option value="shimmer">💿 Shimmer (Light Sweep)</option>
                    <option value="bounce">🏀 Bounce (Playful)</option>
                    <option value="marquee">🏃 Marquee (Scrolling)</option>
                    <option value="glow">🌟 Glow (Premium Breath)</option>
                    <option value="float">☁️ Float (3D Hover)</option>
                    <option value="slide-right">➡️ Slide Right (Dynamic)</option>
                    <option value="typing">⌨️ Typing (High Impact)</option>
                </select>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Start Date</label>
                    <input type="datetime-local" name="start_at" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">End Date</label>
                    <input type="datetime-local" name="end_at" class="form-control">
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem;padding:.75rem;background:rgba(16,185,129,.1);border-radius:8px;border:1px solid rgba(16,185,129,.2)">
                <input type="checkbox" name="is_active" id="is_active" value="1" checked style="width:18px;height:18px;accent-color:#10b981">
                <label for="is_active" style="color:#10b981;font-weight:600;cursor:pointer">✓ Active immediately</label>
            </div>
            <button type="submit" class="btn btn-primary-admin" style="width:100%">Create Announcement</button>
        </form>
    </div>
</div>

@endsection
