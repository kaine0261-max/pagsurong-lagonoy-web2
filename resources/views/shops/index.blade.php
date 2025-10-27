@extends(auth()->check() && auth()->user()->role === 'customer' ? 'layouts.customer' : 'layouts.public')

@section('title', 'Shops - Pagsurong Lagonoy')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8 py-4 sm:py-6 md:py-8">
            <div class="text-center">
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mb-1 sm:mb-2">
                    <i class="fas fa-store mr-2 sm:mr-3 text-green-600"></i>
                    Local Shops
                </h1>
                <p class="text-sm sm:text-base text-gray-600 max-w-2xl mx-auto">
                    Discover authentic local shops and businesses in Lagonoy
                </p>
            </div>
        </div>
    </div>

    <!-- Shops Grid -->
    <div class="max-w-7xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8 py-4 sm:py-6 md:py-8">
        @if($shops->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 md:gap-6 lg:gap-8">
                @foreach($shops as $shop)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                        <!-- Shop Image -->
                        <div class="aspect-w-16 aspect-h-12 bg-gray-200">
                            @if($shop->businessProfile && $shop->businessProfile->cover_image)
                                <img src="{{ Storage::url($shop->businessProfile->cover_image) }}" 
                                     alt="{{ $shop->businessProfile->business_name }}" 
                                     class="w-full h-40 sm:h-48 md:h-56 lg:h-64 object-cover">
                            @elseif($shop->cover_image)
                                <img src="{{ Storage::url($shop->cover_image) }}" 
                                     alt="{{ $shop->name }}" 
                                     class="w-full h-40 sm:h-48 md:h-56 lg:h-64 object-cover">
                            @else
                                <div class="w-full h-40 sm:h-48 md:h-56 lg:h-64 bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-store text-gray-400 text-3xl sm:text-4xl md:text-5xl"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Shop Info -->
                        <div class="p-2 sm:p-3 md:p-4 lg:p-6">
                            <!-- Shop Header -->
                            <div class="flex items-center space-x-2 sm:space-x-3 mb-2 sm:mb-3">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full overflow-hidden flex-shrink-0">
                                    @if($shop->businessProfile && $shop->businessProfile->profile_avatar)
                                        <img src="{{ Storage::url($shop->businessProfile->profile_avatar) }}" 
                                             alt="{{ $shop->businessProfile->business_name }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-green-500 flex items-center justify-center">
                                            <i class="fas fa-store text-white text-lg"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-sm sm:text-base md:text-lg text-gray-900 line-clamp-1">
                                        {{ $shop->businessProfile->business_name ?? $shop->name }}
                                    </h3>
                                    <p class="text-xs sm:text-sm text-gray-500 line-clamp-1">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        {{ $shop->businessProfile->address ?? 'Lagonoy, Camarines Sur' }}
                                    </p>
                                </div>
                                <span class="hidden sm:inline-block px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                    Published
                                </span>
                            </div>

                            @if($shop->businessProfile && $shop->businessProfile->description)
                                <p class="hidden sm:block text-gray-600 text-xs sm:text-sm mb-2 sm:mb-3 line-clamp-2">
                                    {{ $shop->businessProfile->description }}
                                </p>
                            @endif

                            <!-- Rating Display -->
                            <div class="flex items-center justify-center text-sm text-gray-600 mb-4">
                                @auth
                                    <button onclick="showShopRating({{ $shop->id }})" class="flex items-center hover:text-yellow-500 transition-colors">
                                        <i class="fas fa-star text-yellow-400 mr-1"></i>
                                        @php
                                            try {
                                                $avgRating = method_exists($shop, 'ratings') ? $shop->ratings()->avg('rating') : 0;
                                                $ratingCount = method_exists($shop, 'ratings') ? $shop->ratings()->count() : 0;
                                            } catch (Exception $e) {
                                                $avgRating = 0;
                                                $ratingCount = 0;
                                            }
                                        @endphp
                                        {{ number_format($avgRating ?? 0, 1) }} ({{ $ratingCount }})
                                    </button>
                                @else
                                    <button onclick="handleRating('shop', '{{ addslashes($shop->businessProfile->business_name ?? $shop->name) }}')" class="flex items-center hover:text-yellow-500 transition-colors">
                                        <i class="fas fa-star text-yellow-400 mr-1"></i>
                                        @php
                                            try {
                                                $avgRating = method_exists($shop, 'ratings') ? $shop->ratings()->avg('rating') : 0;
                                                $ratingCount = method_exists($shop, 'ratings') ? $shop->ratings()->count() : 0;
                                            } catch (Exception $e) {
                                                $avgRating = 0;
                                                $ratingCount = 0;
                                            }
                                        @endphp
                                        {{ number_format($avgRating ?? 0, 1) }} ({{ $ratingCount }})
                                    </button>
                                @endauth
                            </div>

                            <!-- Actions -->
                            <div class="mt-2 sm:mt-3 md:mt-4 space-y-1.5 sm:space-y-2">
                                <a href="{{ route('public.shops.show', $shop->businessProfile->id ?? $shop->id) }}" 
                                   class="w-full bg-green-600 hover:bg-green-700 text-white py-2 sm:py-2.5 md:py-3 px-3 sm:px-4 rounded-lg transition-colors duration-200 flex items-center justify-center text-sm sm:text-base md:text-lg font-medium">
                                    <i class="fas fa-eye mr-1 sm:mr-2 text-sm sm:text-base"></i><span class="hidden sm:inline">View Shop</span><span class="sm:hidden">View</span>
                                </a>
                                
                                <!-- Feedback Button -->
                                @auth
                                    <button onclick="showShopComments({{ $shop->id }})" class="w-full flex items-center justify-center px-3 sm:px-4 py-1.5 sm:py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors text-xs sm:text-sm">
                                        <i class="fas fa-comment-dots mr-1 sm:mr-2"></i>
                                        <span>Feedback</span>
                                        @php
                                            try {
                                                $commentCount = method_exists($shop, 'comments') ? $shop->comments()->count() : 0;
                                            } catch (Exception $e) {
                                                $commentCount = 0;
                                            }
                                        @endphp
                                        @if($commentCount > 0)
                                            <span class="ml-2 bg-green-500 text-white text-xs rounded-full px-2 py-0.5">{{ $commentCount }}</span>
                                        @endif
                                    </button>
                                @else
                                    <button onclick="viewShopComments({{ $shop->id }}, '{{ addslashes($shop->businessProfile->business_name ?? $shop->name) }}')" class="w-full flex items-center justify-center px-3 sm:px-4 py-1.5 sm:py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors text-xs sm:text-sm">
                                        <i class="fas fa-comment-dots mr-1 sm:mr-2"></i>
                                        <span>View Feedback</span>
                                        @php
                                            try {
                                                $commentCount = method_exists($shop, 'comments') ? $shop->comments()->count() : 0;
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
                {{ $shops->links() }}
            </div>
        @else
            <!-- No Shops Message -->
            <div class="text-center py-16">
                <i class="fas fa-store text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No Shops Available</h3>
                <p class="text-gray-500">Check back later for new local shops and businesses!</p>
            </div>
        @endif
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

// Public action handlers that require authentication
function handleLike(itemType, itemName) {
    showAuthModal('like', itemType, itemName);
}

function handleRating(itemType, itemName) {
    showAuthModal('rate', itemType, itemName);
}

function handleComment(itemType, itemName) {
    showAuthModal('comment', itemType, itemName);
}

// Show authentication modal
function showAuthModal(action, itemType, itemName) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    modal.id = 'auth-modal';
    
    modal.innerHTML = `
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                    <i class="fas fa-user-plus text-green-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Login Required</h3>
                <p class="text-sm text-gray-500 mb-6">
                    You need to login or register to ${action} this ${itemType}.
                </p>
                <div class="flex space-x-3">
                    <a href="{{ route('login') }}" 
                       class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md transition-colors">
                        Login
                    </a>
                    <a href="{{ route('register') }}" 
                       class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-4 rounded-md transition-colors">
                        Register
                    </a>
                </div>
                <button onclick="closeAuthModal()" 
                        class="mt-3 text-sm text-gray-500 hover:text-gray-700">
                    Cancel
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    document.body.style.overflow = 'hidden';
}

function closeAuthModal() {
    const modal = document.getElementById('auth-modal');
    if (modal) {
        modal.remove();
        document.body.style.overflow = 'auto';
    }
}

// View shop comments function for public users (no auth required)
function viewShopComments(shopId, shopName) {
    showShopCommentsModal(shopId, shopName, false); // false = read-only mode
}

// Show shop comments modal
function showShopCommentsModal(shopId, shopName, canComment = true) {
    const modal = createShopCommentsModal(shopId, shopName, canComment);
    document.body.appendChild(modal);
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Load existing comments
    loadShopComments(shopId);
}

function createShopCommentsModal(shopId, shopName, canComment = true) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    modal.id = `shop-comments-modal-${shopId}`;
    
    const commentFormHtml = canComment ? `
        <!-- Add Comment Form -->
        <form id="shop-comment-form-${shopId}" onsubmit="submitShopComment(event, ${shopId})" class="border-t pt-4">
            <div class="flex space-x-3">
                <textarea name="comment" rows="2" class="flex-1 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 resize-none" 
                          placeholder="Write a comment..." required></textarea>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </form>
    ` : `
        <div class="border-t pt-4 text-center">
            <p class="text-gray-500 text-sm mb-3">Want to leave a comment?</p>
            <button onclick="closeShopCommentsModal(${shopId}); handleComment('shop', '${shopName}');" 
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors">
                Login to Comment
            </button>
        </div>
    `;
    
    modal.innerHTML = `
        <div class="bg-white rounded-lg p-6 max-w-lg w-full mx-4 max-h-[80vh] flex flex-col">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Comments - ${shopName}</h3>
                <button onclick="closeShopCommentsModal(${shopId})" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- Comments List -->
            <div class="flex-1 overflow-y-auto mb-4" id="shop-comments-list-${shopId}">
                <div class="text-center py-4 text-gray-500">Loading comments...</div>
            </div>
            
            ${commentFormHtml}
        </div>
    `;
    
    return modal;
}

function closeShopCommentsModal(shopId) {
    const modal = document.getElementById(`shop-comments-modal-${shopId}`);
    if (modal) {
        modal.remove();
        document.body.style.overflow = 'auto';
    }
}

function loadShopComments(shopId) {
    fetch(`/businesses/${shopId}/comments`, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        const commentsList = document.getElementById(`shop-comments-list-${shopId}`);
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
        const commentsList = document.getElementById(`shop-comments-list-${shopId}`);
        commentsList.innerHTML = '<div class="text-center py-4 text-red-500">Error loading comments</div>';
    });
}

@auth
function toggleShopLike(shopId) {
    // Like functionality for authenticated users
    fetch(`/businesses/${shopId}/like`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('Like toggled:', data);
        location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function showShopRating(shopId) {
    alert('Rating feature coming soon!');
}

function showShopComments(shopId) {
    showShopCommentsModal(shopId, 'Shop', true);
}
@endauth
</script>
@endsection
