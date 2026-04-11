<div class="newsletter-form" x-data="newsletterForm()">
    <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900">Subscribe to our newsletter</h3>
                <p class="text-sm text-gray-500">Get the latest posts delivered to your inbox</p>
            </div>
        </div>
        
        <div x-show="message" x-transition class="mb-4 p-3 rounded-lg" :class="messageType === 'success' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700'">
            <span x-text="message"></span>
        </div>
        
        <form x-show="!message || messageType === 'error'" @submit.prevent="submit">
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <input 
                        x-model="email"
                        type="email" 
                        name="email" 
                        placeholder="Enter your email address" 
                        required
                        :class="{'border-red-500': error, 'border-gray-300': !error}"
                        @input="error = ''"
                        class="w-full px-4 py-3 rounded-lg border bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-gray-900"
                    >
                </div>
                <button 
                    type="submit" 
                    :disabled="loading"
                    class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 disabled:opacity-70 disabled:cursor-not-allowed transition-colors flex items-center justify-center gap-2 min-w-32"
                >
                    <span x-show="!loading">Subscribe</span>
                    <span x-show="loading">
                        <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>
            </div>
        </form>
        
        <p x-show="!message" class="text-xs text-gray-400 mt-3">No spam. Unsubscribe anytime.</p>
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