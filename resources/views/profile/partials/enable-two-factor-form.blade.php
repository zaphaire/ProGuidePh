<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
    <div class="max-w-xl">
        <section>
            <header>
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Two-Factor Authentication') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    {{ __('Add an extra layer of security by enabling authenticator app.') }}
                </p>
            </header>

            @if(auth()->user()->two_factor_enabled)
                <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-md">
                    <p class="text-sm text-green-800">
                        {{ __('Authenticator app is enabled for your account.') }}
                    </p>
                    <form method="post" action="{{ route('2fa.disable') }}" class="mt-3">
                        @csrf
                        @method('delete')
                        <button type="submit" class="text-sm text-red-600 hover:text-red-800">
                            {{ __('Disable Authenticator') }}
                        </button>
                    </form>
                </div>
            @else
                <div class="mt-4">
                    @if(session('status') === 'two-factor-authenticator-enabled')
                        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-md">
                            <p class="text-sm text-green-800">{{ __('Authenticator enabled successfully.') }}</p>
                        </div>
                    @endif

                    <p class="text-sm text-gray-600 mb-4">
                        {{ __('Scan this QR code with your authenticator app (Google Authenticator, Authy, etc.):') }}
                    </p>

                    <div class="flex justify-center mb-4">
                        {!! $qrCode !!}
                    </div>

                    <p class="text-sm text-gray-600 mb-2">
                        {{ __('Or enter this secret key manually:') }}
                    </p>
                    <code class="block bg-gray-100 p-2 rounded text-sm mb-4">{{ $secret }}</code>

                    <form method="post" action="{{ route('2fa.enable') }}">
                        @csrf
                        <div class="mt-4">
                            <label class="form-label">{{ __('Enter code from authenticator app') }}</label>
                            <input type="text" name="code" class="form-input" required autofocus placeholder="000000" maxlength="6" pattern="[0-9]*" inputmode="numeric">
                            @error('code')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="btn-login mt-4">
                            {{ __('Enable Authenticator') }}
                        </button>
                    </form>
                </div>
            @endif
        </section>
    </div>
</div>
