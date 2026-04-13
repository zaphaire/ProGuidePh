@extends('layouts.admin')

@section('title', 'Users')

@section('content')

<div class="page-header">
    <div>
        <h1>Users</h1>
        <p>Manage admin accounts and roles</p>
    </div>
    <button onclick="document.getElementById('createUserModal').style.display='flex'" class="btn btn-primary-admin">+ New User</button>
</div>

<div class="admin-card">
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr><th>User</th><th>Role</th><th>Posts</th><th>2FA</th><th>Joined</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:.75rem">
                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover">
                            <div>
                                <div style="font-weight:600;color:var(--text-header)">{{ $user->name }}</div>
                                <div style="font-size:.78rem;color:var(--text-muted)">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span></td>
                    <td style="color:var(--primary)">{{ $user->posts_count }}</td>
                    <td>
                        @if($user->two_factor_enabled)
                            <span class="badge badge-green">2FA</span>
                        @else
                            <span class="badge badge-gray">No 2FA</span>
                        @endif
                    </td>
                    <td style="color:var(--text-muted);font-size:.8rem">{{ $user->created_at->format('M d, Y') }}</td>
                    <td>
                        <div style="display:flex;gap:.4rem">
                            @if($user->two_factor_enabled)
                                <form id="reset-2fa-{{ $user->id }}" action="{{ route('users.reset-2fa', $user) }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                <button type="button" onclick="openDeleteModal('reset-2fa-{{ $user->id }}', 'Reset this user\'s 2FA? They will need to set it up again.')" class="btn btn-warning btn-sm">Reset 2FA</button>
                            @endif
                            <form id="delete-user-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: none;">
                                @csrf @method('DELETE')
                            </form>
                            <button type="button" onclick="openDeleteModal('delete-user-{{ $user->id }}', 'Are you sure you want to delete this user? Their posts will remain but will no longer have an author.')" class="btn btn-danger btn-sm">Delete</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;color:var(--text-muted)">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:1rem">{{ $users->links() }}</div>
</div>

{{-- Create User Modal --}}
<div id="createUserModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:9999;align-items:center;justify-content:center;padding:1rem;">
    <div style="background:var(--bg-card);border-radius:16px;padding:2rem;width:460px;max-width:100%;border:1px solid var(--border-subtle);overflow-y:auto;max-height:90vh;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem">
            <h3 style="color:var(--text-header);font-weight:700">Create New User</h3>
            <button onclick="document.getElementById('createUserModal').style.display='none'" style="background:none;border:none;color:var(--text-muted);font-size:1.5rem;cursor:pointer">×</button>
        </div>
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="form-group"><label class="form-label">Name *</label><input type="text" name="name" class="form-control" required style="background:var(--bg-input);color:var(--text-main);border:1px solid var(--border-subtle)"></div>
            <div class="form-group"><label class="form-label">Email *</label><input type="email" name="email" class="form-control" required style="background:var(--bg-input);color:var(--text-main);border:1px solid var(--border-subtle)"></div>
            <div class="form-group">
                <label class="form-label">Role *</label>
                <select name="role" class="form-control" required style="background:var(--bg-input);color:var(--text-main);border:1px solid var(--border-subtle)">
                    <option value="viewer">Viewer</option>
                    <option value="editor">Editor</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form-group"><label class="form-label">Password *</label><input type="password" name="password" class="form-control" required minlength="8" style="background:var(--bg-input);color:var(--text-main);border:1px solid var(--border-subtle)"></div>
            <div class="form-group"><label class="form-label">Confirm Password *</label><input type="password" name="password_confirmation" class="form-control" required style="background:var(--bg-input);color:var(--text-main);border:1px solid var(--border-subtle)"></div>
            <div style="display:flex;gap:1rem;margin-top:1.25rem;flex-wrap:wrap;">
                <button type="submit" class="btn btn-primary-admin" style="flex:1;justify-content:center">Create User</button>
                <button type="button" onclick="document.getElementById('createUserModal').style.display='none'" class="btn btn-ghost" style="flex:1;justify-content:center">Cancel</button>
            </div>
        </form>
    </div>
</div>

@endsection
