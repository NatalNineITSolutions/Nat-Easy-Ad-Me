<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfileListing;

class MatrimonyManageController extends Controller
{
    public function profile_listing()
    {
        return view('backend.pages.matrimony.profile-listing');
    }

    public function storeProfileSettings(Request $request)
    {
        // Validate the input fields
        $request->validate([
            'price' => 'required|numeric|min:0',
            'bv' => 'required|numeric|min:0',
        ]);

        // Store values in the `static_options` table
        set_static_option('matrimony_price', $request->price);
        set_static_option('matrimony_bv_points', $request->bv);

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    public function profiles()
    {
        // Fetch profiles from the database
        $profiles = ProfileListing::select('id', 'name', 'occupation', 'annual_income', 'is_verified')->get();

        // Return the view with profiles data
        return view('backend.pages.matrimony.profiles', compact('profiles'));
    }

    public function verifyProfile(Request $request, $id)
{
    // Find the profile by ID
    $profile = ProfileListing::findOrFail($id);

    // Update the is_verified status
    $status = $request->status; // 1 = Verified, 2 = Rejected
    $profile->is_verified = $status;
    $profile->save();

    // Return a JSON response
    return response()->json([
        'success' => true,
        'status' => $status
    ]);
}

    
}
