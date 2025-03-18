<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MatrimonyKyc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MatrimonyController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('matrimony.index', compact('user'));
    }

    public function register()
    {
        return view('matrimony.register');
    }

    public function price()
    {
        $memberships = Membership::where('category', 1)->get();

    public function showLoginForm()
    {
        return view('matrimony.login'); // Ensure you have a `login.blade.php` file
    }


    public function profiledetails()
    {
        $user = Auth::user();
        return view('matrimony.profile-details');
    }

    public function otp() {
        return view ('matrimony.otp');
    }

    public function userdetails()
    {
        return view('matrimony.user-details');
    }

    public function storeUserDetails(Request $request)
    {
        try {
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
                'name' => 'nullable|string',
                'email' => 'nullable|email',
                'password' => 'nullable|string',
                'mobile' => 'nullable|string',
            ]);

            // Convert marital_status to lowercase (to match ENUM values in DB)
            $validatedData['marital_status'] = strtolower($validatedData['marital_status']);

            // Hash the password before saving
            if (!empty($validatedData['password'])) {
                $validatedData['password'] = bcrypt($validatedData['password']);
            }

            // Log validated data
            \Log::info('Validated data:', $validatedData);

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

}
