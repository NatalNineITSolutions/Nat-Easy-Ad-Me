<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\UserBv;
use Illuminate\Support\Facades\Log;

class AutoFlushBV extends Command
{
    protected $signature = 'bv:flush';
    protected $description = 'Flush extra BV based on sealing limit at scheduled time';

    public function handle()
    {
        $flushTime = get_static_option('bv_flush_time');
        $now = now()->setTimezone(config('app.timezone'))->format('H:i:s');
        
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
        if (!$childUser) return;

        // Create new BV record with remaining points
        $childUser->userBvs()->create([
            'bv_points' => $remainingBv,
            'type' => 'post_flush',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}