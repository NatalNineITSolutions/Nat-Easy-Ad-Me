<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MatrimonyPreference;
use Illuminate\Http\Request;
use App\Models\MatrimonyKyc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        return view('matrimony.price'); // Ensure this view exists
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

    public function preference()  {
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
            'redirect_url' => url('/'), // Redirect to home page
        ]);
    }

}