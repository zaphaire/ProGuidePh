<x-guest-layout>
    <h2>Verify Your Login</h2>
    <p class="subtitle">Enter the 6-digit code sent to your email</p>

    @if($errors->any())
        <div style="background: #fee2e2; color: #991b1b; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1rem; font-size: 0.875rem;">
            {{ $errors->first() }}
        </div>
    @endif

    @if(session('status'))
        <div style="background: #dcfce7; color: #166534; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1rem; font-size: 0.875rem;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('otp.verify') }}">
        @csrf
        <div class="form-group">
            <label class="form-label">Verification Code</label>
            <input type="text" name="otp_code" class="form-input" required autofocus placeholder="000000" maxlength="6" pattern="[0-9]*" inputmode="numeric" style="letter-spacing: 8px; text-align: center; font-size: 24px;">
            @error('otp_code')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-login">Verify Code</button>
    </form>

    <form method="POST" action="{{ route('otp.resend') }}" style="margin-top: 1rem;">
        @csrf
        <button type="submit" class="forgot-link" style="background: none; border: none; cursor: pointer; text-decoration: underline;">
            Resend Code
        </button>
    </form>

    <form method="POST" action="{{ route('otp.cancel') }}" style="margin-top: 1rem;">
        @csrf
        <button type="submit" class="forgot-link" style="background: none; border: none; cursor: pointer; text-decoration: underline;">
            Cancel Login
        </button>
    </form>
</x-guest-layout>