<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('user_flush_bvs', function (Blueprint $table) {
            // Add eligible_pairs as an unsigned tiny integer (or change to integer if you expect bigger values)
            $table->unsignedInteger('eligible_pairs')->default(0)->after('right_bv');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_flush_bvs', function (Blueprint $table) {
            $table->dropColumn('eligible_pairs');
        });
    }
};
