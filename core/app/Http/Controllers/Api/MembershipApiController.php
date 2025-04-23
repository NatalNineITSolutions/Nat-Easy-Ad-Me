<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Membership\app\Models\Membership;
use Illuminate\Support\Facades\DB;
use App\Services\RazorpayService;
use Illuminate\Support\Facades\Log;
use Modules\Membership\app\Models\MembershipHistory;
use App\Services\BVDistributionService;
use Illuminate\Support\Carbon;
use App\Services\MembershipService;
use Modules\Membership\app\Models\UserMembership;
use App\Models\User;
use App\Models\UsersBV;
use App\Models\Backend\AdminNotification;
use Razorpay\Api\Api;

class MembershipApiController extends Controller
{
    public function getMembershipsByCategory(Request $request)
    {
        $request->validate([
            'category' => 'required|in:0,1'
        ]);

        $category = $request->category;

        $memberships = Membership::where('status', 1)
            ->where('category', $category)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Memberships retrieved successfully',
            'data' => $memberships
        ], 200);
    }

    public function updateMembership(Request $request)
    {
        $request->validate([
            'membership_id' => 'required|exists:memberships,id',
            'selected_payment_gateway' => 'required|string',
        ]);

        $payment_status = $request->selected_payment_gateway === 'wallet' ? 'complete' : 'pending';
        $status = $request->selected_payment_gateway === 'wallet' ? 1 : 0;

        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $membership = Membership::find($request->membership_id);
        if (!$membership) {
            return response()->json(['error' => 'Membership not found'], 404);
        }


        if ($membership->category == 1 && $membership->membership_type_id == 4) {
            if ($membership->category_id !== 1) {
                return response()->json(['error' => 'Invalid membership type for matrimony'], 400);
            }
            $message = 'Matrimony membership added successfully.';
        } else {
            $message = 'Membership added successfully.';
        }

        if (!empty($membership)) {
            // Create membership history
            $new_membership_history = MembershipHistory::create([
                'membership_id' => $membership->id,
                'user_id' => $user->id,
                'payment_status' => $payment_status,
                'payment_gateway' => $request->selected_payment_gateway,
                // 'expire_date' => $expire_date_for_user_exits_membership,
                'listing_limit' => $membership->listing_limit,
                'gallery_images' => $membership->gallery_images,
                'featured_listing' => $membership->featured_listing,
                'enquiry_form' => $membership->enquiry_form,
                'business_hour' => $membership->business_hour,
                'membership_badge' => $membership->membership_badge,
                'price' => $membership->price,
                'status' => $status,
            ]);

            $buy_membership = $new_membership_history;

            // membership history ID in session
            if ($new_membership_history) {
                \Log::info('New membership history created', [
                    'membership_history_id' => $new_membership_history->id,
                    'user_id' => $user->id,
                ]);
               
                $membershipHistoryId = $new_membership_history->id;
                $upgradeMembershipId = $membership->id;
            }
        }

        // 🔐 Fetch gateway credentials from payment_gateways table
        $gateway = \DB::table('payment_gateways')->where('name', $request->selected_payment_gateway)->first();
        if (!$gateway) {
            return response()->json(['error' => 'Selected payment gateway not found.'], 404);
        }

        $credentials = json_decode($gateway->credentials, true);
        $apiKey = $credentials['api_key'] ?? null;
        $apiSecret = $credentials['api_secret'] ?? null;

        if (!$apiKey || !$apiSecret) {
            return response()->json(['error' => 'Incomplete gateway credentials.'], 500);
        }

        // 💸 Razorpay payment link generation
        try {
            $razorpayService = new RazorpayService();
            $razorpayOrder = $razorpayService->createOrder($membership->price);

            $paymentUrl = route('razorpay.checkout') . "?" . http_build_query([
                'order_id' => $razorpayOrder['id'],
                'amount' => $membership->price,
                'currency' => 'INR',
                'key' => $razorpayService->getKey(),
                'membership_id' => $membership->id,
                'user_id' => $user->id,
                'membership_history_id' => $membershipHistoryId,
                'upgrade_membership_id' => $upgradeMembershipId,
            ]);

            return response()->json([
                'success' => true,
                'message' => $message,
                'membership' => $buy_membership,
                'payment_url' => $paymentUrl,
                'razorpay_order_id' => $razorpayOrder['id'],
                'amount' => $membership->price,
                'currency' => 'INR',
                'api_key' => $apiKey,
                'api_secret' => $apiSecret,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Razorpay Error: ' . $e->getMessage()], 500);
        }
    }

    public function handlePaymentSuccess(Request $request)
    {
        $paymentId     = $request->query('payment_id');
        $orderId       = $request->query('order_id');
        $amount        = $request->query('amount');
        $membershipId  = $request->query('membership_id');
        $userId        = $request->query('user_id');
        $signature     = $request->query('signature');
        $membershipHistoryId = $request->query('membership_history_id');
        $upgradeMembershipId = $request->query('upgrade_membership_id');

        // 2. Initialize Razorpay API
        \Log::info('Razorpay payment success', [
            'payment_id' => $paymentId,
            'order_id' => $orderId,
            'amount' => $amount,
            'membership_id' => $membershipId,
            'user_id' => $userId,
            'signature' => $signature,
        ]);

        $gateway = \DB::table('payment_gateways')->where('name', 'razorpay')->first();
        if (!$gateway) {
            return response()->json(['error' => 'Selected payment gateway not found.'], 404);
        }

        $credentials = json_decode($gateway->credentials, true);
        $apiKey = $credentials['api_key'] ?? null;
        $apiSecret = $credentials['api_secret'] ?? null;
        if (!$apiKey || !$apiSecret) {
            return response()->json(['error' => 'Incomplete gateway credentials.'], 500);
        }

        $api = new Api($apiKey, $apiSecret);

        try {
            $paymentData = $api->payment->fetch($paymentId)->toArray();
        } catch (\Exception $e) {
            Log::error('Error fetching Razorpay payment: ' . $e->getMessage());
            return $this->cancel_page();
        }

        Log::info('Razorpay payment data', [
            'payment_data' => $paymentData,
        ]);

        if (isset($paymentData['status']) && $paymentData['status'] === 'captured') {
            // handle your “complete” flow

            if (session('payment_type') === 'matrimony') {
                $method = $paymentData['method'] ?? 'unknown';
                $this->update_profile_listing($orderId, $method);
                session()->forget('payment_type');

                toastr_success(__('Profile On Review'));
                return redirect()->route('matrimony.profile-listing');
            }

            $sessionUserId         = $userId;
            $membershipHistoryId   = $membershipHistoryId;
            $upgradeMembershipId   = $upgradeMembershipId;

            \Log::info('Membership upgrade session data', [
                'session_user_id'         => $sessionUserId,
                'membership_history_id'   => $membershipHistoryId,
                'upgrade_membership_id'   => $upgradeMembershipId,
            ]);
            // Fallback: if session didn't have it, pull from UserMembership
            if (! $upgradeMembershipId && $orderId) {
                $um = UserMembership::find($orderId);
                if ($um) {
                    $upgradeMembershipId = $um->membership_id;
                    Log::info('Fallback upgrade_membership_id loaded from UserMembership', [
                        'order_id'                   => $orderId,
                        'fallback_membership_id'     => $upgradeMembershipId,
                    ]);
                }
            }


            $userMembershipExists = UserMembership::where('user_id', $sessionUserId)
                ->latest('id')
                ->first();

            $lastMembershipId = $userMembershipExists->id;

            $membershipService = new MembershipService();
            $updated = $membershipService->update_database(
                $lastMembershipId,
                $paymentData['id'],   // razorpay transaction id
                $membershipHistoryId,
                $upgradeMembershipId
            );

            // $this->send_jobs_mail($orderId, $sessionUserId);

            Log::info('Membership update result', [
                'updated' => $updated,
                'user_id' => $sessionUserId,
                'membership_history_id' => $membershipHistoryId,
                'upgrade_membership_id' => $upgradeMembershipId,
            ]);

            if ($updated) {
                return view('payment-success');
            }
        }
    }

    protected function cancel_page()
    {
        return redirect()->route('membership.buy.payment.cancel.static');
    }
}
