<?php

namespace App\Http\Controllers;

use App\Models\BusinessProfile;
use App\Models\HotelComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HotelCommentController extends Controller
{
    public function store(Request $request, $hotelId)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $hotel = BusinessProfile::where('id', $hotelId)
            ->where('business_type', 'hotel')
            ->firstOrFail();

        $comment = HotelComment::create([
            'business_profile_id' => $hotel->id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Comment added successfully',
            'comment' => [
                'id' => $comment->id,
                'comment' => $comment->comment,
                'user_name' => Auth::user()->name,
                'created_at' => $comment->created_at->format('M d, Y'),
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($commentId)
    {
        $comment = HotelComment::findOrFail($commentId);

        // Check if the authenticated user owns this comment
        if (Auth::id() !== $comment->user_id) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized to delete this comment'
            ], 403);
        }

        try {
            $comment->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Comment deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to delete comment'
            ], 500);
        }
    }
}
