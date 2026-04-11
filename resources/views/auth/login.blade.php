<x-guest-layout>
    <h2>Welcome back!</h2>
    <p class="subtitle">Enter your credentials to access your account</p>

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
