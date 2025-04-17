<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfileRequest;

class MatrimonyRequestApiController extends Controller
{
    
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

       
        if (ProfileRequest::where('sender_id', auth()->id())
                          ->where('profile_id', $profileId)
                          ->exists()) {
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
}