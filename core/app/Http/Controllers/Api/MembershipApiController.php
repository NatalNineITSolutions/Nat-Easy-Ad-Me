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

        // initialized value for if exits user current membership
        $user_current_listing_limit = 0;
        $user_current_profile_limit = 0;
        $user_current_gallery_images = 0;
        $user_current_featured_listing = 0;
        $user_current_enquiry_form = 0;
        $user_current_business_hour = 0;
        $user_current_membership_badge = 0;

        $user_membership_exits = UserMembership::where('user_id', $user->id)
        ->whereHas('membership', fn($q) => $q->whereIn('category', [0, 1]))
        ->first();

        // $user_membership_exits = UserMembership::where('user_id', $user->id)->first();

        if ($user_membership_exits) {
            // Check if the membership IDs are different
            if ($user_membership_exits->membership_id !== $membership->id) {
                // Check if the membership has not expired
                if ($user_membership_exits->expire_date > now()) {
                    $user_current_listing_limit = $user_membership_exits->listing_limit;
                    $user_current_profile_limit = $user_membership_exits->profile_limit; // Add this line
                    $user_current_gallery_images = $user_membership_exits->gallery_images;
                    $user_current_featured_listing = $user_membership_exits->featured_listing;
                    $user_current_enquiry_form = $user_membership_exits->enquiry_form;
                    $user_current_business_hour = $user_membership_exits->business_hour;
                    $user_current_membership_badge = $user_membership_exits->membership_badge;
                }
            }
        }

        if (!empty($membership)) {
            $listing_limit = $membership->listing_limit + $user_current_listing_limit;
            $profile_limit = $membership->profile_limit + $user_current_profile_limit;
            $gallery_images = $membership->gallery_images + $user_current_gallery_images;
            $featured_listing = $membership->featured_listing + $user_current_featured_listing;

            $total = $membership->price;

            $enquiry_form = ($membership->enquiry_form || $user_current_enquiry_form) ? 1 : 0;
            $business_hour = ($membership->business_hour || $user_current_business_hour) ? 1 : 0;
            $membership_badge = ($membership->membership_badge || $user_current_membership_badge) ? 1 : 0;

            $payment_status = $request->selected_payment_gateway === 'wallet' ? 'complete' : 'pending';
            $status = $request->selected_payment_gateway === 'wallet' ? 1 : 0;
        }

        if (!empty($user_membership_exits)) { //membership exist in usermembership table
            // notes:: payment gateway pay if user membership already exits create membership history then updater if payment status done user membership table update
            if (!empty($membership)) {
                // Create membership history
                $new_membership_history = MembershipHistory::create([
                    'membership_id' => $membership->id,
                    'user_id' =>  $user->id,
                    'payment_status' => $payment_status,
                    'payment_gateway' => $request->selected_payment_gateway,
                    // 'expire_date' => $expire_date_for_user_exits_membership,
                    'listing_limit' => $membership->listing_limit,
                    'gallery_images' => $membership->gallery_images,
                    'featured_listing' => $membership->featured_listing,
                    'enquiry_form' => $membership->enquiry_form,
                    'business_hour' => $membership->business_hour,
                    'profile_limit' => $profile_limit,
                    'membership_badge' => $membership->membership_badge,
                    'price' => $total,
                    'status' => $status,
                ]);

                $buy_membership = $user_membership_exits;
               

                // membership history ID in session
                if ($new_membership_history) {
                    $membershipHistoryId = $new_membership_history->id;
                    $upgradeMembershipId = $membership->id;
                }
            }
        } else {
            // create membership
            $buy_membership = UserMembership::create([
                'user_id' => $user->id,
                'membership_id' => $membership->id,
                'price' => $total,
                'initial_listing_limit' => $listing_limit,
                'initial_gallery_images' => $gallery_images,
                'initial_featured_listing' => $featured_listing,
                'initial_enquiry_form' => $enquiry_form,
                'initial_business_hour' => $business_hour,
                'initial_membership_badge' => $membership_badge,
                'listing_limit' => $listing_limit,
                'gallery_images' => $gallery_images,
                'featured_listing' => $featured_listing,
                'initial_profile_limit' => $profile_limit,
                'profile_limit' => $profile_limit,
                'enquiry_form' => $enquiry_form,
                'business_hour' => $business_hour,
                'membership_badge' => $membership_badge,
                'payment_gateway' => $request->selected_payment_gateway,
            ]);

            // Check if the membership was successfully updated
            if ($buy_membership) {
                $user_membership = $buy_membership;
                // Create membership history
                $new_membership_history = MembershipHistory::create([
                    'membership_id' => $user_membership->membership_id,
                    'user_id' => $user_membership->user_id,
                    'payment_status' => $user_membership->payment_status,
                    'payment_gateway' => $user_membership->payment_gateway,
                    'expire_date' => $user_membership->expire_date,
                    'listing_limit' => $user_membership->listing_limit,
                    'gallery_images' => $user_membership->gallery_images,
                    'featured_listing' => $user_membership->featured_listing,
                    'enquiry_form' => $user_membership->enquiry_form,
                    'business_hour' => $user_membership->business_hour,
                    'membership_badge' => $user_membership->membership_badge,
                    'price' => $total,
                    'status' => $status,
                ]);

                if ($new_membership_history) {
                    $membershipHistoryId = $new_membership_history->id;
                    $upgradeMembershipId = $membership->id;
                }
            }
        }

        $last_membership_id = $membership_id ?? $buy_membership->id;

        if (!empty($user_membership_exits)) {
            if (!empty($membership_details)) {
                if (!empty($buy_membership)) {
                    $last_membership_id = $user_membership_exits->id;
                }
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
                'last_membership_id' => $last_membership_id,
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
        $paymentId = $request->query('payment_id');
        $orderId = $request->query('order_id');
        $amount = $request->query('amount');
        $membershipId = $request->query('membership_id');
        $userId = $request->query('user_id');
        $signature = $request->query('signature');
        $membershipHistoryId = $request->query('membership_history_id');
        $upgradeMembershipId = $request->query('upgrade_membership_id');
        $lastMembershipId = $request->query('last_membership_id');

        \Log::info('Razorpay payment success', [
            'payment_id' => $paymentId,
            'order_id' => $orderId,
            'amount' => $amount,
            'membership_id' => $membershipId,
            'user_id' => $userId,
            'signature' => $signature,
        ]);

        // Initialize Razorpay API
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
            if (session('payment_type') === 'matrimony') {
                $method = $paymentData['method'] ?? 'unknown';
                $this->update_profile_listing($orderId, $method);
                session()->forget('payment_type');

                toastr_success(__('Profile On Review'));
                return redirect()->route('matrimony.profile-listing');
            }

            $sessionUserId = $userId;
            $membershipHistoryId = $membershipHistoryId;
            $upgradeMembershipId = $upgradeMembershipId;

            \Log::info('Membership upgrade session data', [
                'session_user_id' => $sessionUserId,
                'membership_history_id' => $membershipHistoryId,
                'upgrade_membership_id' => $upgradeMembershipId,
            ]);

            // Fallback: if session didn't have it, pull from UserMembership
            if (!$upgradeMembershipId && $orderId) {
                $um = UserMembership::find($orderId);
                if ($um) {
                    $upgradeMembershipId = $um->membership_id;
                    Log::info('Fallback upgrade_membership_id loaded from UserMembership', [
                        'order_id' => $orderId,
                        'fallback_membership_id' => $upgradeMembershipId,
                    ]);
                }
            }

            $membershipService = new MembershipService();
            $updated = $membershipService->update_database(
                $lastMembershipId,
                $paymentData['id'],   // razorpay transaction id
                $membershipHistoryId,
                $upgradeMembershipId
            );

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

        return $this->cancel_page();
    }

    protected function cancel_page()
    {
        return redirect()->route('membership.buy.payment.cancel.static');
    }

    public function index(Request $request)
    {
        // Get the current user
        $user = $request->user();

        // Fetch only their memberships
        $memberships = UserMembership::where('user_id', $user->id)
                                     ->get();

        return response()->json([
            'status'  => 'success',
            'data'    => $memberships,
            'message' => 'User memberships retrieved.',
        ], 200);
    }
}
