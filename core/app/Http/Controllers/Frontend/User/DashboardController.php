<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Frontend\ListingFavorite;
use App\Models\Frontend\Review;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Backend\Category;
use Modules\CountryManage\app\Models\Country;
use App\Models\JobDetail;
use App\Models\Backend\SubCategory;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user_id = Auth::guard('web')->user()->id;
        $user = User::with([
            'listings',
            'reviews',
            'user_country',
            'user_state',
            'membershipUser',
            'membershipHistory',
            'parent',
        ])->findOrFail($user_id);

        // Get current membership details
        $current_membership = optional($user->membershipUser);
        $previous_membership = $user->membershipHistory()->latest('created_at')->first();

        // Ensure user has an active membership
        // if (!$current_membership->id) {
        //     return back()->with('error', 'No active membership found.');
        // }

        // Count all ads posted by the user
        $user_ads_posted = $user->listings()->count();

        $membership_upgraded = $previous_membership && $previous_membership->membership_id != $current_membership->membership_id;

        $remaining_listings = $current_membership->listing_limit;

        $user_active_listings = $user->listings()->where('is_published', 1)->where('status', 1)->count();
        $user_deactivated_ads = $user->listings()->where(function ($query) {
            $query->where('is_published', 0)->orWhere('status', 0);
        })->count();
        $user_favorite_ads = ListingFavorite::where('user_id', $user_id)->count();

        $show_upgrade = ($current_membership->listing_limit > 0 && $remaining_listings === 0);

        $averageRating = $user->reviews?->avg('rating');
        $user_review_count = $user->reviews?->count();
        $user_given_reviews = Review::where('reviewer_id', $user_id)->take(500)->get();

        $age = null;
        if ($user->dob) {
            $age = now()->diffInYears($user->dob);
        }

        $bvvalue = get_static_option('payout_value') ?? 0;

        $directReferralsCount = $user->children()->count();
        $directReferralsLimit = get_static_option('maximum_referrals') ?? 0;

        $leftBvPoints = $user->leftChild ? $user->leftChild->userBvs->sum('bv_points') : 0;
        $rightBvPoints = $user->rightChild ? $user->rightChild->userBvs->sum('bv_points') : 0;
        $totalBvPoints = $directReferralsCount * $bvvalue;

        $referralCommissionRate = $user->referral_commission ?? 0;

        $referralCommission = $referralCommissionRate;
        // Fetch the rate, defaulting to null so we can distinguish “not set” vs. zero
        $bpConversionRate = get_static_option('bp_value');

        if (empty($bpConversionRate) || $bpConversionRate <= 0) {
            error_log("Warning: invalid BP conversion rate: " . var_export($bpConversionRate, true));
            $bpConversionRate = 1;
        }

        $leftBP = floor($leftBvPoints / $bpConversionRate);
        $rightBP = floor($rightBvPoints / $bpConversionRate);


        $equalizedBP = min($leftBP, $rightBP);

        $balancedLeftBP = $leftBP - $equalizedBP;
        $balancedRightBP = $rightBP - $equalizedBP;

        $businesspoint = "{$leftBP} <> {$rightBP}";
        $totalBP = "{$leftBvPoints} <> {$rightBvPoints}";
        $balancedBP = "{$balancedLeftBP} <> {$balancedRightBP}";

        $bvFromReferrals = $user->children()->with('userBvs')->get()->sum(function ($child) {
            return $child->userBvs->sum('bv_points');
        });

        $bv_value = get_static_option('payout_value') ?? 0;

        $income = $directReferralsCount * $bv_value;

        $showIncome = $equalizedBP > 0;

        $selfPurchasedBv = 0;
        if ($current_membership->id) {
            $selfPurchasedBv = optional($current_membership->membership)->bv_points ?? 0;
        }

        return view('frontend.user.dashboard.dashboard', [
            'user' => $user,
            'user_ads_posted' => $user_ads_posted,
            'user_active_listings' => $user_active_listings,
            'user_deactivated_ads' => $user_deactivated_ads,
            'user_favorite_ads' => $user_favorite_ads,
            'averageRating' => $averageRating,
            'user_review_count' => $user_review_count,
            'user_given_reviews' => $user_given_reviews,
            'remaining_listings' => $remaining_listings,
            'listing_limit' => $current_membership->listing_limit,
            'show_upgrade' => $show_upgrade,
            'leftBvPoints' => $leftBvPoints,
            'rightBvPoints' => $rightBvPoints,
            'age' => $age,
            'totalBvPoints' => $totalBvPoints,
            'directReferralsCount' => $directReferralsCount,
            'directReferralsLimit' => $directReferralsLimit,
            'referralCommission' => $referralCommission,
            'referralCommissionRate' => $referralCommissionRate,
            'totalBP' => $totalBP,
            'equalizedBP' => $equalizedBP,
            'balancedBP' => $balancedBP,
            'bvFromReferrals' => $bvFromReferrals,
            'income' => $income,
            'showIncome' => $showIncome,
            'businesspoint' => $businesspoint,
            'selfPurchasedBv' => $selfPurchasedBv,
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

    public function addjobListing(Request $request)
    {
        /// Get basic data needed for form
        $formData = [
            'categories' => Category::where('status', 1)->get(),
            'specific_subcategory' => SubCategory::with([
                'childcategories' => function ($query) {
                    $query->where('status', 1);
                }
            ])
                ->where('id', 107)
                ->where('status', 1)
                ->first(),
            'countries' => Country::where('status', 1)->get(),
        ];

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                // Personal Information
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:500',
                'image' => 'nullable|integer|exists:media_uploads,id',

                // Category Selection
                'child_category_id' => 'required|exists:child_categories,id',

                // Resume/CV
                'work_experience' => 'required|string',
                'education' => 'required|string',
                'skills' => 'required|string',
                'certifications' => 'nullable|string',
                'achievements' => 'nullable|string',
                'projects' => 'nullable|string',
                'summary' => 'required|string|max:1000',
                'portfolio_links' => 'nullable|string',

                // Application Details
                'availability_date' => 'required|date',
                'work_preference' => 'required|in:remote,hybrid,onsite',
                'expected_salary' => 'required|numeric',
                'relocation_willingness' => 'required|boolean',
                'work_authorization' => 'required|string',

                // Location
                'country_id' => 'nullable|exists:countries,id',
                'state_id' => 'nullable|exists:states,id',
                'city_id' => 'nullable|exists:cities,id',
            ]);

            // Create job seeker profile
            JobDetail::create(array_merge(
                $validated,
                [
                    'user_id' => auth()->id(),
                    'image' => $validated['image'] ?? null,
                    'category_id' => $formData['specific_subcategory']->category_id,
                    'sub_category_id' => 107,
                    'child_category_id' => $validated['child_category_id'],
                ]
            ));

            return redirect()->route('user.dashboard')
                ->with('success', 'Profile submitted successfully!');
        }

        return view('frontend.user.listings.add-job-listing', $formData);
    }
}
