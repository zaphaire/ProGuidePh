<div class="newsletter-form">
    <div class="bg-gray-50 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Subscribe to our newsletter</h3>
        <p class="text-gray-600 mb-4">Get the latest posts delivered right to your inbox. No spam, unsubscribe anytime.</p>
        
        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
            @csrf
            <div class="flex-1">
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Enter your email" 
                    required
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
            <button 
                type="submit" 
                class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors"
            >
                Subscribe
            </button>
        </form>
        
        @if(session('message'))
            <p class="mt-3 text-sm text-green-600">{{ session('message') }}</p>
        @endif
        
        @error('email')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>