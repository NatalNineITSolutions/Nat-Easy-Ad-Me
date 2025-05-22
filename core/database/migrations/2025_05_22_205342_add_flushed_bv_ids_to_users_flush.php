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
            $table->unsignedBigInteger('left_bv_flushed_id')->nullable()->after('flushed_left_bv');
            $table->unsignedBigInteger('right_bv_flushed_id')->nullable()->after('left_bv_flushed_id');
            
            $table->foreign('left_bv_flushed_id')
                  ->references('id')->on('users_bvs')
                  ->onDelete('set null');
            $table->foreign('right_bv_flushed_id')
                  ->references('id')->on('users_bvs')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('users_flush', function (Blueprint $table) {
            $table->dropForeign(['left_bv_flushed_id']);
            $table->dropForeign(['right_bv_flushed_id']);
            $table->dropColumn(['left_bv_flushed_id', 'right_bv_flushed_id']);
        });
    }
};
