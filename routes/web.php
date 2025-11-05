<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResortController;
use App\Http\Controllers\AttractionController;

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\CommentController;

// =========================
// PUBLIC ROUTES
// =========================

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/terms', [App\Http\Controllers\TermsController::class, 'show'])->name('terms');
Route::post('/terms/accept', [App\Http\Controllers\TermsController::class, 'accept'])->name('terms.accept');
Route::post('/terms/decline', [App\Http\Controllers\TermsController::class, 'decline'])->name('terms.decline');

// Public browsing routes
Route::get('/products', [ProductController::class, 'index'])->name('public.products');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('public.products.show');
Route::get('/shops', [ProductController::class, 'shops'])->name('public.shops');
Route::get('/shops/{shop}', [ProductController::class, 'showShop'])->name('public.shops.show');
Route::get('/hotels', [HotelController::class, 'index'])->name('public.hotels');
Route::get('/hotels/{hotel}', [HotelController::class, 'show'])->name('public.hotels.show');
Route::get('/resorts', [ResortController::class, 'index'])->name('public.resorts');
Route::get('/resorts/{id}', [ResortController::class, 'show'])->name('public.resorts.show');
Route::get('/attractions', [AttractionController::class, 'index'])->name('public.attractions');
Route::get('/attractions/{id}', [AttractionController::class, 'show'])->name('public.attractions.show');

// Comment count routes (accessible to all)
Route::get('/businesses/{business}/comment-count', [RatingController::class, 'getBusinessCommentCount'])->name('businesses.comment-count');

// Public comment viewing routes (no auth required)
Route::get('/businesses/{business}/comments', [RatingController::class, 'getBusinessComments'])->name('businesses.comments');
Route::get('/products/{product}/comments', [RatingController::class, 'getProductComments'])->name('products.comments');
Route::get('/hotels/{businessProfile}/comments', [RatingController::class, 'getHotelComments'])->name('hotels.comments');
Route::get('/resorts/{businessProfile}/comments', [RatingController::class, 'getResortComments'])->name('resorts.comments');
Route::get('/tourist-spots/{touristSpot}/comments', [RatingController::class, 'getTouristSpotComments'])->name('tourist-spot.comments');

// Unified Rating and Like System
Route::middleware('auth')->group(function () {
    // Unified rating and like routes
    Route::post('/businesses/{business}/rate', [RatingController::class, 'rateBusiness'])->name('businesses.rate');
    Route::post('/businesses/{business}/like', [RatingController::class, 'toggleBusinessLike'])->name('businesses.like');
    Route::post('/businesses/{business}/comment', [RatingController::class, 'commentBusiness'])->name('businesses.comment');
    Route::delete('/comments/{comment}', [RatingController::class, 'deleteComment'])->name('comments.delete');
    
    Route::post('/products/{product}/rate', [RatingController::class, 'rateProduct'])->name('products.rate');
    Route::post('/products/{product}/like', [RatingController::class, 'toggleProductLike'])->name('products.like');
    Route::post('/products/{product}/comment', [RatingController::class, 'commentProduct'])->name('products.comment');
    Route::delete('/product-comments/{comment}', [RatingController::class, 'deleteProductComment'])->name('product-comments.destroy');
    
    Route::post('/hotels/{businessProfile}/rate', [RatingController::class, 'rateHotel'])->name('hotels.rate');
    Route::post('/hotels/{businessProfile}/like', [RatingController::class, 'toggleHotelLike'])->name('hotels.like');
    Route::post('/hotels/{businessProfile}/comment', [RatingController::class, 'commentHotel'])->name('hotels.comment');
    Route::delete('/hotel-comments/{comment}', [RatingController::class, 'deleteHotelComment'])->name('hotel-comments.delete');
    
    Route::post('/resorts/{businessProfile}/rate', [RatingController::class, 'rateResort'])->name('resorts.rate');
    Route::post('/resorts/{businessProfile}/like', [RatingController::class, 'toggleResortLike'])->name('resorts.like');
    Route::post('/resorts/{businessProfile}/comment', [RatingController::class, 'commentResort'])->name('resorts.comment');
    Route::delete('/resort-comments/{comment}', [RatingController::class, 'deleteResortComment'])->name('resort-comments.delete');
    
    // Room and cottage ratings (legacy support)
    Route::post('/rooms/{room}/rate', [RatingController::class, 'rateRoom'])->name('room.rate');
    Route::post('/cottages/{cottage}/rate', [RatingController::class, 'rateCottage'])->name('cottage.rate');
    
    // Tourist spot routes
    Route::post('/tourist-spots/{touristSpot}/rate', [RatingController::class, 'rateTouristSpot'])->name('tourist-spot.rate');
    Route::post('/tourist-spots/{touristSpot}/like', [RatingController::class, 'toggleTouristSpotLike'])->name('tourist-spot.like');
    Route::get('/tourist-spots/{touristSpot}/like-status', [RatingController::class, 'getTouristSpotLikeStatus'])->name('tourist-spot.like-status');
    Route::post('/tourist-spots/{touristSpot}/comment', [RatingController::class, 'commentTouristSpot'])->name('tourist-spot.comment');
    Route::delete('/tourist-spots/comments/{comment}', [RatingController::class, 'deleteTouristSpotComment'])->name('tourist-spot.comment.delete');
    
    // Comment likes and deletes (unified)
    Route::post('/comments/{comment}/like', [RatingController::class, 'toggleCommentLike'])->name('comments.like');
    Route::delete('/comments/{comment}', [RatingController::class, 'deleteCommentUnified'])->name('comments.delete');
});

