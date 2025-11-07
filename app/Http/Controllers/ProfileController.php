<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    /**
     * Update the user's profile avatar.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'profile_avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $user = $request->user();
        
        // Delete old avatar if exists
        if ($user->profile && $user->profile->profile_picture) {
            Storage::disk('public')->delete($user->profile->profile_picture);
        }

        // Store new avatar
        $path = $request->file('profile_avatar')->store('profile-pictures', 'public');
        
        // Update or create profile
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            ['profile_picture' => $path]
        );

        return response()->json([
            'success' => true,
            'avatar_url' => Storage::url($path)
        ]);
    }

    public function show()
    {
        $user = Auth::user();
        $profile = $user->profile;
        
        return view('profile.show', compact('user', 'profile'));
    }

    public function setup()
    {
        $user = Auth::user();
        
        // If user already has a profile, redirect to dashboard
        if ($user->profile) {
            return redirect()->route('dashboard');
        }
        
        // If business owner, show business setup form
        if ($user->role === 'business_owner') {
            return view('profile.business-setup');
        }
        
        // If customer, show regular profile setup
        return view('profile.setup');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        if ($user->role === 'business_owner') {
            return $this->storeBusinessProfile($request);
        }
        
        return $this->storeCustomerProfile($request);
    }

    private function storeCustomerProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'birthday' => 'required|date',
            'age' => 'required|integer|min:1|max:120',
            'sex' => 'required|in:Male,Female,Other',
            'phone_number' => 'required|string|max:20',
            'location' => 'required|string|max:255',
            'bio' => 'nullable|string|max:500',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        // Create profile
        $profileData = [
            'user_id' => $user->id,
            'full_name' => $validated['full_name'],
            'birthday' => $validated['birthday'],
            'age' => $validated['age'],
            'sex' => $validated['sex'],
            'phone_number' => $validated['phone_number'],
            'location' => $validated['location'],
            'bio' => $validated['bio'],
        ];

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $profileData['profile_picture'] = $path;
        }

        Profile::create($profileData);

        return redirect()->route('customer.products')
            ->with('success', 'Profile setup completed successfully!');
    }

    private function storeBusinessProfile(Request $request)
    {
        $validated = $request->validate([
            // Personal Information
            'full_name' => 'required|string|max:255',
            'birthday' => 'required|date',
            'age' => 'required|integer|min:1|max:120',
            'sex' => 'required|in:Male,Female,Other',
            'location' => 'required|string|max:255',
            // Business Information
            'business_name' => 'required|string|max:255',
            'business_info' => 'required|string|max:1000',
            'business_location' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email_address' => 'nullable|email|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
        ]);

        $user = Auth::user();
        
        // Create customer profile with personal information and social media fields
        $profileData = [
            'user_id' => $user->id,
            'full_name' => $validated['full_name'],
            'birthday' => $validated['birthday'],
            'age' => $validated['age'],
            'sex' => $validated['sex'],
            'phone_number' => $validated['phone_number'],
            'location' => $validated['location'],
            'bio' => $validated['business_info'],
            'facebook' => $validated['facebook'] ?? null,
            'instagram' => $validated['instagram'] ?? null,
            'twitter' => $validated['twitter'] ?? null,
        ];

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $profileData['profile_picture'] = $path;
        }

        $profile = Profile::create($profileData);

        // Create business record
        $businessData = [
            'owner_id' => $user->id,
            'name' => $validated['business_name'],
            'description' => $validated['business_info'],
            'address' => $validated['business_location'],
            'contact_number' => $validated['phone_number'],
        ];

        // Create business using Business model
        $business = \App\Models\Business::create($businessData);

        return redirect()->route('business.setup')
            ->with('success', 'Business profile setup completed! Please complete your business setup.');
    }

    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile;
        
        if (!$profile) {
            return redirect()->route('profile.setup');
        }
        
        return view('profile.edit', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;
        
        if (!$profile) {
            return redirect()->route('profile.setup');
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'birthday' => 'required|date',
            'age' => 'required|integer|min:1|max:120',
            'sex' => 'required|in:Male,Female,Other',
            'phone_number' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000', // Increased for business descriptions
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // For business owners, update business profile avatar instead
            if ($user->role === 'business_owner' && $user->businessProfile) {
                // Delete old business avatar if exists
                if ($user->businessProfile->profile_avatar) {
                    Storage::disk('public')->delete($user->businessProfile->profile_avatar);
                }
                
                $path = $request->file('profile_picture')->store('business-avatars', 'public');
                $user->businessProfile->profile_avatar = $path;
                $user->businessProfile->save();
                
                // Remove profile_picture from validated data since we're not updating it
                unset($validated['profile_picture']);
            } else {
                // For customers and admins, update personal profile picture
                // Delete old profile picture if exists
                if ($profile->profile_picture) {
                    Storage::disk('public')->delete($profile->profile_picture);
                }
                
                $path = $request->file('profile_picture')->store('profile-pictures', 'public');
                $validated['profile_picture'] = $path;
            }
        }

        // For business owners, update bio in BusinessProfile as description
        if ($user->role === 'business_owner' && $user->businessProfile) {
            // Save bio to BusinessProfile description instead
            $user->businessProfile->description = $validated['bio'] ?? null;
            $user->businessProfile->facebook_page = $validated['facebook'] ?? null;
            $user->businessProfile->instagram_url = $validated['instagram'] ?? null;
            $user->businessProfile->twitter_url = $validated['twitter'] ?? null;
            $user->businessProfile->save();
            
            // Remove bio from profile update for business owners
            unset($validated['bio']);
        }
        
        $profile->update($validated);
        
        // Also update user's name if full_name changed
        if ($user->name !== $validated['full_name']) {
            $user->name = $validated['full_name'];
            $user->save();
        }

        return redirect()->route('profile.show')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Handle AJAX profile picture update.
     */
    public function updatePicture(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Ensure profile exists
        $profile = $user->profile;
        if (!$profile) {
            $profile = new Profile([
                'user_id' => $user->id,
                'full_name' => $user->name ?? null,
            ]);
        }

        // Delete old profile picture if exists
        if ($profile->profile_picture) {
            Storage::disk('public')->delete($profile->profile_picture);
        }

        // Store new picture
        $path = $request->file('profile_picture')->store('profile-pictures', 'public');
        $profile->profile_picture = $path;

        // Persist profile
        $profile->exists ? $profile->save() : $profile->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile picture updated successfully.',
            'url' => Storage::url($path),
        ]);
    }

    // Legacy methods for backward compatibility
    public function showSetupForm()
    {
        return $this->setup();
    }

    public function storeProfile(Request $request)
    {
        return $this->store($request);
    }

    /**
     * Delete the user's account and all related data.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAccount()
    {
        $user = Auth::user();

        try {
            \DB::beginTransaction();

            // Delete profile picture if exists
            if ($user->profile && $user->profile->profile_picture) {
                Storage::disk('public')->delete($user->profile->profile_picture);
            }

            // Delete user's profile
            if ($user->profile) {
                $user->profile->forceDelete();
            }

            // Delete business-related data if business owner
            if ($user->role === 'business_owner' && $user->businessProfile) {
                // Delete business profile images
                if ($user->businessProfile->cover_image) {
                    Storage::disk('public')->delete($user->businessProfile->cover_image);
                }

                // Delete business galleries
                if ($user->businessProfile->galleries) {
                    foreach ($user->businessProfile->galleries as $gallery) {
                        if ($gallery->image_path) {
                            Storage::disk('public')->delete($gallery->image_path);
                        }
                        $gallery->forceDelete();
                    }
                }

                // Delete business profile
                $user->businessProfile->forceDelete();
            }

            // Delete user's orders
            if ($user->orders) {
                $user->orders()->forceDelete();
            }

            // Delete user's cart items
            if ($user->cart) {
                $user->cart()->forceDelete();
            }

            // Delete user's sent and received messages
            $user->sentMessages()->forceDelete();
            $user->receivedMessages()->forceDelete();

            // Finally, PERMANENTLY delete the user account from database
            $user->forceDelete();

            \DB::commit();

            // Logout the user
            Auth::logout();

            return redirect()->route('home')
                ->with('success', 'Your account has been permanently deleted. We\'re sorry to see you go!');

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error deleting account: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'An error occurred while deleting your account. Please try again or contact support.');
        }
    }
}
