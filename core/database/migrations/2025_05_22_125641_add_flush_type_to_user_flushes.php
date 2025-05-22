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
        Schema::table('users_flush', function (Blueprint $table) {
            $table->enum('flush_type', ['bv', 'payout'])
                ->after('payout_summary_id')
                ->default('bv');
        });
    }

    public function down()
    {
        Schema::table('user_flushes', function (Blueprint $table) {
            $table->dropColumn('flush_type');
        });
    }
};
