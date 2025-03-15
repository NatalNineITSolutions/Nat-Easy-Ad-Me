<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MatrimonyUser;
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

    public function store(Request $request)
    {
        try {
            // Validate the form data
            $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:matrimony_users,email',
                'password' => 'required|min:6',
                'mobile'   => 'required|numeric|digits_between:7,15|unique:matrimony_users,mobile',
            ]);

            // Store in the database
            MatrimonyUser::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
                'mobile'   => $request->mobile,
            ]);

            // Store a session success message
            return redirect()->route('matrimony.index')->with('success', 'Form submitted successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        }
    }

    public function price()
    {
        return view('matrimony.price'); // Ensure this view exists
    }

    public function showLoginForm()
    {
        return view('matrimony.login'); // Ensure you have a `login.blade.php` file
    }

    public function login(Request $request)
    {
        // Validate the input
        $request->validate([
            'login' => 'required|string', // 'login' can be either email or username
            'password' => 'required|string',
        ]);

        // Determine if the input is an email or username
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        // Attempt to find the user
        $user = MatrimonyUser::where($loginType, $request->login)->first();

        // Check if the user exists and the password is correct
        if ($user && Hash::check($request->password, $user->password)) {
            // Store user session
            Auth::login($user);
            return redirect()->route('matrimony.index')->with('success', 'Login successful!');
        }

        // If authentication fails, return with an error message
        return back()->withErrors(['login' => 'Invalid credentials.'])->withInput();
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

}
