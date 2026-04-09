@props(['light' => false, 'size' => 'w-20 h-20'])

<img src="{{ asset('images/logo.svg') }}" class="{{ $size }} fill-current" {{ $attributes }}>