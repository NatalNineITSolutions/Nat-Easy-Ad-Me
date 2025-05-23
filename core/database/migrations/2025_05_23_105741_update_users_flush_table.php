<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_flush', function (Blueprint $table) {
            // Drop foreign key constraints before dropping columns
            if (Schema::hasColumn('users_flush', 'payout_summary_id')) {
                $table->dropForeign(['payout_summary_id']);
                $table->dropColumn('payout_summary_id');
            }
            if (Schema::hasColumn('users_flush', 'left_bv_flushed_id')) {
                $table->dropForeign(['left_bv_flushed_id']);
                $table->dropColumn('left_bv_flushed_id');
            }
            if (Schema::hasColumn('users_flush', 'right_bv_flushed_id')) {
                $table->dropForeign(['right_bv_flushed_id']);
                $table->dropColumn('right_bv_flushed_id');
            }

            // Add new column user_bv_flushed next to user_id
            if (! Schema::hasColumn('users_flush', 'user_bv_flushed')) {
                $table->unsignedBigInteger('user_bv_flushed')->default(0)->after('user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_flush', function (Blueprint $table) {
            // Remove the new column
            if (Schema::hasColumn('users_flush', 'user_bv_flushed')) {
                $table->dropColumn('user_bv_flushed');
            }

            // Re-add dropped columns and foreign keys if necessary
            if (! Schema::hasColumn('users_flush', 'payout_summary_id')) {
                $table->unsignedBigInteger('payout_summary_id')->nullable();
                $table->foreign('payout_summary_id')->references('id')->on('payout_summaries')->onDelete('cascade');
            }
            if (! Schema::hasColumn('users_flush', 'left_bv_flushed_id')) {
                $table->unsignedBigInteger('left_bv_flushed_id')->nullable();
                $table->foreign('left_bv_flushed_id')->references('id')->on('bv_flushes')->onDelete('cascade');
            }
            if (! Schema::hasColumn('users_flush', 'right_bv_flushed_id')) {
                $table->unsignedBigInteger('right_bv_flushed_id')->nullable();
                $table->foreign('right_bv_flushed_id')->references('id')->on('bv_flushes')->onDelete('cascade');
            }
        });
    }
};
