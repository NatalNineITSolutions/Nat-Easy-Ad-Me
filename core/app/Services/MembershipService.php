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
    public function updateMembership($last_membership_id, $transaction_id, $membership_history_id, $upgrade_membership_id)
    {
        DB::beginTransaction();
        try {
            $last_membership_id = (int) $last_membership_id;
            $membership_history_id = (int) $membership_history_id;

            $membership_details = UserMembership::with('membership')->find($last_membership_id);
            $membership_history = MembershipHistory::find($membership_history_id);

            if (!$membership_details) {
                throw new \Exception("Membership not found for ID: $last_membership_id");
            }

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
                'profile_limit' => $new_membership->profile_limit,
                'initial_listing_limit' => $new_membership->listing_limit,
                'listing_limit' => $new_membership->listing_limit,
                'price' => $new_membership->price,
            ];

            // Debug logging before updates
            Log::debug('Starting membership update', [
                'last_membership_id' => $last_membership_id,
                'transaction_id' => $transaction_id,
                'history_id' => $membership_history_id,
                'upgrade_id' => $upgrade_membership_id
            ]);

            // Handle membership based on category
            $this->handleMembershipType($new_membership, $baseData, $membership_details, $last_membership_id, $membership_history);

            // Update Membership History - pass the actual ID if we have an object
            $historyId = $membership_history ? $membership_history->id : $membership_history_id;
            $this->updateMembershipHistory(
                $membership_history ?: MembershipHistory::find($historyId),
                $membership_details,
                $transaction_id,
                $new_membership
            );

            // Update Membership History
            $this->updateMembershipHistory($membership_history, $membership_details, $transaction_id, $new_membership);

            // Handle BV Points
            $this->handleBvPoints($membership_details, $upgrade_membership_id, $new_membership);

            // Create Admin Notification
            $this->createAdminNotification($last_membership_id, $membership_details);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update membership: ' . $e->getMessage());
            throw $e;
        }
    }

    private function handleMembershipType($new_membership, $baseData, $membership_details, $last_membership_id, $membership_history)
    {
        // MATRIMONY MEMBERSHIP (Category = 1)
        if ($new_membership->category == 1) {
            $baseData['expire_date'] = Carbon::now()->addDays(30);

            $matrimonyMembership = UserMembership::where('user_id', $membership_details->user_id)
                ->whereHas('membership', fn($q) => $q->where('category', 1))
                ->first();

            if ($matrimonyMembership) {
                $matrimonyMembership->update($baseData);
            } else {
                $baseData['user_id'] = $membership_details->user_id;
                UserMembership::create($baseData);
            }
        }
        // NORMAL MEMBERSHIP
        else {
            $expire_date = Carbon::now()->addDays(
                Carbon::parse($membership_details->expire_date)->diffInDays(Carbon::now()) +
                Carbon::parse(optional($membership_history)->expire_date)->diffInDays(Carbon::now())
            );
            $baseData['expire_date'] = $expire_date;

            UserMembership::where('id', $last_membership_id)
                ->where('user_id', $membership_details->user_id)
                ->update($baseData);
        }
    }

    private function updateMembershipHistory($membership_history, $membership_details, $transaction_id, $new_membership)
    {
        if ($membership_history) {
            // Ensure we have the correct membership_history record
            $history = MembershipHistory::where('id', $membership_history->id)
                ->where('user_id', $membership_details->user_id)
                ->first();

            if ($history) {
                $history->update([
                    'payment_status' => 'complete',
                    'status' => 1,
                    'transaction_id' => $transaction_id,
                    'profile_limit' => $new_membership->profile_limit,
                    'user_membership_id' => $membership_details->id, // Make sure this is set
                    'updated_at' => now(),
                ]);

                // Debug logging
                Log::info('Updated membership history', [
                    'history_id' => $history->id,
                    'user_id' => $membership_details->user_id,
                    'changes' => $history->getChanges()
                ]);
            } else {
                Log::error('Membership history record not found', [
                    'history_id' => $membership_history->id,
                    'user_id' => $membership_details->user_id
                ]);
            }
        } else {
            Log::warning('No membership history provided for update', [
                'user_id' => $membership_details->user_id,
                'membership_id' => $membership_details->id
            ]);
        }
    }

    private function handleBvPoints($membership_details, $upgrade_membership_id, $new_membership)
    {
        $usersBv = UsersBV::create([
            'user_id' => $membership_details->user_id,
            'membership_id' => $upgrade_membership_id,
            'bv_points' => $new_membership->bv_points ?? 0,
            'upgrade_time' => Carbon::now(),
        ]);

        $user = User::find($membership_details->user_id);
        $bvService = new BVDistributionService();
        $bvService->distributeBVPoints($user, $usersBv->bv_points, $upgrade_membership_id, $membership_details->user_id);
    }

    private function createAdminNotification($last_membership_id, $membership_details)
    {
        AdminNotification::create([
            'identity' => $last_membership_id,
            'user_id' => $membership_details->user_id,
            'type' => __('Buy Membership'),
            'message' => __('User membership purchase'),
        ]);
    }
}