@extends(auth()->user()->role === 'business_owner' ? 'layouts.app' : 'layouts.customer')

@section('content')
<!-- Mobile-optimized messaging layout -->
<div class="fixed inset-0 md:relative md:container md:mx-auto md:max-w-3xl md:mt-4 flex flex-col bg-white md:rounded-lg md:shadow-lg">
    <!-- Fixed Chat Header - stays at top on mobile, below main nav -->
    <div class="bg-white shadow-md p-4 flex items-center flex-shrink-0 fixed md:relative left-0 right-0 z-40 md:rounded-t-lg border-b md:border-0" style="top: 120px; background-color: #064e3b;">
        <a href="{{ auth()->user()->role === 'business_owner' ? route('messages.index') : route('customer.messages') }}" class="text-white hover:text-green-200 mr-3">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div class="flex items-center">
            <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-white">
                @if($user->profile && $user->profile->profile_picture)
                    <img src="{{ asset('storage/' . $user->profile->profile_picture) }}"
                         alt="{{ $user->name }}"
                         class="h-full w-full object-cover">
                @else
                    <div class="h-full w-full bg-green-400 flex items-center justify-center">
                        <span class="text-white font-bold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                    </div>
                @endif
            </div>
            <div class="ml-3">
                <h2 class="font-semibold text-lg text-white">{{ $user->name }}</h2>
                <p class="text-xs text-green-200">
                    {{ ucfirst(str_replace('_', ' ', $user->role ?? '')) }}
                </p>
            </div>
        </div>
    </div>

    <!-- Messages Container - Scrollable area between fixed header and input -->
    <div class="flex-1 overflow-y-auto bg-gray-100 p-4 space-y-3" id="messages-container">
        @forelse($messages as $msg)
            <div class="flex {{ $msg->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-xs px-4 py-2 rounded-lg shadow-sm
                    {{ $msg->sender_id == auth()->id() ? 'bg-green-600 text-white' : 'bg-white border' }}">
                    <div class="break-words">{!! nl2br(e($msg->content)) !!}</div>

                    @if($msg->order)
                        <div class="mt-2 text-xs italic border-t pt-1 
                            {{ $msg->sender_id == auth()->id() ? 'border-green-400 text-green-100' : 'text-gray-600' }}">
                            🔗 Refers to Order #{{ $msg->order->id }}
                        </div>
                    @endif

                    <div class="text-xs opacity-70 mt-1">
                        {{ $msg->created_at->format('H:i') }}
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-8">
                <i class="fas fa-comments text-gray-300 text-4xl mb-3"></i>
                <p class="text-gray-500">Start the conversation!</p>
            </div>
        @endforelse
    </div>

    <!-- Fixed Send Form - stays at bottom above bottom nav -->
    <form action="{{ route('messages.send') }}" method="POST" class="bg-white p-3 flex items-center space-x-2 border-t shadow-lg flex-shrink-0 fixed md:relative left-0 right-0 z-40 md:rounded-b-lg">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $user->id }}">
        <textarea 
            name="content" 
            rows="1" 
            id="message-input"
            class="flex-1 border border-gray-300 rounded-full px-4 py-2 resize-none focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200"
            placeholder="Type a message..."
            required></textarea>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-full transition-colors flex-shrink-0 shadow-md">
            <i class="fas fa-paper-plane"></i>
        </button>
    </form>
</div>

<!-- Auto-scroll to bottom and handle textarea auto-resize -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('messages-container');
    const textarea = document.getElementById('message-input');
    
    // Scroll to bottom on load
    if (container) {
        container.scrollTop = container.scrollHeight;
    }
    
    // Auto-resize textarea
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        });
    }
});
</script>

<style>
    /* Mobile-specific styles */
    @media (max-width: 768px) {
        /* Remove default padding/margin from body on message page */
        body {
            overflow: hidden;
        }
        
        /* Position messages container below header and above input */
        #messages-container {
            position: fixed;
            top: 192px; /* Below main nav (120px) + chat header (72px) */
            bottom: 140px; /* Above input form (70px) + bottom nav (70px) */
            left: 0;
            right: 0;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
        }
        
        /* Position input form above bottom nav */
        form[action*="messages.send"] {
            bottom: 70px !important; /* Above bottom nav */
        }
    }
    
    /* Desktop styles */
    @media (min-width: 769px) {
        #messages-container {
            position: relative !important;
            top: auto !important;
            bottom: auto !important;
            min-height: 500px;
            max-height: 600px;
        }
        
        form[action*="messages.send"] {
            position: relative !important;
            bottom: 0 !important;
        }
    }
</style>
@endsection