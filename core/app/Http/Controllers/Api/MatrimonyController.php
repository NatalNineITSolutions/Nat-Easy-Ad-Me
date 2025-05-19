<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AgeRange;
use App\Models\Caste;
use App\Models\Dosham;
use App\Models\Gothram;
use App\Models\IncomeRange;
use App\Models\MotherTongue;
use App\Models\Religion;
use App\Models\Star;
use App\Models\UnlockedProfile;
use App\Models\ZodiacSign;
use Illuminate\Http\Request;
use App\Models\ProfileListing;
use Illuminate\Support\Facades\Validator;
use App\Models\ProfileRequest;
use App\Models\MatrimonyKyc;
use App\Models\MatrimonyPreference;
use App\Models\User;
use App\Models\UsersBV;
use App\Services\BVDistributionService;
use Illuminate\Support\Facades\Log;
use Modules\CountryManage\app\Models\City;
use Modules\CountryManage\app\Models\Country;
use Modules\CountryManage\app\Models\State;
use Modules\Membership\app\Models\UserMembership;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\DB;
use App\Services\RazorpayService;
use Illuminate\Support\Facades\Auth;


class MatrimonyController extends Controller
{

    public function profileLists()
    {
        $profiles = ProfileListing::with([
            'motherTongue',
            'caste',
            'country',
            'state',
            'city',
        ])->get()
            ->map(function ($profile) {
                // build image_urls as before
                $imageIds = array_filter(
                    preg_split('/[|,]/', $profile->image),
                    fn($id) => trim($id) !== ''
                );
                $profile->image_urls = array_map(
                    fn($id) => get_attachment_url_by_ids(trim($id)),
                    $imageIds
                );

                // now append the names from the loaded relations:
                $profile->mother_tongue_name = $profile->motherTongue?->mother_tongue;
                $profile->caste_name = $profile->castes?->caste;
                $profile->country_name = $profile->countries?->country;
                $profile->state_name = $profile->states?->state;
                $profile->city_name = $profile->cities?->city;

                return $profile;
            });

        return response()->json([
            'success' => true,
            'data' => $profiles,
        ]);
    }

    public function getProfileDetails($profile_id)
    {
        if (!$profile_id) {
            return response()->json([
                'success' => false,
                'message' => 'Profile ID is required.'
            ], 400);
        }

        $profile = ProfileListing::find($profile_id);

        if (!$profile) {
            return response()->json([
                'success' => false,
                'message' => 'Profile not found.'
            ], 404);
        }

        $imageIds = array_filter(preg_split('/[|,]/', $profile->image), fn($id) => !empty(trim($id)));

        $profile->image_urls = array_map(function ($id) {
            return get_attachment_url_by_ids(trim($id)); // Only URL, no HTML
        }, $imageIds);

        return response()->json([
            'success' => true,
            'data' => $profile
        ]);
    }

