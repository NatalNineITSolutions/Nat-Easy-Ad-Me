<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('membership_id')->default(1)->after('password'); // Default to Free membership
            $table->integer('bv_points')->default(0)->after('membership_id'); // Default BV points = 0

            // Foreign key constraint
            $table->foreign('membership_id')->references('id')->on('memberships')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['membership_id']);
            $table->dropColumn(['membership_id', 'bv_points']);
        });
    }
};
