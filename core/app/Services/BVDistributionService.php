<?php

namespace App\Services;

use App\Models\User;
use App\Models\UsersBV;
use App\Models\UserFlushBv;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class BVDistributionService
{
    public function distributeBVPoints(
        User $user,
        int  $bvPoints,
        int  $upgradeMembershipId,
        int  $originalUserId,
        string $referralType = 'Referral'
    ) {
        if (! $user->parent_id) {
            return;
        }

        $parent = User::find($user->parent_id);
        if (! $parent) {
            return;
        }

        // prevent loops
        if ($parent->id === $originalUserId) {
            return $this->distributeBVPoints(
                $parent,
                $bvPoints,
                $upgradeMembershipId,
                $originalUserId
            );
        }

        // 1) bump parent's BV counter
        $parent->bv_points += $bvPoints;
        $parent->save();

        $type = $referralType === 'Referral from products' ? 'Referral from products' : 'Referral';

        // 2) record the referral‐BV
        $bvRecord = UsersBV::create([
            'user_id'       => $parent->id,
            'membership_id' => $upgradeMembershipId,
            'bv_points'     => $bvPoints,
            'upgrade_time'  => Carbon::now(),
            'type'          => $type,
            'position'      => $user->position,
        ]);

        Log::info('Distributed BV referral to parent', [
            'parent_id' => $parent->id,
            'bv_points' => $bvPoints,
            'position'  => $user->position,
        ]);

        // 3) **increment** the flush table by exactly that BV
        $this->incrementFlushBv($parent->id, $bvRecord);

        // 4) recurse up
        $this->distributeBVPoints(
            $parent,
            $bvPoints,
            $upgradeMembershipId,
            $originalUserId
        );
    }

    /**
     * Increment the flush totals for exactly one new UsersBV entry—
     * so old referral BV (already “counted”) never re-appears.
     */
    protected function incrementFlushBv(int $userId, UsersBV $bvRecord): void
    {
        $flush = UserFlushBv::firstOrNew(['user_id' => $userId]);

        if ($bvRecord->position === 'left') {
            $flush->left_bv = ($flush->left_bv ?? 0) + $bvRecord->bv_points;
        } else {
            $flush->right_bv = ($flush->right_bv ?? 0) + $bvRecord->bv_points;
        }

        $flush->save();

        Log::info('Incremented flush BV totals', [
            'user_id'  => $userId,
            'bv_id'     => $bvRecord->id,
            'left_bv'  => $flush->left_bv,
            'right_bv' => $flush->right_bv,
        ]);
    }
}