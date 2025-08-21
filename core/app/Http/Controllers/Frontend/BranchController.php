<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{
    /**
     * Handle branch login (GET and POST requests)
     */
    public function branchlogin(Request $request)
    {
        // Handle GET request - show login form
        if ($request->isMethod('get')) {
            return view('frontend.branches.branchlogin');
        }

        // Handle POST request - process login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Attempt to authenticate as a branch
        if (Auth::guard('branch')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Redirect to branch dashboard or home page
            return redirect()->intended(route('branchdashboard'));
        }

        // If authentication fails
        throw ValidationException::withMessages([
            'email' => __('These credentials do not match our records.'),
        ]);
    }

    /**
     * Branch dashboard (protected route)
     */
    public function branchDashboard()
    {
        $branch = auth('branch')->user();

        return view('frontend.branches.dashboard.dashboard', compact('branch'));
    }

    public function productUpload(Request $request)
    {
       return view('frontend.branches.products.index');
    }

    /**
     * Branch logout
     */
    public function branchlogout(Request $request)
    {
        Auth::guard('branch')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('branchlogin');
    }
}