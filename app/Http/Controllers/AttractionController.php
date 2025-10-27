<?php

namespace App\Http\Controllers;

use App\Models\TouristSpot;
use Illuminate\Http\Request;

class AttractionController extends Controller
{
    /**
     * Display a listing of the attractions for PUBLIC access.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fair display algorithm: Use daily-seeded random order for equal visibility
        $dailySeed = (int) date('Ymd');
        srand($dailySeed);
        
        $attractions = TouristSpot::where('is_active', true)
            ->inRandomOrder()
            ->paginate(12);
        
        return view('attractions.index', compact('attractions'));
    }

    /**
     * Display a listing of the attractions for CUSTOMER access.
     *
     * @return \Illuminate\View\View
     */
    public function customerIndex()
    {
        // Fair display algorithm: Use daily-seeded random order for equal visibility
        $dailySeed = (int) date('Ymd');
        srand($dailySeed);
        
        $attractions = TouristSpot::where('is_active', true)
            ->inRandomOrder()
            ->paginate(12);
        
        return view('customer.attractions', compact('attractions'));
    }

    /**
     * Display the specified attraction for PUBLIC access.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $attraction = TouristSpot::where('is_active', true)
            ->findOrFail($id);
        
        return view('attractions.show', compact('attraction'));
    }

    /**
     * Display the specified attraction for CUSTOMER access.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function customerShow($id)
    {
        $attraction = TouristSpot
            ->where('is_active', true)
            ->findOrFail($id);
        
        return view('customer.tourist-spot-show', compact('attraction'));
    }
}