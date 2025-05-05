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
            // Only drop columns if they exist
            if (Schema::hasColumn('users', 'bv_points')) {
                $table->dropColumn('bv_points');
            }
            if (Schema::hasColumn('users', 'left_bv')) {
                $table->dropColumn('left_bv');
            }
            if (Schema::hasColumn('users', 'right_bv')) {
                $table->dropColumn('right_bv');
            }
            if (Schema::hasColumn('users', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
            if (Schema::hasColumn('users', 'flushed_left_bv')) {
                $table->dropColumn('flushed_left_bv');
            }
            if (Schema::hasColumn('users', 'flushed_right_bv')) {
                $table->dropColumn('flushed_right_bv');
            }
            if (Schema::hasColumn('users', 'last_flush_date')) {
                $table->dropColumn('last_flush_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'bv_points')) {
                $table->integer('bv_points')->default(0);
            }
            if (!Schema::hasColumn('users', 'left_bv')) {
                $table->integer('left_bv')->default(0);
            }
            if (!Schema::hasColumn('users', 'right_bv')) {
                $table->integer('right_bv')->default(0);
            }
            if (!Schema::hasColumn('users', 'deleted_at')) {
                $table->softDeletes();
            }
            if (!Schema::hasColumn('users', 'flushed_left_bv')) {
                $table->integer('flushed_left_bv')->default(0);
            }
            if (!Schema::hasColumn('users', 'flushed_right_bv')) {
                $table->integer('flushed_right_bv')->default(0);
            }
            if (!Schema::hasColumn('users', 'last_flush_date')) {
                $table->date('last_flush_date')->nullable();
            }
        });
    }
};
