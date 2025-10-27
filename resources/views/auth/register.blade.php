<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Pagsurong Lagonoy</title>
    
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
</head>
<body class="font-roboto text-gray-800 leading-relaxed">

    <!-- Header -->
    <header style="background-color: #064e3b;" class="py-4 px-4 md:px-10 flex flex-col md:flex-row justify-between items-center shadow-sm relative z-10">
        <!-- Left Side - Main Branding -->
        <div class="flex items-center mb-4 md:mb-0">
            <img src="{{ asset('logo.png') }}" alt="Pagsurong Lagonoy Logo" class="w-12 h-auto mr-3">
            <div class="font-playfair text-2xl font-bold text-white">Pagsurong Lagonoy</div>
        </div>
        
        <!-- Center - Navigation -->
        <nav class="flex flex-wrap justify-center mb-4 md:mb-0">
            <a href="{{ route('home') }}" class="mx-3 my-1 md:my-0 text-white font-medium text-sm md:text-base hover:text-green-200">Home</a>
            <a href="{{ route('about') }}" class="mx-3 my-1 md:my-0 text-white font-medium text-sm md:text-base hover:text-green-200">About Us</a>
            <a href="{{ route('contact') }}" class="mx-3 my-1 md:my-0 text-white font-medium text-sm md:text-base hover:text-green-200">Contact Us</a>
            @auth
                <a href="{{ route('dashboard') }}" class="mx-3 my-1 md:my-0 text-white font-medium text-sm md:text-base hover:text-green-200">Dashboard</a>
                <a href="#" onclick="logoutUser(event)" class="mx-3 my-1 md:my-0 text-white font-medium text-sm md:text-base hover:text-green-200">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            @endauth
        </nav>
        
        <!-- Right Side - Government Logos -->
        <div class="flex items-center space-x-2">
            <img src="{{ asset('Municipal Seal of Lagonoy.png') }}" alt="Municipal Seal of Lagonoy" class="w-8 h-8 md:w-10 md:h-10 object-cover rounded-full border-2 border-white drop-shadow-sm">
            <img src="{{ asset('bagong-pilipinas-logo.png') }}" alt="Bagong Pilipinas Logo" class="w-8 h-8 md:w-10 md:h-10 object-contain drop-shadow-sm">
            <img src="{{ asset('Provincial Logo of Camarines Sur.png') }}" alt="Provincial Logo of Camarines Sur" class="w-8 h-8 md:w-10 md:h-10 object-cover rounded-full border-2 border-white drop-shadow-sm">
            <img src="{{ asset('Department of Tourism (DOT) Philippines Logo.png') }}" alt="Department of Tourism Philippines" class="w-8 h-8 md:w-10 md:h-10 object-cover rounded-full border-2 border-white drop-shadow-sm">
        </div>
    </header>

    <!-- Main Content -->
    <div class="flex items-center justify-center min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-6 bg-white p-6 sm:p-8 rounded-lg shadow-lg">
            <div class="text-center">
                
                <h2 class="mt-4 sm:mt-6 text-2xl sm:text-3xl font-extrabold text-gray-900">Create Your Account</h2>
                <p class="mt-2 text-sm text-gray-600">Or <a href="{{ route('login') }}" class="font-medium text-green-600 hover:text-green-500">sign in to your account</a></p>
            </div>

            @if (session('success'))
                <div class="rounded-md bg-green-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @elseif ($errors->any())
                <div class="rounded-md bg-red-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ $errors->first() }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}" enctype="multipart/form-data" class="mt-8 space-y-6" id="registerPageForm" onsubmit="return validatePagePasswordStrength()">
                @csrf

                <div class="rounded-md shadow-sm -space-y-px">
                    <div class="py-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input id="name" name="name" type="text" required autofocus 
                               class="appearance-none relative block w-full px-3 py-2 sm:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500 placeholder-gray-500 text-gray-900 text-sm sm:text-base"
                               placeholder="e.g., Juan Dela Cruz"
                               value="{{ old('name') }}">
                    </div>

                    <div class="py-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input id="email" name="email" type="email" required 
                               class="appearance-none relative block w-full px-3 py-2 sm:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500 placeholder-gray-500 text-gray-900 text-sm sm:text-base"
                               placeholder="e.g., juan@example.com"
                               value="{{ old('email') }}">
                    </div>

                    <div class="py-2">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="relative">
                            <input id="password" name="password" type="password" required 
                                   class="appearance-none relative block w-full px-3 py-2 sm:py-3 pr-10 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500 placeholder-gray-500 text-gray-900 text-sm sm:text-base"
                                   placeholder="At least 8 characters with letters & numbers"
                                   oninput="checkPasswordStrength()">
                            <button type="button" 
                                    onclick="togglePasswordVisibility('password')" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-green-600 focus:outline-none">
                                <i id="password-toggle-icon" class="far fa-eye"></i>
                            </button>
                        </div>
                        
                        <!-- Password Strength Indicator -->
                        <div id="password-strength" class="hidden mt-2">
                            <div class="flex items-center justify-between mb-1">
                                <span id="strength-text" class="text-xs font-medium"></span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                <div id="strength-bar" class="h-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                            <p id="strength-requirements" class="text-xs text-gray-600 mt-1"></p>
                        </div>
                    </div>

                    <div class="py-2">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <div class="relative">
                            <input id="password_confirmation" name="password_confirmation" type="password" required 
                                   class="appearance-none relative block w-full px-3 py-2 sm:py-3 pr-10 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500 placeholder-gray-500 text-gray-900 text-sm sm:text-base"
                                   placeholder="Re-enter your password">
                            <button type="button" 
                                    onclick="togglePasswordVisibility('password_confirmation')" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-green-600 focus:outline-none">
                                <i id="password_confirmation-toggle-icon" class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Account Type -->
                    <div class="py-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Account Type</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            <label class="flex items-center p-2 sm:p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="role" value="customer" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300" 
                                    {{ old('role') === 'customer' ? 'checked' : '' }}>
                                <span class="ml-2 block text-sm text-gray-700">Customer</span>
                            </label>
                            <label class="flex items-center p-2 sm:p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="role" value="business_owner" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300" 
                                    {{ old('role') === 'business_owner' ? 'checked' : '' }}>
                                <span class="ml-2 block text-sm text-gray-700">Business Owner</span>
                            </label>
                        </div>
                    </div>

                    <!-- Business Type (shown only when Business Owner is selected) -->
                    <div id="businessTypeSection" class="py-2 hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Business Type</label>
                        <div class="grid grid-cols-1 gap-2">
                            <label class="flex items-center p-2 sm:p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="business_type" value="local_products" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300" 
                                    {{ old('business_type') === 'local_products' ? 'checked' : '' }} required>
                                <span class="ml-2 block text-sm text-gray-700">Local Products Shop</span>
                            </label>
                            <label class="flex items-center p-2 sm:p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="business_type" value="hotel" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300"
                                    {{ old('business_type') === 'hotel' ? 'checked' : '' }} required>
                                <span class="ml-2 block text-sm text-gray-700">Hotel</span>
                            </label>
                            <label class="flex items-center p-2 sm:p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="business_type" value="resort" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300"
                                    {{ old('business_type') === 'resort' ? 'checked' : '' }} required>
                                <span class="ml-2 block text-sm text-gray-700">Resort</span>
                            </label>
                        </div>
                        @error('business_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Removed business detail collection during registration; this will be done in setup -->
                </div>

                <!-- Terms and Conditions Checkbox -->
                <div class="py-2">
                    <label class="flex items-start">
                        <input type="checkbox" name="accept_terms" id="accept_terms" required
                               class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded mt-1">
                        <span class="ml-2 text-sm text-gray-700">
                            I agree to the 
                            <button type="button" onclick="openTermsModal(event)" class="text-green-600 hover:text-green-500 font-medium underline">
                                Terms and Conditions
                            </button>
                        </span>
                    </label>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 sm:py-3 px-4 border border-transparent text-sm sm:text-base font-medium rounded-md text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-green-500 group-hover:text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        Register
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center text-sm text-gray-600">
                Already have an account? <a href="{{ route('login') }}" class="font-medium text-green-600 hover:text-green-500">Login here</a>
            </div>
        </div>
    </div>

    <!-- Terms and Conditions Modal -->
    <div id="termsModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 shadow-lg rounded-lg bg-white mb-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 border-b">
                <h3 class="text-2xl font-bold text-gray-900">Terms and Conditions</h3>
                <button type="button" onclick="closeTermsModal()" class="text-gray-400 hover:text-gray-600 text-2xl font-bold">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6 max-h-[70vh] overflow-y-auto">
                <div class="prose prose-sm max-w-none">
                    <p class="text-gray-600 mb-4">Last updated: {{ date('F j, Y') }}</p>

                    <h2 class="text-xl font-bold text-gray-900 mt-6 mb-3">1. Introduction</h2>
                    <p class="text-gray-700 mb-4">Welcome to Pagsurong Lagonoy Tourism Platform ("we," "our," or "us"). These Terms and Conditions govern your use of our website and services. By accessing or using our platform, you agree to be bound by these terms.</p>
                    <p class="text-gray-700 mb-4">Our platform serves as a digital marketplace connecting tourists and travelers with local businesses in Pagsurong Lagonoy, including hotels, resorts, restaurants, and local product vendors.</p>

                    <h2 class="text-xl font-bold text-gray-900 mt-6 mb-3">2. Acceptance of Terms</h2>
                    <p class="text-gray-700 mb-4">By registering for an account, browsing our platform, making purchases, or using any of our services, you acknowledge that you have read, understood, and agree to be bound by these Terms and Conditions.</p>

                    <h2 class="text-xl font-bold text-gray-900 mt-6 mb-3">3. Description of Services</h2>
                    <p class="text-gray-700 mb-2">Our platform provides the following services:</p>
                    <ul class="list-disc pl-6 mb-4 text-gray-700">
                        <li><strong>For Visitors:</strong> Browse and discover local accommodations (hotels, resorts), attractions, and local product vendors.</li>
                        <li><strong>For Local Businesses:</strong> List and manage business profiles, showcase products and services, and connect with potential customers.</li>
                        <li><strong>Promotional Content:</strong> View promotions, deals, and special offers from hotels, resorts, and attractions.</li>
                        <li><strong>Local Products:</strong> Browse and purchase authentic local products directly from vendors.</li>
                    </ul>

                    <h2 class="text-xl font-bold text-gray-900 mt-6 mb-3">4. User Accounts and Registration</h2>
                    <h3 class="text-lg font-semibold text-gray-900 mt-4 mb-2">4.1 Account Creation</h3>
                    <p class="text-gray-700 mb-4">To use our services, you must create an account by providing accurate, complete, and current information. You are responsible for maintaining the confidentiality of your account credentials.</p>

                    <h3 class="text-lg font-semibold text-gray-900 mt-4 mb-2">4.2 Account Types</h3>
                    <ul class="list-disc pl-6 mb-4 text-gray-700">
                        <li><strong>Visitor Accounts:</strong> For individuals browsing and discovering local businesses and attractions.</li>
                        <li><strong>Business Owner Accounts:</strong> For local business owners to list and manage their services and products.</li>
                        <li><strong>Administrator Accounts:</strong> For platform management and moderation.</li>
                    </ul>

                    <h2 class="text-xl font-bold text-gray-900 mt-6 mb-3">5. User Responsibilities and Conduct</h2>
                    <p class="text-gray-700 mb-2">You agree to use our platform only for lawful purposes. You must not:</p>
                    <ul class="list-disc pl-6 mb-4 text-gray-700">
                        <li>Use our platform for any illegal or unauthorized purpose</li>
                        <li>Violate any applicable laws or regulations</li>
                        <li>Infringe on intellectual property rights</li>
                        <li>Transmit harmful, offensive, or inappropriate content</li>
                        <li>Attempt to gain unauthorized access to our systems</li>
                    </ul>

                    <h2 class="text-xl font-bold text-gray-900 mt-6 mb-3">6. Privacy and Data Protection</h2>
                    <p class="text-gray-700 mb-2">We collect and process personal information including:</p>
                    <ul class="list-disc pl-6 mb-4 text-gray-700">
                        <li>Personal details provided during registration</li>
                        <li>Transaction and purchase information</li>
                        <li>Communication records</li>
                        <li>Usage data and analytics</li>
                    </ul>

                    <h2 class="text-xl font-bold text-gray-900 mt-6 mb-3">7. Intellectual Property</h2>
                    <p class="text-gray-700 mb-4">All content on our platform, including text, graphics, logos, and software, is protected by intellectual property laws and remains our property or that of our licensors.</p>

                    <h2 class="text-xl font-bold text-gray-900 mt-6 mb-3">8. Payment and Transactions</h2>
                    <p class="text-gray-700 mb-4">All payments are processed through secure third-party payment processors. Business owners set their own prices for products and services.</p>

                    <h2 class="text-xl font-bold text-gray-900 mt-6 mb-3">9. Reviews and Ratings</h2>
                    <p class="text-gray-700 mb-4">Users may submit reviews and ratings based on their genuine experiences. Reviews must be honest, factual, and respectful.</p>

                    <h2 class="text-xl font-bold text-gray-900 mt-6 mb-3">10. Limitation of Liability</h2>
                    <p class="text-gray-700 mb-4">Our platform is provided "as is" without warranties of any kind. We shall not be liable for any indirect, incidental, special, or consequential damages arising from your use of our platform.</p>

                    <h2 class="text-xl font-bold text-gray-900 mt-6 mb-3">11. Changes to Terms</h2>
                    <p class="text-gray-700 mb-4">We reserve the right to modify these terms at any time. Continued use of our platform after changes constitutes acceptance of the new terms.</p>

                    <h2 class="text-xl font-bold text-gray-900 mt-6 mb-3">12. Contact Information</h2>
                    <p class="text-gray-700 mb-2">If you have questions about these Terms and Conditions, please contact us:</p>
                    <ul class="list-disc pl-6 mb-4 text-gray-700">
                        <li><strong>Email:</strong> legal@pagsuronglagonoy.com</li>
                        <li><strong>Address:</strong> Pagsurong Lagonoy Tourism Office, Lagonoy, Camarines Sur, Philippines</li>
                    </ul>

                    <div class="mt-6 p-4 bg-green-50 rounded-lg border border-green-200">
                        <p class="text-sm text-green-800">
                            <strong>Important:</strong> By clicking "I Accept" below and proceeding with registration, you acknowledge that you have read, understood, and agree to be bound by these Terms and Conditions.
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex justify-end gap-3 p-4 border-t">
                <button type="button" onclick="closeTermsModal()" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                    Close
                </button>
                <button type="button" onclick="acceptTermsFromModal()" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-check mr-2"></i>I Accept
                </button>
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
                    <p class="mt-4 text-gray-300">
                        Email: info@pagsuronglagonoy.com
                    </p>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} Pagsurong Lagonoy. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Logout Script -->
    <script>
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

        // Password Strength Checker
        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthIndicator = document.getElementById('password-strength');
            const strengthBar = document.getElementById('strength-bar');
            const strengthText = document.getElementById('strength-text');
            const strengthRequirements = document.getElementById('strength-requirements');

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

            // Ensure minimum width for visibility (at least 15% even for very weak passwords)
            const displayWidth = Math.max(strength, 15);
            strengthBar.style.width = displayWidth + '%';

            if (strength === 0) {
                // No criteria met
                strengthBar.className = 'h-full transition-all duration-300 bg-red-600';
                strengthText.className = 'text-xs font-medium text-red-600';
                strengthText.innerHTML = '<i class="fas fa-times-circle mr-1"></i>Very Weak';
                strengthRequirements.innerHTML = '<i class="fas fa-exclamation-triangle mr-1"></i>Password must include: ' + feedback.join(', ');
            } else if (strength <= 25) {
                // Only 1 criteria met
                strengthBar.className = 'h-full transition-all duration-300 bg-red-500';
                strengthText.className = 'text-xs font-medium text-red-600';
                strengthText.innerHTML = '<i class="fas fa-times-circle mr-1"></i>Weak';
                strengthRequirements.innerHTML = '<i class="fas fa-info-circle mr-1"></i>Add: ' + feedback.join(', ');
            } else if (strength <= 50) {
                // 2 criteria met
                strengthBar.className = 'h-full transition-all duration-300 bg-orange-500';
                strengthText.className = 'text-xs font-medium text-orange-600';
                strengthText.innerHTML = '<i class="fas fa-exclamation-circle mr-1"></i>Fair';
                strengthRequirements.innerHTML = '<i class="fas fa-info-circle mr-1"></i>Add: ' + feedback.join(', ');
            } else if (strength <= 75) {
                // 3 criteria met
                strengthBar.className = 'h-full transition-all duration-300 bg-yellow-500';
                strengthText.className = 'text-xs font-medium text-yellow-600';
                strengthText.innerHTML = '<i class="fas fa-check-circle mr-1"></i>Good';
                if (feedback.length > 0) {
                    strengthRequirements.innerHTML = '<i class="fas fa-lightbulb mr-1"></i>Suggestion: Add ' + feedback.join(', ');
                } else {
                    strengthRequirements.innerHTML = '<i class="fas fa-thumbs-up mr-1"></i>Good password!';
                }
            } else {
                // All 4 criteria met
                strengthBar.className = 'h-full transition-all duration-300 bg-green-600';
                strengthText.className = 'text-xs font-medium text-green-600';
                strengthText.innerHTML = '<i class="fas fa-check-circle mr-1"></i>Strong';
                strengthRequirements.innerHTML = '<i class="fas fa-shield-alt mr-1"></i>Excellent! Your password is strong.';
            }
        }

        // Show/hide business sections based on account type selection
        document.addEventListener('DOMContentLoaded', function() {
            const roleInputs = document.querySelectorAll('input[name="role"]');
            const businessTypeSection = document.getElementById('businessTypeSection');
            const businessTypeInputs = document.querySelectorAll('input[name="business_type"]');

            function toggleBusinessSections() {
                const isBusinessOwner = document.querySelector('input[name="role"]:checked')?.value === 'business_owner';
                
                if (isBusinessOwner) {
                    businessTypeSection.classList.remove('hidden');
                    businessTypeInputs.forEach(input => input.required = true);
                } else {
                    businessTypeSection.classList.add('hidden');
                    businessTypeInputs.forEach(input => input.required = false);
                }
            }

            // Add event listeners to all role radio buttons
            roleInputs.forEach(input => {
                input.addEventListener('change', toggleBusinessSections);
            });

            // Initialize the view based on any previously selected value
            toggleBusinessSections();
        });

        // Terms and Conditions Modal Functions
        function openTermsModal(event) {
            if (event) event.preventDefault(); // Prevent any default action
            document.getElementById('termsModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        function closeTermsModal() {
            document.getElementById('termsModal').classList.add('hidden');
            document.body.style.overflow = 'auto'; // Restore scrolling
        }

        function acceptTermsFromModal() {
            // Check the terms checkbox
            document.getElementById('accept_terms').checked = true;
            // Close the modal
            closeTermsModal();
            // Show a brief confirmation message
            const checkboxLabel = document.querySelector('label[for="accept_terms"]');
            checkboxLabel.classList.add('text-green-600');
            setTimeout(() => {
                checkboxLabel.classList.remove('text-green-600');
            }, 2000);
        }

        // Close modal when clicking outside of it
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('termsModal');
            if (event.target === modal) {
                closeTermsModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const modal = document.getElementById('termsModal');
                if (!modal.classList.contains('hidden')) {
                    closeTermsModal();
                }
            }
        });

        // Validate password strength before form submission
        function validatePagePasswordStrength() {
            const password = document.getElementById('password').value;
            
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

</body>
</html>