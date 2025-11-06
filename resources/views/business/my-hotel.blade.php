@extends('layouts.app')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<!-- Success/Error Messages -->
@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded mx-4">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded mx-4">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded mx-4">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Declined Business Alert with Re-upload Section -->
@if($businessProfile && $businessProfile->status === 'declined')
    <div class="bg-red-50 border-l-4 border-red-500 p-4 sm:p-6 mb-4 sm:mb-6 rounded-lg shadow-md mx-2 sm:mx-4">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-red-500 text-xl sm:text-2xl"></i>
            </div>
            <div class="ml-3 sm:ml-4 flex-1">
                <h3 class="text-base sm:text-lg font-semibold text-red-800 mb-2">
                    Your Hotel Application Was Declined
                </h3>
                @if($businessProfile->decline_reason)
                    <div class="bg-white border border-red-200 rounded-md p-3 sm:p-4 mb-3 sm:mb-4">
                        <p class="text-xs sm:text-sm font-medium text-red-700 mb-1">Reason for Decline:</p>
                        <p class="text-xs sm:text-sm text-gray-700 break-words">{{ $businessProfile->decline_reason }}</p>
                    </div>
                @endif
                <p class="text-xs sm:text-sm text-red-700 mb-3 sm:mb-4">
                    Please review the reason above and update your business permit documents to resubmit for approval.
                </p>
                
                <!-- Business Permit Re-upload Form -->
                <div class="bg-white border border-red-200 rounded-lg p-3 sm:p-4">
                    <h4 class="text-xs sm:text-sm font-semibold text-gray-800 mb-2 sm:mb-3">Update Business Permit</h4>
                    <form action="{{ route('business.updateProfile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Upload New Business Permit(s) <span class="text-red-500">*</span>
                                </label>
                                <input type="file" 
                                       name="business_permit[]" 
                                       multiple 
                                       accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                       required>
                                <p class="mt-1 text-xs text-gray-500">
                                    Accepted formats: PDF, JPG, PNG, DOC, DOCX (Max 5MB per file)
                                </p>
                            </div>
                            
                            <!-- Current Business Permit Display -->
                            @if(!empty($businessProfile->business_permit_path))
                                <div class="mt-3">
                                    <p class="text-xs font-medium text-gray-700 mb-2">Current Business Permit(s):</p>
                                    <div class="space-y-1">
                                        @foreach($businessProfile->business_permit_path as $index => $permit)
                                            <div class="flex items-center text-xs text-gray-600">
                                                <i class="fas fa-file-alt mr-2 text-gray-400"></i>
                                                <span>Permit {{ $index + 1 }}: {{ basename($permit) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 pt-2">
                                <button type="submit" 
                                        class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-xs sm:text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-upload mr-2"></i>
                                    Resubmit for Approval
                                </button>
                                <p class="text-xs text-gray-500 text-center sm:text-left">
                                    Your hotel will be reviewed again after resubmission
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Hero Banner Section with Dynamic Background -->
<div class="w-full h-64 relative bg-gray-200"
     id="cover-banner"
     @if($businessProfile && $businessProfile->cover_image)
         style="background-image: url('{{ Storage::url($businessProfile->cover_image) }}?v={{ time() }}'); background-size: cover; background-position: center;"
     @endif>
     
    <!-- Cover Photo Upload Form -->
    <div class="absolute top-20 right-4 z-40">
        <form action="{{ route('business.updateCover') }}" method="POST" enctype="multipart/form-data" class="inline">
            @csrf
            <label class="bg-white bg-opacity-90 text-gray-700 px-4 py-2 rounded-lg hover:bg-opacity-100 transition-all duration-200 flex items-center text-sm font-medium cursor-pointer shadow-lg">
                <i class="fas fa-camera mr-2"></i> Edit Cover Image
                <input type="file" name="cover_image" accept="image/jpeg,image/jpg,image/png" class="hidden" onchange="validateAndSubmitCoverImage(this)">
            </label>
        </form>
    </div>
</div>

<!-- Main Content Section -->
<div class="bg-gray-100 pb-8 min-h-[calc(100vh-16rem)]">
    <div class="w-full max-w-7xl mx-auto px-4 -mt-12 md:-mt-16 lg:-mt-20 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Side - Profile and Hotel Info -->
            <div class="lg:col-span-1">
                <!-- Profile Photo Section -->
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-6 relative">
                    <div class="text-center">
                        <div class="relative w-32 h-32 mx-auto">
                            <div class="w-full h-full border-4 border-white rounded-full flex items-center justify-center cursor-pointer hover:bg-gray-50 transition-all duration-200 shadow-lg overflow-hidden"
                                 onclick="document.getElementById('profile-photo').click()">
                                @if($businessProfile && $businessProfile->profile_avatar)
                                    <img src="{{ Storage::url($businessProfile->profile_avatar) }}?v={{ time() }}" 
                                         alt="{{ $businessProfile->business_name }}" 
                                         class="w-full h-full object-cover profile-photo">
                                @else
                                    <div class="w-full h-full bg-green-600 flex items-center justify-center">
                                        <i class="fas fa-hotel text-white text-4xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="absolute -bottom-2 -right-2 bg-white rounded-full p-2 shadow-md">
                                <i class="fas fa-camera text-green-600 text-sm"></i>
                            </div>
                        </div>
                        <input type="file" id="profile-photo" class="hidden" accept="image/jpeg,image/jpg,image/png" onchange="uploadProfilePhoto(this)">

                        <!-- Hotel Name -->
                        <h1 class="text-3xl font-bold text-gray-800 mt-4 mb-3">
                            {{ $businessProfile ? $businessProfile->business_name : 'Hotel Name' }}
                        </h1>

                        <!-- Availability Status -->
                        <div class="mb-4">
                            <div class="inline-flex items-center px-3 py-1 rounded-full 
                                {{ $business && $business->is_published ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <div class="w-2 h-2 rounded-full mr-2 
                                    {{ $business && $business->is_published ? 'bg-green-500' : 'bg-red-500' }}"></div>
                                <span class="text-sm font-medium">
                                    {{ $business && $business->is_published ? 'Available Now' : 'Not Available' }}
                                </span>
                            </div>
                        </div>

                        <!-- Hotel Info -->
                        <div class="space-y-3 text-left">
                            @if($business && $business->address)
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-map-marker-alt w-5 text-gray-400 mr-3"></i>
                                    <span class="text-sm">{{ $business->address }}</span>
                                </div>
                            @endif
                            @if($business && $business->contact_number)
                                <div class="flex items-center text-gray-600 mb-1">
                                    <i class="fas fa-phone w-5 text-gray-400 mr-3"></i>
                                    <span class="text-sm">{{ $business->contact_number }}</span>
                                </div>
                                <!-- Star Rating -->
                                <div class="flex items-center text-yellow-400 mb-2 ml-8">
                                    @php
                                        $rating = $business->average_rating ?? 0;
                                        $fullStars = floor($rating);
                                        $hasHalfStar = $rating - $fullStars >= 0.5;
                                        $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                                    @endphp
                                    @for($i = 0; $i < $fullStars; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                    @if($hasHalfStar)
                                        <i class="fas fa-star-half-alt"></i>
                                    @endif
                                    @for($i = 0; $i < $emptyStars; $i++)
                                        <i class="far fa-star"></i>
                                    @endfor
                                    <span class="text-gray-600 text-sm ml-2">({{ number_format($rating, 1) }})</span>
                                </div>
                            @endif
                        </div>

                        <!-- Publish/Unpublish Buttons -->
                        <div class="mt-6 flex flex-wrap gap-2 justify-center">
                            @if($business && $business->status === 'approved')
                                @if($business->is_published)
                                    <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-medium">Published</span>
                                    <form action="{{ route('business.unpublish') }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-yellow-600 transition-colors">
                                            Unpublish
                                        </button>
                                    </form>
                                @else
                                    <span class="bg-gray-100 text-gray-800 px-4 py-2 rounded-full text-sm font-medium">Unpublished</span>
                                    <form action="{{ route('business.publish') }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700 transition-colors">
                                            Publish
                                        </button>
                                    </form>
                                @endif
                            @elseif($business && $business->status === 'pending')
                                <span class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full text-sm font-medium">Pending Approval</span>
                                <p class="text-gray-500 text-xs mt-2 w-full text-center">Your hotel is awaiting admin approval</p>
                            @else
                                <form action="{{ route('business.publish') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition-colors">
                                        Publish Now
                                    </button>
                                </form>
                                <p class="text-gray-500 text-xs mt-2 w-full text-center">Submit your hotel for admin approval</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Hotel Statistics</h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="p-2 bg-green-100 rounded-lg mr-3">
                                <i class="fas fa-eye text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Profile Views</p>
                                <p class="font-semibold">0</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="p-2 bg-purple-100 rounded-lg mr-3">
                                <i class="fas fa-star text-purple-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Average Rating</p>
                                <div class="flex items-center">
                                    @php
                                        $avgRating = $business->average_rating ?? 0;
                                        $fullStars = floor($avgRating);
                                        $hasHalfStar = $avgRating - $fullStars >= 0.5;
                                    @endphp
                                    @for($i = 0; $i < $fullStars; $i++)
                                        <i class="fas fa-star text-yellow-400 text-sm"></i>
                                    @endfor
                                    @if($hasHalfStar)
                                        <i class="fas fa-star-half-alt text-yellow-400 text-sm"></i>
                                    @endif
                                    @for($i = 0; $i < (5 - $fullStars - ($hasHalfStar ? 1 : 0)); $i++)
                                        <i class="far fa-star text-yellow-400 text-sm"></i>
                                    @endfor
                                    <span class="ml-1 text-sm text-gray-600">({{ number_format($avgRating, 1) }})</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Side - Dashboard Content -->
            <div class="lg:col-span-2">
                <!-- Stats Overview -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Rooms</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $totalRooms }}</p>
                                <p class="text-xs text-gray-500">Rooms available</p>
                            </div>
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <i class="fas fa-door-open text-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Available Rooms</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $availableRooms }}</p>
                                <p class="text-xs text-gray-500">Available rooms</p>
                            </div>
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <i class="fas fa-bed text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rooms Management -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Rooms</h3>
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="resetRoomForm(); openModal('addRoomModal')" class="inline-flex items-center px-3 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700">
                                <i class="fas fa-plus mr-1"></i> Add Room
                            </button>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($rooms as $room)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    @if($room->image)
                                                        <img class="h-10 w-10 rounded-md object-cover" src="{{ Storage::url($room->image) }}" alt="Room {{ $room->room_number }}">
                                                    @else
                                                        <div class="h-10 w-10 rounded-md bg-gray-200 flex items-center justify-center">
                                                            <i class="fas fa-bed text-gray-400"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">Room {{ $room->room_number }}</div>
                                                    <div class="text-sm text-gray-500">{{ $room->capacity }} guests</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ ucfirst($room->room_type) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            ₱{{ number_format($room->price_per_night, 2) }}<span class="text-gray-500 text-xs">/night</span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <div class="max-w-xs truncate">
                                                {{ $room->description ?: 'No description available' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button onclick="editHotelRoom({{ $room->id }})" class="text-blue-600 hover:text-blue-900 mr-3 font-medium">
                                                <i class="fas fa-edit mr-1"></i>Edit
                                            </button>
                                            <button onclick="deleteHotelRoom({{ $room->id }})" class="text-red-600 hover:text-red-900 font-medium">
                                                <i class="fas fa-trash mr-1"></i>Delete
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                            No rooms added yet. Add your first room to get started.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Gallery Management -->
                <div class="bg-white rounded-2xl shadow-lg p-6 mt-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Gallery</h3>
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="openModal('galleryModal')" class="inline-flex items-center px-3 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700">
                                <i class="fas fa-plus mr-1"></i> Add Photos
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @forelse($galleries ?? [] as $image)
                            <div class="relative group">
                                <img src="{{ Storage::url($image->image_path) }}" alt="Gallery Image" class="w-full h-32 object-cover rounded-lg hover:shadow-md transition-shadow cursor-pointer"
                                     onclick="openImageModal('{{ Storage::url($image->image_path) }}')">
                                <button type="button" onclick="deleteGalleryImage({{ $image->id }})" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8 text-gray-500">
                                <i class="fas fa-images text-4xl mb-4"></i>
                                <p class="text-gray-500">No gallery images yet. Add some photos to showcase your hotel!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Add Promotion Modal -->
<div id="addPromotionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-[60] flex items-center justify-center pt-20">
    <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[80vh] overflow-y-auto mx-4">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-900">Add New Promotion</h3>
                <button type="button" onclick="closeModal('addPromotionModal')" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form action="{{ route('business.promotions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-6">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="promotion_title" class="block text-sm font-medium text-gray-700">Promotion Title</label>
                            <input type="text" name="title" id="promotion_title" required
                                   placeholder="e.g., Summer Special 50% Off"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                        </div>
                        
                        <div>
                            <label for="promotion_description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="promotion_description" rows="3" required
                                      placeholder="Describe your promotion details, terms and conditions..."
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"></textarea>
                        </div>
                        
                        <div>
                            <label for="promotion_image" class="block text-sm font-medium text-gray-700">Promotion Image</label>
                            <input type="file" name="image" id="promotion_image" accept="image/jpeg,image/jpg,image/png" onchange="validatePromotionImage(this)" required
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                            <p class="mt-1 text-sm text-gray-500">Upload an attractive image for your promotion</p>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                        <button type="button" onclick="closeModal('addPromotionModal')" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Create Promotion
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Room Modal -->
<div id="addRoomModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-[60] flex items-center justify-center pt-20">
    <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[80vh] overflow-y-auto mx-4">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 id="roomModalTitle" class="text-xl font-semibold text-gray-900">Add New Room</h3>
                <button type="button" onclick="closeModal('addRoomModal')" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="roomForm" action="{{ route('business.hotel.rooms.store') }}" method="POST" enctype="multipart/form-data" onsubmit="submitRoomForm(event)">
                @csrf
                <input type="hidden" id="roomId" name="roomId" value="">
                <input type="hidden" id="_method" name="_method" value="POST">
                <div class="space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="room_number" class="block text-sm font-medium text-gray-700">Room Number</label>
                            <input type="text" name="room_number" id="room_number" required
                                   placeholder="e.g., 101, A-1, Deluxe-1"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                        </div>
                        
                        <div>
                            <label for="room_type" class="block text-sm font-medium text-gray-700">Room Type</label>
                            <select name="room_type" id="room_type" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                                <option value="">Select room type</option>
                                <option value="standard">Standard Room</option>
                                <option value="deluxe">Deluxe Room</option>
                                <option value="suite">Suite</option>
                                <option value="family">Family Room</option>
                                <option value="presidential">Presidential Suite</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="room_price" class="block text-sm font-medium text-gray-700">Price per Night (₱)</label>
                            <input type="number" name="price_per_night" id="room_price" step="0.01" min="0" required
                                   placeholder="2500.00"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                        </div>
                        
                        <div>
                            <label for="room_capacity" class="block text-sm font-medium text-gray-700">Guest Capacity</label>
                            <input type="number" name="capacity" id="room_capacity" min="1" max="20" required
                                   placeholder="2"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                        </div>
                        
                        <div class="col-span-2">
                            <label for="room_description" class="block text-sm font-medium text-gray-700">Room Description</label>
                            <textarea name="description" id="room_description" rows="3" required
                                      placeholder="Describe the room features, amenities, and what makes it special..."
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"></textarea>
                        </div>
                        
                        <div class="col-span-2">
                            <label for="room_amenities" class="block text-sm font-medium text-gray-700">Amenities</label>
                            <input type="text" name="amenities" id="room_amenities"
                                   placeholder="e.g., WiFi, Air Conditioning, TV, Mini Bar, Ocean View"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                            <p class="mt-1 text-sm text-gray-500">Separate amenities with commas</p>
                        </div>
                        
                        <div class="col-span-2">
                            <label for="room_image" class="block text-sm font-medium text-gray-700">Room Image</label>
                            <input type="file" name="image" id="room_image" accept="image/jpeg,image/jpg,image/png" onchange="previewRoomImages(this)"
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                            <div id="imagePreviews" class="mt-2 grid grid-cols-4 gap-2"></div>
                            <p class="mt-1 text-sm text-gray-500">Upload an image to showcase your room</p>
                        </div>
                        
                    </div>
                    
                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                        <button type="button" onclick="closeModal('addRoomModal')" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Cancel
                        </button>
                        <button type="submit" id="roomSubmitBtn" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Add Room
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Gallery Modal -->
<div id="galleryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-[60] flex items-center justify-center pt-20">
    <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-900">Add Photos to Gallery</h3>
                <button type="button" onclick="closeModal('galleryModal')" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form action="{{ route('business.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Upload Photos</label>
                    <div class="mt-2 flex items-center">
                        <input type="file" name="images[]" id="galleryImages" multiple accept="image/jpeg,image/jpg,image/png" class="hidden" onchange="previewGalleryImages(this)">
                        <label for="galleryImages" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-upload mr-2"></i> Select Files
                        </label>
                        <span id="fileNames" class="ml-4 text-sm text-gray-500">No files selected</span>
                    </div>
                    <div id="galleryPreviews" class="mt-4 grid grid-cols-3 gap-2"></div>
                    <p class="mt-2 text-xs text-gray-500">Upload up to 10 images at once (JPG, PNG, max 10MB each)</p>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeModal('galleryModal')" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Upload Photos
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Gallery Image Confirmation Modal -->
<div id="deleteGalleryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                Confirm Delete
            </h3>
            <button onclick="closeDeleteGalleryModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="mb-6">
            <p class="text-gray-600 mb-2">Are you sure you want to delete this gallery image?</p>
            <p class="text-sm text-red-600 mt-3">
                <i class="fas fa-info-circle mr-1"></i>
                This action cannot be undone.
            </p>
        </div>
        
        <div class="flex space-x-3">
            <button type="button" onclick="closeDeleteGalleryModal()" 
                    class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                Cancel
            </button>
            <button type="button" onclick="confirmDeleteGalleryImage()" 
                    class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                <i class="fas fa-trash mr-2"></i>Delete
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    
    function resetRoomForm() {
        document.getElementById('roomModalTitle').textContent = 'Add New Room';
        document.getElementById('roomSubmitBtn').textContent = 'Add Room';
        document.getElementById('roomId').value = '';
        document.getElementById('_method').value = 'POST';
        document.getElementById('roomForm').action = '{{ route("business.hotel.rooms.store") }}';
        document.getElementById('roomForm').reset();
        document.getElementById('imagePreviews').innerHTML = '';
    }
    
    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        if (modalId === 'addRoomModal') {
            resetRoomForm();
        }
    }
    
    function submitRoomForm(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        const url = form.action;
        const method = form.querySelector('input[name="_method"]') ? form.querySelector('input[name="_method"]').value : 'POST';

        // Show loading state
        const submitButton = form.querySelector('button[type="submit"]');
        const originalButtonText = submitButton.innerHTML;
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Saving...';

        fetch(url, {
            method: method === 'PUT' ? 'POST' : 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                alert('Room saved successfully!');
                // Close modal and refresh the page
                closeModal('addRoomModal');
                window.location.reload();
            } else {
                // Show error message
                alert('Error: ' + (data.message || 'Failed to save room'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error saving room. Please try again.');
        })
        .finally(() => {
            // Restore button state
            submitButton.disabled = false;
            submitButton.innerHTML = originalButtonText;
        });
    }
    
    function previewRoomImages(input) {
        const previewContainer = document.getElementById('imagePreviews');
        const maxSize = 10 * 1024 * 1024; // 10MB
        previewContainer.innerHTML = '';
        
        if (input.files.length > 0) {
            // Validate file sizes
            for (let i = 0; i < input.files.length; i++) {
                if (input.files[i].size > maxSize) {
                    alert('One or more images exceed 10MB. Please select images smaller than 10MB.');
                    input.value = ''; // Clear the input
                    return;
                }
            }
            
            for (let i = 0; i < input.files.length; i++) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.createElement('div');
                    preview.className = 'relative group';
                    preview.innerHTML = `
                        <img src="${e.target.result}" class="h-16 w-16 object-cover rounded-md">
                        <button type="button" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100" onclick="this.parentElement.remove(); updateFileInput(input, ${i})">
                            ×
                        </button>
                    `;
                    previewContainer.appendChild(preview);
                };
                reader.readAsDataURL(input.files[i]);
            }
        }
    }
    
    function previewGalleryImages(input) {
        const fileNames = [];
        const previewContainer = document.getElementById('galleryPreviews');
        const maxSize = 10 * 1024 * 1024; // 10MB
        previewContainer.innerHTML = '';
        
        if (input.files.length > 0) {
            let validFiles = [];
            let hasOversizedFile = false;
            
            // Validate file sizes
            for (let i = 0; i < input.files.length; i++) {
                if (input.files[i].size > maxSize) {
                    hasOversizedFile = true;
                } else {
                    validFiles.push(input.files[i]);
                }
            }
            
            // Show alert if any file exceeds 10MB
            if (hasOversizedFile) {
                alert('One or more images exceed 10MB. Please select images smaller than 10MB.');
                input.value = ''; // Clear the input
                document.getElementById('fileNames').textContent = 'No files selected';
                return;
            }
            
            for (let i = 0; i < Math.min(validFiles.length, 10); i++) {
                fileNames.push(validFiles[i].name);
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.createElement('div');
                    preview.className = 'relative group';
                    preview.innerHTML = `
                        <img src="${e.target.result}" class="h-24 w-full object-cover rounded-md">
                    `;
                    previewContainer.appendChild(preview);
                };
                reader.readAsDataURL(validFiles[i]);
            }
            
            document.getElementById('fileNames').textContent = `${fileNames.length} file(s) selected`;
        } else {
            document.getElementById('fileNames').textContent = 'No files selected';
        }
    }
    
    function updateFileInput(input, indexToRemove) {
        const dt = new DataTransfer();
        const { files } = input;
        
        for (let i = 0; i < files.length; i++) {
            if (i !== indexToRemove) {
                dt.items.add(files[i]);
            }
        }
        
        input.files = dt.files;
    }
    
    function editHotelRoom(roomId) {
        fetch(`/business/hotel-rooms/${roomId}/edit`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success === false) {
                alert('Error: ' + data.message);
                return;
            }
            
            console.log('Edit room data received:', data); // Debug log
            
            // Reset form and update modal for edit mode (like resort)
            resetRoomForm();
            document.getElementById('roomModalTitle').textContent = 'Edit Room';
            document.getElementById('roomSubmitBtn').textContent = 'Update Room';
            document.getElementById('roomId').value = data.id;
            document.getElementById('_method').value = 'PUT';
            document.getElementById('roomForm').action = `/business/hotel-rooms/${data.id}`;
            
            console.log('Form action set to:', document.getElementById('roomForm').action); // Debug log
            
            // Populate form fields
            document.getElementById('room_number').value = data.room_number || '';
            document.getElementById('room_type').value = data.room_type || '';
            document.getElementById('room_price').value = data.price_per_night || '';
            document.getElementById('room_capacity').value = data.capacity || '';
            document.getElementById('room_description').value = data.description || '';
            document.getElementById('room_amenities').value = data.amenities || '';
            
            // Show modal
            openModal('addRoomModal');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading room data. Please try again.');
        });
    }
    
    function deleteHotelRoom(roomId) {
        // Get room number for confirmation
        const roomRow = event.target.closest('tr');
        const roomName = roomRow.querySelector('td:first-child .text-sm.font-medium').textContent;
        
        if (confirm(`Are you sure you want to delete ${roomName}? This action cannot be undone.`)) {
            // Show loading state
            const deleteButton = event.target;
            const originalText = deleteButton.textContent;
            deleteButton.textContent = 'Deleting...';
            deleteButton.style.pointerEvents = 'none';
            
            fetch(`/business/hotel-rooms/${roomId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message and reload
                    alert('Room deleted successfully!');
                    window.location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Failed to delete room'));
                    // Restore button state
                    deleteButton.textContent = originalText;
                    deleteButton.style.pointerEvents = 'auto';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error deleting room. Please try again.');
                // Restore button state
                deleteButton.textContent = originalText;
                deleteButton.style.pointerEvents = 'auto';
            });
        }
    }
    
    function editRoom(roomId) {
        // Fetch room data and populate the form
        fetch(`/business/rooms/${roomId}/edit`)
            .then(response => response.json())
            .then(room => {
                // Populate form fields
                document.getElementById('roomForm').action = `/business/rooms/${roomId}`;
                
                // Add method spoofing for PUT request
                let methodInput = document.getElementById('roomForm').querySelector('input[name="_method"]');
                if (!methodInput) {
                    methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'PUT';
                    document.getElementById('roomForm').appendChild(methodInput);
                } else {
                    methodInput.value = 'PUT';
                }
                
                document.getElementById('room_name').value = room.name;
                document.getElementById('room_type').value = room.room_type || 'standard';
                document.getElementById('room_price').value = room.price_per_night;
                document.getElementById('room_capacity').value = room.capacity;
                document.getElementById('room_description').value = room.description;
                
                // Update modal title and button text for editing
                document.getElementById('roomModalTitle').textContent = 'Edit Room';
                document.getElementById('roomSubmitBtn').textContent = 'Update Room';
                
                // Show existing images
                const previewContainer = document.getElementById('imagePreviews');
                if (previewContainer) {
                    previewContainer.innerHTML = '';
                    
                    if (room.images && room.images.length > 0) {
                        room.images.forEach(image => {
                            const preview = document.createElement('div');
                            preview.className = 'relative group';
                            preview.innerHTML = `
                                <img src="${image.path}" class="h-16 w-16 object-cover rounded-md">
                                <input type="hidden" name="existing_images[]" value="${image.id}">
                                <button type="button" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100" onclick="this.parentElement.remove();">
                                    ×
                                </button>
                            `;
                            previewContainer.appendChild(preview);
                        });
                    }
                }
                
                // Open the modal without resetting
                document.getElementById('addRoomModal').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            })
            .catch(error => console.error('Error fetching room data:', error));
    }
    
    function deleteRoom(roomId) {
        if (confirm('Are you sure you want to delete this room? This action cannot be undone.')) {
            fetch(`/business/rooms/${roomId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Failed to delete room');
                }
            })
            .then(data => {
                if (data.success) {
                    alert('Room deleted successfully!');
                    window.location.reload();
                } else {
                    alert('Failed to delete room. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error deleting room:', error);
                alert('Failed to delete room. Please try again.');
            });
        }
    }
    
    function deleteImage(imageId) {
        if (confirm('Are you sure you want to delete this image?')) {
            fetch(`/business/gallery/${imageId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert('Failed to delete image. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error deleting image:', error);
                alert('An error occurred while deleting the image.');
            });
        }
    }
    
    function uploadProfilePhoto(input) {
        if (input.files && input.files[0]) {
            const formData = new FormData();
            formData.append('profile_avatar', input.files[0]);

            fetch('{{ route("business.updateAvatar") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Update the profile picture in the navigation bar and dashboard
                    const navProfileImg = document.querySelector('.user-profile-image');
                    const profileImg = document.querySelector('.profile-photo');
                    const timestamp = new Date().getTime();
                    const newSrc = data.url + '?t=' + timestamp;
                    
                    if (navProfileImg) navProfileImg.src = newSrc;
                    if (profileImg) profileImg.src = newSrc;
                    
                    // Show success message
                    alert('Profile picture updated successfully!');
                    
                    // Reload page to show updated image
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    throw new Error(data.message || 'Failed to update profile picture');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating profile picture: ' + (error.message || 'Unknown error occurred'));
            });
        }
    }

    // Delete gallery image function
    let galleryImageToDelete = null;
    
    function deleteGalleryImage(imageId) {
        galleryImageToDelete = imageId;
        document.getElementById('deleteGalleryModal').classList.remove('hidden');
    }
    
    function closeDeleteGalleryModal() {
        document.getElementById('deleteGalleryModal').classList.add('hidden');
        galleryImageToDelete = null;
    }
    
    function confirmDeleteGalleryImage() {
        if (galleryImageToDelete) {
            fetch(`/business/gallery/${galleryImageToDelete}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeDeleteGalleryModal();
                    location.reload();
                } else {
                    alert('Error deleting image: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error deleting image');
            });
        }
    }

    function validateAndSubmitCoverImage(input) {
        const maxSize = 10 * 1024 * 1024; // 10MB
        
        if (input.files && input.files[0]) {
            if (input.files[0].size > maxSize) {
                alert('Image exceeds 10MB. Please select an image smaller than 10MB.');
                input.value = '';
                return false;
            }
            input.form.submit();
        }
    }
    
    function uploadProfilePhoto(input) {
        const maxSize = 10 * 1024 * 1024; // 10MB
        
        if (input.files && input.files[0]) {
            if (input.files[0].size > maxSize) {
                alert('Image exceeds 10MB. Please select an image smaller than 10MB.');
                input.value = '';
                return false;
            }
            
            const formData = new FormData();
            formData.append('profile_avatar', input.files[0]);
            formData.append('_token', '{{ csrf_token() }}');
            
            fetch('{{ route("business.updateProfileAvatar") }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error uploading profile photo: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error uploading profile photo');
            });
        }
    }
    
    function validatePromotionImage(input) {
        const maxSize = 10 * 1024 * 1024; // 10MB
        
        if (input.files && input.files[0]) {
            if (input.files[0].size > maxSize) {
                alert('Image exceeds 10MB. Please select an image smaller than 10MB.');
                input.value = '';
                return false;
            }
        }
        return true;
    }

    // Gallery preview function
    function previewGalleryImages(input) {
        const previewContainer = document.getElementById('galleryPreviews');
        const fileNames = document.getElementById('fileNames');
        
        previewContainer.innerHTML = '';
        
        if (input.files && input.files.length > 0) {
            fileNames.textContent = `${input.files.length} file(s) selected`;
            
            Array.from(input.files).forEach((file, index) => {
                if (index < 10) { // Limit to 10 previews
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative';
                        div.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-full h-20 object-cover rounded-lg">`;
                        previewContainer.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                }
            });
        } else {
            fileNames.textContent = 'No files selected';
        }
    }
    
</script>
@endpush
