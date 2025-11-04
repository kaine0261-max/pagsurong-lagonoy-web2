@extends(auth()->user()->role === 'business_owner' ? 'layouts.app' : 'layouts.customer')

@section('content')
<!-- Messenger-style messaging layout -->
<div class="flex flex-col h-screen md:h-auto md:container md:mx-auto md:max-w-3xl md:mt-4 md:rounded-lg md:shadow-lg bg-white">
    <!-- Fixed Chat Header - directly under nav bar -->
    <div class="bg-green-800 shadow-sm p-4 flex items-center flex-shrink-0 sticky top-0 z-40 md:rounded-t-lg">
        <a href="{{ auth()->user()->role === 'business_owner' ? route('messages.index') : route('customer.messages') }}" class="text-white hover:text-green-200 mr-3">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div class="flex items-center flex-1">
            <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-white">
                @if($user->profile && $user->profile->profile_picture)
                    <img src="{{ asset('storage/' . $user->profile->profile_picture) }}"
                         alt="{{ $user->name }}"
                         class="h-full w-full object-cover">
                @else
                    <div class="h-full w-full bg-green-400 flex items-center justify-center">
                        <span class="text-white font-bold text-lg">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                    </div>
                @endif
            </div>
            <div class="ml-3">
                <h2 class="font-semibold text-base text-white">{{ $user->name }}</h2>
                <p class="text-xs text-green-200">
                    {{ ucfirst(str_replace('_', ' ', $user->role ?? '')) }}
                </p>
            </div>
        </div>
    </div>

    <!-- Messages Container - Scrollable area -->
    <div class="flex-1 overflow-y-auto bg-gray-50 p-4 space-y-3" id="messages-container">
        @forelse($messages as $msg)
            <div class="flex {{ $msg->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[75%] px-4 py-2 rounded-2xl shadow-sm
                    {{ $msg->sender_id == auth()->id() ? 'bg-green-600 text-white rounded-br-sm' : 'bg-white border border-gray-200 rounded-bl-sm' }}">
                    <div class="break-words text-sm">{!! nl2br(e($msg->content)) !!}</div>

                    @if($msg->order)
                        <div class="mt-2 text-xs italic border-t pt-1 
                            {{ $msg->sender_id == auth()->id() ? 'border-green-400 text-green-100' : 'border-gray-200 text-gray-600' }}">
                            🔗 Refers to Order #{{ $msg->order->id }}
                        </div>
                    @endif

                    <div class="text-xs opacity-70 mt-1">
                        {{ $msg->created_at->format('g:i A') }}
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <i class="fas fa-comments text-gray-300 text-5xl mb-3"></i>
                <p class="text-gray-500 text-sm">No messages yet. Start the conversation!</p>
            </div>
        @endforelse
    </div>

    <!-- Fixed Send Form - stays at bottom -->
    <form action="{{ route('messages.send') }}" method="POST" class="bg-white p-3 flex items-center space-x-2 border-t border-gray-200 flex-shrink-0 md:rounded-b-lg">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $user->id }}">
        <textarea 
            name="content" 
            rows="1" 
            id="message-input"
            class="flex-1 bg-gray-100 border-0 rounded-full px-4 py-2 resize-none focus:outline-none focus:bg-gray-200 text-sm"
            placeholder="Type a message..."
            required></textarea>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white w-10 h-10 rounded-full transition-colors flex items-center justify-center flex-shrink-0">
            <i class="fas fa-paper-plane text-sm"></i>
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
        /* Ensure full-screen messaging on mobile */
        .flex.flex-col.h-screen {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            padding-top: 56px; /* Space for main nav */
            padding-bottom: 70px; /* Space for bottom nav */
        }
        
        /* Messages container takes remaining space */
        #messages-container {
            flex: 1;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Sticky header stays below main nav */
        .sticky.top-0 {
            top: 56px !important;
        }
    }
    
    /* Desktop styles */
    @media (min-width: 769px) {
        .flex.flex-col.h-screen {
            position: relative !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }
        
        #messages-container {
            min-height: 500px;
            max-height: 600px;
        }
        
        .sticky.top-0 {
            top: 0 !important;
        }
    }
    
    /* Message bubble animations */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    #messages-container > div {
        animation: slideIn 0.3s ease-out;
    }
</style>
@endsection