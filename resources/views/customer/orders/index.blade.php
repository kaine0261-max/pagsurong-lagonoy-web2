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
                    <li class="px-6 py-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        @if($order->orderItems->first() && $order->orderItems->first()->product->image)
                                            <img class="h-16 w-16 rounded-lg object-cover" 
                                                 src="{{ asset('storage/' . $order->orderItems->first()->product->image) }}" 
                                                 alt="{{ $order->orderItems->first()->product->name }}">
                                        @else
                                            <div class="h-16 w-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-shopping-bag text-gray-400 text-xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-base font-semibold text-gray-900 truncate">
                                            Order #{{ $order->id }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            {{ $order->orderItems->first() ? $order->orderItems->first()->product->name : 'Product' }}
                                            @if($order->orderItems->count() > 1)
                                                <span class="text-gray-500">+{{ $order->orderItems->count() - 1 }} more</span>
                                            @endif
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            <i class="fas fa-store mr-1"></i>{{ $order->business->name }}
                                        </p>
                                        <p class="text-sm font-medium text-gray-900 mt-1">
                                            <i class="fas fa-box mr-1"></i>Quantity: {{ $order->orderItems->sum('quantity') }} | 
                                            <span class="text-green-600">₱{{ number_format($order->orderItems->sum(function($item) { return $item->price * $item->quantity; }), 2) }}</span>
                                        </p>
                                        @if($order->pickup_time)
                                            <p class="text-sm text-green-600 mt-1">
                                                <i class="fas fa-clock mr-1"></i>Pickup: {{ $order->pickup_time }}
                                            </p>
                                        @endif
                                        @if($order->notes)
                                            <p class="text-sm text-gray-500 mt-1">
                                                <i class="fas fa-sticky-note mr-1"></i>{{ $order->notes }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col items-end space-y-2">
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full
                                    @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status === 'ready_for_pickup') bg-green-100 text-green-800
                                    @elseif($order->status === 'completed') bg-green-100 text-green-800
                                    @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                                <p class="text-xs text-gray-500">
                                    {{ $order->created_at->format('M d, Y g:i A') }}
                                </p>
                                <a href="{{ route('messages.thread', $order->business->owner_id) }}" 
                                   class="inline-flex items-center text-sm text-green-600 hover:text-green-700 font-medium transition-colors">
                                    <i class="fas fa-comment-dots mr-1"></i>Message Business
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
