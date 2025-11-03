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
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">

    @stack('styles')
</head>
<body class="font-roboto text-gray-800 leading-relaxed bg-gray-50 antialiased">

    <!-- Header -->
    <header style="background-color: #064e3b;" class="text-white shadow-md fixed w-full top-0 left-0 right-0 z-50">
        <div class="py-3 px-4 md:px-10 flex flex-col md:flex-row justify-between items-center">
            <!-- Left Side - Main Branding -->
            <div class="flex items-center mb-4 md:mb-0">
                <a href="{{ route('home') }}" class="flex items-center hover:opacity-80 transition-opacity">
                    <img src="{{ asset('logo.png') }}" alt="Pagsurong Lagonoy Logo" class="w-12 h-auto mr-3 drop-shadow-sm">
                    <div class="font-playfair text-2xl font-bold">Pagsurong Lagonoy</div>
                </a>
            </div>

            
            <!-- Right Side - Government Logos -->
            <div class="flex items-center space-x-2">
                <img src="{{ asset('Municipal Seal of Lagonoy.png') }}" alt="Municipal Seal of Lagonoy" class="w-8 h-8 md:w-10 md:h-10 object-cover rounded-full border-2 border-white drop-shadow-sm">
                <img src="{{ asset('bagong-pilipinas-logo.png') }}" alt="Bagong Pilipinas Logo" class="w-8 h-8 md:w-10 md:h-10 object-contain drop-shadow-sm">
                <img src="{{ asset('Provincial Logo of Camarines Sur.png') }}" alt="Provincial Logo of Camarines Sur" class="w-8 h-8 md:w-10 md:h-10 object-cover rounded-full border-2 border-white drop-shadow-sm">
                <img src="{{ asset('Department of Tourism (DOT) Philippines Logo.png') }}" alt="Department of Tourism Philippines" class="w-8 h-8 md:w-10 md:h-10 object-cover rounded-full border-2 border-white drop-shadow-sm">
            </div>
        </div>
    </header>

    <!-- Main content -->
    <div class="pt-20 min-h-screen">
        @yield('content')
    </div>

    <!-- Divider -->
    <div class="border-t border-gray-200 my-10 hidden lg:block"></div>

    <!-- Footer -->
    <footer style="background-color: #064e3b;" class="text-white py-10">
        <div class="max-w-6xl mx-auto px-5">
            <div class="text-center">
                <h3 class="text-xl font-playfair font-bold mb-4">Pagsurong Lagonoy</h3>
                <p class="text-gray-300 mb-6">
                    Your gateway to authentic Camarines Sur tourism experiences. Connect with local businesses
                    and discover the beauty of Pagsurong Lagonoy.
                </p>
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
