<?php

namespace App\Http\Controllers;

use App\Helpers\PaymentGatewayCredential;
use App\Http\Controllers\Controller;
use App\Models\AgeRange;
use App\Models\IncomeRange;
use App\Models\MatrimonyPreference;
use App\Models\Religion;
use DB;
use Illuminate\Http\Request;
use App\Models\MatrimonyKyc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\UnlockedProfile;
use Modules\Membership\app\Models\Membership;
use Modules\Membership\app\Models\MembershipHistory;
use Modules\Membership\app\Models\UserMembership;
use App\Models\ProfileListing;
use Illuminate\Support\Str;
use App\Models\Gothram;
use App\Models\Caste;
use App\Models\MotherTongue;
use App\Models\Dosham;
use App\Models\ZodiacSign;
use App\Models\Star;
use Modules\CountryManage\app\Models\City;
use Modules\CountryManage\app\Models\State;
use Modules\CountryManage\app\Models\Country;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\ProfileRequest;
use Carbon\Carbon;


class MatrimonyController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('user.login')->with('error', 'Please log in or register first to access Matrimony');
        }

        $user = auth()->user();

        if ($user->profile_completed != 1) {
            return redirect()->route('matrimony.user-details')->with('info', 'Please complete your profile to proceed.');
        }

        $unlockedProfileIds = UnlockedProfile::where('user_id', $user->id)
            ->pluck('profile_id')
            ->toArray();

        $notificationCount = ProfileRequest::whereHas('profile', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->where('status', 'pending')
            ->count();

        // Log the notification count
        Log::info("Pending profile requests count for user {$user->id}: {$notificationCount}");

        $profiles = ProfileListing::where('is_verified', 1)
            ->where('id', '!=', $user->id)
            ->select('id', 'name', 'date_of_birth', 'occupation', 'city', 'image', 'mother_tongue', 'visibility')
            ->inRandomOrder()
            ->limit(7)
            ->get()
            ->map(function ($profile) use ($unlockedProfileIds) {
                $isUnlocked = in_array($profile->id, $unlockedProfileIds);
                $firstImageId = null;

                if (!empty($profile->image)) {
                    $imageIds = explode('|', $profile->image);
                    $firstImageId = trim($imageIds[0]) ?? null;
                }

                $shouldBlur = !$isUnlocked && $profile->visibility == 1;

                if ($firstImageId) {
                    $imageUrl = get_attachment_url_by_ids($firstImageId);
                    if ($imageUrl) {
                        $profile->first_image_url = "<img src=\"{$imageUrl}\"" . ($shouldBlur ? " class=\"blurred\"" : "") . " alt=\"Profile Image\">";
                    } else {
                        $profile->first_image_url = "<img src=\"/assets/uploads/media-uploader/profile.png\"" . ($shouldBlur ? " class=\"blurred\"" : "") . " alt=\"Profile Image\">";
                    }
                } else {
                    $profile->first_image_url = "<img src=\"/assets/uploads/media-uploader/profile.png\"" . ($shouldBlur ? " class=\"blurred\"" : "") . " alt=\"Profile Image\">";
                }

                return $profile;
            });

        return view('matrimony.index', compact('profiles', 'notificationCount'));
    }

    public function searchresults(Request $request)
    {
        $gender = $request->gender;
        $ageRange = $request->age;
        $occupation = $request->occupation;
        $location = $request->location;

        [$minAge, $maxAge] = explode('-', $ageRange);

        $userIds = User::when($gender, fn($q) => $q->where('gender', $gender))
            ->pluck('id');

        $matchedProfiles = ProfileListing::where(function ($query) use ($userIds, $minAge, $maxAge, $occupation, $location) {
            $query->when($userIds->isNotEmpty(), fn($q) => $q->orWhereIn('user_id', $userIds))
                ->orWhereBetween('age', [$minAge, $maxAge])
                ->orWhere('occupation', 'LIKE', "%$occupation%")
                ->orWhere('city', 'LIKE', "%$location%");
        })
            ->get(['id', 'name', 'age', 'occupation', 'city']);

        return view('matrimony.search-results', compact('matchedProfiles'));
    }

    public function price()
    {
        $memberships = Membership::where('category', 1)->get();

        // Get the user's most recent membership if logged in
        $user_current_membership = null;
        if (Auth::check()) {
            $user_current_membership = UserMembership::where('user_id', Auth::id())
                ->where('status', 1)
                ->whereHas('membership', fn($q) => $q->where('category', 1))
                ->first();
        }

        return view('matrimony.price', compact('memberships', 'user_current_membership'));
    }

    public function profileDetails($id)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('user.login')->with('error', 'Please log in to view profile details');
        }

        $profile = ProfileListing::with(['user', 'caste', 'city'])->findOrFail($id);
        $isOwnProfile = $profile->user_id === $user->id;

        $isUnlocked = UnlockedProfile::where('user_id', $user->id)
            ->where('profile_id', $id)
            ->exists();

        if (!$isUnlocked) {
            // Pick the user's active membership (from user_memberships table)
            $membership = UserMembership::where('user_id', $user->id)
                ->where('profile_limit', '>', 0)
                ->orderBy('id', 'desc') // pick latest if multiple entries
                ->first();

            if ($membership) {
                DB::transaction(function () use ($membership, $user, $id) {
                    // Deduct profile limit
                    $membership->decrement('profile_limit');

                    // Save unlocked profile
                    UnlockedProfile::create([
                        'user_id' => $user->id,
                        'profile_id' => $id,
                    ]);
                });

                $isUnlocked = true; // Now unlocked after transaction
            }
        }

        $shouldBlur = !$isUnlocked;

        $mainImageHtml = null;
        $galleryImagesHtml = [];

        if (!empty($profile->image)) {
            $imageIds = array_filter(
                preg_split('/[|,]/', $profile->image),
                fn($id) => !empty(trim($id))
            );

            if (!empty($imageIds)) {
                $mainImageHtml = $shouldBlur
                    ? '<img src="' . get_attachment_url_by_id(trim($imageIds[0])) . '" class="blurred" alt="Profile Image">'
                    : render_image_markup_by_attachment_id(trim($imageIds[0]));

                foreach ($imageIds as $imageId) {
                    $galleryImagesHtml[] = $shouldBlur
                        ? '<img src="' . get_attachment_url_by_id(trim($imageId)) . '" class="blurred" alt="Gallery Image">'
                        : render_image_markup_by_attachment_id(trim($imageId));
                }
            }
        }

        $sentRequest = ProfileRequest::where('sender_id', $user->id)
            ->where('profile_id', $id)
            ->first();

        $isRequestAccepted = $sentRequest && $sentRequest->status === 'accepted';

        return view('matrimony.profile-details', [
            'profile' => $profile,
            'mainImageHtml' => $mainImageHtml,
            'galleryImagesHtml' => $galleryImagesHtml,
            'isUnlocked' => $isUnlocked,
            'shouldBlur' => $shouldBlur,
            'userEmail' => $profile->user->email ?? null,
            'userPhone' => $profile->user->phone ?? null,
            'isOwnProfile' => $isOwnProfile,
            'isRequestAccepted' => $isRequestAccepted,
            'sentRequest' => $sentRequest,
        ]);
    }

    public function sendRequest(Request $request, ProfileListing $profile)
    {
        // Verify the user isn't sending to themselves
        if ($profile->user_id === auth()->id()) {
            return response()->json([
                'message' => 'You cannot send a request to your own profile'
            ], 403);
        }

        // Check for existing request
        if (
            ProfileRequest::where('sender_id', auth()->id())
                ->where('profile_id', $profile->id)
                ->exists()
        ) {
            return response()->json([
                'message' => 'You have already sent a request to this profile'
            ], 422);
        }

        // Create the request
        ProfileRequest::create([
            'sender_id' => auth()->id(),
            'profile_id' => $profile->id,
            'status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Profile request sent successfully!'
        ]);
    }
    public function userdetails()
    {
        $castes = Caste::all();
        $gothrams = Gothram::all();
        $doshams = Dosham::all();
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
        $zodiacsigns = ZodiacSign::all();
        $stars = Star::all();

        return view('matrimony.user-details', compact('castes', 'gothrams', 'doshams', 'countries', 'states', 'cities', 'zodiacsigns', 'stars'));
    }

    public function getStates($country_id)
    {
        $states = State::where('country_id', $country_id)->get(['id', 'state']); // Select only necessary fields
        return response()->json(['states' => $states]); // Return the states data
    }

    public function getCities($state_id)
    {
        $cities = City::where('state_id', $state_id)->get(['id', 'city']);
        return response()->json(['cities' => $cities]);
    }

    public function storeUserDetails(Request $request)
    {
        $validated = $request->validate([
            'marital_status' => 'required|string',
            'dob' => 'required|date',
            'family_status' => 'required|string',
            'family_values' => 'required|string',
            'family_type' => 'required|string',
            'disability' => 'required|string',
            'height' => 'required|numeric',
            'weight' => 'required|string',
            'caste' => 'required|integer',
            'dosham' => 'required|integer',
            'gothram' => 'required|integer',
            'education' => 'required|string',
            'occupation' => 'required|string',
            'annual_income' => 'required|string',
            'employed_in' => 'required|string',
            'country' => 'required|integer',
            'state' => 'required|integer',
            'city' => 'required|integer',
            'about' => 'required|string|max:500',
            'document' => 'nullable|file|mimes:pdf|max:2048',
            'image' => 'required|string',
            'zodiac_sign' => 'required|integer|exists:zodiac_signs,id',
            'star' => 'required|integer|exists:stars,id',
        ]);

        try {
            // Handle file upload
            $documentPath = null;
            if ($request->hasFile('document')) {
                $documentPath = $request->file('document')->store('matrimony/documents', 'public');
            }

            // Get names for zodiac and star
            $zodiacSign = ZodiacSign::find($validated['zodiac_sign']);
            $star = Star::find($validated['star']);

            // Create KYC record
            $kyc = MatrimonyKyc::create([
                'user_id' => Auth::id(),
                'marital_status' => $validated['marital_status'],
                'dob' => $validated['dob'],
                'family_status' => $validated['family_status'],
                'family_values' => $validated['family_values'],
                'family_type' => $validated['family_type'],
                'disability' => $validated['disability'],
                'height' => $validated['height'],
                'weight' => $validated['weight'],
                'caste' => $validated['caste'],
                'dosham' => $validated['dosham'],
                'gothram' => $validated['gothram'],
                'education' => $validated['education'],
                'occupation' => $validated['occupation'],
                'annual_income' => $validated['annual_income'],
                'employed_in' => $validated['employed_in'],
                'country' => $validated['country'],
                'state' => $validated['state'],
                'city' => $validated['city'],
                'about' => $validated['about'],
                'document_path' => $documentPath,
                'image' => $validated['image'],
                'status' => 'pending',
                'zodiac_sign' => $validated['zodiac_sign'], 
                'star' => $validated['star'],               
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'KYC submitted successfully!',
                'user_id' => 'M' . str_pad(Auth::id(), 6, '0', STR_PAD_LEFT)
            ]);

        } catch (\Exception $e) {
            \Log::error('KYC Submission Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to submit KYC: ' . $e->getMessage()
            ], 500);
        }
    }

    public function preference()
    {
        $motherTongues = MotherTongue::all();
        $castes = Caste::all();
        $zodiacsigns = ZodiacSign::all();
        $stars = Star::all();
        $ages = AgeRange::all();
        $income = IncomeRange::all();
        $religions = Religion::all();
        $marital_status = ['Married', 'Unmarried', 'Divorced', 'Widowed'];

        $preferences = MatrimonyPreference::where('user_id', auth()->id())->first();

        $selectedZodiac = $preferences ? (array) $preferences->zodiac_sign : [];
        $selectedStars = $preferences ? (array) $preferences->star : [];

        return view('matrimony.preference', compact('motherTongues', 'castes', 'zodiacsigns', 'stars', 'ages', 'income', 'religions', 'marital_status'), [
            'selectedZodiac' => $preferences ? $preferences->zodiac_sign : [],
            'selectedStars' => $preferences ? $preferences->star : []
        ]);
    }

    public function storePreference(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'partner_age' => 'required|string',
                'income' => 'required|string',
                'mother_tongue' => 'required|string',
                'religion' => 'required|string',
                'caste' => 'required|string',
                'height' => 'required|string',
                'weight' => 'required|string',
                'occupation' => 'required|string',
                'location' => 'required|string',
                'zodiac_sign' => 'nullable|array',
                'zodiac_sign.*' => 'integer|exists:zodiac_signs,id',
                'star' => 'nullable|array',
                'star.*' => 'integer|exists:stars,id',
                'marital_status' => 'required|string',
                'gender' => 'required|string',
            ]);
            Log::info('Incoming preference data:', $validatedData);

            // Convert arrays to delimited string
            $validatedData['zodiac_sign'] = is_array($request->zodiac_sign) ? implode('|', $request->zodiac_sign) : null;
            $validatedData['star'] = is_array($request->star) ? implode('|', $request->star) : null;

            // Get the authenticated user
            $user = auth()->user();

            // Store or update preferences
            MatrimonyPreference::updateOrCreate(
                ['user_id' => $user->id],
                $validatedData
            );

            // Refresh user model to get latest relations
            $user->refresh();

            // Check if both KYC and preferences exist
            if ($user->kyc && $user->matrimonyPreference) {
                $user->update(['profile_completed' => 1]);
            }

            // Log for debugging
            Log::info('User preferences saved:', $validatedData);
            Log::info('Preferences saved successfully for user: ' . $user->id);

            return response()->json([
                'success' => true,
                'message' => 'Preferences saved successfully!',
                'redirect_url' => url('/matrimony'),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function profile()
    {
        $userId = auth()->id();
        Log::info("Fetching profile for user ID: {$userId}");

        $kycRecord = DB::table('matrimony_kyc')
            ->leftJoin('users', 'matrimony_kyc.user_id', '=', 'users.id')
            ->select(
                'matrimony_kyc.*',
                'users.username'
            )
            ->where('matrimony_kyc.user_id', $userId) // Filter for logged-in user
            ->first(); // Use first() instead of get() since we expect one record per user

        Log::info("MatrimonyKYC Data:", (array) $kycRecord);

        return view('matrimony.main-profile', ['kycRecord' => $kycRecord]);
    }

    public function profilelisting(Request $request)
    {
        $castes = Caste::all();
        $motherTongues = MotherTongue::all();
        $zodiacsign = ZodiacSign::all();
        $stars = Star::all();
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
        $religions = Religion::all();
        $marital_status = ['married', 'unmarried', 'divorced', 'widowed'];

        $profile = null;

        if ($request->has('profile_id')) {
            $profile = ProfileListing::find($request->profile_id);
        }

        return view('matrimony.profile-listing', compact('castes', 'motherTongues', 'countries', 'states', 'cities', 'profile', 'zodiacsign', 'stars', 'religions', 'marital_status'));
    }

    // Update Profile Listing
    public function updateProfile(Request $request, $profile_id = null)
    {
        $castes = Caste::all();
        $motherTongues = MotherTongue::all();
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();

        // Find the profile if profile_id is provided
        $profile = $profile_id ? ProfileListing::find($profile_id) : null;

        return view('matrimony.update-profile-listing', compact('castes', 'motherTongues', 'countries', 'states', 'cities', 'profile'));
    }

    public function submitUpdateProfile(Request $request, $profile_id)
    {
        $profile = ProfileListing::findOrFail($profile_id);

        // First update regular fields
        $profile->update($request->all());

        // Then force is_verified update
        \DB::table('profile_listings')
            ->where('id', $profile_id)
            ->update(['is_verified' => 0]);

        return redirect('/matrimony/profile-lists')
            ->with('success', 'Profile updated successfully.');
    }

    public function storeProfileListing(Request $request)
    {
        Log::info('Form submission data:', $request->all());

        $imagePaths = [];
        if ($request->filled('images')) {
            $imageIds = explode('|', $request->input('images'));

            foreach ($imageIds as $imageId) {
                $imagePaths[] = $imageId;
            }
        }

        // Join the paths with pipe if you want to keep the current storage format
        $imagePathString = !empty($imagePaths) ? implode('|', $imagePaths) : null;

        // Calculate age from date of birth
        $dob = Carbon::parse($request->date_of_birth);
        $age = $dob->age;

        // Create profile with IDs and calculated age
        $profileListing = ProfileListing::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'date_of_birth' => $request->date_of_birth,
            'age' => $age,
            'gender' => $request->gender,
            'religion' => $request->religion,
            'occupation' => $request->occupation,
            'marital_status' => $request->marital_status,
            'annual_income' => $request->annual_income,
            'caste' => $request->caste,
            'mother_tongue' => $request->motherTongue,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'image' => $imagePathString, // Store the pipe-separated string
            'description' => $request->description,
            'paid' => 0,
            'payment_method' => null,
            'zodiac_sign' => $request->zodiac_sign,
            'star' => $request->star,
            'visibility' => $request->visibility ?? 0,
        ]);

        Log::info('Profile Listing Created:', $profileListing->toArray());

        session()->put('profile_listing_id', $profileListing->id);

        // Handle payment gateway if selected
        if ($request->filled('selected_payment_gateway')) {
            $payment_gateway = $request->selected_payment_gateway;
            $credential_function = 'get_' . $payment_gateway . '_credential';

            if (!method_exists((new PaymentGatewayCredential()), $credential_function)) {
                $custom_data = [
                    'request' => $request->all(),
                    'total' => get_static_option('matrimony_price'),
                    'payment_type' => "deposit",
                    'payment_for' => "membership",
                    'success_url' => route('user.membership.all'),
                ];

                $charge_customer_class_namespace = getChargeCustomerMethodNameByPaymentGatewayNameSpace($payment_gateway);
                $charge_customer_method_name = getChargeCustomerMethodNameByPaymentGatewayName($payment_gateway);

                $custom_charge_customer_class_object = new $charge_customer_class_namespace;

                if (
                    class_exists($charge_customer_class_namespace) &&
                    method_exists($custom_charge_customer_class_object, $charge_customer_method_name)
                ) {
                    return $custom_charge_customer_class_object->$charge_customer_method_name($custom_data);
                } else {
                    return back()->with(toastr_error('Incorrect Class or Method'));
                }
            } else {
                return $this->payment_with_gateway($payment_gateway);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Profile Listing Saved Successfully!',
        ]);
    }

    public function payment_with_gateway($payment_gateway_name)
    {
        try {
            $gateway_function = 'get_' . $payment_gateway_name . '_credential';
            $gateway = PaymentGatewayCredential::$gateway_function();

            $redirect_url = $gateway->charge_customer(
                $this->common_charge_customer_data($payment_gateway_name)
            );
            session()->put('payment_type', "matrimony");

            return $redirect_url;
        } catch (\Exception $e) {
            return back()->with(['msg' => $e->getMessage(), 'type' => 'danger']);
        }
    }
    public function common_charge_customer_data($payment_gateway_name)
    {
        $user = Auth::guard('web')->user();
        $email = $user->email;
        $name = $user->fullname;

        $ipn_route = route('user.' . strtolower($payment_gateway_name) . '.ipn.membership');

        \Log::info('IPN Route, matrimony price: ' . get_static_option('matrimony_price'));

        return [
            'amount' => get_static_option('matrimony_price'),
            'title' => "Profile Listing",
            'description' => "Matrimony",
            'ipn_url' => $ipn_route,
            'order_id' => session('profile_listing_id'),
            'track' => Str::random(36),
            'success_url' => route('user.membership.all'),
            'email' => $email,
            'name' => $name,
            'payment_type' => 'deposit',
        ];
    }

    public function profilelists()
    {
        $userId = auth()->id(); // Get the current logged-in user's ID

        $profiles = ProfileListing::where('user_id', $userId)
            ->select('id', 'name', 'date_of_birth', 'is_verified', 'rejection_reason')
            ->get();

        return view('matrimony.profile-lists', compact('profiles'));
    }

    public function decrementProfileCount()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $updated = DB::table('membership_histories')
            ->where('user_id', $user->id)
            ->where('profile_limit', '>', 0)
            ->decrement('profile_limit');

        if ($updated) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'message' => 'No profiles remaining']);
    }

    public function unlockProfile(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please login to unlock profiles',
                'redirect' => route('user.login')
            ], 401);
        }

        $request->validate([
            'profile_id' => 'required|exists:profile_listings,id'
        ]);

        return DB::transaction(function () use ($user, $request) {
            // Check if already unlocked
            $alreadyUnlocked = UnlockedProfile::where('user_id', $user->id)
                ->where('profile_id', $request->profile_id)
                ->exists();

            if ($alreadyUnlocked) {
                return response()->json(['status' => 'success']);
            }

            // Check in user_memberships table
            $membership = UserMembership::where('user_id', $user->id)
                ->where('profile_limit', '>', 0)
                ->first();

            if (!$membership) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No profile views remaining. Please upgrade your membership.',
                    'redirect' => route('matrimony.price')
                ], 403);
            }

            try {
                // Record unlock
                UnlockedProfile::create([
                    'user_id' => $user->id,
                    'profile_id' => $request->profile_id
                ]);

                // Deduct from profile_limit
                $membership->decrement('profile_limit');

                return response()->json([
                    'status' => 'success',
                    'remaining_views' => $membership->profile_limit - 1
                ]);

            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to unlock profile: ' . $e->getMessage()
                ], 500);
            }
        });
    }

    public function dashboard()
    {
        $userId = auth()->id();
        \Log::info("[MATCHING] Starting matching process for user ID: {$userId}");

        $userPreferences = MatrimonyPreference::where('user_id', $userId)->first();

        \Log::debug("[MATCHING] User preferences:", $userPreferences ? [
            'age_range' => "$userPreferences->partner_age",
            'gender' => $userPreferences->gender,
            'religion' => $userPreferences->religion,
            'zodiac_signs' => $userPreferences->zodiac_sign,
            'stars' => $userPreferences->star,
            'occupations' => $userPreferences->occupation,
            'annual_income' => $userPreferences->income,
            'caste' => $userPreferences->caste,
            'mother_tongue' => $userPreferences->mother_tongue
        ] : ['message' => 'No preferences found']);

        $matchesQuery = ProfileListing::where('user_id', '!=', $userId)
            ->where('is_verified', 1);

        if ($userPreferences) {
            if ($userPreferences->gender) {
                $matchesQuery->where('gender', $userPreferences->gender);
            }
        }

        $potentialMatches = $matchesQuery->inRandomOrder()->limit(20)->get();
        \Log::info("[MATCHING] Found {$potentialMatches->count()} potential matches for initial filtering");

        $finalMatches = [];
        $criteriaWeights = [
            'age' => 15,
            'gender' => 10,
            'religion' => 15,
            'zodiac_sign' => 10,
            'star' => 10,
            'occupation' => 10,
            'annual_income' => 15,
            'caste' => 10,
            'mother_tongue' => 5
        ];

        foreach ($potentialMatches as $profile) {
            $matchDetails = [
                'profile_id' => $profile->id,
                'profile_name' => $profile->name,
                'criteria_matches' => [],
                'raw_scores' => [],
                'total_score' => 0
            ];

            if ($userPreferences) {
                $ageScore = 0;
                if ($userPreferences->from_age && $userPreferences->to_age) {
                    $profileAge = Carbon::parse($profile->date_of_birth)->age;
                    $ageDiff = abs($profileAge - (($userPreferences->from_age + $userPreferences->to_age) / 2));
                    $maxAgeDiff = $userPreferences->to_age - $userPreferences->from_age;
                    $ageScore = max(0, $criteriaWeights['age'] * (1 - ($ageDiff / $maxAgeDiff)));
                    $matchDetails['criteria_matches']['age'] = "{$profile->age} (preferred: {$userPreferences->from_age}-{$userPreferences->to_age})";
                    $matchDetails['raw_scores']['age'] = $ageScore;
                }

                $genderScore = ($userPreferences->gender && $profile->gender == $userPreferences->gender)
                    ? $criteriaWeights['gender'] : 0;
                $matchDetails['criteria_matches']['gender'] = $profile->gender;
                $matchDetails['raw_scores']['gender'] = $genderScore;

                $religionScore = ($userPreferences->religion && $profile->religion == $userPreferences->religion)
                    ? $criteriaWeights['religion'] : 0;
                $matchDetails['criteria_matches']['religion'] = $profile->religion;
                $matchDetails['raw_scores']['religion'] = $religionScore;

                $zodiacScore = 0;
                if ($userPreferences->zodiac_sign) {
                    $zodiacs = explode('|', $userPreferences->zodiac_sign);
                    $zodiacScore = in_array($profile->zodiac_sign, $zodiacs) ? $criteriaWeights['zodiac_sign'] : 0;
                    $matchDetails['criteria_matches']['zodiac_sign'] = "{$profile->zodiac_sign} (preferred: " . implode(', ', $zodiacs) . ")";
                    $matchDetails['raw_scores']['zodiac_sign'] = $zodiacScore;
                }

                $starScore = 0;
                if ($userPreferences->star) {
                    $stars = explode('|', $userPreferences->star);
                    $starScore = in_array($profile->star, $stars) ? $criteriaWeights['star'] : 0;
                    $matchDetails['criteria_matches']['star'] = "{$profile->star} (preferred: " . implode(', ', $stars) . ")";
                    $matchDetails['raw_scores']['star'] = $starScore;
                }

                $occupationScore = 0;
                if ($userPreferences->occupation) {
                    $occupations = explode('|', $userPreferences->occupation);
                    foreach ($occupations as $occupation) {
                        if (stripos($profile->occupation, trim($occupation)) !== false) {
                            $occupationScore = $criteriaWeights['occupation'];
                            break;
                        }
                    }
                    $matchDetails['criteria_matches']['occupation'] = "{$profile->occupation} (preferred: " . implode(', ', $occupations) . ")";
                    $matchDetails['raw_scores']['occupation'] = $occupationScore;
                }

                $incomeScore = 0;
                if ($userPreferences->annual_income && $profile->annual_income) {
                    $incomeRatio = min(1, $profile->annual_income / $userPreferences->annual_income);
                    $incomeScore = $criteriaWeights['annual_income'] * $incomeRatio;
                    $matchDetails['criteria_matches']['annual_income'] = "{$profile->annual_income} (preferred min: {$userPreferences->annual_income})";
                    $matchDetails['raw_scores']['annual_income'] = $incomeScore;
                }

                $casteScore = ($userPreferences->caste && $profile->caste == $userPreferences->caste)
                    ? $criteriaWeights['caste'] : 0;
                $matchDetails['criteria_matches']['caste'] = $profile->caste;
                $matchDetails['raw_scores']['caste'] = $casteScore;

                $motherTongueScore = ($userPreferences->mother_tongue && $profile->mother_tongue == $userPreferences->mother_tongue)
                    ? $criteriaWeights['mother_tongue'] : 0;
                $matchDetails['criteria_matches']['mother_tongue'] = $profile->mother_tongue;
                $matchDetails['raw_scores']['mother_tongue'] = $motherTongueScore;

                $totalScore = array_sum($matchDetails['raw_scores']);
                $matchPercentage = round(($totalScore / array_sum($criteriaWeights)) * 100 / 5) * 5;

                $matchDetails['total_score'] = $totalScore;
                $matchDetails['match_percentage'] = $matchPercentage;
                $profile->match_percentage = $matchPercentage;

                $finalMatches[] = $matchDetails;
            }
        }

        $matches = $potentialMatches->sortByDesc('match_percentage')
            ->filter(function ($profile) {
                return $profile->match_percentage > 50;
            })
            ->take(4);

        // Add first image URL to each profile
        $matches->each(function ($profile) {
            $firstImageId = $profile->image;
            $profile->first_image_url = $firstImageId
                ? render_image_markup_by_attachment_id($firstImageId)
                : '/assets/uploads/media-uploader/profile.png';
        });

        $receivedRequests = ProfileRequest::with(['sender.identity_verify', 'sender.kyc', 'profile'])
            ->whereHas('profile', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('status', 'pending')
            ->latest()
            ->get();

        $acceptedRequests = ProfileRequest::with(['sender.identity_verify', 'sender.kyc', 'profile'])
            ->whereHas('profile', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('status', 'accepted')
            ->latest()
            ->get();

        $rejectedRequests = ProfileRequest::with(['sender.identity_verify', 'sender.kyc', 'profile'])
            ->whereHas('profile', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('status', 'rejected')
            ->latest()
            ->get();

        $userMembership = UserMembership::where('user_id', $userId)
            ->latest('created_at')
            ->first();

        $membershipInfo = null;
        if ($userMembership && $userMembership->membership && $userMembership->membership->category == 1) {
            $membershipInfo = [
                'title' => $userMembership->membership->title,
                'profile_limit' => $userMembership->profile_limit
            ];
        }

        return view('matrimony.dashboard', compact(
            'matches',
            'receivedRequests',
            'acceptedRequests',
            'rejectedRequests',
            'membershipInfo'
        ));
    }

    public function accept(Request $request)
    {
        $requestModel = ProfileRequest::find($request->id);
        $requestModel->status = 'accepted';
        $requestModel->save();

        // Get new count of pending requests
        $newCount = ProfileRequest::where('status', 'pending')->count();

        return response()->json([
            'success' => true,
            'newCount' => $newCount
        ]);
    }

    public function deny(Request $request)
    {
        try {
            $requestModel = ProfileRequest::findOrFail($request->id);
            $requestModel->status = 'rejected';
            $requestModel->save();

            $newCount = ProfileRequest::where('status', 'pending')->count();

            return response()->json([
                'success' => true,
                'message' => 'Request has been denied successfully',
                'newCount' => $newCount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error denying request: ' . $e->getMessage()
            ], 500);
        }
    }

    public function requestlists()
    {
        $userId = auth()->id();

        $requests = ProfileRequest::with(['profile']) // sender is not needed now
            ->where('sender_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('matrimony.requests-lists', compact('requests'));
    }

    public function filter(Request $request, $profileId = null)
    {
        // Start with base query for verified profiles excluding current user
        $query = ProfileListing::where('user_id', '!=', auth()->id())
            ->where('is_verified', 1);

        // Check if we're viewing a single profile
        $isSingleProfile = $profileId !== null;

        if ($isSingleProfile) {
            // Handle single profile view
            $profile = $query->findOrFail($profileId);

            // Ensure the profile is verified and not the current user's
            if ($profile->user_id == auth()->id() || !$profile->is_verified) {
                abort(404);
            }

            $profiles = collect([$profile]);
        } else {
            // Apply filters only if at least one filter is present
            if (
                $request->anyFilled([
                    'gender',
                    'age_range',
                    'marital_status',
                    'income',
                    'occupation',
                    'religion',
                    'caste',
                    'star',
                    'zodiac_sign',
                    'country',
                    'state',
                    'city'
                ])
            ) {

                // Apply all filters (same as your existing logic)
                if ($request->filled('gender')) {
                    $query->where('gender', $request->gender);
                }

                if ($request->filled('age_range')) {
                    $ageRange = AgeRange::find($request->age_range);
                    if ($ageRange) {
                        $query->whereBetween('age', [$ageRange->from_age, $ageRange->to_age]);
                    }
                }
            }

            if ($request->filled('marital_status')) {
                $query->where('marital_status', $request->marital_status);
            }            

            if ($request->filled('income')) {
                $incomeRange = IncomeRange::find($request->income);
                if ($incomeRange) {
                    $query->where('income', '>=', $incomeRange->from_income);
                }
            }

            if ($request->filled('occupation')) {
                $query->where('occupation', 'LIKE', "%{$request->occupation}%");
            }

            if ($request->filled('religion')) {
                $query->where('religion', $request->religion);
            }

            if ($request->filled('caste')) {
                $query->where('caste', $request->caste);
            }

            if ($request->filled('star')) {
                $query->where('star', $request->star);
            }

            if ($request->filled('zodiac_sign')) {
                $query->where('zodiac_sign', $request->zodiac_sign);
            }

            if ($request->filled('country')) {
                $query->where('country', $request->country);
            }

            if ($request->filled('state')) {
                $query->where('state', $request->state);
            }

            if ($request->filled('city')) {
                $query->where('city', $request->city);
            }
        }

        // Get paginated results
        $profiles = $query->paginate(12);

        // Fetch all filter options from database
        $filterOptions = [
            'ages' => AgeRange::orderBy('from_age')->orderBy('to_age')->get(),
            'income' => IncomeRange::orderBy('from_income')->orderBy('to_income')->get(),
            'religions' => Religion::orderBy('religion')->get(),
            'castes' => Caste::orderBy('caste')->get(),
            'stars' => Star::orderBy('star')->get(),
            'zodiacSigns' => ZodiacSign::orderBy('zodiac_sign')->get(),
            'countries' => Country::orderBy('country')->get(),
            'states' => State::orderBy('state')->get(),
            'cities' => City::orderBy('city')->get(),
            'maritalStatuses' => ['Married', 'Unmarried', 'Divorced', 'Widowed'],
        ];

        return view('matrimony.filter', [
            'profiles' => $profiles,
            'filters' => $request->all(),
            'filterOptions' => $filterOptions,
            'hasFilters' => $request->anyFilled([
                'gender',
                'age_range',
                'marital_status',
                'income',
                'occupation',
                'religion',
                'caste',
                'star',
                'zodiac_sign',
                'country',
                'state',
                'city'
            ])
        ]);
    }

   
}