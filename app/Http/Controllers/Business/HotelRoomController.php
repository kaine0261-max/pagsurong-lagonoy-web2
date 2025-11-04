<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\HotelRoom;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HotelRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $business = Auth::user()->business;
        $rooms = $business->hotelRooms()
            ->with('business')
            ->latest()
            ->paginate(10);
            
        return view('business.hotel.rooms.index', [
            'rooms' => $rooms,
            'business' => $business
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('business.hotel.rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:20',
            'room_type' => 'required|string|max:100',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
            'amenities' => 'nullable|string'
        ]);

        $business = Auth::user()->business;
        
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('hotel-rooms', 'public');
        }

        $validated['business_id'] = $business->id;
        $validated['is_available'] = $request->has('is_available');

        $room = HotelRoom::create($validated);

        // Return JSON response for AJAX requests
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Room created successfully!',
                'room' => $room
            ]);
        }
        
        return redirect()->route('business.my-hotel')
            ->with('success', 'Room created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HotelRoom $room)
    {
        $this->authorize('view', $room);
        return view('business.hotel.rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HotelRoom $hotelRoom)
    {
        // Temporarily disable authorization for debugging
        // if ($hotelRoom->business_id !== auth()->user()->business->id) {
        //     abort(403, 'Unauthorized');
        // }
        
        // Return JSON response for AJAX requests
        if (request()->expectsJson()) {
            $response = [
                'success' => true,
                'id' => $hotelRoom->id,
                'room_number' => $hotelRoom->room_number,
                'room_type' => $hotelRoom->room_type,
                'price_per_night' => $hotelRoom->price_per_night,
                'capacity' => $hotelRoom->capacity,
                'description' => $hotelRoom->description,
                'amenities' => $hotelRoom->amenities,
                'is_available' => $hotelRoom->is_available,
                'image' => $hotelRoom->image ? Storage::url($hotelRoom->image) : null
            ];
            
            \Log::info('Hotel room edit response:', $response);
            return response()->json($response);
        }
        
        return view('business.hotel.rooms.edit', compact('hotelRoom'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HotelRoom $hotelRoom)
    {
        // Temporarily disable authorization for debugging
        // if ($hotelRoom->business_id !== auth()->user()->business->id) {
        //     abort(403, 'Unauthorized');
        // }

        $validated = $request->validate([
            'room_number' => 'required|string|max:20',
            'room_type' => 'required|string|max:100',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
            'amenities' => 'nullable|string'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($hotelRoom->image) {
                Storage::disk('public')->delete($hotelRoom->image);
            }
            $validated['image'] = $request->file('image')->store('hotel-rooms', 'public');
        }

        $validated['is_available'] = $request->has('is_available');

        $hotelRoom->update($validated);

        // Return JSON response for AJAX requests
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Room updated successfully!',
                'room' => $hotelRoom->fresh()
            ]);
        }

        return redirect()->route('business.my-hotel')
            ->with('success', 'Room updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HotelRoom $hotelRoom)
    {
        // Simple ownership check
        if ($hotelRoom->business_id !== auth()->user()->business->id) {
            abort(403, 'Unauthorized');
        }
        
        // Delete image if exists
        if ($hotelRoom->image) {
            Storage::disk('public')->delete($hotelRoom->image);
        }
        
        $hotelRoom->delete();
        
        // Return JSON response for AJAX requests
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Room deleted successfully!'
            ]);
        }
        
        return redirect()->route('business.my-hotel')
            ->with('success', 'Room deleted successfully.');
    }
}
