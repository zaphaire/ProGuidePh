<x-guest-layout>
    <h2>Set Up Authenticator</h2>
    <p class="subtitle">Scan the QR code with your authenticator app</p>

    @if($errors->any())
        <div style="background: #fee2e2; color: #991b1b; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1rem; font-size: 0.875rem;">
            {{ $errors->first() }}
        </div>
    @endif

    <div style="text-align: center;">
        <p class="text-sm text-gray-600 mb-4">
            Scan this QR code with your authenticator app (Google Authenticator, Authy, etc.):
        </p>

        <div class="flex justify-center mb-4">
            {!! $qrCode !!}
        </div>

        <p class="text-sm text-gray-600 mb-2">
            Or enter this secret key manually:
        </p>
        <code class="block bg-gray-100 p-2 rounded text-sm mb-4" style="word-break: break-all;">{{ $secret }}</code>

        <form method="POST" action="{{ route('2fa.authenticator.setup') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Enter code from authenticator app</label>
                <input type="text" name="code" class="form-input" required autofocus placeholder="000000" maxlength="6" pattern="[0-9]*" inputmode="numeric" style="letter-spacing: 8px; text-align: center; font-size: 24px;">
            </div>

            <button type="submit" class="btn-login">Verify & Complete Login</button>
        </form>
    </div>

    <div style="margin-top: 1.5rem; display: flex; gap: 1rem; justify-content: center;">
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
