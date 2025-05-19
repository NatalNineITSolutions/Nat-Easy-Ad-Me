<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Modules\Membership\app\Models\Membership;
use App\Models\UsersBV;
use Modules\Wallet\app\Models\Wallet;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendRegisterUserEmailJob;


class GenologyController extends Controller
{
    public function genology()
    {
        $user_id = Auth::id();

        $user = User::with([
            'leftChild.userBvs',
            'rightChild.userBvs',
            'leftChild.leftChild',
            'rightChild.rightChild'
        ])->where('id', $user_id)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => __('User not found')
            ], 404);
        }

        // Recursively calculate BV for each node
        $this->calculateBV($user);

        // Prepare the MLM tree data
        $mlmTree = $user;

        return response()->json([
            'success' => true,
            'mlmTree' => $mlmTree
        ]);
    }

    private function calculateBV(&$node)
    {
        if (!$node) {
            Log::warning('Node is null in calculateBV');
            return;
        }

        // Calculate BV for the current node
        $node->leftBV = $node->leftChild ? $node->leftChild->userBvs->sum('bv_points') : 0;
        $node->rightBV = $node->rightChild ? $node->rightChild->userBvs->sum('bv_points') : 0;

        // Debug: Log calculated BV points
        Log::info('Calculated BV points for node:', [
            'node_id' => $node->id,
            'leftBV' => $node->leftBV,
            'rightBV' => $node->rightBV,
        ]);

        // Recursively calculate BV for left and right children
        if ($node->leftChild) {
            $this->calculateBV($node->leftChild);
        }

        if ($node->rightChild) {
            $this->calculateBV($node->rightChild);
        }
    }

    public function apiRegisterNewMember(Request $request)
    {
        Log::info('MLM new member API registration request received.', ['request_data' => $request->all()]);

        $validationRules = [
            'first_name' => 'required|max:191',
            'last_name' => 'required|max:191',
            'email' => 'required|email|unique:users|max:191',
            'username' => 'required|unique:users|max:191',
            'phone' => 'required|max:191',
            'password' => 'required|min:6|max:191',
            'confirm_password' => 'required|same:password',
            'parent_id' => 'required|exists:users,id',  // Immediate parent (node clicked)
            'root_id' => 'required|exists:users,id',    // Root user of the tree
            'position' => 'required|in:left,right',
            'gender' => 'required|in:male,female',
            'dob' => 'required|date|before:today',
        ];

        if (get_static_option('site_google_captcha_enable') == 'on') {
            $validationRules['g-recaptcha-response'] = 'nullable';
        }

        $validator = \Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => __('Validation errors'),
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $email_verify_token = sprintf("%d", random_int(123456, 999999));

            $phone_number = Str::replace(['-', '(', ')', ' '], '', $request->phone);
            $country_code = '+' . ltrim($request->country_code, '+');
            $full_phone_number = $country_code . ' - ' . $phone_number;

            if (!empty($full_phone_number) && User::where('phone', $full_phone_number)->exists()) {
                return response()->json([
                    'status' => false,
                    'message' => __('Phone number is already taken')
                ], 409);
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

            Log::info('User created via API. ID: ' . $user->id, $user->toArray());

            $default_membership = Membership::find(1);
            $membership_id = $default_membership ? $default_membership->id : 1;
            $bv_points = $default_membership ? $default_membership->bv_points : 0;

            UsersBV::create([
                'user_id' => $user->id,
                'membership_id' => $membership_id,
                'bv_points' => $bv_points,
                'upgrade_time' => now(),
            ]);

            Log::info('BV points initialized via API.', ['user_id' => $user->id, 'bv' => $bv_points]);

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

            return response()->json([
                'status' => true,
                'message' => __('New member registered successfully!'),
                'user_id' => $user->id
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error during MLM member API registration.', ['error' => $e->getMessage()]);

            return response()->json([
                'status' => false,
                'message' => __('An error occurred during registration. Please try again.'),
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }
}
