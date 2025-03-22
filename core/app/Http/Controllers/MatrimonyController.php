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
        if ($user->profile_completed == 1) {
            // If profile is completed, allow access to matrimony.index
            return view('matrimony.index'); // Replace with your actual view for matrimony.index
        } else {
            // If profile is not completed, redirect to matrimony.user-details
            return redirect()->route('matrimony.user-details')->with('info', 'Please complete your profile to proceed.');
        }
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
        return view('matrimony.user-details');
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
        return view('matrimony.preference');
    }

    public function storePreference(Request $request)
    {
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

    public function profilelisting()
    {
        return view('matrimony.profile-listing');
    }

    public function storeProfileListing(Request $request)
    {
        \Log::info('Profile listing request data: ' . json_encode($request->all()));

        // Handle file upload (if provided)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profile_images', 'public');
        }

        $profileListing = ProfileListing::create([
            'user_id'       => Auth::id(),
            'name'          => $request->name,
            'age'           => $request->age,
            'occupation'    => $request->occupation,
            'annual_income' => $request->annual_income,
            'caste'         => $request->caste,
            'mother_tongue' => $request->motherTongue,
            'country'       => $request->country,
            'state'         => $request->state,
            'city'          => $request->city,
            'image'         => $imagePath,
            'description'   => $request->description,
            'paid'          => 0,       // Not paid yet
            'payment_method' => null,    // Not selected yet
        ]);

        session()->put('profile_listing_id', $profileListing->id);

        // Process payment if a payment gateway is selected
        if ($request->filled('selected_payment_gateway')) {
            $payment_gateway = $request->selected_payment_gateway;
            \Log::info('Payment gateway selected: ' . $payment_gateway);

            $credential_function = 'get_' . $payment_gateway . '_credential';
            \Log::info('Credential function: ' . $credential_function);

            // Check if the payment gateway has a custom credential function
            if (!method_exists((new PaymentGatewayCredential()), $credential_function)) {
                \Log::info('Using custom payment logic for user: ' . Auth::id());

                // Prepare custom data for payment processing
                $custom_data = [];
                $custom_data['request']         = $request->all();
                $custom_data['total']           = get_static_option('matrimony_price');
                $custom_data['payment_type']    = "deposit";
                $custom_data['payment_for']     = "membership";
                $custom_data['success_url']     = route('user.membership.all');

                // Get the namespace and method for charging the customer
                $charge_customer_class_namespace = getChargeCustomerMethodNameByPaymentGatewayNameSpace($payment_gateway);
                $charge_customer_method_name     = getChargeCustomerMethodNameByPaymentGatewayName($payment_gateway);

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
        $name  = $user->fullname;

        $ipn_route = route('user.' . strtolower($payment_gateway_name) . '.ipn.membership');

        \Log::info('IPN Route, matrimony price: ' . get_static_option('matrimony_price'));

        return [
            'amount'       => get_static_option('matrimony_price'),
            'title'        => "Profile Listing",
            'description'  => "Matrimony",
            'ipn_url'      => $ipn_route,
            'order_id'     => session('profile_listing_id'), 
            'track'        => Str::random(36),
            'success_url'  => route('user.membership.all'),
            'email'        => $email,
            'name'         => $name,
            'payment_type' => 'deposit',
        ];
    }


    public function profilelists()
    {
        $profiles = ProfileListing::select('id', 'name', 'age', 'is_verified')->get();
        return view('matrimony.profile-lists', compact('profiles'));
    }
}
