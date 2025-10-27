@extends(auth()->check() && auth()->user()->role === 'customer' ? 'layouts.customer' : 'layouts.public')

@section('title', 'Tourist Attractions - Pagsurong Lagonoy')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8 py-4 sm:py-6 md:py-8">
            <div class="text-center">
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mb-1 sm:mb-2">
                    <i class="fas fa-map-marked-alt mr-2 sm:mr-3 text-green-600"></i>
                    Tourist Attractions
                </h1>
                <p class="text-sm sm:text-base text-gray-600 max-w-2xl mx-auto">
                    Discover must-visit places and hidden gems in Lagonoy
                </p>
            </div>
        </div>
    </div>

    <!-- Attractions Grid -->
    <div class="max-w-7xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8 py-4 sm:py-6 md:py-8">
        @if($attractions->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 md:gap-6 lg:gap-8">
                @foreach($attractions as $attraction)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                        <!-- Attraction Image -->
                        <div class="aspect-w-16 aspect-h-12 bg-gray-200">
                            @if($attraction->cover_image)
                                <img src="{{ Storage::url($attraction->cover_image) }}" 
                                     alt="{{ $attraction->name }}" 
                                     class="w-full h-40 sm:h-48 md:h-56 lg:h-64 object-cover">
                            @else
                                <div class="w-full h-40 sm:h-48 md:h-56 lg:h-64 bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-map-marked-alt text-gray-400 text-3xl sm:text-4xl md:text-5xl"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Attraction Info -->
                        <div class="p-2 sm:p-3 md:p-4 lg:p-6">
                            <h3 class="font-semibold text-sm sm:text-base md:text-lg text-gray-900 mb-1 sm:mb-2 line-clamp-2">
                                {{ $attraction->name }}
                            </h3>
                            <p class="text-xs sm:text-sm text-gray-500 mb-2 line-clamp-1">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                {{ $attraction->location ?? 'Lagonoy, Camarines Sur' }}
                            </p>

                            @if($attraction->description)
                                <p class="hidden sm:block text-gray-600 text-xs sm:text-sm mb-2 sm:mb-3 line-clamp-2">
                                    {{ $attraction->description }}
                                </p>
                            @endif

                            <!-- Actions -->
                            <div class="mt-2 sm:mt-3 md:mt-4">
                                <a href="{{ route('public.attractions.show', $attraction->id) }}" 
                                   class="w-full bg-green-600 hover:bg-green-700 text-white py-2 sm:py-2.5 md:py-3 px-3 sm:px-4 rounded-lg transition-colors duration-200 flex items-center justify-center text-sm sm:text-base md:text-lg font-medium">
                                    <i class="fas fa-eye mr-1 sm:mr-2 text-sm sm:text-base"></i><span class="hidden sm:inline">Read More</span><span class="sm:hidden">View</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $attractions->links() }}
            </div>
        @else
            <!-- No Attractions Message -->
            <div class="text-center py-16">
                <i class="fas fa-map-marked-alt text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No Tourist Attractions Available</h3>
                <p class="text-gray-500">Check back later for new attraction listings!</p>
            </div>
        @endif
    </div>
</div>
@endsection
