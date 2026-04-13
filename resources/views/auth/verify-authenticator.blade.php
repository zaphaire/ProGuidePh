<x-guest-layout>
    <h2>Authenticator Verification</h2>
    <p class="subtitle">Enter the 6-digit code from your authenticator app</p>

    @if($errors->any())
        <div style="background: #fee2e2; color: #991b1b; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1rem; font-size: 0.875rem;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('2fa.authenticator.verify') }}">
        @csrf
        <div class="form-group">
            <label class="form-label">Verification Code</label>
            <input type="text" name="code" class="form-input" required autofocus placeholder="000000" maxlength="6" pattern="[0-9]*" inputmode="numeric" style="letter-spacing: 8px; text-align: center; font-size: 24px;">
            @error('code')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-login">Verify</button>
    </form>

    <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
        <a href="{{ route('2fa.select') }}" style="color: #6b7280; text-decoration: underline;">
            Back to choices
        </a>
    </div>

    <form method="POST" action="{{ route('2fa.cancel') }}" style="margin-top: 1rem;">
        @csrf
        <button type="submit" class="forgot-link" style="background: none; border: none; cursor: pointer; text-decoration: underline; color: #6b7280;">
            Cancel Login
        </button>
    </form>
</x-guest-layout>
