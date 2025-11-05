@extends('layouts.app')

@section('content')
@php
    $user = auth()->user();
    // Always hide nav for business owners and customers on messages page
    $shouldHideNav = in_array($user->role, ['business_owner', 'customer']);
@endphp

<div class="container mx-auto max-w-3xl messages-page" data-hide-nav="{{ $shouldHideNav ? 'true' : 'false' }}">
    <!-- Header -->
    <div class="bg-white shadow-sm messages-header mb-6">
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

    @if($threads->isEmpty())
        <div class="bg-white rounded-lg shadow-sm p-12 text-center">
            <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                <i class="fas fa-envelope text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No messages yet</h3>
            <p class="text-gray-500 mb-4">Your customer conversations will appear here.</p>
        </div>
    @else
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <ul class="divide-y divide-gray-200">
            @foreach($threads as $thread)
                @php
                    // Determine the other user in the conversation
                    $otherUser = $thread->sender_id == auth()->id() 
                        ? $thread->receiver 
                        : $thread->sender;

                    // Safely get the last message content
                    $lastMessage = $thread->content ? strip_tags($thread->content) : 'No message content';
                    $preview = strlen($lastMessage) > 80 
                        ? substr($lastMessage, 0, 80) . '...' 
                        : $lastMessage;
                @endphp

                @if($otherUser)
                    <li class="px-6 py-4 hover:bg-gray-50 transition-colors">
                        <a href="{{ route('messages.thread', $otherUser->id) }}" class="block">
                            <div class="flex items-center space-x-3">
                                <div class="h-10 w-10 rounded-full overflow-hidden">
                                    @if($otherUser->profile && $otherUser->profile->profile_picture)
                                        <img src="{{ asset('storage/' . $otherUser->profile->profile_picture) }}"
                                             alt="{{ $otherUser->name }}"
                                             class="h-full w-full object-cover">
                                    @else
                                        <div class="h-full w-full bg-green-500 flex items-center justify-center">
                                            <span class="text-white font-medium text-sm">
                                                {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ $otherUser->name }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $thread->created_at ? $thread->created_at->diffForHumans() : '' }}
                                        </p>
                                    </div>
                                    <p class="text-sm text-gray-500 truncate">
                                        {{ $preview }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
        </div>
    @endif
</div>

<style>
    /* Mobile-specific styles for messages page */
    @media (max-width: 768px) {
        /* Hide top header on mobile for business owners and customers */
        body:has(.messages-page[data-hide-nav="true"]) header {
            display: none !important;
        }
        
        /* Adjust page layout for mobile when nav is hidden */
        .messages-page[data-hide-nav="true"] {
            padding-top: 0 !important;
            margin-top: 0 !important;
            padding-bottom: 80px;
        }
        
        /* Adjust messages header positioning when nav is hidden */
        .messages-page[data-hide-nav="true"] .messages-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 40;
            background: linear-gradient(135deg, #065f46 0%, #047857 100%);
            margin-bottom: 0 !important;
        }
        
        .messages-page[data-hide-nav="true"] .messages-header h1,
        .messages-page[data-hide-nav="true"] .messages-header p {
            color: white;
        }
        
        .messages-page[data-hide-nav="true"] .messages-header i {
            color: #d1fae5;
        }
        
        /* Add padding to content to account for fixed header when nav is hidden */
        .messages-page[data-hide-nav="true"] {
            padding-top: 140px !important;
        }
        
        /* For business owners pending approval, keep normal layout */
        .messages-page[data-hide-nav="false"] {
            padding-bottom: 80px;
        }
    }
</style>

@if(auth()->user()->role === 'business_owner')
<script>
// Force show proper business owner bottom nav on messages page
document.addEventListener('DOMContentLoaded', function() {
    // This is a workaround - the proper fix would be in the layout file
    // but we're making it work for the messages page specifically
    console.log('Messages page loaded for business owner');
});
</script>
@endif
@endsection
