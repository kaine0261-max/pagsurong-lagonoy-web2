@extends(auth()->user()->role === 'business_owner' ? 'layouts.app' : 'layouts.customer')

@section('content')
<!-- Messenger-style messaging layout - Fixed 3-part structure -->
<div class="message-layout">
    <!-- 1. Fixed Header - Top -->
    <div class="message-header">
        <a href="javascript:history.back()" class="text-white hover:text-green-200 mr-3">
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
            @if($msg->order)
                <!-- Order Card Message -->
                <div class="flex {{ $msg->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }} mb-4">
                    <div class="max-w-[85%] bg-green-600 text-white rounded-lg shadow-md p-4">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-receipt mr-2"></i>
                            <span class="font-semibold">New Order #{{ $msg->order->id }}</span>
                        </div>
                        <div class="text-sm space-y-1">
                            <p><strong>Customer:</strong> {{ $msg->order->customer->name ?? 'N/A' }}</p>
                            <p><strong>Pickup Time:</strong> {{ $msg->order->pickup_time ?? 'N/A' }}</p>
                            <div class="mt-2">
                                <p class="font-semibold">Order Details:</p>
                                @if($msg->order->orderItems && $msg->order->orderItems->count() > 0)
                                    @foreach($msg->order->orderItems as $item)
                                        <p>• {{ $item->product->name ?? 'Product' }} x {{ $item->quantity }} = ₱{{ number_format($item->price * $item->quantity, 2) }}</p>
                                    @endforeach
                                @endif
                            </div>
                            <p class="mt-2"><strong>Total:</strong> ₱{{ number_format($msg->order->total_amount, 2) }}</p>
                        </div>
                        <div class="text-xs opacity-80 mt-2 pt-2 border-t border-green-400 flex items-center">
                            <i class="fas fa-link mr-1"></i>
                            Refers to Order #{{ $msg->order->id }}
                        </div>
                        <div class="text-xs opacity-70 mt-1">
                            {{ $msg->created_at->format('g:i A') }}
                        </div>
                    </div>
                </div>
            @else
                <!-- Regular Text Message -->
                <div class="flex {{ $msg->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }} mb-3">
                    <div class="max-w-[75%] px-4 py-2 rounded-2xl shadow-sm
                        {{ $msg->sender_id == auth()->id() ? 'bg-green-600 text-white rounded-br-sm' : 'bg-white border border-gray-200 rounded-bl-sm' }}">
                        <div class="break-words text-sm">{!! nl2br(e($msg->content)) !!}</div>
                        <div class="text-xs opacity-70 mt-1">
                            {{ $msg->created_at->format('g:i A') }}
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div class="text-center py-12">
                <i class="fas fa-comments text-gray-300 text-5xl mb-3"></i>
                <p class="text-gray-500 text-sm">No messages yet. Start the conversation!</p>
            </div>
        @endforelse
    </div>

    <!-- 3. Fixed Input Form - Bottom -->
    <form id="message-form" action="{{ route('messages.send') }}" method="POST" class="message-input">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $user->id }}">
        <textarea 
            name="content" 
            rows="1" 
            id="message-input"
            class="flex-1 bg-gray-100 border-0 rounded-full px-4 py-2 resize-none focus:outline-none focus:bg-gray-200 text-sm"
            placeholder="Type a message..."
            required></textarea>
        <button type="submit" id="send-button" class="bg-green-600 hover:bg-green-700 text-white w-10 h-10 rounded-full transition-colors flex items-center justify-center flex-shrink-0 shadow-md">
            <i class="fas fa-paper-plane text-sm"></i>
        </button>
    </form>
</div>

