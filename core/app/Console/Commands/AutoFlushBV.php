<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\User;
use App\Models\UsersBv;
use App\Models\IncomePayoutManage;
use Illuminate\Support\Facades\Log;
use App\Models\UserPayoutDetail;
use Illuminate\Support\Facades\DB;
use App\Models\UserFlush;

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

            UserFlush::create([
                'user_id' => $user->id,
                'flushed_left_bv' => $amountToFlush,
                'flushed_right_bv' => $amountToFlush,
                'payout' => 0,
            ]);

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
                $user->referral_commission = 0;
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

    protected function calculateMatchingPairs(float $bpConversionRate)
    {
        $users = User::with(['leftChild.userBvs', 'rightChild.userBvs'])->get();
        $matchingPairs = 0;

        foreach ($users as $user) {
            $leftBv = $user->leftChild ?
                $user->leftChild->userBvs()
                    ->where('bv_points', '>', 0)
                    ->whereNotIn('type', $this->protectedTypes)
                    ->sum('bv_points') : 0;

            $rightBv = $user->rightChild ?
                $user->rightChild->userBvs()
                    ->where('bv_points', '>', 0)
                    ->whereNotIn('type', $this->protectedTypes)
                    ->sum('bv_points') : 0;

            // Count only the number of complete pairs based on sealing limit
            $pairs = (int) floor(min($leftBv, $rightBv) / $bpConversionRate);
            $matchingPairs += $pairs;
            Log::info("User {$user->id} matching pairs: {$pairs}", [
                'left_bv' => $leftBv,
                'right_bv' => $rightBv,
            ]);
        }

        return $matchingPairs;
    }


    protected function recordUserPayoutDetails(
        int $payoutSummaryId,
        float $sealingLimitBv,
        float $bpConversionRate,
        float $pairIncome,
        float $tdsPercentage,
        float $serviceCharge
    ) {
        $dailyLimit = (int) get_static_option('sealing_limitation');
        $now = Carbon::now();

        // only users with both left & right legs
        $users = User::with(['leftChild', 'rightChild'])
            ->whereHas('leftChild')
            ->whereHas('rightChild')
            ->get();

        foreach ($users as $user) {
            // 1) find the last flush before this summary
            $lastFlushAt = UserFlush::where('user_id', $user->id)
                ->where('payout_summary_id', '<', $payoutSummaryId)
                ->max('created_at');

            // 2) calculate total BV on each side since last flush
            $leftBvQuery = $user->leftChild->userBvs()
                ->where('bv_points', '>', 0)
                ->whereNotIn('type', array_merge($this->protectedTypes, ['referral_commission']))
                ->where('created_at', '<', $now);
            $rightBvQuery = $user->rightChild->userBvs()
                ->where('bv_points', '>', 0)
                ->whereNotIn('type', array_merge($this->protectedTypes, ['referral_commission']))
                ->where('created_at', '<', $now);

            if ($lastFlushAt) {
                $leftBvQuery->where('created_at', '>', $lastFlushAt);
                $rightBvQuery->where('created_at', '>', $lastFlushAt);
            }

            $totalLeftBv = (float) $leftBvQuery->sum('bv_points');
            $totalRightBv = (float) $rightBvQuery->sum('bv_points');

            // subtract previously flushed totals for this summary runner
            $flushedLeftTotal = UserFlush::where('user_id', $user->id)
                ->where('payout_summary_id', $payoutSummaryId)
                ->sum('flushed_left_bv');
            $flushedRightTotal = UserFlush::where('user_id', $user->id)
                ->where('payout_summary_id', $payoutSummaryId)
                ->sum('flushed_right_bv');

            $leftBv = max($totalLeftBv - $flushedLeftTotal, 0);
            $rightBv = max($totalRightBv - $flushedRightTotal, 0);

            // 3) pairing math
            $selfBv = $user->self_purchased_bv ?? 0;
            $rawPairs = 0;
            if (
                $selfBv >= $bpConversionRate
                && $leftBv >= $bpConversionRate
                && $rightBv >= $bpConversionRate
            ) {
                $rawPairs = floor(min($leftBv, $rightBv) / $bpConversionRate);
            }
            $userPairs = min($rawPairs, $dailyLimit);

            $flushedLeft = $userPairs * $bpConversionRate;
            $flushedRight = $userPairs * $bpConversionRate;

            // 4) referral commission within this run
            $referralWindowEnd = $now;
            $referralWindowStart = $now->copy()->subMinute();
            $recentReferral = UsersBv::where('user_id', $user->id)
                ->where('type', 'referral_commission')
                ->whereBetween('created_at', [$referralWindowStart, $referralWindowEnd])
                ->sum('bv_points');

            // 5) compute payout amounts
            $grossPayout = ($userPairs * $pairIncome) + $recentReferral;
            $tdsDeduction = $grossPayout * ($tdsPercentage / 100);
            $serviceChargeAmt = $grossPayout * ($serviceCharge / 100);
            $netAmount = max($grossPayout - $tdsDeduction - $serviceChargeAmt, 0);

            // 6) record details and flush row
            if ($userPairs > 0 || $recentReferral > 0) {
                UserPayoutDetail::create([
                    'user_id' => $user->id,
                    'payout_summary_id' => $payoutSummaryId,
                    'left_bv' => $flushedLeft,
                    'right_bv' => $flushedRight,
                    'matching_pairs' => $userPairs,
                    'payout_amount' => $grossPayout,
                    'tds_deduction' => $tdsDeduction,
                    'service_charge' => $serviceChargeAmt,
                    'net_amount' => $netAmount,
                    'status' => $grossPayout > 0
                        ? 'payout_eligible'
                        : 'no_payout',
                ]);

                Log::info('User payout detail recorded', [
                    'user_id' => $user->id,
                    'payout_summary_id' => $payoutSummaryId,
                    'left_bv' => $flushedLeft,
                    'right_bv' => $flushedRight,
                    'matching_pairs' => $userPairs,
                    'gross_payout' => $grossPayout,
                    'tds_deduction' => $tdsDeduction,
                    'service_charge' => $serviceChargeAmt,
                    'net_amount' => $netAmount,
                    'status' => $grossPayout > 0 ? 'payout_eligible' : 'no_payout',
                ]);

                UserFlush::create([
                    'user_id' => $user->id,
                    'payout_summary_id' => $payoutSummaryId,
                    'flushed_left_bv' => $flushedLeft,
                    'flushed_right_bv' => $flushedRight,
                    'payout' => $grossPayout,
                ]);
            }
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