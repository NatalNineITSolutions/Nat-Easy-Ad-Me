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

        // Only process if both legs exist
        if (!$leftChild || !$rightChild) {
            return;
        }

        // Get current BV points excluding protected types
        $leftBv = $leftChild->userBvs()
            ->where('bv_points', '>', 0)
            ->whereNotIn('type', $this->protectedTypes)
            ->sum('bv_points');
            
        $rightBv = $rightChild->userBvs()
            ->where('bv_points', '>', 0)
            ->whereNotIn('type', $this->protectedTypes)
            ->sum('bv_points');

        // Calculate flushable pairs (common multiples of sealing limit)
        $flushablePairs = floor(min($leftBv, $rightBv) / $sealingLimitBv);

        if ($flushablePairs > 0) {
            $totalFlushAmount = $flushablePairs * $sealingLimitBv;

            // Create deduction records (negative BV)
            $leftChild->userBvs()->create([
                'bv_points' => -$totalFlushAmount,
                'type' => 'flush_deduction',
                'description' => 'BV flush at ' . now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $rightChild->userBvs()->create([
                'bv_points' => -$totalFlushAmount,
                'type' => 'flush_deduction',
                'description' => 'BV flush at ' . now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Log::info("BV Flush Completed", [
                'user_id' => $user->id,
                'left_bv_before' => $leftBv,
                'right_bv_before' => $rightBv,
                'flushed_amount' => $totalFlushAmount,
                'left_remaining' => $leftBv - $totalFlushAmount,
                'right_remaining' => $rightBv - $totalFlushAmount
            ]);
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

            $matchingPairs += floor(min($leftBv, $rightBv) / $sealingLimitBv);
        }

        return $matchingPairs;
    }

    protected function recordUserPayoutDetails($payoutSummaryId, $sealingLimitBv, $pairIncome, $tdsPercentage, $serviceCharge)
    {
        $users = User::with(['leftChild.userBvs', 'rightChild.userBvs'])
            ->whereHas('leftChild')
            ->whereHas('rightChild')
            ->get();

        Log::info("Starting payout detail recording. Total users: " . $users->count());

        foreach ($users as $user) {
            $leftChild = $user->leftChild;
            $rightChild = $user->rightChild;

            // Get BV before flush operation (excluding protected types)
            $leftBv = $leftChild?->userBvs()
                ->where('bv_points', '>', 0)
                ->whereNotIn('type', $this->protectedTypes)
                ->where('created_at', '<', now())
                ->sum('bv_points') ?? 0;
                
            $rightBv = $rightChild?->userBvs()
                ->where('bv_points', '>', 0)
                ->whereNotIn('type', $this->protectedTypes)
                ->where('created_at', '<', now())
                ->sum('bv_points') ?? 0;

            $userPairs = floor(min($leftBv, $rightBv) / $sealingLimitBv);
            $userPayout = $userPairs * $pairIncome;

            // Calculate deductions
            $tdsDeduction = $userPayout * ($tdsPercentage / 100);
            $serviceChargeAmount = $userPayout * ($serviceCharge / 100);
            $netAmount = $userPayout > 0 ? ($userPayout - $tdsDeduction - $serviceChargeAmount) : 0;

            // Create payout detail record regardless of payout amount
            UserPayoutDetail::create([
                'user_id' => $user->id,
                'payout_summary_id' => $payoutSummaryId,
                'left_bv' => $leftBv,
                'right_bv' => $rightBv,
                'matching_pairs' => $userPairs,
                'payout_amount' => $userPayout,
                'tds_deduction' => $tdsDeduction,
                'service_charge' => $serviceChargeAmount,
                'net_amount' => $netAmount,
                'status' => $userPayout > 0 ? 'processed' : 'no_payout'
            ]);

            Log::info("User Payout Detail Created", [
                'user_id' => $user->id,
                'left_bv' => $leftBv,
                'right_bv' => $rightBv,
                'pairs' => $userPairs,
                'payout' => $userPayout,
                'net_amount' => $netAmount
            ]);
        }

        Log::info("Payout detail recording completed.");
    }
}