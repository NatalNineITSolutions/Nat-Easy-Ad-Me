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
            if (Schema::hasColumn('users_flush', 'payout_summary_id')) {
                $table->dropColumn('payout_summary_id');
            }
            if (Schema::hasColumn('users_flush', 'flush_type')) {
                $table->dropColumn('flush_type');
            }

            if (!Schema::hasColumn('users_flush', 'user_bv_flushed')) {
                $table->text('user_bv_flushed')->nullable(); // or use ->json() if storing structured data
            }
        });
    }

    public function down()
    {
        Schema::table('users_flush', function (Blueprint $table) {
            $table->unsignedBigInteger('payout_summary_id')->nullable();
            $table->string('flush_type')->nullable();
            $table->dropColumn('user_bv_flushed');
        });
    }
};
