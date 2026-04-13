<x-guest-layout>
    <h2>Two-Factor Authentication</h2>
    <p class="subtitle">Choose how you want to verify your identity</p>

    <div style="display: flex; flex-direction: column; gap: 1rem; margin-top: 2rem;">
        <form method="POST" action="{{ route('2fa.select') }}">
            @csrf
            <input type="hidden" name="method" value="email">
            <button type="submit" style="width: 100%; padding: 1.5rem; border: 2px solid #e5e7eb; border-radius: 12px; background: white; cursor: pointer; text-align: left; transition: all 0.2s;" onmouseover="this.style.borderColor='#4f46e5'" onmouseout="this.style.borderColor='#e5e7eb'">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 48px; height: 48px; background: #e0e7ff; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    </div>
                    <div>
                        <h3 style="margin: 0; font-size: 1.125rem; font-weight: 600; color: #111827;">Email Verification</h3>
                        <p style="margin: 0.25rem 0 0; font-size: 0.875rem; color: #6b7280;">Get a 6-digit code sent to your email</p>
                    </div>
                </div>
            </button>
        </form>

        <form method="POST" action="{{ route('2fa.select') }}">
            @csrf
            <input type="hidden" name="method" value="authenticator">
            <button type="submit" style="width: 100%; padding: 1.5rem; border: 2px solid #e5e7eb; border-radius: 12px; background: white; cursor: pointer; text-align: left; transition: all 0.2s;" onmouseover="this.style.borderColor='#4f46e5'" onmouseout="this.style.borderColor='#e5e7eb'">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 48px; height: 48px; background: #e0e7ff; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </div>
                    <div>
                        <h3 style="margin: 0; font-size: 1.125rem; font-weight: 600; color: #111827;">Authenticator App</h3>
                        <p style="margin: 0.25rem 0 0; font-size: 0.875rem; color: #6b7280;">Use Google Authenticator or similar app</p>
                    </div>
                </div>
            </button>
        </form>
    </div>

    <form method="POST" action="{{ route('2fa.cancel') }}" style="margin-top: 2rem;">
        @csrf
        <button type="submit" class="forgot-link" style="background: none; border: none; cursor: pointer; text-decoration: underline; color: #6b7280;">
            Cancel Login
        </button>
    </form>
</x-guest-layout>
