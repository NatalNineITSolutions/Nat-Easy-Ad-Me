<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Frontend\ListingFavorite;
use App\Models\Frontend\Review;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user_id = Auth::guard('web')->user()->id;
        $user = User::with('listings', 'reviews', 'user_country', 'user_state')->findOrFail($user_id);

        $user_ads_posted = $user->listings->count();
        $user_active_listings = $user->listings->where('is_published', 1)->where('status', 1)->count();
        $user_deactivated_ads = $user->listings->where('is_published', 0)->where('status', 0)->count();
        $user_favorite_ads = ListingFavorite::where('user_id', $user_id)->count();

        $averageRating = $user->reviews?->avg('rating');
        $user_review_count = $user->reviews?->count();

        $user_given_reviews = Review::where('reviewer_id', $user_id)->take(500)->get();

        return view('frontend.user.dashboard.dashboard', [
            'user' => $user,
            'user_ads_posted' => $user_ads_posted,
            'user_active_listings' => $user_active_listings,
            'user_deactivated_ads' => $user_deactivated_ads,
            'user_favorite_ads' => $user_favorite_ads,
            'averageRating' => $averageRating,
            'user_review_count' => $user_review_count,
            'user_given_reviews' => $user_given_reviews,
        ]);
    }

    public function genology()
    {
        $user_id = Auth::id();

        // Eager load the binary tree relationships recursively
        $user = User::with([
            'leftChild.userBvs',
            'rightChild.userBvs',
            'leftChild.leftChild',
            'rightChild.rightChild'
        ])->where('id', $user_id)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['error' => __('User not found')]);
        }

        // Recursively calculate BV for each node
        $this->calculateBV($user);

        // Prepare the MLM tree data
        $mlmTree = $user;

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'mlmTree' => $mlmTree,
            ]);
        }

        return view('frontend.user.genology.genology', compact('mlmTree'));
    }

    /**
     * Recursively calculate BV points for each user in the MLM tree.
     */
    /**
     * Recursively calculate BV points for each user in the MLM tree.
     */
    private function calculateBV(&$node)
    {
        if (!$node) {
            Log::warning('Node is null in calculateBV');
            return;
        }

        // Calculate BV for the current node
        $node->leftBV = $node->leftChild ? $node->leftChild->userBvs->sum('bv_points') : 0;
        $node->rightBV = $node->rightChild ? $node->rightChild->userBvs->sum('bv_points') : 0;

        // Debug: Log calculated BV points
        Log::info('Calculated BV points for node:', [
            'node_id' => $node->id,
            'leftBV' => $node->leftBV,
            'rightBV' => $node->rightBV,
        ]);

        // Recursively calculate BV for left and right children
        if ($node->leftChild) {
            $this->calculateBV($node->leftChild);
        }

        if ($node->rightChild) {
            $this->calculateBV($node->rightChild);
        }
    }

}
