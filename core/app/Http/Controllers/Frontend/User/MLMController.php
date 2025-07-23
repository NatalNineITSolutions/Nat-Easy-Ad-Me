<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\UsersBv;
use App\Jobs\SendRegisterUserEmailJob;
use Modules\Membership\app\Models\Membership;
use App\Mail\BasicMail;
use Modules\Wallet\app\Models\Wallet;

class MLMController extends Controller
{
    /**
     * Show the form to add a new member in the binary MLM structure.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    // public function addNewMember(Request $request)
    // {
    //     $sponsorId = $request->query('sponsor');
    //     $position = $request->query('position');

    //     // Validate the parameters.
    //     if (!$sponsorId || !in_array($position, ['left', 'right'])) {
    //         return redirect()->back()->withErrors(['error' => __('Invalid sponsor or position provided.')]);
    //     }

    //     $sponsor = User::find($sponsorId);
    //     if (!$sponsor) {
    //         return redirect()->back()->withErrors(['error' => __('Sponsor user not found.')]);
    //     }

    //     $existingChild = $sponsor->children()->where('position', $position)->first();
    //     if ($existingChild) {
    //         return redirect()->back()->withErrors(['error' => __('The selected position is already occupied.')]);
    //     }

    //     return view('frontend.user.genology.add-member', compact('sponsor', 'position'));
    // }

    // public function addNewMember(Request $request)
    // {
    //     $sponsorId = $request->query('sponsor');
    //     $position = $request->query('position');

    //     // Validate the parameters
    //     if (!$sponsorId || !in_array($position, ['left', 'right'])) {
    //         return redirect()->back()->withErrors(['error' => __('Invalid sponsor or position provided.')]);
    //     }

    //     $sponsor = User::find($sponsorId);
    //     if (!$sponsor) {
    //         return redirect()->back()->withErrors(['error' => __('Sponsor user not found.')]);
    //     }

    //     // Get the root user (the top-most user in the MLM system)
    //     $rootUser = auth()->user();

    //     return view('frontend.user.genology.add-member', [
    //         'parentUser' => $sponsor,  // Immediate parent (the user under whom we're adding)
    //         'rootUser' => $rootUser,     // The root user of the MLM tree
    //         'position' => $position
    //     ]);
    // }

    public function addNewMember(Request $request)
    {
        $sponsorId = $request->query('sponsor');
        $position = $request->query('position');

        // Validate the parameters
        if (!$sponsorId || !in_array($position, ['left', 'right'])) {
            return redirect()->back()->withErrors(['error' => __('Invalid sponsor or position provided.')]);
        }

        // Get sponsor (parent) user
        $sponsor = User::find($sponsorId);
        if (!$sponsor) {
            return redirect()->back()->withErrors(['error' => __('Sponsor user not found.')]);
        }

        // Get root user only if authenticated
        $rootUser = auth()->check() ? auth()->user() : null;

        return view('frontend.user.genology.add-member', [
            'parentUser' => $sponsor,      // Sponsor under whom the new member is being added
            'rootUser' => $rootUser,       // Current user (if logged in)
            'position' => $position
        ]);
    }

    public function registerNewMember(Request $request)
    {
        if ($request->isMethod('POST')) {
            Log::info('MLM new member registration request received.', ['request_data' => $request->all()]);

            $validationRules = [
                'first_name' => 'required|max:191',
                'last_name' => 'required|max:191',
                'email' => 'required|email|unique:users|max:191',
                'username' => 'required|unique:users|max:191',
                'phone' => 'required|max:191',
                'password' => 'required|min:6|max:191',
                'confirm_password' => 'required|same:password',
                'parent_id' => 'required|exists:users,id',  // Immediate parent (the node clicked)
                'root_id' => 'required|exists:users,id',    // Root user of the tree
                'position' => 'required|in:left,right',
                'gender' => 'required|in:male,female',
                'dob' => 'required|date|before:today',
            ];

            if (get_static_option('site_google_captcha_enable') == 'on') {
                $validationRules['g-recaptcha-response'] = 'nullable';
            }

            $request->validate($validationRules);

            try {
                $email_verify_token = sprintf("%d", random_int(123456, 999999));

                $phone_number = Str::replace(['-', '(', ')', ' '], '', $request->phone);
                $country_code = '+' . ltrim($request->country_code, '+');
                $full_phone_number = $country_code . ' - ' . $phone_number;

                if (!empty($full_phone_number) && User::where('phone', $full_phone_number)->exists()) {
                    return redirect()->back()->withErrors(['phone' => __('Phone number is already taken')]);
                }

                // Generate unique partner ID
                do {
                    $dateCode = now()->format('Yn');
                    $randomDigits = rand(1000, 99999);
                    $partnerId = 'GL' . $dateCode . $randomDigits;
                } while (User::where('partner_id', $partnerId)->exists());

                $partnerName = 'EASYADME-' . strtoupper($request->first_name);

                $user = new User([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'username' => $request->username,
                    'phone' => $full_phone_number,
                    'password' => Hash::make($request->password),
                    'terms_conditions' => 1,
                    'email_verify_token' => $email_verify_token,
                    'partner_id' => $partnerId,
                    'partner_name' => $partnerName,
                    'sponsor_id' => $request->root_id,      // The root user who owns this tree
                    'parent_id' => $request->parent_id,     // The immediate parent (node clicked)
                    'gender' => $request->gender,
                    'dob' => $request->dob,
                    'position' => $request->position,
                ]);

                $user->save();

                Log::info('User created ID: ' . $user->id, $user->toArray());

                $default_membership = Membership::find(1);
                $membership_id = $default_membership ? $default_membership->id : 1;
                $bv_points = $default_membership ? $default_membership->bv_points : 0;

                UsersBv::create([
                    'user_id' => $user->id,
                    'membership_id' => $membership_id,
                    'bv_points' => $bv_points,
                    'upgrade_time' => now(),
                ]);

                Log::info('BV points initialized.', ['user_id' => $user->id, 'bv' => $bv_points]);

                if (moduleExists("Wallet")) {
                    Wallet::create([
                        'user_id' => $user->id,
                        'balance' => 0,
                        'remaining_balance' => 0,
                        'withdraw_amount' => 0,
                        'status' => 1,
                    ]);
                }

                dispatch(new SendRegisterUserEmailJob($user, $request->password));

                return redirect()->route('user.genology')->with('success', __('New member registered successfully!'));
            } catch (\Exception $e) {
                Log::error('Error during MLM member registration.', ['error' => $e->getMessage()]);
                return redirect()->back()->withErrors(['error' => __('An error occurred during registration. Please try again.')]);
            }
        }

        return view('frontend.user.genology.add-member');
    }
}
