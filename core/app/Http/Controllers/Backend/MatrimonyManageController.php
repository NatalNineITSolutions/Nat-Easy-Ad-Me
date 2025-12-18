<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\Mail;
use App\Mail\MatrimonyProfileApproved;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfileListing;
use App\Models\Caste;
use App\Models\MotherTongue;
use App\Models\Dosham;
use App\Models\Gothram;
use App\Models\ZodiacSign;
use App\Models\AgeRange;
use App\Models\IncomeRange;
use App\Models\Star;
use App\Models\Religion;
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

        // Prevent duplicate verification
        if ($profile->is_verified == 1) {
            return response()->json(['success' => true]);
        }

        $profile->is_verified = 1;
        $profile->save();

        Log::info("Profile ID {$profile->id} verified successfully.");

        if (!empty($profile->email)) {
            try {
                Mail::to($profile->email)
                    ->send(new MatrimonyProfileApproved($profile));
            } catch (\Exception $e) {
                Log::error('Profile approval mail failed: ' . $e->getMessage());
            }
        }

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

    // Zodiac Sign Methods
    public function zodiacsign()
    {
        $zodiacSigns = ZodiacSign::paginate(10);
        return view('backend.pages.matrimony.zodiac-sign', compact('zodiacSigns'));
    }

    public function addZodiacSign()
    {
        return view('backend.pages.matrimony.add-zodiac-sign');
    }

    public function storeZodiacSign(Request $request)
    {
        $request->validate([
            'zodiac_sign' => 'required|string|max:255|unique:zodiac_signs,zodiac_sign'
        ], [
            'zodiac_sign.unique' => 'This Zodiac Sign already exists!'
        ]);

        ZodiacSign::create(['zodiac_sign' => $request->zodiac_sign]);

        return redirect()->route('admin.matrimony.zodiac-sign')->with('success', 'Zodiac Sign added successfully!');
    }

    public function editZodiacSign($id = null)
    {
        $zodiacSign = $id ? ZodiacSign::find($id) : null;
        return view('backend.pages.matrimony.add-zodiac-sign', compact('zodiacSign'));
    }

    public function updateZodiacSign(Request $request, $id)
    {
        $request->validate([
            'zodiac_sign' => 'required|string|max:255|unique:zodiac_signs,zodiac_sign,' . $id
        ], [
            'zodiac_sign.unique' => 'This Zodiac Sign already exists!'
        ]);

        $zodiacSign = ZodiacSign::find($id);

        if (!$zodiacSign) {
            return redirect()->route('admin.matrimony.zodiac-sign')->with('error', 'Zodiac Sign not found.');
        }

        $zodiacSign->update(['zodiac_sign' => $request->zodiac_sign]);

        return redirect()->route('admin.matrimony.zodiac-sign')->with('success', 'Zodiac Sign updated successfully!');
    }

    public function deleteZodiacSign($id)
    {
        $zodiacSign = ZodiacSign::find($id);

        if (!$zodiacSign) {
            return response()->json(['success' => false, 'message' => 'Zodiac Sign not found.'], 404);
        }

        $zodiacSign->delete();

        return response()->json(['success' => true, 'message' => 'Zodiac Sign deleted successfully!']);
    }

    // Star Methods
    public function star()
    {
        $stars = Star::paginate(10);
        return view('backend.pages.matrimony.star', compact('stars'));
    }

    public function addStar()
    {
        return view('backend.pages.matrimony.add-star');
    }

    public function storeStar(Request $request)
    {
        $request->validate([
            'star' => 'required|string|max:255|unique:stars,star'
        ], [
            'star.unique' => 'This Star already exists!'
        ]);

        Star::create(['star' => $request->star]);

        return redirect()->route('admin.matrimony.star')->with('success', 'Star added successfully!');
    }

    public function editStar($id = null)
    {
        $star = $id ? Star::find($id) : null;
        return view('backend.pages.matrimony.add-star', compact('star'));
    }

    public function updateStar(Request $request, $id)
    {
        $request->validate([
            'star' => 'required|string|max:255|unique:stars,star,' . $id
        ], [
            'star.unique' => 'This Star already exists!'
        ]);

        $star = Star::find($id);

        if (!$star) {
            return redirect()->route('admin.matrimony.star')->with('error', 'Star not found.');
        }

        $star->update(['star' => $request->star]);

        return redirect()->route('admin.matrimony.star')->with('success', 'Star updated successfully!');
    }

    public function deleteStar($id)
    {
        $star = Star::find($id);

        if (!$star) {
            return response()->json(['success' => false, 'message' => 'Star not found.'], 404);
        }

        $star->delete();

        return response()->json(['success' => true, 'message' => 'Star deleted successfully!']);
    }

    public function age()
    {
        $ages = AgeRange::paginate(10);
        return view('backend.pages.matrimony.age', compact('ages'));
    }

    public function addAge()
    {
        return view('backend.pages.matrimony.add-age');
    }

    public function editAge($id = null)
    {
        $age = $id ? AgeRange::find($id) : null;
        return view('backend.pages.matrimony.add-age', compact('age'));
    }

    public function storeAge(Request $request)
    {
        $request->validate([
            'from_age' => 'required|integer|min:1',
            'to_age' => 'required|integer|gt:from_age',
        ]);

        AgeRange::create($request->only('from_age', 'to_age'));
        return redirect()->route('admin.matrimony.age')->with('success', 'Age range added successfully!');
    }

    public function updateAge(Request $request, $id)
    {
        $request->validate([
            'from_age' => 'required|integer|min:1',
            'to_age' => 'required|integer|gt:from_age',
        ]);

        $age = AgeRange::find($id);
        if (!$age) {
            return redirect()->route('admin.matrimony.age')->with('error', 'Age range not found.');
        }

        $age->update($request->only('from_age', 'to_age'));
        return redirect()->route('admin.matrimony.age')->with('success', 'Age range updated successfully!');
    }

    public function deleteAge($id)
    {
        $age = AgeRange::find($id);
        if (!$age) {
            return response()->json(['success' => false, 'message' => 'Age range not found.'], 404);
        }

        $age->delete();
        return response()->json(['success' => true, 'message' => 'Age range deleted successfully!']);
    }

    public function income()
    {
        $incomes = IncomeRange::paginate(10);
        return view('backend.pages.matrimony.income', compact('incomes'));
    }

    public function addIncome()
    {
        return view('backend.pages.matrimony.add-income');
    }

    public function editIncome($id = null)
    {
        $income = $id ? IncomeRange::find($id) : null;
        return view('backend.pages.matrimony.add-income', compact('income'));
    }

    public function storeIncome(Request $request)
    {
        $request->validate([
            'from_income' => 'required|integer|min:0',
            'to_income' => 'required|integer|gt:from_income',
        ]);

        IncomeRange::create($request->only('from_income', 'to_income'));
        return redirect()->route('admin.matrimony.income')->with('success', 'Income range added successfully!');
    }

    public function updateIncome(Request $request, $id)
    {
        $request->validate([
            'from_income' => 'required|integer|min:0',
            'to_income' => 'required|integer|gt:from_income',
        ]);

        $income = IncomeRange::find($id);
        if (!$income) {
            return redirect()->route('admin.matrimony.income')->with('error', 'Income range not found.');
        }

        $income->update($request->only('from_income', 'to_income'));
        return redirect()->route('admin.matrimony.income')->with('success', 'Income range updated successfully!');
    }

    public function deleteIncome($id)
    {
        $income = IncomeRange::find($id);
        if (!$income) {
            return response()->json(['success' => false, 'message' => 'Income range not found.'], 404);
        }

        $income->delete();
        return response()->json(['success' => true, 'message' => 'Income range deleted successfully!']);
    }

    public function religion()
    {
        $religions = Religion::latest()->paginate(10);
        return view('backend.pages.matrimony.religion', compact('religions'));
    }

    public function addReligion()
    {
        return view('backend.pages.matrimony.add-religion');
    }

    public function editReligion($id)
    {
        $religion = Religion::findOrFail($id);
        return view('backend.pages.matrimony.add-religion', compact('religion'));
    }

    public function storeReligion(Request $request)
    {
        $request->validate([
            'religion' => 'required|string|max:255|unique:religions,religion'
        ]);

        Religion::create($request->only('religion'));

        return redirect()->route('admin.matrimony.religion')
            ->with('success', 'Religion added successfully');
    }

    public function updateReligion(Request $request, $id)
    {
        $request->validate([
            'religion' => 'required|string|max:255|unique:religions,religion,' . $id
        ]);

        $religion = Religion::findOrFail($id);
        $religion->update($request->only('religion'));

        return redirect()->route('admin.matrimony.religion')
            ->with('success', 'Religion updated successfully');
    }

    public function deleteReligion($id)
    {
        try {
            $religion = Religion::findOrFail($id);
            $religion->delete();

            return response()->json([
                'success' => true,
                'message' => 'Religion deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete religion: ' . $e->getMessage()
            ], 500);
        }
    }
}
