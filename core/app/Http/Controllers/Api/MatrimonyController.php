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
use Razorpay\Api\Api;
use Illuminate\Support\Facades\DB;
use App\Services\RazorpayService;
use Illuminate\Support\Facades\Auth;


class MatrimonyController extends Controller
{

    public function profileLists()
    {
        $profiles = ProfileListing::all()->map(function ($profile) {
            $imageIds = array_filter(preg_split('/[|,]/', $profile->image), fn($id) => !empty(trim($id)));

            $profile->image_urls = array_map(function ($id) {
                return get_attachment_url_by_ids(trim($id));
            }, $imageIds);

            return $profile;
        });

        return response()->json([
            'success' => true,
            'data' => $profiles
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

        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'date_of_birth'         => 'required|date',
            'age'                   => 'required|integer|min:0',
            'gender'                => 'required|in:male,female,other',
            'religion'              => 'nullable|string|max:100',
            'occupation'            => 'required|string|max:150',
            'marital_status'        => 'required|in:single,married,divorced,widowed',
            'annual_income'         => 'required|numeric|min:0',
            'caste'                 => 'nullable|string|max:100',
            'mother_tongue'         => 'required|string|max:100',
            'country'               => 'required|string|max:100',
            'state'                 => 'required|string|max:100',
            'city'                  => 'required|string|max:100',
            'image'                 => 'required',
            'description'           => 'required|string',
            'zodiac_sign'           => 'nullable|string|max:50',
            'star'                  => 'nullable|string|max:50',
            'visibility'            => 'nullable|boolean',
            'paid'                  => 'nullable|boolean',
            'payment_method'        => 'nullable|string|max:50',
            'is_verified'           => 'nullable|boolean',
            'rejection_reason'      => 'nullable|string',
            'selected_payment_gateway' => 'required|string',
        ]);

        // Inject user_id and ensure paid/payment_method defaults
        $data = array_merge($validated, [
            'user_id'        => $user->id,
            'paid'           => $validated['paid'] ?? 0,
            'payment_method' => $validated['payment_method'] ?? null,
        ]);

        // Create the ProfileListing
        $profile = ProfileListing::create($data);

        // Fetch gateway credentials from DB
        $gatewayRow = DB::table('payment_gateways')
            ->where('name', $request->selected_payment_gateway)
            ->first();
        if (! $gatewayRow) {
            return response()->json(['error' => 'Selected payment gateway not found.'], 404);
        }

        $credentials = json_decode($gatewayRow->credentials, true) ?: [];
        $apiKey = $credentials['api_key'] ?? null;
        $apiSecret = $credentials['api_secret'] ?? null;

        if (! $apiKey || ! $apiSecret) {
            return response()->json(['error' => 'Incomplete gateway credentials.'], 500);
        }

        // Instantiate RazorpayService with dynamic creds
        $razorpayService = new RazorpayService($apiKey, $apiSecret);

        // Create order
        $amountInRupees = get_static_option('matrimony_price') ?? 0; // e.g. 500
        $order = $razorpayService->createOrder($amountInRupees);

        // Build checkout URL
        $query = http_build_query([
            'order_id'             => $order['id'],
            'amount'               => $amountInRupees,
            'currency'             => 'INR',
            'key'                  => $razorpayService->getKey(),
            'profile_listing_id'   => $profile->id,
            'user_id'              => $profile->user_id,
        ]);

        $checkoutUrl = route('profile.checkout') . '?' . $query;

        return response()->json([
            'success'     => true,
            'checkout_url' => $checkoutUrl,
            'order_id'    => $order['id'],
            'message'     => 'Checkout URL generated successfully.'
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


    public function accept(Request $request)
    {
        $requestModel = ProfileRequest::find($request->id);


        if (!$requestModel) {
            return response()->json(['message' => 'Request not found'], 404);
        }


        $requestModel->status = 'accepted';
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

            $validatedData = $request->validate([
                'marital_status' => 'required|string',
                'dob' => 'required|date_format:d-m-Y', // Changed validation
                'family_status' => 'required|string',
                'family_values' => 'required|string',
                'family_type' => 'required|string',
                'disability' => 'required|string',
                'height' => 'required|numeric|min:50|max:250',
                'weight' => 'required|string',
                'caste' => 'required|string',
                'dosham' => 'required|string',
                'gothram' => 'required|string',
                'education' => 'required|string',
                'occupation' => 'required|string',
                'annual_income' => 'required|string',
                'employed_in' => 'required|string',
                'country' => 'required|string',
                'state' => 'required|string',
                'city' => 'required|string',
                'about' => 'required|string|max:500',
                'image' => 'required|numeric', // Now expecting image ID
                'gallery_images' => 'sometimes|array',
                'gallery_images.*' => 'numeric'
            ]);

            // Convert date to MySQL format
            $validatedData['dob'] = \Carbon\Carbon::createFromFormat('d-m-Y', $validatedData['dob'])->format('Y-m-d');

            // Attach authenticated user ID
            $validatedData['user_id'] = auth()->id();
            $validatedData['marital_status'] = strtolower($validatedData['marital_status']);

            // Save to database
            $matrimonyKyc = MatrimonyKyc::create($validatedData);

            return response()->json([
                'status' => 'success',
                'message' => 'User details saved successfully!',
                'user_id' => 'M' . str_pad($matrimonyKyc->user_id, 6, '0', STR_PAD_LEFT),
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('User Details Store Error: ' . $e->getMessage());
            \Log::error('Stack Trace: ' . $e->getTraceAsString());

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
}
