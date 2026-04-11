<div class="newsletter-form" x-data="newsletterForm()">
    <div class="bg-gray-50 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Subscribe to our newsletter</h3>
        <p class="text-gray-600 mb-4">Get the latest posts delivered right to your inbox. No spam, unsubscribe anytime.</p>
        
        <form @submit.prevent="submit" class="flex flex-col sm:flex-row gap-3">
            @csrf
            <div class="flex-1">
                <input 
                    x-model="email"
                    type="email" 
                    name="email" 
                    placeholder="Enter your email" 
                    required
                    :class="{'border-red-500': error, 'border-gray-300': !error}"
                    @input="error = ''"
                    class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                >
            </div>
            <button 
                type="submit" 
                :disabled="loading"
                class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors flex items-center justify-center min-w-20"
            >
                <span x-show="!loading">Subscribe</span>
                <span x-show="loading" class="flex items-center">
                    <svg class="animate-spin h-5 w-5 mr-2" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
            </button>
        </form>
        
        <div x-show="message" :class="messageType === 'success' ? 'text-green-600' : 'text-red-600'" class="mt-3 text-sm">
            <span x-text="message"></span>
        </div>
    </div>
</div>

@push('scripts')
<script>
function newsletterForm() {
    return {
        email: '',
        loading: false,
        error: '',
        message: '',
        messageType: '',
        
        async submit() {
            this.loading = true;
            this.error = '';
            this.message = '';
            
            try {
                const response = await fetch('{{ route("newsletter.subscribe") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ email: this.email })
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    this.message = data.message || 'Thank you for subscribing!';
                    this.messageType = 'success';
                    this.email = '';
                } else {
                    if (data.errors?.email) {
                        this.error = data.errors.email[0];
                    } else {
                        this.error = data.message || 'Something went wrong. Please try again.';
                    }
                    this.messageType = 'error';
                }
            } catch (e) {
                this.error = 'Network error. Please try again.';
                this.messageType = 'error';
            }
            
            this.loading = false;
        }
    }
}
</script>
@endpush