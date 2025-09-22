<?php

namespace App\Services;

use App\Models\LevelCommission;
use App\Models\LevelCommissionHistory;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LevelCommissionService
{

    public static function process($order)
    {
        try {
            if (! $order) {
                Log::warning('[LevelCommission] no order provided');
                return;
            }

            $totalBv = null;
            if (isset($order->total_bv)) {
                $totalBv = (float) $order->total_bv;
            } elseif (isset($order->totalBV)) {
                $totalBv = (float) $order->totalBV;
            } else {
                $totalBv = (float) ($order->total_bv ?? 0);
            }

            if ($totalBv <= 0) {
                Log::info("[LevelCommission] order {$order->id} total BV is zero or missing — skipping.");
                return;
            }

            $rules = LevelCommission::all(); 

            if ($rules->isEmpty()) {
                Log::info("[LevelCommission] no commission rules found — skipping processing for order {$order->id}.");
                return;
            }

            $rulesTransformed = $rules->map(function ($r) {
                preg_match('/^(\d+)/', trim((string)$r->level_name), $m);
                $levelNum = isset($m[1]) ? (int)$m[1] : 0;

                return (object)[
                    'original' => $r,
                    'level' => $levelNum,
                    'percentage' => (float) ($r->commission ?? $r->percentage ?? 0),
                ];
            })->filter(fn($x) => $x->level > 0)
              ->sortBy('level')
              ->values(); 

            if ($rulesTransformed->isEmpty()) {
                Log::info("[LevelCommission] no valid numeric level rules found — skipping order {$order->id}.");
                return;
            }

            $purchaser = $order->user ?? null;
            if (! $purchaser && ! empty($order->user_id)) {
                $purchaser = User::find($order->user_id);
            }

            if (! $purchaser) {
                Log::warning("[LevelCommission] purchaser not found for order {$order->id} (user_id: {$order->user_id})");
                return;
            }

            $already = LevelCommissionHistory::where('order_id', $order->id)->exists();
            if ($already) {
                Log::info("[LevelCommission] order {$order->id} already processed (history exists) — skipping.");
                return;
            }

            DB::transaction(function () use ($order, $purchaser, $rulesTransformed, $totalBv) {
                $currentUplineId = $purchaser->sponsor_id ?? null;

                foreach ($rulesTransformed as $ruleObj) {
                    $levelNumber = (int) $ruleObj->level;
                    $percentage = (float) $ruleObj->percentage;

                    if (! $currentUplineId) {
                        Log::info("[LevelCommission] no further upline (stopped before level {$levelNumber}) for purchaser {$purchaser->id}");
                        break;
                    }

                    $upline = User::find($currentUplineId);
                    if (! $upline) {
                        Log::info("[LevelCommission] upline (id: {$currentUplineId}) not found — stopping.");
                        break;
                    }

                    if ($percentage <= 0) {
                        $currentUplineId = $upline->sponsor_id ?? null;
                        continue;
                    }

                    $bvToAdd = round(($totalBv * $percentage) / 100, 2);
                    if ($bvToAdd <= 0) {
                        $currentUplineId = $upline->sponsor_id ?? null;
                        continue;
                    }

                    DB::table('users')->where('id', $upline->id)->increment('self_purchased_bv', $bvToAdd);

                    LevelCommissionHistory::create([
                        'order_id' => $order->id,
                        'purchaser_id' => $purchaser->id,
                        'upline_id' => $upline->id,
                        'level' => $levelNumber,
                        'percentage' => $percentage,
                        'bv_added' => $bvToAdd,
                    ]);

                    Log::info("[LevelCommission] order {$order->id} - level {$levelNumber}: added {$bvToAdd} BV to user {$upline->id} ({$percentage}%)");

                    $currentUplineId = $upline->sponsor_id ?? null;
                }
            });

            Log::info("[LevelCommission] finished processing order {$order->id}");
        } catch (\Throwable $ex) {
            Log::error("[LevelCommission] error processing order " . ($order->id ?? 'unknown') . " : " . $ex->getMessage(), [
                'trace' => $ex->getTraceAsString()
            ]);
        }
    }
}
