<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Jobs\SendRegisterUserEmailJob;
use App\Mail\BasicMail;
use App\Models\User;
use App\Models\UsersBV;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Modules\Membership\app\Http\Services\MembershipService;
use Modules\Wallet\app\Models\Wallet;
use App\Models\Backend\Admin;
use Modules\Membership\app\Models\Membership;

class RegisterController extends Controller
{
    protected $membershipService;

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //    protected $redirectTo = RouteServiceProvider::HOME;
    public function redirectTo()
    {
        return route('homepage');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (moduleExists("Membership")) {
            if (membershipModuleExistsAndEnable('Membership')) {
                $this->membershipService = app()->make(MembershipService::class);
            }
        }

        $this->middleware('guest');
        $this->middleware('guest:admin');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'captcha_token' => ['nullable'],
            'username' => ['required', 'string', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'captcha_token.required' => __('google captcha is required'),
            'name.required' => __('name is required'),
            'name.max' => __('name is must be between 191 character'),
            'username.required' => __('username is required'),
            'username.max' => __('username is must be between 191 character'),
            'username.unique' => __('username is already taken'),
            'email.unique' => __('email is already taken'),
            'email.required' => __('email is required'),
            'password.required' => __('password is required'),
            'password.confirmed' => __('both password does not matched'),
        ]);
    }

    protected function adminValidator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:admins'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'country_id' => $data['country_id'],
            'city_id' => $data['city_id'],
            'area_id' => $data['area_id']
        ]);
        return $user;
    }

    public function userNameAvailability(Request $request)
    {
        $username = User::where('username', $request->username)->first();
        if (!empty($username) && $username->username == $request->username) {
            $status = 'not_available';
            $msg = __('Sorry! Username name is not available');
        } else {
            $status = 'available';
            $msg = __('Congrats! Username name is available');
        }
        return response()->json([
            'status' => $status,
            'msg' => $msg,
        ]);
    }

    public function emailAvailability(Request $request)
    {
        $email = User::where('email', $request->email)->first();
        if (!empty($email) && $email->email == $request->email) {
            $status = 'not_available';
            $msg = __('Sorry! Email has already taken');
        } else {
            $status = 'available';
            $msg = __('Congrats! Email is available');
        }
        return response()->json([
            'status' => $status,
            'msg' => $msg,
        ]);
    }

    public function phoneNumberAvailability(Request $request)
    {
        $phone = User::where('phone', $request->phone)->first();
        if (!empty($phone) && $phone->phone == $request->phone) {
            $status = 'not_available';
            $msg = __('Sorry! Phone Number has already taken');
        } else {
            $status = 'available';
            $msg = __('Congrats! Phone number is available');
        }
        return response()->json([
            'status' => $status,
            'msg' => $msg,
            'phone' => $phone,
        ]);
    }

    public function userRegister(Request $request)
    {
        if ($request->isMethod('POST')) {
            Log::info('User registration request received.', ['request_data' => $request->all()]);

            $validationRules = [
                'first_name' => 'required|max:191',
                'last_name' => 'required|max:191',
                'email' => 'required|email|unique:users|max:191',
                'username' => 'required|unique:users|max:191',
                'phone' => 'required|max:191',
                'country_code' => 'nullable|max:10',
                'password' => 'required|min:6|max:191',
                'confirm_password' => 'required|same:password',
                'partner_id' => [
                    'nullable',
                    function ($attribute, $value, $fail) {
                        // Check both users and admins tables
                        $userExists = User::where('partner_id', $value)->exists();
                        $adminExists = Admin::where('partner_id', $value)->exists();

                        if (!$userExists && !$adminExists) {
                            $fail('The selected partner Id is invalid.');
                        }
                    },
                ],
                'gender' => 'required|in:male,female',
                'dob' => 'required|date|before:today|before:-18 years',
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

                // Generate a unique partner ID
                do {
                    $year = now()->format('Y');
                    $month = now()->format('n');
                    $dateCode = $year . $month;
                    $randomDigits = rand(1000, 99999);
                    $partnerId = 'GL' . $dateCode . $randomDigits;
                } while (User::where('partner_id', $partnerId)->exists());

                $partnerName = 'EASYADME-' . strtoupper($request->first_name);

                $sponsor_id = null;
                $parent_id = null;
                $position = null;
                $is_admin_partner = false;

                if ($request->partner_id) {
                    // First check if this is an admin's partner ID
                    $adminPartner = Admin::where('partner_id', $request->partner_id)->first();

                    if ($adminPartner) {
                        $is_admin_partner = true;
                        $sponsor_id = null; // Or set to admin's ID if needed
                        Log::info('Admin partner used for registration', [
                            'admin_partner_id' => $request->partner_id,
                            'admin_id' => $adminPartner->id
                        ]);
                    } else {
                        // Check regular users
                        $partner = User::where('partner_id', $request->partner_id)
                            ->orWhere('username', $request->partner_id)
                            ->first();

                        if ($partner) {
                            $sponsor_id = $partner->id;

                            // Binary tree placement logic
                            $placementFound = false;

                            // First try direct placement under partner
                            if (!$partner->children()->where('position', 'left')->exists()) {
                                $parent_id = $partner->id;
                                $position = 'left';
                                $placementFound = true;
                            } elseif (!$partner->children()->where('position', 'right')->exists()) {
                                $parent_id = $partner->id;
                                $position = 'right';
                                $placementFound = true;
                            }

                            // If direct slots are full, find next available spot
                            if (!$placementFound) {
                                $descendants = $partner->descendants()->with('children')->get();

                                foreach ($descendants as $descendant) {
                                    if (!$descendant->children()->where('position', 'left')->exists()) {
                                        $parent_id = $descendant->id;
                                        $position = 'left';
                                        $placementFound = true;
                                        break;
                                    } elseif (!$descendant->children()->where('position', 'right')->exists()) {
                                        $parent_id = $descendant->id;
                                        $position = 'right';
                                        $placementFound = true;
                                        break;
                                    }
                                }

                                if (!$placementFound) {
                                    $firstAvailable = User::whereDoesntHave('children', function ($q) {
                                        $q->where('position', 'left');
                                    })
                                        ->orWhereDoesntHave('children', function ($q) {
                                            $q->where('position', 'right');
                                        })
                                        ->first();

                                    if ($firstAvailable) {
                                        $parent_id = $firstAvailable->id;
                                        $position = !$firstAvailable->children()->where('position', 'left')->exists() ? 'left' : 'right';
                                    }
                                }
                            }

                            Log::info('Referral details', [
                                'entered_partner_id' => $request->partner_id,
                                'sponsor_id' => $sponsor_id,
                                'tree_parent_id' => $parent_id,
                                'position' => $position
                            ]);
                        }
                    }
                }

                $default_membership = Membership::find(1);
                $membership_id = $default_membership ? $default_membership->id : 1;
                $bv_points = $default_membership ? $default_membership->bv_points : 0;

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
                    'sponsor_id' => $sponsor_id,
                    'parent_id' => $parent_id,
                    'position' => $position,
                    'gender' => $request->gender,
                    'dob' => $request->dob,
                    'is_admin_partner' => $is_admin_partner,
                ]);

                // Save the user within the nested set structure
                if ($parent_id) {
                    $parent = User::find($parent_id);
                    $parent->appendNode($user);
                } else {
                    $user->saveAsRoot();
                }

                Log::info('User created successfully.', ['user_id' => $user->id]);

                UsersBv::create([
                    'user_id' => $user->id,
                    'membership_id' => $membership_id,
                    'bv_points' => $bv_points,
                    'upgrade_time' => now(),
                ]);

                // Add commission to sponsor (if not admin partner)
                // if ($sponsor_id && !$is_admin_partner) {
                //     $referrer = User::find($sponsor_id);
                //     if ($referrer) {
                //         $referrer->bv_points += $bv_points;

                //         $commissionAmount = get_static_option('referral_value') ?? 0;
                //         $referrer->referral_commission += $commissionAmount;
                //         $referrer->save();

                //         Log::info("Commission added to sponsor", [
                //             'sponsor_id' => $referrer->id,
                //             'sponsor_partner_id' => $referrer->partner_id,
                //             'amount' => $commissionAmount,
                //         ]);
                //     }
                // }

                if (moduleExists("Wallet")) {
                    Wallet::create([
                        'user_id' => $user->id,
                        'balance' => 0,
                        'remaining_balance' => 0,
                        'withdraw_amount' => 0,
                        'status' => 1,
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

                if ($user) {
                    dispatch(new SendRegisterUserEmailJob($user, $request->password));
                }

                // Log in the user
                if (Auth::guard('web')->attempt(['username' => $request->username, 'password' => $request->password])) {
                    return redirect()->route('user.dashboard');
                }
            } catch (\Exception $e) {
                Log::error('Error during user registration.', ['error' => $e->getMessage()]);
                return redirect()->back()->withErrors(['error' => __('An error occurred during registration. Please try again.')]);
            }
        }

        return view('frontend.user.user-register');
    }

    public function verifyAdminPartnerId(Request $request)
    {
        $request->validate([
            'partner_id' => 'required|string'
        ]);

        // Check if partner_id exists in admin table
        $exists = Admin::where('partner_id', $request->partner_id)->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }

    public function emailVerify(Request $request)
    {
        $user_details = Auth::guard('web')->user();
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'email_verify_token' => 'required|max:191'
            ], [
                'email_verify_token.required' => __('verify code is required')
            ]);

            $user_details = User::where(['email_verify_token' => $request->email_verify_token, 'email' => $user_details->email])->first();
            if (!is_null($user_details)) {
                $user_details->email_verified = 1;
                $user_details->save();
                return redirect()->route('user.dashboard');
            }
            toastr_warning(__('Your verification code is wrong.'));
            return back();
        }
        $verify_token = $user_details->email_verify_token ?? null;
        try {
            if (is_null($verify_token)) {
                $verify_token = Str::random(8);
                $user_details->email_verify_token = Str::random(8);
                $user_details->save();

                $message_body = __('Hello') . ' ' . $user_details->name . ' <br>' . __('Here is your verification code') . ' <span class="verify-code">' . $verify_token . '</span>';
                Mail::to($user_details->email)->send(new BasicMail([
                    'subject' => sprintf(__('Verify your email address %s'), get_static_option('site_title')),
                    'message' => $message_body
                ]));
            }
        } catch (\Exception $e) {
        }
        return view('frontend.user.email-verify');
    }

    public function resendCode()
    {

        $user_details = Auth::guard('web')->user();
        $verify_token = $user_details->email_verify_token ?? null;

        try {
            if (is_null($verify_token)) {
                $verify_token = Str::random(8);
                $user_details->email_verify_token = Str::random(8);
                $user_details->save();
            }
            $message_body = __('Hello') . ' ' . $user_details->name . ' <br>' . __('Here is your verification code') . ' <span class="verify-code">' . $verify_token . '</span>';
            Mail::to($user_details->email)->send(new BasicMail([
                'subject' => sprintf(__('Verify your email address %s'), get_static_option('site_title')),
                'message' => $message_body
            ]));
        } catch (\Exception $e) {
        }
        return redirect()->back()->with(['msg' => __('Resend Email Verify Code, Please check your inbox of spam.'), 'type' => 'success']);
    }

    public function partnerAvailability()
    {
        $admin = Admin::first();

        if ($admin) {
            return response()->json([
                'success' => true,
                'partner_id' => $admin->partner_id,
                'partner_name' => $admin->partner_name
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'No admin found']);
        }
    }

    public function partneridAvailability(Request $request)
    {
        $partner = User::where('partner_id', $request->partner_id)->first();

        if ($partner) {
            return response()->json(['status' => 'success', 'partner_name' => $partner->partner_name]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Partner ID not found']);
        }
    }

    public function store(Request $request)
    {
        $parent = User::find($request->parent_id);

        if (!$parent) {
            return response()->json(['error' => 'Parent not found'], 404);
        }

        $child = new User([
            'name' => $request->name,
            'email' => $request->email,
            'user_code' => $request->user_code,
            'password' => bcrypt($request->password)
        ]);

        $parent->appendNode($child);

        return response()->json(['message' => 'User added successfully!', 'user' => $child]);
    }
}
