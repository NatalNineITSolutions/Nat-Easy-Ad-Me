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
        // Add columns if they don't already exist
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'left_bv')) {
                $table->integer('left_bv')->default(0)->after('remember_token');
            }
            if (!Schema::hasColumn('users', 'right_bv')) {
                $table->integer('right_bv')->default(0)->after('left_bv');
            }
            // If flushed_right_bv column exists, add after it, otherwise append at the end
            if (!Schema::hasColumn('users', 'last_flush_date')) {
                if (Schema::hasColumn('users', 'flushed_right_bv')) {
                    $table->timestamp('last_flush_date')->nullable()->after('flushed_right_bv');
                } else {
                    $table->timestamp('last_flush_date')->nullable();
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'left_bv')) {
                $table->dropColumn('left_bv');
            }
            if (Schema::hasColumn('users', 'right_bv')) {
                $table->dropColumn('right_bv');
            }
            if (Schema::hasColumn('users', 'last_flush_date')) {
                $table->dropColumn('last_flush_date');
            }
        });
    }
};
