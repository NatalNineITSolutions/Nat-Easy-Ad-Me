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
use Modules\CountryManage\app\Models\City;
use Modules\CountryManage\app\Models\State;
use App\Models\Backend\IdentityVerification;
use Carbon\Carbon;
use App\Models\UserPayoutDetail;
use Barryvdh\DomPDF\Facade\Pdf;

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
            'children.userBvs',
            'leftChild.userBvs',
            'rightChild.userBvs'
        ])->findOrFail($user_id);

        $current_membership = optional($user->membershipUser);
        $previous_membership = $user->membershipHistory()->latest('created_at')->first();

        // Basic user stats
        $user_ads_posted = $user->listings()->count();
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
        $age = $user->dob ? now()->diffInYears($user->dob) : null;

        // BV and BP configuration
        $bvvalue = get_static_option('payout_value') ?? 0;
        $bpConversionRate = get_static_option('bp_value') ?? 1;
        $sealingLimit = get_static_option('sealing_limit') ?? 1;

        // Calculate BV points
        $leftBvPoints = $user->leftChild ? $user->leftChild->userBvs->sum('bv_points') : 0;
        $rightBvPoints = $user->rightChild ? $user->rightChild->userBvs->sum('bv_points') : 0;



        $sealingLimitBv = $sealingLimit * $bpConversionRate;

        // Step 1: Deduct one sealing limit if both sides meet it
        if ($leftBvPoints >= $sealingLimitBv && $rightBvPoints >= $sealingLimitBv) {
            $leftBvPoints -= $sealingLimitBv;
            $rightBvPoints -= $sealingLimitBv;
        }

        // Step 2: Keep only multiples of sealingLimitBv
        $remainingLeftBv = floor($leftBvPoints / $sealingLimitBv) * $sealingLimitBv;
        $remainingRightBv = floor($rightBvPoints / $sealingLimitBv) * $sealingLimitBv;

        // Step 3: Calculate flushed BVs
        $flushedLeft = $leftBvPoints - $remainingLeftBv;
        $flushedRight = $rightBvPoints - $remainingRightBv;

        // Apply sealing limit to the BV points
        $sealingLimitBv = $sealingLimit * $bpConversionRate;

        // Retain only BV up to the sealing limit
        $sealedLeftBv = min($leftBvPoints, $sealingLimitBv);
        $sealedRightBv = min($rightBvPoints, $sealingLimitBv);

        // Update the retained BP points for display
        $leftBP = floor($sealedLeftBv / $bpConversionRate);
        $rightBP = floor($sealedRightBv / $bpConversionRate);
        $equalizedBP = min($leftBP, $rightBP);

        // Calculate income
        $income = $equalizedBP * $bvvalue;
        $showIncome = $equalizedBP > 0;

        // Format display values
        $businesspoint = "$leftBvPoints <> $rightBvPoints";
        $totalBP = "$leftBP <> $rightBP";
        $balancedBP = "$remainingLeftBv <> $remainingRightBv";

        // BV from direct referrals
        $bvFromReferrals = $user->children()->with('userBvs')->get()->sum(fn($child) => $child->userBvs->sum('bv_points'));

        // Referral commission
        $referralCommissionRate = $user->referral_commission ?? 0;
        $referralCommission = $referralCommissionRate;

        // Self purchased BV
        $selfPurchasedBv = $current_membership->id ? ($current_membership->membership->bv_points ?? 0) : 0;

        // Calculate BV points
        $directReferralsCount = $user->children()->count();

        // Return the view with updated data
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
            'totalBvPoints' => $businesspoint,
            'directReferralsCount' => $directReferralsCount,
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
            'sealingLimit' => $sealingLimit,
            'sealedLeftBv' => $sealedLeftBv,
            'sealedRightBv' => $sealedRightBv,
            'remainingLeftBv' => $remainingLeftBv,
            'remainingRightBv' => $remainingRightBv,
            'sealingLimitBv' => $sealingLimitBv,
            'flushedLeft' => $flushedLeft,
            'flushedRight' => $flushedRight,
        ]);
    }

    public function genology()
    {
        $user_id = Auth::id();

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
        // Get basic data needed for form
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
                'image' => 'required|integer|exists:media_uploads,id',
                'dob' => 'required|date|before:-18 years',

                // Location Information
                'country_id' => 'required|exists:countries,id',
                'state_id' => 'required|exists:states,id',
                'city_id' => 'required|exists:cities,id',

                // Job Preferences
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
            ]);

            // Create job seeker profile
            JobDetail::create(array_merge(
                $validated,
                [
                    'user_id' => auth()->id(),
                    'image' => $validated['image'],
                    'category_id' => $formData['specific_subcategory']->category_id,
                    'sub_category_id' => 107,
                    'child_category_id' => $validated['child_category_id'],
                    'country_id' => $validated['country_id'],
                    'state_id' => $validated['state_id'],
                    'city_id' => $validated['city_id'],
                ]
            ));

            return redirect()->route('user.dashboard')
                ->with('success', 'Profile submitted successfully!');
        }

        return view('frontend.user.listings.add-job-listing', $formData);
    }

    public function getjobseeker()
    {
        $jobs = JobDetail::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('frontend.user.job-listings', compact('jobs'));
    }

    public function editJob(Request $request, $id)
    {
        $jobDetail = JobDetail::where('user_id', auth()->id())->findOrFail($id);

        // Get the form data needed for edit page
        $formData = [
            'jobDetail' => $jobDetail,
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
            'all_states' => State::where('status', 1)->get(),
            'all_cities' => City::where('status', 1)->get(),
        ];

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:500',
                'image' => 'required|integer|exists:media_uploads,id',
                'dob' => 'required|date|before:-18 years',

                'country_id' => 'required|exists:countries,id',
                'state_id' => 'required|exists:states,id',
                'city_id' => 'required|exists:cities,id',

                'child_category_id' => 'required|exists:child_categories,id',

                'work_experience' => 'required|string',
                'education' => 'required|string',
                'skills' => 'required|string',
                'certifications' => 'nullable|string',
                'achievements' => 'nullable|string',
                'projects' => 'nullable|string',
                'summary' => 'required|string|max:1000',
                'portfolio_links' => 'nullable|string',

                'availability_date' => 'required|date',
                'work_preference' => 'required|in:remote,hybrid,onsite',
                'expected_salary' => 'required|numeric',
                'relocation_willingness' => 'required|boolean',
                'work_authorization' => 'required|string',
            ]);

            $jobDetail->update(array_merge(
                $validated,
                [
                    'category_id' => $formData['specific_subcategory']->category_id,
                    'sub_category_id' => 107,
                    'child_category_id' => $validated['child_category_id'],
                    'country_id' => $validated['country_id'],
                    'state_id' => $validated['state_id'],
                    'city_id' => $validated['city_id'],
                ]
            ));

            return redirect()->route('job.listings')->with('success', 'Job listing updated successfully!');
        }

        return view('frontend.user.edit-job-listings', $formData);
    }

    public function updateJob(Request $request, $id)
    {
        $jobDetail = JobDetail::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'image' => 'required|integer|exists:media_uploads,id',
            'dob' => 'required|date|before:-18 years',

            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',

            'child_category_id' => 'required|exists:child_categories,id',

            'work_experience' => 'required|string',
            'education' => 'required|string',
            'skills' => 'required|string',
            'certifications' => 'nullable|string',
            'achievements' => 'nullable|string',
            'projects' => 'nullable|string',
            'summary' => 'required|string|max:1000',
            'portfolio_links' => 'nullable|string',

            'availability_date' => 'required|date',
            'work_preference' => 'required|in:remote,hybrid,onsite',
            'expected_salary' => 'required|numeric',
            'relocation_willingness' => 'required|boolean',
            'work_authorization' => 'required|string',
        ]);

        // Assuming sub_category_id is fixed to 107
        $subcategory = SubCategory::with('category')->where('id', 107)->where('status', 1)->firstOrFail();

        $jobDetail->update(array_merge(
            $validated,
            [
                'category_id' => $subcategory->category_id,
                'sub_category_id' => $subcategory->id,
            ]
        ));

        return redirect()->route('user.job.info')->with('success', 'Job listing updated successfully!');
    }

    public function deleteJob($id)
    {
        $job = JobDetail::where('user_id', auth()->id())
            ->findOrFail($id);

        $job->delete();

        return redirect()->route('user.job.info')
            ->with('success', 'Job listing deleted successfully');
    }

    public function showProfile()
    {
        $user = auth()->user();
        $verification = IdentityVerification::where('user_id', $user->id)->first();
        $sponsor = User::where('id', $user->sponsor_id)->first();

        // Get profile stats
        $user_ads_posted = $user->listings()->count();
        $averageRating = $user->reviews?->avg('rating');
        $user_review_count = $user->reviews?->count();

        // Calculate age
        $age = null;
        if ($user->dob) {
            $age = now()->diffInYears($user->dob);
        }

        $profile = [
            'profile_id' => $user->partner_id,
            'sponsor_id' => $sponsor?->partner_id,
            'full_name' => $user->full_name,
            'dob' => $user->dob,
            'gender' => $user->gender,
            'whatsapp_no' => $user->phone,
            'mobile_number' => $user->phone,
            'father_husband_name' => $verification->relation_name ?? null,
            'completion_percentage' => $verification ? 100 : 0,
            'email' => $user->email,
            'nominee_name' => $verification->nominee_name ?? null,
            'bank_name' => $verification->bank_name ?? null,
            'branch' => $verification->branch ?? null,
            'ifsc_code' => $verification->ifsc_code ?? null,
            'account_no' => $verification->bank_account_no ?? null,
            'account_type' => $verification->account_type ?? null,
            'image' => $user->image,
            'user_ads_posted' => $user_ads_posted,
            'average_rating' => $averageRating,
            'review_count' => $user_review_count,
            'age' => $age,
            'created_at' => $user->created_at,
            'address' => $user->address,
            'country_id' => $user->country_id,
            'state_id' => $user->state_id,
            'city_id' => $user->city_id,
            'phone' => $user->phone,
            'is_verified' => $user->email_verified_at && $user->phone_verified_at
        ];

        return view('frontend.user.profile.main-profile', compact('profile'));
    }

    public function teamView($id)
    {
        // Get all users with their location relationships
        $allUsers = User::with(['user_country', 'user_state', 'user_city', 'membership'])->get()->keyBy('id');

        // Get the parent user
        $parentUser = $allUsers->get($id);

        if (!$parentUser) {
            abort(404, 'User not found');
        }

        // Get all team members recursively
        $teamMembers = $this->getEntireTeam($id, $allUsers);

        return view('frontend.user.genology.team_view', [
            'id' => $id,
            'parentUser' => $parentUser,
            'teamMembers' => $teamMembers,
            'allUsers' => $allUsers
        ]);
    }

    protected function getEntireTeam($userId, $allUsers)
    {
        // Initialize result array
        $teamMembers = [];

        // Recursively fetch all descendants
        $this->fetchDescendants($userId, $allUsers, $teamMembers);

        return collect($teamMembers); // Convert to collection for easier handling
    }

    protected function fetchDescendants($parentId, $allUsers, &$result, $level = 0)
    {
        $children = $allUsers->where('sponsor_id', $parentId);

        foreach ($children as $child) {
            $child->level = $level;

            $child->position = $child->membership ? 'Paid User' : 'Free User';

            $result[] = $child;

            $this->fetchDescendants($child->id, $allUsers, $result, $level + 1);
        }
    }

    private function buildReferralTree($userId, $allUsers)
    {
        $user = $allUsers->get($userId);
        if (!$user)
            return null;

        // Recursively build children
        $user->referrals = $allUsers->where('parent_id', $userId)->map(function ($child) use ($allUsers) {
            return $this->buildReferralTree($child->id, $allUsers);
        });

        return $user;
    }

    public function referralView($id)
    {
        $allUsers = User::with(['user_country', 'user_state', 'user_city', 'membership'])->get()->keyBy('id');

        $parentUser = $allUsers->get($id);

        if (!$parentUser) {
            abort(404, 'User not found');
        }

        // Only fetch direct referrals (1 level)
        $referrals = $allUsers->where('parent_id', $id)->map(function ($user) {
            $user->position = $user->membership ? 'Paid User' : 'Free User';
            return $user;
        });

        // 1-level tree structure
        $referralTree = [
            'user' => $parentUser,
            'children' => $referrals->values()
        ];

        return view('frontend.user.genology.referral_view', [
            'id' => $id,
            'parentUser' => $parentUser,
            'referrals' => $referrals,
            'allUsers' => $allUsers,
            'referralTree' => $referralTree,
        ]);
    }

    // public function viewincome()
    // {
    //     $user = auth()->user();
    //     $user->load(['kycRecord.user_country', 'kycRecord.user_state', 'kycRecord.user_city']);

    //     // Get payment type from static option
    //     $paymentType = get_static_option('payment_type') ?? 'day';
    //     $tdsPercentage = get_static_option('tds_value') ?? 0;
    //     $servicecharge = get_static_option('service_charge') ?? 0;

    //     // Get income data and filter
    //     $allDays = $this->getIncomeDays($user->id);
    //     $filteredDays = $this->filterIncomeDays($allDays, $paymentType);


    //     $totalIncome = collect($filteredDays)->sum('income');

    //     $incomeData = [
    //         'name' => $user->full_name,
    //         'rank' => $user->rank,
    //         'address' => $user->address,
    //         'bank_details' => $user->bank_details,
    //         'days' => $filteredDays,
    //         'total_income' => $totalIncome,
    //         'product_coupon' => 0,
    //         'tds' => $tdsPercentage,
    //         'service_charge' => $servicecharge,
    //         'net_amount' => $totalIncome * (1 - (10 + 5 + 2) / 100),
    //         'direct_business_bv' => 150,
    //         'kyc' => $user->kycRecord,
    //     ];

    //     return view('frontend.user.income.income', compact('incomeData'));
    // }


    public function viewincome()
    {
        $user = auth()->user();
        $user->load(['kycRecord.user_country', 'kycRecord.user_state', 'kycRecord.user_city']);

        // Get settings
        $paymentType = get_static_option('payment_type') ?? 'day';
        $tdsPercentage = get_static_option('tds_value') ?? 0;
        $serviceChargePercentage = get_static_option('service_charge') ?? 0;

        // Get income data
        $allDays = $this->getIncomeDays($user->id);
        $filteredDays = $this->filterIncomeDays($allDays, $paymentType);
        $totalIncome = collect($filteredDays)->sum('income');

        // ✅ Correct percentage calculations
        $tdsAmount = $totalIncome * ($tdsPercentage / 100);
        $serviceChargeAmount = $totalIncome * ($serviceChargePercentage / 100);
        $netAmount = $totalIncome - $tdsAmount - $serviceChargeAmount;

        $incomeData = [
            'name' => $user->full_name,
            'rank' => $user->rank,
            'address' => $user->address,
            'bank_details' => $user->bank_details,
            'days' => $filteredDays,
            'total_income' => round($totalIncome, 2),
            'product_coupon' => 0,
            'tds' => round($tdsAmount, 3),
            'service_charge' => round($serviceChargeAmount, 3),
            'net_amount' => round($netAmount, 3),
            'direct_business_bv' => 150,
            'kyc' => $user->kycRecord,
            'tds_percentage' => $tdsPercentage,
            'service_charge_percentage' => $serviceChargePercentage,
        ];

        return view('frontend.user.income.income', compact('incomeData'));
    }

    private function filterIncomeDays(array $days, string $paymentType): array
    {
        $today = Carbon::today();

        switch ($paymentType) {
            case 'week':
                $startDate = $today->copy()->subDays(6);
                break;
            case 'month':
                $startDate = $today->copy()->subDays(27);
                break;
            case 'day':
            default:
                $startDate = $today;
                break;
        }

        return array_filter($days, function ($item) use ($startDate) {
            return Carbon::parse($item['day'])->greaterThanOrEqualTo($startDate);
        });
    }

    private function getIncomeDays($userId)
    {
        return UserPayoutDetail::where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'day' => Carbon::parse($item->created_at)->toDateString(),
                    'team_cv' => $item->left_bv + $item->right_bv,
                    'income' => $item->net_amount,
                ];
            })
            ->toArray();
    }

    public function downloadIncomePdf()
    {
        $user = auth()->user();
        $user->load(['kycRecord.user_country', 'kycRecord.user_state', 'kycRecord.user_city']);

        // Get settings (same as viewincome method)
        $paymentType = get_static_option('payment_type') ?? 'day';
        $tdsPercentage = get_static_option('tds_value') ?? 0;
        $serviceChargePercentage = get_static_option('service_charge') ?? 0;

        // Get income data (same as viewincome method)
        $allDays = $this->getIncomeDays($user->id);
        $filteredDays = $this->filterIncomeDays($allDays, $paymentType);
        $totalIncome = collect($filteredDays)->sum('income');

        // Calculate amounts (same as viewincome method)
        $tdsAmount = $totalIncome * ($tdsPercentage / 100);
        $serviceChargeAmount = $totalIncome * ($serviceChargePercentage / 100);
        $netAmount = $totalIncome - $tdsAmount - $serviceChargeAmount;

        $today = now()->toDateString();
        $todayIncome = collect($filteredDays)->filter(function ($item) use ($today) {
            $dateField = $item['created_at'] ?? $item['date'] ?? $item['day'] ?? null;
            return $dateField && Carbon::parse($dateField)->toDateString() === $today;
        });

        $incomeData = [
            'name' => $user->full_name,
            'rank' => $user->rank,
            'address' => $user->address,
            'bank_details' => $user->bank_details,
            'days' => $filteredDays,
            'today_income' => $todayIncome,
            'total_income' => round($totalIncome, 2),
            'product_coupon' => 0,
            'tds' => round($tdsAmount, 3),
            'service_charge' => round($serviceChargeAmount, 3),
            'net_amount' => round($netAmount, 3),
            'direct_business_bv' => 150,
            'kyc' => $user->kycRecord,
            'tds_percentage' => $tdsPercentage,
            'service_charge_percentage' => $serviceChargePercentage,
            'today' => $today,
        ];

        $pdf = Pdf::loadView('frontend.user.income.income-pdf', compact('incomeData', 'user'));

        return $pdf->download('income-statement.pdf');
    }

}
