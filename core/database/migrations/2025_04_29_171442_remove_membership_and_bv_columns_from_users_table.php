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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'bv_points',
                'left_bv',
                'right_bv',
                'deleted_at',
                'flushed_left_bv',
                'flushed_right_bv',
                'last_flush_date'
            ]);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('bv_points')->default(0);
            $table->integer('left_bv')->default(0);
            $table->integer('right_bv')->default(0);
            $table->softDeletes(); // Adds 'deleted_at'
            $table->integer('flushed_left_bv')->default(0);
            $table->integer('flushed_right_bv')->default(0);
            $table->date('last_flush_date')->nullable();
        });
    }
};
