<x-guest-layout>
    <h2>Welcome back!</h2>
    <p class="subtitle">Enter your credentials to access your account</p>

    @if($errors->any())
        <div style="background: #fee2e2; color: #991b1b; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1rem; font-size: 0.875rem;">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-input" value="{{ old('email') }}" required autofocus placeholder="you@example.com">
            @error('email')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-input" required placeholder="••••••••">
            @error('password')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-checkbox">
            <input type="checkbox" name="remember" id="remember_me">
            <label for="remember_me">Remember me</label>
        </div>

        <button type="submit" class="btn-login">Sign In</button>
    </form>

    @if (Route::has('password.request'))
        <a class="forgot-link" href="{{ route('password.request') }}">
            {{ __('Forgot your password?') }}
        </a>
    @endif
</x-guest-layout>
