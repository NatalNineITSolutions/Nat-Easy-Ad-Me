<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BuyMembershipApiController extends Controller
{
    public function updateMembership(Request $request)
    {
        // Validate input data
        $request->validate([
            'membership_id' => 'required|exists:memberships,id',
            'selected_payment_gateway' => 'required|string',
            'order_id' => 'required|integer',
        ]);

        // Get the authenticated user
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Fetch the membership details
        $membership = DB::table('memberships')->where('id', $request->membership_id)->first();

        if (!$membership) {
            return response()->json(['error' => 'Membership not found'], 404);
        }

        // Check if it's a matrimony membership (membership_id = 4)
        if ($membership->category_id === 1 && $membership->membership_type_id === 4) {
            // This is a matrimony membership, handle accordingly
            return $this->updateMatrimonyMembership($user, $membership, $request);
        } else {
            // This is a regular membership, handle accordingly
            return $this->updateRegularMembership($user, $membership, $request);
        }
    }

    private function updateRegularMembership($user, $membership, $request)
    {
        // Ensure the user has an existing membership
        $user_membership = DB::table('user_memberships')->where('user_id', $user->id)->first();

        if (!$user_membership) {
            return response()->json(['error' => 'User does not have an existing membership'], 404);
        }

        // Set expiry to 1 month from now
        $expire_date = now()->addMonths(1);

        // Update or insert into user_memberships table for regular memberships
        DB::table('user_memberships')->where('user_id', $user->id)->update([
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
            'expire_date' => $expire_date,
            'payment_gateway' => $request->selected_payment_gateway,
            'payment_status' => 'paid',
            'status' => '1',
        ]);

        // Fetch updated user membership
        $updated_user_membership = DB::table('user_memberships')->where('user_id', $user->id)->first();

        return response()->json([
            'success' => true,
            'message' => 'Membership updated successfully',
            'membership' => $updated_user_membership,
        ]);
    }

    private function updateMatrimonyMembership($user, $membership, $request)
    {
        // Ensure the matrimony membership has the correct category_id and membership_type_id
        if ($membership->category_id !== 1 || $membership->membership_type_id !== 4) {
            return response()->json(['error' => 'Invalid membership type for matrimony'], 400);
        }

        // Set expiry to 1 month from now
        $expire_date = now()->addMonths(1);

        // Insert or update matrimony membership in user_memberships table
        DB::table('user_memberships')->updateOrInsert(
            ['user_id' => $user->id], // Check if the user already has a membership
            [
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
                'expire_date' => $expire_date,
                'payment_gateway' => $request->selected_payment_gateway,
                'payment_status' => 'paid',
                'status' => 1, // Membership is active
            ]
        );

        // Fetch updated matrimony membership
        $updatedMembership = DB::table('user_memberships')->where('user_id', $user->id)->first();

        return response()->json([
            'success' => true,
            'message' => 'Matrimony membership activated successfully.',
            'membership' => $updatedMembership,
        ]);
    }
}