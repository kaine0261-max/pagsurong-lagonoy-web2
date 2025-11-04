@extends(auth()->user()->role === 'business_owner' ? 'layouts.app' : 'layouts.customer')

@section('content')
<!-- Messenger-style messaging layout - Fixed 3-part structure -->
<div class="message-layout">
    <!-- 1. Fixed Header - Top -->
    <div class="message-header">
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

    <!-- 2. Scrollable Messages - Middle -->
    <div class="message-content" id="messages-container">
        @forelse($messages as $msg)
            <div class="flex {{ $msg->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }} mb-3">
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

    <!-- 3. Fixed Input Form - Bottom -->
    <form action="{{ route('messages.send') }}" method="POST" class="message-input">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $user->id }}">
        <textarea 
            name="content" 
            rows="1" 
            id="message-input"
            class="flex-1 bg-gray-100 border-0 rounded-full px-4 py-2 resize-none focus:outline-none focus:bg-gray-200 text-sm"
            placeholder="Type a message..."
            required></textarea>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white w-10 h-10 rounded-full transition-colors flex items-center justify-center flex-shrink-0 shadow-md">
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
    /* Remove padding from main content container */
    #main-content {
        padding: 0 !important;
        overflow: hidden !important;
    }
    
    /* Mobile Layout - 3 fixed sections */
    @media (max-width: 768px) {
        body {
            padding-top: 0 !important;
        }
        
        .message-layout {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 70px; /* Above bottom nav */
            display: flex;
            flex-direction: column;
            background: white;
            padding-top: 104px; /* Space for nav */
        }
        
        /* 1. Fixed Header at top */
        .message-header {
            background-color: #065f46; /* green-800 */
            padding: 12px;
            display: flex;
            align-items: center;
            flex-shrink: 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            z-index: 10;
        }
        
        /* 2. Scrollable content in middle */
        .message-content {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            background-color: #f9fafb; /* gray-50 */
            padding: 16px;
            -webkit-overflow-scrolling: touch;
        }
        
        /* 3. Fixed input at bottom */
        .message-input {
            background: white;
            padding: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            border-top: 1px solid #e5e7eb;
            flex-shrink: 0;
            box-shadow: 0 -2px 4px rgba(0,0,0,0.05);
        }
    }
    
    /* Desktop Layout */
    @media (min-width: 769px) {
        .message-layout {
            max-width: 48rem;
            margin: 1rem auto;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 600px;
        }
        
        .message-header {
            background-color: #065f46;
            padding: 12px;
            display: flex;
            align-items: center;
            flex-shrink: 0;
        }
        
        .message-content {
            flex: 1;
            overflow-y: auto;
            background-color: #f9fafb;
            padding: 16px;
        }
        
        .message-input {
            background: white;
            padding: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            border-top: 1px solid #e5e7eb;
            flex-shrink: 0;
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
    
    .message-content > div {
        animation: slideIn 0.3s ease-out;
    }
</style>
@endsection