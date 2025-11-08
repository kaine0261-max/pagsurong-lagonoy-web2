@extends(auth()->check() && auth()->user()->role === 'customer' ? 'layouts.customer' : 'layouts.public')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8 py-4 sm:py-6 md:py-8">
            <div class="text-center">
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mb-1 sm:mb-2">
                    <i class="fas fa-shopping-bag mr-2 sm:mr-3 text-green-600"></i>
                    Products
                </h1>
                <p class="text-sm sm:text-base text-gray-600 max-w-2xl mx-auto">
                    Discover authentic local products from Lagonoy's finest businesses
                </p>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="max-w-7xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8 py-4 sm:py-6 md:py-8">
        @if($products->count() > 0)
            <div id="productsGrid" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6 transition-all duration-300">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden flex flex-col h-full">
                        <!-- Product Image -->
                        <div class="aspect-w-16 aspect-h-12 bg-gray-200 flex-shrink-0">
                            @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-32 sm:h-40 md:h-48 object-cover">
                            @else
                                <div class="w-full h-32 sm:h-40 md:h-48 bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400 text-xl sm:text-2xl md:text-3xl"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="p-2 sm:p-3 md:p-4 flex flex-col flex-grow">
                            <h3 class="font-semibold text-sm sm:text-base md:text-lg text-gray-900 mb-1 sm:mb-2 line-clamp-1">
                                {{ $product->name }}
                            </h3>
                            
                            <!-- Business Info -->
                            @if($product->business)
                                <div class="flex items-center text-xs sm:text-sm text-gray-500 mb-2">
                                    <i class="fas fa-store mr-1 sm:mr-2 text-xs"></i>
                                    <span class="truncate">{{ $product->business->businessProfile->business_name ?? 'Local Shop' }}</span>
                                </div>
                            @endif

                            <!-- Price -->
                            <div class="flex items-center justify-between mb-2 sm:mb-3">
                                <span class="text-lg sm:text-xl md:text-2xl font-bold text-green-600">
                                    ₱{{ number_format($product->price, 2) }}
                                </span>
                                
                                <!-- Stock Status -->
                                @if($product->current_stock > 0)
                                    <span class="text-xs text-green-600 bg-green-100 px-1.5 sm:px-2 py-0.5 sm:py-1 rounded-full">
                                        {{ $product->current_stock }} in stock
                                    </span>
                                @else
                                    <span class="text-xs text-red-600 bg-red-100 px-1.5 sm:px-2 py-0.5 sm:py-1 rounded-full">
                                        Out of stock
                                    </span>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="mt-auto space-y-2">
                                @auth
                                    @if($product->current_stock > 0)
                                        <button onclick="addToCart({{ $product->id }})" 
                                                class="w-full bg-green-600 hover:bg-green-700 text-white py-1.5 sm:py-2 px-2 sm:px-4 rounded-lg transition-colors duration-200 text-xs sm:text-sm md:text-base">
                                            <i class="fas fa-cart-plus mr-1 sm:mr-2"></i><span class="hidden sm:inline">Add to Cart</span><span class="sm:hidden">Add</span>
                                        </button>
                                    @else
                                        <button disabled 
                                                class="w-full bg-gray-300 text-gray-500 py-1.5 sm:py-2 px-2 sm:px-4 rounded-lg cursor-not-allowed text-xs sm:text-sm md:text-base">
                                            <i class="fas fa-times mr-1 sm:mr-2"></i><span class="hidden sm:inline">Out of Stock</span><span class="sm:hidden">Out</span>
                                        </button>
                                    @endif
                                @else
                                    @if($product->current_stock > 0)
                                        <button onclick="handleAddToCart({{ $product->id }}, '{{ addslashes($product->name) }}')" 
                                                class="w-full bg-green-600 hover:bg-green-700 text-white py-1.5 sm:py-2 px-2 sm:px-4 rounded-lg transition-colors duration-200 text-xs sm:text-sm md:text-base">
                                            <i class="fas fa-cart-plus mr-1 sm:mr-2"></i><span class="hidden sm:inline">Add to Cart</span><span class="sm:hidden">Add</span>
                                        </button>
                                    @else
                                        <button disabled 
                                                class="w-full bg-gray-300 text-gray-500 py-1.5 sm:py-2 px-2 sm:px-4 rounded-lg cursor-not-allowed text-xs sm:text-sm md:text-base">
                                            <i class="fas fa-times mr-1 sm:mr-2"></i><span class="hidden sm:inline">Out of Stock</span><span class="sm:hidden">Out</span>
                                        </button>
                                    @endif
                                @endauth

                                <!-- Reviews Button -->
                                @auth
                                    <button onclick="showComments({{ $product->id }})" class="w-full flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                                        <i class="fas fa-comment-dots mr-2"></i>
                                        <span>Reviews</span>
                                        @php
                                            try {
                                                $commentCount = method_exists($product, 'comments') ? $product->comments()->count() : 0;
                                            } catch (Exception $e) {
                                                $commentCount = 0;
                                            }
                                        @endphp
                                        @if($commentCount > 0)
                                            <span class="ml-2 bg-green-500 text-white text-xs rounded-full px-2 py-0.5">{{ $commentCount }}</span>
                                        @endif
                                    </button>
                                @else
                                    <button onclick="viewComments({{ $product->id }}, '{{ addslashes($product->name) }}')" class="w-full flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                                        <i class="fas fa-comment-dots mr-2"></i>
                                        <span>View Reviews</span>
                                        @php
                                            try {
                                                $commentCount = method_exists($product, 'comments') ? $product->comments()->count() : 0;
                                            } catch (Exception $e) {
                                                $commentCount = 0;
                                            }
                                        @endphp
                                        @if($commentCount > 0)
                                            <span class="ml-2 bg-green-500 text-white text-xs rounded-full px-2 py-0.5">{{ $commentCount }}</span>
                                        @endif
                                    </button>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <!-- No Products Message -->
            <div class="text-center py-16">
                <i class="fas fa-shopping-basket text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No Products Available</h3>
                <p class="text-gray-500">Check back later for new products from local shops!</p>
            </div>
        @endif
    </div>
