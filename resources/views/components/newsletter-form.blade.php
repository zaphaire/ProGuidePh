<div class="newsletter-form relative overflow-hidden" x-data="newsletterForm()">
    <div class="relative z-10 bg-gradient-to-br from-indigo-600 via-blue-600 to-violet-700 rounded-2xl p-8 md:p-10 shadow-2xl">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/20 to-violet-500/20 pointer-events-none"></div>
        
        <div class="relative flex flex-col md:flex-row items-start md:items-center gap-8">
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-blue-200" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                    </svg>
                    <span class="text-blue-200 text-sm font-medium uppercase tracking-wider">Newsletter</span>
                </div>
                
                <h3 class="text-2xl md:text-3xl font-bold text-white mb-3">Stay in the loop</h3>
                <p class="text-blue-100 text-base leading-relaxed max-w-md">Get the latest guides, tutorials, and learning resources delivered straight to your inbox. No spam, ever.</p>
                
                <div class="flex items-center gap-4 mt-6">
                    <div class="flex -space-x-2">
                        <div class="w-8 h-8 rounded-full bg-white/20 border-2 border-white flex items-center justify-center text-white text-xs font-bold">A</div>
                        <div class="w-8 h-8 rounded-full bg-white/30 border-2 border-white flex items-center justify-center text-white text-xs font-bold">B</div>
                        <div class="w-8 h-8 rounded-full bg-white/40 border-2 border-white flex items-center justify-center text-white text-xs font-bold">+</div>
                    </div>
                    <span class="text-blue-200 text-sm">Join 1,000+ learners</span>
                </div>
            </div>
            
            <div class="w-full md:w-auto md:min-w-80">
                <form @submit.prevent="submit" class="space-y-4">
                    <div class="relative">
                        <input 
                            x-model="email"
                            type="email" 
                            name="email" 
                            placeholder="Enter your email address" 
                            required
                            :class="{'border-red-400': error, 'border-white/30': !error}"
                            @input="error = ''"
                            class="w-full px-5 py-4 bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 text-white placeholder-blue-200/70 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-white/40 transition-all"
                        >
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 text-blue-200/50">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <button 
                        type="submit" 
                        :disabled="loading"
                        class="w-full px-6 py-4 bg-white text-blue-600 font-bold rounded-xl hover:bg-blue-50 disabled:opacity-70 disabled:cursor-not-allowed transition-all duration-300 flex items-center justify-center gap-2 shadow-lg hover:shadow-xl hover:-translate-y-0.5"
                    >
                        <span x-show="!loading" class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                            </svg>
                            Subscribe Now
                        </span>
                        <span x-show="loading" class="flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Subscribing...
                        </span>
                    </button>
                    
                    <p class="text-center text-blue-200/70 text-xs">No spam. Unsubscribe anytime.</p>
                </form>
                
                <div x-show="message" x-transition class="mt-4 p-3 rounded-lg backdrop-blur-sm" :class="messageType === 'success' ? 'bg-green-500/20 border border-green-400/30' : 'bg-red-500/20 border border-red-400/30'">
                    <p class="text-sm flex items-center gap-2" :class="messageType === 'success' ? 'text-green-200' : 'text-red-200'">
                        <svg x-show="messageType === 'success'" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <svg x-show="messageType === 'error'" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <span x-text="message"></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-blue-400/20 rounded-full blur-3xl"></div>
    <div class="absolute -top-20 -right-20 w-40 h-40 bg-violet-400/20 rounded-full blur-3xl"></div>
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