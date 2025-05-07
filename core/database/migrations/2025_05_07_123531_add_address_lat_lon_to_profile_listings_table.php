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
        Schema::table('profile_listings', function (Blueprint $table) {
            if (!Schema::hasColumn('profile_listings', 'address')) {
                $table->string('address')->nullable();
            }
            if (!Schema::hasColumn('profile_listings', 'lat')) {
                $table->decimal('lat', 10, 7)->nullable();
            }
            if (!Schema::hasColumn('profile_listings', 'lon')) {
                $table->decimal('lon', 10, 7)->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('profile_listings', function (Blueprint $table) {
            $table->dropColumn(['address', 'lat', 'lon']);
        });
    }
};
