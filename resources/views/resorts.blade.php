@extends('layouts.public')

@section('title', 'Resorts - Pagsurong Lagonoy')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-umbrella-beach mr-3 text-green-600"></i>
                    Resorts
                </h1>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Explore beautiful beachfront properties and vacation destinations in Lagonoy
                </p>
            </div>
        </div>
    </div>

    <!-- Resorts Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($resorts->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($resorts as $resort)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                        <!-- Resort Image -->
                        <div class="aspect-w-16 aspect-h-12 bg-gray-200">
                            @if($resort->cover_image)
                                <img src="{{ Storage::url($resort->cover_image) }}" 
                                     alt="{{ $resort->business_name }}" 
                                     class="w-full h-64 object-cover">
                            @elseif($resort->business && $resort->business->cover_image)
                                <img src="{{ Storage::url($resort->business->cover_image) }}" 
                                     alt="{{ $resort->business_name }}" 
                                     class="w-full h-64 object-cover">
                            @else
                                <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-umbrella-beach text-gray-400 text-5xl"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Resort Info -->
                        <div class="p-6">
                            <!-- Resort Header -->
                            <div class="flex items-center space-x-3 mb-3">
                                <div class="w-12 h-12 rounded-full overflow-hidden flex-shrink-0">
                                    @if($resort->profile_avatar)
                                        <img src="{{ Storage::url($resort->profile_avatar) }}" 
                                             alt="{{ $resort->business_name }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-cyan-500 flex items-center justify-center">
                                            <i class="fas fa-umbrella-beach text-white text-lg"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-lg text-gray-900 line-clamp-1">
                                        {{ $resort->business_name }}
                                    </h3>
                                    <p class="text-sm text-gray-500 line-clamp-1">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        {{ $resort->address ?? 'Lagonoy, Camarines Sur' }}
                                    </p>
                                </div>
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                    Published
                                </span>
                            </div>

                            @if($resort->description)
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                    {{ $resort->description }}
                                </p>
                            @endif

                            <!-- Actions -->
                            <div class="mt-4">
                                <a href="{{ route('public.resorts.show', $resort->id) }}" 
                                   class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center text-lg font-medium">
                                    <i class="fas fa-eye mr-2"></i>Read More
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $resorts->links() }}
            </div>
        @else
            <!-- No Resorts Message -->
            <div class="text-center py-16">
                <i class="fas fa-umbrella-beach text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No Resorts Available</h3>
                <p class="text-gray-500">Check back later for new resort listings!</p>
            </div>
        @endif
    </div>
</div>
@endsection
