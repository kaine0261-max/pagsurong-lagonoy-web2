@extends(auth()->check() && auth()->user()->role === 'customer' ? 'layouts.customer' : 'layouts.app')

@section('title', 'My Profile - Pagsurong Lagonoy')

@section('content')
<div class="min-h-screen bg-gray-50">
<div class="py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-serif font-bold text-gray-800 mb-2">My Profile</h1>
                <p class="text-gray-600">Manage your profile information</p>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-6">
                <!-- Profile Picture -->
                <div class="text-center">
                    @php
                        $showBusinessAvatar = $user->role === 'business_owner' && $user->businessProfile && $user->businessProfile->profile_avatar;
                    @endphp
                    @if($showBusinessAvatar)
                        <img src="{{ Storage::url($user->businessProfile->profile_avatar) }}" 
                             alt="Profile Picture" 
                             class="w-32 h-32 rounded-full object-cover mx-auto border-4 border-green-500">
                    @elseif($profile && $profile->profile_picture)
                        <img src="{{ asset('storage/' . $profile->profile_picture) }}" 
                             alt="Profile Picture" 
                             class="w-32 h-32 rounded-full object-cover mx-auto border-4 border-green-500">
                    @else
                        <div class="w-32 h-32 rounded-full bg-green-500 flex items-center justify-center mx-auto">
                            <span class="text-white text-4xl font-bold">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                    @endif
                </div>

                <!-- User Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                        <p class="text-gray-900 font-medium">{{ $user->name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <p class="text-gray-900 font-medium">{{ $user->email }}</p>
                    </div>
                </div>

                <!-- Profile Info -->
                @if($profile)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                            <p class="text-gray-900">{{ $profile->phone_number ?: 'Not provided' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                            <p class="text-gray-900">{{ $profile->address ?: 'Not provided' }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            {{ auth()->user()->role === 'business_owner' ? 'Business Description' : 'Bio' }}
                        </label>
                        @if(auth()->user()->role === 'business_owner')
                            <p class="text-gray-900">{{ auth()->user()->businessProfile && auth()->user()->businessProfile->description ? auth()->user()->businessProfile->description : 'No business description provided' }}</p>
                        @else
                            <p class="text-gray-900">{{ $profile->bio ?: 'No bio provided' }}</p>
                        @endif
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500 mb-4">No profile information found.</p>
                        <a href="{{ route('profile.setup') }}" 
                           class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            Complete Profile Setup
                        </a>
                    </div>
                @endif

                <!-- Actions -->
                @if($profile)
                    <div class="pt-6 flex justify-center gap-4">
                        <a href="{{ route('profile.edit') }}" 
                           class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Profile
                        </a>
                        <button onclick="@if(auth()->user()->role === 'business_owner')openDeleteAccountModal()@else openDeleteModal()@endif" 
                                class="inline-flex items-center px-6 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="fas fa-trash-alt mr-2"></i>
                            Delete My Account
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>

<!-- Delete Account Confirmation Modal (Only for Customers) -->
@if(auth()->user()->role === 'customer')
<div id="deleteAccountModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-md w-full p-6 shadow-xl">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-800">Delete Account</h3>
            <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <div class="mb-6">
            <div class="flex items-center justify-center mb-4">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600 text-3xl"></i>
                </div>
            </div>
            <p class="text-gray-700 text-center mb-2">Are you sure you want to delete your account?</p>
            <p class="text-gray-600 text-sm text-center">This action cannot be undone and all your data will be permanently deleted.</p>
        </div>

        <div class="flex space-x-3">
            <button onclick="closeDeleteModal()" 
                    class="flex-1 bg-gray-200 text-gray-700 py-3 px-4 rounded-lg hover:bg-gray-300 transition-colors duration-200 font-medium">
                Cancel
            </button>
            <button onclick="confirmDeleteAccount()" 
                    class="flex-1 bg-red-600 text-white py-3 px-4 rounded-lg hover:bg-red-700 transition-colors duration-200 font-medium">
                Delete Account
            </button>
        </div>
    </div>
</div>
@endif
@endsection

@section('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400;500&display=swap');
    
    .font-serif {
        font-family: 'Playfair Display', serif;
    }
</style>
@endsection

@section('scripts')
@if(auth()->user()->role === 'customer')
<script>
function openDeleteModal() {
    document.getElementById('deleteAccountModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteAccountModal').classList.add('hidden');
}

function confirmDeleteAccount() {
    // Create and submit form
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("account.delete") }}';
    
    // Add CSRF token
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = '{{ csrf_token() }}';
    form.appendChild(csrfInput);
    
    // Add DELETE method
    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'DELETE';
    form.appendChild(methodInput);
    
    document.body.appendChild(form);
    form.submit();
}

// Close modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('deleteAccountModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeDeleteModal();
            }
        });
    }
});
</script>
@endif
@endsection
