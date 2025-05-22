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
            // JSON is a good fit for storing an array of IDs
            $table->json('flushed_bv_ids')
                  ->nullable()
                  ->after('type');
        });
    }

    public function down()
    {
        Schema::table('users_bvs', function (Blueprint $table) {
            $table->dropColumn('flushed_bv_ids');
        });
    }
};
