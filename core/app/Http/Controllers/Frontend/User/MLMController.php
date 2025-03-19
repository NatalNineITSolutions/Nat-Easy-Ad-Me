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
    public function addNewMember(Request $request)
    {
        $sponsorId = $request->query('sponsor');
        $position  = $request->query('position');

        // Validate the parameters.
        if (!$sponsorId || !in_array($position, ['left', 'right'])) {
            return redirect()->back()->withErrors(['error' => __('Invalid sponsor or position provided.')]);
        }

        $sponsor = User::find($sponsorId);
        if (!$sponsor) {
            return redirect()->back()->withErrors(['error' => __('Sponsor user not found.')]);
        }

        $existingChild = $sponsor->children()->where('position', $position)->first();
        if ($existingChild) {
            return redirect()->back()->withErrors(['error' => __('The selected position is already occupied.')]);
        }

        // Return a view with a form to add a new member.
        // Pass along the sponsor and position so the form can automatically set these values.
        return view('frontend.user.genology.add-member', compact('sponsor', 'position'));
    }


    public function registerNewMember(Request $request)
    {
        if ($request->isMethod('POST')) {
            Log::info('MLM new member registration request received.', ['request_data' => $request->all()]);

            $validationRules = [
                'first_name'       => 'required|max:191',
                'last_name'        => 'required|max:191',
                'email'            => 'required|email|unique:users|max:191',
                'username'         => 'required|unique:users|max:191',
                'phone'            => 'required|max:191',
                'password'         => 'required|min:6|max:191',
                'confirm_password' => 'required|same:password',
                // Hidden fields from the form:
                'sponsor_id'       => 'required|exists:users,id',
                'position'         => 'required|in:left,right',
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
                    Log::warning('Phone number already taken.', ['phone' => $full_phone_number]);
                    return redirect()->back()->withErrors(['phone' => __('Phone number is already taken')]);
                }

                do {
                    $partnerId = 'EAM' . Str::upper(Str::random(6));
                } while (User::where('partner_id', $partnerId)->exists());

                $partnerName = 'EASYADME-' . strtoupper($request->first_name);

                // The sponsor_id and position are passed as hidden fields from the form.
                $parent_id = $request->input('sponsor_id');
                $position  = $request->input('position');

                Log::info('New member referred by existing user.', ['referrer_id' => $parent_id, 'position' => $position]);

                $default_membership = Membership::find(1);
                $membership_id = $default_membership ? $default_membership->id : 1;
                $bv_points = $default_membership ? $default_membership->bv_points : 0;

                // Create the new user record
                $user = new User([
                    'first_name'       => $request->first_name,
                    'last_name'        => $request->last_name,
                    'email'            => $request->email,
                    'username'         => $request->username,
                    'phone'            => $full_phone_number,
                    'password'         => Hash::make($request->password),
                    'terms_conditions' => 1,
                    'email_verify_token' => $email_verify_token,
                    'partner_id'       => $partnerId,
                    'partner_name'     => $partnerName,
                    'parent_id'        => $parent_id,
                    'position'         => $position,
                ]);

                // Save the user within the nested set structure
                if ($parent_id) {
                    $parent = User::find($parent_id);
                    // appendNode() is used if you're implementing a nested set structure
                    $parent->appendNode($user);
                } else {
                    $user->saveAsRoot(); // If no sponsor, save as root
                }

                Log::info('New MLM member created successfully.', ['user_id' => $user->id]);

                // Assign BV points
                UsersBv::create([
                    'user_id'       => $user->id,
                    'membership_id' => $membership_id,
                    'bv_points'     => $bv_points,
                    'upgrade_time'  => now(),
                ]);

                Log::info('User BV points recorded.', [
                    'user_id'       => $user->id,
                    'membership_id' => $membership_id,
                    'bv_points'     => $bv_points
                ]);

                // Update the sponsor's BV points
                if ($parent_id) {
                    $referrer = User::find($parent_id);
                    if ($referrer) {
                        $referrer->bv_points += $bv_points;
                        $referrer->save();

                        Log::info('Referrer BV points updated.', [
                            'referrer_id'   => $referrer->id,
                            'new_bv_points' => $referrer->bv_points
                        ]);
                    }
                }

                // Create wallet if needed
                if (moduleExists("Wallet")) {
                    Wallet::create([
                        'user_id'           => $user->id,
                        'balance'           => 0,
                        'remaining_balance' => 0,
                        'withdraw_amount'   => 0,
                        'status'            => 1,
                    ]);
                }

                // Send OTP email if email verification is enabled
                if (!empty(get_static_option('user_email_verify_enable_disable'))) {
                    try {
                        Mail::to($user->email)->send(new BasicMail([
                            'subject' => __('Otp Email'),
                            'message' => __('Your OTP code is: ') . $email_verify_token,
                        ]));
                    } catch (\Exception $e) {
                        Log::error('Failed to send OTP email.', ['error' => $e->getMessage()]);
                    }
                }

                // Dispatch job to send registration email
                if ($user) {
                    dispatch(new SendRegisterUserEmailJob($user, $request->password));
                }

                // Optionally, log in the user immediately
                if (Auth::guard('web')->attempt(['username' => $request->username, 'password' => $request->password])) {
                    return redirect()->route('user.dashboard');
                }
            } catch (\Exception $e) {
                Log::error('Error during MLM member registration.', ['error' => $e->getMessage()]);
                return redirect()->back()->withErrors(['error' => __('An error occurred during registration. Please try again.')]);
            }
        }

        // For GET requests, show the registration form
        return view('frontend.user.genology.add-member');
    }
}
