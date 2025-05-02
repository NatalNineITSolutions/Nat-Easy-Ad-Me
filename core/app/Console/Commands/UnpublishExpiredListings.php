<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Backend\Listing;

class UnpublishExpiredListings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'listings:unpublish-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiryDays = get_static_option('listing_expiry_days') ?? 28;

        Listing::where('is_published', 1)
            ->whereNotNull('published_at')
            ->whereDate('published_at', '<=', now()->subDays($expiryDays))
            ->update(['is_published' => 0]);

        \Log::info('Expired listings unpublished.');
    }

}
