<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Exception;
use App\Models\User;
use Modules\Membership\app\Models\Membership;
use Modules\Wallet\app\Models\Wallet;
use App\Jobs\SendRegisterUserEmailJob;
use App\Mail\BasicMail;
use App\Models\UsersBV;
use App\Models\Frontend\ListingFavorite;
use App\Models\Frontend\Review;
use Illuminate\Support\Facades\Auth;
use App\Models\Backend\Admin;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Handle API user registration.
     */
    public function register(Request $request)
    {
        // Validate input including gender and dob
        $request->validate([
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'email' => 'required|email|unique:users,email|max:191',
            'username' => 'required|string|unique:users,username|max:191',
            'phone' => 'required|string|max:191',
            'password' => 'required|string|min:6|max:191|confirmed',
            'gender' => 'required|in:male,female',
            'dob' => 'required|date|before:' . now()->subYears(18)->toDateString(),
            'partner_id' => 'nullable|string',
        ], [
            'dob.before' => __('You must be at least 18 years old.'),
        ]);

        try {
            // Clean and format phone number
            $phoneClean = Str::replace(['-', '(', ')', ' '], '', $request->phone);
            $countryCode = '+' . ltrim($request->input('country_code', ''), '+');
            $fullPhone = trim($countryCode . $phoneClean);

            // Assign partner or default to admin
            $inputPartnerId = $request->partner_id;
            $isAdminPartner = false;
            if (empty($inputPartnerId)) {
                $admin = Admin::firstOrFail();
                $inputPartnerId = $admin->partner_id;
                $isAdminPartner = true;
            }

            // Determine sponsor, parent, and position
            $sponsorId = null;
            $parentId = null;
            $position = null;

            // Check if partner is admin
            $adminPartner = Admin::where('partner_id', $inputPartnerId)->first();
            if ($adminPartner) {
                $isAdminPartner = true;
            } else {
                // Partner is a regular user
                $referrer = User::where('partner_id', $inputPartnerId)
                    ->orWhere('username', $inputPartnerId)
                    ->first();
                if ($referrer) {
                    $sponsorId = $referrer->id;
                    // Binary tree placement
                    if (!$referrer->children()->where('position', 'left')->exists()) {
                        $parentId = $referrer->id;
                        $position = 'left';
                    } elseif (!$referrer->children()->where('position', 'right')->exists()) {
                        $parentId = $referrer->id;
                        $position = 'right';
                    } else {
                        // Traverse descendants
                        $descendants = $referrer->descendants()->with('children')->get();
                        foreach ($descendants as $desc) {
                            if (!$desc->children()->where('position', 'left')->exists()) {
                                $parentId = $desc->id;
                                $position = 'left';
                                break;
                            }
                            if (!$desc->children()->where('position', 'right')->exists()) {
                                $parentId = $desc->id;
                                $position = 'right';
                                break;
                            }
                        }
                        // Fallback to first available
                        if (!$parentId) {
                            $firstAvail = User::whereDoesntHave('children', fn($q) => $q->where('position', 'left'))
                                ->orWhereDoesntHave('children', fn($q) => $q->where('position', 'right'))
                                ->first();
                            if ($firstAvail) {
                                $parentId = $firstAvail->id;
                                $position = $firstAvail->children()->where('position', 'left')->exists() ? 'right' : 'left';
                            }
                        }
                    }
                }
            }

            // Generate new partner ID for this user
            do {
                $code = now()->format('Ym') . rand(1000, 99999);
                $newPartner = 'GL' . $code;
            } while (User::where('partner_id', $newPartner)->exists());

            // Generate partner_name
            $partnerName = 'EASYADME-' . strtoupper($request->first_name);

            // Instantiate the user
            $user = new User([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'username' => $request->username,
                'phone' => $fullPhone,
                'password' => Hash::make($request->password),
                'gender' => $request->gender,
                'dob' => $request->dob,
                'partner_id' => $newPartner,
                'partner_name' => $partnerName,
                'sponsor_id' => $sponsorId,
                'parent_id' => $parentId,
                'position' => $position,
                'is_admin_partner' => $isAdminPartner,
            ]);

            // Save in nested set
            if ($parentId) {
                User::find($parentId)->appendNode($user);
            } else {
                $user->saveAsRoot();
            }

            // Assign default membership BV
            $defaultMembership = Membership::find(1);
            $bvPoints = $defaultMembership->bv_points ?? 0;
            UsersBV::create([
                'user_id' => $user->id,
                'membership_id' => $defaultMembership->id ?? 1,
                'bv_points' => $bvPoints,
                'upgrade_time' => now(),
            ]);

            // Initialize wallet if module exists
            if (moduleExists('Wallet')) {
                Wallet::create([
                    'user_id' => $user->id,
                    'balance' => 0,
                    'remaining_balance' => 0,
                    'withdraw_amount' => 0,
                    'status' => 1,
                ]);
            }

            // Dispatch welcome email
            SendRegisterUserEmailJob::dispatch($user, $request->password);

            return response()->json(['success' => true, 'user' => $user], 201);
        } catch (\Exception $e) {
            Log::error('API registration error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => __('Registration failed.')], 500);
        }
    }

    // Verify existing partner
    public function verifyPartner(Request $request)
    {
        $partner = User::where('partner_id', $request->partner_id)
            ->orWhere('username', $request->partner_id)
            ->first();

        if (!$partner) {
            return response()->json([
                'status' => 'error',
                'message' => 'Partner ID not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'partner_name' => $partner->first_name . ' ' . $partner->last_name,
            'partner_id' => $partner->partner_id
        ]);
    }

    public function getAdminPartner()
    {
        $admin = Admin::select('partner_id', 'partner_name')->first();

        return response()->json([
            'success' => true,
            'data' => $admin ?? []
        ], 200);
    }

    public function verifyAdminPartnerId(Request $request)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'partner_id' => 'required|string|max:255',
            ]);

            // Check existence
            $exists = Admin::where('partner_id', $validated['partner_id'])->exists();

            // Return JSON response
            return response()->json([
                'success' => true,
                'exists' => $exists,
                'message' => $exists
                    ? 'Partner ID exists.'
                    : 'Partner ID does not exist.',
            ], 200);

        } catch (ValidationException $e) {
            // Return validation errors
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
                'message' => 'Validation failed.',
            ], 422);

        } catch (\Exception $e) {
            // Handle unexpected errors
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $validationRules = [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];

        $request->validate($validationRules);

        try {
            Log::info('User login request received.', ['email' => $request->email]);

            // Find user by email
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                Log::warning('Invalid login credentials.', ['email' => $request->email]);
                return response()->json(['error' => __('Invalid credentials')], 401);
            }

            // Check if email verification is required
            if (!empty(get_static_option('user_email_verify_enable_disable')) && !$user->email_verified_at) {
                Log::warning('User email not verified.', ['email' => $request->email]);
                return response()->json(['error' => __('Please verify your email before logging in.')], 403);
            }

            // Generate API token using Laravel Sanctum
            $token = $user->createToken('API Token')->plainTextToken;

            Log::info('User logged in successfully.', ['user_id' => $user->id]);

            return response()->json([
                'message' => 'Login successful.',
                'user' => $user,
                'token' => $token,
            ], 200);
        } catch (Exception $e) {
            Log::error('Error during user login.', ['error' => $e->getMessage()]);
            return response()->json(['error' => __('An error occurred during login. Please try again.')], 500);
        }
    }

    public function dashboardApi()
    {
        $user_id = Auth::id();
        $user = User::with([
            'listings',
            'reviews',
            'user_country',
            'user_state',
            'membershipUser.membership',
            'membershipHistory',
            'parent',
            'children.userBvs',
            'leftChild.userBvs',
            'rightChild.userBvs'
        ])->findOrFail($user_id);

        $current_membership = optional($user->membershipUser);
        $previous_membership = $user->membershipHistory()->latest('created_at')->first();

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

        $bvvalue = get_static_option('payout_value') ?? 0;
        $bpConversionRate = get_static_option('bp_value') ?? 1;
        $sealingLimit = get_static_option('sealing_limit') ?? 1;

        $leftBvPoints = $user->leftChild ? $user->leftChild->userBvs->sum('bv_points') : 0;
        $rightBvPoints = $user->rightChild ? $user->rightChild->userBvs->sum('bv_points') : 0;

        $sealingLimitBv = $sealingLimit * $bpConversionRate;

        if ($leftBvPoints >= $sealingLimitBv && $rightBvPoints >= $sealingLimitBv) {
            $leftBvPoints -= $sealingLimitBv;
            $rightBvPoints -= $sealingLimitBv;
        }

        $remainingLeftBv = floor($leftBvPoints / $sealingLimitBv) * $sealingLimitBv;
        $remainingRightBv = floor($rightBvPoints / $sealingLimitBv) * $sealingLimitBv;

        $flushedLeft = $leftBvPoints - $remainingLeftBv;
        $flushedRight = $rightBvPoints - $remainingRightBv;

        $sealedLeftBv = min($leftBvPoints, $sealingLimitBv);
        $sealedRightBv = min($rightBvPoints, $sealingLimitBv);

        $leftBP = floor($sealedLeftBv / $bpConversionRate);
        $rightBP = floor($sealedRightBv / $bpConversionRate);
        $equalizedBP = min($leftBP, $rightBP);

        $income = $equalizedBP * $bvvalue;
        $showIncome = $equalizedBP > 0;

        $businesspoint = "$leftBvPoints <> $rightBvPoints";
        $totalBP = "$leftBP <> $rightBP";
        $balancedBP = "$remainingLeftBv <> $remainingRightBv";

        $bvFromReferrals = $user->children->sum(fn($child) => $child->userBvs->sum('bv_points'));

        $referralCommissionRate = $user->referral_commission ?? 0;
        $referralCommission = $referralCommissionRate;

        $selfPurchasedBv = $current_membership->id ? ($current_membership->membership->bv_points ?? 0) : 0;

        $directReferralsCount = $user->children()->count();

        return response()->json([
            'user' => $user,
            'user_ads_posted' => $user_ads_posted,
            'user_active_listings' => $user_active_listings,
            'user_deactivated_ads' => $user_deactivated_ads,
            'user_favorite_ads' => $user_favorite_ads,
            'averageRating' => $averageRating,
            'user_review_count' => $user_review_count,
            'user_given_reviews' => $user_given_reviews,
            'remaining_listings' => $remaining_listings,
            'show_upgrade' => $show_upgrade,
            'age' => $age,
            'showIncome' => $showIncome,
            'sealingLimit' => $sealingLimit,
            'sealedLeftBv' => $sealedLeftBv,
            'sealedRightBv' => $sealedRightBv,
            'remainingLeftBv' => $remainingLeftBv,
            'remainingRightBv' => $remainingRightBv,
            'sealingLimitBv' => $sealingLimitBv,
            'flushedLeft' => $flushedLeft,
            'flushedRight' => $flushedRight,

            // ✅ Grouped Sections (no duplication)
            'referrals' => [
                'sponsor_id' => $user->sponsor_id,
                'sponsor_name' => optional($user->parent)->name,
                'referred_by' => optional($user->parent)?->name . ' (' . optional($user->parent)?->user_id . ')',
                'my_referrals_count' => $directReferralsCount,
                'bv_from_referrals' => $bvFromReferrals,
                'referral_commission' => number_format($referralCommission, 2),
                'referral_commission_rate' => $referralCommissionRate,
            ],

            'business' => [
                'status' => strtoupper($user->status ?? 'DISTRIBUTOR'),
                'self_purchase_bv' => $selfPurchasedBv,
                'team_bv_left' => $leftBvPoints,
                'team_bv_right' => $rightBvPoints,
                'commission_value' => "$sealedLeftBv <> $sealedRightBv",
            ],

            'income_details' => [
                'total_bv_points' => $businesspoint,
                'total_bp' => "$totalBP",
                'equalized_bp' => $equalizedBP,
                'balanced_bp' => "$remainingLeftBv <> $remainingRightBv",
                'income' => $income,
            ],
        ]);
    }

    public function updateProfile(Request $request)
    {
        $userId = Auth::id();
        Log::info('API profile update request received.', ['request_data' => $request->all()]);

        try {
            $request->validate([
                'email' => 'required|email|unique:users,email,' . $userId,
                'country' => 'nullable|integer|exists:countries,id',
                'state' => 'nullable|integer|exists:states,id',
                'city' => 'nullable|integer|exists:cities,id',
            ], [
                'email.required' => __('Email is required'),
                'email.email' => __('Invalid email format'),
                'email.unique' => __('This email is already in use'),
            ]);

            $user = User::findOrFail($userId);
            $user->email = $request->email;

            if ($request->filled('country')) {
                $user->country_id = $request->country;
            }

            if ($request->filled('state')) {
                $user->state_id = $request->state;
            }

            if ($request->filled('city')) {
                $user->city_id = $request->city;
            }

            if ($request->filled('image')) {
                // if you have an image_id column:
                $user->image = $request->image;
            }

            $user->save();

            Log::info('API profile update success:', ['user_id' => $userId]);

            return response()->json([
                'status' => 'ok',
                'message' => __('Profile updated successfully'),
                'data' => $user
            ]);
        } catch (\Exception $e) {
            Log::error('API profile update failed:', ['error' => $e->getMessage()]);

            return response()->json([
                'status' => 'error',
                'message' => __('Profile update failed: ') . $e->getMessage()
            ], 500);
        }
    }


}
