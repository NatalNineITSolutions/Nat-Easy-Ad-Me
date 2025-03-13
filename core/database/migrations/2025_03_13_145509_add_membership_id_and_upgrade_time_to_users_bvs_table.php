<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users_bvs', function (Blueprint $table) {
            $table->unsignedBigInteger('membership_id')->after('user_id');
            $table->timestamp('upgrade_time')->nullable()->after('bv_points'); 

            $table->foreign('membership_id')->references('id')->on('memberships')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('users_bvs', function (Blueprint $table) {
            $table->dropForeign(['membership_id']);
            $table->dropColumn(['membership_id', 'upgrade_time']);
        });
    }
};
