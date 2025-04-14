<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
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

            User::each(function ($user) use ($sealingLimitBv) {
                $leftBv = $user->left_bv ?? 0;
                $rightBv = $user->right_bv ?? 0;

                // Step 1: Deduct one sealing limit if both sides meet it
                if ($leftBv >= $sealingLimitBv && $rightBv >= $sealingLimitBv) {
                    $leftBv -= $sealingLimitBv;
                    $rightBv -= $sealingLimitBv;
                }

                // Step 2: Keep only multiples of sealingLimitBv
                $remainingLeftBv = floor($leftBv / $sealingLimitBv) * $sealingLimitBv;
                $remainingRightBv = floor($rightBv / $sealingLimitBv) * $sealingLimitBv;

                // Step 3: Calculate flushed BVs
                $flushedLeft = $leftBv - $remainingLeftBv;
                $flushedRight = $rightBv - $remainingRightBv;

                $user->update([
                    'left_bv' => $remainingLeftBv,
                    'right_bv' => $remainingRightBv,
                ]);

                Log::info("BV flushed for user ID: {$user->id}", [
                    'flushedLeft' => $flushedLeft,
                    'flushedRight' => $flushedRight,
                    'remainingLeft' => $remainingLeftBv,
                    'remainingRight' => $remainingRightBv,
                ]);
            });

            $this->info('BV flushed and deducted successfully.');
        } else {
            $this->info("No flush — it's not time yet.");
        }

        return 0;
    }
}

