<?php $currentYear = date("Y"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pagsurong Lagonoy')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">
    
    <!-- Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'playfair': ['Playfair Display', 'serif'],
                        'roboto': ['Roboto', 'sans-serif']
                    }
                }
            }
        }
    </script>
    
    <!-- Custom Styles -->
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }
        
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="font-roboto text-gray-800 leading-relaxed">

    <!-- Fixed Header -->
    <header class="py-2 md:py-4 px-2 sm:px-3 md:px-10 flex flex-col md:flex-row justify-between items-center shadow-sm fixed top-0 left-0 right-0 z-50 text-white" style="background-color: #064e3b;">
        <!-- Left Side - Main Branding (Hidden on Mobile) -->
        <div class="hidden md:flex items-center">
            <img src="{{ asset('logo.png') }}" alt="Pagsurong Lagonoy Logo" class="w-12 h-auto mr-3">
            <div class="font-playfair text-2xl font-bold text-white">Pagsurong Lagonoy</div>
        </div>
        
        <!-- Center - Navigation -->
        <nav class="flex flex-wrap justify-center mb-0 gap-1 sm:gap-2">
            <!-- Home with Logo (Mobile Only) -->
            <a href="{{ route('home') }}" class="px-2 sm:px-3 md:px-3 py-1.5 md:py-2 text-white font-medium text-xs sm:text-sm md:text-base hover:text-green-200 transition-colors duration-200 flex items-center {{ request()->routeIs('home') ? 'text-green-200 border-b-2 border-green-200' : '' }}">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="w-5 h-5 sm:w-6 sm:h-6 mr-1 sm:mr-1.5 md:hidden">
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

    <!-- HOME SECTION -->
    <section id="home" class="pt-12 md:pt-16">
        <!-- Hero Banner with Split Layout -->
        <div class="relative h-[70vh] min-h-[500px] flex">
            <!-- Combined Background with Seamless Green to Plaza Transition -->
            <div class="w-full h-full absolute inset-0" style="background: linear-gradient(to right, #064e3b 0%, #15803d 40%, rgba(21, 128, 61, 0.8) 47%, rgba(21, 128, 61, 0.4) 50%, rgba(21, 128, 61, 0.2) 53%, transparent 60%), url('plaza1.jpg'); background-size: cover; background-position: center; background-blend-mode: normal;"></div>
            
            <!-- Left Side - Text Content -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center items-start px-8 lg:px-16 relative z-10">
                <div class="max-w-2xl">
                    <h1 class="font-playfair text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold mb-6 text-white leading-tight">
                        Lagonoy Products, Hotels, Resorts and Tourist Spots
                    </h1>
                    <p class="text-lg md:text-xl lg:text-2xl text-green-100 mb-8 font-light">
                        Local Finds, Unforgettable Memories!
                    </p>
                    <div class="flex flex-wrap gap-4 mt-8">
                        @guest
                            <button onclick="openRegisterModal()" class="inline-block px-6 lg:px-8 py-3 rounded-full bg-green-600 text-white font-medium text-base lg:text-lg hover:bg-green-700 transform hover:-translate-y-1 transition-all duration-300 shadow-lg">Register</button>
                            <button onclick="openLoginModal()" class="inline-block px-6 lg:px-8 py-3 rounded-full border-2 border-white text-white bg-transparent font-medium text-base lg:text-lg hover:bg-white hover:text-green-700 transform hover:-translate-y-1 transition-all duration-300">Login</button>
                        @else
                            <a href="{{ route('dashboard') }}" class="inline-block px-6 lg:px-8 py-3 rounded-full bg-green-600 text-white font-medium text-base lg:text-lg hover:bg-green-700 transform hover:-translate-y-1 transition-all duration-300 shadow-lg">Go to Dashboard</a>
                        @endguest
                    </div>
                </div>
            </div>

            <!-- Right Side - Transparent overlay for content if needed -->
            <div class="hidden lg:block w-1/2 relative z-10">
                <!-- This space is now part of the merged background -->
            </div>

            <!-- Mobile Background for smaller screens -->
            <div class="lg:hidden absolute inset-0 bg-cover bg-center opacity-20" style="background-image: url('plaza1.jpg');"></div>
        </div>
    </section>

    <!-- ABOUT SECTION -->
    <section id="about" class="py-20" style="background-color: #064e3b;">
        <div class="text-center py-20 px-4 fade-in">
            <h1 class="font-playfair text-4xl md:text-5xl font-bold mb-5 text-white leading-tight">About Pagsurong Lagonoy</h1>
            <p class="text-xl text-green-100 font-light">Connecting you to the best of Lagonoy</p>
        </div>

        <div class="max-w-6xl mx-auto px-5 fade-in">
            <h2 class="text-2xl font-bold mb-4 text-white">Our Platform</h2>
            <p class="mb-12 text-green-100">Pagsurong Lagonoy is a comprehensive web platform designed to showcase and promote local products, resorts, and hotels in Lagonoy, Camarines Sur. We bridge the gap between local businesses and consumers by providing a centralized marketplace for unique local offerings.</p>

            <h2 class="text-2xl font-bold mb-6 text-white">The Development Team</h2>
            <div class="flex flex-wrap justify-around mb-12">
                <div class="basis-full md:basis-[30%] bg-white border border-gray-200 rounded-lg p-5 text-center shadow-sm mb-6 md:mb-0 hover:translate-y-[-5px] transition-transform">
                    <img src="{{ asset('images/john-vincent.jpg') }}" alt="John Vincent L. Villarin" class="w-32 h-32 rounded-full object-cover mx-auto mb-4">
                    <h3 class="text-xl font-bold mb-1">John Vincent L. Villarin</h3>
                    <p class="text-green-600 mb-2">Lead Developer</p>
                    <p class="text-gray-600 text-sm">jvloriaga572.pbox@parsu.edu.ph</p>
                </div>
                <div class="basis-full md:basis-[30%] bg-white border border-gray-200 rounded-lg p-5 text-center shadow-sm mb-6 md:mb-0 hover:translate-y-[-5px] transition-transform">
                    <img src="{{ asset('images/ranel.jpg') }}" alt="Ranel D. Carulla" class="w-32 h-32 rounded-full object-cover mx-auto mb-4">
                    <h3 class="text-xl font-bold mb-1">Ranel D. Carulla</h3>
                    <p class="text-green-600 mb-2">Lead Data Manager</p>
                    <p class="text-gray-600 text-sm">rdcarulla507.pbox@parsu.edu.ph</p>
                </div>
                <div class="basis-full md:basis-[30%] bg-white border border-gray-200 rounded-lg p-5 text-center shadow-sm hover:translate-y-[-5px] transition-transform">
                    <img src="{{ asset('images/jason.jpg') }}" alt="Jason P. Villareal" class="w-32 h-32 rounded-full object-cover mx-auto mb-4">
                    <h3 class="text-xl font-bold mb-1">Jason P. Villareal</h3>
                    <p class="text-green-600 mb-2">Lead Documenter</p>
                    <p class="text-gray-600 text-sm">jpvillareal571.pbox@parsu.edu.ph</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACT SECTION -->
    <section id="contact" class="py-20" style="background-color: #15803d;">
        <div class="text-center py-12 sm:py-16 md:py-20 px-4 fade-in">
            <h1 class="font-playfair text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold mb-3 sm:mb-5 text-white leading-tight">Get In Touch</h1>
            <p class="text-base sm:text-lg md:text-xl text-green-100 font-light">We'd love to hear from you</p>
        </div>

        <div class="max-w-6xl mx-auto px-5 text-center fade-in">
            <div class="flex flex-wrap justify-center gap-8">
                <div class="flex-1 min-w-[250px] bg-white p-6 rounded-lg shadow-sm hover:translate-y-[-5px] transition-transform">
                    <div class="text-4xl mb-4 text-green-600">📞</div>
                    <h3 class="text-xl font-bold mb-3">Phone</h3>
                    <p class="text-gray-600">+63 123 456 7890</p>
                    <p class="text-gray-600">+63 987 654 3210</p>
                </div>
                
                <div class="flex-1 min-w-[250px] bg-white p-6 rounded-lg shadow-sm hover:translate-y-[-5px] transition-transform">
                    <div class="text-4xl mb-4 text-green-600">📧</div>
                    <h3 class="text-xl font-bold mb-3">Email</h3>
                    <p class="text-gray-600">info@pagsuronglagonoy.com</p>
                    <p class="text-gray-600">support@pagsuronglagonoy.com</p>
                </div>
            </div>
            
            <!-- Updated Map Section with Google Maps Embed -->
            <div class="mt-12 rounded-lg overflow-hidden shadow-md h-80">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3875.761398331468!2d123.51834237411634!3d13.732890497732994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a1c351609944a1%3A0x29fbae3f657b85f7!2sLagonoy%20Municipal%20Hall!5e0!3m2!1sen!2sph!4v1755818544100!5m2!1sen!2sph" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer style="background-color: #064e3b;" class="text-white py-10">
        <div class="max-w-6xl mx-auto px-5">
            <!-- Logo and Description -->
            <div class="flex items-center mb-6">
                <img src="{{ asset('logo.png') }}" alt="Pagsurong Lagonoy Logo" class="w-12 h-auto mr-3">
                <h3 class="text-xl font-playfair font-bold">Pagsurong Lagonoy</h3>
            </div>
            <p class="text-gray-300 mb-6">
                Discover the beauty and culture of Lagonoy through our local businesses, attractions, and warm hospitality.
            </p>
            
            <!-- Government Logos -->
            <div class="flex items-center space-x-4 mb-8">
                <img src="{{ asset('Municipal Seal of Lagonoy.png') }}" alt="Municipal Seal of Lagonoy" class="w-12 h-12 object-cover rounded-full border-2 border-white">
                <img src="{{ asset('bagong-pilipinas-logo.png') }}" alt="Bagong Pilipinas Logo" class="w-12 h-12 object-contain">
                <img src="{{ asset('Provincial Logo of Camarines Sur.png') }}" alt="Provincial Logo of Camarines Sur" class="w-12 h-12 object-cover rounded-full border-2 border-white">
                <img src="{{ asset('Department of Tourism (DOT) Philippines Logo.png') }}" alt="Department of Tourism Philippines" class="w-12 h-12 object-cover rounded-full border-2 border-white">
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <div class="space-y-2">
                        <a href="#" class="block text-gray-300 hover:text-white transition-colors">About Us</a>
                        <a href="#" class="block text-gray-300 hover:text-white transition-colors">Contact Us</a>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact Info</h4>
                    <div class="space-y-2 text-gray-300">
                        <p><i class="fas fa-phone mr-2"></i>+63 123 456 7890</p>
                        <p><i class="fas fa-envelope mr-2"></i>info@pagsuronglagonoy.com</p>
                        <p><i class="fas fa-map-marker-alt mr-2"></i>Lagonoy, Camarines Sur</p>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400 text-sm">
                <p>&copy; {{ $currentYear }} Pagsurong Lagonoy. All rights reserved.</p>
            </div>
        </div>
    </footer>

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

                <form method="POST" action="{{ route('register.post') }}" id="registerForm" onsubmit="return validatePasswordStrength()">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="register_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" 
                                   id="register_name" 
                                   name="name" 
                                   required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   placeholder="e.g., Juan Dela Cruz">
                        </div>

                        <div>
                            <label for="register_email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" 
                                   id="register_email" 
                                   name="email" 
                                   required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   placeholder="e.g., juan@example.com">
                        </div>

                        <div>
                            <label for="register_password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <div class="relative">
                                <input type="password" 
                                       id="register_password" 
                                       name="password" 
                                       required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent pr-10"
                                       placeholder="At least 8 characters with letters & numbers"
                                       oninput="checkModalPasswordStrength()">
                                <button type="button" 
                                        onclick="togglePasswordVisibility('register_password')" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="register_password_icon"></i>
                                </button>
                            </div>
                            
                            <!-- Password Strength Indicator -->
                            <div id="modal-password-strength" class="hidden mt-2">
                                <div class="flex items-center justify-between mb-1">
                                    <span id="modal-strength-text" class="text-xs font-medium"></span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                    <div id="modal-strength-bar" class="h-full transition-all duration-300" style="width: 0%"></div>
                                </div>
                                <p id="modal-strength-requirements" class="text-xs text-gray-600 mt-1"></p>
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
                                       placeholder="Re-enter your password">
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

        // Password visibility toggle
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

        // Close modals when clicking outside
        document.getElementById('loginModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLoginModal();
            }
        });

        document.getElementById('registerModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRegisterModal();
            }
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLoginModal();
                closeRegisterModal();
                closeLogoutModal();
            }
        });

        // Authentication prompt functions for public actions
        function requireAuth(action, message) {
            if (typeof authUser === 'undefined' || !authUser) {
                showAuthPrompt(action, message);
                return false;
            }
            return true;
        }

        function showAuthPrompt(action, message) {
            const promptMessage = message || `Please login or register to ${action}.`;
            
            // Create custom auth prompt modal
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
            
            // Remove existing auth prompt if any
            const existingPrompt = document.getElementById('authPromptModal');
            if (existingPrompt) {
                existingPrompt.remove();
            }
            
            // Add new auth prompt to body
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

        // Public action handlers that require authentication
        function handleAddToCart(productId, productName) {
            if (!requireAuth('add items to cart', `Please login or register to add "${productName}" to your cart.`)) {
                return false;
            }
            // Proceed with add to cart logic
            return true;
        }

        function handleRating(itemType, itemName) {
            if (!requireAuth('rate items', `Please login or register to rate "${itemName}".`)) {
                return false;
            }
            // Proceed with rating logic
            return true;
        }

        function handleComment(itemType, itemName) {
            if (!requireAuth('leave comments', `Please login or register to comment on "${itemName}".`)) {
                return false;
            }
            // Proceed with comment logic
            return true;
        }

        function handleLike(itemType, itemName) {
            if (!requireAuth('like items', `Please login or register to like "${itemName}".`)) {
                return false;
            }
            // Proceed with like logic
            return true;
        }

        function handleBooking(itemType, itemName) {
            if (!requireAuth('make bookings', `Please login or register to book "${itemName}".`)) {
                return false;
            }
            // Proceed with booking logic
            return true;
        }

        // Set auth status for JavaScript
        @auth
            const authUser = true;
        @else
            const authUser = false;
        @endauth

        // Auto-open modals based on URL hash
        document.addEventListener('DOMContentLoaded', function() {
            const hash = window.location.hash;
            if (hash === '#register') {
                openRegisterModal();
            } else if (hash === '#login') {
                openLoginModal();
            }
        });

        // Business type section toggle for registration modal
        document.addEventListener('DOMContentLoaded', function() {
            const roleInputs = document.querySelectorAll('input[name="role"]');
            const businessTypeSection = document.getElementById('businessTypeSection');
            const businessTypeInputs = document.querySelectorAll('input[name="business_type"]');

            function toggleBusinessSection() {
                const isBusinessOwner = document.querySelector('input[name="role"]:checked')?.value === 'business_owner';
                
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

            // Add event listeners to role radio buttons
            roleInputs.forEach(input => {
                input.addEventListener('change', toggleBusinessSection);
            });

            // Initialize the view
            toggleBusinessSection();
        });

        // Global variable to track password strength
        let currentPasswordStrength = 0;

        // Password Strength Checker for Modal
        function checkModalPasswordStrength() {
            const password = document.getElementById('register_password').value;
            const strengthIndicator = document.getElementById('modal-password-strength');
            const strengthBar = document.getElementById('modal-strength-bar');
            const strengthText = document.getElementById('modal-strength-text');
            const strengthRequirements = document.getElementById('modal-strength-requirements');

            if (password.length === 0) {
                strengthIndicator.classList.add('hidden');
                currentPasswordStrength = 0;
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

            // Store current strength
            currentPasswordStrength = strength;

            // Ensure minimum width for visibility
            const displayWidth = Math.max(strength, 15);
            strengthBar.style.width = displayWidth + '%';

            if (strength === 0) {
                strengthBar.className = 'h-full transition-all duration-300 bg-red-600';
                strengthText.className = 'text-xs font-medium text-red-600';
                strengthText.innerHTML = '<i class="fas fa-times-circle mr-1"></i>Very Weak';
                strengthRequirements.innerHTML = '<i class="fas fa-exclamation-triangle mr-1"></i>Password must include: ' + feedback.join(', ');
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

        // Validate password strength before form submission
        function validatePasswordStrength() {
            const password = document.getElementById('register_password').value;
            
            // Check if password is less than 8 characters (weak)
            if (password.length < 8) {
                showNotification('Weak password! Password must be at least 8 characters. Please try again.', 'error');
                return false;
            }
            
            return true;
        }

        // Show notification function
        function showNotification(message, type = 'error') {
            // Remove existing notification if any
            const existingNotification = document.getElementById('notification');
            if (existingNotification) {
                existingNotification.remove();
            }

            // Create notification element
            const notification = document.createElement('div');
            notification.id = 'notification';
            notification.className = `fixed top-4 right-4 z-[60] max-w-md p-4 rounded-lg shadow-lg transform transition-all duration-300 ${
                type === 'error' ? 'bg-red-500' : 'bg-green-500'
            } text-white`;
            
            notification.innerHTML = `
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas ${type === 'error' ? 'fa-exclamation-circle' : 'fa-check-circle'} text-xl"></i>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium">${message}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;

            document.body.appendChild(notification);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.style.opacity = '0';
                    setTimeout(() => notification.remove(), 300);
                }
            }, 5000);
        }
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

</body>
</html>
