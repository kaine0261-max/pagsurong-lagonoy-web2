@extends(auth()->check() && auth()->user()->role === 'customer' ? 'layouts.customer' : 'layouts.public')

@section('title', $resort->business_name ?? $resort->name)

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-6xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8 py-4 sm:py-6">
        <div class="bg-white rounded-lg sm:rounded-xl shadow overflow-hidden">
            <!-- Cover Image -->
            @if($resort->cover_image)
                <img src="{{ Storage::url($resort->cover_image) }}" class="w-full h-48 sm:h-56 md:h-64 object-cover" alt="{{ $resort->business_name ?? $resort->name }}">
            @endif

            <!-- Resort Info -->
            <div class="p-4 sm:p-5 md:p-6">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">{{ $resort->business_name ?? $resort->name }}</h1>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    @if($resort->address)
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-map-marker-alt mr-2 text-green-600"></i>
                            <span>{{ $resort->address }}</span>
                        </div>
                    @endif

                    @if($resort->contact_number)
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-phone mr-2 text-green-600"></i>
                            <span>{{ $resort->contact_number }}</span>
                        </div>
                    @endif

                    @if($resort->email)
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-envelope mr-2 text-green-600"></i>
                            <span>{{ $resort->email }}</span>
                        </div>
                    @endif

                    @if($resort->website)
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-globe mr-2 text-green-600"></i>
                            <a href="{{ $resort->website }}" target="_blank" class="text-green-600 hover:underline">Visit Website</a>
                        </div>
                    @endif
                </div>

                @if($resort->description)
                    <div class="mt-4 sm:mt-6">
                        <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2">About This Resort</h2>
                        <p class="text-sm sm:text-base text-gray-700 leading-relaxed">{{ $resort->description }}</p>
                    </div>
                @endif
            </div>

            <!-- Rooms Section -->
            <div class="px-3 sm:px-4 md:px-6 pb-4 sm:pb-6">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-3 sm:mb-4">Resort Rooms</h2>
                @if($resort->resortRooms && $resort->resortRooms->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 md:gap-6">
                        @foreach($resort->resortRooms as $room)
                            <div class="border border-gray-200 rounded-lg overflow-hidden bg-white hover:shadow-lg transition-shadow">
                                @if($room->images && $room->images->count() > 0)
                                    <div class="relative h-36 sm:h-40 md:h-48 overflow-hidden">
                                        <img src="{{ Storage::url($room->images->first()->image_path) }}" 
                                             class="w-full h-full object-cover" 
                                             alt="{{ $room->name }}">
                                        @if($room->images->count() > 1)
                                            <div class="absolute bottom-2 right-2 bg-black bg-opacity-70 text-white px-1.5 sm:px-2 py-0.5 sm:py-1 rounded text-xs">
                                                <i class="fas fa-images mr-1"></i><span class="hidden sm:inline">{{ $room->images->count() }} photos</span><span class="sm:hidden">{{ $room->images->count() }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="h-36 sm:h-40 md:h-48 bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-bed text-gray-400 text-2xl sm:text-3xl md:text-4xl"></i>
                                    </div>
                                @endif
                                <div class="p-3 sm:p-4">
                                    <h3 class="font-bold text-base sm:text-lg text-gray-900 mb-1">{{ $room->name }}</h3>
                                    @if($room->room_type)
                                        <p class="text-xs sm:text-sm text-green-600 font-medium mb-2">{{ ucfirst($room->room_type) }}</p>
                                    @endif
                                    @if($room->description)
                                        <p class="text-xs sm:text-sm text-gray-600 mb-2 sm:mb-3 line-clamp-2">{{ Str::limit($room->description, 80) }}</p>
                                    @endif
                                    <div class="flex items-center justify-between mb-2 sm:mb-3">
                                        <p class="text-xl sm:text-2xl font-bold text-green-600">₱{{ number_format($room->price_per_night, 2) }}</p>
                                        <span class="text-xs sm:text-sm text-gray-500">/night</span>
                                    </div>
                                    <div class="flex items-center gap-2 sm:gap-4 text-xs sm:text-sm text-gray-600 mb-2 sm:mb-3">
                                        @if($room->capacity)
                                            <span><i class="fas fa-users mr-1"></i>{{ $room->capacity }}</span>
                                        @endif
                                        @if($room->beds)
                                            <span><i class="fas fa-bed mr-1"></i>{{ $room->beds }} bed(s)</span>
                                        @endif
                                        @if($room->bathrooms)
                                            <span><i class="fas fa-bath mr-1"></i>{{ $room->bathrooms }}</span>
                                        @endif
                                    </div>
                                    <button onclick="openRoomModal({{ $room->id }})" 
                                            class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-3 sm:px-4 rounded-lg transition-colors text-sm sm:text-base">
                                        <i class="fas fa-info-circle mr-1 sm:mr-2"></i><span class="hidden sm:inline">View Details</span><span class="sm:hidden">Details</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-50 rounded-lg p-6 sm:p-8 text-center">
                        <i class="fas fa-bed text-gray-400 text-3xl sm:text-4xl mb-3"></i>
                        <p class="text-sm sm:text-base text-gray-500">No rooms available yet.</p>
                    </div>
                @endif
            </div>

            <!-- Cottages Section -->
            @if($resort->cottages && $resort->cottages->count() > 0)
                <div class="px-3 sm:px-4 md:px-6 pb-4 sm:pb-6">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-3 sm:mb-4">Resort Cottages</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 md:gap-6">
                        @foreach($resort->cottages as $cottage)
                            <div class="border border-gray-200 rounded-lg overflow-hidden bg-white hover:shadow-lg transition-shadow">
                                @if($cottage->galleries && $cottage->galleries->count() > 0)
                                    <div class="relative h-36 sm:h-40 md:h-48 overflow-hidden">
                                        <img src="{{ Storage::url($cottage->galleries->first()->image_path) }}" 
                                             class="w-full h-full object-cover" 
                                             alt="{{ $cottage->cottage_name }}">
                                        @if($cottage->galleries->count() > 1)
                                            <div class="absolute bottom-2 right-2 bg-black bg-opacity-70 text-white px-1.5 sm:px-2 py-0.5 sm:py-1 rounded text-xs">
                                                <i class="fas fa-images mr-1"></i><span class="hidden sm:inline">{{ $cottage->galleries->count() }} photos</span><span class="sm:hidden">{{ $cottage->galleries->count() }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="h-36 sm:h-40 md:h-48 bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-home text-gray-400 text-2xl sm:text-3xl md:text-4xl"></i>
                                    </div>
                                @endif
                                <div class="p-3 sm:p-4">
                                    <h3 class="font-bold text-base sm:text-lg text-gray-900 mb-2">{{ $cottage->cottage_name ?? $cottage->cottage_type }}</h3>
                                    @if($cottage->description)
                                        <p class="text-xs sm:text-sm text-gray-600 mb-2 sm:mb-3 line-clamp-2">{{ Str::limit($cottage->description, 80) }}</p>
                                    @endif
                                    <div class="flex items-center justify-between mb-2 sm:mb-3">
                                        <p class="text-xl sm:text-2xl font-bold text-green-600">₱{{ number_format($cottage->price_per_night, 2) }}</p>
                                        <span class="text-xs sm:text-sm text-gray-500">/night</span>
                                    </div>
                                    @if($cottage->capacity)
                                        <div class="flex items-center text-xs sm:text-sm text-gray-600 mb-2 sm:mb-3">
                                            <i class="fas fa-users mr-1 sm:mr-2"></i>
                                            <span class="hidden sm:inline">Up to {{ $cottage->capacity }} guests</span>
                                            <span class="sm:hidden">{{ $cottage->capacity }} guests</span>
                                        </div>
                                    @endif
                                    <button onclick="openCottageModal({{ $cottage->id }})" 
                                            class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-3 sm:px-4 rounded-lg transition-colors text-sm sm:text-base">
                                        <i class="fas fa-info-circle mr-1 sm:mr-2"></i><span class="hidden sm:inline">View Details</span><span class="sm:hidden">Details</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-50 rounded-lg p-6 sm:p-8 text-center">
                        <i class="fas fa-home text-gray-400 text-3xl sm:text-4xl mb-3"></i>
                        <p class="text-sm sm:text-base text-gray-500">No cottages available yet.</p>
                    </div>
                @endif
            </div>

            <!-- Gallery Section -->
            <div class="px-3 sm:px-4 md:px-6 pb-4 sm:pb-6">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-3 sm:mb-4">Gallery</h2>
                @if($resort->galleries && $resort->galleries->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2 sm:gap-3 md:gap-4">
                        @foreach($resort->galleries as $gallery)
                            <div class="relative group cursor-pointer" onclick="openImageModal('{{ Storage::url($gallery->image_path) }}')">
                                <img src="{{ Storage::url($gallery->image_path) }}" 
                                     class="w-full h-40 object-cover rounded-lg hover:opacity-90 transition-opacity" 
                                     alt="Gallery image">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-opacity rounded-lg flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white opacity-0 group-hover:opacity-100 text-2xl"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-50 rounded-lg p-8 text-center">
                        <i class="fas fa-images text-gray-400 text-4xl mb-3"></i>
                        <p class="text-gray-500">No gallery images available yet.</p>
                    </div>
                @endif
            </div>

            <!-- Feedback Button -->
            <div class="px-6 pb-6">
                @auth
                    <button onclick="viewResortComments({{ $resort->id }}, '{{ addslashes($resort->business_name ?? $resort->name) }}', true)" class="w-full flex items-center justify-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                        <i class="fas fa-comment-dots mr-2"></i>
                        <span>Leave Feedback</span>
                    </button>
                @else
                    <button onclick="viewResortComments({{ $resort->id }}, '{{ addslashes($resort->business_name ?? $resort->name) }}', false)" class="w-full flex items-center justify-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                        <i class="fas fa-comment-dots mr-2"></i>
                        <span>View Feedback</span>
                    </button>
                @endauth
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-90 hidden z-50 flex items-center justify-center" onclick="closeImageModal()">
    <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white text-3xl hover:text-gray-300">
        <i class="fas fa-times"></i>
    </button>
    <img id="modalImage" src="" class="max-w-full max-h-full object-contain" alt="Gallery image">
</div>

<!-- Room Details Modal -->
<div id="roomModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4" onclick="closeRoomModal()">
    <div class="bg-white rounded-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        <div class="sticky top-0 bg-white border-b px-6 py-4 flex items-center justify-between">
            <h3 class="text-2xl font-bold text-gray-900" id="roomModalTitle"></h3>
            <button onclick="closeRoomModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        <div id="roomModalContent" class="p-6"></div>
    </div>
</div>

<!-- Cottage Details Modal -->
<div id="cottageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4" onclick="closeCottageModal()">
    <div class="bg-white rounded-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        <div class="sticky top-0 bg-white border-b px-6 py-4 flex items-center justify-between">
            <h3 class="text-2xl font-bold text-gray-900" id="cottageModalTitle"></h3>
            <button onclick="closeCottageModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        <div id="cottageModalContent" class="p-6"></div>
    </div>
</div>

<!-- Comments Modal -->
<div id="commentsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-lg w-full mx-4 max-h-[80vh] flex flex-col" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center p-6 border-b">
            <h3 class="text-lg font-semibold" id="commentsModalTitle">Comments</h3>
            <button onclick="closeCommentsModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="flex-1 overflow-y-auto p-6" id="commentsListContainer">
            <div class="text-center py-4 text-gray-500">Loading comments...</div>
        </div>
        
        <div id="commentFormContainer" class="border-t p-6"></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Room data
const rooms = @json($resort->resortRooms);

// Cottage data
const cottages = @json($resort->cottages);

function openImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function openRoomModal(roomId) {
    const room = rooms.find(r => r.id === roomId);
    if (!room) return;
    
    document.getElementById('roomModalTitle').textContent = 'Room Details';
    
    const firstImage = room.images && room.images.length > 0 ? room.images[0].image_path : null;
    
    let content = `
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Left: Image -->
            <div class="md:w-1/3">
                ${firstImage ? `
                    <img src="/storage/${firstImage}" 
                         class="w-full h-48 object-cover rounded-lg cursor-pointer hover:opacity-90" 
                         onclick="openImageModal('/storage/${firstImage}')" 
                         alt="${room.room_name}">
                ` : `
                    <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center">
                        <i class="fas fa-bed text-gray-400 text-4xl"></i>
                    </div>
                `}
            </div>
            
            <!-- Right: Details -->
            <div class="md:w-2/3">
                <div class="space-y-4">
                    <!-- ID and Room Name -->
                    <div>
                        <p class="text-sm text-gray-500">Room ID: #${room.id}</p>
                        <h3 class="text-2xl font-bold text-gray-900">${room.room_name || 'Room ' + room.id}</h3>
                    </div>
                    
                    <!-- Room Type -->
                    ${room.room_type ? `
                        <div>
                            <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                ${room.room_type.charAt(0).toUpperCase() + room.room_type.slice(1)}
                            </span>
                        </div>
                    ` : ''}
                    
                    <!-- Price -->
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-green-600">₱${parseFloat(room.price_per_night).toLocaleString('en-PH', {minimumFractionDigits: 2})}</span>
                        <span class="text-gray-500">per night</span>
                    </div>
                    
                    <!-- Guest Capacity -->
                    ${room.capacity ? `
                        <div class="flex items-center gap-2 text-gray-700">
                            <i class="fas fa-users text-green-600"></i>
                            <span>${room.capacity} ${room.capacity > 1 ? 'Guests' : 'Guest'}</span>
                        </div>
                    ` : ''}
                    
                    <!-- Bed Configuration -->
                    ${room.bed_configuration ? `
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-1">Bed Configuration</h4>
                            <p class="text-gray-600 text-sm">${room.bed_configuration}</p>
                        </div>
                    ` : ''}
                    
                    <!-- Description -->
                    ${room.description ? `
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-1">Description</h4>
                            <p class="text-gray-600 text-sm">${room.description}</p>
                        </div>
                    ` : ''}
                    
                    <!-- Amenities -->
                    ${room.amenities ? (() => {
                        const amenitiesList = typeof room.amenities === 'string' 
                            ? room.amenities.split(',').map(a => a.trim()).filter(a => a)
                            : (Array.isArray(room.amenities) ? room.amenities : []);
                        
                        return amenitiesList.length > 0 ? `
                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 mb-2">Amenities</h4>
                                <div class="flex flex-wrap gap-2">
                                    ${amenitiesList.map(amenity => `
                                        <span class="inline-flex items-center gap-1 bg-gray-100 px-2 py-1 rounded text-xs text-gray-700">
                                            <i class="fas fa-check text-green-600"></i>
                                            ${amenity}
                                        </span>
                                    `).join('')}
                                </div>
                            </div>
                        ` : '';
                    })() : ''}
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('roomModalContent').innerHTML = content;
    document.getElementById('roomModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeRoomModal() {
    document.getElementById('roomModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function openCottageModal(cottageId) {
    const cottage = cottages.find(c => c.id === cottageId);
    if (!cottage) return;
    
    document.getElementById('cottageModalTitle').textContent = 'Cottage Details';
    
    const firstImage = cottage.galleries && cottage.galleries.length > 0 ? cottage.galleries[0].image_path : null;
    
    let content = `
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Left: Image -->
            <div class="md:w-1/3">
                ${firstImage ? `
                    <img src="/storage/${firstImage}" 
                         class="w-full h-48 object-cover rounded-lg cursor-pointer hover:opacity-90" 
                         onclick="openImageModal('/storage/${firstImage}')" 
                         alt="${cottage.cottage_name || cottage.cottage_type}">
                ` : `
                    <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center">
                        <i class="fas fa-home text-gray-400 text-4xl"></i>
                    </div>
                `}
            </div>
            
            <!-- Right: Details -->
            <div class="md:w-2/3">
                <div class="space-y-4">
                    <!-- ID and Cottage Name -->
                    <div>
                        <p class="text-sm text-gray-500">Cottage ID: #${cottage.id}</p>
                        <h3 class="text-2xl font-bold text-gray-900">${cottage.cottage_name || cottage.cottage_type || 'Cottage ' + cottage.id}</h3>
                    </div>
                    
                    <!-- Cottage Type -->
                    ${cottage.cottage_type ? `
                        <div>
                            <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                ${cottage.cottage_type}
                            </span>
                        </div>
                    ` : ''}
                    
                    <!-- Price -->
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-green-600">₱${parseFloat(cottage.price_per_night).toLocaleString('en-PH', {minimumFractionDigits: 2})}</span>
                        <span class="text-gray-500">per night</span>
                    </div>
                    
                    <!-- Guest Capacity -->
                    ${cottage.capacity ? `
                        <div class="flex items-center gap-2 text-gray-700">
                            <i class="fas fa-users text-green-600"></i>
                            <span>Up to ${cottage.capacity} ${cottage.capacity > 1 ? 'Guests' : 'Guest'}</span>
                        </div>
                    ` : ''}
                    
                    <!-- Description -->
                    ${cottage.description ? `
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-1">Description</h4>
                            <p class="text-gray-600 text-sm">${cottage.description}</p>
                        </div>
                    ` : ''}
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('cottageModalContent').innerHTML = content;
    document.getElementById('cottageModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeCottageModal() {
    document.getElementById('cottageModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// View resort comments/feedback
function viewResortComments(resortId, resortName, canComment = true) {
    const modal = document.getElementById('commentsModal');
    const title = document.getElementById('commentsModalTitle');
    const listContainer = document.getElementById('commentsListContainer');
    const formContainer = document.getElementById('commentFormContainer');
    
    title.textContent = `Comments - ${resortName}`;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Show loading state
    listContainer.innerHTML = '<div class="text-center py-4 text-gray-500">Loading comments...</div>';
    
    // Set up comment form
    if (canComment) {
        formContainer.innerHTML = `
            <form id="resort-comment-form" onsubmit="submitResortComment(event, ${resortId})" class="flex space-x-3">
                <textarea name="comment" rows="2" class="flex-1 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 resize-none" 
                          placeholder="Write a comment..." required></textarea>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        `;
    } else {
        formContainer.innerHTML = `
            <div class="text-center">
                <p class="text-gray-500 text-sm mb-3">Want to leave a comment?</p>
                <button onclick="closeCommentsModal(); window.location.href='/#login';" 
                        class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors">
                    Login to Comment
                </button>
            </div>
        `;
    }
    
    // Load comments
    loadResortComments(resortId);
}

function closeCommentsModal() {
    document.getElementById('commentsModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function loadResortComments(resortId) {
    fetch(`/resorts/${resortId}/comments`, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        const listContainer = document.getElementById('commentsListContainer');
        if (data.comments && data.comments.length > 0) {
            listContainer.innerHTML = data.comments.map(comment => `
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
            listContainer.innerHTML = '<div class="text-center py-4 text-gray-500">No comments yet. Be the first to comment!</div>';
        }
    })
    .catch(error => {
        console.error('Error loading comments:', error);
        const listContainer = document.getElementById('commentsListContainer');
        listContainer.innerHTML = '<div class="text-center py-4 text-red-500">Error loading comments</div>';
    });
}

function submitResortComment(event, resortId) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    
    fetch(`/resorts/${resortId}/comment`, {
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
            loadResortComments(resortId);
        } else {
            alert(data.error || 'Error submitting comment');
        }
    })
    .catch(error => {
        console.error('Error submitting comment:', error);
        alert('Error submitting comment');
    });
}
</script>
@endsection
