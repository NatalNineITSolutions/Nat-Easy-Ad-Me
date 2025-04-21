<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Membership\app\Models\Membership;
use Illuminate\Support\Facades\DB;
use App\Services\RazorpayService;

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

        $latest = $this->createUserMembership($user->id, $membership, $request->selected_payment_gateway);

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
            ]);

            return response()->json([
                'success' => true,
                'message' => $message,
                'membership' => $latest,
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


    private function createUserMembership($userId, $membership, $gateway)
    {
        $data = [
            'user_id' => $userId,
            'membership_id' => $membership->id,
            'price' => $membership->price,
            'listing_limit' => $membership->listing_limit,
            'gallery_images' => $membership->gallery_images,
            'featured_listing' => $membership->featured_listing,
            'enquiry_form' => $membership->enquiry_form,
            'business_hour' => $membership->business_hour,
            'membership_badge' => $membership->membership_badge,
            'initial_listing_limit' => $membership->listing_limit,
            'initial_gallery_images' => $membership->gallery_images,
            'initial_featured_listing' => $membership->featured_listing,
            'initial_enquiry_form' => $membership->enquiry_form,
            'initial_business_hour' => $membership->business_hour,
            'initial_membership_badge' => $membership->membership_badge,
            'profile_limit' => 0,
            'expire_date' => now()->addMonths(1),
            'payment_gateway' => $gateway,
            'payment_status' => 'paid',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('user_memberships')->insert($data);

        return DB::table('user_memberships')->where('user_id', $userId)->latest('id')->first();
    }
}
