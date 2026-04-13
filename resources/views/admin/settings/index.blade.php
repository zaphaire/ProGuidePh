@extends('layouts.admin')

@section('title', 'Settings')

@section('content')

@php
$currentLogo = \App\Models\Setting::get('site_logo');
@endphp

<div class="page-header">
    <div>
        <h1>Site Settings</h1>
        <p>Configure your website appearance and metadata</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.settings.update') }}">
    @csrf

    {{-- Logo --}}
    <div class="admin-card" style="margin-bottom:1.5rem">
        <h3 style="font-size:1rem;font-weight:700;color:var(--text-header);margin-bottom:1.5rem;padding-bottom:.75rem;border-bottom:1px solid var(--border-subtle)">🖼️ Website Logo</h3>
        
        @if($currentLogo)
            @php
                if (str_starts_with($currentLogo, 'http')) {
                    $logoUrl = $currentLogo;
                } elseif (str_starts_with($currentLogo, 'logos/')) {
                    $logoUrl = asset('storage/' . $currentLogo);
                } else {
                    $logoUrl = asset('storage/logos/' . $currentLogo);
                }
            @endphp
            <div style="background: var(--bg-input); padding: 1rem; border-radius: 8px; border: 1px solid var(--border-subtle); margin-bottom: 1rem;">
                <p style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem;">Current Logo:</p>
                <img src="{{ $logoUrl }}" alt="Site Logo" style="max-width: 200px; max-height: 80px; object-fit: contain; background: white;" 
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                >
                <p style="display:none; color: #ef4444; font-size: 0.875rem;">Unable to load image. Please enter a new Google Drive link below.</p>
            </div>
        @endif
        
        <div>
            <label class="form-label">Logo URL (Google Drive, Dropbox, etc.)</label>
            <div style="display: flex; gap: 0.5rem;">
                <input type="url" name="site_logo" value="{{ $currentLogo ?? '' }}" class="form-control" placeholder="https://drive.google.com/uc?export=view&id=..." style="flex: 1;">
                <button type="submit" class="btn btn-primary-admin" style="white-space: nowrap;">Save Logo</button>
            </div>
            <small style="color: var(--text-muted); font-size: 0.75rem; display: block; margin-top: 0.5rem;">
                For Google Drive: Get share link → Copy the file ID (1itEJMdt2MnufDS9-qp-c9CQ1HVkqflwp) → Use: https://drive.google.com/uc?export=view&id=YOUR_FILE_ID
            </small>
            
            <div style="margin-top: 1rem; padding: 1rem; background: var(--bg-input); border-radius: 8px; border: 1px solid var(--border-subtle);">
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.5rem;"><strong>Quick Example for your link:</strong></p>
                <code style="font-size: 0.75rem; word-break: break-all; color: var(--accent);">https://drive.google.com/uc?export=view&id=1itEJMdt2MnufDS9-qp-c9CQ1HVkqflwp</code>
            </div>
        </div>
    </div>

    {{-- General --}}
    <div class="admin-card" style="margin-bottom:1.5rem">
        <h3 style="font-size:1rem;font-weight:700;color:var(--text-header);margin-bottom:1.5rem;padding-bottom:.75rem;border-bottom:1px solid var(--border-subtle)">🌐 General Settings</h3>
        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">Site Name</label>
                <input type="text" name="site_name" value="{{ $settings['site_name']->value ?? 'ProGuidePh' }}" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Tagline</label>
                <input type="text" name="site_tagline" value="{{ $settings['site_tagline']->value ?? '' }}" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Contact Email</label>
                <input type="email" name="site_email" value="{{ $settings['site_email']->value ?? '' }}" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Phone</label>
                <input type="text" name="site_phone" value="{{ $settings['site_phone']->value ?? '' }}" class="form-control">
            </div>
            <div class="form-group" style="grid-column:1/-1">
                <label class="form-label">Address / Location</label>
                <input type="text" name="site_address" value="{{ $settings['site_address']->value ?? '' }}" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Posts Per Page</label>
                <input type="number" name="posts_per_page" value="{{ $settings['posts_per_page']->value ?? 9 }}" class="form-control" min="1" max="50">
            </div>
            <div class="form-group">
                <label class="form-label">Footer Text</label>
                <input type="text" name="footer_text" value="{{ $settings['footer_text']->value ?? '' }}" class="form-control">
            </div>
        </div>
    </div>

    {{-- SEO --}}
    <div class="admin-card" style="margin-bottom:1.5rem">
        <h3 style="font-size:1rem;font-weight:700;color:var(--text-header);margin-bottom:1.5rem;padding-bottom:.75rem;border-bottom:1px solid var(--border-subtle)">🔍 SEO Settings</h3>
        <div class="form-group">
            <label class="form-label">Meta Description</label>
            <textarea name="meta_description" class="form-control" rows="3">{{ $settings['meta_description']->value ?? '' }}</textarea>
        </div>
        <div class="form-group">
            <label class="form-label">Meta Keywords</label>
            <input type="text" name="meta_keywords" value="{{ $settings['meta_keywords']->value ?? '' }}" class="form-control" placeholder="tips, guides, filipino, philippines, tambayan...">
        </div>
        <div class="form-group">
            <label class="form-label">OG Image URL</label>
            <input type="url" name="og_image" value="{{ $settings['og_image']->value ?? '' }}" class="form-control" placeholder="https://example.com/images/og-image.png">
            <small style="color:var(--text-muted);font-size:.75rem">Recommended size: 1200x630px</small>
        </div>
    </div>

    {{-- Social Media --}}
    <div class="admin-card" style="margin-bottom:1.5rem">
        <h3 style="font-size:1rem;font-weight:700;color:var(--text-header);margin-bottom:1.5rem;padding-bottom:.75rem;border-bottom:1px solid var(--border-subtle)">📱 Social Media</h3>
        <div class="grid-2">
            <div class="form-group">
                <label class="form-label"><svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" style="vertical-align:middle;margin-right:.25rem"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg> Facebook</label>
                <input type="url" name="social_facebook" value="{{ $settings['social_facebook']->value ?? '' }}" class="form-control" placeholder="https://facebook.com/yourpage">
            </div>
            <div class="form-group">
                <label class="form-label"><svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" style="vertical-align:middle;margin-right:.25rem"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg> X (Twitter)</label>
                <input type="url" name="social_twitter" value="{{ $settings['social_twitter']->value ?? '' }}" class="form-control" placeholder="https://x.com/yourhandle">
            </div>
            <div class="form-group">
                <label class="form-label"><svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" style="vertical-align:middle;margin-right:.25rem"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg> TikTok</label>
                <input type="url" name="social_tiktok" value="{{ $settings['social_tiktok']->value ?? '' }}" class="form-control" placeholder="https://tiktok.com/@yourhandle">
            </div>
            <div class="form-group">
                <label class="form-label"><svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" style="vertical-align:middle;margin-right:.25rem"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg> LinkedIn</label>
                <input type="url" name="social_linkedin" value="{{ $settings['social_linkedin']->value ?? '' }}" class="form-control" placeholder="https://linkedin.com/in/yourprofile">
            </div>
            <div class="form-group">
                <label class="form-label"><svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" style="vertical-align:middle;margin-right:.25rem"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg> Instagram</label>
                <input type="url" name="social_instagram" value="{{ $settings['social_instagram']->value ?? '' }}" class="form-control" placeholder="https://instagram.com/yourhandle">
            </div>
        </div>
    </div>

    {{-- System Maintenance --}}
    <div class="admin-card" style="margin-bottom:1.5rem; border:1px dashed var(--accent)">
        <div style="display:flex; justify-content:space-between; align-items:center">
            <div>
                <h3 style="font-size:1rem;font-weight:700;color:var(--text-header);margin-bottom:.5rem">🛠️ System Maintenance</h3>
                <p style="font-size:.8rem;color:var(--text-muted)">Synchronize core system pages and branding assets.</p>
            </div>
            <div>
                <button type="button" onclick="confirmSyncAbout()" class="btn btn-warning" style="font-weight:700">🔄 Sync About Page</button>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary-admin" style="padding:.7rem 2rem">💾 Save All Settings</button>
</form>

<form id="syncAboutForm" method="POST" action="{{ route('admin.settings.sync-about') }}" style="display:none">
    @csrf
</form>

<script>
    function confirmSyncAbout() {
        if (confirm('This will update the "About Us" page content with the latest ProGuidePh branding. Existing content on the About page will be overwritten. Proceed?')) {
            document.getElementById('syncAboutForm').submit();
        }
    }
</script>

@endsection
