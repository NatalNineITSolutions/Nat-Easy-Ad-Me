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
use App\Models\UserFlushBv;

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
                            $this->processUserBvFlush($user);
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

    protected function processUserBvFlush(User $user, int $payoutSummaryId = null)
    {
        $bpConversionRate = get_static_option('bp_value') ?? 1;
        $sealingLimit = get_static_option('sealing_limitation') ?? 1;

        $leftChild = $user->leftChild;
        $rightChild = $user->rightChild;
        if (!$leftChild || !$rightChild) {
            return;
        }

        $leftBvRecords = $leftChild->userBvs()
            ->whereNotIn('type', $this->protectedTypes)
            ->where('bv_points', '>', 0)
            ->orderBy('created_at')
            ->get();

        $rightBvRecords = $rightChild->userBvs()
            ->whereNotIn('type', $this->protectedTypes)
            ->where('bv_points', '>', 0)
            ->orderBy('created_at')
            ->get();


        // Total BV on each side (excluding protected types)
        $leftBv = $leftBvRecords->sum('bv_points');
        $rightBv = $rightBvRecords->sum('bv_points');

        $leftBpUnits = floor($leftBv / $bpConversionRate);
        $rightBpUnits = floor($rightBv / $bpConversionRate);

        $possiblePairs = min($leftBpUnits, $rightBpUnits);
        $pairsToFlush = min($possiblePairs, $sealingLimit);

        if ($pairsToFlush > 0) {
            $amountToFlush = $pairsToFlush * $bpConversionRate;

            // figure out exactly which record‐IDs to flush
            $leftBvIds = $this->getFlushedBvIds($leftBvRecords, $amountToFlush);
            $rightBvIds = $this->getFlushedBvIds($rightBvRecords, $amountToFlush);

            $allFlushedLeftIds = $leftBvIds;
            $allFlushedRightIds = $rightBvIds;

            $allBvIds = array_merge($leftBvIds, $rightBvIds);

            Log::info("Flushing BV for user {$user->id}", [
                'left_bv' => $leftBv,
                'right_bv' => $rightBv,
                'pairs_to_flush' => $pairsToFlush,
                'allBvIds' => $allBvIds,
            ]);

            // 2) Compute remainders
            $leftRemainder = $leftBv - $amountToFlush;
            $rightRemainder = $rightBv - $amountToFlush;

            // 3) If the remainders differ, flush the smaller one entirely
            if ($leftRemainder !== $rightRemainder) {
                if ($leftRemainder < $rightRemainder && $leftRemainder > 0) {
                    Log::info("Flushing leftover left BV", [
                        'user_id' => $user->id,
                        'left_over_bv' => $leftRemainder,
                    ]);
                    $ids = $this->getFlushedBvIds($leftBvRecords, $leftRemainder);
                    $this->flushSide($leftChild, $leftRemainder, 'left', $allBvIds);
                    $leftRemainder = 0;
                } elseif ($rightRemainder < $leftRemainder && $rightRemainder > 0) {
                    Log::info("Flushing leftover right BV", [
                        'user_id' => $user->id,
                        'right_over_bv' => $rightRemainder,
                    ]);
                    $ids = $this->getFlushedBvIds($rightBvRecords, $rightRemainder);
                    $this->flushSide($rightChild, $rightRemainder, 'right', $allBvIds);
                    $rightRemainder = 0;
                }
            }
            // 4) If they’re exactly equal and nonzero, flush one side
            elseif ($leftRemainder === $rightRemainder && $leftRemainder > 0) {
                Log::info("Equal remainders; flushing left BV", [
                    'user_id' => $user->id,
                    'left_over_bv' => $leftRemainder,
                ]);

                // Filter out already flushed IDs
                $remainingLeftRecords = $leftBvRecords->filter(function ($bv) use ($allFlushedLeftIds) {
                    return !in_array($bv->id, $allFlushedLeftIds);
                })->values();

                Log::info("Remaining left BV records", [
                    'leftBvRecords' => $leftBvRecords,
                    'remaining_left_bv' => $remainingLeftRecords,
                ]);

                $ids = $this->getFlushedBvIds($remainingLeftRecords, $leftRemainder);
                $this->flushSide($leftChild, $leftRemainder, 'left', $allBvIds);
                $leftRemainder = 0;
            }

            // Log final summary…
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

    protected function getFlushedBvIds($bvRecords, $amountToFlush)
    {
        $ids = [];
        $remaining = $amountToFlush;
        foreach ($bvRecords as $bv) {
            if ($remaining <= 0)
                break;
            $ids[] = $bv->id;
            $remaining -= $bv->bv_points;
        }
        return $ids;
    }

    protected function flushSide(User $userChild, float $amount, string $side, array $allBvIds): array
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Amount to flush must be greater than zero.');
        }

        $createdFlushIds = [];

        Log::info('Bvid:' . json_encode(["bvids" => $allBvIds]));
        foreach ($allBvIds as $bvId) {
            $bvRecord = UsersBv::find($bvId);
            if (!$bvRecord) {
                throw new \RuntimeException("BV record with ID {$bvId} not found.");
            }

            // Create UserFlush entry
            $userFlush = UserFlush::create([
                'user_id' => $bvRecord->user_id,
                'flushed_left_bv' => $side === 'left' ? $bvRecord->bv_points : 0,
                'flushed_right_bv' => $side === 'right' ? $bvRecord->bv_points : 0,
                'user_bv_flushed' => $bvId,
            ]);

            $createdFlushIds[] = $bvId;

            // 🔽 Update UserFlushBv table here
            $userFlushBv = UserFlushBv::firstOrNew([
                'user_id' => $bvRecord->user_id,
            ]);

            if ($side === 'left') {
                $userFlushBv->left_bv = ($userFlushBv->left_bv ?? 0) + $bvRecord->bv_points;
            } elseif ($side === 'right') {
                $userFlushBv->right_bv = ($userFlushBv->right_bv ?? 0) + $bvRecord->bv_points;
            }

            $userFlushBv->save();

            Log::debug('UserFlush created', [
                'id' => $userFlush->id,
                'user_bv_flushed' => $userFlush->user_bv_flushed,
            ]);
        }

        if (!empty($createdFlushIds)) {
            UsersBv::whereIn('id', $createdFlushIds)
                ->update(['consumed' => 1]);
        }

        return $createdFlushIds;
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
        $now = now();

        $users = User::with(['leftChild', 'rightChild'])
            ->whereHas('leftChild')
            ->whereHas('rightChild')
            ->get();

        foreach ($users as $user) {
            // — only un-consumed, non-referral BV —
            $leftBv = $user->leftChild
                ->userBvs()
                ->where('bv_points', '>', 0)
                ->where('consumed', 0)                           // ← ignore flushed BV
                ->whereNotIn('type', array_merge($this->protectedTypes, ['referral_commission']))
                ->where('created_at', '<', $now)
                ->sum('bv_points');

            $rightBv = $user->rightChild
                ->userBvs()
                ->where('bv_points', '>', 0)
                ->where('consumed', 0)                           // ← ignore flushed BV
                ->whereNotIn('type', array_merge($this->protectedTypes, ['referral_commission']))
                ->where('created_at', '<', $now)
                ->sum('bv_points');

            $selfBv = $user->self_purchased_bv ?? 0;
            $rawPairs = ($selfBv >= $bpConversionRate && $leftBv >= $bpConversionRate && $rightBv >= $bpConversionRate)
                ? floor(min($leftBv, $rightBv) / $bpConversionRate)
                : 0;
            $userPairs = min($rawPairs, $dailyLimit);

            // — flush amounts —
            $flushedLeft = $userPairs * $bpConversionRate;
            $flushedRight = $userPairs * $bpConversionRate;

            // referral commissions from the last minute (we still count these unconditionally)
            $recentReferral = UsersBv::where('user_id', $user->id)
                ->where('type', 'referral_commission')
                ->where('created_at', '>=', $now->subMinute())
                ->sum('bv_points');

            // gross, TDS, service-charge, net
            $grossPayout = ($userPairs * $pairIncome) + $recentReferral;
            $tdsDeduction = $grossPayout * ($tdsPercentage / 100);
            $serviceChargeAmt = $grossPayout * ($serviceCharge / 100);
            $netAmount = max($grossPayout - $tdsDeduction - $serviceChargeAmt, 0);

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
                    'status' => $grossPayout > 0 ? 'payout_eligible' : 'no_payout',
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
