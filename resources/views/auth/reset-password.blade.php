<x-guest-layout>
    <h2>Set New Password</h2>
    <p class="subtitle">Please enter your new password below.</p>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="form-group">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-input" value="{{ old('email', $request->email) }}" required autofocus placeholder="you@example.com">
            @error('email')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">New Password</label>
            <input type="password" name="password" class="form-input" required placeholder="••••••••">
            @error('password')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-input" required placeholder="••••••••">
            @error('password_confirmation')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-login">Reset Password</button>
    </form>
</x-guest-layout>
