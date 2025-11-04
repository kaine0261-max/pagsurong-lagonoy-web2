@extends('layouts.customer')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-shopping-bag mr-3 text-green-600"></i>
                    My Orders
                </h1>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Track your product reservations and pickup status
                </p>
            </div>
        </div>
    </div>

    <!-- Orders List -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($orders->count() > 0)
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <ul class="divide-y divide-gray-200">
                @foreach($orders as $order)
                    <li class="px-3 py-3 md:px-6 md:py-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start space-x-2 md:space-x-3">
                                    <div class="flex-shrink-0">
                                        @if($order->items->first() && $order->items->first()->product->image)
                                            <img class="h-12 w-12 md:h-16 md:w-16 rounded-lg object-cover" 
                                                 src="{{ asset('storage/' . $order->items->first()->product->image) }}" 
                                                 alt="{{ $order->items->first()->product->name }}">
                                        @else
                                            <div class="h-12 w-12 md:h-16 md:w-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-shopping-bag text-gray-400 text-lg md:text-xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm md:text-base font-semibold text-gray-900 truncate">
                                            Order #{{ $order->id }}
                                        </p>
                                        <p class="text-xs md:text-sm text-gray-600 truncate">
                                            {{ $order->items->first() ? $order->items->first()->product->name : 'Product' }}
                                            @if($order->items->count() > 1)
                                                <span class="text-gray-500">+{{ $order->items->count() - 1 }}</span>
                                            @endif
                                        </p>
                                        <p class="text-xs md:text-sm text-gray-500 truncate">
                                            <i class="fas fa-store mr-1"></i>{{ $order->business->name }}
                                        </p>
                                        <p class="text-xs md:text-sm font-medium text-gray-900 mt-0.5">
                                            Qty: {{ $order->items->sum('quantity') }} | 
                                            <span class="text-green-600">₱{{ number_format($order->items->sum(function($item) { return $item->price * $item->quantity; }), 2) }}</span>
                                        </p>
                                        @if($order->pickup_time)
                                            <p class="text-xs md:text-sm text-green-600 mt-0.5">
                                                <i class="fas fa-clock mr-1"></i>{{ $order->pickup_time }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col items-end space-y-1 md:space-y-2 flex-shrink-0">
                                <span class="inline-flex px-2 py-0.5 md:px-3 md:py-1 text-[10px] md:text-xs font-semibold rounded-full whitespace-nowrap
                                    @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status === 'ready_for_pickup') bg-green-100 text-green-800
                                    @elseif($order->status === 'completed') bg-green-100 text-green-800
                                    @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                                <p class="text-[10px] md:text-xs text-gray-500">
                                    {{ $order->created_at->format('M d, Y') }}
                                </p>
                                <a href="{{ route('messages.thread', $order->business->owner_id) }}" 
                                   class="inline-flex items-center text-xs md:text-sm text-green-600 hover:text-green-700 font-medium transition-colors">
                                    <i class="fas fa-comment-dots mr-1"></i><span class="hidden md:inline">Message</span>
                                </a>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @else
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-shopping-bag text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No orders yet</h3>
                <p class="text-gray-500 mb-4">Start exploring local products to place your first order!</p>
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