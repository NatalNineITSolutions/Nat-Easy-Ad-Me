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
        Schema::table('matrimony_kyc', function (Blueprint $table) {
            if (!Schema::hasColumn('matrimony_kyc', 'user_id')) {
                $table->unsignedBigInteger('user_id')->after('id'); // Ensure user_id exists
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('matrimony_kyc', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
};
