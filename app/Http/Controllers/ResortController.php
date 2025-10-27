<?php

namespace App\Http\Controllers;

use App\Models\BusinessProfile;
use App\Models\Business;
use Illuminate\Http\Request;

class ResortController extends Controller
{
    /**
     * Display a listing of the resorts for PUBLIC access.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fair display algorithm: Use daily-seeded random order for equal visibility
        $dailySeed = (int) date('Ymd');
        srand($dailySeed);
        
        $resorts = BusinessProfile::with(['business'])
            ->where('business_type', 'resort')
            ->where('status', 'approved')
            ->whereHas('business', function($q) {
                $q->where('is_published', true);
            })
            ->inRandomOrder()
            ->paginate(12);
        
        return view('resorts.index', compact('resorts'));
    }

    /**
     * Display a listing of the resorts for CUSTOMER access.
     *
     * @return \Illuminate\View\View
     */
    public function customerIndex()
    {
        // Fair display algorithm: Use daily-seeded random order for equal visibility
        $dailySeed = (int) date('Ymd');
        srand($dailySeed);
        
        $resorts = BusinessProfile::with(['business'])
            ->where('business_type', 'resort')
            ->where('status', 'approved')
            ->whereHas('business', function($q) {
                $q->where('is_published', true);
            })
            ->inRandomOrder()
            ->paginate(12);
        
        return view('customer.resorts', compact('resorts'));
    }

    /**
     * Display the specified resort for PUBLIC access.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $resort = BusinessProfile::with(['business', 'galleries', 'resortRooms.images', 'cottages.galleries'])
            ->where('business_type', 'resort')
            ->where('status', 'approved')
            ->whereHas('business', function($q) {
                $q->where('is_published', true);
            })
            ->findOrFail($id);
        
        return view('resorts.show', compact('resort'));
    }

    /**
     * Display the specified resort for CUSTOMER access.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function customerShow($id)
    {
        $resort = BusinessProfile::with(['business', 'galleries', 'resortRooms.images', 'cottages.galleries'])
            ->where('business_type', 'resort')
            ->where('status', 'approved')
            ->whereHas('business', function($q) {
                $q->where('is_published', true);
            })
            ->findOrFail($id);
        
        return view('customer.resort-show', compact('resort'));
    }
}