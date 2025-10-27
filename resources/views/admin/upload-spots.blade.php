@extends('layouts.app')

@section('title', 'Upload Tourist Spots')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex gap-6">
        <!-- Left Sidebar - Uploaded Tourist Spots -->
        <div id="touristSpotsPanel" class="hidden lg:flex flex-col bg-white rounded-lg shadow-md sticky top-8 h-[calc(100vh-6rem)] w-80 transition-all duration-300">
            <!-- Header with Toggle -->
            <div class="p-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <button onclick="toggleTouristSpotsPanel()" class="flex items-center hover:text-blue-700 transition-colors">
                        <i class="fas fa-map-marked-alt text-blue-600 text-xl"></i>
                        <span id="touristSpotsTitle" class="ml-2 font-semibold text-gray-900">Uploaded Tourist Spots</span>
                    </button>
                    <button id="touristSpotsToggleBtn" onclick="toggleTouristSpotsPanel()" class="text-gray-400 hover:text-gray-600 p-1">
                        <i id="touristSpotsToggleIcon" class="fas fa-chevron-left text-sm"></i>
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div id="touristSpotsContent" class="flex-1 overflow-y-auto p-4">
                @if($touristSpots->count() > 0)
                    <div class="space-y-4">
                        @foreach($touristSpots as $spot)
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex items-start space-x-3">
                                    <!-- Profile Avatar -->
                                    <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-200 flex-shrink-0">
                                        @if($spot->profile_avatar)
                                            <img src="{{ asset('storage/' . $spot->profile_avatar) }}" 
                                                 alt="{{ $spot->name }}" 
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-blue-500 flex items-center justify-center">
                                                <span class="text-white text-sm font-bold">
                                                    {{ strtoupper(substr($spot->name, 0, 1)) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Spot Info -->
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-semibold text-gray-900 truncate">{{ $spot->name }}</h4>
                                        @if($spot->location)
                                            <p class="text-xs text-gray-600 truncate">{{ $spot->location }}</p>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex space-x-2 mt-3">
                                    <button onclick="editTouristSpot({{ $spot->id }})" 
                                            class="flex-1 bg-blue-600 text-white text-xs py-2 px-3 rounded hover:bg-blue-700 transition-colors">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </button>
                                    <button onclick="deleteTouristSpot({{ $spot->id }})" 
                                            class="flex-1 bg-red-600 text-white text-xs py-2 px-3 rounded hover:bg-red-700 transition-colors">
                                        <i class="fas fa-trash mr-1"></i> Delete
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-map-marked-alt text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">No tourist spots uploaded yet</p>
                        <p class="text-sm text-gray-400">Upload your first spot using the form</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Main Content - Upload Form -->
        <div class="flex-1">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Upload Tourist Spot</h1>
                    <p class="text-gray-600 mt-2">Add a new tourist destination for visitors to discover</p>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="touristSpotForm" action="{{ route('admin.upload.spots.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Tourist Spot Name -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Tourist Spot Name *</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Enter tourist spot name">
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Describe the tourist spot...">{{ old('description') }}</textarea>
                    </div>

                    <!-- Profile Avatar -->
                    <div class="mb-6">
                        <label for="profile_avatar" class="block text-sm font-medium text-gray-700 mb-2">Profile Avatar</label>
                        <input type="file" 
                               id="profile_avatar" 
                               name="profile_avatar" 
                               accept="image/*"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>

                    <!-- Cover Image -->
                    <div class="mb-6">
                        <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-2">Cover Image</label>
                        <input type="file" 
                               id="cover_image" 
                               name="cover_image" 
                               accept="image/*"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>

                    <!-- Location -->
                    <div class="mb-6">
                        <x-location-select name="location" :value="old('location')">
                            Location
                        </x-location-select>
                    </div>


                    <!-- Additional Info -->
                    <div class="mb-6">
                        <label for="additional_info" class="block text-sm font-medium text-gray-700 mb-2">Additional Information</label>
                        <textarea id="additional_info" 
                                  name="additional_info" 
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Any additional information about the tourist spot...">{{ old('additional_info') }}</textarea>
                    </div>

                    <!-- Upload Gallery Section -->
                    <div class="mb-6 border-t pt-6">
                        <h4 class="text-md font-semibold text-gray-900 mb-4">Upload Gallery</h4>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Gallery Images</label>
                                <input type="file" 
                                       id="gallery_images" 
                                       name="gallery_images[]" 
                                       multiple 
                                       accept="image/*"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                        </div>
                        
                        <!-- Gallery Preview -->
                        <div id="gallery-preview" class="mt-4 grid grid-cols-2 gap-2"></div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" 
                                class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition-colors font-medium">
                            Upload Tourist Spot
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Edit Tourist Spot</h3>
                        <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <form id="editForm" method="POST" enctype="multipart/form-data" onsubmit="handleEditFormSubmit(event)">
                        @csrf
                        @method('PUT')
                        <!-- Hidden input for location (will be populated from edit_location) -->
                        <input type="hidden" name="location" id="final_location">
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                <input type="text" id="edit_name" name="name" required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <textarea id="edit_description" name="description" rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>
                            
                            <div>
                                <x-location-select name="edit_location">
                                    Location
                                </x-location-select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Additional Information</label>
                                <textarea id="edit_additional_info" name="additional_info" rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Profile Avatar</label>
                                    <input type="file" name="profile_avatar" accept="image/*"
                                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Cover Image</label>
                                    <input type="file" name="cover_image" accept="image/*"
                                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                </div>
                            </div>
                            
                            <!-- Gallery Images Section -->
                            <div class="border-t pt-4 mt-4 bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-md font-semibold text-gray-900 mb-3">📸 Gallery Images</h4>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Upload New Gallery Images</label>
                                <input type="file" name="gallery_images[]" multiple accept="image/*"
                                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="text-xs text-gray-500 mt-1">📌 Upload multiple images for the gallery. This will replace existing gallery images.</p>
                                
                                <!-- Current Gallery Preview -->
                                <div id="current-gallery-preview" class="mt-4">
                                    <p class="text-sm font-medium text-gray-700 mb-2">Current Gallery Images:</p>
                                    <div id="current-gallery-grid" class="grid grid-cols-3 gap-2"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button" onclick="closeEditModal()" 
                                    class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                Update Tourist Spot
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Global variables
let currentTouristSpotId = null;
let currentGalleryImages = [];

// Global functions for edit and delete
function editTouristSpot(id) {
    currentTouristSpotId = id;
    fetch(`/admin/tourist-spots/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_name').value = data.name || '';
            document.getElementById('edit_description').value = data.description || '';
            // Set location value for the edit location component
            const editLocationSearchInput = document.getElementById('edit_location_search');
            const editLocationHiddenInput = document.getElementById('edit_location');
            if (editLocationSearchInput && editLocationHiddenInput) {
                editLocationSearchInput.value = data.location || '';
                editLocationHiddenInput.value = data.location || '';
            }
            document.getElementById('edit_additional_info').value = data.additional_info || '';
            
            // Store current gallery images
            try {
                currentGalleryImages = data.gallery_images ? 
                    (typeof data.gallery_images === 'string' ? JSON.parse(data.gallery_images) : data.gallery_images) : [];
            } catch (e) {
                currentGalleryImages = [];
            }
            
            // Load current gallery images
            loadCurrentGallery(data.gallery_images);
            
            document.getElementById('editForm').action = `/admin/tourist-spots/${id}`;
            document.getElementById('editModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading tourist spot data');
        });
}

function loadCurrentGallery(galleryImages) {
    console.log('Loading gallery images:', galleryImages);
    const galleryGrid = document.getElementById('current-gallery-grid');
    const galleryPreview = document.getElementById('current-gallery-preview');
    
    if (!galleryGrid || !galleryPreview) {
        console.error('Gallery elements not found');
        return;
    }
    
    // Clear existing content
    galleryGrid.innerHTML = '';
    
    if (galleryImages) {
        let images = [];
        try {
            // Parse JSON if it's a string
            images = typeof galleryImages === 'string' ? JSON.parse(galleryImages) : galleryImages;
        } catch (e) {
            console.error('Error parsing gallery images:', e);
            images = [];
        }
        
        console.log('Parsed images:', images);
        
        if (Array.isArray(images) && images.length > 0) {
            galleryPreview.style.display = 'block';
            images.forEach((imagePath, index) => {
                const imgContainer = document.createElement('div');
                imgContainer.className = 'relative group';
                
                const img = document.createElement('img');
                img.src = '/storage/' + imagePath;
                img.className = 'w-full h-16 object-cover rounded border';
                img.alt = 'Gallery image';
                
                // Delete button
                const deleteBtn = document.createElement('button');
                deleteBtn.type = 'button';
                deleteBtn.className = 'absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 opacity-0 group-hover:opacity-100 transition-opacity';
                deleteBtn.innerHTML = '×';
                deleteBtn.title = 'Remove image';
                deleteBtn.onclick = () => removeGalleryImage(imagePath, index);
                
                imgContainer.appendChild(img);
                imgContainer.appendChild(deleteBtn);
                galleryGrid.appendChild(imgContainer);
            });
        } else {
            galleryPreview.style.display = 'none';
            console.log('No gallery images to display');
        }
    } else {
        galleryPreview.style.display = 'none';
        console.log('No gallery images provided');
    }
}

function removeGalleryImage(imagePath, index) {
    if (!confirm('Are you sure you want to remove this image from the gallery?')) {
        return;
    }
    
    if (!currentTouristSpotId) {
        alert('Error: Tourist spot ID not found');
        return;
    }
    
    // Show loading state
    const deleteBtn = event.target;
    const originalText = deleteBtn.innerHTML;
    deleteBtn.innerHTML = '⏳';
    deleteBtn.disabled = true;
    
    fetch(`/admin/tourist-spots/${currentTouristSpotId}/gallery/remove`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            image_path: imagePath,
            image_index: index
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the current gallery images array
            currentGalleryImages = data.updated_gallery || [];
            // Reload the gallery display
            loadCurrentGallery(currentGalleryImages);
            // Show success message
            showMessage('Image removed successfully!', 'success');
        } else {
            alert('Error removing image: ' + (data.message || 'Unknown error'));
            // Restore button state
            deleteBtn.innerHTML = originalText;
            deleteBtn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error removing image');
        // Restore button state
        deleteBtn.innerHTML = originalText;
        deleteBtn.disabled = false;
    });
}

function showMessage(message, type = 'info') {
    // Create a temporary message element
    const messageDiv = document.createElement('div');
    messageDiv.className = `fixed top-4 right-4 z-50 px-4 py-2 rounded-md text-white ${
        type === 'success' ? 'bg-green-500' : 
        type === 'error' ? 'bg-red-500' : 'bg-blue-500'
    }`;
    messageDiv.textContent = message;
    
    document.body.appendChild(messageDiv);
    
    // Remove after 3 seconds
    setTimeout(() => {
        if (messageDiv.parentNode) {
            messageDiv.parentNode.removeChild(messageDiv);
        }
    }, 3000);
}

function handleEditFormSubmit(event) {
    // Copy the edit_location value to the final_location hidden input
    const editLocationValue = document.getElementById('edit_location').value;
    document.getElementById('final_location').value = editLocationValue;
    
    // Let the form submit normally
    return true;
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    currentTouristSpotId = null;
    currentGalleryImages = [];
}

function deleteTouristSpot(id) {
    if (confirm('Are you sure you want to delete this tourist spot? This action cannot be undone.')) {
        fetch(`/admin/tourist-spots/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting tourist spot');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting tourist spot');
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const uploadGalleryBtn = document.getElementById('upload-gallery-btn');
    const galleryInput = document.getElementById('gallery_images');
    const galleryPreview = document.getElementById('gallery-preview');
    const touristSpotForm = document.getElementById('touristSpotForm');

    // Reset form after successful submission if there's a success message
    @if(session('success'))
        if (touristSpotForm) {
            touristSpotForm.reset();
            // Clear location component
            const locationSearchInput = document.getElementById('location_search');
            const locationHiddenInput = document.getElementById('location');
            if (locationSearchInput) locationSearchInput.value = '';
            if (locationHiddenInput) locationHiddenInput.value = '';
            // Clear gallery preview
            if (galleryPreview) galleryPreview.innerHTML = '';
        }
    @endif

    if (uploadGalleryBtn) {
        uploadGalleryBtn.addEventListener('click', function() {
            const files = galleryInput.files;
            if (files.length === 0) {
                alert('Please select images to upload');
                return;
            }

            const formData = new FormData();
            for (let i = 0; i < files.length; i++) {
                formData.append('gallery_images[]', files[i]);
            }

            // Add CSRF token
            formData.append('_token', '{{ csrf_token() }}');

            fetch('{{ route("admin.upload.spots.gallery") }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    // Clear the input
                    galleryInput.value = '';
                    // Update preview
                    updateGalleryPreview(data.files);
                } else {
                    alert('Upload failed');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Upload failed');
            });
        });
    }

    function updateGalleryPreview(files) {
        galleryPreview.innerHTML = '';
        files.forEach(file => {
            const img = document.createElement('img');
            img.src = '/storage/' + file;
            img.className = 'w-full h-20 object-cover rounded';
            galleryPreview.appendChild(img);
        });
    }

    // Close modal when clicking outside
    const editModal = document.getElementById('editModal');
    if (editModal) {
        editModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });
    }
});

// Toggle Tourist Spots Panel (Minimize/Maximize)
function toggleTouristSpotsPanel() {
    const panel = document.getElementById('touristSpotsPanel');
    const content = document.getElementById('touristSpotsContent');
    const icon = document.getElementById('touristSpotsToggleIcon');
    const title = document.getElementById('touristSpotsTitle');
    const toggleBtn = document.getElementById('touristSpotsToggleBtn');
    
    if (panel && content && icon && title && toggleBtn) {
        const isMinimized = content.style.display === 'none';
        
        if (isMinimized) {
            // Maximize
            content.style.display = 'block';
            title.style.display = 'inline';
            toggleBtn.style.display = 'block';
            panel.classList.remove('w-12');
            panel.classList.add('w-80');
            icon.classList.remove('fa-chevron-right');
            icon.classList.add('fa-chevron-left');
        } else {
            // Minimize - Show only icon
            content.style.display = 'none';
            title.style.display = 'none';
            toggleBtn.style.display = 'none';
            panel.classList.remove('w-80');
            panel.classList.add('w-12');
            icon.classList.remove('fa-chevron-left');
            icon.classList.add('fa-chevron-right');
        }
    }
}
</script>
@endsection
