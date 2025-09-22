<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('bv:flush')->dailyAt(get_static_option('bv_flush_time'));
        $schedule->command('payout:level-based')
            ->dailyAt(get_static_option('bv_flush_time'))
            ->withoutOverlapping();
        $schedule->command('listings:unpublish-expired')->daily();

        $schedule->command('branch:payout')->cron('0 0 */28 * *');
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

