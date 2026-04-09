<x-guest-layout>
    <h2>Forgot Password?</h2>
    <p class="subtitle">Enter your email and we'll send you a reset link.</p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-input" value="{{ old('email') }}" required autofocus placeholder="you@example.com">
            @error('email')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-login">Email Reset Link</button>
    </form>

    <div class="mt-4 text-center">
        <a href="{{ route('login') }}" class="forgot-link">Back to Login</a>
    </div>
</x-guest-layout>
