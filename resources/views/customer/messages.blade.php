@extends('layouts.customer')

@section('title', 'Messages')

@section('content')
<div class="min-h-screen bg-gray-50 messages-page">
    <!-- Header -->
    <div class="bg-white shadow-sm messages-header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
            <div class="text-center">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-envelope mr-2 md:mr-3 text-green-600"></i>
                    Messages
                </h1>
                <p class="text-sm md:text-base text-gray-600 max-w-2xl mx-auto">
                    Chat with business owners about your orders
                </p>
            </div>
        </div>
    </div>

    <!-- Messages List -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($threads->count() > 0)
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
                                    @if($otherUser->businessProfile)
                                        <p class="text-xs text-green-600 font-medium mt-1">
                                            {{ $otherUser->businessProfile->business_name }}
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

<style>
    /* Mobile-specific styles for messages page */
    @media (max-width: 768px) {
        /* Hide top header on mobile */
        .messages-page header {
            display: none !important;
        }
        
        /* Adjust page layout for mobile */
        .messages-page {
            padding-top: 0 !important;
            margin-top: 0 !important;
        }
        
        /* Adjust messages header positioning */
        .messages-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 40;
            background: linear-gradient(135deg, #065f46 0%, #047857 100%);
        }
        
        .messages-header h1,
        .messages-header p {
            color: white;
        }
        
        .messages-header i {
            color: #d1fae5;
        }
        
        /* Add padding to content to account for fixed header */
        .messages-page > div:last-child {
            padding-top: 140px;
            padding-bottom: 80px;
        }
    }
</style>
@endsection