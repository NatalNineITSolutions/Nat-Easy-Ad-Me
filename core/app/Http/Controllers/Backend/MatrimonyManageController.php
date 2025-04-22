<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfileListing;
use App\Models\Caste;
use App\Models\MotherTongue;
use App\Models\Dosham;
use App\Models\Gothram;
use Illuminate\Support\Facades\Log;

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
            'matrimony_bv_value' => 'required|numeric|min:0',
        ]);

        // Store values in the `static_options` table
        set_static_option('matrimony_price', $request->price);
        set_static_option('matrimony_bv_points', $request->bv);
        set_static_option('matrimony_bv_value', $request->matrimony_bv_value);

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    public function profiles()
    {
        // Fetch profiles where 'paid' is 1
        $profiles = ProfileListing::where('paid', 1)->get();

        // Log the profiles data
        Log::info('Fetched Profiles:', $profiles->toArray());

        // Return the view with the profiles data
        return view('backend.pages.matrimony.profiles', compact('profiles'));
    }

    public function show($id)
    {
        // Fetch the profile by its ID
        $profile = ProfileListing::find($id);

        if (!$profile) {
            // Handle the case where the profile is not found
            return redirect()->route('admin.matrimony.profiles')->with('error', 'Profile not found.');
        }

        // Return the view with the profile data
        return view('backend.pages.matrimony.profile-show', compact('profile'));
    }

    public function verifyProfile(Request $request)
    {
        $profile = ProfileListing::find($request->id);

        if ($profile) {
            $profile->is_verified = 1;
            $profile->save();

            Log::info("Profile ID {$profile->id} verified successfully.");

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function rejectProfile(Request $request)
    {
        try {
            Log::info("Reject Profile Request Received", $request->all());

            $profile = ProfileListing::find($request->id);

            if (!$profile) {
                Log::error("Profile not found: ID " . $request->id);
                return response()->json(['success' => false, 'message' => 'Profile not found'], 404);
            }

            $profile->is_verified = 2;
            $profile->rejection_reason = $request->reason; // Ensure this column exists in DB
            $profile->save();

            Log::info("Profile ID {$profile->id} rejected successfully.");
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error("Error rejecting profile: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function castes()
    {
        $castes = Caste::paginate(10); 
        return view('backend.pages.matrimony.caste', compact('castes'));
    }

    public function addcaste()
    {
        return view('backend.pages.matrimony.add-caste');
    }

    public function storeCaste(Request $request)
    {
        $request->validate([
            'caste' => 'required|string|max:255|unique:castes,caste'
        ], [
            'caste.unique' => 'This caste already exists!'
        ]);

        Caste::create(['caste' => $request->caste]);

        return redirect()->route('admin.matrimony.castes')->with('success', 'Caste added successfully!');
    }

    public function updateCaste(Request $request, $id)
    {
        $request->validate(['caste' => 'required|string|max:255']);

        $caste = Caste::find($id);
        if (!$caste) {
            return redirect()->route('admin.matrimony.castes')->with('error', 'Caste not found.');
        }

        $caste->update(['caste' => $request->caste]);

        return redirect()->route('admin.matrimony.castes')->with('success', 'Caste updated successfully!');
    }

    public function deleteCaste($id)
    {
        $caste = Caste::find($id);
        
        if (!$caste) {
            return response()->json(['success' => false, 'message' => 'Caste not found.'], 404);
        }

        $caste->delete();

        return response()->json(['success' => true, 'message' => 'Caste deleted successfully!']);
    }

    public function editcaste($id = null)
    {
        $caste = $id ? Caste::find($id) : null;
        return view('backend.pages.matrimony.add-caste', compact('caste'));
    }

    public function motherTongues()
    {
        $motherTongues = MotherTongue::paginate(10);
        return view('backend.pages.matrimony.mother-tongue', compact('motherTongues'));
    }

    public function addMotherTongue()
    {
        return view('backend.pages.matrimony.add-mother-tongue');
    }

    public function storeMotherTongue(Request $request)
    {
        $request->validate([
            'mother_tongue' => 'required|string|max:255|unique:mother_tongues,mother_tongue'
        ], [
            'mother_tongue.unique' => 'This mother tongue already exists!'
        ]);

        MotherTongue::create([
            'mother_tongue' => $request->mother_tongue
        ]);

        return redirect()->route('admin.matrimony.add-mother-tongue')->with('success', 'Mother Tongue added successfully!');
    }

    public function deleteMotherTongue($id)
    {
        $motherTongue = MotherTongue::find($id);

        if ($motherTongue) {
            $motherTongue->delete();
            return response()->json(['success' => true, 'message' => 'Mother Tongue deleted successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Mother Tongue not found'], 404);
        }
    }

    public function updateMotherTongue(Request $request, $id)
    {
        $request->validate([
            'mother_tongue' => 'required|string|max:255',
        ]);

        $motherTongue = MotherTongue::find($id);

        if (!$motherTongue) {
            return redirect()->route('admin.matrimony.mother-tongues')->with('error', 'Mother Tongue not found');
        }

        $motherTongue->update([
            'mother_tongue' => $request->mother_tongue
        ]);

        return redirect()->route('admin.matrimony.mother-tongues')->with('success', 'Mother Tongue updated successfully');
    }

    public function editMotherTongue($id = null)
    {
        $motherTongue = $id ? MotherTongue::find($id) : null;
        return view('backend.pages.matrimony.add-mother-tongue', compact('motherTongue'));
    }
    
    public function doshams()
    {
        $doshams = Dosham::paginate(10); // Show 10 records per page
        return view('backend.pages.matrimony.dosham', compact('doshams'));
    }

    public function addDosham()
    {
        return view('backend.pages.matrimony.add-dosham');
    }

    public function storeDosham(Request $request)
    {
        $request->validate([
            'dosham' => 'required|string|max:255|unique:doshams,dosham'
        ], [
            'dosham.unique' => 'This Dosham already exists!'
        ]);

        Dosham::create([
            'dosham' => $request->dosham
        ]);

        return redirect()->route('admin.matrimony.add-dosham')->with('success', 'Dosham added successfully!');
    }

    public function deleteDosham($id)
    {
        $dosham = Dosham::find($id);

        if (!$dosham) {
            return response()->json(['success' => false, 'message' => 'Dosham not found!']);
        }

        $dosham->delete();

        return response()->json(['success' => true, 'message' => 'Dosham deleted successfully!']);
    }

    public function editDosham($id = null)
    {
        $dosham = $id ? Dosham::find($id) : null;
        return view('backend.pages.matrimony.add-dosham', compact('dosham'));
    }

    public function updateDosham(Request $request, $id)
    {
        $request->validate([
            'dosham' => 'required|string|max:255|unique:doshams,dosham,' . $id,
        ], [
            'dosham.unique' => 'This dosham already exists!',
        ]);

        $dosham = Dosham::find($id);

        if (!$dosham) {
            return redirect()->route('admin.matrimony.doshams')->with('error', 'Dosham not found');
        }

        $dosham->update([
            'dosham' => $request->dosham
        ]);

        return redirect()->route('admin.matrimony.doshams')->with('success', 'Dosham updated successfully!');
    }

    public function gothrams()
    {
        $gothrams = Gothram::paginate(10); // Paginate if records exceed 10
        return view('backend.pages.matrimony.gothram', compact('gothrams'));
    }

    public function addGothram()
    {
        return view('backend.pages.matrimony.add-gothram');
    }

    public function storeGothram(Request $request)
    {
        $request->validate([
            'gothram' => 'required|string|max:255|unique:gothrams,gothram'
        ], [
            'gothram.unique' => 'This Gothram already exists!'
        ]);

        Gothram::create(['gothram' => $request->gothram]);

        return redirect()->route('admin.matrimony.gothrams')->with('success', 'Gothram added successfully!');
    }

    public function deleteGothram($id)
    {
        $gothram = Gothram::find($id);

        if (!$gothram) {
            return response()->json(['error' => 'Gothram not found!'], 404);
        }

        $gothram->delete();

        return response()->json(['success' => 'Gothram deleted successfully!']);
    }

    public function editGothram($id = null)
    {
        $gothram = $id ? Gothram::findOrFail($id) : null;
        return view('backend.pages.matrimony.add-gothram', compact('gothram'));
    }

    public function updateGothram(Request $request, $id)
    {
        $request->validate([
            'gothram' => 'required|string|max:255|unique:gothrams,gothram,' . $id
        ], [
            'gothram.unique' => 'This Gothram already exists!'
        ]);

        $gothram = Gothram::findOrFail($id);
        $gothram->update(['gothram' => $request->gothram]);

        return redirect()->route('admin.matrimony.gothrams')->with('success', 'Gothram updated successfully!');
    }

}
