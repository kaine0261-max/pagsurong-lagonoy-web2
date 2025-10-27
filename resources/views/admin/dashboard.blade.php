@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8 -mt-20">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <input type="text" placeholder="Search..." class="border border-gray-300 rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
            <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
                <i class="fas fa-plus mr-2"></i> New User
            </a>
        </div>
    </div>

    <p class="text-gray-600 mb-8">Welcome, Admin. Manage users, businesses, products, and orders.</p>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6 transition-transform duration-300 hover:translate-y-[-5px] cursor-pointer" onclick="openUsersModal()">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-blue-100 text-blue-600">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-500 text-sm">Total Users</h2>
                    <p class="text-2xl font-bold">{{ $counts['customers'] + $counts['businessOwners'] + $counts['admins'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 transition-transform duration-300 hover:translate-y-[-5px] cursor-pointer" onclick="openProductsModal()">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-purple-100 text-purple-600">
                    <i class="fas fa-shopping-cart text-xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-500 text-sm">Total Products</h2>
                    <p class="text-2xl font-bold">{{ $productCount ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 transition-transform duration-300 hover:translate-y-[-5px] cursor-pointer" onclick="openHotelsModal()">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-orange-100 text-orange-600">
                    <i class="fas fa-hotel text-xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-500 text-sm">Hotels</h2>
                    <p class="text-2xl font-bold">{{ $hotelCount ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 transition-transform duration-300 hover:translate-y-[-5px] cursor-pointer" onclick="openResortsModal()">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-teal-100 text-teal-600">
                    <i class="fas fa-umbrella-beach text-xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-500 text-sm">Resorts</h2>
                    <p class="text-2xl font-bold">{{ $resortCount ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 transition-transform duration-300 hover:translate-y-[-5px] cursor-pointer" onclick="openTouristSpotsModal()">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-indigo-100 text-indigo-600">
                    <i class="fas fa-map-marked-alt text-xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-500 text-sm">Tourist Spots</h2>
                    <p class="text-2xl font-bold">{{ $touristSpotCount ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Businesses -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Recent Users</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($recentUsers as $user)
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($user->profile && $user->profile->profile_picture)
                                            <img class="h-10 w-10 rounded-full" src="{{ Storage::url($user->profile->profile_picture) }}" alt="{{ $user->name }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-semibold">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($user->role === 'admin') bg-purple-100 text-purple-800
                                    @elseif($user->role === 'business_owner') bg-blue-100 text-blue-800
                                    @else bg-green-100 text-green-800
                                    @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->created_at->diffForHumans() }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Registered Businesses</h2>
            <div class="space-y-4">
                @foreach($businesses as $business)
                <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-md bg-blue-100 flex items-center justify-center mr-3 text-blue-600">
                            <i class="fas fa-store"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium">{{ $business->name }}</p>
                            <p class="text-xs text-gray-500">By {{ $business->owner->name }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium">{{ $business->products_count }} products</p>
                        <p class="text-xs text-green-500">{{ $business->is_published ? 'Published' : 'Unpublished' }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">User Distribution</h2>
            <div class="h-64">
                <canvas id="userDistributionChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Top Locations</h2>
            <div class="h-64">
                <canvas id="locationChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- ✅ Fixed Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Pass PHP data to JS
    const customerCount = {{ $counts['customers'] }};
    const businessOwnerCount = {{ $counts['businessOwners'] }};
    const adminCount = {{ $counts['admins'] }};

    const businessLabels = [
        @foreach($businesses as $business)
            "{{ addslashes($business->name) }}",
        @endforeach
    ];

    const productCounts = [
        @foreach($businesses as $business)
            {{ $business->products_count }},
        @endforeach
    ];

    // ===== 1. User Distribution Chart =====
    const userCtx = document.getElementById('userDistributionChart').getContext('2d');
    new Chart(userCtx, {
        type: 'doughnut',
        data: {
            labels: ['Customers', 'Business Owners', 'Admins'],
            datasets: [{
                data: [customerCount, businessOwnerCount, adminCount],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(153, 102, 255, 0.8)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { font: { size: 11 } } }
            }
        }
    });

    // ===== 2. Location Distribution Chart =====
    const locationCtx = document.getElementById('locationChart').getContext('2d');
    new Chart(locationCtx, {
        type: 'pie',
        data: {
            labels: [
                @foreach($locationDistribution as $location)
                    "{{ $location->location }}",
                @endforeach
            ],
            datasets: [{
                data: [
                    @foreach($locationDistribution as $location)
                        {{ $location->count }},
                    @endforeach
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { font: { size: 10 } } }
            }
        }
    });

    // Modal Functions
    function openUsersModal() {
        document.getElementById('usersModal').classList.remove('hidden');
    }

    function openProductsModal() {
        document.getElementById('productsModal').classList.remove('hidden');
    }

    function openHotelsModal() {
        document.getElementById('hotelsModal').classList.remove('hidden');
    }

    function openResortsModal() {
        document.getElementById('resortsModal').classList.remove('hidden');
    }

    function openTouristSpotsModal() {
        document.getElementById('touristSpotsModal').classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
</script>

<!-- Modals -->
<!-- Users Modal -->
<div id="usersModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-900">All Users by Category</h3>
            <button onclick="closeModal('usersModal')" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="max-h-96 overflow-y-auto">
            <div class="mb-6">
                <h4 class="font-semibold text-blue-600 mb-2 flex items-center">
                    <i class="fas fa-users mr-2"></i> Customers ({{ $counts['customers'] }})
                </h4>
                <div class="space-y-2">
                    @foreach(App\Models\User::where('role', 'customer')->with('profile')->get() as $user)
                        <div class="flex items-center justify-between p-2 bg-blue-50 rounded">
                            <div class="flex items-center">
                                @if($user->profile && $user->profile->profile_picture)
                                    <img src="{{ Storage::url($user->profile->profile_picture) }}" class="w-8 h-8 rounded-full mr-2" alt="{{ $user->name }}">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm mr-2">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-medium">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-6">
                <h4 class="font-semibold text-green-600 mb-2 flex items-center">
                    <i class="fas fa-store mr-2"></i> Business Owners ({{ $counts['businessOwners'] }})
                </h4>
                <div class="space-y-2">
                    @foreach(App\Models\User::where('role', 'business_owner')->with('profile')->get() as $user)
                        <div class="flex items-center justify-between p-2 bg-green-50 rounded">
                            <div class="flex items-center">
                                @if($user->profile && $user->profile->profile_picture)
                                    <img src="{{ Storage::url($user->profile->profile_picture) }}" class="w-8 h-8 rounded-full mr-2" alt="{{ $user->name }}">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white text-sm mr-2">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-medium">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div>
                <h4 class="font-semibold text-purple-600 mb-2 flex items-center">
                    <i class="fas fa-user-shield mr-2"></i> Admins ({{ $counts['admins'] }})
                </h4>
                <div class="space-y-2">
                    @foreach(App\Models\User::where('role', 'admin')->with('profile')->get() as $user)
                        <div class="flex items-center justify-between p-2 bg-purple-50 rounded">
                            <div class="flex items-center">
                                @if($user->profile && $user->profile->profile_picture)
                                    <img src="{{ Storage::url($user->profile->profile_picture) }}" class="w-8 h-8 rounded-full mr-2" alt="{{ $user->name }}">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-purple-500 flex items-center justify-center text-white text-sm mr-2">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-medium">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Products Modal -->
<div id="productsModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-900">All Products by Shop</h3>
            <button onclick="closeModal('productsModal')" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="max-h-96 overflow-y-auto">
            @foreach($businesses as $business)
                @if($business->products_count > 0)
                    <div class="mb-4">
                        <h4 class="font-semibold text-purple-600 mb-2">{{ $business->name }} ({{ $business->products_count }} products)</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            @foreach($business->products as $product)
                                <div class="flex items-center p-2 bg-purple-50 rounded">
                                    @if($product->image)
                                        <img src="{{ Storage::url($product->image) }}" class="w-12 h-12 object-cover rounded mr-2" alt="{{ $product->name }}">
                                    @else
                                        <div class="w-12 h-12 bg-purple-200 rounded mr-2 flex items-center justify-center">
                                            <i class="fas fa-box text-purple-500"></i>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <p class="text-sm font-medium">{{ $product->name }}</p>
                                        <p class="text-xs text-gray-500">₱{{ number_format($product->price, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>

<!-- Hotels Modal -->
<div id="hotelsModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-900">All Hotels</h3>
            <button onclick="closeModal('hotelsModal')" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="max-h-96 overflow-y-auto">
            @php
                $hotels = App\Models\BusinessProfile::where('business_type', 'hotel')->where('status', 'approved')->with('user')->get();
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @forelse($hotels as $hotel)
                    <div class="p-3 bg-orange-50 rounded-lg">
                        <div class="flex items-start">
                            @if($hotel->cover_image)
                                <img src="{{ Storage::url($hotel->cover_image) }}" class="w-16 h-16 object-cover rounded mr-3" alt="{{ $hotel->business_name }}">
                            @else
                                <div class="w-16 h-16 bg-orange-200 rounded mr-3 flex items-center justify-center">
                                    <i class="fas fa-hotel text-orange-500 text-2xl"></i>
                                </div>
                            @endif
                            <div class="flex-1">
                                <p class="font-medium text-sm">{{ $hotel->business_name }}</p>
                                <p class="text-xs text-gray-500">{{ $hotel->address }}</p>
                                <p class="text-xs text-gray-500 mt-1">Owner: {{ $hotel->user->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm col-span-2">No hotels registered yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Resorts Modal -->
<div id="resortsModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-900">All Resorts</h3>
            <button onclick="closeModal('resortsModal')" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="max-h-96 overflow-y-auto">
            @php
                $resorts = App\Models\BusinessProfile::where('business_type', 'resort')->where('status', 'approved')->with('user')->get();
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @forelse($resorts as $resort)
                    <div class="p-3 bg-teal-50 rounded-lg">
                        <div class="flex items-start">
                            @if($resort->cover_image)
                                <img src="{{ Storage::url($resort->cover_image) }}" class="w-16 h-16 object-cover rounded mr-3" alt="{{ $resort->business_name }}">
                            @else
                                <div class="w-16 h-16 bg-teal-200 rounded mr-3 flex items-center justify-center">
                                    <i class="fas fa-umbrella-beach text-teal-500 text-2xl"></i>
                                </div>
                            @endif
                            <div class="flex-1">
                                <p class="font-medium text-sm">{{ $resort->business_name }}</p>
                                <p class="text-xs text-gray-500">{{ $resort->address }}</p>
                                <p class="text-xs text-gray-500 mt-1">Owner: {{ $resort->user->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm col-span-2">No resorts registered yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Tourist Spots Modal -->
<div id="touristSpotsModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-900">All Tourist Spots by Category</h3>
            <button onclick="closeModal('touristSpotsModal')" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="max-h-96 overflow-y-auto">
            @php
                $touristSpots = App\Models\TouristSpot::all();
                $categories = $touristSpots->groupBy('category');
            @endphp
            @forelse($categories as $category => $spots)
                <div class="mb-4">
                    <h4 class="font-semibold text-indigo-600 mb-2 flex items-center">
                        <i class="fas fa-map-marker-alt mr-2"></i> {{ ucfirst($category) }} ({{ $spots->count() }})
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        @foreach($spots as $spot)
                            <div class="flex items-center p-2 bg-indigo-50 rounded">
                                @if($spot->main_image)
                                    <img src="{{ Storage::url($spot->main_image) }}" class="w-12 h-12 object-cover rounded mr-2" alt="{{ $spot->name }}">
                                @else
                                    <div class="w-12 h-12 bg-indigo-200 rounded mr-2 flex items-center justify-center">
                                        <i class="fas fa-mountain text-indigo-500"></i>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <p class="text-sm font-medium">{{ $spot->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $spot->location }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-sm">No tourist spots uploaded yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection