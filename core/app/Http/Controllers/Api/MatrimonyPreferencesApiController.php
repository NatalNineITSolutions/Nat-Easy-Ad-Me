<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MatrimonyPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MatrimonyPreferencesApiController extends Controller
{
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
