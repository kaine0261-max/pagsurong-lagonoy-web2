<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TouristSpot;
use App\Models\TouristSpotRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class TouristSpotController extends Controller
{
    public function index()
    {
        $touristSpots = TouristSpot::with('uploader')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.upload-spots', compact('touristSpots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'profile_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'location' => 'nullable|string|max:255',
            'additional_info' => 'nullable|string',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif'
        ]);

        $data = $request->all();
        $data['uploaded_by'] = Auth::id();

        // Handle profile avatar upload
        if ($request->hasFile('profile_avatar')) {
            $data['profile_avatar'] = $request->file('profile_avatar')->store('tourist-spots/avatars', 'public');
        }

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('tourist-spots/covers', 'public');
        }

        // Handle gallery images upload
        $galleryImages = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $path = $file->store('tourist-spots/gallery', 'public');
                $galleryImages[] = $path;
            }
        }
        $data['gallery_images'] = json_encode($galleryImages);

        TouristSpot::create($data);

        return redirect()->route('admin.upload.spots')->with('success', 'Tourist spot uploaded successfully!');
    }

    public function uploadGallery(Request $request)
    {
        $request->validate([
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif'
        ]);

        $uploadedFiles = [];
        
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $path = $file->store('admin/gallery', 'public');
                $uploadedFiles[] = $path;
            }
        }

        return response()->json([
            'success' => true,
            'files' => $uploadedFiles,
            'message' => 'Gallery images uploaded successfully!'
        ]);
    }


    public function edit(TouristSpot $touristSpot)
    {
        return response()->json($touristSpot);
    }

    public function update(Request $request, TouristSpot $touristSpot)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'profile_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'location' => 'nullable|string|max:255',
            'additional_info' => 'nullable|string',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif'
        ]);

        $data = $request->all();

        // Handle profile avatar upload
        if ($request->hasFile('profile_avatar')) {
            if ($touristSpot->profile_avatar) {
                Storage::disk('public')->delete($touristSpot->profile_avatar);
            }
            $data['profile_avatar'] = $request->file('profile_avatar')->store('tourist-spots/avatars', 'public');
        }

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            if ($touristSpot->cover_image) {
                Storage::disk('public')->delete($touristSpot->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('tourist-spots/covers', 'public');
        }

        // Handle gallery images upload
        if ($request->hasFile('gallery_images')) {
            // Delete existing gallery images
            if ($touristSpot->gallery_images) {
                $existingImages = json_decode($touristSpot->gallery_images, true);
                if (is_array($existingImages)) {
                    foreach ($existingImages as $image) {
                        Storage::disk('public')->delete($image);
                    }
                }
            }
            
            // Upload new gallery images
            $galleryImages = [];
            foreach ($request->file('gallery_images') as $file) {
                $path = $file->store('tourist-spots/gallery', 'public');
                $galleryImages[] = $path;
            }
            $data['gallery_images'] = json_encode($galleryImages);
        }

        $touristSpot->update($data);

        return redirect()->route('admin.upload.spots')->with('success', 'Tourist spot updated successfully!');
    }

    public function destroy(TouristSpot $touristSpot)
    {
        // Delete associated files
        if ($touristSpot->profile_avatar) {
            Storage::disk('public')->delete($touristSpot->profile_avatar);
        }
        if ($touristSpot->cover_image) {
            Storage::disk('public')->delete($touristSpot->cover_image);
        }
        
        // Delete gallery images
        if ($touristSpot->gallery_images) {
            $galleryImages = json_decode($touristSpot->gallery_images, true);
            if (is_array($galleryImages)) {
                foreach ($galleryImages as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
        }

        $touristSpot->delete();

        return response()->json(['success' => true, 'message' => 'Tourist spot deleted successfully!']);
    }

    public function removeGalleryImage(Request $request, TouristSpot $touristSpot)
    {
        $request->validate([
            'image_path' => 'required|string',
            'image_index' => 'required|integer|min:0'
        ]);

        $imagePath = $request->input('image_path');
        $imageIndex = $request->input('image_index');

        // Get current gallery images
        $currentImages = [];
        if ($touristSpot->gallery_images) {
            $currentImages = json_decode($touristSpot->gallery_images, true);
            if (!is_array($currentImages)) {
                $currentImages = [];
            }
        }

        // Check if the image exists at the specified index
        if (!isset($currentImages[$imageIndex]) || $currentImages[$imageIndex] !== $imagePath) {
            return response()->json([
                'success' => false,
                'message' => 'Image not found or index mismatch'
            ]);
        }

        // Delete the physical file
        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

        // Remove the image from the array
        array_splice($currentImages, $imageIndex, 1);

        // Update the database
        $touristSpot->gallery_images = json_encode($currentImages);
        $touristSpot->save();

        return response()->json([
            'success' => true,
            'message' => 'Gallery image removed successfully',
            'updated_gallery' => $currentImages
        ]);
    }
}
