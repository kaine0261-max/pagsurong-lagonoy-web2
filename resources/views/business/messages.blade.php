@extends('layouts.app')

@section('title', 'Messages')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
            <div class="text-center">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-envelope mr-2 md:mr-3 text-green-600"></i>
                    Messages
                </h1>
                <p class="text-sm md:text-base text-gray-600 max-w-2xl mx-auto">
                    Chat with your customers about their orders
                </p>
            </div>
        </div>
    </div>

    <!-- Messages List -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(isset($threads) && $threads->count() > 0)
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <ul class="divide-y divide-gray-200">
                @foreach($threads as $thread)
                    @php
                        $otherUser = $thread->sender_id == auth()->id() ? $thread->receiver : $thread->sender;
                        $lastMessage = \App\Models\Message::where('id', $thread->last_id)->first();
                    @endphp
                    <li class="px-6 py-4 hover:bg-gray-50 transition-colors">
                        <a href="{{ route('messages.thread', $otherUser) }}" class="block">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="h-12 w-12 rounded-full bg-green-600 flex items-center justify-center">
                                        <span class="text-white font-medium">
                                            {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ $otherUser->name }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $lastMessage ? $lastMessage->created_at->diffForHumans() : '' }}
                                        </p>
                                    </div>
                                    <p class="text-sm text-gray-500 truncate">
                                        {{ $lastMessage ? \Illuminate\Support\Str::limit($lastMessage->content, 50) : 'No messages yet' }}
                                    </p>
                                    @if($thread->order_id)
                                        <p class="text-xs text-green-600 font-medium mt-1">
                                            <i class="fas fa-receipt mr-1"></i>Order #{{ $thread->order_id }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-envelope text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No messages yet</h3>
                <p class="text-gray-500 mb-4">Order confirmations and customer messages will appear here</p>
            </div>
        @endif
    </div>
</div>
@endsection
