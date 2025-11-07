@extends('layouts.customer')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                <i class="fas fa-shopping-bag mr-2 text-green-600"></i>
                My Orders
            </h1>
            <p class="text-sm text-gray-600 mt-1">Track your product reservations and pickup status</p>
        </div>
    </div>

    <!-- Orders List -->
    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8 py-4 sm:py-6">
        @if($orders->count() > 0)
            <div class="space-y-3 sm:space-y-4">
                @foreach($orders as $order)
                    <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="p-4">
                            <!-- Order Header with Status -->
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-base font-bold text-gray-900">
                                    Order #{{ $order->id }}
                                </h3>
                                <span class="inline-flex px-2.5 py-1 text-xs font-semibold rounded-full whitespace-nowrap
                                    @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status === 'ready_for_pickup') bg-blue-100 text-blue-800
                                    @elseif($order->status === 'completed') bg-green-100 text-green-800
                                    @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </div>
                            
                            <!-- Product Info -->
                            <div class="flex items-start gap-3 mb-3">
                                <!-- Product Image -->
                                <div class="flex-shrink-0">
                                    @if($order->items->first() && $order->items->first()->product->image)
                                        <img class="h-16 w-16 rounded-lg object-cover" 
                                             src="{{ asset('storage/' . $order->items->first()->product->image) }}" 
                                             alt="{{ $order->items->first()->product->name }}">
                                    @else
                                        <div class="h-16 w-16 rounded-lg bg-gray-100 flex items-center justify-center">
                                            <i class="fas fa-shopping-bag text-gray-400 text-xl"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Product Details -->
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 mb-1">
                                        {{ $order->items->first() ? $order->items->first()->product->name : 'Product' }}
                                        @if($order->items->count() > 1)
                                            <span class="text-gray-500">×{{ $order->items->first()->quantity }}</span>
                                        @endif
                                    </p>
                                    <p class="text-xs text-gray-600 mb-2">
                                        <i class="fas fa-store mr-1"></i>{{ $order->business->name }}
                                    </p>
                                    <div class="flex items-center gap-3 text-xs">
                                        <span class="text-gray-700">
                                            Quantity: <span class="font-semibold text-gray-900">{{ $order->items->sum('quantity') }}</span>
                                        </span>
                                        <span class="text-gray-700">
                                            <span class="font-semibold text-green-600">₱{{ number_format($order->items->sum(function($item) { return $item->price * $item->quantity; }), 2) }}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Pickup Time -->
                            @if($order->pickup_time)
                                <div class="mb-3 py-2 px-3 bg-green-50 rounded-lg">
                                    <p class="text-xs text-green-700 font-medium flex items-center">
                                        <i class="fas fa-clock mr-1.5"></i>Pickup: {{ $order->pickup_time }}
                                    </p>
                                </div>
                            @endif
                            
                            <!-- Footer -->
                            <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                <p class="text-xs text-gray-500">
                                    {{ $order->created_at->format('M d, Y h:i A') }}
                                </p>
                                
                                <a href="{{ route('messages.thread', $order->business->owner_id) }}" 
                                   class="inline-flex items-center text-xs font-medium text-green-600 hover:text-green-700 transition-colors">
                                    <i class="fas fa-comment-dots mr-1"></i>Message Business
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @else
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-shopping-bag text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">No orders yet</h3>
                <p class="text-gray-500 mb-6">Start exploring local products to place your first order!</p>
                <a href="{{ route('customer.products') }}" 
                   class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 transition-colors shadow-sm">
                    <i class="fas fa-shopping-basket mr-2"></i>
                    Browse Products
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
