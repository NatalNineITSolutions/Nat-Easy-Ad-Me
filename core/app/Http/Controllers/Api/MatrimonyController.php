<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfileListing;

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
}
