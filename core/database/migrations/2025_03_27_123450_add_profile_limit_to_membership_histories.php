<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('membership_histories', function (Blueprint $table) {
            $table->integer('profile_limit')->default(0)->after('listing_limit');
        });
    }

    public function down()
    {
        Schema::table('membership_histories', function (Blueprint $table) {
            $table->dropColumn('profile_limit');
        });
    }
};
