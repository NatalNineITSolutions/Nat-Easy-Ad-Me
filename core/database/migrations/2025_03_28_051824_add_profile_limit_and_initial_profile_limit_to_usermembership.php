<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        Schema::table('user_memberships', function (Blueprint $table) {
            $table->integer('initial_profile_limit')->default(0)->after('initial_listing_limit');
            $table->integer('profile_limit')->default(0)->after('listing_limit');
        });
    }

    public function down() {
        Schema::table('user_memberships', function (Blueprint $table) {
            $table->dropColumn(['initial_profile_limit', 'profile_limit']);
        });
    }
};
