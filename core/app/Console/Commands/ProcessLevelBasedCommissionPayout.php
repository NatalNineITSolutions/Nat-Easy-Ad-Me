<?php

namespace App\Console\Commands;

use App\Models\LevelCommissionHistory;
use App\Models\LevelBasedCommissionPayout;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProcessLevelBasedCommissionPayout extends Command
{
    protected $signature = 'payout:level-based {--dry-run}';
    protected $description = 'Process level-based commission payouts (flush BV to uplines with TDS & Service Charge deduction).';

    public function handle()
    {
        $this->info('Starting level-based commission payout process...');
        Log::info('[Payout] Starting level-based commission payout');

        $bvFlushTime = get_static_option('bv_flush_time') ?? '16.21'; 
        $parts = explode('.', $bvFlushTime);
        $flushHour = (int) ($parts[0] ?? 0);
        $flushMinute = (int) ($parts[1] ?? 0);

        $now = now();
        $scheduledTime = now()->setHour($flushHour)->setMinute($flushMinute)->setSecond(0);

        if ($now < $scheduledTime) {
            $this->info('Payout time has not yet arrived. Next payout is at ' . $scheduledTime->format('H:i'));
            Log::info('[Payout] Attempted to run before scheduled time.');
            return 0;
        }

        $unpaid = LevelCommissionHistory::whereNull('payout_id')
            ->where('is_paid', false)
            ->get();

        if ($unpaid->isEmpty()) {
            $this->info('No unpaid level commission histories found.');
            Log::info('[Payout] No unpaid level commission histories');
            return 0;
        }

        $grouped = $unpaid->groupBy('upline_id');

        $paymentType = 'manual';

        $tdsRaw = get_static_option('tds_value');
        $serviceRaw = get_static_option('service_charge');

        $tdsPercent = is_numeric($tdsRaw) ? (float) $tdsRaw : 0;
        $serviceChargePercent = is_numeric($serviceRaw) ? (float) $serviceRaw : 0;
        $totalDeductionPercent = $tdsPercent + $serviceChargePercent;

        Log::info("[Payout] TDS: {$tdsPercent}%, Service Charge: {$serviceChargePercent}%, Total Deduction: {$totalDeductionPercent}%");

        $this->info('Found ' . $unpaid->count() . ' unpaid history records for ' . $grouped->count() . ' uplines.');
        Log::info("[Payout] Preparing payouts batch , uplines: {$grouped->count()}");

        DB::transaction(function () use ($grouped, $paymentType, $totalDeductionPercent, $tdsPercent, $serviceChargePercent) {
            foreach ($grouped as $uplineId => $histories) {
                if (empty($uplineId)) {
                    Log::warning("[Payout] Skipping group with empty upline id (found {$histories->count()} histories)");
                    continue;
                }

                $totalBv = $histories->sum('bv_added');

                $deductionAmount = ($totalBv * $totalDeductionPercent) / 100;
                $payoutAmount = $totalBv - $deductionAmount;

                $payout = LevelBasedCommissionPayout::create([
                    'user_id' => $uplineId,
                    'total_bv' => $totalBv,
                    'payout_amount' => $payoutAmount,
                    'tds_percent' => $tdsPercent,
                    'service_charge_percent' => $serviceChargePercent,
                    'details' => [
                        'history_ids' => $histories->pluck('id')->toArray(),
                        'count' => $histories->count(),
                        'deduction_amount' => $deductionAmount,
                    ],
                    'payment_type' => $paymentType,
                    'payout_date' => now(),
                ]);

                LevelCommissionHistory::whereIn('id', $histories->pluck('id')->toArray())
                    ->update([
                        'payout_id' => $payout->id,
                        'is_paid' => true,
                    ]);

                Log::info("[Payout] Created payout #{$payout->id} for upline #{$uplineId}, total BV: {$totalBv}, payout: {$payoutAmount}");
            }
        });

        $this->info('Level-based commission payout process completed.');
        Log::info('[Payout] Completed batch');

        return 0;
    }

}
