@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                <i class="fas fa-clipboard-list mr-2 text-green-600"></i>
                Orders
            </h1>
            <p class="text-sm text-gray-600 mt-1">Manage customer orders and update their status</p>
        </div>
    </div>

    <!-- Orders List -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if($orders->isEmpty())
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-clipboard-list text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">No orders yet</h3>
                <p class="text-gray-500">Orders from customers will appear here.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($orders as $order)
                    @php
                        $total = $order->orderItems->sum(fn($item) => $item->price * $item->quantity);
                        $totalItems = $order->orderItems->sum('quantity');
                    @endphp
                    
                    <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="p-4 sm:p-6">
                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                                <!-- Left Section -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start gap-3">
                                        <!-- Product Image -->
                                        <div class="flex-shrink-0">
                                            @if($order->orderItems->first() && $order->orderItems->first()->product->image)
                                                <img class="h-16 w-16 rounded-lg object-cover" 
                                                     src="{{ Storage::url($order->orderItems->first()->product->image) }}" 
                                                     alt="Product">
                                            @else
                                                <div class="h-16 w-16 rounded-lg bg-gray-100 flex items-center justify-center">
                                                    <i class="fas fa-shopping-bag text-gray-400 text-xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Order Info -->
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-base font-semibold text-gray-900 mb-1">
                                                Order #{{ $order->id }}
                                            </h3>
                                            <p class="text-sm text-gray-600 mb-2">
                                                <i class="fas fa-user mr-1"></i>{{ $order->user->name }}
                                            </p>
                                            
                                            <!-- Items List -->
                                            <div class="space-y-1 mb-2">
                                                @foreach($order->orderItems as $item)
                                                    <p class="text-sm text-gray-700">
                                                        {{ $item->product->name }} 
                                                        <span class="text-gray-500">×{{ $item->quantity }}</span>
                                                    </p>
                                                @endforeach
                                            </div>
                                            
                                            <div class="flex items-center gap-4 text-sm">
                                                <span class="font-medium text-gray-900">
                                                    Quantity: <span class="text-green-600">{{ $totalItems }}</span>
                                                </span>
                                                <span class="font-medium text-gray-900">
                                                    Total: <span class="text-green-600">₱{{ number_format($total, 2) }}</span>
                                                </span>
                                            </div>
                                            
                                            @if($order->pickup_time)
                                                <p class="text-sm text-green-600 mt-2">
                                                    <i class="fas fa-clock mr-1"></i>Pickup: {{ $order->pickup_time }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Right Section -->
                                <div class="flex flex-col items-start sm:items-end gap-3 flex-shrink-0">
                                    <p class="text-xs text-gray-500">
                                        {{ $order->created_at->format('M d, Y h:i A') }}
                                    </p>
                                    
                                    <!-- Status Dropdown -->
                                    <form method="POST" action="{{ route('business.orders.update.status', $order) }}" class="w-full sm:w-auto">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" 
                                                onchange="this.form.submit()" 
                                                class="w-full sm:w-auto px-3 py-2 text-sm font-medium rounded-lg border-2 focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors
                                                    @if($order->status === 'pending') border-yellow-300 bg-yellow-50 text-yellow-800
                                                    @elseif($order->status === 'ready_for_pickup') border-blue-300 bg-blue-50 text-blue-800
                                                    @elseif($order->status === 'completed') border-green-300 bg-green-50 text-green-800
                                                    @elseif($order->status === 'cancelled') border-red-300 bg-red-50 text-red-800
                                                    @endif">
                                            <option {{ $order->status === 'pending' ? 'selected' : '' }} value="pending">Pending</option>
                                            <option {{ $order->status === 'ready_for_pickup' ? 'selected' : '' }} value="ready_for_pickup">Ready for Pickup</option>
                                            <option {{ $order->status === 'completed' ? 'selected' : '' }} value="completed">Completed</option>
                                            <option {{ $order->status === 'cancelled' ? 'selected' : '' }} value="cancelled">Cancelled</option>
                                        </select>
                                    </form>
                                    
                                    <a href="{{ route('messages.thread', $order->user->id) }}" 
                                       class="inline-flex items-center text-sm text-green-600 hover:text-green-700 font-medium transition-colors">
                                        <i class="fas fa-comment-dots mr-1"></i>Message Customer
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