<!-- Auto-scroll to bottom and handle textarea auto-resize -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('messages-container');
    const textarea = document.getElementById('message-input');
    const messageForm = document.getElementById('message-form');
    const sendButton = document.getElementById('send-button');
    let lastMessageId = {{ $messages->last()->id ?? 0 }};
    let isUserScrolling = false;
    let scrollTimeout;
    let isSending = false;
    
    // Scroll to bottom on load
    function scrollToBottom() {
        if (container && !isUserScrolling) {
            container.scrollTop = container.scrollHeight;
        }
    }
    
    scrollToBottom();
    
    // Detect user scrolling
    container.addEventListener('scroll', () => {
        const isAtBottom = container.scrollHeight - container.scrollTop <= container.clientHeight + 50;
        isUserScrolling = !isAtBottom;
        
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(() => {
            if (isAtBottom) {
                isUserScrolling = false;
            }
        }, 1000);
    });
    
    // Auto-resize textarea
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        });
    }
    
    // Handle form submission via AJAX
    messageForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        if (isSending) return;
        
        const content = textarea.value.trim();
        if (!content) return;
        
        isSending = true;
        sendButton.disabled = true;
        
        try {
            const formData = new FormData(messageForm);
            const response = await fetch(messageForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (response.ok) {
                // Clear textarea
                textarea.value = '';
                textarea.style.height = 'auto';
                
                // Add message to UI immediately
                const messageDiv = document.createElement('div');
                messageDiv.className = 'flex justify-end mb-3';
                messageDiv.style.animation = 'slideIn 0.3s ease-out';
                
                const bubbleDiv = document.createElement('div');
                bubbleDiv.className = 'max-w-[75%] px-4 py-2 rounded-2xl shadow-sm bg-green-600 text-white rounded-br-sm';
                
                const now = new Date();
                const timeStr = now.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
                
                bubbleDiv.innerHTML = `
                    <div class="break-words text-sm">${content.replace(/\n/g, '<br>')}</div>
                    <div class="text-xs opacity-70 mt-1">${timeStr}</div>
                `;
                
                messageDiv.appendChild(bubbleDiv);
                container.appendChild(messageDiv);
                
                scrollToBottom();
                
                // Wait a bit before fetching to get the actual message ID
                setTimeout(async () => {
                    try {
                        const fetchResponse = await fetch(`{{ route('messages.fetch', $user->id) }}?last_message_id=${lastMessageId}`);
                        const data = await fetchResponse.json();
                        if (data.messages && data.messages.length > 0) {
                            lastMessageId = Math.max(...data.messages.map(m => m.id));
                        }
                    } catch (err) {
                        console.error('Error updating message ID:', err);
                    }
                }, 500);
            }
        } catch (error) {
            console.error('Error sending message:', error);
            alert('Failed to send message. Please try again.');
        } finally {
            isSending = false;
            sendButton.disabled = false;
            textarea.focus();
        }
    });
    
    // Fetch new messages every 2 seconds
    setInterval(async () => {
        try {
            const response = await fetch(`{{ route('messages.fetch', $user->id) }}?last_message_id=${lastMessageId}`);
            const data = await response.json();
            
            if (data.messages && data.messages.length > 0) {
                data.messages.forEach(msg => {
                    // Create message bubble
                    const messageDiv = document.createElement('div');
                    messageDiv.className = `flex ${msg.is_mine ? 'justify-end' : 'justify-start'} mb-3`;
                    messageDiv.style.animation = 'slideIn 0.3s ease-out';
                    
                    const bubbleDiv = document.createElement('div');
                    bubbleDiv.className = `max-w-[75%] px-4 py-2 rounded-2xl shadow-sm ${
                        msg.is_mine 
                            ? 'bg-green-600 text-white rounded-br-sm' 
                            : 'bg-white border border-gray-200 rounded-bl-sm'
                    }`;
                    
                    bubbleDiv.innerHTML = `
                        <div class="break-words text-sm">${msg.content.replace(/\n/g, '<br>')}</div>
                        <div class="text-xs opacity-70 mt-1">${msg.created_at}</div>
                    `;
                    
                    messageDiv.appendChild(bubbleDiv);
                    container.appendChild(messageDiv);
                    
                    lastMessageId = msg.id;
                });
                
                // Scroll to bottom if user is not scrolling
                scrollToBottom();
                
                // Play notification sound (optional)
                if (!data.messages[0].is_mine) {
                    // You can add a notification sound here
                    console.log('New message received!');
                }
            }
        } catch (error) {
            console.error('Error fetching messages:', error);
        }
    }, 2000); // Check every 2 seconds
});
</script>

<style>
    /* Reset main content padding */
    #main-content {
        padding: 0 !important;
        overflow: hidden !important;
        margin: 0 !important;
    }
    
    /* Mobile Layout */
    @media (max-width: 768px) {
        /* Hide top header on mobile for full-screen messaging */
        header {
            display: none !important;
        }
        
        /* Hide bottom navigation bar on mobile */
        nav[class*="bottom"],
        .fixed.bottom-0,
        [class*="mobile-nav"],
        footer {
            display: none !important;
        }
        
        body {
            overflow: hidden;
        }
        
        .message-layout {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            background: white;
            z-index: 50;
        }
        
        .message-header {
            background-color: #065f46;
            padding: 16px 12px;
            display: flex;
            align-items: center;
            flex-shrink: 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            min-height: 64px;
        }
        
        .message-content {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            background-color: #f9fafb;
            padding: 16px;
            padding-bottom: 80px;
            -webkit-overflow-scrolling: touch;
        }
        
        .message-input {
            background: #ffffff !important;
            background-color: #ffffff !important;
            padding: 12px 16px;
            padding-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-top: 1px solid #e5e7eb;
            flex-shrink: 0;
            box-shadow: 0 -2px 8px rgba(0,0,0,0.1);
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 100;
            min-height: 60px;
            opacity: 1 !important;
        }
        
        .message-input textarea {
            max-height: 100px;
        }
        
        .message-input button {
            width: 44px;
            height: 44px;
        }
    }
    
    /* Desktop Layout */
    @media (min-width: 769px) {
        .message-layout {
            max-width: 48rem;
            margin: 2rem auto;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            height: calc(100vh - 200px);
            min-height: 500px;
            max-height: 700px;
            background: white;
            overflow: hidden;
        }
        
        .message-header {
            background-color: #065f46;
            padding: 16px;
            display: flex;
            align-items: center;
            flex-shrink: 0;
            border-radius: 0.5rem 0.5rem 0 0;
        }
        
        .message-content {
            flex: 1;
            overflow-y: auto;
            background-color: #f9fafb;
            padding: 20px;
            padding-bottom: 20px;
        }
        
        .message-input {
            background: white;
            padding: 16px;
            display: flex !important;
            align-items: center;
            gap: 12px;
            border-top: 1px solid #e5e7eb;
            flex-shrink: 0;
            border-radius: 0 0 0.5rem 0.5rem;
            min-height: 70px;
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
