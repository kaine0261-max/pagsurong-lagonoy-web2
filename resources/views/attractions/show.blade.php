@extends(auth()->check() && auth()->user()->role === 'customer' ? 'layouts.customer' : 'layouts.public')

@section('title', $attraction->name)

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <!-- Cover Image -->
            @if($attraction->main_image)
                <img src="{{ Storage::url($attraction->main_image) }}" class="w-full h-64 object-cover" alt="{{ $attraction->name }}">
            @endif

            <!-- Attraction Info -->
            <div class="p-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $attraction->name }}</h1>
                
                @if($attraction->location)
                    <div class="flex items-center text-gray-600 mb-4">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        <span>{{ $attraction->location }}</span>
                    </div>
                @endif

                @if($attraction->description)
                    <div class="mt-4">
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">About This Attraction</h2>
                        <p class="text-gray-700 leading-relaxed">{{ $attraction->description }}</p>
                    </div>
                @endif

                <!-- Additional Info -->
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($attraction->category)
                        <div class="flex items-center">
                            <i class="fas fa-tag text-green-600 mr-2"></i>
                            <span class="text-gray-700"><strong>Category:</strong> {{ ucfirst($attraction->category) }}</span>
                        </div>
                    @endif
                    
                    @if($attraction->best_time_to_visit)
                        <div class="flex items-center">
                            <i class="fas fa-clock text-green-600 mr-2"></i>
                            <span class="text-gray-700"><strong>Best Time:</strong> {{ $attraction->best_time_to_visit }}</span>
                        </div>
                    @endif
                    
                    @if($attraction->entrance_fee)
                        <div class="flex items-center">
                            <i class="fas fa-ticket-alt text-green-600 mr-2"></i>
                            <span class="text-gray-700"><strong>Entrance Fee:</strong> ₱{{ number_format($attraction->entrance_fee, 2) }}</span>
                        </div>
                    @endif
                    
                    @if($attraction->contact_number)
                        <div class="flex items-center">
                            <i class="fas fa-phone text-green-600 mr-2"></i>
                            <span class="text-gray-700"><strong>Contact:</strong> {{ $attraction->contact_number }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Gallery Section -->
            @php
                $galleryImages = is_string($attraction->gallery_images) ? json_decode($attraction->gallery_images, true) : $attraction->gallery_images;
            @endphp
            @if($galleryImages && is_array($galleryImages) && count($galleryImages) > 0)
                <div class="px-6 pb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Gallery</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach($galleryImages as $imagePath)
                            <div class="relative group cursor-pointer" onclick="openImageModal('{{ Storage::url($imagePath) }}')">
                                <img src="{{ Storage::url($imagePath) }}" 
                                     class="w-full h-40 object-cover rounded-lg hover:opacity-90 transition-opacity" 
                                     alt="Gallery image">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-opacity rounded-lg flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white opacity-0 group-hover:opacity-100 text-2xl"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Activities Section -->
            @if($attraction->activities)
                <div class="px-6 pb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Activities</h2>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-700 leading-relaxed">{{ $attraction->activities }}</p>
                    </div>
                </div>
            @endif

            <!-- How to Get There -->
            @if($attraction->how_to_get_there)
                <div class="px-6 pb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">How to Get There</h2>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <p class="text-gray-700 leading-relaxed">{{ $attraction->how_to_get_there }}</p>
                    </div>
                </div>
            @endif

            <!-- Feedback Button -->
            <div class="px-6 pb-6">
                @auth
                    <button onclick="viewAttractionComments({{ $attraction->id }}, '{{ addslashes($attraction->name) }}', true)" class="w-full flex items-center justify-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                        <i class="fas fa-comment-dots mr-2"></i>
                        <span>Leave Feedback</span>
                    </button>
                @else
                    <button onclick="viewAttractionComments({{ $attraction->id }}, '{{ addslashes($attraction->name) }}', false)" class="w-full flex items-center justify-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
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
function openImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// View attraction comments/feedback
function viewAttractionComments(attractionId, attractionName, canComment = true) {
    const modal = document.getElementById('commentsModal');
    const title = document.getElementById('commentsModalTitle');
    const listContainer = document.getElementById('commentsListContainer');
    const formContainer = document.getElementById('commentFormContainer');
    
    title.textContent = `Comments - ${attractionName}`;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Show loading state
    listContainer.innerHTML = '<div class="text-center py-4 text-gray-500">Loading comments...</div>';
    
    // Set up comment form
    if (canComment) {
        formContainer.innerHTML = `
            <form id="attraction-comment-form" onsubmit="submitAttractionComment(event, ${attractionId})" class="flex space-x-3">
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
    loadAttractionComments(attractionId);
}

function closeCommentsModal() {
    document.getElementById('commentsModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function loadAttractionComments(attractionId) {
    fetch(`/tourist-spots/${attractionId}/comments`, {
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
                                    ${comment.user_name ? comment.user_name.charAt(0).toUpperCase() : 'U'}
                                </div>`
                            }
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-medium text-sm">${comment.user_name || 'User'}</span>
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

function submitAttractionComment(event, attractionId) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    
    fetch(`/tourist-spots/${attractionId}/comment`, {
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
            loadAttractionComments(attractionId);
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