</div>

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

                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-sm text-green-600 hover:text-green-500">
                            Forgot password?
                        </a>
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
@endsection

@section('scripts')
<script>
// Set auth status for JavaScript
@auth
    const authUser = true;
@else
    const authUser = false;
@endauth

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
    addToCart(productId);
    return true;
}

function handleLike(itemType, itemName) {
    if (!requireAuth('like items', `Please login or register to like "${itemName}".`)) {
        return false;
    }
    // Proceed with like logic
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

// View comments function for public users (no auth required)
function viewComments(productId, productName) {
    showCommentsModal(productId, productName, false); // false = read-only mode
}

// Show comments modal
function showCommentsModal(productId, productName, canComment = true) {
    const modal = createCommentsModal(productId, productName, canComment);
    document.body.appendChild(modal);
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Load existing comments
    loadProductComments(productId);
}

function createCommentsModal(productId, productName, canComment = true) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    modal.id = `comments-modal-${productId}`;
    
    const commentFormHtml = canComment ? `
        <!-- Add Comment Form -->
        <form id="comment-form-${productId}" onsubmit="submitProductComment(event, ${productId})" class="border-t pt-4">
            <div class="flex space-x-3">
                <textarea name="comment" rows="2" class="flex-1 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 resize-none" 
                          placeholder="Write a review..." required></textarea>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </form>
    ` : `
        <div class="border-t pt-4 text-center">
            <p class="text-gray-500 text-sm mb-3">Want to leave a review?</p>
            <button onclick="closeCommentsModal(${productId}); handleComment('product', '${productName}');" 
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors">
                Login to Review
            </button>
        </div>
    `;
    
    modal.innerHTML = `
        <div class="bg-white rounded-lg p-6 max-w-lg w-full mx-4 max-h-[80vh] flex flex-col">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Reviews - ${productName}</h3>
                <button onclick="closeCommentsModal(${productId})" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- Reviews List -->
            <div class="flex-1 overflow-y-auto mb-4" id="comments-list-${productId}">
                <div class="text-center py-4 text-gray-500">Loading reviews...</div>
            </div>
            
            ${commentFormHtml}
        </div>
    `;
    
    return modal;
}

function closeCommentsModal(productId) {
    const modal = document.getElementById(`comments-modal-${productId}`);
    if (modal) {
        modal.remove();
        document.body.style.overflow = 'auto';
    }
}

