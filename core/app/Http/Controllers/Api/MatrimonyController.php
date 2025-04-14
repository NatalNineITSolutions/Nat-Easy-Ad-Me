<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfileListing;
use Illuminate\Support\Facades\Validator;

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
}