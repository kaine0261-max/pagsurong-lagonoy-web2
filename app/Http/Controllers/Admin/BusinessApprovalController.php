<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BusinessStatusUpdated;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BusinessApprovalController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of pending business approvals.
     */
    public function index()
    {
        $pendingBusinesses = BusinessProfile::with('user')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $approvedBusinesses = BusinessProfile::with('user')
            ->where('status', 'approved')
            ->orderBy('approved_at', 'desc')
            ->paginate(10, ['*'], 'approved_page');

        $declinedBusinesses = BusinessProfile::with('user')
            ->where('status', 'declined')
            ->orderBy('updated_at', 'desc')
            ->paginate(10, ['*'], 'declined_page');

        return view('admin.business-approvals.index', compact(
            'pendingBusinesses',
            'approvedBusinesses',
            'declinedBusinesses'
        ));
    }

    /**
     * Display the specified business profile for review.
     */
    public function show(BusinessProfile $business)
    {
        $business->load('user');
        
        // Get the business permit file URLs (now supports multiple files)
        $businessPermitUrls = [];
        if (!empty($business->business_permit_path)) {
            foreach ($business->business_permit_path as $permitPath) {
                $businessPermitUrls[] = [
                    'url' => Storage::url($permitPath),
                    'path' => $permitPath,
                    'name' => basename($permitPath)
                ];
            }
        }
        
        // Get any additional licenses
        $licenses = [];
        if (!empty($business->licenses)) {
            foreach ($business->licenses as $license) {
                $licenses[] = [
                    'url' => Storage::url($license['path']),
                    'name' => $license['original_name']
                ];
            }
        }

        return view('admin.business-approvals.show', compact(
            'business',
            'businessPermitUrls',
            'licenses'
        ));
    }

    /**
     * Approve a business profile.
     */
    public function approve(Request $request, BusinessProfile $business)
    {
        $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        return $this->updateBusinessStatus($business, 'approved', $request->notes);
    }

    /**
     * Decline a business profile.
     */
    public function decline(Request $request, BusinessProfile $business)
    {
        try {
            $request->validate([
                'decline_reason' => 'required|string|max:1000',
            ], [
                'decline_reason.required' => 'Please provide a reason for declining this business.',
                'decline_reason.max' => 'The decline reason must not exceed 1000 characters.',
            ]);

            return $this->updateBusinessStatus($business, 'declined', $request->decline_reason);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error declining business', [
                'business_id' => $business->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Failed to decline business. Please try again.');
        }
    }

    /**
     * Update the business status and notify the owner.
     */
    protected function updateBusinessStatus(BusinessProfile $business, string $status, ?string $notes = null)
    {
        // Ensure the user relationship is loaded
        if (!$business->relationLoaded('user')) {
            $business->load('user');
        }
        
        $payload = [
            'status' => $status,
            'decline_reason' => $status === 'declined' ? $notes : null,
            'approved_at' => $status === 'approved' ? now() : $business->approved_at,
            'approved_by' => $status === 'approved' ? auth()->id() : $business->approved_by,
        ];

        // Auto-publish when approved so it becomes visible to customers
        if ($status === 'approved') {
            $payload['is_published'] = true;
        }

        $business->update($payload);

        // Mirror publish flag to Business entity used for product visibility
        if ($status === 'approved') {
            \App\Models\Business::where('owner_id', $business->user_id)->update(['is_published' => true]);
        }

        // Notify the business owner (do not fail the request if mail transport is unavailable)
        try {
            $this->notifyBusinessOwner($business, $status, $notes);
        } catch (\Throwable $e) {
            \Log::warning('Failed to send business status email', [
                'business_id' => $business->id,
                'status' => $status,
                'error' => $e->getMessage(),
            ]);
        }

        return redirect()
            ->route('admin.business-approvals.index')
            ->with('success', "Business has been {$status} successfully.");
    }

    /**
     * Send notification to business owner about status update.
     */
    protected function notifyBusinessOwner(BusinessProfile $business, string $status, ?string $notes = null)
    {
        $user = $business->user;
        
        if (!$user) {
            \Log::warning('Business owner user not found', ['business_id' => $business->id]);
            return;
        }
        
        // Send email notification
        try {
            Mail::to($user->email)->send(new BusinessStatusUpdated($business, $status, $notes));
        } catch (\Exception $e) {
            \Log::error('Failed to send business status email', [
                'business_id' => $business->id,
                'user_email' => $user->email,
                'status' => $status,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            // Don't throw - allow the status update to succeed even if email fails
        }
        
        // You can also add in-app notifications here
        // $user->notify(new BusinessStatusUpdatedNotification($business, $status, $notes));
    }

    /**
     * Download a business document.
     */
    public function downloadDocument(BusinessProfile $business, string $type, int $index = null)
    {
        $this->authorize('view', $business);
        
        if ($type === 'permit') {
            // Handle business_permit_path as array (supports multiple permits)
            $permits = $business->business_permit_path ?? [];
            
            if ($index !== null && isset($permits[$index])) {
                $filePath = $permits[$index];
            } elseif (count($permits) > 0) {
                // If no index specified, download the first permit
                $filePath = $permits[0];
            } else {
                abort(404, 'No business permit found');
            }
            
            $fileName = 'business_permit_' . ($index !== null ? ($index + 1) . '_' : '') . 
                Str::slug($business->business_name) . '.' . 
                pathinfo($filePath, PATHINFO_EXTENSION);
        } elseif ($type === 'license' && $index !== null && isset($business->licenses[$index])) {
            $filePath = $business->licenses[$index]['path'];
            $fileName = $business->licenses[$index]['original_name'];
        } else {
            abort(404);
        }

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File not found in storage');
        }

        return Storage::disk('public')->download($filePath, $fileName);
    }

    /**
     * Toggle business published status.
     */
    public function togglePublish(BusinessProfile $business)
    {
        $business->update([
            'is_published' => !$business->is_published,
            'published_at' => $business->is_published ? null : now(),
        ]);

        $status = $business->is_published ? 'published' : 'unpublished';
        
        return back()->with('success', "Business has been {$status} successfully.");
    }
}
