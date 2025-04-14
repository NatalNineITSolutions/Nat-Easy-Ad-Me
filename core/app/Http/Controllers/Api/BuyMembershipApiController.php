<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;

class BuyMembershipApiController extends Controller
{
    public function updateMembership(Request $request)
    {
        
        $request->validate([
            'membership_id' => 'required|exists:memberships,id',  
            'selected_payment_gateway' => 'required|string',      
        ]);

        
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        
        $membership_details = DB::table('memberships')->where('id', $request->membership_id)->first();

        if (!$membership_details) {
            return response()->json(['error' => 'Membership not found'], 404);
        }

        
        $user_membership = DB::table('user_memberships')->where('user_id', $user->id)->first();

        
        if (!$user_membership) {
            return response()->json(['error' => 'User does not have an existing membership'], 404);
        }

        
        $expire_date = now()->addMonths(1); 

        
        DB::table('user_memberships')->where('user_id', $user->id)->update([
            'membership_id' => $membership_details->id,  
            'price' => $membership_details->price,
            'listing_limit' => $membership_details->listing_limit,
            'gallery_images' => $membership_details->gallery_images,
            'featured_listing' => $membership_details->featured_listing,
            'enquiry_form' => $membership_details->enquiry_form,
            'business_hour' => $membership_details->business_hour,
            'membership_badge' => $membership_details->membership_badge,
            'initial_listing_limit' => $membership_details->listing_limit,
            'initial_gallery_images' => $membership_details->gallery_images,
            'initial_featured_listing' => $membership_details->featured_listing,
            'initial_enquiry_form' => $membership_details->enquiry_form,
            'initial_business_hour' => $membership_details->business_hour,
            'initial_membership_badge' => $membership_details->membership_badge,
            'expire_date' => $expire_date,
            'payment_gateway' => $request->selected_payment_gateway,
            'payment_status' => 'paid',
            'status' => '1',  
        ]);

        
        $updated_user_membership = DB::table('user_memberships')->where('user_id', $user->id)->first();

        
        return response()->json([
            'success' => true,
            'message' => 'Membership updated successfully',
            'membership' => $updated_user_membership, 
        ]);
    }
}
