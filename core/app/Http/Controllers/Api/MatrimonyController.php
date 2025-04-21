<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfileListing;
use Illuminate\Support\Facades\Validator;
use App\Models\ProfileRequest;
use App\Models\MatrimonyKyc;
use App\Models\MatrimonyPreference;
use Illuminate\Support\Facades\Log;

class MatrimonyController extends Controller
{

    public function profileLists()
    {
        $profiles = ProfileListing::all();

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

        return response()->json([
            'success' => true,
            'data' => $profile
        ]);
    }


    public function storeProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'occupation' => 'nullable|string',
            'annual_income' => 'nullable|numeric',
            'caste' => 'nullable|string',
            'mother_tongue' => 'nullable|string',
            'country' => 'nullable|string',
            'state' => 'nullable|string',
            'city' => 'nullable|string',
            'image' => 'nullable|string',
            'description' => 'nullable|string',
            'paid' => 'nullable|boolean',
            'payment_method' => 'nullable|string',
            'is_verified' => 'nullable|boolean',
            'rejection_reason' => 'nullable|string',
        ]);


        $validated['user_id'] = $request->user()->id;


        $profile = ProfileListing::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Profile created successfully',
            'profile' => $profile
        ], 201);
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

    public function storeUserDetails(Request $request)
    {
        try {
          
            if (!auth()->check()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User must be logged in to submit details.'
                ], 401);
            }

          
            \Log::info('Incoming request data:', $request->all());

          
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

         
            $validatedData['marital_status'] = strtolower($validatedData['marital_status']);

           
            $validatedData['user_id'] = auth()->id();

            
            \Log::info('Validated data with user_id:', $validatedData);

           
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
}