    public function storeProfile(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 401);
        }

        // 1) Validate input, treating 'image' as an array of IDs
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'age' => 'required|integer|min:0',
            'gender' => 'required|in:male,female,other',
            'religion' => 'nullable|string|max:100',
            'occupation' => 'required|string|max:150',
            'marital_status' => 'required|in:unmarried,married,divorced,widowed',
            'annual_income' => 'required|numeric|min:0',
            'caste' => 'nullable|string|max:100',
            'mother_tongue' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'lat' => 'nullable|numeric',
            'lon' => 'nullable|numeric',
            'image' => 'required|array|min:1',
            'image.*' => 'integer',           // each element must be an integer ID
            'description' => 'required|string',
            'zodiac_sign' => 'nullable|string|max:50',
            'star' => 'nullable|string|max:50',
            'visibility' => 'sometimes|boolean',
            'paid' => 'sometimes|boolean',
            'payment_method' => 'nullable|string|max:50',
            'is_verified' => 'sometimes|boolean',
            'rejection_reason' => 'nullable|string',
            'selected_payment_gateway' => 'required|string',
        ]);

        // 2) Turn the array of image IDs into a pipe-separated string
        $imageIds = $validated['image'];            // e.g. [1274,1273]
        $imageString = implode('|', $imageIds);        // "1274|1273"

        // 3) Merge defaults for optional flags/fields
        $data = array_merge($validated, [
            'user_id' => $user->id,
            'paid' => $validated['paid'] ?? false,
            'payment_method' => $validated['payment_method'] ?? null,
            'is_verified' => $validated['is_verified'] ?? false,
            'rejection_reason' => $validated['rejection_reason'] ?? null,
        ]);

        // 4) Populate and save
        $profile = new ProfileListing();
        $profile->user_id = $data['user_id'];
        $profile->name = $data['name'];
        $profile->date_of_birth = $data['date_of_birth'];
        $profile->age = $data['age'];
        $profile->gender = $data['gender'];
        $profile->religion = $data['religion'];
        $profile->occupation = $data['occupation'];
        $profile->marital_status = $data['marital_status'];
        $profile->annual_income = $data['annual_income'];
        $profile->caste = $data['caste'];
        $profile->mother_tongue = $data['mother_tongue'];
        $profile->country = $data['country'];
        $profile->state = $data['state'];
        $profile->city = $data['city'];
        $profile->address = $data['address'];
        $profile->lat = $data['lat'];
        $profile->lon = $data['lon'];

        // <-- store the pipe-separated IDs here -->
        $profile->image = $imageString;

        $profile->description = $data['description'];
        $profile->zodiac_sign = $data['zodiac_sign'];
        $profile->star = $data['star'];
        $profile->visibility = $data['visibility'];
        $profile->paid = $data['paid'];
        $profile->payment_method = $data['payment_method'];
        $profile->is_verified = $data['is_verified'];
        $profile->rejection_reason = $data['rejection_reason'];
        $profile->save();

        // 5) Fetch gateway creds and create a Razorpay order
        $gatewayRow = DB::table('payment_gateways')
            ->where('name', $request->selected_payment_gateway)
            ->first();
        if (!$gatewayRow) {
            return response()->json(['error' => 'Selected payment gateway not found.'], 404);
        }
        $creds = json_decode($gatewayRow->credentials, true) ?: [];
        $apiKey = $creds['api_key'] ?? null;
        $apiSecret = $creds['api_secret'] ?? null;
        if (!$apiKey || !$apiSecret) {
            return response()->json(['error' => 'Incomplete gateway credentials.'], 500);
        }

        $razorpayService = new RazorpayService($apiKey, $apiSecret);
        $amountInRupees = get_static_option('matrimony_price') ?? 0;
        $order = $razorpayService->createOrder($amountInRupees);

        // 6) Build and return the checkout URL
        $query = http_build_query([
            'order_id' => $order['id'],
            'amount' => $amountInRupees,
            'currency' => 'INR',
            'key' => $razorpayService->getKey(),
            'profile_listing_id' => $profile->id,
            'user_id' => $profile->user_id,
        ]);

        return response()->json([
            'success' => true,
            'checkout_url' => route('profile.checkout') . '?' . $query,
            'order_id' => $order['id'],
            'message' => 'Checkout URL generated successfully.'
        ]);
    }

    public function handlePaymentSuccess(Request $request)
    {
        $profileListingId = $request->query('profile_listing_id');
        $orderId = $request->query('order_id');
        $amount = $request->query('amount');
        $membershipId = $request->query('membership_id');
        $userId = $request->query('user_id');
        $signature = $request->query('signature');


        // Update the profile listing record
        $update = ProfileListing::where('id', $profileListingId)->update([
            'paid' => 1,
            'payment_method' => "Razorpay",
        ]);

        // Retrieve the updated profile listing record
        $profileListing = ProfileListing::find($profileListingId);
        if (!$profileListing) {
            return response()->json(['error' => 'Profile listing not found.'], 404);
        }

        // Get BV points from config
        $bvPoints = get_static_option('matrimony_bv_points') ?? 0;

        // Create a BV record for the user
        $usersBv = UsersBV::create([
            'user_id' => $profileListing->user_id,
            'bv_points' => $bvPoints,
            'upgrade_time' => \Carbon\Carbon::now(),
            'type' => 'Profile Listing',
        ]);

        // Find the user
        $user = User::find($profileListing->user_id);
        if ($user) {
            // Update user's self purchased BV
            $user->self_purchased_bv = ($user->self_purchased_bv ?? 0) + $bvPoints;
            $user->save();

            // Distribute BV
            $bvService = new BVDistributionService();
            $bvService->distributeBVPoints($user, $bvPoints, null, $profileListing->user_id);
        }

        if ($update) {
            return view('payment-success');
        }
    }

    public function sendRequest(Request $request, $profileId)
    {

        $profile = \DB::table('profile_listings')->where('id', $profileId)->first();

        if (!$profile) {
            return response()->json([
                'message' => 'Profile not found'
            ], 404);
        }


        if ($profile->user_id === auth()->id()) {
            return response()->json([
                'message' => 'You cannot send a request to your own profile'
            ], 403);
        }


        if (
            ProfileRequest::where('sender_id', auth()->id())
                ->where('profile_id', $profileId)
                ->exists()
        ) {
            return response()->json([
                'message' => 'You have already sent a request to this profile'
            ], 422);
        }


        ProfileRequest::create([
            'sender_id' => auth()->id(),
            'profile_id' => $profileId,
            'status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Profile request sent successfully!'
        ]);
    }

    public function updateStatus(Request $request)
    {
        $requestModel = ProfileRequest::find($request->id);

        if (!$requestModel) {
            return response()->json(['message' => 'Request not found'], 404);
        }

        if (!in_array($request->status, ['accepted', 'rejected'])) {
            return response()->json(['message' => 'Invalid status'], 400);
        }

        $requestModel->status = $request->status;
        $requestModel->save();

        $newCount = ProfileRequest::where('status', 'pending')->count();

        return response()->json([
            'success' => true,
            'newCount' => $newCount
        ]);
    }

    // In your controller
    public function storeUserDetails(Request $request)
    {
        try {
            if (!auth()->check()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User must be logged in to submit details.'
                ], 401);
            }

            $validated = $request->validate([
                'marital_status' => 'required|string',
                'dob' => 'required|date_format:d-m-Y',
                'family_status' => 'required|string',
                'family_values' => 'required|string',
                'family_type' => 'required|string',
                'disability' => 'required|string',
                'height' => 'required|numeric|min:50|max:250',
                'weight' => 'required|string',

                // store these as integer IDs:
                'zodiac_sign' => 'nullable|integer|exists:zodiac_signs,id',
                'star' => 'nullable|integer|exists:stars,id',
                'caste' => 'required|integer|exists:castes,id',
                'dosham' => 'required|integer|exists:doshams,id',
                'gothram' => 'required|integer|exists:gothrams,id',
                'annual_income' => 'required|string',

                'education' => 'required|string',
                'occupation' => 'required|string',
                'employed_in' => 'required|string',
                'country' => 'required|string',
                'state' => 'required|string',
                'city' => 'required|string',
                'about' => 'required|string|max:500',
                'image' => 'required|numeric',
                'gallery_images' => 'sometimes|array',
                'gallery_images.*' => 'numeric',
            ]);

            // convert and normalize
            $validated['dob'] = \Carbon\Carbon::createFromFormat('d-m-Y', $validated['dob'])->format('Y-m-d');
            $validated['user_id'] = auth()->id();
            $validated['marital_status'] = strtolower($validated['marital_status']);

            $kyc = MatrimonyKyc::create($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'User details saved successfully!',
                'user_id' => 'M' . str_pad($kyc->user_id, 6, '0', STR_PAD_LEFT),
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('User Details Store Error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred. Please try again.',
            ], 500);
        }
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'partner_age' => 'required|integer|min:18|max:100',
            'mother_tongue' => 'required|string',
            'religion' => 'required|string',
            'caste' => 'required|string',
            'height' => 'required|string',
            'weight' => 'required|string',
            'occupation' => 'required|string',
            'location' => 'required|string',
            'income' => 'required|string',
            'marital_status' => 'required|string',
            'gender' => 'required|string',
            'zodiac_sign' => 'required|string',
            'star' => 'required|string',
        ]);


        $user = auth()->user();


        $validatedData['user_id'] = $user->id;


        MatrimonyPreference::updateOrCreate(
            ['user_id' => $user->id],
            $validatedData
        );


        if ($user->kyc && $user->matrimonyPreference) {
            $user->update(['profile_completed' => 1]);
        }


        Log::info('API Preferences saved for user: ' . $user->id);

        return response()->json([
            'success' => true,
            'message' => 'Preferences saved successfully!',
        ]);
    }

    public function religion()
    {
        $religions = Religion::all();

        return response()->json([
            'success' => true,
            'data' => $religions
        ], 200);
    }

    public function caste()
    {
        $castes = Caste::all();

        return response()->json([
            'success' => true,
            'data' => $castes
        ], 200);
    }

    public function gothram()
    {
        $gothram = Gothram::all();

        return response()->json([
            'success' => true,
            'data' => $gothram
        ], 200);
    }

    public function dosham()
    {
        $dosham = Dosham::all();

        return response()->json([
            'success' => true,
            'data' => $dosham
        ], 200);
    }

    public function income()
    {
        $income = IncomeRange::all();

        return response()->json([
            'success' => true,
            'data' => $income
        ], 200);
    }

    public function age()
    {
        $ages = AgeRange::all();

        return response()->json([
            'success' => true,
            'data' => $ages
        ], 200);
    }

    public function mothertongue()
    {
        $motherTongue = MotherTongue::all();

        return response()->json([
            'success' => true,
            'data' => $motherTongue
        ], 200);
    }

    public function zodiacSign()
    {
        $zodiacSigns = ZodiacSign::all();

        return response()->json([
            'success' => true,
            'data' => $zodiacSigns
        ], 200);
    }

    public function star()
    {
        $stars = Star::all();

        return response()->json([
            'success' => true,
            'data' => $stars
        ], 200);
    }

    public function country()
    {
        // load countries → states → cities
        $countries = Country::with('states.cities')->get();

        return response()->json([
            'success' => true,
            'data' => $countries
        ], 200);
    }


    public function state(Request $request)
    {
        $validated = $request->validate([
            'country_id' => 'required|integer|exists:countries,id',
        ]);

        $states = State::where('country_id', $validated['country_id'])->get();

        return response()->json([
            'success' => true,
            'data' => $states
        ], 200);
    }

    public function city(Request $request)
    {
        $validated = $request->validate([
            'state_id' => 'required|integer|exists:states,id',
        ]);

        $cities = City::where('state_id', $validated['state_id'])->get();

        return response()->json([
            'success' => true,
            'data' => $cities
        ], 200);
    }

    public function getReceivedRequests(Request $request)
    {
        $userId = auth()->id();

        $receivedRequests = ProfileRequest::with(['sender.identity_verify', 'sender.kyc', 'profile'])
            ->whereHas('profile', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('status', 'pending')
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'count' => $receivedRequests->count(),
            'data' => $receivedRequests
        ]);
    }

    public function getAcceptedRequests()
    {
        $userId = auth()->id();

        $requests = ProfileRequest::with(['sender', 'profile']) // Include related models
            ->where('status', 'accepted')
            ->where(function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                    ->orWhere('profile_id', $userId);
            })
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $requests
        ]);
    }

    public function getRejectedRequests()
    {
        $userId = auth()->id();

        $rejectedRequests = ProfileRequest::with(['sender', 'profile']) // Include related models
            ->where('status', 'rejected')
            ->where(function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                    ->orWhere('profile_id', $userId);
            })
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $rejectedRequests,
        ]);
    }

    public function unlockProfile(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please login to unlock profiles',
                'redirect' => route('user.login'),
            ], 401);
        }

        $request->validate([
            'profile_id' => 'required|exists:profile_listings,id',
        ]);

        return DB::transaction(function () use ($user, $request) {
            // 1) Already unlocked?
            $alreadyUnlocked = UnlockedProfile::where('user_id', $user->id)
                ->where('profile_id', $request->profile_id)
                ->exists();

            if ($alreadyUnlocked) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Already unlocked',
                ]);
            }

            // 2) Find a membership with remaining profile_limit > 0
            $membership = UserMembership::where('user_id', $user->id)
                ->where('profile_limit', '>', 0)
                ->first();

            if (!$membership) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No profile views remaining. Please upgrade your membership.',
                    'redirect' => route('matrimony.price'),
                ], 403);
            }

            try {
                // 3) Create the unlock record
                UnlockedProfile::create([
                    'user_id' => $user->id,
                    'profile_id' => $request->profile_id,
                ]);

                // 4) Deduct one view
                $membership->decrement('profile_limit');

                return response()->json([
                    'status' => 'success',
                    'remaining_views' => $membership->profile_limit,
                ]);
            } catch (\Exception $e) {
                // Rollback is automatic on exception in DB::transaction
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to unlock profile: ' . $e->getMessage(),
                ], 500);
            }
        });
    }

    public function getUnlockedProfiles()
    {
        $unlockedProfiles = UnlockedProfile::with(['user', 'profile'])->get();

        return response()->json([
            'success' => true,
            'data' => $unlockedProfiles
        ], 200);
    }

    public function apiFilter(Request $request, $profileId = null)
    {
        $query = ProfileListing::where('user_id', '!=', auth()->id())
            ->where('is_verified', 1);

        $isSingle = $profileId !== null;
        if ($isSingle) {
            $profile = $query->findOrFail($profileId);
            if ($profile->user_id == auth()->id() || !$profile->is_verified) {
                return response()->json(['message' => 'Not Found'], 404);
            }
            $items = collect([$profile]);
        } else {
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
                if ($request->filled('gender')) {
                    $query->where('gender', $request->gender);
                }
                if ($request->filled('age_range')) {
                    if ($ar = AgeRange::find($request->age_range)) {
                        $query->whereBetween('age', [$ar->from_age, $ar->to_age]);
                    }
                }
                if ($request->filled('marital_status')) {
                $query->where('marital_status', $request->marital_status);
            }

            if ($request->filled('income')) {
                $incomeRange = IncomeRange::find($request->income);
                if ($incomeRange) {
                    $query->where('annual_income', '>=', $incomeRange->from_income);
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
            $items = $query->paginate(12);
        }
    
        $filterOptions = [
            'ages' => AgeRange::orderBy('from_age')->get(),
            'income' => IncomeRange::orderBy('from_income')->get(),
            'religions' => Religion::orderBy('religion')->get(),
            'castes' => Caste::orderBy('caste')->get(),
            'stars' => Star::orderBy('star')->get(),
            'zodiacSigns' => ZodiacSign::orderBy('zodiac_sign')->get(),
            'countries' => Country::orderBy('country')->get(),
            'states' => State::orderBy('state')->get(),
            'cities' => City::orderBy('city')->get(),
            'maritalStatuses' => ['Married', 'Unmarried', 'Divorced', 'Widowed'],
        ];

        return response()->json([
            'data' => $items,
            'filters' => $request->only([
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
            ]),
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
            ]),
        ]);
    }

    public function index(Request $request)
    {
        $user = $request->user(); 

        $profiles = ProfileListing::where('user_id', $user->id)
            ->select('id', 'name', 'date_of_birth', 'is_verified', 'rejection_reason')
            ->get();

        return response()->json([
            'data' => $profiles,
        ], 200);
    }
}
