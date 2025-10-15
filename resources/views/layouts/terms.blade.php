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
                        'primary': '#1d4ed8', // blue-700
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
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    @stack('styles')
</head>
<body class="font-roboto text-gray-800 leading-relaxed bg-gray-50 antialiased">

    <!-- Header -->
    <header style="background-color: #012844ff;" class="text-white shadow-md fixed w-full top-0 left-0 right-0 z-50">
        <div class="py-3 px-4 md:px-10 flex flex-col md:flex-row justify-between items-center">
            <div class="flex items-center mb-4 md:mb-0">
                <a href="{{ route('home') }}" class="flex items-center hover:opacity-80 transition-opacity">
                    <img src="{{ asset('logo.png') }}" alt="Pagsurong Lagonoy Logo" class="w-12 h-auto mr-3 drop-shadow-sm">
                    <div class="font-playfair text-2xl font-bold">Pagsurong Lagonoy</div>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="flex items-center space-x-6">
                @if(request()->query('from') === 'profile_setup' || request()->query('from') === 'business_setup' || request()->query('from') === 'business_profile' || request()->query('from') === 'business_profile_update')
                    <!-- Registration flow navigation - only Home and Register -->
                    <a href="{{ route('home') }}" class="text-white hover:text-blue-100 transition-all duration-200 relative group">
                        Home
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-400 group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="{{ route('register') }}" class="text-white hover:text-blue-100 transition-all duration-200 relative group">
                        Register
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-400 group-hover:w-full transition-all duration-300"></span>
                    </a>
                @else
                    <!-- Full navigation for regular terms viewing -->
                    <a href="{{ route('home') }}" class="text-white hover:text-blue-100 transition-all duration-200 relative group {{ request()->routeIs('home') ? 'font-semibold' : '' }}">
                        Home
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-400 group-hover:w-full transition-all duration-300 {{ request()->routeIs('home') ? 'w-full' : '' }}"></span>
                    </a>
                    <a href="{{ route('about') }}" class="text-white hover:text-blue-100 transition-all duration-200 relative group {{ request()->routeIs('about') ? 'font-semibold' : '' }}">
                        About Us
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-400 group-hover:w-full transition-all duration-300 {{ request()->routeIs('about') ? 'w-full' : '' }}"></span>
                    </a>
                    <a href="{{ route('contact') }}" class="text-white hover:text-blue-100 transition-all duration-200 relative group {{ request()->routeIs('contact') ? 'font-semibold' : '' }}">
                        Contact
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-400 group-hover:w-full transition-all duration-300 {{ request()->routeIs('contact') ? 'w-full' : '' }}"></span>
                    </a>
                    @auth
                        <a href="{{ route('profile.show') }}" class="text-white hover:text-blue-100 transition-all duration-200 relative group {{ request()->routeIs('profile.show') ? 'font-semibold' : '' }}">
                            My Profile
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-400 group-hover:w-full transition-all duration-300 {{ request()->routeIs('profile.show') ? 'w-full' : '' }}"></span>
                        </a>
                        <a href="#" onclick="confirmLogout()" class="text-white hover:text-blue-100 transition-all duration-200">
                            Logout
                        </a>
                        <form method="POST" action="{{ route('logout') }}" id="logout-form" class="hidden">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-white hover:text-blue-100 transition-all duration-200 relative group">
                            Login
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-400 group-hover:w-full transition-all duration-300"></span>
                        </a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-all duration-200">Register</a>
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <!-- Main content -->
    <div class="pt-20 min-h-screen">
        @yield('content')
    </div>

    <!-- Divider -->
    <div class="border-t border-gray-200 my-10 hidden lg:block"></div>

    <!-- Footer -->
    <footer style="background-color: #012844ff;" class="text-white py-10">
        <div class="max-w-6xl mx-auto px-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-playfair font-bold mb-4">Pagsurong Lagonoy</h3>
                    <p class="text-gray-300">
                        Your gateway to authentic Camarines Sur tourism experiences. Connect with local businesses
                        and discover the beauty of Pagsurong Lagonoy.
                    </p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition-colors duration-200">Home</a></li>
                        <li><a href="{{ route('about') }}" class="text-gray-300 hover:text-white transition-colors duration-200">About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-white transition-colors duration-200">Contact</a></li>
                        <li><a href="{{ route('terms') }}" class="text-gray-300 hover:text-white transition-colors duration-200">Terms & Conditions</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">Help Center</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">FAQ</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">Report Issue</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400 text-sm">
                <p>&copy; {{ $currentYear }} Pagsurong Lagonoy. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Logout Script -->
    <script>
        function confirmLogout() {
            if (confirm('Are you sure you want to logout?')) {
                document.getElementById('logout-form').submit();
            }
        }
    </script>

    @stack('scripts')
</body>
</html>
