@extends('layouts.app')


@section('content')
@if(auth()->user()->role === 'customer')
    <!-- Redirect customers to their dashboard -->
    <script>window.location.href = "{{ route('customer.dashboard') }}";</script>
@else
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(auth()->user()->role === 'business_owner')
            <!-- Business Owner Quick Actions -->
            <div class="mt-12">
                <h2 class="text-2xl font-serif font-bold text-gray-800 mb-6 text-center">Business Management</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <a href="{{ route('business.dashboard') }}" class="bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 p-6 text-center border border-gray-100">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-100 text-blue-600 mb-3">
                            <i class="fas fa-store text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">My Business</h3>
                        <p class="text-gray-600 text-sm">Manage your shop and products</p>
                    </a>
                    <a href="{{ route('orders.business') }}" class="bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 p-6 text-center border border-gray-100">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-green-100 text-green-600 mb-3">
                            <i class="fas fa-shopping-cart text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Orders</h3>
                        <p class="text-gray-600 text-sm">View and manage customer orders</p>
                    </a>
                    <a href="{{ route('messages.owner') }}" class="bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 p-6 text-center border border-gray-100">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-purple-100 text-purple-600 mb-3">
                            <i class="fas fa-comments text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Messages</h3>
                        <p class="text-gray-600 text-sm">Chat with customers</p>
                    </a>
                </div>
            </div>
        @endif
    </div>
@endif
@endsection

@section('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400;500&display=swap');
    
    .font-serif {
        font-family: 'Playfair Display', serif;
    }
</style>
@endsection
