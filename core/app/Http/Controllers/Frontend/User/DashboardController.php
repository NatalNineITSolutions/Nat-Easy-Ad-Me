<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Frontend\ListingFavorite;
use App\Models\Frontend\Review;
use App\Models\UnlockedProfile;
use App\Models\User;
use App\Models\UsersBV;
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
use App\Models\Backend\Admin;
use Barryvdh\DomPDF\Facade\Pdf;
use Modules\Membership\app\Models\UserMembership;
use Illuminate\Support\Facades\DB;

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
        $membership = UserMembership::where('user_id', $user_id)->first();

        $current_membership = optional($user->adsMembership);
        $previous_membership = $user->membershipHistory()->latest('created_at')->first();

        // Basic user stats
        $user_ads_posted = $user->listings()->count();
        $remaining_listings = $current_membership->listing_limit;
        $user_active_listings = $user->listings()->where('is_published', 1)->where('status', 1)->count();
        $user_deactivated_ads = $user->listings()->where(fn($q) => $q->where('is_published', 0)->orWhere('status', 0))->count();
        $user_favorite_ads = ListingFavorite::where('user_id', $user_id)->count();
        $show_upgrade = ($remaining_listings === 0 && $current_membership->listing_limit > 0);
        $averageRating = $user->reviews?->avg('rating');
        $user_review_count = $user->reviews?->count();
        $user_given_reviews = Review::where('reviewer_id', $user_id)->take(500)->get();
        $age = $user->dob ? now()->diffInYears($user->dob) : null;

        $userMembership = UserMembership::where('user_id', $user_id)->latest('created_at')->first();
        $membershipInfo = null;
        if ($userMembership && $userMembership->membership?->category === 1) {
            $membershipInfo = [
                'title' => $userMembership->membership->title,
                'profile_limit' => $userMembership->profile_limit
            ];
        }

        $profilesViewed = UnlockedProfile::where('user_id', $user_id)->count();
        $remainingProfileLimit = max(0, ($membershipInfo['profile_limit'] ?? 0) - $profilesViewed);

        // BV / BP settings
        $bvvalue = ($membership?->category == 1)
            ? get_static_option('matrimony_bv_value')
            : get_static_option('payout_value');
        $bpConversionRate = get_static_option('bp_value') ?? 1;
        $sealingLimit = get_static_option('sealing_limitation') ?? 1;

        // Get left and right BV points from user_flush_bvs table
        $userFlushBvs = DB::table('user_flush_bvs')
            ->where('user_id', $user_id)
            ->latest('id')
            ->first();

        // Sum BV points
        $leftBvPoints = $userFlushBvs ? $userFlushBvs->left_bv : 0;
        Log::info('LeftBV: ' . $leftBvPoints);

        $rightBvPoints = $userFlushBvs ? $userFlushBvs->right_bv : 0;
        Log::info('RightBV:' . $rightBvPoints);

        // Flushable & remainder
        $sealingLimitBv = $sealingLimit * $bpConversionRate;
        $flushableAmount = floor(min($leftBvPoints, $rightBvPoints) / $sealingLimitBv) * $sealingLimitBv;
        $remainingLeft = max(0, $leftBvPoints - $flushableAmount);
        $remainingRight = max(0, $rightBvPoints - $flushableAmount);
        $flushedLeft = $leftBvPoints - $remainingLeft;
        $flushedRight = $rightBvPoints - $remainingRight;

        // BP display
        $sealedLeftBv = min($leftBvPoints, $sealingLimitBv);
        $sealedRightBv = min($rightBvPoints, $sealingLimitBv);
        $leftBP = floor($sealedLeftBv / $bpConversionRate);
        $rightBP = floor($sealedRightBv / $bpConversionRate);
        $equalizedBP = min($leftBP, $rightBP);
        $pairincome = get_static_option('maximum_one_pair_income') ?? 0;
        $income = $equalizedBP * $pairincome;
        $showIncome = $equalizedBP > 0;

        // Other stats
        $businesspoint = "$leftBvPoints <> $rightBvPoints";
        $totalBP = "$leftBP <> $rightBP";
        $balancedBP = "$leftBvPoints <> $rightBvPoints";
        $bvFromReferrals = $user->children()->with('userBvs')->get()->sum(fn($c) => $c->userBvs->where('type', '!=', 'referral_commission')->sum('bv_points'));

        // ─── Referral Commission Logic ─────────────────────────────────────────────
        $referralValue = (float) get_static_option('referral_value');
        $referralPercentage = (float) get_static_option('referral_percentage');
        $perReferralCommission = ($referralPercentage / 100) * $referralValue;

        // Only process new referrals (flagged is_commissioned = 0)
        $qualifiedReferrals = User::where('sponsor_id', $user_id)
            ->where('self_purchased_bv', '>=', 900)
            ->where('commission_given', 0)
            ->get();

        $pendingReferralCommission = 0;
        foreach ($qualifiedReferrals as $ref) {
            $pendingReferralCommission += $perReferralCommission;
            $ref->update(['commission_given' => 1]);
        }

        if ($pendingReferralCommission > 0) {
            $user->increment('referral_commission', $pendingReferralCommission);
        }

        // Now read the stored commission for display
        $referralCommission = $user->referral_commission;

        // Determine sponsor display
        if ($user->sponsor) {
            $referredBy = $user->sponsor->partner_name ?: 'Unknown';
            $referredById = $user->sponsor->partner_id ?: '';
        } else {
            $admin = Admin::first();
            $referredBy = $admin?->partner_name ?: 'Admin';
            $referredById = $admin?->partner_id ?: '';
        }

        return view('frontend.user.dashboard.dashboard', [
            'user' => $user,
            'check_active_distributor' => ($user->self_purchased_bv ?? 0) >= $bpConversionRate,
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
            'directReferralsCount' => User::where('sponsor_id', $user_id)->count(),
            'referralCommission' => $referralCommission,
            'referralCommissionRate' => $referralPercentage,
            'totalBP' => $totalBP,
            'equalizedBP' => $equalizedBP,
            'balancedBP' => $balancedBP,
            'bvFromReferrals' => $bvFromReferrals,
            'income' => $income,
            'showIncome' => $showIncome,
            'businesspoint' => $businesspoint,
            'selfPurchasedBv' => $user->self_purchased_bv ?? 0,
            'sealingLimit' => $sealingLimit,
            'sealedLeftBv' => $sealedLeftBv,
            'sealedRightBv' => $sealedRightBv,
            'remainingLeftBv' => $remainingLeft,
            'remainingRightBv' => $remainingRight,
            'sealingLimitBv' => $sealingLimitBv,
            'flushedLeft' => $flushedLeft,
            'flushedRight' => $flushedRight,
            'referredBy' => $referredBy,
            'referredById' => $referredById,
            'membership' => $membership,
            'membershipInfo' => $membershipInfo,
            'profilesViewed' => $profilesViewed,
            'remainingProfileLimit' => $remainingProfileLimit,
        ]);
    }

    public function genology()
    {
        $userId = Auth::id();

        // eager‐load exactly two levels of children (or deeper if you like)
        $user = User::with([
            'leftChild.leftChild',    // for deeper trees add more relationships
            'leftChild.rightChild',
            'rightChild.leftChild',
            'rightChild.rightChild',
        ])->findOrFail($userId);

        // Walk the entire tree and compute BV & possible_pairs
        $this->calculateBV($user);

        // render — each node now has ->leftBV, ->rightBV and ->possible_pairs
        return view('frontend.user.genology.genology', [
            'mlmTree' => $user,
        ]);
    }

    public function getChildren(Request $request, $id)
    {
        $user_id = Auth::id();
        // Find the parent by ID and eager load only its immediate children with BV data
        $parent = User::with([
            'leftChild.userBvs',
            'rightChild.userBvs'
        ])->find($id);

        if (!$parent) {
            return redirect()->back()->withErrors(['error' => __('Parent not found')]);
        }

        $bpConversionRate = get_static_option('bp_value') ?? 1;
        $sealingLimit = get_static_option('sealing_limitation') ?? 1;

        $userFlushBvs = DB::table('user_flush_bvs')
            ->where('user_id', $user_id)
            ->latest('id')
            ->first();

        // Sum BV points
        $leftBvPoints = $userFlushBvs ? $userFlushBvs->left_bv : 0;
        Log::info('LeftBV: ' . $leftBvPoints);

        $rightBvPoints = $userFlushBvs ? $userFlushBvs->right_bv : 0;
        Log::info('RightBV:' . $rightBvPoints);

        $sealingLimitBv = $sealingLimit * $bpConversionRate;
        $sealedLeftBv = min($leftBvPoints, $sealingLimitBv);
        $sealedRightBv = min($rightBvPoints, $sealingLimitBv);
        $leftBP = floor($sealedLeftBv / $bpConversionRate);
        $rightBP = floor($sealedRightBv / $bpConversionRate);
        $possiblePairs = min($leftBP, $rightBP);

        // Calculate BV for the parent and its immediate children if needed
        $this->calculateBV($parent);

        return view('frontend.user.genology.show_children', compact('parent', 'possiblePairs'));
    }
    private function calculateBV(&$node)
    {
        if (!$node) {
            Log::warning('calculateBV called with null node');
            return;
        }

        // 1) get the most recent flush record for this user
        $flush = DB::table('user_flush_bvs')
            ->where('user_id', $node->id)
            ->latest('id')
            ->first();

        $leftBV = $flush->left_bv ?? 0;
        $rightBV = $flush->right_bv ?? 0;

        // 2) store raw BV on the node
        $node->leftBV = $leftBV;
        $node->rightBV = $rightBV;

        // 3) apply sealing limit & BP conversion
        $bpRate = (int) (get_static_option('bp_value') ?? 1);
        $sealLimit = (int) (get_static_option('sealing_limitation') ?? 1);
        $maxAllowed = $sealLimit * $bpRate;

        $sealedL = min($leftBV, $maxAllowed);
        $sealedR = min($rightBV, $maxAllowed);

        $leftBP = floor($sealedL / $bpRate);
        $rightBP = floor($sealedR / $bpRate);

        // 4) attach possible_pairs
        $node->possible_pairs = min($leftBP, $rightBP);

        Log::info('Node BV/Pair calc', [
            'user_id' => $node->id,
            'leftBV' => $leftBV,
            'rightBV' => $rightBV,
            'sealedL' => $sealedL,
            'sealedR' => $sealedR,
            'leftBP' => $leftBP,
            'rightBP' => $rightBP,
            'possible_pairs' => $node->possible_pairs,
        ]);

        // 5) recurse into children
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
        $referrals = $allUsers->where('sponsor_id', $id)->map(function ($user) {
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

    public function viewincome()
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
        $filteredDays = collect($filteredDays)->map(function ($day) {
            $day['income'] = $day['payout_amount'];
            return $day;
        });
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

        $bvFromReferrals = $user->children()->with('userBvs')->get()->sum(fn($child) => $child->userBvs->sum('bv_points'));

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
            'direct_business' => $bvFromReferrals,
            'kyc' => $user->kycRecord,
            'tds_percentage' => $tdsPercentage,
            'service_charge_percentage' => $serviceChargePercentage,
            'today' => $today,
            'bv_from_referrals' => $bvFromReferrals,
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
            ->where('status', 'payout_eligible')
            ->get()
            ->map(function ($item) {
                return [
                    'day' => Carbon::parse($item->created_at)->toDateString(),
                    'team_cv' => $item->left_bv + $item->right_bv,
                    'payout_amount' => $item->payout_amount,
                    'net_amount' => $item->net_amount,
                    'tds' => $item->tds_deduction,
                    'service_charge' => $item->service_charge,
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
        $filteredDays = collect($filteredDays)->map(function ($day) {
            $day['income'] = $day['payout_amount'];
            return $day;
        });
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

        $bvFromReferrals = $user->children()->with('userBvs')->get()->sum(fn($child) => $child->userBvs->sum('bv_points'));

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
            'direct_business' => $bvFromReferrals,
            'kyc' => $user->kycRecord,
            'tds_percentage' => $tdsPercentage,
            'service_charge_percentage' => $serviceChargePercentage,
            'today' => $today,
            'bv_from_referrals' => $bvFromReferrals,
        ];

        $pdf = Pdf::loadView('frontend.user.income.income-pdf', compact('incomeData', 'user'));

        return $pdf->download('income-statement.pdf');
    }

    public function bvhistory()
    {
        $user = auth()->user();

        $bvHistory = UsersBv::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('frontend.user.bv_history', compact('bvHistory'));
    }
}
