<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Exception;
use App\Models\User;
use Modules\Membership\app\Models\Membership;
use Modules\Wallet\app\Models\Wallet;
use App\Jobs\SendRegisterUserEmailJob;
use App\Mail\BasicMail;
use App\Models\UsersBV;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validationRules = [
            'first_name' => 'required|max:191',
            'last_name' => 'required|max:191',
            'email' => 'required|email|unique:users|max:191',
            'username' => 'required|unique:users|max:191',
            'phone' => 'required|max:191',
            'country_code' => 'nullable|max:10',
            'password' => 'required|min:6|max:191',
            'confirm_password' => 'required|same:password',
            'partner_id' => 'nullable|exists:users,partner_id',
        ];

        // Validate the request
        $request->validate($validationRules);

        try {
            Log::info('User registration request received.', ['request_data' => $request->all()]);

            $email_verify_token = sprintf("%d", random_int(123456, 999999));

            // Clean and format phone number
            $phone_number = Str::replace(['-', '(', ')', ' '], '', $request->phone);
            $country_code = '+' . ltrim($request->country_code, '+');
            $full_phone_number = $country_code . ' - ' . $phone_number;

            if (!empty($full_phone_number) && User::where('phone', $full_phone_number)->exists()) {
                Log::warning('Phone number already taken.', ['phone' => $full_phone_number]);
                return response()->json(['error' => __('Phone number is already taken')], 422);
            }

            // Generate unique partner id
            do {
                $partnerId = 'EAM' . Str::upper(Str::random(6));
            } while (User::where('partner_id', $partnerId)->exists());

            $partnerName = 'EASYADME-' . strtoupper($request->first_name);

            $parent_id = null;
            if ($request->partner_id) {
                $partner = User::where('partner_id', $request->partner_id)->first();
                if ($partner) {
                    $parent_id = $partner->id;
                    Log::info('Referred by existing user.', ['referrer_id' => $parent_id]);
                }
            }

            // Get default membership and BV points
            $default_membership = Membership::find(1);
            $membership_id = $default_membership ? $default_membership->id : 1;
            $bv_points = $default_membership ? $default_membership->bv_points : 0;

            // Create the user
            $user = User::create([
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
                'parent_id' => $parent_id,
            ]);

            Log::info('User created successfully.', ['user_id' => $user->id]);

            // Record the user's BV points
            UsersBv::create([
                'user_id' => $user->id,
                'membership_id' => $membership_id,
                'bv_points' => $bv_points,
                'upgrade_time' => now(),
            ]);

            Log::info('User BV points recorded.', [
                'user_id' => $user->id,
                'membership_id' => $membership_id,
                'bv_points' => $bv_points
            ]);

            // Update referrer's BV points if applicable
            if ($parent_id) {
                $referrer = User::find($parent_id);
                if ($referrer) {
                    $referrer->bv_points += $bv_points;
                    $referrer->save();

                    Log::info('Referrer BV points updated.', [
                        'referrer_id' => $referrer->id,
                        'new_bv_points' => $referrer->bv_points
                    ]);
                }
            }

            if (moduleExists("Wallet")) {
                Wallet::create([
                    'user_id' => $user->id,
                    'balance' => 0,
                    'remaining_balance' => 0,
                    'withdraw_amount' => 0,
                    'status' => 1,
                ]);
            }

            // Send OTP email if enabled
            if (!empty(get_static_option('user_email_verify_enable_disable'))) {
                try {
                    Mail::to($user->email)->send(new BasicMail([
                        'subject' => __('Otp Email'),
                        'message' => __('Your OTP code is: ') . $email_verify_token,
                    ]));
                } catch (Exception $e) {
                    Log::error('Failed to send OTP email.', ['error' => $e->getMessage()]);
                }
            }

            // Dispatch email job
            dispatch(new SendRegisterUserEmailJob($user, $request->password));

            // Generate API token for the user (using Sanctum)
            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                'message' => 'User registered successfully.',
                'user' => $user,
                'token' => $token,
            ], 201);
        } catch (Exception $e) {
            Log::error('Error during user registration.', ['error' => $e->getMessage()]);
            return response()->json([
                'error' => __('An error occurred during registration. Please try again.')
            ], 500);
        }
    }


    // Verify existing partner
    public function verifyPartner(Request $request)
    {
        $partner = User::where('partner_id', $request->partner_id)
                     ->orWhere('username', $request->partner_id)
                     ->first();

        if (!$partner) {
            return response()->json([
                'status' => 'error',
                'message' => 'Partner ID not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'partner_name' => $partner->first_name.' '.$partner->last_name,
            'partner_id' => $partner->partner_id
        ]);
    }

    public function login(Request $request)
    {
        $validationRules = [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];

        $request->validate($validationRules);

        try {
            Log::info('User login request received.', ['email' => $request->email]);

            // Find user by email
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                Log::warning('Invalid login credentials.', ['email' => $request->email]);
                return response()->json(['error' => __('Invalid credentials')], 401);
            }

            // Check if email verification is required
            if (!empty(get_static_option('user_email_verify_enable_disable')) && !$user->email_verified_at) {
                Log::warning('User email not verified.', ['email' => $request->email]);
                return response()->json(['error' => __('Please verify your email before logging in.')], 403);
            }

            // Generate API token using Laravel Sanctum
            $token = $user->createToken('API Token')->plainTextToken;

            Log::info('User logged in successfully.', ['user_id' => $user->id]);

            return response()->json([
                'message' => 'Login successful.',
                'user' => $user,
                'token' => $token,
            ], 200);
        } catch (Exception $e) {
            Log::error('Error during user login.', ['error' => $e->getMessage()]);
            return response()->json(['error' => __('An error occurred during login. Please try again.')], 500);
        }
    }
}
