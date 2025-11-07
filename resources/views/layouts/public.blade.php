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
        
        <!-- Center - Navigation -->
        <nav class="flex flex-wrap justify-center mb-0 gap-1 sm:gap-2">
            <!-- Home with Logo (Mobile Only) -->
            <a href="{{ route('home') }}" class="px-2 sm:px-3 md:px-3 py-1.5 md:py-2 text-white font-medium text-xs sm:text-sm md:text-base hover:text-green-200 transition-colors duration-200 flex items-center {{ request()->routeIs('home') ? 'text-green-200 border-b-2 border-green-200' : '' }}">
                <img src="{{ asset('pagsurongfaviconlogo.png') }}" alt="Logo" class="w-5 h-5 sm:w-6 sm:h-6 mr-1 sm:mr-1.5 md:hidden">
                <span>Home</span>
            </a>
            <a href="{{ route('public.products') }}" class="px-2 sm:px-3 md:px-3 py-1.5 md:py-2 text-white font-medium text-xs sm:text-sm md:text-base hover:text-green-200 transition-colors duration-200 {{ request()->routeIs('public.products') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Products</a>
            <a href="{{ route('public.shops') }}" class="px-2 sm:px-3 md:px-3 py-1.5 md:py-2 text-white font-medium text-xs sm:text-sm md:text-base hover:text-green-200 transition-colors duration-200 {{ request()->routeIs('public.shops*') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Shops</a>
            <a href="{{ route('public.hotels') }}" class="px-2 sm:px-3 md:px-3 py-1.5 md:py-2 text-white font-medium text-xs sm:text-sm md:text-base hover:text-green-200 transition-colors duration-200 {{ request()->routeIs('public.hotels*') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Hotels</a>
            <a href="{{ route('public.resorts') }}" class="px-2 sm:px-3 md:px-3 py-1.5 md:py-2 text-white font-medium text-xs sm:text-sm md:text-base hover:text-green-200 transition-colors duration-200 {{ request()->routeIs('public.resorts*') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Resorts</a>
            <a href="{{ route('public.attractions') }}" class="px-2 sm:px-3 md:px-3 py-1.5 md:py-2 text-white font-medium text-xs sm:text-sm md:text-base hover:text-green-200 transition-colors duration-200 {{ request()->routeIs('public.attractions*') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Attractions</a>
            @auth
                @php
                    $user = auth()->user();
                @endphp
                @if($user->role === 'customer')
                    <a href="{{ route('customer.dashboard') }}" class="mx-2 md:mx-3 my-1 md:my-0 text-white font-medium text-sm md:text-base hover:text-green-200 transition-colors duration-200">Dashboard</a>
                @elseif($user->role === 'business_owner')
                    <a href="{{ route('dashboard') }}" class="mx-2 md:mx-3 my-1 md:my-0 text-white font-medium text-sm md:text-base hover:text-green-200 transition-colors duration-200">Business Dashboard</a>
                @elseif($user->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="mx-2 md:mx-3 my-1 md:my-0 text-white font-medium text-sm md:text-base hover:text-green-200 transition-colors duration-200">Admin Dashboard</a>
                @endif
                <a href="#" onclick="logoutUser(event)" class="mx-2 md:mx-3 my-1 md:my-0 text-white font-medium text-sm md:text-base hover:text-green-200">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            @endauth
        </nav>
        
        <!-- Right Side - Government Logos (Hidden on Mobile) -->
        <div class="hidden md:flex items-center space-x-2">
            <img src="{{ asset('Municipal Seal of Lagonoy.png') }}" alt="Municipal Seal of Lagonoy" class="w-10 h-10 object-cover rounded-full border-2 border-white drop-shadow-sm">
            <img src="{{ asset('bagong-pilipinas-logo.png') }}" alt="Bagong Pilipinas Logo" class="w-10 h-10 object-contain drop-shadow-sm">
            <img src="{{ asset('Provincial Logo of Camarines Sur.png') }}" alt="Provincial Logo of Camarines Sur" class="w-10 h-10 object-cover rounded-full border-2 border-white drop-shadow-sm">
            <img src="{{ asset('Department of Tourism (DOT) Philippines Logo.png') }}" alt="Department of Tourism Philippines" class="w-10 h-10 object-cover rounded-full border-2 border-white drop-shadow-sm">
        </div>
    </header>

    <!-- Search Bar (Below Navigation) -->
    <div class="fixed top-16 md:top-20 left-0 right-0 z-40 bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-4xl mx-auto px-3 sm:px-4 lg:px-6 py-2">
            <div class="flex items-center justify-center gap-2">
                <!-- Search Input -->
                <div class="relative w-full max-w-xl">
                    <input type="text" 
                           id="searchInput" 
                           placeholder="Search..." 
                           class="w-full pl-9 pr-9 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm"
                           autocomplete="off">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs"></i>
                    <button id="clearSearch" class="hidden absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
                
                <!-- Search Button -->
                <button id="searchButton" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-full transition-colors text-sm font-medium whitespace-nowrap">
                    <i class="fas fa-search text-xs sm:mr-1.5"></i>
                    <span class="hidden sm:inline">Search</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="pt-[6.5rem] md:pt-[7.5rem]">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-white py-12" style="background-color: #064e3b;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('pagsurongfaviconlogo.png') }}" alt="Pagsurong Lagonoy Logo" class="w-10 h-auto mr-3">
                        <div class="font-playfair text-xl font-bold">Pagsurong Lagonoy</div>
                    </div>
                    <p class="text-green-100 mb-4">
                        Discover the beauty and culture of Lagonoy through our local businesses, attractions, and warm hospitality.
                    </p>
                    
                    <!-- Government Logos (Visible on Mobile, moved from header) -->
                    <div class="flex md:hidden items-center space-x-3 mt-6">
                        <img src="{{ asset('Municipal Seal of Lagonoy.png') }}" alt="Municipal Seal of Lagonoy" class="w-10 h-10 object-cover rounded-full border-2 border-white drop-shadow-sm">
                        <img src="{{ asset('bagong-pilipinas-logo.png') }}" alt="Bagong Pilipinas Logo" class="w-10 h-10 object-contain drop-shadow-sm">
                        <img src="{{ asset('Provincial Logo of Camarines Sur.png') }}" alt="Provincial Logo of Camarines Sur" class="w-10 h-10 object-cover rounded-full border-2 border-white drop-shadow-sm">
                        <img src="{{ asset('Department of Tourism (DOT) Philippines Logo.png') }}" alt="Department of Tourism Philippines" class="w-10 h-10 object-cover rounded-full border-2 border-white drop-shadow-sm">
                    </div>
                </div>
                
                <div>
                    <h3 class="font-semibold text-lg mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}#about" class="text-green-100 hover:text-white transition-colors">About Us</a></li>
                        <li><a href="{{ route('home') }}#contact" class="text-green-100 hover:text-white transition-colors">Contact Us</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-semibold text-lg mb-4">Contact Info</h3>
                    <ul class="space-y-2 text-green-100">
                        <li><i class="fas fa-phone mr-2"></i> +63 123 456 7890</li>
                        <li><i class="fas fa-envelope mr-2"></i> info@pagsuronglagonoy.com</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i> Lagonoy, Camarines Sur</li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-green-700 mt-8 pt-8 text-center text-green-100">
                <p>&copy; {{ $currentYear }} Pagsurong Lagonoy. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
    @yield('scripts')

    <!-- Login Modal -->
    <div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-md w-full p-6 relative my-8">
                <button onclick="closeLoginModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
                
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Welcome Back</h2>
                    <p class="text-gray-600">Sign in to your account</p>
                </div>

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="login_email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" 
                                   id="login_email" 
                                   name="email" 
                                   required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   placeholder="Enter your email">
                        </div>

                        <div>
                            <label for="login_password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <div class="relative">
                                <input type="password" 
                                       id="login_password" 
                                       name="password" 
                                       required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent pr-10"
                                       placeholder="Enter your password">
                                <button type="button" 
                                        onclick="togglePasswordVisibility('login_password')" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="login_password_icon"></i>
                                </button>
                            </div>
                        </div>


                        <button type="submit" 
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                            Sign In
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Don't have an account? 
                        <button onclick="switchToRegister()" class="text-green-600 hover:text-green-500 font-medium">
                            Sign up
                        </button>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div id="registerModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 overflow-y-auto">
        <div class="flex items-start justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-md w-full p-6 relative my-8 max-h-screen overflow-y-auto">
                <button onclick="closeRegisterModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
                
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Create Account</h2>
                    <p class="text-gray-600">Join Pagsurong Lagonoy today</p>
                </div>

                <form method="POST" action="{{ route('register.post') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="register_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" 
                                   id="register_name" 
                                   name="name" 
                                   required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   placeholder="Enter your full name">
                        </div>

                        <div>
                            <label for="register_email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" 
                                   id="register_email" 
                                   name="email" 
                                   required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   placeholder="Enter your email">
                        </div>

                        <div>
                            <label for="register_password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <div class="relative">
                                <input type="password" 
                                       id="register_password" 
                                       name="password" 
                                       required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent pr-10"
                                       placeholder="Create a password">
                                <button type="button" 
                                        onclick="togglePasswordVisibility('register_password')" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="register_password_icon"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label for="register_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                            <div class="relative">
                                <input type="password" 
                                       id="register_password_confirmation" 
                                       name="password_confirmation" 
                                       required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent pr-10"
                                       placeholder="Confirm your password">
                                <button type="button" 
                                        onclick="togglePasswordVisibility('register_password_confirmation')" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="register_password_confirmation_icon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Account Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Account Type</label>
                            <div class="grid grid-cols-1 gap-3">
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="role" value="customer" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300" required>
                                    <span class="ml-2 block text-sm text-gray-700">Customer - Browse and buy products</span>
                                </label>
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="role" value="business_owner" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300" required>
                                    <span class="ml-2 block text-sm text-gray-700">Business Owner - Sell products/services</span>
                                </label>
                            </div>
                        </div>

                        <!-- Business Type (shown only when Business Owner is selected) -->
                        <div id="businessTypeSection" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Business Type</label>
                            <div class="grid grid-cols-1 gap-2">
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="business_type" value="local_products" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                    <span class="ml-2 block text-sm text-gray-700">Local Products Shop</span>
                                </label>
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="business_type" value="hotel" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                    <span class="ml-2 block text-sm text-gray-700">Hotel</span>
                                </label>
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="business_type" value="resort" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                    <span class="ml-2 block text-sm text-gray-700">Resort</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="register_terms" 
                                   name="terms" 
                                   required 
                                   class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                            <label for="register_terms" class="ml-2 text-sm text-gray-600">
                                I agree to the <a href="{{ route('terms') }}" target="_blank" class="text-green-600 hover:text-green-500">Terms and Conditions</a>
                            </label>
                        </div>

                        <button type="submit" 
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                            Create Account
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Already have an account? 
                        <button onclick="switchToLogin()" class="text-green-600 hover:text-green-500 font-medium">
                            Sign in
                        </button>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Set auth status for JavaScript
        @auth
            const authUser = true;
        @else
            const authUser = false;
        @endauth

        // Authentication prompt functions
        function requireAuth(action, message) {
            if (typeof authUser === 'undefined' || !authUser) {
                showAuthPrompt(action, message);
                return false;
            }
            return true;
        }

        function showAuthPrompt(action, message) {
            const promptMessage = message || `Please login or register to ${action}.`;
            
            const authPromptHtml = `
                <div id="authPromptModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
                    <div class="flex items-center justify-center min-h-screen p-4">
                        <div class="bg-white rounded-lg max-w-md w-full p-6 relative my-8">
                            <button onclick="closeAuthPrompt()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                            
                            <div class="text-center mb-6">
                                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                                    <i class="fas fa-user-plus text-green-600 text-xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Authentication Required</h3>
                                <p class="text-sm text-gray-600">${promptMessage}</p>
                            </div>

                            <div class="flex space-x-3">
                                <button onclick="closeAuthPrompt(); openLoginModal();" 
                                        class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                                    Login
                                </button>
                                <button onclick="closeAuthPrompt(); openRegisterModal();" 
                                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                                    Register
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            const existingPrompt = document.getElementById('authPromptModal');
            if (existingPrompt) {
                existingPrompt.remove();
            }
            
            document.body.insertAdjacentHTML('beforeend', authPromptHtml);
            document.body.style.overflow = 'hidden';
        }

        function closeAuthPrompt() {
            const authPrompt = document.getElementById('authPromptModal');
            if (authPrompt) {
                authPrompt.remove();
                document.body.style.overflow = 'auto';
            }
        }

        // Public action handlers
        function handleAddToCart(productId, productName) {
            if (!requireAuth('add items to cart', `Please login or register to add "${productName}" to your cart.`)) {
                return false;
            }
            return true;
        }

        function handleLike(itemType, itemName) {
            if (!requireAuth('like items', `Please login or register to like "${itemName}".`)) {
                return false;
            }
            return true;
        }

        function handleComment(itemType, itemName) {
            if (!requireAuth('leave comments', `Please login or register to comment on "${itemName}".`)) {
                return false;
            }
            return true;
        }

        function handleBooking(itemType, itemName) {
            if (!requireAuth('make bookings', `Please login or register to book "${itemName}".`)) {
                return false;
            }
            return true;
        }

        // Modal Functions
        function openLoginModal() {
            document.getElementById('loginModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeLoginModal() {
            document.getElementById('loginModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function openRegisterModal() {
            document.getElementById('registerModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeRegisterModal() {
            document.getElementById('registerModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function switchToRegister() {
            closeLoginModal();
            openRegisterModal();
        }

        function switchToLogin() {
            closeRegisterModal();
            openLoginModal();
        }

        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(inputId + '_icon');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Password Strength Checker for Modal
        function checkPasswordStrengthModal() {
            const password = document.getElementById('register_password').value;
            const strengthIndicator = document.getElementById('modal-password-strength');
            const strengthBar = document.getElementById('modal-strength-bar');
            const strengthText = document.getElementById('modal-strength-text');
            const strengthRequirements = document.getElementById('modal-strength-requirements');

            if (password.length === 0) {
                strengthIndicator.classList.add('hidden');
                return;
            }

            strengthIndicator.classList.remove('hidden');

            let strength = 0;
            let feedback = [];

            // Check password length
            if (password.length >= 8) {
                strength += 25;
            } else {
                feedback.push('at least 8 characters');
            }

            // Check for lowercase letters
            if (/[a-z]/.test(password)) {
                strength += 25;
            } else {
                feedback.push('lowercase letters');
            }

            // Check for uppercase letters
            if (/[A-Z]/.test(password)) {
                strength += 25;
            } else {
                feedback.push('uppercase letters');
            }

            // Check for numbers or special characters
            if (/[0-9]/.test(password) || /[^A-Za-z0-9]/.test(password)) {
                strength += 25;
            } else {
                feedback.push('numbers or symbols');
            }

            // Ensure minimum width for visibility
            const displayWidth = Math.max(strength, 15);
            strengthBar.style.width = displayWidth + '%';

            if (strength === 0) {
                strengthBar.className = 'h-full transition-all duration-300 bg-red-600';
                strengthText.className = 'text-xs font-medium text-red-600';
                strengthText.innerHTML = '<i class="fas fa-times-circle mr-1"></i>Very Weak';
                strengthRequirements.innerHTML = '<i class="fas fa-exclamation-triangle mr-1"></i>Add: ' + feedback.join(', ');
            } else if (strength <= 25) {
                strengthBar.className = 'h-full transition-all duration-300 bg-red-500';
                strengthText.className = 'text-xs font-medium text-red-600';
                strengthText.innerHTML = '<i class="fas fa-times-circle mr-1"></i>Weak';
                strengthRequirements.innerHTML = '<i class="fas fa-info-circle mr-1"></i>Add: ' + feedback.join(', ');
            } else if (strength <= 50) {
                strengthBar.className = 'h-full transition-all duration-300 bg-orange-500';
                strengthText.className = 'text-xs font-medium text-orange-600';
                strengthText.innerHTML = '<i class="fas fa-exclamation-circle mr-1"></i>Fair';
                strengthRequirements.innerHTML = '<i class="fas fa-info-circle mr-1"></i>Add: ' + feedback.join(', ');
            } else if (strength <= 75) {
                strengthBar.className = 'h-full transition-all duration-300 bg-yellow-500';
                strengthText.className = 'text-xs font-medium text-yellow-600';
                strengthText.innerHTML = '<i class="fas fa-check-circle mr-1"></i>Good';
                if (feedback.length > 0) {
                    strengthRequirements.innerHTML = '<i class="fas fa-lightbulb mr-1"></i>Suggestion: Add ' + feedback.join(', ');
                } else {
                    strengthRequirements.innerHTML = '<i class="fas fa-thumbs-up mr-1"></i>Good password!';
                }
            } else {
                strengthBar.className = 'h-full transition-all duration-300 bg-green-600';
                strengthText.className = 'text-xs font-medium text-green-600';
                strengthText.innerHTML = '<i class="fas fa-check-circle mr-1"></i>Strong';
                strengthRequirements.innerHTML = '<i class="fas fa-shield-alt mr-1"></i>Excellent! Your password is strong.';
            }
        }

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

        // Close modals when clicking outside
        document.addEventListener('DOMContentLoaded', function() {
            const loginModal = document.getElementById('loginModal');
            const registerModal = document.getElementById('registerModal');

            if (loginModal) {
                loginModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeLoginModal();
                    }
                });
            }

            if (registerModal) {
                registerModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeRegisterModal();
                    }
                });
            }

            // Business type section toggle
            const roleInputs = document.querySelectorAll('input[name="role"]');
            const businessTypeSection = document.getElementById('businessTypeSection');
            const businessTypeInputs = document.querySelectorAll('input[name="business_type"]');

            function toggleBusinessSection() {
                const isBusinessOwner = document.querySelector('input[name="role"]:checked')?.value === 'business_owner';
                
                if (businessTypeSection) {
                    if (isBusinessOwner) {
                        businessTypeSection.classList.remove('hidden');
                        businessTypeInputs.forEach(input => input.required = true);
                    } else {
                        businessTypeSection.classList.add('hidden');
                        businessTypeInputs.forEach(input => {
                            input.required = false;
                            input.checked = false;
                        });
                    }
                }
            }

            roleInputs.forEach(input => {
                input.addEventListener('change', toggleBusinessSection);
            });

            toggleBusinessSection();
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLoginModal();
                closeRegisterModal();
                closeAuthPrompt();
                closeLogoutModal();
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

<!-- Search Results Modal -->
<div id="searchModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 overflow-y-auto">
    <div class="flex items-start justify-center min-h-screen p-4 pt-20">
        <div class="bg-white rounded-lg w-full md:max-w-2xl lg:max-w-3xl relative my-8 max-h-[80vh] overflow-hidden flex flex-col">
            <!-- Modal Header -->
            <div class="p-4 md:p-6 border-b border-gray-200 flex items-center justify-between sticky top-0 bg-white z-10">
                <div class="flex-1">
                    <h3 class="text-lg md:text-xl font-bold text-gray-900">Search Results</h3>
                    <p id="searchResultsCount" class="text-sm text-gray-600 mt-1"></p>
                </div>
                <button onclick="closeSearchModal()" class="text-gray-400 hover:text-gray-600 ml-4">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <!-- Loading State -->
            <div id="searchLoading" class="hidden p-8 text-center">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-green-600"></div>
                <p class="mt-4 text-gray-600">Searching...</p>
            </div>

            <!-- Results Container -->
            <div id="searchResultsContainer" class="flex-1 overflow-y-auto p-4 md:p-6">
                <!-- Results will be inserted here -->
            </div>

            <!-- Empty State -->
            <div id="searchEmpty" class="hidden p-8 text-center">
                <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-search text-gray-400 text-3xl"></i>
                </div>
                <p class="text-gray-600 text-lg mb-2">No results found</p>
                <p class="text-gray-500 text-sm">Try adjusting your search terms or category filter</p>
            </div>
        </div>
    </div>
</div>

<!-- Search JavaScript -->
<script>
    let searchTimeout = null;

    function performSearch() {
        const query = document.getElementById('searchInput').value.trim();
        const category = 'all';

        if (query.length < 2) {
            alert('Please enter at least 2 characters to search');
            return;
        }

        // Show modal and loading state
        document.getElementById('searchModal').classList.remove('hidden');
        document.getElementById('searchLoading').classList.remove('hidden');
        document.getElementById('searchResultsContainer').classList.add('hidden');
        document.getElementById('searchEmpty').classList.add('hidden');
        document.body.style.overflow = 'hidden';

        // Construct URL
        const searchUrl = `/search?q=${encodeURIComponent(query)}&category=${category}`;
        console.log('Searching:', searchUrl);

        // Perform search
        fetch(searchUrl, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    return response.text().then(text => {
                        throw new Error(`HTTP ${response.status}: ${text.substring(0, 100)}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Search results:', data);
                document.getElementById('searchLoading').classList.add('hidden');
                
                if (!data.success) {
                    throw new Error(data.message || 'Search failed');
                }
                
                if (data.total === 0) {
                    document.getElementById('searchEmpty').classList.remove('hidden');
                    document.getElementById('searchResultsCount').textContent = 'No results found';
                } else {
                    document.getElementById('searchResultsContainer').classList.remove('hidden');
                    displaySearchResults(data);
                    document.getElementById('searchResultsCount').textContent = 
                        `Found ${data.total} result${data.total !== 1 ? 's' : ''} for "${data.query}"`;
                }
            })
            .catch(error => {
                console.error('Search error:', error);
                document.getElementById('searchLoading').classList.add('hidden');
                document.getElementById('searchResultsContainer').classList.remove('hidden');
                const container = document.getElementById('searchResultsContainer');
                container.innerHTML = `
                    <div class="text-center py-8">
                        <div class="w-20 h-20 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-red-500 text-3xl"></i>
                        </div>
                        <p class="text-gray-900 text-lg mb-2">Search Error</p>
                        <p class="text-gray-600 text-sm mb-4">Unable to perform search. Please try again.</p>
                        <p class="text-gray-500 text-xs break-all px-4">${error.message}</p>
                    </div>
                `;
                document.getElementById('searchResultsCount').textContent = 'Search error occurred';
            });
    }

    function displaySearchResults(data) {
        const container = document.getElementById('searchResultsContainer');
        container.innerHTML = '';

        // Display Products
        if (data.results.products && data.results.products.length > 0) {
            container.innerHTML += createResultSection('Products', data.results.products, 'product');
        }

        // Display Shops
        if (data.results.shops && data.results.shops.length > 0) {
            container.innerHTML += createResultSection('Shops', data.results.shops, 'shop');
        }

        // Display Hotels
        if (data.results.hotels && data.results.hotels.length > 0) {
            container.innerHTML += createResultSection('Hotels', data.results.hotels, 'hotel');
        }

        // Display Resorts
        if (data.results.resorts && data.results.resorts.length > 0) {
            container.innerHTML += createResultSection('Resorts', data.results.resorts, 'resort');
        }

        // Display Attractions
        if (data.results.attractions && data.results.attractions.length > 0) {
            container.innerHTML += createResultSection('Attractions', data.results.attractions, 'attraction');
        }
    }

    function createResultSection(title, items, type) {
        let html = `
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                    <i class="fas fa-${getIconForType(type)} text-green-600 mr-2"></i>
                    ${title}
                    <span class="ml-2 text-sm font-normal text-gray-500">(${items.length})</span>
                </h4>
                <div class="grid grid-cols-1 gap-4">
        `;

        items.forEach(item => {
            html += createResultCard(item, type);
        });

        html += `
                </div>
            </div>
        `;

        return html;
    }

    function createResultCard(item, type) {
        const imageUrl = item.image || '{{ asset("placeholder.png") }}';
        const priceHtml = item.price ? `<p class="text-green-600 font-semibold text-lg">₱${parseFloat(item.price).toFixed(2)}</p>` : '';
        const businessNameHtml = item.business_name ? `<p class="text-xs text-gray-500 mt-1"><i class="fas fa-store mr-1"></i>${item.business_name}</p>` : '';
        const addressHtml = item.address ? `<p class="text-xs text-gray-500 mt-1"><i class="fas fa-map-marker-alt mr-1"></i>${item.address}</p>` : '';
        const locationHtml = item.location ? `<p class="text-xs text-gray-500 mt-1"><i class="fas fa-map-marker-alt mr-1"></i>${item.location}</p>` : '';
        const starRatingHtml = item.star_rating ? `<p class="text-xs text-yellow-500 mt-1"><i class="fas fa-star mr-1"></i>${item.star_rating} Star</p>` : '';
        const entranceFeeHtml = item.entrance_fee ? `<p class="text-xs text-green-600 mt-1"><i class="fas fa-ticket-alt mr-1"></i>₱${parseFloat(item.entrance_fee).toFixed(2)}</p>` : '';

        return `
            <a href="${item.url}" class="block bg-white border border-gray-200 rounded-lg hover:shadow-lg transition-shadow overflow-hidden">
                <div class="flex">
                    <div class="w-24 h-24 md:w-32 md:h-32 flex-shrink-0">
                        <img src="${imageUrl}" alt="${item.name}" class="w-full h-full object-cover" onerror="this.src='{{ asset("placeholder.png") }}'">
                    </div>
                    <div class="flex-1 p-3 md:p-4 min-w-0">
                        <h5 class="font-semibold text-gray-900 text-sm md:text-base truncate">${item.name}</h5>
                        <p class="text-xs md:text-sm text-gray-600 mt-1 line-clamp-2">${item.description || ''}</p>
                        ${priceHtml}
                        ${businessNameHtml}
                        ${addressHtml}
                        ${locationHtml}
                        ${starRatingHtml}
                        ${entranceFeeHtml}
                    </div>
                </div>
            </a>
        `;
    }

    function getIconForType(type) {
        const icons = {
            'product': 'shopping-bag',
            'shop': 'store',
            'hotel': 'hotel',
            'resort': 'umbrella-beach',
            'attraction': 'map-marked-alt'
        };
        return icons[type] || 'circle';
    }

    function closeSearchModal() {
        document.getElementById('searchModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Event Listeners
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        const clearButton = document.getElementById('clearSearch');
        const searchModal = document.getElementById('searchModal');

        // Search on button click
        searchButton.addEventListener('click', performSearch);

        // Search on Enter key
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });

        // Show/hide clear button
        searchInput.addEventListener('input', function() {
            if (this.value.length > 0) {
                clearButton.classList.remove('hidden');
            } else {
                clearButton.classList.add('hidden');
            }
        });

        // Clear search
        clearButton.addEventListener('click', function() {
            searchInput.value = '';
            clearButton.classList.add('hidden');
            searchInput.focus();
        });

        // Close modal on outside click
        if (searchModal) {
            searchModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeSearchModal();
                }
            });
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSearchModal();
            }
        });
    });
</script>

</body>
</html>
