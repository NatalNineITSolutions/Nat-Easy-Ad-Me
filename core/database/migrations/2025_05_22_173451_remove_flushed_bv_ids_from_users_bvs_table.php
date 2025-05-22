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
        Schema::table('users_bvs', function (Blueprint $table) {
            if (Schema::hasColumn('users_bvs', 'flushed_bv_ids')) {
                $table->dropColumn('flushed_bv_ids');
            }
        });
    }

    public function down()
    {
        Schema::table('users_bvs', function (Blueprint $table) {
            $table->text('flushed_bv_ids')->nullable(); // Adjust type as needed
        });
    }
};
