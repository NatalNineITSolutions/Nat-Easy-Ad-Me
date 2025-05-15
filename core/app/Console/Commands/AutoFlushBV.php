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
        } else {
            Log::info("No BV flush for user {$user->id}: not enough BV to form even one pair", [
                'left_bv' => $leftBv,
                'right_bv' => $rightBv,
                'bp_rate' => $bpConversionRate,
            ]);
        }
    }

    protected function processReferralCommission(User $user)
    {
        // Get the user's current referral commission
        $currentCommission = $user->referral_commission ?? 0;

        if ($currentCommission > 0) {
            // Create a BV record for the referral commission
            $user->userBvs()->create([
                'bv_points' => $currentCommission,
                'type' => 'referral_commission',
                'description' => 'Referral commission payout at ' . now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Reset the referral commission to 0
            $user->referral_commission = 0;
            $user->save();

            Log::info("Referral commission processed", [
                'user_id' => $user->id,
                'amount' => $currentCommission
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
            'flushed_amount' => $amount,
        ]);
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
        $dailyPairLimit = (int) get_static_option('sealing_limitation');
        $now = now();

        // Fetch users with both children
        $users = User::with(['leftChild', 'rightChild'])
            ->whereHas('leftChild')
            ->whereHas('rightChild')
            ->get();

        Log::info("Starting payout-detail recording. Users to process: {$users->count()}");

        foreach ($users as $user) {
            // Sum BV in each side
            $totalLeftBv = $this->sumSubtreeBv($user->leftChild, $now);
            $totalRightBv = $this->sumSubtreeBv($user->rightChild, $now);

            // Must meet *all three* criteria to be eligible
            if (
                ($user->self_purchased_bv ?? 0) < 900 ||
                $totalLeftBv < 900 ||
                $totalRightBv < 900
            ) {
                Log::info("Skipping user {$user->id}; eligibility conditions not met", [
                    'self_purchased_bv' => $user->self_purchased_bv,
                    'left_bv' => $totalLeftBv,
                    'right_bv' => $totalRightBv,
                ]);
                continue;
            }

            // Compute how many BP‐pairs they’ve formed, capped by daily limit
            $rawPairs = (int) floor(min($totalLeftBv, $totalRightBv) / $bpConversionRate);
            $userPairs = min($rawPairs, $dailyPairLimit);

            // Include any referral commissions credited in the last minute
            $referral = UsersBv::where('user_id', $user->id)
                ->where('type', 'referral_commission')
                ->where('created_at', '>=', $now->subMinute())
                ->sum('bv_points');

            $grossPayout = ($userPairs * $pairIncome) + $referral;
            Log::info("User {$user->id} gross payout: {$grossPayout}", compact('userPairs', 'referral'));

            // Calculate deductions
            $tdsDeduction = $grossPayout * ($tdsPercentage / 100);
            $serviceChargeAmt = $grossPayout * ($serviceCharge / 100);
            $netAmount = max($grossPayout - $tdsDeduction - $serviceChargeAmt, 0);

            // Persist the payout detail
            UserPayoutDetail::create([
                'user_id' => $user->id,
                'payout_summary_id' => $payoutSummaryId,
                'left_bv' => $totalLeftBv,
                'right_bv' => $totalRightBv,
                'matching_pairs' => $userPairs,
                'payout_amount' => $grossPayout,
                'tds_deduction' => $tdsDeduction,
                'service_charge' => $serviceChargeAmt,
                'net_amount' => $netAmount,
                'status' => $grossPayout > 0
                    ? 'payout_eligible'
                    : 'no_payout',
            ]);

            Log::info("User {$user->id} payout detail recorded", [
                'totalLeftBv' => $totalLeftBv,
                'totalRightBv' => $totalRightBv,
                'rawPairs' => $rawPairs,
                'userPairs' => $userPairs,
                'grossPayout' => $grossPayout,
                'netAmount' => $netAmount,
            ]);
        }

        Log::info("Payout detail recording completed.");
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