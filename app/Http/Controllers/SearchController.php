<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Business;
use App\Models\Attraction;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        try {
            $query = $request->input('q', '');
            
            if (strlen($query) < 2) {
                return response()->json([
                    'success' => true,
                    'query' => $query,
                    'results' => [
                        'products' => [],
                        'shops' => [],
                        'hotels' => [],
                        'resorts' => [],
                        'attractions' => []
                    ],
                    'total' => 0
                ]);
            }

            $results = [
                'products' => [],
                'shops' => [],
                'hotels' => [],
                'resorts' => [],
                'attractions' => []
            ];

            // Search Products
            try {
                $products = Product::with('business')->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%")
                    ->limit(20)
                    ->get()
                    ->map(function($product) {
                        // Link to shop page instead of product page
                        $shopId = $product->business_id;
                        return [
                            'id' => $product->id,
                            'name' => $product->name,
                            'description' => $product->description ? substr($product->description, 0, 100) : '',
                            'price' => $product->price,
                            'image' => $product->image ? asset('storage/' . $product->image) : null,
                            'business_name' => $product->business->name ?? 'Shop',
                            'url' => auth()->check() && auth()->user()->role === 'customer' 
                                ? route('customer.shops.show', $shopId)
                                : route('public.shops.show', $shopId),
                            'type' => 'product'
                        ];
                    });
                $results['products'] = $products;
            } catch (\Exception $e) {
                $results['products'] = collect([]);
            }

            // Search Shops (exclude hotels and resorts)
            try {
                $shops = Business::with('businessProfile')
                    ->where(function($q) use ($query) {
                        $q->where('name', 'LIKE', "%{$query}%")
                          ->orWhere('description', 'LIKE', "%{$query}%");
                    })
                    ->whereNotIn('business_type', ['hotel', 'resort'])
                    ->limit(20)
                    ->get()
                    ->map(function($shop) {
                        $coverImage = null;
                        if ($shop->businessProfile && $shop->businessProfile->cover_image) {
                            $coverImage = asset('storage/' . $shop->businessProfile->cover_image);
                        }
                        return [
                            'id' => $shop->id,
                            'name' => $shop->name ?? 'Shop',
                            'description' => $shop->description ? substr($shop->description, 0, 100) : '',
                            'image' => $coverImage,
                            'address' => $shop->address ?? '',
                            'url' => auth()->check() && auth()->user()->role === 'customer'
                                ? route('customer.shops.show', $shop->id)
                                : route('public.shops.show', $shop->id),
                            'type' => 'shop'
                        ];
                    });
                $results['shops'] = $shops;
            } catch (\Exception $e) {
                $results['shops'] = collect([]);
            }

            // Search Hotels
            try {
                $hotels = Business::with('businessProfile')
                    ->where('business_type', 'hotel')
                    ->where(function($q) use ($query) {
                        $q->where('name', 'LIKE', "%{$query}%")
                          ->orWhere('description', 'LIKE', "%{$query}%");
                    })
                    ->limit(20)
                    ->get()
                    ->map(function($hotel) {
                        $coverImage = null;
                        if ($hotel->businessProfile && $hotel->businessProfile->cover_image) {
                            $coverImage = asset('storage/' . $hotel->businessProfile->cover_image);
                        }
                        return [
                            'id' => $hotel->id,
                            'name' => $hotel->name ?? 'Hotel',
                            'description' => $hotel->description ? substr($hotel->description, 0, 100) : '',
                            'image' => $coverImage,
                            'address' => $hotel->address ?? '',
                            'star_rating' => $hotel->star_rating ?? null,
                            'url' => auth()->check() && auth()->user()->role === 'customer'
                                ? route('customer.hotels.show', $hotel->id)
                                : route('public.hotels.show', $hotel->id),
                            'type' => 'hotel'
                        ];
                    });
                $results['hotels'] = $hotels;
            } catch (\Exception $e) {
                $results['hotels'] = collect([]);
            }

            // Search Resorts
            try {
                $resorts = Business::with('businessProfile')
                    ->where('business_type', 'resort')
                    ->where(function($q) use ($query) {
                        $q->where('name', 'LIKE', "%{$query}%")
                          ->orWhere('description', 'LIKE', "%{$query}%");
                    })
                    ->limit(20)
                    ->get()
                    ->map(function($resort) {
                        $coverImage = null;
                        if ($resort->businessProfile && $resort->businessProfile->cover_image) {
                            $coverImage = asset('storage/' . $resort->businessProfile->cover_image);
                        }
                        return [
                            'id' => $resort->id,
                            'name' => $resort->name ?? 'Resort',
                            'description' => $resort->description ? substr($resort->description, 0, 100) : '',
                            'image' => $coverImage,
                            'address' => $resort->address ?? '',
                            'url' => auth()->check() && auth()->user()->role === 'customer'
                                ? route('customer.resorts.show', $resort->id)
                                : route('public.resorts.show', $resort->id),
                            'type' => 'resort'
                        ];
                    });
                $results['resorts'] = $resorts;
            } catch (\Exception $e) {
                $results['resorts'] = collect([]);
            }

            // Search Attractions
            try {
                $attractions = Attraction::where(function($q) use ($query) {
                        $q->where('name', 'LIKE', "%{$query}%")
                          ->orWhere('location', 'LIKE', "%{$query}%")
                          ->orWhere('description', 'LIKE', "%{$query}%")
                          ->orWhere('additional_info', 'LIKE', "%{$query}%");
                    })
                    ->limit(20)
                    ->get()
                    ->map(function($attraction) {
                        return [
                            'id' => $attraction->id,
                            'name' => $attraction->name,
                            'description' => $attraction->description ? substr($attraction->description, 0, 100) : '',
                            'location' => $attraction->location ?? '',
                            'image' => $attraction->cover_image ? asset('storage/' . $attraction->cover_image) : null,
                            'entrance_fee' => $attraction->entrance_fee ?? null,
                            'url' => auth()->check() && auth()->user()->role === 'customer'
                                ? route('customer.attractions.show', $attraction->id)
                                : route('public.attractions.show', $attraction->id),
                            'type' => 'attraction'
                        ];
                    });
                $results['attractions'] = $attractions;
            } catch (\Exception $e) {
                \Log::error('Attraction search error: ' . $e->getMessage());
                $results['attractions'] = collect([]);
            }

            $total = collect($results)->sum(function($items) {
                return count($items);
            });

            return response()->json([
                'success' => true,
                'query' => $query,
                'results' => $results,
                'total' => $total
            ]);
        } catch (\Exception $e) {
            \Log::error('Search error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'An error occurred while searching',
                'message' => $e->getMessage(),
                'query' => $request->input('q', ''),
                'results' => [
                    'products' => [],
                    'shops' => [],
                    'hotels' => [],
                    'resorts' => [],
                    'attractions' => []
                ],
                'total' => 0
            ], 500);
        }
    }
}
