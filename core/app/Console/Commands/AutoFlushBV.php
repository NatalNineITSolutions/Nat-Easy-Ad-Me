<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\User;
use App\Models\UsersBv;
use App\Models\IncomePayoutManage;
use Illuminate\Support\Facades\Log;
use App\Models\UserPayoutDetail;
use App\Models\UserFlushBv;
use Illuminate\Support\Facades\DB;

class AutoFlushBV extends Command
{
    protected $signature = 'bv:flush';
    protected $description = 'Flush extra BV based on sealing limit at scheduled time';

    protected $protectedTypes = [
        'genology',
        'purchase'
    ];

    public function handle()
    {
        $flushTime = get_static_option('bv_flush_time');
        $now = now()->setTimezone(config('app.timezone'))->format('H:i');

        Log::info("Checking for BV flush. Now: $now, Configured: $flushTime");

        if ($now !== $flushTime) {
            $this->info("No flush — it's not time yet.");
            return 0;
        }

        try {
            DB::transaction(function () {
                $bpConversionRate = get_static_option('bp_value') ?? 1;
                $sealingLimit = get_static_option('sealing_limitation') ?? 1;
                $sealingLimitBv = $sealingLimit * $bpConversionRate;
                $pairIncome = get_static_option('maximum_one_pair_income');
                $tdsPercentage = get_static_option('tds_value');
                $serviceCharge = get_static_option('service_charge');

                // Process BV flush for all users
                User::with(['leftChild.userBvs', 'rightChild.userBvs'])
                    ->chunk(200, function ($users) use ($sealingLimitBv) {
                        foreach ($users as $user) {
                            $this->processUserBvFlush($user, $sealingLimitBv);
                            $this->processReferralCommission($user);
                        }
                    });

                // Record payout summary and details
                $payoutRecord = $this->recordPayoutSummary($sealingLimitBv);
                $this->recordUserPayoutDetails(
                    $payoutRecord->id,
                    $sealingLimitBv,
                    $bpConversionRate,
                    $pairIncome,
                    $tdsPercentage,
                    $serviceCharge
                );
            });

            $this->info('BV and referral commissions flushed successfully.');
            return 0;
        } catch (\Exception $e) {
            Log::error("BV Flush Error: " . $e->getMessage());
            $this->error('Error during BV flush: ' . $e->getMessage());
            return 1;
        }
    }

