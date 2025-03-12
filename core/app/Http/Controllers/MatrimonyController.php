<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MatrimonyUser;

class MatrimonyController extends Controller
{
    public function index()
    {
        return view('matrimony.index'); 
    }

    public function register()
    {
        return view('matrimony.register'); 
    }

    public function store(Request $request)
    {
        try {
            // Validate the form data
            $request->validate([
                'name'      => 'required|string|max:255',
                'email'     => 'required|email|unique:matrimony_users,email',
                'password'  => 'required|min:6',
                'gender'    => 'required|in:Male,Female',
                'dob'       => 'required|date',
                'country'   => 'required|string',
                'location'  => 'required|string',
                'mobile'    => 'required|numeric|digits_between:7,15|unique:matrimony_users,mobile',
            ]);

            // Store in the database
            MatrimonyUser::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => bcrypt($request->password), // Hashing the password
                'gender'    => $request->gender,
                'dob'       => $request->dob,
                'country'   => $request->country,
                'location'  => $request->location,
                'mobile'    => $request->mobile,
            ]);

            // Store a session flag to prevent back navigation
            session()->put('registration_success', true);

            return redirect()->route('matrimony.index')->with('success', 'Registration successful!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Email is already taken.'); // Add this line to pass the error message
        }
    }

    public function price()
    {
        return view('matrimony.index'); // Ensure this view exists
    }

}
