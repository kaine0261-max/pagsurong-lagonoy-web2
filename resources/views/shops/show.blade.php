@extends(auth()->check() && auth()->user()->role === 'customer' ? 'layouts.customer' : 'layouts.public')

@section('title', $shop->business_name)

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-6xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8 py-4 sm:py-6">
        <div class="bg-white rounded-lg sm:rounded-xl shadow overflow-hidden">
            <!-- Cover Image -->
            @if($shop->cover_image)
                <img src="{{ Storage::url($shop->cover_image) }}" class="w-full h-48 sm:h-56 md:h-64 object-cover" alt="{{ $shop->business_name }}">
            @endif

            <!-- Shop Info -->
            <div class="p-4 sm:p-5 md:p-6">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex-1">
                        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mb-2">{{ $shop->business_name }}</h1>
                        
                        @if($shop->average_rating > 0)
                            <div class="flex items-center mb-3 sm:mb-4">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-sm sm:text-base {{ $i <= $shop->average_rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                    @endfor
                                </div>
                                <span class="ml-2 text-xs sm:text-sm text-gray-600">{{ number_format($shop->average_rating, 1) }} ({{ $shop->total_ratings }})</span>
                            </div>
                        @endif
                    </div>

                    @if($shop->profile_avatar || $shop->logo)
                        <img src="{{ Storage::url($shop->profile_avatar ?? $shop->logo) }}" 
                             class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 rounded-full object-cover border-2 sm:border-4 border-white shadow-lg flex-shrink-0" 
                             alt="{{ $shop->business_name }}">
                    @endif
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 mt-3 sm:mt-4">
                    @if($shop->address)
                        <div class="flex items-center text-sm sm:text-base text-gray-600">
                            <i class="fas fa-map-marker-alt mr-2 text-green-600 text-sm"></i>
                            <span class="truncate">{{ $shop->address }}</span>
                        </div>
                    @endif

                    @if($shop->contact_number)
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-phone mr-2 text-green-600"></i>
                            <span>{{ $shop->contact_number }}</span>
                        </div>
                    @endif

                    @if($shop->email)
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-envelope mr-2 text-green-600"></i>
                            <span>{{ $shop->email }}</span>
                        </div>
                    @endif

                    @if($shop->website)
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-globe mr-2 text-green-600"></i>
                            <a href="{{ $shop->website }}" target="_blank" class="text-green-600 hover:underline">Visit Website</a>
                        </div>
                    @endif

                    @if($shop->facebook_page)
                        <div class="flex items-center text-gray-600">
                            <i class="fab fa-facebook mr-2 text-green-600"></i>
                            <a href="{{ $shop->facebook_page }}" target="_blank" class="text-green-600 hover:underline">Facebook Page</a>
                        </div>
                    @endif
                </div>

                @if($shop->description)
                    <div class="mt-4 sm:mt-6">
                        <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2">About This Shop</h2>
                        <p class="text-sm sm:text-base text-gray-700 leading-relaxed">{{ $shop->description }}</p>
                    </div>
                @endif
            </div>

            <!-- Products Section -->
            <div class="px-3 sm:px-4 md:px-6 pb-4 sm:pb-6">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-3 sm:mb-4">
                    <i class="fas fa-shopping-bag mr-2 text-green-600"></i>Products
                </h2>
                
                @if($shop->products && $shop->products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                        @foreach($shop->products as $product)
                            <div class="border border-gray-200 rounded-lg overflow-hidden bg-white hover:shadow-lg transition-shadow">
                                @if($product->image)
                                    <div class="relative h-36 sm:h-40 md:h-48 overflow-hidden">
                                        <img src="{{ Storage::url($product->image) }}" 
                                             class="w-full h-full object-cover" 
                                             alt="{{ $product->name }}">
                                    </div>
                                @else
                                    <div class="h-36 sm:h-40 md:h-48 bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-box text-gray-400 text-2xl sm:text-3xl md:text-4xl"></i>
                                    </div>
                                @endif
                                <div class="p-3 sm:p-4">
                                    <h3 class="font-bold text-base sm:text-lg text-gray-900 mb-1">{{ $product->name }}</h3>
                                    @if($product->description)
                                        <p class="text-xs sm:text-sm text-gray-600 mb-2 sm:mb-3 line-clamp-2">{{ Str::limit($product->description, 80) }}</p>
                                    @endif
                                    <div class="flex items-center justify-between mb-2 sm:mb-3">
                                        <p class="text-xl sm:text-2xl font-bold text-green-600">₱{{ number_format($product->price, 2) }}</p>
                                        @if($product->current_stock > 0)
                                            <span class="text-xs sm:text-sm text-green-600 font-medium">Stock: {{ $product->current_stock }}</span>
                                        @else
                                            <span class="text-xs sm:text-sm text-red-600 font-medium">Out</span>
                                        @endif
                                    </div>
                                    
                                    @auth
                                        @if(auth()->user()->role === 'customer')
                                            @if($product->current_stock > 0)
                                                <button onclick="addToCart({{ $product->id }})" 
                                                        class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-3 sm:px-4 rounded-lg transition-colors text-sm sm:text-base">
                                                    <i class="fas fa-shopping-cart mr-1 sm:mr-2"></i><span class="hidden sm:inline">Add to Cart</span><span class="sm:hidden">Add</span>
                                                </button>
                                            @else
                                                <button disabled 
                                                        class="w-full bg-gray-300 text-gray-500 py-2 px-3 sm:px-4 rounded-lg cursor-not-allowed text-sm sm:text-base">
                                                    <i class="fas fa-times-circle mr-1 sm:mr-2"></i><span class="hidden sm:inline">Out of Stock</span><span class="sm:hidden">Out</span>
                                                </button>
                                            @endif
                                        @else
                                            <button disabled 
                                                    class="w-full bg-gray-300 text-gray-500 py-2 px-3 sm:px-4 rounded-lg cursor-not-allowed text-sm sm:text-base">
                                                <i class="fas fa-info-circle mr-1 sm:mr-2"></i>View Only
                                            </button>
                                        @endif
                                    @else
                                        <button onclick="showLoginPrompt()" 
                                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-3 sm:px-4 rounded-lg transition-colors text-sm sm:text-base">
                                            <i class="fas fa-sign-in-alt mr-1 sm:mr-2"></i><span class="hidden sm:inline">Login to Purchase</span><span class="sm:hidden">Login</span>
                                        </button>
                                    @endauth
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 text-gray-500">
                        <i class="fas fa-box-open text-6xl mb-4"></i>
                        <p class="text-lg">No products available at the moment.</p>
                    </div>
                @endif
            </div>

            <!-- Gallery Section -->
            @if($shop->galleries && $shop->galleries->count() > 0)
                <div class="px-6 pb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-images mr-2 text-green-600"></i>Gallery
                    </h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach($shop->galleries as $gallery)
                            <div class="relative group cursor-pointer" onclick="openImageModal('{{ Storage::url($gallery->image_path) }}')">
                                <img src="{{ Storage::url($gallery->image_path) }}" 
                                     class="w-full h-40 object-cover rounded-lg hover:opacity-90 transition-opacity">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-opacity rounded-lg flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white opacity-0 group-hover:opacity-100 text-2xl"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4" onclick="closeImageModal()">
    <button type="button" class="absolute top-4 right-4 text-white text-4xl font-bold hover:text-gray-300" onclick="closeImageModal()">
        &times;
    </button>
    <img id="modalImage" src="" alt="Gallery Image" class="max-w-full max-h-full object-contain">
</div>

<!-- Login Prompt Modal -->
<div id="loginModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Login Required</h3>
        <p class="text-gray-600 mb-6">Please login as a customer to add products to your cart and make purchases.</p>
        <div class="flex gap-3">
            <a href="{{ route('login') }}" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg text-center transition-colors">
                Login
            </a>
            <button onclick="closeLoginModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-lg transition-colors">
                Cancel
            </button>
        </div>
    </div>
</div>

<script>
    function openImageModal(imageSrc) {
        document.getElementById('modalImage').src = imageSrc;
        document.getElementById('imageModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function showLoginPrompt() {
        document.getElementById('loginModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeLoginModal() {
        document.getElementById('loginModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    @auth
    @if(auth()->user()->role === 'customer')
    function addToCart(productId) {
        fetch(`/cart/add`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
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
                showNotification('Product added to cart successfully!', 'success');
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
                // Reload page after short delay to update cart
                setTimeout(() => location.reload(), 1500);
            } else {
                showNotification(data.message || 'Failed to add product to cart', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred. Please try again.', 'error');
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
    @endif
    @endauth
</script>
@endsection
