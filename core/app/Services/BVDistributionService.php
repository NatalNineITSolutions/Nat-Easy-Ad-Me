<?php

namespace App\Services;

use App\Models\User;
use App\Models\UsersBV;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class BVDistributionService
{
    /**
     * Recursively distribute BV points upward through the upline.
     *
     * @param User   $user              The starting user (typically the new referral).
     * @param int    $bvPoints          The BV points to distribute.
     * @param mixed  $upgradeMembershipId The membership ID for recording purposes.
     * @param mixed  $originalUserId    The ID of the original user (to skip duplicate updates).
     * @return void
     */
    public function distributeBVPoints(User $user, int $bvPoints, $upgradeMembershipId, $originalUserId)
    {
        if (!$user || !$user->parent_id) {
            return;
        }
        
        // Get the immediate parent.
        $parent = User::find($user->parent_id);
        if (!$parent) {
            return;
        }
        
        // Optionally skip if the parent's ID matches the original user to avoid duplicate distribution.
        if ($parent->id === $originalUserId) {
            $this->distributeBVPoints($parent, $bvPoints, $upgradeMembershipId, $originalUserId);
            return;
        }
        
        // Update the parent's BV points.
        $parent->bv_points += $bvPoints;
        $parent->save();
        
        // Record the distribution in the UsersBV table.
        UsersBV::create([
            'user_id'       => $parent->id,
            'membership_id' => $upgradeMembershipId,
            'bv_points'     => $bvPoints,
            'upgrade_time'  => Carbon::now(),
        ]);
        
        Log::info('Distributed BV points to parent user:', [
            'user_id'   => $parent->id,
            'bv_points' => $bvPoints,
        ]);
        
        $this->distributeBVPoints($parent, $bvPoints, $upgradeMembershipId, $originalUserId);
    }
}
