<?php

namespace App\Http\Controllers;

use App\Helpers\PaymentGatewayCredential;
use App\Http\Controllers\Controller;
use App\Models\MatrimonyPreference;
use Illuminate\Http\Request;
use App\Models\MatrimonyKyc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Membership\app\Models\Membership;
use App\Models\ProfileListing;
use Illuminate\Support\Str;
use App\Models\Gothram;
use App\Models\Caste;
use App\Models\MotherTongue;
use App\Models\Dosham;
use Modules\CountryManage\app\Models\City;
use Modules\CountryManage\app\Models\State;
use Modules\CountryManage\app\Models\Country;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class MatrimonyController extends Controller
{
    public function index()
    {
        // Check if user is logged in
        if (!auth()->check()) {
            return redirect()->route('user.login')->with('error', 'Please log in or register first to access Matrimony');
        }

        // Get the authenticated user
        $user = auth()->user();

        // Check if the profile is completed
        if ($user->profile_completed != 1) {
            return redirect()->route('matrimony.user-details')->with('info', 'Please complete your profile to proceed.');
        }

        // Get verified profiles with only needed fields
        $profiles = ProfileListing::where('is_verified', 1)
            ->where('id', '!=', $user->id)
            ->select('id', 'name', 'age', 'occupation', 'city', 'image') // Only select needed fields
            ->inRandomOrder()
            ->limit(7)
            ->get();

        return view('matrimony.index', compact('profiles'));
    }


    public function price()
    {
        $memberships = Membership::where('category', 1)->get();

        return view('matrimony.price', compact('memberships'));
    }


    public function profiledetails()
    {
        $user = Auth::user();
        return view('matrimony.profile-details');
    }
    public function userdetails()
    {
        $castes = Caste::all();
        $gothrams = Gothram::all();
        $doshams = Dosham::all();
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();

        return view('matrimony.user-details', compact('castes', 'gothrams', 'doshams', 'countries', 'states', 'cities'));
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
        try {
            // Ensure the user is logged in
            if (!auth()->check()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User must be logged in to submit details.'
                ], 401);
            }

            // Log the incoming request data
            \Log::info('Incoming request data:', $request->all());

            // Validate the request data
            $validatedData = $request->validate([
                'marital_status' => 'required|string',
                'dob' => 'required|date',
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
                'about' => 'required|string',
            ]);

            // Convert marital_status to lowercase (to match ENUM values in DB)
            $validatedData['marital_status'] = strtolower($validatedData['marital_status']);

            // Assign the logged-in user's ID
            $validatedData['user_id'] = auth()->id();

            // Log validated data
            \Log::info('Validated data with user_id:', $validatedData);

            // Store Data in MatrimonyKyc table
            $matrimonyKyc = MatrimonyKyc::create($validatedData);

            return response()->json([
                'status' => 'success',
                'message' => 'User details saved successfully!',
                'user_id' => $matrimonyKyc->id
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('User Details Store Error: ' . $e->getMessage());
            \Log::error('Stack Trace: ' . $e->getTraceAsString());

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred. Please try again.'
            ], 500);
        }
    }

    public function preference()
    {
        $motherTongues = MotherTongue::all();
        $castes = Caste::all();

        return view('matrimony.preference', compact('motherTongues', 'castes'));
    }

    public function storePreference(Request $request)
    {
        \Log::info('Request data:', $request->all());

        // Validate the request data
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
            'images' => 'required|string',
        ]);

        // Get the authenticated user
        $user = auth()->user();

        // Assign the user_id
        $validatedData['user_id'] = $user->id;

        // Store data in the MatrimonyPreference table
        MatrimonyPreference::updateOrCreate(
            ['user_id' => $user->id], // Ensure only one record per user
            $validatedData
        );

        // Check if both forms are completed
        if ($user->kyc && $user->matrimonyPreference) {
            $user->update(['profile_completed' => 1]); // Update profile completion status
        }

        // Log the response for debugging
        \Log::info('Preferences saved successfully for user: ' . $user->id);

        return response()->json([
            'success' => true,
            'message' => 'Preferences saved successfully!',
            'redirect_url' => url('/matrimony'),
        ]);
    }

    public function profile()
    {
        return view('matrimony.main-profile');
    }

    // public function profilelisting()
    // {
    //     $castes = Caste::all(); 
    //     $motherTongues = MotherTongue::all(); 
    //     $countries = Country::all(); 
    //     $states = State::all(); 
    //     $cities = City::all();

    //     return view('matrimony.profile-listing', compact('castes', 'motherTongues', 'countries', 'states', 'cities'));
    // }

    public function profilelisting(Request $request)
    {
        $castes = Caste::all();
        $motherTongues = MotherTongue::all();
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();

        $profile = null;

        if ($request->has('profile_id')) {
            $profile = ProfileListing::find($request->profile_id);
        }

        return view('matrimony.profile-listing', compact('castes', 'motherTongues', 'countries', 'states', 'cities', 'profile'));
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
        \Log::info('Profile listing request data: ' . json_encode($request->all()));

        // Handle single profile image (file upload)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profile_images', 'public');
            \Log::info('Uploaded profile image path: ' . $imagePath);
        }

        // Handle gallery images (IDs from media library)
        $galleryImageIds = null;
        if ($request->filled('images')) {
            $images = $request->input('images');

            if (is_array($images)) {
                \Log::info('Gallery images received as array: ' . json_encode($images));
                $galleryImageIds = implode('|', array_filter($images, 'is_numeric'));
            } elseif (is_string($images)) {
                \Log::info('Gallery images received as string: ' . $images);
                $imageIds = array_filter(explode('|', $images), 'is_numeric');
                $galleryImageIds = !empty($imageIds) ? implode('|', $imageIds) : null;
            }

            \Log::info('Processed gallery images for storage: ' . ($galleryImageIds ?? 'None'));
        }

        // Store profile listing - using 'image' column for both single image and gallery IDs
        $profileListing = ProfileListing::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'age' => $request->age,
            'occupation' => $request->occupation,
            'annual_income' => $request->annual_income,
            'caste' => $request->caste,
            'mother_tongue' => $request->motherTongue,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'image' => $galleryImageIds, // Storing the pipe-separated IDs in 'image' column
            'description' => $request->description,
            'paid' => 0,
            'payment_method' => null,
            // 'images' column removed since we're using 'image'
        ]);

        \Log::info('Profile listing created with ID: ' . $profileListing->id);
        session()->put('profile_listing_id', $profileListing->id);

        // Handle payment gateway if selected
        if ($request->filled('selected_payment_gateway')) {
            $payment_gateway = $request->selected_payment_gateway;
            \Log::info('Payment gateway selected: ' . $payment_gateway);

            $credential_function = 'get_' . $payment_gateway . '_credential';
            \Log::info('Credential function: ' . $credential_function);

            if (!method_exists((new PaymentGatewayCredential()), $credential_function)) {
                \Log::info('Using custom payment logic for user: ' . Auth::id());

                $custom_data = [
                    'request' => $request->all(),
                    'total' => get_static_option('matrimony_price'),
                    'payment_type' => "deposit",
                    'payment_for' => "membership",
                    'success_url' => route('user.membership.all')
                ];

                $charge_customer_class_namespace = getChargeCustomerMethodNameByPaymentGatewayNameSpace($payment_gateway);
                $charge_customer_method_name = getChargeCustomerMethodNameByPaymentGatewayName($payment_gateway);

                $custom_charge_customer_class_object = new $charge_customer_class_namespace;
                if (class_exists($charge_customer_class_namespace) && method_exists($custom_charge_customer_class_object, $charge_customer_method_name)) {
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
        $profiles = ProfileListing::select('id', 'name', 'age', 'is_verified', 'rejection_reason')->get();
        return view('matrimony.profile-lists', compact('profiles'));
    }

}
