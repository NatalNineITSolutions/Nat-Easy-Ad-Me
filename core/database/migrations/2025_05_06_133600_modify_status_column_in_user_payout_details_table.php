<?php

// Run in terminal to generate the migration:
// php artisan make:migration modify_status_column_in_user_payout_details_table --table=user_payout_details

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Note: Requires doctrine/dbal (composer require doctrine/dbal).
     * @return void
     */
    public function up()
    {
        // Only modify if the column exists
        if (Schema::hasColumn('user_payout_details', 'status')) {
            // 1) Clean up any values not in the new enum
            DB::table('user_payout_details')
                ->whereNotIn('status', ['no_payout', 'payout_eligible', 'payout_completed'])
                ->update(['status' => 'no_payout']);

            // 2) Apply the enum modification
            Schema::table('user_payout_details', function (Blueprint $table) {
                $table->enum('status', ['no_payout', 'payout_eligible', 'payout_completed'])
                      ->default('no_payout')
                      ->comment('no_payout, payout_eligible, payout_completed')
                      ->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('user_payout_details', 'status')) {
            Schema::table('user_payout_details', function (Blueprint $table) {
                $table->string('status', 50)
                      ->default('no_payout')
                      ->change();
            });
        }
    }
};
