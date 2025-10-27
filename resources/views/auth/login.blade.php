<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Pagsurong Lagonoy</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
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
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login | Pagsurong Lagonoy</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <!-- Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        playfair: ['Playfair Display', 'serif'],
                        roboto: ['Roboto', 'sans-serif'],
                    },
                },
            },
        };
    </script>
</head>
<body class="font-roboto bg-gray-50 min-h-screen flex flex-col">
    <!-- Header -->
    <header style="background-color: #064e3b;" class="py-4 px-4 md:px-10 flex flex-col md:flex-row justify-between items-center shadow-sm relative z-10">
        <!-- Left Side - Main Branding -->
        <div class="flex items-center mb-4 md:mb-0">
            <img src="{{ asset('logo.png') }}" alt="Pagsurong Lagonoy Logo" class="w-12 h-auto mr-3" />
            <div class="font-playfair text-2xl font-bold text-white">Pagsurong Lagonoy</div>
        </div>
        
        <!-- Center - Navigation -->
        <nav class="flex flex-wrap justify-center mb-4 md:mb-0">
            <a href="{{ route('home') }}" class="mx-3 my-1 md:my-0 text-white font-medium text-sm md:text-base hover:text-green-200">Home</a>
            <a href="{{ route('about') }}" class="mx-3 my-1 md:my-0 text-white font-medium text-sm md:text-base hover:text-green-200">About Us</a>
            <a href="{{ route('contact') }}" class="mx-3 my-1 md:my-0 text-white font-medium text-sm md:text-base hover:text-green-200">Contact Us</a>
            @auth
                <a href="{{ route('dashboard') }}" class="mx-3 my-1 md:my-0 text-white font-medium text-sm md:text-base hover:text-green-200">Dashboard</a>
                <a href="#" onclick="logoutUser (event)" class="mx-3 my-1 md:my-0 text-white font-medium text-sm md:text-base hover:text-green-200">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            @endauth
        </nav>
        
        <!-- Right Side - Government Logos -->
        <div class="flex items-center space-x-2">
            <img src="{{ asset('Municipal Seal of Lagonoy.png') }}" alt="Municipal Seal of Lagonoy" class="w-8 h-8 md:w-10 md:h-10 object-cover rounded-full border-2 border-white drop-shadow-sm" />
            <img src="{{ asset('bagong-pilipinas-logo.png') }}" alt="Bagong Pilipinas Logo" class="w-8 h-8 md:w-10 md:h-10 object-contain drop-shadow-sm" />
            <img src="{{ asset('Provincial Logo of Camarines Sur.png') }}" alt="Provincial Logo of Camarines Sur" class="w-8 h-8 md:w-10 md:h-10 object-cover rounded-full border-2 border-white drop-shadow-sm" />
            <img src="{{ asset('Department of Tourism (DOT) Philippines Logo.png') }}" alt="Department of Tourism Philippines" class="w-8 h-8 md:w-10 md:h-10 object-cover rounded-full border-2 border-white drop-shadow-sm" />
        </div>
    </header>

    <!-- Main Content -->
    <div class="flex-1 flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
            <div class="text-center mb-6 sm:mb-8">
                <h1 class="font-playfair text-2xl sm:text-3xl text-gray-800 mb-2">Welcome Back</h1>
                <p class="text-sm sm:text-base text-gray-600">Please login to access your account</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="mb-4 sm:mb-6">
                    <label for="email" class="block text-gray-700 font-medium mb-2 text-left text-sm sm:text-base">Email Address</label>
                    <input
                        id="email"
                        type="email"
                        placeholder="Enter your email address"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        autofocus
                        class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:outline-none transition-all duration-200 text-sm sm:text-base"
                    />
                    @error('email')
                        <p class="text-red-500 text-xs italic mt-2 text-left">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4 sm:mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block text-gray-700 font-medium text-sm sm:text-base">Password</label>
                        <a href="{{ route('password.request') }}" class="text-xs sm:text-sm text-green-600 hover:underline">Forgot Password?</a>
                    </div>
                    <div class="relative">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            placeholder="Enter your password"
                            class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:outline-none transition-all duration-200 pr-12 text-sm sm:text-base"
                            required
                            autocomplete="current-password"
                        />
                        <button type="button" 
                                onclick="togglePasswordVisibility('password')" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-green-600 focus:outline-none">
                            <i id="password-toggle-icon" class="far fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs italic mt-2 text-left">{{ $message }}</p>
                    @enderror
                </div>


                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <div class="flex items-center">
                        <input
                            id="remember"
                            type="checkbox"
                            class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                            name="remember"
                            {{ old('remember') ? 'checked' : '' }}
                        >
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            {{ __('Remember me') }}
                        </label>
                    </div>
                </div>

                <button
                    type="submit"
                    class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-2 sm:py-3 px-4 rounded-md transition-colors duration-300 text-sm sm:text-base"
                >
                    Login
                </button>
            </form>

            <div class="mt-6 text-center text-gray-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-green-500 hover:text-green-700 font-medium">Register here</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer style="background-color: #064e3b;" class="text-white py-10">
        <div class="max-w-6xl mx-auto px-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-xl font-playfair font-bold mb-4">Pagsurong Lagonoy</h3>
                    <p class="text-gray-300">
                        Showcasing the best of Lagonoy's local products, accommodations, and tourist destinations.
                    </p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Connect With Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                    <p class="mt-4 text-gray-300">Email: info@pagsuronglagonoy.com</p>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} Pagsurong Lagonoy. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Role selection removed - users login with their assigned roles

        // Logout function
        function logoutUser(event) {
            event.preventDefault();
            if (confirm('Are you sure you want to logout?')) {
                document.getElementById('logout-form').submit();
            }
        }

        function togglePasswordVisibility(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-toggle-icon') || document.getElementById('password-toggle-icon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>