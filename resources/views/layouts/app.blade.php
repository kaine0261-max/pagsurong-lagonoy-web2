<?php $currentYear = date("Y"); ?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Pagsurong Lagonoy')</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'playfair': ['"Playfair Display"', 'serif'],
                        'roboto': ['"Roboto"', 'sans-serif']
                    },
                    colors: {
                        'primary': '#15803d', // green-700
                        'secondary': '#f97316' // orange-500
                    }
                }
            },
            plugins: []
        }
    </script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">

    @stack('styles')
</head>
<body class="font-roboto text-gray-800 leading-relaxed bg-gray-50 antialiased">

    <!-- Skip to Content (Accessibility) -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 bg-green-600 text-white px-4 py-2 rounded-md z-50">
        Skip to main content
    </a>

    <!-- Header -->
    <header style="background-color: #064e3b;" class="text-white shadow-md fixed w-full top-0 left-0 right-0 z-50">
        <!-- Mobile Top Header -->
        <div class="md:hidden px-4 py-3 flex items-center justify-between">
            <!-- Left Side - Main Branding -->
            <div class="flex items-center space-x-2">
                <img src="{{ asset('logo.png') }}" alt="Pagsurong Lagonoy Logo" class="w-8 h-auto">
                <div class="font-playfair text-lg font-bold">Pagsurong Lagonoy</div>
            </div>
            
        </div>
        
        <!-- Mobile Category Navigation -->
        <div class="md:hidden px-4 py-2 flex items-center justify-center space-x-4 text-xs border-t border-green-700">
                @auth
                    @php
                        $user = auth()->user();
                    @endphp
                    @if($user->role === 'customer' && $user->hasCompletedProfile())
                        <a href="{{ route('customer.products') }}" class="text-white hover:text-green-200 transition-colors relative pb-1 {{ request()->routeIs('customer.products') ? 'font-semibold' : '' }}">
                            Products
                            <span class="absolute bottom-0 left-0 h-0.5 bg-green-400 {{ request()->routeIs('customer.products') ? 'w-full' : 'w-0' }}"></span>
                        </a>
                        <a href="{{ route('customer.shops') }}" class="text-white hover:text-green-200 transition-colors relative pb-1 {{ request()->routeIs('customer.shops*') ? 'font-semibold' : '' }}">
                            Shops
                            <span class="absolute bottom-0 left-0 h-0.5 bg-green-400 {{ request()->routeIs('customer.shops*') ? 'w-full' : 'w-0' }}"></span>
                        </a>
                        <a href="{{ route('customer.hotels') }}" class="text-white hover:text-green-200 transition-colors relative pb-1 {{ request()->routeIs('customer.hotels*') ? 'font-semibold' : '' }}">
                            Hotels
                            <span class="absolute bottom-0 left-0 h-0.5 bg-green-400 {{ request()->routeIs('customer.hotels*') ? 'w-full' : 'w-0' }}"></span>
                        </a>
                        <a href="{{ route('customer.resorts') }}" class="text-white hover:text-green-200 transition-colors relative pb-1 {{ request()->routeIs('customer.resorts*') ? 'font-semibold' : '' }}">
                            Resorts
                            <span class="absolute bottom-0 left-0 h-0.5 bg-green-400 {{ request()->routeIs('customer.resorts*') ? 'w-full' : 'w-0' }}"></span>
                        </a>
                        <a href="{{ route('customer.attractions') }}" class="text-white hover:text-green-200 transition-colors relative pb-1 {{ request()->routeIs('customer.attractions*') ? 'font-semibold' : '' }}">
                            Attractions
                            <span class="absolute bottom-0 left-0 h-0.5 bg-green-400 {{ request()->routeIs('customer.attractions*') ? 'w-full' : 'w-0' }}"></span>
                        </a>
                    @elseif($user->role === 'customer' && !$user->hasCompletedProfile())
                        <span class="text-white text-xs opacity-75">Complete your profile to access all features</span>
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
                
                @if($user->role === 'customer')
                    @if($user->hasCompletedProfile())
                        <!-- Mobile Bottom Navigation - Full customer features -->
                        <a href="{{ route('customer.dashboard') }}" class="flex flex-col items-center px-2 py-3 text-xs text-gray-600 hover:text-green-500 transition-colors {{ request()->routeIs('customer.dashboard') ? 'text-green-500' : '' }}">
                            <i class="fas fa-home text-xl mb-1"></i>
                            <span class="text-[10px] leading-tight">Home</span>
                        </a>

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
                @elseif($user->role === 'business_owner')
                    @php
                        $bizProfile = $user->businessProfile;
                        $isApproved = $bizProfile && ($bizProfile->status === 'approved');
                        $isPublished = $bizProfile && ($bizProfile->is_published ?? false);
                        // Fix: Get pending orders count from the business relationship, not businessProfile
                        $pendingOrdersCount = 0;
                        if ($user->business) {
                            $pendingOrdersCount = $user->business->orders()->where('status', 'pending')->count();
                        }
                    @endphp
                    
                    @if($isApproved || $isPublished)
                        <!-- Business Owner Mobile Navigation - When Business is Approved/Published -->
                        @if($bizProfile && $bizProfile->business_type === 'resort')
                            <a href="{{ route('business.my-resort') }}" class="flex flex-col items-center px-2 py-3 text-xs text-gray-600 hover:text-green-500 transition-colors {{ request()->routeIs('business.my-resort') ? 'text-green-500' : '' }}">
                                <i class="fas fa-umbrella-beach text-xl mb-1"></i>
                                <span class="text-[10px] leading-tight">My Resort</span>
                            </a>
                        @elseif($bizProfile && $bizProfile->business_type === 'hotel')
                            <a href="{{ route('business.my-hotel') }}" class="flex flex-col items-center px-2 py-3 text-xs text-gray-600 hover:text-green-500 transition-colors {{ request()->routeIs('business.my-hotel') ? 'text-green-500' : '' }}">
                                <i class="fas fa-hotel text-xl mb-1"></i>
                                <span class="text-[10px] leading-tight">My Hotel</span>
                            </a>
                        @else
                            <a href="{{ route('business.my-shop') }}" class="flex flex-col items-center px-2 py-3 text-xs text-gray-600 hover:text-green-500 transition-colors {{ request()->routeIs('business.my-shop') ? 'text-green-500' : '' }}">
                                <i class="fas fa-store text-xl mb-1"></i>
                                <span class="text-[10px] leading-tight">My Shop</span>
                            </a>
                        @endif
                        
                        <!-- Orders - Show for all business types -->
                        @if($bizProfile && $bizProfile->business_type === 'shop')
                        <a href="{{ route('business.orders') }}" class="flex flex-col items-center px-2 py-3 text-xs text-gray-600 hover:text-green-500 transition-colors relative {{ request()->routeIs('business.orders') ? 'text-green-500' : '' }}">
                            <div class="relative">
                                <i class="fas fa-shopping-bag text-xl mb-1"></i>
                                @if($pendingOrdersCount > 0)
                                    <span class="absolute -top-1 -right-2 bg-red-500 text-white text-[10px] rounded-full w-5 h-5 flex items-center justify-center font-bold">
                                        {{ $pendingOrdersCount }}
                                    </span>
                                @endif
                            </div>
                            <span class="text-[10px] leading-tight">Orders</span>
                        </a>
                        @endif
                        
                        <!-- Messages - Show for all business types -->
                        <a href="{{ route('messages.index') }}" class="flex flex-col items-center px-2 py-3 text-xs text-gray-600 hover:text-green-500 transition-colors relative {{ request()->routeIs('messages.*') ? 'text-green-500' : '' }}">
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
                        <!-- Business Owner Mobile Navigation - When Business Needs Setup/Approval -->
                        {{-- Only show navigation links if user has completed business setup (has business profile) --}}
                        @if($bizProfile)
                            @php
                                $setupLabel = 'Shop';
                                $setupRoute = 'business.my-shop';
                                $setupIcon = 'fas fa-store';
                                if ($bizProfile->business_type === 'hotel') {
                                    $setupLabel = 'Hotel';
                                    $setupRoute = 'business.my-hotel';
                                    $setupIcon = 'fas fa-hotel';
                                } elseif ($bizProfile->business_type === 'resort') {
                                    $setupLabel = 'Resort';
                                    $setupRoute = 'business.my-resort';
                                    $setupIcon = 'fas fa-umbrella-beach';
                                }
                            @endphp
                            
                            <a href="{{ route($setupRoute) }}" class="flex flex-col items-center px-2 py-3 text-xs text-gray-600 hover:text-green-500 transition-colors {{ request()->routeIs($setupRoute) ? 'text-green-500' : '' }}">
                                <i class="{{ $setupIcon }} text-xl mb-1"></i>
                                <span class="text-[10px] leading-tight text-center">My<br>{{ $setupLabel }}</span>
                            </a>
                            
                            @if($bizProfile->status === 'pending')
                                <div class="flex flex-col items-center px-2 py-3 text-xs text-yellow-600">
                                    <i class="fas fa-clock text-xl mb-1"></i>
                                    <span class="text-[10px] leading-tight text-center">Pending<br>Approval</span>
                                </div>
                            @endif
                        @endif
                        
                        <a href="{{ route('dashboard') }}" class="flex flex-col items-center px-2 py-3 text-xs text-gray-600 hover:text-green-500 transition-colors {{ request()->routeIs('dashboard') ? 'text-green-500' : '' }}">
                            <i class="fas fa-home text-xl mb-1"></i>
                            <span class="text-[10px] leading-tight">Home</span>
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
                @elseif($user->role === 'admin')
                    <!-- Admin Mobile Navigation -->
                    <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center px-2 py-3 text-xs text-gray-600 hover:text-green-500 transition-colors {{ request()->routeIs('admin.dashboard') ? 'text-green-500' : '' }}">
                        <i class="fas fa-tachometer-alt text-xl mb-1"></i>
                        <span class="text-[10px] leading-tight">Dashboard</span>
                    </a>
                    
                    <a href="{{ route('admin.business-approvals.index') }}" class="flex flex-col items-center px-2 py-3 text-xs text-gray-600 hover:text-green-500 transition-colors {{ request()->routeIs('admin.business-approvals.*') ? 'text-green-500' : '' }}">
                        <i class="fas fa-clipboard-check text-xl mb-1"></i>
                        <span class="text-[10px] leading-tight">Approvals</span>
                    </a>
                    
                    <a href="{{ route('admin.users') }}" class="flex flex-col items-center px-2 py-3 text-xs text-gray-600 hover:text-green-500 transition-colors {{ request()->routeIs('admin.users') ? 'text-green-500' : '' }}">
                        <i class="fas fa-users text-xl mb-1"></i>
                        <span class="text-[10px] leading-tight">Users</span>
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
        
        <!-- Desktop Header -->
        <div class="hidden md:flex py-3 px-4 md:px-10 justify-between items-center">
            <!-- Left Side - Main Branding -->
            <div class="flex items-center">
                <a href="javascript:history.back()" class="flex items-center hover:opacity-80 transition-opacity">
                    <img src="{{ asset('logo.png') }}" alt="Pagsurong Lagonoy Logo" class="w-12 h-auto mr-3 drop-shadow-sm">
                    <div class="font-playfair text-2xl font-bold">Pagsurong Lagonoy</div>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="flex items-center space-x-6">
            @auth
                @php
                    $user = auth()->user();
                    $unreadMessages = $user->unreadMessages()->count() ?? 0;
                    $cartCount = $user->cart ? $user->cart->count() : 0;
                @endphp

                @if($user->role === 'business_owner')
                    @php
                        // Prefer BusinessProfile status for approval; fall back to publish flag
                        $bizProfile = $user->businessProfile;
                        $isApproved = $bizProfile && ($bizProfile->status === 'approved');
                        $isPublished = $bizProfile && ($bizProfile->is_published ?? false);
                        // Fix: Get pending orders count from the business relationship, not businessProfile
                        $pendingOrdersCount = 0;
                        if ($user->business) {
                            $pendingOrdersCount = $user->business->orders()->where('status', 'pending')->count();
                        }
                    @endphp
                    @if($isApproved || $isPublished)
                        <!-- Business Owner Nav - When Business is Approved/Published -->
                        @if($bizProfile && $bizProfile->business_type === 'resort')
                            <a href="{{ route('business.my-resort') }}" 
                               class="text-white hover:text-green-100 transition-all duration-200 relative group {{ request()->routeIs(['business.my-resort', 'profile.show', 'profile.edit']) ? 'font-semibold' : '' }}">
                                <i class="fas fa-umbrella-beach mr-1"></i> My Resort
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-400 group-hover:w-full transition-all duration-300 {{ request()->routeIs(['business.my-resort', 'profile.show', 'profile.edit']) ? 'w-full' : '' }}"></span>
                            </a>
                        @elseif($bizProfile && $bizProfile->business_type === 'hotel')
                            <a href="{{ route('business.my-hotel') }}" 
                               class="text-white hover:text-green-100 transition-all duration-200 relative group {{ request()->routeIs(['business.my-hotel', 'profile.show', 'profile.edit']) ? 'font-semibold' : '' }}">
                                <i class="fas fa-hotel mr-1"></i> My Hotel
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-400 group-hover:w-full transition-all duration-300 {{ request()->routeIs(['business.my-hotel', 'profile.show', 'profile.edit']) ? 'w-full' : '' }}"></span>
                            </a>
                        @else
                            <a href="{{ route('business.my-shop') }}" 
                               class="text-white hover:text-green-100 transition-all duration-200 relative group {{ request()->routeIs(['business.my-shop', 'profile.show', 'profile.edit']) ? 'font-semibold' : '' }}">
                                <i class="fas fa-store mr-1"></i> My Shop
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-400 group-hover:w-full transition-all duration-300 {{ request()->routeIs(['business.my-shop', 'profile.show', 'profile.edit']) ? 'w-full' : '' }}"></span>
                            </a>
                        @endif
                        
                        @if($bizProfile && $bizProfile->business_type === 'shop')
                        <a href="{{ route('business.orders') }}" 
                           class="text-white hover:text-green-100 transition-all duration-200 relative group {{ request()->routeIs('business.orders') ? 'font-semibold' : '' }}">
                            <i class="fas fa-shopping-bag mr-1"></i> Orders
                            @if($pendingOrdersCount > 0)
                                <span class="ml-1 bg-red-500 text-white text-xs rounded-full px-2 py-0.5 font-bold">
                                    {{ $pendingOrdersCount }}
                                </span>
                            @endif
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-400 group-hover:w-full transition-all duration-300 {{ request()->routeIs('business.orders') ? 'w-full' : '' }}"></span>
                        </a>
                        @endif
                        
                    @else
                        <!-- Business Owner Nav - When Business Needs Setup/Approval -->
                        {{-- Only show navigation links if user has completed business setup (has business profile) --}}
                        @if($bizProfile)
                            @php
                                $setupLabel = 'Shop';
                                if ($bizProfile->business_type === 'hotel') {
                                    $setupLabel = 'Hotel';
                                } elseif ($bizProfile->business_type === 'resort') {
                                    $setupLabel = 'Resort';
                                }
                            @endphp
                            @if($setupLabel === 'Hotel')
                                <a href="{{ route('business.my-hotel') }}" 
                                   class="text-white hover:text-green-100 transition-all duration-200 relative group {{ request()->routeIs('business.my-hotel') ? 'font-semibold' : '' }}">
                                    <i class="fas fa-hotel mr-1"></i> My {{ $setupLabel }}
                                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-400 group-hover:w-full transition-all duration-300 {{ request()->routeIs('business.my-hotel') ? 'w-full' : '' }}"></span>
                                </a>
                            @elseif($setupLabel === 'Resort')
                                <a href="{{ route('business.my-resort') }}" 
                                   class="text-white hover:text-green-100 transition-all duration-200 relative group {{ request()->routeIs('business.my-resort') ? 'font-semibold' : '' }}">
                                    <i class="fas fa-umbrella-beach mr-1"></i> My {{ $setupLabel }}
                                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-400 group-hover:w-full transition-all duration-300 {{ request()->routeIs('business.my-resort') ? 'w-full' : '' }}"></span>
                                </a>
                            @else
                                <a href="{{ route('business.my-shop') }}" 
                                   class="text-white hover:text-green-100 transition-all duration-200 relative group {{ request()->routeIs('business.my-shop') ? 'font-semibold' : '' }}">
                                    <i class="fas fa-store mr-1"></i> My {{ $setupLabel }}
                                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-400 group-hover:w-full transition-all duration-300 {{ request()->routeIs('business.my-shop') ? 'w-full' : '' }}"></span>
                                </a>
                            @endif
                            @if($bizProfile->status === 'pending')
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    Pending Approval
                                </span>
                            @endif
                        @endif
                        {{-- No navigation links shown during initial business setup --}}
                    @endif
                    @elseif($user->role === 'admin')
                        <!-- Admin Nav -->
                        <a href="{{ route('admin.dashboard') }}" 
                           class="text-white hover:text-green-100 transition-all duration-200 relative group {{ request()->routeIs('admin.dashboard') ? 'font-semibold' : '' }}">
                            Dashboard
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-400 group-hover:w-full transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'w-full' : '' }}"></span>
                        </a>
                        <a href="{{ route('admin.business-approvals.index') }}" 
                           class="text-white hover:text-green-100 transition-all duration-200 relative group {{ request()->routeIs('admin.business-approvals.*') ? 'font-semibold' : '' }}">
                            Approval
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-400 group-hover:w-full transition-all duration-300 {{ request()->routeIs('admin.business-approvals.*') ? 'w-full' : '' }}"></span>
                        </a>
                        <a href="{{ route('admin.users') }}" 
                           class="text-white hover:text-green-100 transition-all duration-200 relative group {{ request()->routeIs('admin.users') ? 'font-semibold' : '' }}">
                            Users
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-400 group-hover:w-full transition-all duration-300 {{ request()->routeIs('admin.users') ? 'w-full' : '' }}"></span>
                        </a>
                        <a href="{{ route('admin.upload.spots') }}" 
                           class="text-white hover:text-green-100 transition-colors duration-200 {{ request()->routeIs('admin.upload.spots') ? 'font-semibold' : '' }}">
                            Promotions
                        </a>

                @else
                    <!-- Customer Nav - Desktop -->
                    <div class="hidden md:flex items-center space-x-6">
                        @if($user->hasCompletedProfile())
                            <!-- Full customer navigation - consistent with public design (no icons) -->
                            <a href="{{ route('customer.dashboard') }}"
                               class="text-white hover:text-green-100 transition-all duration-200 relative group {{ request()->routeIs('customer.dashboard') ? 'font-semibold' : '' }}">
                                Home
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-400 group-hover:w-full transition-all duration-300 {{ request()->routeIs('customer.dashboard') ? 'w-full' : '' }}"></span>
                            </a>
                            <a href="{{ route('customer.products') }}"
                               class="text-white hover:text-green-100 transition-all duration-200 relative group {{ request()->routeIs('customer.products') ? 'font-semibold' : '' }}">
                                Products
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-400 group-hover:w-full transition-all duration-300 {{ request()->routeIs('customer.products') ? 'w-full' : '' }}"></span>
                            </a>
                            <a href="{{ route('customer.shops') }}"
                               class="text-white hover:text-green-100 transition-all duration-200 relative group {{ request()->routeIs('customer.shops*') ? 'font-semibold' : '' }}">
                                Shops
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-400 group-hover:w-full transition-all duration-300 {{ request()->routeIs('customer.shops*') ? 'w-full' : '' }}"></span>
                            </a>
                            <a href="{{ route('customer.hotels') }}"
                               class="text-white hover:text-green-100 transition-all duration-200 relative group {{ request()->routeIs('customer.hotels*') ? 'font-semibold' : '' }}">
                                Hotels
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-400 group-hover:w-full transition-all duration-300 {{ request()->routeIs('customer.hotels*') ? 'w-full' : '' }}"></span>
                            </a>
                            <a href="{{ route('customer.resorts') }}"
                               class="text-white hover:text-green-100 transition-all duration-200 relative group {{ request()->routeIs('customer.resorts*') ? 'font-semibold' : '' }}">
                                Resorts
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-400 group-hover:w-full transition-all duration-300 {{ request()->routeIs('customer.resorts*') ? 'w-full' : '' }}"></span>
                            </a>
                            <a href="{{ route('customer.attractions') }}"
                               class="text-white hover:text-green-100 transition-all duration-200 relative group {{ request()->routeIs('customer.attractions*') ? 'font-semibold' : '' }}">
                                Attractions
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-400 group-hover:w-full transition-all duration-300 {{ request()->routeIs('customer.attractions*') ? 'w-full' : '' }}"></span>
                            </a>
                            <a href="{{ route('customer.cart') }}" class="text-white hover:text-green-100 transition-all duration-200 relative group {{ request()->routeIs('customer.cart') ? 'font-semibold' : '' }}">
                                My Cart
                                @if($cartCount > 0)
                                    <span class="ml-1 bg-orange-500 text-white text-xs rounded-full px-2 py-0.5 font-bold">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-400 group-hover:w-full transition-all duration-300 {{ request()->routeIs('customer.cart') ? 'w-full' : '' }}"></span>
                            </a>
                        @else
                            <!-- Simple navigation - during profile setup -->
                            <a href="{{ route('profile.setup') }}"
                               class="text-white hover:text-green-100 transition-all duration-200 relative group {{ request()->routeIs('profile.setup') ? 'font-semibold' : '' }}">
                                Complete Profile
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-400 group-hover:w-full transition-all duration-300 {{ request()->routeIs('profile.setup') ? 'w-full' : '' }}"></span>
                            </a>
                        @endif
                    </div>
                @endif

                <!-- Profile Dropdown -->
                <div class="relative group">
                    <button class="flex items-center focus:outline-none focus:ring-2 focus:ring-blue-300 rounded-full">
                        @if($user->profile && $user->profile->profile_picture)
                            <img src="{{ Storage::url($user->profile->profile_picture) }}" 
                                 alt="Profile" 
                                 class="w-10 h-10 rounded-full object-cover border-2 border-green-500">
                        @else
                            <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </button>

                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg py-1 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                        <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user mr-2"></i> My Profile
                        </a>
                        <hr class="my-1 border-gray-100">
                        <form method="POST" action="{{ route('logout') }}" id="logout-form" class="hidden">
                            @csrf
                        </form>
                        <button type="button" onclick="confirmLogout()" 
                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </div>
                </div>
            @else
                <!-- Guest Navigation -->
                <a href="{{ route('login') }}" class="text-white hover:text-green-100 transition-all duration-200 relative group">
                    Login
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-400 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="{{ route('register') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-all duration-200">Register</a>
            @endauth
        </nav>
        </div>
    </header>

    <!-- Main content wrapper with fixed navigation and three-column layout -->
    <div class="pt-20 md:pt-16 pb-20 md:pb-0 min-h-screen">
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
                                $orders = auth()->user()->orders()->latest()->take(5)->get();
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
                                                <span class="px-2 py-1 text-xs rounded-full {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
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
                                                            <p class="text-xs text-blue-600 font-medium mt-1">
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
                                    <a href="{{ route('customer.products') }}" class="text-xs text-blue-600 hover:underline">
                                        Browse products to get started
                                    </a>
                                </div>
                            @endif
                        </div>
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


    <!-- Scripts -->
    <script>
        function confirmLogout(type = 'desktop') {
            if (confirm('Are you sure you want to logout?')) {
                let formId;
                if (type === 'mobile') {
                    formId = 'logout-form-mobile';
                } else if (type === 'mobile-sidebar') {
                    formId = 'logout-form-mobile-sidebar';
                } else {
                    formId = 'logout-form';
                }
                document.getElementById(formId).submit();
            }
        }
    </script>

    @stack('scripts')
    
    @auth
        @if((auth()->user()->role === 'customer' && auth()->user()->hasCompletedProfile()) || (auth()->user()->role === 'business_owner' && auth()->user()->businessProfile && !request()->routeIs(['business.my-hotel', 'business.my-resort'])))
            <style>
                /* Smooth transitions for the messages panel */
                #messagesPanel {
                    box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
                }
                
                /* Adjust main content when messages panel is open */
                @media (min-width: 768px) {
                    #messagesPanel.translate-x-0 + main {
                        margin-right: 20rem;
                        transition: margin-right 0.3s ease-in-out;
                    }
                }
                
                /* Message list styles */
                .message-item {
                    transition: background-color 0.2s ease;
                }
                
                .message-item:hover {
                    background-color: #f9fafb;
                }
                
                /* Custom scrollbar for messages */
                .messages-scroll {
                    scrollbar-width: thin;
                    scrollbar-color: #cbd5e0 #f7fafc;
                }
                
                .messages-scroll::-webkit-scrollbar {
                    width: 6px;
                }
                
                .messages-scroll::-webkit-scrollbar-track {
                    background: #f7fafc;
                }
                
                .messages-scroll::-webkit-scrollbar-thumb {
                    background-color: #cbd5e0;
                    border-radius: 3px;
                }
            </style>
        @endif
    @endauth
    
    <!-- Mobile Profile Sidebar -->
    @auth
        @if((auth()->user()->role === 'customer' && auth()->user()->hasCompletedProfile()) || (auth()->user()->role === 'business_owner' && auth()->user()->businessProfile))
            <!-- Overlay -->
            <div id="mobileProfileOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden" onclick="closeMobileProfileSidebar()"></div>
            
            <!-- Sidebar -->
            <div id="mobileProfileSidebar" class="fixed top-0 right-0 h-full w-80 bg-white shadow-xl transform translate-x-full transition-transform duration-300 ease-in-out z-50 md:hidden">
                <div class="flex flex-col h-full">
                    <!-- Header -->
                    <div class="bg-green-600 text-white p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                @if(auth()->user()->profile && auth()->user()->profile->profile_picture)
                                    <img src="{{ Storage::url(auth()->user()->profile->profile_picture) }}" 
                                         alt="Profile" 
                                         class="w-12 h-12 rounded-full object-cover border-2 border-white">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-white bg-opacity-20 flex items-center justify-center text-white text-lg font-semibold">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <h3 class="font-semibold text-lg">{{ auth()->user()->name }}</h3>
                                    <p class="text-blue-100 text-sm">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                            <button onclick="closeMobileProfileSidebar()" class="text-white hover:text-blue-200 transition-colors">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Menu Items -->
                    <div class="flex-1 py-4">
                        @php
                            $user = auth()->user();
                        @endphp

                        @if($user->role === 'customer')
                            <a href="{{ route('profile.show') }}" class="flex items-center px-6 py-4 text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-user mr-4 text-blue-600 w-5"></i>
                                <span class="font-medium">My Profile</span>
                            </a>
                            <a href="{{ route('customer.orders') }}" class="flex items-center px-6 py-4 text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-shopping-bag mr-4 text-blue-600 w-5"></i>
                                <span class="font-medium">My Orders</span>
                            </a>
                            <a href="{{ route('customer.messages') }}" class="flex items-center px-6 py-4 text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-envelope mr-4 text-blue-600 w-5"></i>
                                <span class="font-medium">Messages</span>
                            </a>
                        @else
                            <!-- Business Owner Menu Items -->
                            <a href="{{ route('profile.show') }}" class="flex items-center px-6 py-4 text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-user mr-4 text-blue-600 w-5"></i>
                                <span class="font-medium">My Profile</span>
                            </a>

                            @if($user->businessProfile && $user->businessProfile->business_type === 'resort')
                                <a href="{{ route('business.my-resort') }}" class="flex items-center px-6 py-4 text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-umbrella-beach mr-4 text-blue-600 w-5"></i>
                                    <span class="font-medium">My Resort</span>
                                </a>
                            @elseif($user->businessProfile && $user->businessProfile->business_type === 'hotel')
                                <a href="{{ route('business.my-hotel') }}" class="flex items-center px-6 py-4 text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-hotel mr-4 text-blue-600 w-5"></i>
                                    <span class="font-medium">My Hotel</span>
                                </a>
                            @else
                                <a href="{{ route('business.my-shop') }}" class="flex items-center px-6 py-4 text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-store mr-4 text-blue-600 w-5"></i>
                                    <span class="font-medium">My Shop</span>
                                </a>
                            @endif

                            <hr class="my-2 border-gray-200">

                            @if($user->businessProfile && $user->businessProfile->business_type === 'shop')
                            <a href="{{ route('business.orders') }}" class="flex items-center px-6 py-4 text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-shopping-bag mr-4 text-blue-600 w-5"></i>
                                <span class="font-medium">Orders</span>
                            </a>
                            @endif

                            <a href="{{ route('messages.index') }}" class="flex items-center px-6 py-4 text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-envelope mr-4 text-blue-600 w-5"></i>
                                <span class="font-medium">Messages</span>
                            </a>
                        @endif

                    </div>
                    
                    <!-- Logout Button -->
                    <div class="border-t border-gray-200 p-4">
                        <form method="POST" action="{{ route('logout') }}" id="logout-form-mobile-sidebar" class="hidden">
                            @csrf
                        </form>
                        <button type="button" onclick="confirmLogout('mobile-sidebar')" 
                                class="w-full flex items-center px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                            <i class="fas fa-sign-out-alt mr-4 w-5"></i>
                            <span class="font-medium">Logout</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif
    @endauth
    
    <!-- Mobile Profile Sidebar JavaScript -->
    <script>
        function toggleMobileProfileSidebar() {
            const sidebar = document.getElementById('mobileProfileSidebar');
            const overlay = document.getElementById('mobileProfileOverlay');
            
            if (sidebar && overlay) {
                const isOpen = !sidebar.classList.contains('translate-x-full');
                
                if (isOpen) {
                    closeMobileProfileSidebar();
                } else {
                    openMobileProfileSidebar();
                }
            }
        }
        
        function openMobileProfileSidebar() {
            const sidebar = document.getElementById('mobileProfileSidebar');
            const overlay = document.getElementById('mobileProfileOverlay');
            
            if (sidebar && overlay) {
                overlay.classList.remove('hidden');
                sidebar.classList.remove('translate-x-full');
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
            }
        }
        
        function closeMobileProfileSidebar() {
            const sidebar = document.getElementById('mobileProfileSidebar');
            const overlay = document.getElementById('mobileProfileOverlay');
            
            if (sidebar && overlay) {
                sidebar.classList.add('translate-x-full');
                overlay.classList.add('hidden');
                document.body.style.overflow = ''; // Restore scrolling
            }
        }
        
        // Close sidebar when clicking on links (except logout)
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarLinks = document.querySelectorAll('#mobileProfileSidebar a[href]:not([href="#"])');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    closeMobileProfileSidebar();
                });
            });
        });

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
                
                // Save state
                localStorage.setItem('sidebarPanel', 'orders');
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
                
                // Save state
                localStorage.setItem('sidebarPanel', 'messages');
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
                
                // Save state
                localStorage.setItem('sidebarPanel', 'cart');
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
                
                // Save state
                localStorage.setItem('sidebarPanel', 'minimized');
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

        // Restore panel state on page load
        document.addEventListener('DOMContentLoaded', function() {
            const panelState = localStorage.getItem('sidebarPanel');
            
            if (panelState === 'orders') {
                showOrdersPanel();
            } else if (panelState === 'messages') {
                showMessagesPanel();
            } else if (panelState === 'cart') {
                showCartPanel();
            } else {
                // Default to minimized
                minimizePanel();
            }
        });

        // Delete Account Confirmation
        function confirmDeleteAccount() {
            document.getElementById('deleteAccountModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteAccountModal() {
            document.getElementById('deleteAccountModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function deleteMyAccount() {
            document.getElementById('delete-account-form').submit();
        }
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
            <div class="py-4">
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                    <p class="text-sm text-red-800 font-semibold mb-2">
                        <i class="fas fa-exclamation-circle mr-1"></i> Warning: This action cannot be undone!
                    </p>
                    <p class="text-sm text-red-700">
                        Deleting your account will permanently remove:
                    </p>
                    <ul class="list-disc list-inside text-sm text-red-700 mt-2 space-y-1">
                        <li>Your profile and personal information</li>
                        <li>All your orders and order history</li>
                        <li>Your messages and conversations</li>
                        @if(auth()->user()->role === 'business_owner')
                        <li>Your business profile and listings</li>
                        <li>All products and services</li>
                        @endif
                    </ul>
                </div>
                
                <p class="text-gray-700 text-sm mb-4">
                    Are you absolutely sure you want to delete your account? This action is permanent and cannot be reversed.
                </p>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex justify-end gap-3 pt-3 border-t">
                <button type="button" onclick="closeDeleteAccountModal()" 
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                    <i class="fas fa-times mr-2"></i>Cancel
                </button>
                <button type="button" onclick="deleteMyAccount()" 
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    <i class="fas fa-trash-alt mr-2"></i>Delete My Account
                </button>
            </div>
        </div>
    </div>

    <!-- Hidden Delete Account Form -->
    <form id="delete-account-form" action="{{ route('account.delete') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <!-- Rating System -->
    <script src="{{ asset('js/ratings.js') }}"></script>
</body>
</html>