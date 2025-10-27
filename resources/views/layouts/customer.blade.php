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
            <img src="{{ asset('logo.png') }}" alt="Pagsurong Lagonoy Logo" class="w-12 h-auto mr-3">
            <div class="font-playfair text-2xl font-bold text-white">Pagsurong Lagonoy</div>
        </div>
        
        <!-- Center - Navigation (Customer Routes) -->
        <nav class="flex flex-wrap justify-center items-center mb-0 gap-1 sm:gap-2">
            <!-- Products with Logo (Mobile Only) -->
            <a href="{{ route('customer.products') }}" class="px-2 sm:px-3 md:px-3 py-1.5 md:py-2 text-white font-medium text-xs sm:text-sm md:text-base hover:text-green-200 transition-colors duration-200 flex items-center {{ request()->routeIs('customer.products') ? 'text-green-200 border-b-2 border-green-200' : '' }}">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="w-5 h-5 sm:w-6 sm:h-6 mr-1 sm:mr-1.5 md:hidden">
                <span>Products</span>
            </a>
            <a href="{{ route('customer.shops') }}" class="px-2 sm:px-3 md:px-3 py-1.5 md:py-2 text-white font-medium text-xs sm:text-sm md:text-base hover:text-green-200 transition-colors duration-200 {{ request()->routeIs('customer.shops') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Shops</a>
            <a href="{{ route('customer.hotels') }}" class="px-2 sm:px-3 md:px-3 py-1.5 md:py-2 text-white font-medium text-xs sm:text-sm md:text-base hover:text-green-200 transition-colors duration-200 {{ request()->routeIs('customer.hotels') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Hotels</a>
            <a href="{{ route('customer.resorts') }}" class="px-2 sm:px-3 md:px-3 py-1.5 md:py-2 text-white font-medium text-xs sm:text-sm md:text-base hover:text-green-200 transition-colors duration-200 {{ request()->routeIs('customer.resorts') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Resorts</a>
            <a href="{{ route('customer.attractions') }}" class="px-2 sm:px-3 md:px-3 py-1.5 md:py-2 text-white font-medium text-xs sm:text-sm md:text-base hover:text-green-200 transition-colors duration-200 {{ request()->routeIs('customer.attractions') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Attractions</a>
            <a href="{{ route('customer.cart') }}" class="px-2 sm:px-3 md:px-3 py-1.5 md:py-2 text-white font-medium text-xs sm:text-sm md:text-base hover:text-green-200 transition-colors duration-200 {{ request()->routeIs('customer.cart') ? 'text-green-200 border-b-2 border-green-200' : '' }} relative">
                My Cart
                @php
                    $headerCartCount = auth()->check() && auth()->user()->cart ? auth()->user()->cart->sum('quantity') : 0;
                @endphp
                @if($headerCartCount > 0)
                    <span class="cart-count-badge absolute -top-1 -right-1 bg-orange-500 text-white text-[10px] rounded-full w-4 h-4 flex items-center justify-center font-bold">{{ $headerCartCount }}</span>
                @endif
            </a>
            
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
                    <a href="{{ route('customer.orders') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-shopping-bag mr-2"></i>My Orders
                    </a>
                    <a href="{{ route('customer.messages') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-comments mr-2"></i>Messages
                    </a>
                    <div class="border-t border-gray-100"></div>
                    <button type="button" onclick="confirmDeleteAccount()" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                        <i class="fas fa-trash-alt mr-2"></i>Delete My Account
                    </button>
                    <a href="#" onclick="logoutUser(event)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </a>
                </div>
            </div>
            
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </nav>
        
        <!-- Right Side - Government Logos (Hidden on Mobile) -->
        <div class="hidden md:flex items-center space-x-2">
            <img src="{{ asset('Municipal Seal of Lagonoy.png') }}" alt="Municipal Seal of Lagonoy" class="w-10 h-10 object-cover rounded-full border-2 border-white drop-shadow-sm">
            <img src="{{ asset('bagong-pilipinas-logo.png') }}" alt="Bagong Pilipinas Logo" class="w-10 h-10 object-contain drop-shadow-sm">
            <img src="{{ asset('Provincial Logo of Camarines Sur.png') }}" alt="Provincial Logo of Camarines Sur" class="w-10 h-10 object-cover rounded-full border-2 border-white drop-shadow-sm">
            <img src="{{ asset('Department of Tourism (DOT) Philippines Logo.png') }}" alt="Department of Tourism Philippines" class="w-10 h-10 object-cover rounded-full border-2 border-white drop-shadow-sm">
        </div>
    </header>

    <!-- Main content wrapper with fixed navigation and three-column layout -->
    <div class="pt-20 md:pt-24 pb-20 md:pb-0 min-h-screen">
        <div class="flex min-h-[calc(100vh-5rem)] max-h-[calc(100vh-5rem)]">
            <!-- Left Sidebar - Orders Panel (Desktop Only) -->
            @auth
                @if(auth()->user()->role === 'customer' && auth()->user()->hasCompletedProfile())
                    <div id="ordersPanel" class="hidden lg:block w-80 bg-white border-r border-gray-200 overflow-y-auto flex-shrink-0 transition-all duration-300">
                        <div class="p-4 border-b border-gray-200 sticky top-0 bg-white z-10">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold text-gray-900 flex items-center">
                                    <button onclick="toggleOrdersPanel()" class="flex items-center hover:text-green-700 transition-colors relative">
                                        <i class="fas fa-shopping-bag text-green-600" id="ordersIcon"></i>
                                        <span id="ordersText" class="ml-2">My Orders</span>
                                        <i class="fas fa-chevron-right text-green-600 ml-1 hidden" id="ordersChevronRight"></i>
                                    </button>
                                </h3>
                                <div class="flex items-center space-x-2" id="ordersActions">
                                    <a href="{{ route('customer.orders') }}" class="text-xs text-green-600 hover:underline">
                                        View All
                                    </a>
                                    <button onclick="toggleOrdersPanel()" class="text-green-600 hover:text-green-700 p-1">
                                        <i id="ordersToggleIcon" class="fas fa-chevron-left text-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="ordersContent" class="p-4">
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
                @endif
            @endauth
            
            <!-- Main Content - Feed -->
            <main id="main-content" class="flex-1 overflow-y-auto bg-gray-50 pb-16 md:pb-0 min-w-0">
                @yield('content')
            </main>
            
            <!-- Right Sidebar - Messages Panel -->
            @auth
                @if(auth()->user()->role === 'customer' && auth()->user()->hasCompletedProfile())
                    <div id="messagesPanel" class="hidden lg:block w-80 bg-white border-l border-gray-200 overflow-y-auto flex-shrink-0 relative z-10 transition-all duration-300">
                        <div class="p-4 border-b border-gray-200 sticky top-0 bg-white z-20">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold text-gray-900 flex items-center">
                                    <button onclick="toggleMessagesPanel()" class="flex items-center hover:text-green-700 transition-colors relative">
                                        <i class="fas fa-chevron-left text-green-600 hidden" id="messagesChevronLeft"></i>
                                        <i class="fas fa-envelope text-green-600 ml-1" id="messagesIcon"></i>
                                        <span id="messagesText" class="ml-2">Messages</span>
                                        @php
                                            $unreadCount = auth()->user()->unreadMessages()->count();
                                        @endphp
                                        @if($unreadCount > 0)
                                            <span id="messagesUnreadBadge" class="ml-2 bg-red-500 text-white text-xs rounded-full px-2 py-1">{{ $unreadCount }}</span>
                                            <span id="messagesUnreadDot" class="hidden absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full border-2 border-white"></span>
                                        @endif
                                    </button>
                                </h3>
                                <button onclick="toggleMessagesPanel()" class="text-green-600 hover:text-green-700 p-1" id="messagesToggleBtn">
                                    <i id="messagesToggleIcon" class="fas fa-chevron-right text-sm"></i>
                                </button>
                            </div>
                        </div>
                        <div id="messagesContent" class="p-0">
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
                @endif
            @endauth
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
                    
                    <a href="{{ route('customer.orders') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors" onclick="closeMobileProfileSidebar()">
                        <i class="fas fa-shopping-bag w-6 text-green-600"></i>
                        <span class="ml-3 font-medium">My Orders</span>
                    </a>
                    
                    <a href="{{ route('customer.messages') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors" onclick="closeMobileProfileSidebar()">
                        <i class="fas fa-envelope w-6 text-green-600"></i>
                        <span class="ml-3 font-medium">Messages</span>
                    </a>
                    
                    <a href="{{ route('customer.cart') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors" onclick="closeMobileProfileSidebar()">
                        <i class="fas fa-shopping-cart w-6 text-green-600"></i>
                        <span class="ml-3 font-medium">My Cart</span>
                    </a>
                    
                    <div class="border-t border-gray-200 my-2"></div>
                    
                    <button type="button" onclick="confirmDeleteAccount()" class="w-full flex items-center px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                        <i class="fas fa-trash-alt w-6"></i>
                        <span class="ml-3 font-medium">Delete My Account</span>
                    </button>
                    
                    <a href="#" onclick="logoutUser(event)" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <i class="fas fa-sign-out-alt w-6 text-green-600"></i>
                        <span class="ml-3 font-medium">Logout</span>
                    </a>
                </nav>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-white py-12 px-4 md:px-10" style="background-color: #064e3b;">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- About Section -->
                <div class="md:col-span-2">
                    <h3 class="text-xl font-bold font-playfair mb-4">Pagsurong Lagonoy</h3>
                    <p class="text-green-100 mb-4 leading-relaxed">
                        Discover the beauty and culture of Lagonoy, Camarines Sur. From pristine beaches to rich heritage, 
                        experience authentic Filipino hospitality and natural wonders.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-green-200 hover:text-white transition-colors">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="#" class="text-green-200 hover:text-white transition-colors">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-green-200 hover:text-white transition-colors">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('customer.dashboard') }}" class="text-green-100 hover:text-white transition-colors">Dashboard</a></li>
                        <li><a href="{{ route('home') }}#about" class="text-green-100 hover:text-white transition-colors">About Us</a></li>
                        <li><a href="{{ route('home') }}#contact" class="text-green-100 hover:text-white transition-colors">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact Info</h4>
                    <div class="space-y-2 text-green-100">
                        <p><i class="fas fa-map-marker-alt mr-2"></i>Lagonoy, Camarines Sur</p>
                        <p><i class="fas fa-phone mr-2"></i>+63 XXX XXX XXXX</p>
                        <p><i class="fas fa-envelope mr-2"></i>info@pagsuronglagonoy.gov.ph</p>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-green-700 mt-8 pt-8 text-center">
                <p class="text-green-100">&copy; {{ $currentYear }} Pagsurong Lagonoy. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        function logoutUser(event) {
            event.preventDefault();
            if (confirm('Are you sure you want to logout?')) {
                document.getElementById('logout-form').submit();
            }
        }

        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Panel toggle functions with localStorage persistence
        function toggleOrdersPanel() {
            const panel = document.getElementById('ordersPanel');
            const content = document.getElementById('ordersContent');
            const icon = document.getElementById('ordersToggleIcon');
            const text = document.getElementById('ordersText');
            const actions = document.getElementById('ordersActions');
            const chevronRight = document.getElementById('ordersChevronRight');
            
            if (panel && content && icon && text && actions) {
                if (panel.classList.contains('w-80')) {
                    // Collapse
                    panel.classList.remove('w-80');
                    panel.classList.add('w-16');
                    content.classList.add('hidden');
                    text.classList.add('hidden');
                    actions.classList.add('hidden');
                    if (chevronRight) chevronRight.classList.remove('hidden');
                    icon.classList.remove('fa-chevron-left');
                    icon.classList.add('fa-chevron-right');
                    localStorage.setItem('ordersPanel', 'collapsed');
                } else {
                    // Expand
                    panel.classList.remove('w-16');
                    panel.classList.add('w-80');
                    content.classList.remove('hidden');
                    text.classList.remove('hidden');
                    actions.classList.remove('hidden');
                    if (chevronRight) chevronRight.classList.add('hidden');
                    icon.classList.remove('fa-chevron-right');
                    icon.classList.add('fa-chevron-left');
                    localStorage.setItem('ordersPanel', 'expanded');
                }
            }
        }

        function toggleMessagesPanel() {
            const panel = document.getElementById('messagesPanel');
            const content = document.getElementById('messagesContent');
            const icon = document.getElementById('messagesToggleIcon');
            const text = document.getElementById('messagesText');
            const badge = document.getElementById('messagesUnreadBadge');
            const dot = document.getElementById('messagesUnreadDot');
            const toggleBtn = document.getElementById('messagesToggleBtn');
            const chevronLeft = document.getElementById('messagesChevronLeft');
            
            if (panel && content && icon && text) {
                if (panel.classList.contains('w-80')) {
                    // Collapse
                    panel.classList.remove('w-80');
                    panel.classList.add('w-16');
                    content.classList.add('hidden');
                    text.classList.add('hidden');
                    if (badge) badge.classList.add('hidden');
                    if (dot) dot.classList.remove('hidden');
                    if (toggleBtn) toggleBtn.classList.add('hidden');
                    if (chevronLeft) chevronLeft.classList.remove('hidden');
                    icon.classList.remove('fa-chevron-right');
                    icon.classList.add('fa-chevron-left');
                    localStorage.setItem('messagesPanel', 'collapsed');
                } else {
                    // Expand
                    panel.classList.remove('w-16');
                    panel.classList.add('w-80');
                    content.classList.remove('hidden');
                    text.classList.remove('hidden');
                    if (badge) badge.classList.remove('hidden');
                    if (dot) dot.classList.add('hidden');
                    if (toggleBtn) toggleBtn.classList.remove('hidden');
                    if (chevronLeft) chevronLeft.classList.add('hidden');
                    icon.classList.remove('fa-chevron-left');
                    icon.classList.add('fa-chevron-right');
                    localStorage.setItem('messagesPanel', 'expanded');
                }
            }
        }

        // Restore panel states on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Restore Orders Panel state
            const ordersState = localStorage.getItem('ordersPanel');
            if (ordersState === 'collapsed') {
                const panel = document.getElementById('ordersPanel');
                const content = document.getElementById('ordersContent');
                const icon = document.getElementById('ordersToggleIcon');
                const text = document.getElementById('ordersText');
                const actions = document.getElementById('ordersActions');
                const chevronRight = document.getElementById('ordersChevronRight');
                if (panel && content && icon && text && actions) {
                    panel.classList.remove('w-80');
                    panel.classList.add('w-16');
                    content.classList.add('hidden');
                    text.classList.add('hidden');
                    actions.classList.add('hidden');
                    if (chevronRight) chevronRight.classList.remove('hidden');
                    icon.classList.remove('fa-chevron-left');
                    icon.classList.add('fa-chevron-right');
                }
            }

            // Restore Messages Panel state
            const messagesState = localStorage.getItem('messagesPanel');
            if (messagesState === 'collapsed') {
                const panel = document.getElementById('messagesPanel');
                const content = document.getElementById('messagesContent');
                const icon = document.getElementById('messagesToggleIcon');
                const text = document.getElementById('messagesText');
                const badge = document.getElementById('messagesUnreadBadge');
                const dot = document.getElementById('messagesUnreadDot');
                const toggleBtn = document.getElementById('messagesToggleBtn');
                const chevronLeft = document.getElementById('messagesChevronLeft');
                if (panel && content && icon && text) {
                    panel.classList.remove('w-80');
                    panel.classList.add('w-16');
                    content.classList.add('hidden');
                    text.classList.add('hidden');
                    if (badge) badge.classList.add('hidden');
                    if (dot) dot.classList.remove('hidden');
                    if (toggleBtn) toggleBtn.classList.add('hidden');
                    if (chevronLeft) chevronLeft.classList.remove('hidden');
                    icon.classList.remove('fa-chevron-right');
                    icon.classList.add('fa-chevron-left');
                }
            }
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

        // Delete Account Confirmation
        function confirmDeleteAccount() {
            document.getElementById('deleteAccountModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteAccountModal() {
            document.getElementById('deleteAccountModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function deleteAccount() {
            document.getElementById('delete-account-form').submit();
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

    <!-- Delete Account Confirmation Modal -->
    <div id="deleteAccountModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-3 border-b">
                <h3 class="text-xl font-bold text-gray-900">
                    <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                    Delete Account
                </h3>
                <button type="button" onclick="closeDeleteAccountModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="mt-4">
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                <strong>Warning:</strong> This action cannot be undone!
                            </p>
                        </div>
                    </div>
                </div>
                
                <p class="text-gray-700 mb-4">
                    Are you sure you want to delete your account? This will permanently remove:
                </p>
                
                <ul class="list-disc list-inside text-gray-600 mb-4 space-y-1">
                    <li>Your profile information</li>
                    <li>Your order history</li>
                    <li>Your messages</li>
                    <li>All your account data</li>
                </ul>
                
                <p class="text-gray-700 font-semibold">
                    Type your confirmation below to proceed.
                </p>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                <button type="button" onclick="closeDeleteAccountModal()" 
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors">
                    Cancel
                </button>
                <button type="button" onclick="deleteAccount()" 
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                    <i class="fas fa-trash-alt mr-2"></i>
                    Delete My Account
                </button>
            </div>
        </div>
    </div>

    <!-- Hidden Delete Account Form -->
    <form id="delete-account-form" action="{{ route('account.delete') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
    
    @yield('scripts')
</body>
</html>
