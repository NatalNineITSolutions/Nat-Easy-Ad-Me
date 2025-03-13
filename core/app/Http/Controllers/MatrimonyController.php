<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MatrimonyUser;

class MatrimonyController extends Controller
{
    public function index()
    {
        return view('matrimony.index'); // Ensure this view exists
    }

    public function register()
    {
        return view('matrimony.register'); // Ensure this view file exists
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

}
