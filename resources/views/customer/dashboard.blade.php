@extends('layouts.customer')


@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Welcome Section -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    Welcome to Pagsurong Lagonoy
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-8">
                    Discover the best of Lagonoy's local businesses, accommodations, and attractions
                </p>
                
                <!-- Search Bar -->
                <div class="max-w-2xl mx-auto">
                    <form action="{{ route('customer.search') }}" method="GET" class="flex gap-3">
                        <input type="text"
                               name="q"
                               value="{{ request('q') }}"
                               placeholder="Search for products, businesses, or tourist spots..."
                               class="flex-1 px-6 py-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-gray-800 text-lg">
                        <button type="submit" class="px-8 py-4 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors text-lg font-medium">
                            <i class="fas fa-search mr-2"></i>Search
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Access Categories -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-2xl font-bold text-gray-900 text-center mb-8">Explore Lagonoy</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Products & Shops -->
            <a href="{{ route('customer.products') }}" class="group bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden">
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-200 transition-colors">
                        <i class="fas fa-shopping-bag text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Products</h3>
                    <p class="text-gray-600 text-sm">Browse local products from Lagonoy's finest businesses</p>
                </div>
            </a>
            
            <!-- Shops -->
            <a href="{{ route('customer.shops') }}" class="group bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden">
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-200 transition-colors">
                        <i class="fas fa-store text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Shops</h3>
                    <p class="text-gray-600 text-sm">Discover local shops and businesses in Lagonoy</p>
                </div>
            </a>
            
            <!-- Hotels -->
            <a href="{{ route('customer.hotels') }}" class="group bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden">
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-200 transition-colors">
                        <i class="fas fa-hotel text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Hotels</h3>
                    <p class="text-gray-600 text-sm">Find comfortable accommodations for your stay</p>
                </div>
            </a>
            
            <!-- Resorts -->
            <a href="{{ route('customer.resorts') }}" class="group bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden">
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-cyan-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-cyan-200 transition-colors">
                        <i class="fas fa-umbrella-beach text-cyan-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Resorts</h3>
                    <p class="text-gray-600 text-sm">Explore beautiful beachfront properties and vacation destinations</p>
                </div>
            </a>
        </div>
        
        <!-- Second Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            <!-- Attractions -->
            <a href="{{ route('customer.attractions') }}" class="group bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden">
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-emerald-200 transition-colors">
                        <i class="fas fa-map-marked-alt text-emerald-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Tourist Attractions</h3>
                    <p class="text-gray-600 text-sm">Discover must-visit places and hidden gems in Lagonoy</p>
                </div>
            </a>
            
            <!-- My Orders -->
            <a href="{{ route('customer.orders') }}" class="group bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden">
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-orange-200 transition-colors">
                        <i class="fas fa-shopping-cart text-orange-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">My Orders</h3>
                    <p class="text-gray-600 text-sm">Track your purchases and order history</p>
                </div>
            </a>
            
            <!-- Messages -->
            <a href="{{ route('customer.messages') }}" class="group bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden">
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-indigo-200 transition-colors">
                        <i class="fas fa-envelope text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Messages</h3>
                    <p class="text-gray-600 text-sm">Communicate with business owners</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

