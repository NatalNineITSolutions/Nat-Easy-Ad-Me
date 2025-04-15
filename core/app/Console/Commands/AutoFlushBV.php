<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\User;
use App\Models\UsersBv;
use App\Models\IncomePayoutManage;
use Illuminate\Support\Facades\Log;

class AutoFlushBV extends Command
{
    protected $signature = 'bv:flush';
    protected $description = 'Flush extra BV based on sealing limit at scheduled time';

    public function handle()
    {
        $flushTime = get_static_option('bv_flush_time');
        $now = now()->setTimezone(config('app.timezone'))->format('H:i');

        Log::info("Checking for BV flush. Now: $now, Configured: $flushTime");

        if ($now === $flushTime) {
            $bpConversionRate = get_static_option('bp_value') ?? 1;
            $sealingLimit = get_static_option('sealing_limit') ?? 1;
            $sealingLimitBv = $sealingLimit * $bpConversionRate;

            User::with(['leftChild.userBvs', 'rightChild.userBvs'])
                ->chunk(200, function ($users) use ($sealingLimitBv) {
                    foreach ($users as $user) {
                        $this->processUserBvFlush($user, $sealingLimitBv);
                    }
                });
            $this->recordPayoutSummary($sealingLimitBv);

            $this->info('BV flushed and deducted successfully.');
        } else {
            $this->info("No flush — it's not time yet.");
        }

        return 0;
    }

    protected function processUserBvFlush(User $user, $sealingLimitBv)
    {
        // Calculate current BV from relationships
        $leftBv = $user->leftChild ? $user->leftChild->userBvs->sum('bv_points') : 0;
        $rightBv = $user->rightChild ? $user->rightChild->userBvs->sum('bv_points') : 0;

        // Store original values for logging
        $originalLeft = $leftBv;
        $originalRight = $rightBv;

        // Apply sealing logic
        if ($leftBv >= $sealingLimitBv && $rightBv >= $sealingLimitBv) {
            $leftBv -= $sealingLimitBv;
            $rightBv -= $sealingLimitBv;
        }

        $remainingLeftBv = floor($leftBv / $sealingLimitBv) * $sealingLimitBv;
        $remainingRightBv = floor($rightBv / $sealingLimitBv) * $sealingLimitBv;

        // Create new BV records with remaining points
        $this->updateBvRecords($user->leftChild, $remainingLeftBv);
        $this->updateBvRecords($user->rightChild, $remainingRightBv);

        Log::info("BV flushed for user ID: {$user->id}", [
            'original' => ['left' => $originalLeft, 'right' => $originalRight],
            'remaining' => ['left' => $remainingLeftBv, 'right' => $remainingRightBv],
            'flushed' => [
                'left' => $originalLeft - $remainingLeftBv,
                'right' => $originalRight - $remainingRightBv
            ]
        ]);
    }

    protected function updateBvRecords($childUser, $remainingBv)
    {
        if (!$childUser)
            return;

        // Create new BV record with remaining points
        $childUser->userBvs()->create([
            'bv_points' => $remainingBv,
            'type' => 'post_flush',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    protected function recordPayoutSummary($sealingLimitBv)
    {
        // Prevent duplicate records for the same day
        if (IncomePayoutManage::whereDate('payout_date', Carbon::today())->exists()) {
            Log::warning('Payout record already exists for ' . Carbon::today()->toDateString());
            return;
        }

        // Get today's BV points
        $currentDayBV = UsersBv::whereDate('created_at', Carbon::today())->sum('bv_points');

        // Get system configuration
        $pairIncome = get_static_option('pair_income') ?? 300;
        $dailyCeiling = get_static_option('sealing_limit') ?? 10;
        $maximumPairIncome = get_static_option('maximum_pair_income') ?? PHP_INT_MAX;

        // Calculate matching pairs
        $matchingPairs = $this->calculateMatchingPairs($sealingLimitBv);
        $actualPairsToPay = min($matchingPairs, $dailyCeiling);

        // Calculate payout amounts
        $totalOutput = $actualPairsToPay * $pairIncome;
        $totalOutput = min($totalOutput, $maximumPairIncome);

        // Get previous balance and calculate new balance
        $previousRecord = IncomePayoutManage::latest()->first();
        $previousBalance = $previousRecord ? $previousRecord->balance_case_on_hand : 0;
        $newBalance = ($currentDayBV + $previousBalance) - $totalOutput;

        // Create the payout record
        $payoutRecord = IncomePayoutManage::create([
            'payout_date' => now()->toDateString(),
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
            'date' => now()->toDateString(),
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
            $leftBv = $user->leftChild ? $user->leftChild->userBvs->sum('bv_points') : 0;
            $rightBv = $user->rightChild ? $user->rightChild->userBvs->sum('bv_points') : 0;

            $matchingPairs += floor(min($leftBv, $rightBv) / $sealingLimitBv);
        }

        return $matchingPairs;
    }
}