function loadProductComments(productId) {
    fetch(`/products/${productId}/comments`, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        const commentsList = document.getElementById(`comments-list-${productId}`);
        if (data.comments && data.comments.length > 0) {
            commentsList.innerHTML = data.comments.map(comment => `
                <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 rounded-full overflow-hidden flex-shrink-0">
                            ${comment.user && comment.user.profile_picture ? 
                                `<img src="${comment.user.profile_picture}" alt="${comment.user.name}" class="w-full h-full object-cover">` :
                                `<div class="w-full h-full bg-green-500 flex items-center justify-center text-white text-sm font-medium">
                                    ${comment.user && comment.user.name ? comment.user.name.charAt(0).toUpperCase() : 'U'}
                                </div>`
                            }
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-medium text-sm">${comment.user ? comment.user.name : 'User'}</span>
                                <span class="text-xs text-gray-500">${comment.created_at_human || comment.created_at}</span>
                            </div>
                            <p class="text-sm text-gray-700">${comment.comment}</p>
                        </div>
                    </div>
                </div>
            `).join('');
        } else {
            commentsList.innerHTML = '<div class="text-center py-4 text-gray-500">No comments yet. Be the first to comment!</div>';
        }
    })
    .catch(error => {
        console.error('Error loading comments:', error);
        const commentsList = document.getElementById(`comments-list-${productId}`);
        commentsList.innerHTML = '<div class="text-center py-4 text-red-500">Error loading comments</div>';
    });
}

function submitProductComment(event, productId) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    
    fetch(`/products/${productId}/comment`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            form.reset();
            loadProductComments(productId);
        } else {
            alert(data.error || 'Error submitting comment');
        }
    })
    .catch(error => {
        console.error('Error submitting comment:', error);
        alert('Error submitting comment');
    });
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
        closeAuthPrompt();
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

@auth
function addToCart(productId) {
    // Add to cart functionality for authenticated users
    fetch(`{{ route('customer.cart.add') }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success notification
            showNotification(data.message || 'Product added to cart!', 'success');
            // Update cart count badges
            if (data.cartCount) {
                // Update mobile bottom nav badge
                const mobileBadges = document.querySelectorAll('.cart-count, [class*="cart"]');
                mobileBadges.forEach(badge => {
                    if (badge.tagName === 'SPAN') {
                        badge.textContent = data.cartCount;
                        badge.classList.remove('hidden');
                    }
                });
                
                // Update header cart badge
                const headerBadge = document.querySelector('.cart-count-badge');
                if (headerBadge) {
                    headerBadge.textContent = data.cartCount;
                } else {
                    // Create badge if it doesn't exist
                    const cartLink = document.querySelector('a[href*="cart"]');
                    if (cartLink && !cartLink.querySelector('.cart-count-badge')) {
                        const badge = document.createElement('span');
                        badge.className = 'cart-count-badge absolute -top-1 -right-1 bg-orange-500 text-white text-[10px] rounded-full w-4 h-4 flex items-center justify-center font-bold';
                        badge.textContent = data.cartCount;
                        cartLink.appendChild(badge);
                    }
                }
            }
            // Redirect to cart page
            setTimeout(() => window.location.href = '{{ route('customer.cart') }}', 1500);
        } else {
            showNotification(data.message || 'Error adding product to cart.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error adding product to cart. Please try again.', 'error');
    });
}

function showNotification(message, type = 'success') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-20 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${
        type === 'success' ? 'bg-green-600 text-white' : 'bg-red-600 text-white'
    }`;
    notification.innerHTML = `
        <div class="flex items-center space-x-3">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} text-xl"></i>
            <span class="font-medium">${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 10);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

function toggleLike(productId) {
    // Like functionality for authenticated users
    fetch(`/products/${productId}/like`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Update like button state
        console.log('Like toggled:', data);
        // Refresh the page to show updated counts
        location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function showRating(productId) {
    // Rating functionality for authenticated users
    alert('Rating feature coming soon!');
}

function showComments(productId) {
    // Comment functionality for authenticated users - can comment
    showCommentsModal(productId, 'Product', true);
}
@endauth
</script>
@endsection
