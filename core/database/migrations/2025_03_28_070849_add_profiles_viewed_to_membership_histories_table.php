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
        Schema::table('membership_histories', function (Blueprint $table) {
            $table->unsignedInteger('profiles_viewed')
                  ->default(0)
                  ->after('profile_limit')
                  ->comment('Count of profiles viewed under this subscription');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('membership_histories', function (Blueprint $table) {
            $table->dropColumn('profiles_viewed');
        });
    }
};
