<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users_flush', function (Blueprint $table) {
            // only add if it doesn’t already exist
            if (! Schema::hasColumn('users_flush', 'payout_summary_id')) {
                $table->unsignedBigInteger('payout_summary_id')->nullable()->after('user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users_flush', function (Blueprint $table) {
            if (Schema::hasColumn('users_flush', 'payout_summary_id')) {
                $table->dropForeign(['payout_summary_id']);
                $table->dropColumn('payout_summary_id');
            }
        });
    }
};
