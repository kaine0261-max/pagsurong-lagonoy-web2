@extends('layouts.customer')

@section('title', 'Messages')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-envelope mr-3 text-green-600"></i>
                    Messages
                </h1>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Chat with business owners about your orders
                </p>
            </div>
        </div>
    </div>

    <!-- Messages List -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @if($threads->count() > 0)
            <div class="bg-white shadow overflow-hidden rounded-lg">
                <ul class="divide-y divide-gray-200">
                    @foreach($threads as $thread)
                        @php
                            // Determine the other user in the conversation
                            $otherUser = $thread->sender_id == auth()->id() 
                                ? $thread->receiver 
                                : $thread->sender;

                            // Get the last message (assuming $thread has a last_id or use latest())
                            $lastMessage = \App\Models\Message::where('id', $thread->last_id ?? $thread->id)
                                ->first();
                            
                            // Count unread messages from this user
                            $unreadCount = \App\Models\Message::where('sender_id', $otherUser->id)
                                ->where('receiver_id', auth()->id())
                                ->whereNull('read_at')
                                ->count();
                            
                            // Check if last message is unread
                            $isUnread = $lastMessage && $lastMessage->receiver_id == auth()->id() && is_null($lastMessage->read_at);
                        @endphp

                        @if($otherUser)
                            <li class="px-6 py-4 hover:bg-gray-50 transition {{ $isUnread ? 'bg-blue-50' : '' }}">
                                <a href="{{ route('messages.thread', $otherUser) }}" class="block">
                                    <div class="flex items-center space-x-3">
                                        <!-- Profile Picture -->
                                        <div class="flex-shrink-0 h-10 w-10 sm:h-12 sm:w-12 rounded-full overflow-hidden relative">
                                            @if($otherUser->businessProfile && $otherUser->businessProfile->profile_avatar)
                                                <img src="{{ Storage::url($otherUser->businessProfile->profile_avatar) }}"
                                                     alt="{{ $otherUser->name }}"
                                                     class="h-full w-full object-cover">
                                            @elseif($otherUser->profile && $otherUser->profile->profile_picture)
                                                <img src="{{ Storage::url($otherUser->profile->profile_picture) }}"
                                                     alt="{{ $otherUser->name }}"
                                                     class="h-full w-full object-cover">
                                            @else
                                                <div class="h-full w-full bg-green-500 flex items-center justify-center">
                                                    <span class="text-white font-medium text-sm">
                                                        {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                            @endif
                                            
                                            <!-- Unread indicator dot on avatar -->
                                            @if($unreadCount > 0)
                                                <span class="absolute top-0 right-0 block h-3 w-3 rounded-full bg-red-500 ring-2 ring-white"></span>
                                            @endif
                                        </div>

                                        <!-- User Info & Message Preview -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <p class="text-sm font-medium truncate {{ $isUnread ? 'text-gray-900 font-bold' : 'text-gray-900' }}">
                                                    {{ $otherUser->name }}
                                                </p>
                                                <div class="flex items-center space-x-2">
                                                    <p class="text-xs text-gray-500">
                                                        {{ $lastMessage?->created_at->diffForHumans() ?? '' }}
                                                    </p>
                                                    @if($unreadCount > 0)
                                                        <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full">
                                                            {{ $unreadCount }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <p class="text-sm truncate {{ $isUnread ? 'text-gray-900 font-semibold' : 'text-gray-500' }}">
                                                @if($isUnread)
                                                    <i class="fas fa-circle text-blue-500 text-xs mr-1"></i>
                                                @endif
                                                {{ $lastMessage?->content ? Str::limit(strip_tags($lastMessage->content), 60) : 'No messages yet' }}
                                            </p>

                                            <!-- Show business name if available -->
                                            @if($otherUser->businessProfile)
                                                <p class="text-xs text-green-600 font-medium mt-1">
                                                    {{ $otherUser->businessProfile->business_name }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <div class="text-gray-400 mb-4">
                    <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No messages yet</h3>
                <p class="text-gray-500 mb-4">Start a conversation when you place an order with a business!</p>
                <a href="{{ route('customer.products') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 transition-colors">
                    <i class="fas fa-shopping-basket mr-2"></i>
                    Browse Products
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
