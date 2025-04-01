<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Frontend\ListingFavorite;
use App\Models\Frontend\Review;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // public function dashboard()
    // {
    //     $user_id = Auth::guard('web')->user()->id;
    //     $user = User::with('listings', 'reviews', 'user_country', 'user_state')->findOrFail($user_id);

    //     $user_ads_posted = $user->listings->count();
    //     $user_active_listings = $user->listings->where('is_published', 1)->where('status', 1)->count();
    //     $user_deactivated_ads = $user->listings->where('is_published', 0)->where('status', 0)->count();
    //     $user_favorite_ads = ListingFavorite::where('user_id', $user_id)->count();

    //     $averageRating = $user->reviews?->avg('rating');
    //     $user_review_count = $user->reviews?->count();

    //     $user_given_reviews = Review::where('reviewer_id', $user_id)->take(500)->get();

    //     return view('frontend.user.dashboard.dashboard', [
    //         'user' => $user,
    //         'user_ads_posted' => $user_ads_posted,
    //         'user_active_listings' => $user_active_listings,
    //         'user_deactivated_ads' => $user_deactivated_ads,
    //         'user_favorite_ads' => $user_favorite_ads,
    //         'averageRating' => $averageRating,
    //         'user_review_count' => $user_review_count,
    //         'user_given_reviews' => $user_given_reviews,
    //     ]);
    // }


    public function dashboard()
    {
        $user_id = Auth::guard('web')->user()->id;
        $user = User::with(['listings', 'reviews', 'user_country', 'user_state', 'membershipUser', 'membershipHistory'])
            ->findOrFail($user_id);

        $user_ads_posted = $user->listings->count();
        $user_active_listings = $user->listings->where('is_published', 1)->where('status', 1)->count();
        $user_deactivated_ads = $user->listings->filter(function ($listing) {
            return $listing->is_published == 0 || $listing->status == 0;
        })->count();

        $user_favorite_ads = ListingFavorite::where('user_id', $user_id)->count();

        // Get remaining listings from membership history
        $remaining_listings = optional($user->membershipHistory)->listing_limit - $user_ads_posted ?? 0;
        $listing_limit = optional($user->membershipUser)->listing_limit ?? 0;

        // Calculate if upgrade should be shown
        $show_upgrade = ($listing_limit > 0 && $remaining_listings === 0);

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
            'remaining_listings' => $remaining_listings === 0 ? 0 : $remaining_listings, // Ensure no negative numbers
            'listing_limit' => $listing_limit,
            'show_upgrade' => $show_upgrade
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

    public function getChildren(Request $request, $id)
    {
        // Find the parent by ID and eager load only its immediate children with BV data
        $parent = User::with([
            'leftChild.userBvs',
            'rightChild.userBvs'
        ])->find($id);

        if (!$parent) {
            return redirect()->back()->withErrors(['error' => __('Parent not found')]);
        }

        // Calculate BV for the parent and its immediate children if needed
        $this->calculateBV($parent);

        // Redirect to a new page that displays the parent's node and its children
        // Create a dedicated view for this, e.g. "frontend.user.genology.show_children"
        return view('frontend.user.genology.show_children', compact('parent'));
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
