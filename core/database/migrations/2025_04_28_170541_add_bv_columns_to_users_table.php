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
            $table->integer('left_bv')->default(0)->after('remember_token');
            $table->integer('right_bv')->default(0)->after('left_bv');
            $table->timestamp('last_flush_date')->nullable()->after('flushed_right_bv');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'left_bv',
                'right_bv',
                'last_flush_date',
            ]);
        });
    }
};
