<?php

namespace App\Http\Controllers;

use App\Models\BusinessProfile;
use App\Models\Business;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    /**
     * Display a listing of the hotels for PUBLIC access.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fair display algorithm: Use daily-seeded random order for equal visibility
        $dailySeed = (int) date('Ymd');
        srand($dailySeed);
        
        $hotels = BusinessProfile::with(['business'])
            ->where('business_type', 'hotel')
            ->where('status', 'approved')
            ->whereHas('business', function($q) {
                $q->where('is_published', true);
            })
            ->inRandomOrder()
            ->paginate(12);
        
        return view('hotels.index', compact('hotels'));
    }

    /**
     * Display a listing of the hotels for CUSTOMER access.
     *
     * @return \Illuminate\View\View
     */
    public function customerIndex()
    {
        // Fair display algorithm: Use daily-seeded random order for equal visibility
        $dailySeed = (int) date('Ymd');
        srand($dailySeed);
        
        $hotels = BusinessProfile::with(['business'])
            ->where('business_type', 'hotel')
            ->where('status', 'approved')
            ->whereHas('business', function($q) {
                $q->where('is_published', true);
            })
            ->inRandomOrder()
            ->paginate(12);
        
        return view('customer.hotels', compact('hotels'));
    }

    /**
     * Display the specified hotel for PUBLIC access.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $hotel = BusinessProfile::with(['business', 'galleries', 'rooms'])
            ->where('business_type', 'hotel')
            ->where('status', 'approved')
            ->whereHas('business', function($q) {
                $q->where('is_published', true);
            })
            ->findOrFail($id);
        
        return view('hotels.show', compact('hotel'));
    }

    /**
     * Display the specified hotel for CUSTOMER access.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function customerShow($id)
    {
        $hotel = BusinessProfile::with(['business', 'galleries', 'rooms'])
            ->where('business_type', 'hotel')
            ->where('status', 'approved')
            ->whereHas('business', function($q) {
                $q->where('is_published', true);
            })
            ->findOrFail($id);
        
        return view('customer.hotel-show', compact('hotel'));
    }
}