<?php $currentYear = date("Y"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pagsurong Lagonoy')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('pagsurongfaviconlogo.png') }}" type="image/png">
    
    <style>
        html {
            scroll-behavior: smooth;
        }
        .font-playfair {
            font-family: 'Playfair Display', serif;
        }
        .font-roboto {
            font-family: 'Roboto', sans-serif;
        }
    </style>
    
    @yield('styles')
</head>
<body class="font-roboto bg-gray-50">
    <!-- Header -->
    <header class="py-2 md:py-4 px-2 sm:px-3 md:px-10 flex flex-col md:flex-row justify-between items-center shadow-sm fixed top-0 left-0 right-0 z-50 text-white" style="background-color: #064e3b;">
        <!-- Left Side - Main Branding (Hidden on Mobile) -->
        <div class="hidden md:flex items-center">
            <img src="{{ asset('pagsurongfaviconlogo.png') }}" alt="Pagsurong Lagonoy Logo" class="w-12 h-auto mr-3">
            <div class="font-playfair text-2xl font-bold text-white">Pagsurong Lagonoy</div>
        </div>
        
        <!-- Center - Navigation (Customer Routes) -->
        <nav class="flex flex-wrap justify-center items-center mb-0 gap-1 sm:gap-2">
            <!-- Products with Logo (Mobile Only) -->
            <a href="{{ route('customer.products') }}" class="px-2 sm:px-3 md:px-3 py-1.5 md:py-2 text-white font-medium text-xs sm:text-sm md:text-base hover:text-green-200 transition-colors duration-200 flex items-center {{ request()->routeIs('customer.products') ? 'text-green-200 border-b-2 border-green-200' : '' }}">
                <img src="{{ asset('pagsurongfaviconlogo.png') }}" alt="Logo" class="w-5 h-5 sm:w-6 sm:h-6 mr-1 sm:mr-1.5 md:hidden">
                <span>Products</span>
            </a>
            <a href="{{ route('customer.shops') }}" class="px-2 sm:px-3 md:px-3 py-1.5 md:py-2 text-white font-medium text-xs sm:text-sm md:text-base hover:text-green-200 transition-colors duration-200 {{ request()->routeIs('customer.shops*') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Shops</a>
            <a href="{{ route('customer.hotels') }}" class="px-2 sm:px-3 md:px-3 py-1.5 md:py-2 text-white font-medium text-xs sm:text-sm md:text-base hover:text-green-200 transition-colors duration-200 {{ request()->routeIs('customer.hotels*') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Hotels</a>
            <a href="{{ route('customer.resorts') }}" class="px-2 sm:px-3 md:px-3 py-1.5 md:py-2 text-white font-medium text-xs sm:text-sm md:text-base hover:text-green-200 transition-colors duration-200 {{ request()->routeIs('customer.resorts*') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Resorts</a>
            <a href="{{ route('customer.attractions') }}" class="px-2 sm:px-3 md:px-3 py-1.5 md:py-2 text-white font-medium text-xs sm:text-sm md:text-base hover:text-green-200 transition-colors duration-200 {{ request()->routeIs('customer.attractions*') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Attractions</a>
            
            <!-- User Profile Dropdown (Desktop Only) -->
            <div class="hidden md:block relative mx-2 md:mx-3 my-1 md:my-0">
                <button onclick="toggleProfileDropdown()" class="flex items-center text-white hover:text-green-200 transition-colors duration-200">
                    @php
                        $user = auth()->user();
                        $profile = $user->profile ?? null;
                        $profilePicture = $profile ? $profile->profile_picture : null;
                    @endphp
                    
                    @if($profilePicture)
                        <img src="{{ Storage::url($profilePicture) }}" alt="Profile" class="w-10 h-10 rounded-full border-2 border-white">
                    @else
                        <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center border-2 border-white">
                            <span class="text-white text-base font-medium">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                    @endif
                    <i class="fas fa-chevron-down ml-2 text-xs"></i>
                </button>
                
                <!-- Dropdown Menu -->
                <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-user mr-2"></i>My Profile
                    </a>
                    <div class="border-t border-gray-100"></div>
                    <a href="#" onclick="logoutUser(event)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </a>
                </div>
            </div>
            
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </nav>
    </header>

    <!-- Main content wrapper with fixed navigation and three-column layout -->
    <div class="pt-20 md:pt-24 pb-20 md:pb-0 min-h-screen">
        <div class="flex min-h-[calc(100vh-5rem)] max-h-[calc(100vh-5rem)]">
            <!-- Left Sidebar - Switchable Panel (Desktop Only) -->
            @auth
                @if(auth()->user()->role === 'customer' && auth()->user()->hasCompletedProfile())
                    <div id="sidebarPanel" class="hidden lg:block w-16 bg-white border-r border-gray-200 overflow-y-auto flex-shrink-0 transition-all duration-300">
                        <!-- Minimized Icons View -->
                        <div id="minimizedIcons" class="p-4 space-y-4">
                            <button onclick="showOrdersPanel()" class="w-full flex flex-col items-center justify-center p-3 hover:bg-gray-50 rounded-lg transition-colors relative group">
                                <i class="fas fa-shopping-bag text-green-600 text-2xl"></i>
                                <span class="text-xs text-gray-600 mt-1">Orders</span>
                            </button>
                            <button onclick="showMessagesPanel()" class="w-full flex flex-col items-center justify-center p-3 hover:bg-gray-50 rounded-lg transition-colors relative group">
                                <i class="fas fa-envelope text-green-600 text-2xl"></i>
                                <span class="text-xs text-gray-600 mt-1">Messages</span>
                                @php
                                    $unreadCount = auth()->user()->unreadMessages()->count();
                                @endphp
                                @if($unreadCount > 0)
                                    <span class="absolute top-2 right-2 bg-red-500 text-white text-xs rounded-full px-2 py-1">{{ $unreadCount }}</span>
                                @endif
                            </button>
                            <button onclick="showCartPanel()" class="w-full flex flex-col items-center justify-center p-3 hover:bg-gray-50 rounded-lg transition-colors relative group">
                                <i class="fas fa-shopping-cart text-green-600 text-2xl"></i>
                                <span class="text-xs text-gray-600 mt-1 whitespace-nowrap">My Cart</span>
                                @php
                                    $cartCount = auth()->user()->cart ? auth()->user()->cart->sum('quantity') : 0;
                                @endphp
                                @if($cartCount > 0)
                                    <span class="absolute top-2 right-2 bg-orange-500 text-white text-xs rounded-full px-2 py-1">{{ $cartCount }}</span>
                                @endif
                            </button>
                        </div>

                        <!-- Orders Panel Content -->
                        <div id="ordersPanel" class="hidden">
                            <div class="p-4 border-b border-gray-200 sticky top-0 bg-white z-10">
                                <div class="flex items-center justify-between">
                                    <button onclick="minimizePanel()" class="font-semibold text-gray-900 flex items-center hover:text-green-700 transition-colors cursor-pointer">
                                        <i class="fas fa-shopping-bag text-green-600"></i>
                                        <span class="ml-2">My Orders</span>
                                    </button>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('customer.orders') }}" class="text-xs text-green-600 hover:underline">
                                            View All
                                        </a>
                                        <button onclick="minimizePanel()" class="text-green-600 hover:text-green-700 p-1">
                                            <i class="fas fa-chevron-left text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4">
                            @php
                                // Only show non-completed orders in the sidebar
                                $orders = auth()->user()->orders()
                                    ->where('status', '!=', 'completed')
                                    ->latest()
                                    ->take(5)
                                    ->get();
                            @endphp
                            
                            @if($orders->count() > 0)
                                <div class="space-y-3">
                                    @foreach($orders as $order)
                                        <div class="border rounded-lg p-3 hover:bg-gray-50 transition-colors cursor-pointer" onclick="window.location='{{ route('customer.orders.show', $order) }}'">
                                            <div class="flex justify-between items-start mb-2">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">Order #{{ $order->id }}</p>
                                                    <p class="text-xs text-gray-500">{{ $order->created_at->format('M d, Y') }}</p>
                                                </div>
                                                <span class="px-2 py-1 text-xs rounded-full {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($order->status === 'processing' ? 'bg-green-100 text-green-800' : 'bg-green-100 text-green-800') }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </div>
                                            <div class="text-xs text-gray-600">
                                                Total: ₱{{ number_format($order->total_amount ?? $order->total ?? $order->orderItems->sum(function($item) { return $item->quantity * $item->price; }), 2) }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-shopping-bag text-gray-400 text-xl"></i>
                                    </div>
                                    <p class="text-sm text-gray-500 mb-3">No orders yet</p>
                                    <a href="{{ route('customer.products') }}" class="inline-flex items-center px-3 py-2 border border-green-300 rounded-md text-sm font-medium text-green-700 bg-green-50 hover:bg-green-100 transition-colors">
                                        <i class="fas fa-shopping-basket mr-2"></i>
                                        Start Shopping
                                    </a>
                                </div>
                            @endif
                            </div>
                        </div>

                        <!-- Messages Panel Content -->
                        <div id="messagesPanel" class="hidden">
                            <div class="p-4 border-b border-gray-200 sticky top-0 bg-white z-10">
                                <div class="flex items-center justify-between">
                                    <button onclick="minimizePanel()" class="font-semibold text-gray-900 flex items-center hover:text-green-700 transition-colors cursor-pointer">
                                        <i class="fas fa-envelope text-green-600"></i>
                                        <span class="ml-2">Messages</span>
                                        @php
                                            $unreadCount = auth()->user()->unreadMessages()->count();
                                        @endphp
                                        @if($unreadCount > 0)
                                            <span class="ml-2 bg-red-500 text-white text-xs rounded-full px-2 py-1">{{ $unreadCount }}</span>
                                        @endif
                                    </button>
                                    <button onclick="minimizePanel()" class="text-green-600 hover:text-green-700 p-1">
                                        <i class="fas fa-chevron-left text-sm"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="p-0">
                            @php
                                $user = auth()->user();
                                $threads = $user->threads()->take(10);
                            @endphp
                            
                            @if($threads->count() > 0)
                                <div class="divide-y divide-gray-200">
                                    @foreach($threads as $otherUser)
                                        @php
                                            $lastMessage = $otherUser->last_message ?? null;
                                            $isUnread = $lastMessage && $lastMessage->receiver_id == $user->id && !$lastMessage->read_at;
                                        @endphp
                                        
                                        <a href="{{ route('messages.thread', $otherUser) }}" class="block hover:bg-gray-50 transition-colors">
                                            <div class="px-4 py-3">
                                                <div class="flex items-center space-x-3">
                                                    <!-- Profile Picture -->
                                                    <div class="flex-shrink-0 h-10 w-10 rounded-full overflow-hidden">
                                                        @if($otherUser->profile && $otherUser->profile->profile_picture)
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
                                                    </div>

                                                    <!-- Message Preview -->
                                                    <div class="flex-1 min-w-0 {{ $isUnread ? 'font-medium' : '' }}">
                                                        <div class="flex items-center justify-between">
                                                            <p class="text-sm text-gray-900 truncate">
                                                                {{ $otherUser->name }}
                                                            </p>
                                                            <p class="text-xs text-gray-500">
                                                                {{ $lastMessage ? $lastMessage->created_at->diffForHumans() : '' }}
                                                            </p>
                                                        </div>
                                                        <p class="text-xs text-gray-500 truncate">
                                                            @if($lastMessage)
                                                                {{ $lastMessage->sender_id == $user->id ? 'You: ' : '' }}
                                                                {{ \Illuminate\Support\Str::limit(strip_tags($lastMessage->content), 30) }}
                                                            @else
                                                                No messages yet
                                                            @endif
                                                        </p>
                                                        
                                                        @if($otherUser->businessProfile)
                                                            <p class="text-xs text-green-600 font-medium mt-1">
                                                                {{ $otherUser->businessProfile->business_name }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                    
                                                    @if($isUnread)
                                                        <span class="flex-shrink-0 w-2 h-2 bg-red-500 rounded-full"></span>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="p-4 text-center">
                                    <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-envelope text-gray-400 text-xl"></i>
                                    </div>
                                    <p class="text-sm text-gray-500 mb-3">No messages yet</p>
                                    <a href="{{ route('customer.products') }}" class="text-xs text-green-600 hover:underline">
                                        Browse products to get started
                                    </a>
                                </div>
                            @endif
                            </div>
                        </div>

                        <!-- Cart Panel Content -->
                        <div id="cartPanel" class="hidden">
                            <div class="p-4 border-b border-gray-200 sticky top-0 bg-white z-10">
                                <div class="flex items-center justify-between">
                                    <button onclick="minimizePanel()" class="font-semibold text-gray-900 flex items-center hover:text-green-700 transition-colors cursor-pointer">
                                        <i class="fas fa-shopping-cart text-green-600"></i>
                                        <span class="ml-2">My Cart</span>
                                        @php
                                            $cartCount = auth()->user()->cart ? auth()->user()->cart->sum('quantity') : 0;
                                        @endphp
                                        @if($cartCount > 0)
                                            <span class="ml-2 bg-orange-500 text-white text-xs rounded-full px-2 py-1">{{ $cartCount }}</span>
                                        @endif
                                    </button>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('customer.cart') }}" class="text-xs text-green-600 hover:underline">
                                            View All
                                        </a>
                                        <button onclick="minimizePanel()" class="text-green-600 hover:text-green-700 p-1">
                                            <i class="fas fa-chevron-left text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4">
                            @php
                                $cartItems = auth()->user()->cart()->with('product')->take(5)->get();
                            @endphp
                            
                            @if($cartItems->count() > 0)
                                <div class="space-y-3">
                                    @foreach($cartItems as $item)
                                        <div class="border rounded-lg p-3 hover:bg-gray-50 transition-colors">
                                            <div class="flex items-start space-x-3">
                                                @if($item->product && $item->product->image)
                                                    <img src="{{ Storage::url($item->product->image) }}" 
                                                         alt="{{ $item->product->name }}" 
                                                         class="w-16 h-16 object-cover rounded">
                                                @else
                                                    <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                        <i class="fas fa-image text-gray-400"></i>
                                                    </div>
                                                @endif
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $item->product->name ?? 'Product' }}</p>
                                                    <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                                                    <p class="text-sm font-semibold text-green-600">₱{{ number_format(($item->product->price ?? 0) * $item->quantity, 2) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-4 pt-4 border-t">
                                    <div class="flex justify-between items-center mb-3">
                                        <span class="text-sm font-medium text-gray-700">Total Items:</span>
                                        <span class="text-sm font-bold text-gray-900">{{ $cartCount }}</span>
                                    </div>
                                    <a href="{{ route('customer.cart') }}" class="block w-full text-center bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg transition-colors">
                                        View Full Cart
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-shopping-cart text-gray-400 text-xl"></i>
                                    </div>
                                    <p class="text-sm text-gray-500 mb-3">Your cart is empty</p>
                                    <a href="{{ route('customer.products') }}" class="inline-flex items-center px-3 py-2 border border-green-300 rounded-md text-sm font-medium text-green-700 bg-green-50 hover:bg-green-100 transition-colors">
                                        <i class="fas fa-shopping-basket mr-2"></i>
                                        Start Shopping
                                    </a>
                                </div>
                            @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endauth
            
            <!-- Main Content - Feed -->
            <main id="main-content" class="flex-1 overflow-y-auto bg-gray-50 pb-16 md:pb-0 min-w-0">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile Bottom Navigation -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50">
        <div class="flex justify-around items-center py-3">
            @auth
                @php
                    $user = auth()->user();
                    $unreadMessages = $user->unreadMessages()->count() ?? 0;
                    $cartCount = $user->cart ? $user->cart->count() : 0;
                @endphp
                
                @if($user->role === 'customer' && $user->hasCompletedProfile())
                    <!-- Mobile Bottom Navigation - Full customer features -->
                    <a href="{{ route('customer.orders') }}" class="flex flex-col items-center px-2 py-3 text-xs text-gray-600 hover:text-green-500 transition-colors relative {{ request()->routeIs('customer.orders') ? 'text-green-500' : '' }}">
                        <i class="fas fa-shopping-bag text-xl mb-1"></i>
                        <span class="text-[10px] leading-tight">Orders</span>
                    </a>

                    <a href="{{ route('customer.messages') }}" class="flex flex-col items-center px-2 py-3 text-xs text-gray-600 hover:text-green-500 transition-colors relative {{ request()->routeIs('customer.messages') ? 'text-green-500' : '' }}">
                        <div class="relative">
                            <i class="fas fa-envelope text-xl mb-1"></i>
                            @if($unreadMessages)
                                <span class="absolute -top-1 -right-2 bg-red-500 text-white text-[10px] rounded-full w-5 h-5 flex items-center justify-center font-bold">
                                    {{ $unreadMessages }}
                                </span>
                            @endif
                        </div>
                        <span class="text-[10px] leading-tight">Messages</span>
                    </a>

                    <a href="{{ route('customer.cart') }}" class="flex flex-col items-center px-2 py-3 text-xs text-gray-600 hover:text-green-500 transition-colors relative {{ request()->routeIs('customer.cart') ? 'text-green-500' : '' }}">
                        <div class="relative">
                            <i class="fas fa-shopping-cart text-xl mb-1"></i>
                            @if($cartCount)
                                <span class="absolute -top-1 -right-2 bg-orange-500 text-white text-[10px] rounded-full w-5 h-5 flex items-center justify-center font-bold">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </div>
                        <span class="text-[10px] leading-tight">Cart</span>
                    </a>

                    <button onclick="toggleMobileProfileSidebar()" class="flex flex-col items-center px-2 py-3 text-xs text-gray-600 hover:text-green-500 focus:outline-none">
                        @if($user->profile && $user->profile->profile_picture)
                            <img src="{{ Storage::url($user->profile->profile_picture) }}"
                                 alt="Profile"
                                 class="w-8 h-8 rounded-full object-cover border border-green-400 mb-1">
                        @else
                            <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white text-sm mb-1">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <span class="text-[10px] leading-tight">Profile</span>
                    </button>
                @else
                    <!-- Mobile Bottom Navigation - Simple during profile setup -->
                    <a href="{{ route('profile.setup') }}" class="flex flex-col items-center px-2 py-3 text-xs text-gray-600 hover:text-green-500 transition-colors {{ request()->routeIs('profile.setup') ? 'text-green-500' : '' }}">
                        <i class="fas fa-user-edit text-xl mb-1"></i>
                        <span class="text-[10px] leading-tight">Setup</span>
                    </a>

                    <button onclick="toggleMobileProfileSidebar()" class="flex flex-col items-center px-2 py-3 text-xs text-gray-600 hover:text-green-500 focus:outline-none">
                        @if($user->profile && $user->profile->profile_picture)
                            <img src="{{ Storage::url($user->profile->profile_picture) }}"
                                 alt="Profile"
                                 class="w-8 h-8 rounded-full object-cover border border-green-400 mb-1">
                        @else
                            <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white text-sm mb-1">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <span class="text-[10px] leading-tight">Profile</span>
                    </button>
                @endif
            @endauth
        </div>
    </div>

    <!-- Mobile Profile Sidebar Overlay -->
    <div id="mobileProfileOverlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 md:hidden" onclick="closeMobileProfileSidebar()"></div>

    <!-- Mobile Profile Sidebar -->
    <div id="mobileProfileSidebar" class="fixed top-0 right-0 h-full w-80 bg-white shadow-2xl transform translate-x-full transition-transform duration-300 z-50 md:hidden">
        <div class="flex flex-col h-full">
            <!-- Sidebar Header -->
            <div class="p-6 border-b border-gray-200" style="background-color: #064e3b;">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-white">Profile</h3>
                    <button onclick="closeMobileProfileSidebar()" class="text-white hover:text-gray-200">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
                
                @auth
                    @php
                        $user = auth()->user();
                        $profile = $user->profile ?? null;
                        $profilePicture = $profile ? $profile->profile_picture : null;
                    @endphp
                    
                    <div class="flex items-center space-x-3">
                        @if($profilePicture)
                            <img src="{{ Storage::url($profilePicture) }}" alt="Profile" class="w-16 h-16 rounded-full border-2 border-white">
                        @else
                            <div class="w-16 h-16 rounded-full bg-green-500 flex items-center justify-center border-2 border-white">
                                <span class="text-white text-2xl font-medium">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-white font-semibold text-lg truncate">{{ $user->name }}</p>
                            <p class="text-green-100 text-sm truncate">{{ $user->email }}</p>
                        </div>
                    </div>
                @endauth
            </div>
            
            <!-- Sidebar Menu -->
            <div class="flex-1 overflow-y-auto py-4">
                <nav class="space-y-1 px-3">
                    <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors" onclick="closeMobileProfileSidebar()">
                        <i class="fas fa-user w-6 text-green-600"></i>
                        <span class="ml-3 font-medium">My Profile</span>
                    </a>
                    
                    <a href="#" onclick="logoutUser(event)" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <i class="fas fa-sign-out-alt w-6 text-green-600"></i>
                        <span class="ml-3 font-medium">Logout</span>
                    </a>
                </nav>
            </div>
        </div>
    </div>


    <!-- Scripts -->
    <script>
        function logoutUser(event) {
            event.preventDefault();
            document.getElementById('logoutModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function confirmLogout() {
            document.getElementById('logout-form').submit();
        }

        function closeLogoutModal() {
            document.getElementById('logoutModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Switchable panel functions
        function showOrdersPanel() {
            const sidebarPanel = document.getElementById('sidebarPanel');
            const minimizedIcons = document.getElementById('minimizedIcons');
            const ordersPanel = document.getElementById('ordersPanel');
            const messagesPanel = document.getElementById('messagesPanel');
            const cartPanel = document.getElementById('cartPanel');
            
            if (sidebarPanel && minimizedIcons && ordersPanel && messagesPanel) {
                // Expand panel
                sidebarPanel.classList.remove('w-16');
                sidebarPanel.classList.add('w-80');
                
                // Show orders, hide messages, cart and icons
                minimizedIcons.classList.add('hidden');
                ordersPanel.classList.remove('hidden');
                messagesPanel.classList.add('hidden');
                if (cartPanel) cartPanel.classList.add('hidden');
                
                // Adjust product grid to 3 columns
                adjustProductGrid(true);
            }
        }

        function showMessagesPanel() {
            const sidebarPanel = document.getElementById('sidebarPanel');
            const minimizedIcons = document.getElementById('minimizedIcons');
            const ordersPanel = document.getElementById('ordersPanel');
            const messagesPanel = document.getElementById('messagesPanel');
            const cartPanel = document.getElementById('cartPanel');
            
            if (sidebarPanel && minimizedIcons && ordersPanel && messagesPanel) {
                // Expand panel
                sidebarPanel.classList.remove('w-16');
                sidebarPanel.classList.add('w-80');
                
                // Show messages, hide orders, cart and icons
                minimizedIcons.classList.add('hidden');
                ordersPanel.classList.add('hidden');
                messagesPanel.classList.remove('hidden');
                if (cartPanel) cartPanel.classList.add('hidden');
                
                // Adjust product grid to 3 columns
                adjustProductGrid(true);
            }
        }

        function showCartPanel() {
            const sidebarPanel = document.getElementById('sidebarPanel');
            const minimizedIcons = document.getElementById('minimizedIcons');
            const ordersPanel = document.getElementById('ordersPanel');
            const messagesPanel = document.getElementById('messagesPanel');
            const cartPanel = document.getElementById('cartPanel');
            
            if (sidebarPanel && minimizedIcons && ordersPanel && messagesPanel && cartPanel) {
                // Expand panel
                sidebarPanel.classList.remove('w-16');
                sidebarPanel.classList.add('w-80');
                
                // Show cart, hide orders, messages and icons
                minimizedIcons.classList.add('hidden');
                ordersPanel.classList.add('hidden');
                messagesPanel.classList.add('hidden');
                cartPanel.classList.remove('hidden');
                
                // Adjust product grid to 3 columns
                adjustProductGrid(true);
            }
        }

        function minimizePanel() {
            const sidebarPanel = document.getElementById('sidebarPanel');
            const minimizedIcons = document.getElementById('minimizedIcons');
            const ordersPanel = document.getElementById('ordersPanel');
            const messagesPanel = document.getElementById('messagesPanel');
            const cartPanel = document.getElementById('cartPanel');
            
            if (sidebarPanel && minimizedIcons && ordersPanel && messagesPanel) {
                // Collapse panel
                sidebarPanel.classList.remove('w-80');
                sidebarPanel.classList.add('w-16');
                
                // Show icons, hide all panels
                minimizedIcons.classList.remove('hidden');
                ordersPanel.classList.add('hidden');
                messagesPanel.classList.add('hidden');
                if (cartPanel) cartPanel.classList.add('hidden');
                
                // Adjust product grid to 4 columns
                adjustProductGrid(false);
            }
        }

        // Function to adjust product grid columns based on panel state
        function adjustProductGrid(isPanelExpanded) {
            const productsGrid = document.getElementById('productsGrid');
            if (productsGrid) {
                if (isPanelExpanded) {
                    // Panel expanded: show 3 columns on large screens
                    productsGrid.classList.remove('lg:grid-cols-4');
                    productsGrid.classList.add('lg:grid-cols-3');
                } else {
                    // Panel minimized: show 4 columns on large screens
                    productsGrid.classList.remove('lg:grid-cols-3');
                    productsGrid.classList.add('lg:grid-cols-4');
                }
            }
        }

        // Auto-minimize panels on page load (when switching pages)
        document.addEventListener('DOMContentLoaded', function() {
            // Always start minimized when page loads
            minimizePanel();
            // Clear any saved panel state
            localStorage.removeItem('sidebarPanel');
        });

        function toggleMobileProfileSidebar() {
            const sidebar = document.getElementById('mobileProfileSidebar');
            const overlay = document.getElementById('mobileProfileOverlay');
            
            if (sidebar && overlay) {
                sidebar.classList.toggle('translate-x-full');
                overlay.classList.toggle('hidden');
                document.body.style.overflow = sidebar.classList.contains('translate-x-full') ? 'auto' : 'hidden';
            }
        }

        function closeMobileProfileSidebar() {
            const sidebar = document.getElementById('mobileProfileSidebar');
            const overlay = document.getElementById('mobileProfileOverlay');
            
            if (sidebar && overlay) {
                sidebar.classList.add('translate-x-full');
                overlay.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('profileDropdown');
            const button = event.target.closest('button[onclick="toggleProfileDropdown()"]');
            
            if (!button && dropdown && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>

    <!-- Logout Confirmation Modal -->
    <div id="logoutModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-md w-full p-6 relative my-8">
                <div class="text-center mb-6">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                        <i class="fas fa-sign-out-alt text-red-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Confirm Logout</h3>
                    <p class="text-sm text-gray-600">Are you sure you want to logout?</p>
                </div>

                <div class="flex space-x-3">
                    <button onclick="closeLogoutModal()" 
                            class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                        Cancel
                    </button>
                    <button onclick="confirmLogout()" 
                            class="flex-1 bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    @yield('scripts')
</body>
</html>