// --- Dynamic Tourism Pages ---
// Routes moved to public section above

// Auth - Redirect to home page with modals
Route::get('/register', function() { return redirect('/#register'); })->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Authentication Routes - Redirect to home page with modals
Route::get('/login', function() { return redirect('/#login'); })->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/forgot-password', [LoginController::class, 'showLinkRequestForm'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [LoginController::class, 'sendResetLinkEmail'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [LoginController::class, 'showResetForm'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [LoginController::class, 'reset'])
    ->middleware('guest')
    ->name('password.update');

// =========================
// AUTHENTICATED USERS
// =========================

Route::middleware(['auth'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/setup', [ProfileController::class, 'setup'])->name('profile.setup');
    Route::post('/profile/setup', [ProfileController::class, 'store'])->name('profile.store');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    // AJAX profile picture upload
    Route::post('/profile/picture', [ProfileController::class, 'updatePicture'])->name('profile.picture.update');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/account/delete', [ProfileController::class, 'deleteAccount'])->name('account.delete');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Business viewing (accessible by both customers and admins)
    Route::get('/customer/business/{business}', [CustomerController::class, 'showBusiness'])->name('customer.business.show');

    // =========================
    // CUSTOMER ROUTES
    // =========================
    // Feed routes - accessible to authenticated users
    Route::get('/customer/feed', [CustomerController::class, 'getFeedData'])->name('customer.feed');
    Route::get('/customer/products/feed', [ProductController::class, 'getProductsFeedData'])->name('customer.products.feed');
    Route::get('/customer/hotels/feed', [CustomerController::class, 'getHotelsFeedData'])->name('customer.hotels.feed');
    Route::get('/customer/resorts/feed', [CustomerController::class, 'getResortsFeedData'])->name('customer.resorts.feed');
    Route::get('/customer/attractions/feed', [CustomerController::class, 'getAttractionsFeedData'])->name('customer.attractions.feed');
    
    Route::middleware(['role:customer'])->group(function () {
        Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
        // Search
        Route::get('/customer/search', [CustomerController::class, 'search'])->name('customer.search');

        // Use public views for consistent layout (no feeds, simple grid)
        Route::get('/customer/products', [ProductController::class, 'index'])->name('customer.products');
        Route::get('/customer/shops', [ProductController::class, 'shops'])->name('customer.shops');
        Route::get('/customer/shops/{shop}', [ProductController::class, 'showShop'])->name('customer.shops.show');
        Route::get('/customer/hotels', [HotelController::class, 'index'])->name('customer.hotels');
        Route::get('/customer/hotels/{hotel}', [HotelController::class, 'show'])->name('customer.hotels.show');
        Route::get('/customer/resorts', [ResortController::class, 'index'])->name('customer.resorts');
        Route::get('/customer/resorts/{id}', [ResortController::class, 'show'])->name('customer.resorts.show');
        Route::get('/customer/attractions', [AttractionController::class, 'index'])->name('customer.attractions');
        Route::get('/customer/attractions/{id}', [AttractionController::class, 'show'])->name('customer.attractions.show');
        Route::get('/customer/product/{product}', [ProductController::class, 'show'])->name('customer.product.show');

        // Orders
        Route::get('/customer/order-details/{product}', [OrderController::class, 'showOrderDetails'])->name('customer.order.details');
        Route::get('/customer/orders', [OrderController::class, 'myOrders'])->name('customer.orders');
        Route::get('/customer/orders/{order}', [OrderController::class, 'orderDetails'])->name('customer.orders.show');
        Route::post('/customer/orders/{order}/message', [OrderController::class, 'sendMessage'])->name('customer.orders.message');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my');
        Route::delete('/customer/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('customer.orders.cancel');

        // Feedback
        Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

        // Messaging
        Route::get('/customer/messages', [MessageController::class, 'index'])->name('customer.messages');

        // Cart
        Route::get('/cart', [CartController::class, 'index'])->name('customer.cart');
        Route::post('/cart/add', [CartController::class, 'add'])->name('customer.cart.add');
        Route::put('/cart/{cart}', [CartController::class, 'update'])->name('customer.cart.update');
        Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('customer.cart.remove');
        Route::delete('/cart', [CartController::class, 'clear'])->name('customer.cart.clear');
        Route::delete('/cart/clear/{business}', [CartController::class, 'clearByBusiness'])->name('customer.cart.clearByBusiness');
        Route::post('/cart/checkout/{business}', [OrderController::class, 'checkout'])->name('customer.cart.checkout');
    });

    // =========================
    // BUSINESS OWNER ROUTES
    // =========================
    Route::middleware(['role:business_owner'])
        ->prefix('business')
        ->name('business.')
        ->group(function () {
            // Setup routes
            Route::get('/setup', [\App\Http\Controllers\Business\BusinessController::class, 'setup'])->name('setup');
            Route::post('/setup', [\App\Http\Controllers\Business\BusinessController::class, 'storeSetup'])->name('setup.store');
            
            // Main business dashboard
            Route::get('/my-shop', [\App\Http\Controllers\Business\BusinessController::class, 'myShop'])->name('my-shop');
            Route::get('/my-hotel', [\App\Http\Controllers\Business\BusinessController::class, 'myHotel'])->name('my-hotel');
            Route::get('/my-resort', [\App\Http\Controllers\Business\BusinessController::class, 'myResort'])->name('my-resort');
            
            // Products
            Route::get('/products', [ProductController::class, 'index'])->name('products');
            Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
            Route::post('/products', [ProductController::class, 'store'])->name('products.store');
            Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
            Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
            Route::put('/products/{product}/stock', [ProductController::class, 'updateStock'])->name('products.stock.update');
            Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
            
            // Profile routes
            Route::post('/profile/update', [\App\Http\Controllers\Business\BusinessController::class, 'updateProfile'])->name('updateProfile');
            Route::post('/update-profile-avatar', [\App\Http\Controllers\Business\BusinessController::class, 'updateProfileAvatar'])->name('updateProfileAvatar');
            Route::post('/update-avatar', [\App\Http\Controllers\Business\BusinessController::class, 'updateProfileAvatar'])->name('updateAvatar');
            
            // Gallery routes
            Route::post('/gallery', [\App\Http\Controllers\Business\BusinessController::class, 'storeGallery'])->name('gallery.store');
            Route::delete('/gallery/{id}', [\App\Http\Controllers\Business\BusinessController::class, 'destroyGallery'])->name('gallery.destroy');
            
            // Promotion routes
            Route::post('/promotions', [\App\Http\Controllers\Business\BusinessController::class, 'storePromotion'])->name('promotions.store');
            Route::delete('/promotions/{id}', [\App\Http\Controllers\Business\BusinessController::class, 'destroyPromotion'])->name('promotions.destroy');
            
            // Resort Room routes
            Route::post('/rooms', [\App\Http\Controllers\Business\ResortRoomController::class, 'store'])->name('rooms.store');
            Route::get('/rooms/{room}/edit', [\App\Http\Controllers\Business\ResortRoomController::class, 'edit'])->name('rooms.edit');
            Route::put('/rooms/{room}', [\App\Http\Controllers\Business\ResortRoomController::class, 'update'])->name('rooms.update');
            Route::put('/rooms/{room}/availability', [\App\Http\Controllers\Business\ResortRoomController::class, 'toggleAvailability'])->name('rooms.availability');
            Route::delete('/rooms/{room}', [\App\Http\Controllers\Business\ResortRoomController::class, 'destroy'])->name('rooms.destroy');
            
            // Hotel Room routes
            Route::post('/hotel-rooms', [\App\Http\Controllers\Business\HotelRoomController::class, 'store'])->name('hotel.rooms.store');
            Route::get('/hotel-rooms/{hotelRoom}/edit', [\App\Http\Controllers\Business\HotelRoomController::class, 'edit'])->name('hotel.rooms.edit');
            Route::put('/hotel-rooms/{hotelRoom}', [\App\Http\Controllers\Business\HotelRoomController::class, 'update'])->name('hotel.rooms.update');
            Route::delete('/hotel-rooms/{hotelRoom}', [\App\Http\Controllers\Business\HotelRoomController::class, 'destroy'])->name('hotel.rooms.destroy');
            
            // Cottage routes
            Route::post('/cottages', [\App\Http\Controllers\Business\CottageController::class, 'store'])->name('cottages.store');
            Route::get('/cottages/{cottage}/edit', [\App\Http\Controllers\Business\CottageController::class, 'edit'])->name('cottages.edit');
            Route::put('/cottages/{cottage}', [\App\Http\Controllers\Business\CottageController::class, 'update'])->name('cottages.update');
            Route::post('/cottages/{cottage}/toggle', [\App\Http\Controllers\Business\CottageController::class, 'toggleAvailability'])->name('cottages.toggle');
            Route::delete('/cottages/{cottage}', [\App\Http\Controllers\Business\CottageController::class, 'destroy'])->name('cottages.destroy');
            
            // Shop specific routes
            Route::post('/publish-shop', [BusinessController::class, 'publishShop'])->name('publish-shop');
            Route::post('/unpublish-shop', [BusinessController::class, 'unpublishShop'])->name('unpublish-shop');
            
            // Backward compatibility
            Route::post('/publish', [\App\Http\Controllers\Business\BusinessController::class, 'publish'])->name('publish');
            Route::post('/unpublish', [\App\Http\Controllers\Business\BusinessController::class, 'unpublish'])->name('unpublish');

            // Profile picture upload route
            Route::put('/profile/picture', [\App\Http\Controllers\Business\BusinessController::class, 'updateProfilePicture'])->name('profile.updatePicture');
            
            // Common routes for all businesses
            Route::post('/update-cover', [\App\Http\Controllers\Business\BusinessController::class, 'updateCover'])->name('updateCover');
            Route::post('/update-profile-avatar', [\App\Http\Controllers\Business\BusinessController::class, 'updateProfileAvatar'])->name('updateProfileAvatar');
            Route::get('/orders', [OrderController::class, 'businessOrders'])->name('orders');
            Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update.status');
            Route::get('/messages', [MessageController::class, 'indexOwner'])->name('messages');
            Route::post('/gallery/upload', [\App\Http\Controllers\Business\BusinessController::class, 'galleryUpload'])->name('gallery.upload');
            
            // Product management routes
            Route::get('/products', [\App\Http\Controllers\Business\BusinessController::class, 'products'])->name('products');
            Route::get('/products/create', [\App\Http\Controllers\Business\BusinessController::class, 'createProduct'])->name('products.create');
            Route::post('/products', [\App\Http\Controllers\Business\BusinessController::class, 'storeProduct'])->name('products.store');
            Route::put('/products/{product}/stock', [\App\Http\Controllers\Business\BusinessController::class, 'updateProductStock'])->name('products.updateStock');
            Route::delete('/products/{product}', [\App\Http\Controllers\Business\BusinessController::class, 'deleteProduct'])->name('products.destroy');
        });

    // =========================
    // SHARED MESSAGING ROUTES
    // =========================
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::get('/thread/{user}', [MessageController::class, 'thread'])->name('thread');
        Route::post('/send', [MessageController::class, 'send'])->name('send');
    });

    // =========================
    // ADMIN ROUTES
    // =========================
    Route::middleware(['role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            // Business Approvals
            Route::prefix('business-approvals')->name('business-approvals.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Admin\BusinessApprovalController::class, 'index'])->name('index');
                Route::get('/{business}', [\App\Http\Controllers\Admin\BusinessApprovalController::class, 'show'])->name('show');
                Route::post('/{business}/approve', [\App\Http\Controllers\Admin\BusinessApprovalController::class, 'approve'])->name('approve');
                Route::post('/{business}/decline', [\App\Http\Controllers\Admin\BusinessApprovalController::class, 'decline'])->name('decline');
                Route::post('/{business}/toggle-publish', [\App\Http\Controllers\Admin\BusinessApprovalController::class, 'togglePublish'])->name('toggle-publish');
                Route::get('/{business}/download/{type}/{index?}', [\App\Http\Controllers\Admin\BusinessApprovalController::class, 'downloadDocument'])->name('download');
            });
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
            Route::get('/users', [AdminController::class, 'users'])->name('users');
            Route::get('/users/archived', [AdminController::class, 'archivedUsers'])->name('users.archived');
            Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
            
            // Business viewing for admins
            Route::get('/business/{business}', [AdminController::class, 'showBusiness'])->name('business.show');
            Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
            Route::post('/drop-business-owner/{user}', [AdminController::class, 'dropBusinessOwner'])->name('drop.business');
            Route::post('/users/{user}/archive', [AdminController::class, 'archiveUser'])->name('users.archive');
            Route::post('/users/{user}/restore', [AdminController::class, 'restoreUser'])->name('users.restore');

            // Upload Promotion Landing Page
            Route::get('/uploadpromotion', [AdminController::class, 'uploadPromotion'])->name('uploadpromotion');

            // --- HOTELS ---
            Route::get('/upload/hotels', [\App\Http\Controllers\Admin\HotelController::class, 'create'])->name('upload.hotels');
            Route::post('/upload/hotels', [\App\Http\Controllers\Admin\HotelController::class, 'store'])->name('hotels.store');
            Route::get('/hotels', [\App\Http\Controllers\Admin\HotelController::class, 'index'])->name('hotels.index');
            Route::get('/hotels/{hotel}/edit', [\App\Http\Controllers\Admin\HotelController::class, 'edit'])->name('hotels.edit');
            Route::put('/hotels/{hotel}', [\App\Http\Controllers\Admin\HotelController::class, 'update'])->name('hotels.update');
            Route::delete('/hotels/{hotel}', [\App\Http\Controllers\Admin\HotelController::class, 'destroy'])->name('hotels.destroy');

            // --- RESORTS ---
            Route::get('/upload/resorts', [\App\Http\Controllers\Admin\ResortController::class, 'create'])->name('upload.resorts');
            Route::post('/upload/resorts', [\App\Http\Controllers\Admin\ResortController::class, 'store'])->name('resorts.store');
            Route::get('/resorts', [\App\Http\Controllers\Admin\ResortController::class, 'index'])->name('resorts.index');
            Route::get('/resorts/{resort}/edit', [\App\Http\Controllers\Admin\ResortController::class, 'edit'])->name('resorts.edit');
            Route::put('/resorts/{resort}', [\App\Http\Controllers\Admin\ResortController::class, 'update'])->name('resorts.update');
            Route::delete('/resorts/{resort}', [\App\Http\Controllers\Admin\ResortController::class, 'destroy'])->name('resorts.destroy');

            // --- TOURIST SPOTS ---
            Route::get('/upload-spots', [\App\Http\Controllers\AdminController::class, 'uploadSpots'])->name('upload.spots');
            Route::post('/upload-spots', [\App\Http\Controllers\Admin\TouristSpotController::class, 'store'])->name('upload.spots.store');
            Route::post('/upload-spots/gallery', [\App\Http\Controllers\Admin\TouristSpotController::class, 'uploadGallery'])->name('upload.spots.gallery');
            Route::get('/tourist-spots/{touristSpot}/edit', [\App\Http\Controllers\Admin\TouristSpotController::class, 'edit'])->name('tourist.spots.edit');
            Route::put('/tourist-spots/{touristSpot}', [\App\Http\Controllers\Admin\TouristSpotController::class, 'update'])->name('tourist.spots.update');
            Route::post('/tourist-spots/{touristSpot}/gallery/remove', [\App\Http\Controllers\Admin\TouristSpotController::class, 'removeGalleryImage'])->name('tourist.spots.gallery.remove');
            Route::delete('/tourist-spots/{touristSpot}', [\App\Http\Controllers\Admin\TouristSpotController::class, 'destroy'])->name('tourist.spots.destroy');
        });
});

// =========================
// CUSTOMER RESORT AND ATTRACTION ROUTES (moved to public section above)
// =========================

// Legacy tourist spot routes (kept for compatibility)
Route::middleware('auth')->group(function () {
    Route::post('/tourist-spots/{id}/like', [CustomerController::class, 'toggleLike'])->name('tourist-spots.like');
    Route::get('/tourist-spots/{id}/comments', [CustomerController::class, 'getTouristSpotComments'])->name('tourist-spots.comments');
    Route::post('/tourist-spots/{id}/comment', [CustomerController::class, 'commentTouristSpot'])->name('tourist-spots.comment');
});
// Product interaction routes are already defined in the auth middleware group above
