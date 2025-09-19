<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Branch;
use App\Models\BranchCommission;
use App\Models\BranchPayout;

class BranchPayoutCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'branch:payout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate branch payout requests every 28 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $branches = Branch::all();

        foreach ($branches as $branch) {
            $commission = BranchCommission::where('branch_id', $branch->id)
                ->where('status', 'earned')
                ->sum('commission_amount');

            if ($commission > 0) {
                BranchPayout::create([
                    'branch_id'        => $branch->id,
                    'total_commission' => $commission,
                    'status'           => 'pending', // default
                ]);

                $this->info("Payout request created for branch #{$branch->id}");
            }
        }

        return Command::SUCCESS;
    }
}
