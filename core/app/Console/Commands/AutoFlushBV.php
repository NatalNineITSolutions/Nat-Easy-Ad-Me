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
        'direct_referral',
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
                $sealingLimit = get_static_option('sealing_limit') ?? 1;
                $sealingLimitBv = $sealingLimit * $bpConversionRate;
                $pairIncome = get_static_option('maximum_one_pair_income');
                $tdsPercentage = get_static_option('tds_value');
                $serviceCharge = get_static_option('service_charge');

                // Process BV flush for all users
                User::with(['leftChild.userBvs', 'rightChild.userBvs'])
                    ->chunk(200, function ($users) use ($sealingLimitBv) {
                        foreach ($users as $user) {
                            $this->processUserBvFlush($user, $sealingLimitBv);
                        }
                    });

                // Record payout summary and details
                $payoutRecord = $this->recordPayoutSummary($sealingLimitBv);
                $this->recordUserPayoutDetails(
                    $payoutRecord->id,
                    $sealingLimitBv,
                    $pairIncome,
                    $tdsPercentage,
                    $serviceCharge
                );
            });

            $this->info('BV flushed and deducted successfully.');
            return 0;
        } catch (\Exception $e) {
            Log::error("BV Flush Error: " . $e->getMessage());
            $this->error('Error during BV flush: ' . $e->getMessage());
            return 1;
        }
    }

    protected function processUserBvFlush(User $user, $sealingLimitBv)
    {
        $leftChild = $user->leftChild;
        $rightChild = $user->rightChild;
        if (!$leftChild || !$rightChild) {
            return;
        }

        $leftBv = $leftChild->userBvs()
            ->whereNotIn('type', $this->protectedTypes)
            ->sum('bv_points');
        $rightBv = $rightChild->userBvs()
            ->whereNotIn('type', $this->protectedTypes)
            ->sum('bv_points');

        if ($leftBv >= $sealingLimitBv && $rightBv >= $sealingLimitBv) {
            // 1) Flush one sealing‐limit chunk from each side
            $this->flushSide($leftChild, $sealingLimitBv, 'left');
            $this->flushSide($rightChild, $sealingLimitBv, 'right');

            $leftBv -= $sealingLimitBv;
            $rightBv -= $sealingLimitBv;

            // 2) Now flush the *entire* smaller side, regardless of sealing‐limit
            if ($leftBv !== $rightBv) {
                if ($leftBv < $rightBv && $leftBv > 0) {
                    Log::info("Flushing entire remaining left side BV", [
                        'user_id' => $user->id,
                        'remaining_left_bv' => $leftBv,
                    ]);
                    $this->flushSide($leftChild, $leftBv, 'left');
                    $leftBv = 0;
                } elseif ($rightBv < $leftBv && $rightBv > 0) {
                    Log::info("Flushing entire remaining right side BV", [
                        'user_id' => $user->id,
                        'remaining_right_bv' => $rightBv,
                    ]);
                    $this->flushSide($rightChild, $rightBv, 'right');
                    $rightBv = 0;
                }
            }

            Log::info("Flush completed", [
                'remaining_left_bv' => $leftBv,
                'remaining_right_bv' => $rightBv,
            ]);
        } else {
            Log::info("No flush: Either side below sealing limit", [
                'left_bv' => $leftBv,
                'right_bv' => $rightBv,
                'sealing_limit' => $sealingLimitBv,
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
        $maximumPairIncome = get_static_option('maximum_pair_income') ?? PHP_INT_MAX;

        $matchingPairs = $this->calculateMatchingPairs($sealingLimitBv);
        $actualPairsToPay = min($matchingPairs, $dailyCeiling);

        $totalOutput = $matchingPairs * $pairIncome;
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

    protected function calculateMatchingPairs($sealingLimitBv)
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
            $pairs = floor(min($leftBv, $rightBv) / $sealingLimitBv);
            $matchingPairs += $pairs;
        }

        return $matchingPairs;
    }

    protected function recordUserPayoutDetails(
        int   $payoutSummaryId,
        float $sealingLimitBv,
        float $pairIncome,
        float $tdsPercentage,
        float $serviceCharge
    ) {
        // 1️⃣ daily cap
        $dailyPairLimit = (int) (get_static_option('sealing_limitation') ?? 1);
        $now           = now();
    
        // 2️⃣ users with both legs
        $users = User::with(['leftChild.userBvs', 'rightChild.userBvs'])
                     ->whereHas('leftChild')
                     ->whereHas('rightChild')
                     ->get();
    
        Log::info("Starting payout-detail recording. Users to process: {$users->count()}");
    
        foreach ($users as $user) {
            // 3️⃣ **Sum all net BV** under **this node’s entire left vs right** subtrees?
            //    → We’ll still log (or store) the total raw BV on each side for debugging if you like:
            $totalLeftBv   = $this->sumSubtreeBv($user->leftChild,  $now);
            $totalRightBv  = $this->sumSubtreeBv($user->rightChild, $now);
    
            // 4️⃣ **Count total matching pairs** by recursing through the tree
            $rawPairs = $this->countMatchingPairs($user, $sealingLimitBv, $now);
    
            // 5️⃣ Cap it
            $userPairs = min($rawPairs, $dailyPairLimit);
    
            // 6️⃣ dollar math stays the same…
            $grossPayout    = $userPairs * $pairIncome;
            $tdsDeduction   = $grossPayout * ($tdsPercentage  / 100);
            $serviceChargeAmt = $grossPayout * ($serviceCharge / 100);
            $netAmount      = max($grossPayout - $tdsDeduction - $serviceChargeAmt, 0);
    
            // 7️⃣ record
            UserPayoutDetail::create([
                'user_id'           => $user->id,
                'payout_summary_id' => $payoutSummaryId,
                'left_bv'           => $totalLeftBv,
                'right_bv'          => $totalRightBv,
                'matching_pairs'    => $userPairs,
                'payout_amount'     => $grossPayout,
                'tds_deduction'     => $tdsDeduction,
                'service_charge'    => $serviceChargeAmt,
                'net_amount'        => $netAmount,
                'status'            => $grossPayout > 0 ? 'payout_eligible' : 'no_payout',
            ]);
    
            Log::info("User {$user->id} payout detail:", compact(
                'totalLeftBv','totalRightBv','rawPairs','userPairs','grossPayout','netAmount'
            ));
        }
    
        Log::info("Payout detail recording completed.");
    }
    
    /**
     * Sum only one node’s BV records (not its whole subtree).
     */
    protected function sumNodeBv(?User $node, \Illuminate\Support\Carbon $cutoff): float
    {
        if (! $node) return 0;
        return (float) $node->userBvs()
            ->whereNotIn('type', $this->protectedTypes)
            ->where('created_at','<',$cutoff)
            ->sum('bv_points');
    }
    
    /**
     * (Optional) if you want to log/store the entire subtree’s BV total.
     */
    protected function sumSubtreeBv(?User $node, \Illuminate\Support\Carbon $cutoff): float
    {
        if (! $node) return 0;
        $total = $this->sumNodeBv($node, $cutoff);
        $total += $this->sumSubtreeBv($node->leftChild,  $cutoff);
        $total += $this->sumSubtreeBv($node->rightChild, $cutoff);
        return $total;
    }
    
    /**
     * Recursively count **1 direct pair** at this node +
     * all pairs in its left‐ & right‐child subtrees.
     */
    protected function countMatchingPairs(?User $user, float $limit, \Illuminate\Support\Carbon $cutoff): int
    {
        if (! $user) return 0;
    
        // how much BV sits *directly* under each immediate child?
        $L = $this->sumNodeBv($user->leftChild,  $cutoff);
        $R = $this->sumNodeBv($user->rightChild, $cutoff);
    
        // ① direct pair here?
        $direct = ($L >= $limit && $R >= $limit) ? 1 : 0;
    
        // ② plus whatever their sub‐subtrees hold
        $leftPairs  = $this->countMatchingPairs($user->leftChild,  $limit, $cutoff);
        $rightPairs = $this->countMatchingPairs($user->rightChild, $limit, $cutoff);
    
        return $direct + $leftPairs + $rightPairs;
    }
}