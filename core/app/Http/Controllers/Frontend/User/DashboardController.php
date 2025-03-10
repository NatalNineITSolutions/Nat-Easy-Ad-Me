<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Frontend\ListingFavorite;
use App\Models\Frontend\Review;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user_id = Auth::guard('web')->user()->id;
        $user = User::with('listings', 'reviews', 'user_country','user_state')->findOrFail($user_id);

        // listings
        $user_ads_posted = $user->listings->count();
        $user_active_listings = $user->listings->where('is_published', 1)->where('status', 1)->count();
        $user_deactivated_ads = $user->listings->where('is_published', 0)->where('status', 0)->count();
        $user_favorite_ads =   ListingFavorite::where('user_id', $user_id)->count();

        // Ratings
        $averageRating = $user->reviews?->avg('rating');
        $user_review_count = $user->reviews?->count();

        // user given reviews
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
}
