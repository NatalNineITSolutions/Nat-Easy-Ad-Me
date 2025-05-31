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
        if (Schema::hasTable('user_flush_bvs') && ! Schema::hasColumn('user_flush_bvs', 'eligible_pairs')) {
            Schema::table('user_flush_bvs', function (Blueprint $table) {
                // Add an integer column named `eligible_pairs` with default 0.
                // Place it after `right_bv` (or adjust ->after(...) as needed).
                $table->integer('eligible_pairs')->default(0)->after('right_bv');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * This will drop the `eligible_pairs` column if it exists.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('user_flush_bvs') && Schema::hasColumn('user_flush_bvs', 'eligible_pairs')) {
            Schema::table('user_flush_bvs', function (Blueprint $table) {
                $table->dropColumn('eligible_pairs');
            });
        }
    }
};