    protected function processUserBvFlush(User $user)
    {
        // re‐fetch the dynamic settings
        $bpConversionRate = get_static_option('bp_value') ?? 1;
        $sealingLimit = get_static_option('sealing_limitation') ?? 1;

        $leftChild = $user->leftChild;
        $rightChild = $user->rightChild;
        if (!$leftChild || !$rightChild) {
            return;
        }

        // total BV on each side (excluding protected types)
        $leftBv = $leftChild->userBvs()
            ->whereNotIn('type', $this->protectedTypes)
            ->sum('bv_points');
        $rightBv = $rightChild->userBvs()
            ->whereNotIn('type', $this->protectedTypes)
            ->sum('bv_points');

        // How many WHOLE BP units on each side?
        $leftBpUnits = floor($leftBv / $bpConversionRate);
        $rightBpUnits = floor($rightBv / $bpConversionRate);

        // How many BP‐pairs do we actually have?
        $possiblePairs = min($leftBpUnits, $rightBpUnits);

        // But we can only flush up to our daily sealing limit:
        $pairsToFlush = min($possiblePairs, $sealingLimit);

        if ($pairsToFlush > 0) {
            // This is the BV we’ll deduct from each side:
            $amountToFlush = $pairsToFlush * $bpConversionRate;

            // 1) Flush that exact amount from left and right
            $this->flushSide($leftChild, $amountToFlush, 'left');
            $this->flushSide($rightChild, $amountToFlush, 'right');

            // 2) Subtract it so we can still run your “remainder” logic
            $leftRemainder = $leftBv - $amountToFlush;
            $rightRemainder = $rightBv - $amountToFlush;

            // 3) If the remainders differ, flush the smaller one entirely
            if ($leftRemainder !== $rightRemainder) {
                if ($leftRemainder < $rightRemainder && $leftRemainder > 0) {
                    Log::info("Flushing leftover left BV", [
                        'user_id' => $user->id,
                        'left_over_bv' => $leftRemainder,
                    ]);
                    $this->flushSide($leftChild, $leftRemainder, 'left');
                    $leftRemainder = 0;
                } elseif ($rightRemainder < $leftRemainder && $rightRemainder > 0) {
                    Log::info("Flushing leftover right BV", [
                        'user_id' => $user->id,
                        'right_over_bv' => $rightRemainder,
                    ]);
                    $this->flushSide($rightChild, $rightRemainder, 'right');
                    $rightRemainder = 0;
                }
            }
            // 4) If they’re exactly equal and nonzero, flush one side
            elseif ($leftRemainder === $rightRemainder && $leftRemainder > 0) {
                Log::info("Equal remainders; flushing left BV", [
                    'user_id' => $user->id,
                    'left_over_bv' => $leftRemainder,
                ]);
                $this->flushSide($leftChild, $leftRemainder, 'left');
                $leftRemainder = 0;
            }

            Log::info("BV flush for user {$user->id} completed", [
                'pairs_flushed' => $pairsToFlush,
                'bv_per_side_flushed' => $amountToFlush,
                'remaining_left_bv' => $leftRemainder,
                'remaining_right_bv' => $rightRemainder,
            ]);

            DB::table('user_flush_bvs')->updateOrInsert(
                ['user_id' => $user->id],
                [
                    'left_bv' => $leftRemainder,
                    'right_bv' => $rightRemainder,
                    'eligible_pairs' => $pairsToFlush,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        } else {
            Log::info("No BV flush for user {$user->id}: not enough BV to form even one pair", [
                'left_bv' => $leftBv,
                'right_bv' => $rightBv,
                'bp_rate' => $bpConversionRate,
            ]);
        }
    }

    protected function flushSide($userChild, $amount, $side)
    {
        if ($amount <= 0) {
            return;
        }

        $userChild->userBvs()->create([
            'bv_points' => -$amount,
            'type' => 'flush_deduction',
            'description' => ucfirst($side) . ' BV flush at ' . now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Log::info("BV Flush - Side {$side}", [
            'user_id' => $userChild->id,
            'flushed_bv' => $amount,
        ]);
    }

    protected function isUserEligibleForPayout(User $user): bool
    {
        $now = now();
        $selfBv = $user->self_purchased_bv ?? 0;
        $bpConversionRate = get_static_option('bp_value') ?? 1;

        $referral = $user->referral_commission ?? 0;
        if ($selfBv >= $bpConversionRate && $referral > 100) {
            Log::info("User qualifies via referral override", [
                'user_id' => $user->id,
                'self_bv' => $selfBv,
                'referral_commission' => $referral
            ]);
            return true;
        }

        // Then check standard tree eligibility
        $totalLeftBv = $this->sumSubtreeBv($user->leftChild, $now);
        $totalRightBv = $this->sumSubtreeBv($user->rightChild, $now);

        $standardEligible = $selfBv >= $bpConversionRate && $totalLeftBv >= $bpConversionRate && $totalRightBv >= $bpConversionRate;

        Log::info("User eligibility check", [
            'user_id' => $user->id,
            'self_bv' => $selfBv,
            'left_bv' => $totalLeftBv,
            'right_bv' => $totalRightBv,
            'referral_commission' => $referral,
            'is_eligible' => $standardEligible || ($selfBv >= $bpConversionRate && $referral > 100)
        ]);

        return $standardEligible;
    }

    protected function processReferralCommission(User $user)
    {
        // Get the user's current referral commission
        $currentCommission = $user->referral_commission ?? 0;

        if ($currentCommission > 0) {
            // Check if user is eligible through either criteria
            $isEligible = $this->isUserEligibleForPayout($user);

            if ($isEligible) {
                // Create BV record for the commission
                $user->userBvs()->create([
                    'bv_points' => $currentCommission,
                    'type' => 'referral_commission',
                    'description' => 'Referral commission payout at ' . now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Reset the commission
                // $user->referral_commission = 0;
                $user->save();

                Log::info("Referral commission processed for eligible user", [
                    'user_id' => $user->id,
                    'amount' => $currentCommission,
                    'self_bv' => $user->self_purchased_bv,
                    'has_referral_override' => true
                ]);
            } else {
                Log::info("Referral commission held - user not eligible", [
                    'user_id' => $user->id,
                    'amount' => $currentCommission,
                    'self_bv' => $user->self_purchased_bv
                ]);
            }
        }
    }

    protected function recordPayoutSummary($sealingLimitBv)
    {
        $payoutDateTime = now();

        // Get BV before the flush operation (excluding protected types)
        $currentDayBV = UsersBv::where('bv_points', '>', 0)
            ->whereNotIn('type', $this->protectedTypes)
            ->where('created_at', '<', $payoutDateTime)
            ->sum('bv_points');

        $pairIncome = get_static_option('maximum_one_pair_income') ?? 1;
        $dailyCeiling = get_static_option('sealing_limitation') ?? 1;
        $bpConversionRate = get_static_option('bp_value') ?? 1; // Ensure $bpConversionRate is defined
        $matchingPairs = $this->calculateMatchingPairs($bpConversionRate);
        $actualPairsToPay = min($matchingPairs, $dailyCeiling);/*  */

        $totalOutput = $matchingPairs * $pairIncome;
        $maximumPairIncome = get_static_option('maximum_one_pair_income') ?? 0;
        $totalOutput = min($totalOutput, $maximumPairIncome);

        // Get previous balance and calculate new balance
        $previousRecord = IncomePayoutManage::latest()->first();
        $previousBalance = $previousRecord ? $previousRecord->balance_case_on_hand : 0;
        $newBalance = ($currentDayBV + $previousBalance) - $totalOutput;

        // Create the payout record
        $payoutRecord = IncomePayoutManage::create([
            'payout_date' => $payoutDateTime,
            'previous_case_on_hand' => $previousBalance,
            'current_day_bv' => $currentDayBV,
            'total_bv' => $previousBalance + $currentDayBV,
            'matching_pairs' => $matchingPairs,
            'actual_pairs_paid' => $actualPairsToPay,
            'pair_income' => $pairIncome,
            'total_output_amount' => $totalOutput,
            'balance_case_on_hand' => $newBalance,
        ]);

        Log::info("Payout recorded", [
            'date' => $payoutDateTime->toDateTimeString(),
            'previous_balance' => $previousBalance,
            'new_balance' => $newBalance,
            'record_id' => $payoutRecord->id
        ]);

        return $payoutRecord;
    }

    /**
     * Sum up all of today’s eligible_pairs in user_flush_bvs
     * — that is your total matching pairs.
     */
    protected function calculateMatchingPairs(float $bpConversionRate): int
    {
        // Uncomment to restrict to just today's flush rows:
        // $dayStart = now()->startOfDay();
        // $dayEnd   = now()->endOfDay();

        $q = UserFlushBv::query()
            // ->whereBetween('created_at', [$dayStart, $dayEnd])
            ->where('eligible_pairs', '>', 0);

        Log::info('calculateMatchingPairs:', [
            'rows' => $q->count(),
            'sum_eligible_pairs' => $q->sum('eligible_pairs'),
        ]);

        return (int) $q->sum('eligible_pairs');
    }

    /**
     * Create UserPayoutDetail entries only for users with
     * eligible_pairs ≥ 1, then zero those out.
     */
    /**
     * Create UserPayoutDetail entries for:
     *  1) users who flushed ≥1 pair today (eligible_pairs ≥ 1)
     *  2) then zero out those pairs
     *  3) then pay pure "override" users (self_purchased_bv≥bp && referral≥100)
     */
    protected function recordUserPayoutDetails(
        int $payoutSummaryId,
        float $sealingLimitBv,
        float $bpConversionRate,
        float $pairIncome,
        float $tdsPercentage,
        float $serviceCharge
    ): void {
        $dayStart = now()->startOfDay();
        $dayEnd = now()->endOfDay();

        // 1) grab only those with ≥1 pair flushed today
        $flushRows = UserFlushBv::whereBetween('created_at', [$dayStart, $dayEnd])
            ->where('eligible_pairs', '>=', 1)
            ->get()
            ->keyBy('user_id');

        // process each real-flush user
        foreach ($flushRows as $userId => $flush) {
            $user = User::find($userId);

            // skip if self BV too low
            if (!$user || ($user->self_purchased_bv ?? 0) < $bpConversionRate) {
                Log::info("Skipping user {$userId}: self_purchased_bv too low");
                continue;
            }

            $pairs = $flush->eligible_pairs;
            $commission = $user->referral_commission ?? 0;

            // drain or re-sum commission
            if ($commission >= 100) {
                $user->referral_commission = 0;
                $user->save();
            } elseif ($commission > 0) {
                $commission = UsersBv::where('user_id', $userId)
                    ->where('type', 'referral_commission')
                    ->where('created_at', '>=', now()->subMinute())
                    ->sum('bv_points');
            }

            // gross = pair-income + commission
            $gross = ($pairs * $pairIncome) + $commission;

            // deductions
            $tdsAmt = $gross * ($tdsPercentage / 100);
            $serviceChargeAmt = $gross * ($serviceCharge / 100);
            $net = max($gross - $tdsAmt - $serviceChargeAmt, 0);

            // record payout detail
            UserPayoutDetail::create([
                'user_id' => $userId,
                'payout_summary_id' => $payoutSummaryId,
                'left_bv' => $pairs * $bpConversionRate,
                'right_bv' => $pairs * $bpConversionRate,
                'matching_pairs' => $pairs,
                'payout_amount' => $gross,
                'referral' => $commission,
                'tds_deduction' => $tdsAmt,
                'service_charge' => $serviceChargeAmt,
                'net_amount' => $net,
                'status' => 'payout_eligible',
            ]);

            Log::info("UserPayoutDetail created for user {$userId}", [
                'pairs' => $pairs,
                'gross' => $gross,
                'tds' => $tdsAmt,
                'service' => $serviceChargeAmt,
                'net' => $net,
                'referral' => $commission,
            ]);
        }

        // 2) zero out those eligible_pairs so they won’t be re-paid
        UserFlushBv::whereBetween('created_at', [$dayStart, $dayEnd])
            ->where('eligible_pairs', '>=', 1)
            ->update(['eligible_pairs' => 0]);

        // 3) pure-referral override payouts
        $overrideUsers = User::where('self_purchased_bv', '>=', $bpConversionRate)
            ->where('referral_commission', '>=', 100)
            ->whereNotIn('id', $flushRows->keys())
            ->get();

        foreach ($overrideUsers as $user) {
            $commission = $user->referral_commission;

            // drain referral
            $user->referral_commission = 0;
            $user->save();

            // gross = commission only
            $gross = $commission;

            $tdsAmt = $gross * ($tdsPercentage / 100);
            $serviceChargeAmt = $gross * ($serviceCharge / 100);
            $net = max($gross - $tdsAmt - $serviceChargeAmt, 0);

            UserPayoutDetail::create([
                'user_id' => $user->id,
                'payout_summary_id' => $payoutSummaryId,
                'left_bv' => 0,
                'right_bv' => 0,
                'matching_pairs' => 0,
                'payout_amount' => $gross,
                'referral' => $commission,
                'tds_deduction' => $tdsAmt,
                'service_charge' => $serviceChargeAmt,
                'net_amount' => $net,
                'status' => 'payout_eligible',
            ]);

            Log::info("Override-only payout recorded for user {$user->id}", [
                'gross' => $gross,
                'tds' => $tdsAmt,
                'service' => $serviceChargeAmt,
                'net' => $net,
                'referral' => $commission,
            ]);
        }
    }


    /**
     * Sum only one node's BV records (not its whole subtree).
     */
    protected function sumNodeBv(?User $node, \Illuminate\Support\Carbon $cutoff): float
    {
        if (!$node)
            return 0;
        return (float) $node->userBvs()
            ->whereNotIn('type', $this->protectedTypes)
            ->where('created_at', '<', $cutoff)
            ->sum('bv_points');
    }

    /**
     * (Optional) if you want to log/store the entire subtree's BV total.
     */
    protected function sumSubtreeBv(?User $node, \Illuminate\Support\Carbon $cutoff): float
    {
        if (!$node)
            return 0;
        $total = $this->sumNodeBv($node, $cutoff);
        $total += $this->sumSubtreeBv($node->leftChild, $cutoff);
        $total += $this->sumSubtreeBv($node->rightChild, $cutoff);
        return $total;
    }

    /**
     * Recursively count **1 direct pair** at this node +
     * all pairs in its left‐ & right‐child subtrees.
     */
    protected function countMatchingPairs(?User $user, float $bpConversionRate, Carbon $cutoff): int
    {
        if (!$user)
            return 0;

        // how much BV sits *directly* under each immediate child?
        $L = $this->sumNodeBv($user->leftChild, $cutoff);
        $R = $this->sumNodeBv($user->rightChild, $cutoff);

        // ① direct pair here?
        $direct = (floor(min($L, $R) / $bpConversionRate) >= 1) ? 1 : 0;

        // ② plus whatever their sub‐subtrees hold
        $leftPairs = $this->countMatchingPairs($user->leftChild, $bpConversionRate, $cutoff);
        $rightPairs = $this->countMatchingPairs($user->rightChild, $bpConversionRate, $cutoff);

        return $direct + $leftPairs + $rightPairs;
    }
}