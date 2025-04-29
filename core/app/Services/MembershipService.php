<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Membership\app\Models\UserMembership;
use Modules\Membership\app\Models\MembershipHistory;
use Modules\Membership\app\Models\Membership;
use App\Models\User;
use App\Models\UsersBV;
use App\Models\Backend\AdminNotification;
use App\Services\BVDistributionService;

class MembershipService
{
    public function update_database($last_membership_id, $transaction_id, $membership_history_id, $upgrade_membership_id)
    {
        try {
            \Log::info('Updating membership database', [
                'last_membership_id' => $last_membership_id,
                'transaction_id' => $transaction_id,
                'membership_history_id' => $membership_history_id,
                'upgrade_membership_id' => $upgrade_membership_id,
            ]);

            $last_membership_id = (int) $last_membership_id;
            $membership_history_id = (int) $membership_history_id;

            $membership_details = UserMembership::with('membership')->find($last_membership_id);
            $membership_history = MembershipHistory::find($membership_history_id);

            if (!$membership_details) {
                throw new \Exception("Membership not found for ID: $last_membership_id");
            }

            // Fallback: Get upgrade_membership_id from the user record
            if (!$upgrade_membership_id) {
                $upgrade_membership_id = $membership_details->membership_id;
                Log::info('Fallback: upgrade_membership_id was null, using membership_id from user record', [
                    'used_membership_id' => $upgrade_membership_id
                ]);
            }

            // Fetch new membership details
            $new_membership = Membership::find($upgrade_membership_id);
            if (!$new_membership) {
                throw new \Exception("New membership not found for ID: $upgrade_membership_id");
            }

            // Set common fields
            $baseData = [
                'membership_id' => $upgrade_membership_id,
                'payment_status' => 'complete',
                'status' => 1,
                'transaction_id' => $transaction_id,
                'initial_profile_limit' => $new_membership->profile_limit,
                'profile_limit' => $new_membership->profile_limit,
                'initial_listing_limit' => $new_membership->listing_limit,
                'initial_gallery_images' => $new_membership->gallery_images,
                'initial_featured_listing' => $new_membership->featured_listing,
                'initial_enquiry_form' => $new_membership->enquiry_form,
                'initial_business_hour' => $new_membership->business_hour,
                'initial_membership_badge' => $new_membership->membership_badge,

                'listing_limit' => $new_membership->listing_limit,
                'price' => $new_membership->price,
                'gallery_images' => $new_membership->gallery_images ,
                'featured_listing' => $new_membership->featured_listing ,

                'enquiry_form' => $new_membership->enquiry_form  ? 1 : 0,
                'business_hour' => $new_membership->business_hour ? 1 : 0,
                'membership_badge' => $new_membership->membership_badge ? 1 : 0,
    
            ];

            // MATRIMONY MEMBERSHIP (Category = 1)
            if ($new_membership->category == 1) {
                $expire_date = Carbon::now()->addDays(30);
                $baseData['expire_date'] = $expire_date;

                // Check if matrimony membership already exists
                $matrimonyMembership = UserMembership::where('user_id', $membership_details->user_id)
                    ->whereHas('membership', fn($q) => $q->where('category', 1))
                    ->first();

                if ($matrimonyMembership) {
                    $matrimonyMembership->update($baseData);
                } else {
                    $baseData['user_id'] = $membership_details->user_id;
                    UserMembership::create($baseData);
                }

                // NORMAL MEMBERSHIP
            } else {
                $expire_date = Carbon::now()->addDays(
                    Carbon::parse($membership_details->expire_date)->diffInDays(Carbon::now()) +
                        Carbon::parse(optional($membership_history)->expire_date)->diffInDays(Carbon::now())
                );
                $baseData['expire_date'] = $expire_date;

                $overlap_matrimony_membership = UserMembership::where('user_id',  $membership_details->user_id)
                    ->whereHas('membership', fn($q) => $q->where('category', 0))
                    ->first();

                \Log::info('Overlap Matrimony Membership', [
                    'overlap_matrimony_membership' => $overlap_matrimony_membership->id ?? 0,
                ]);
             
                if ($overlap_matrimony_membership) {
                    UserMembership::where('id', $overlap_matrimony_membership->id)
                    ->where('user_id', $membership_details->user_id)
                    ->update($baseData);
                   
                } else {
                    $baseData['user_id'] = $membership_details->user_id;
                    UserMembership::create($baseData);
                }
               
            }

            // Update Membership History
            if ($membership_history) {
                MembershipHistory::where('id', $membership_history_id)
                    ->where('user_id', $membership_details->user_id)
                    ->update([
                        'payment_status' => 'complete',
                        'status' => 1,
                        'transaction_id' => $transaction_id,
                        'profile_limit' => $new_membership->profile_limit,
                        'title' => $new_membership->title,
                    ]);
            }

            // BV POINTS Distribution
            $usersBv = UsersBV::create([
                'user_id' => $membership_details->user_id,
                'membership_id' => $upgrade_membership_id,
                'bv_points' => $new_membership->bv_points ?? 0,
                'upgrade_time' => Carbon::now(),
                'type' => 'Self-Purchased',
            ]);

            $user = User::find($membership_details->user_id);

            // Update self_purchased_bv for the user
            if ($new_membership->bv_points > 0) {
                $user->self_purchased_bv += $new_membership->bv_points;
                $user->save();
            }

            $bvService = new BVDistributionService();
            $bvService->distributeBVPoints($user, $usersBv->bv_points, $upgrade_membership_id, $membership_details->user_id);

            // Admin Notification
            AdminNotification::create([
                'identity' => $last_membership_id,
                'user_id' => $membership_details->user_id,
                'type' => __('Buy Membership'),
                'message' => __('User membership purchase'),
            ]);

            session()->forget(['order_id', 'membership_history_id', 'upgrade_membership_id']);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to update membership: ' . $e->getMessage());
            return false;
        }
    }
}
