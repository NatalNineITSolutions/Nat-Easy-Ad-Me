<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->enum('visibility_type', ['radius', 'city', 'district', 'state'])
                ->default('radius')
                ->after('radius_km');

            $table->string('city_name', 191)->nullable()->after('visibility_type');
            $table->string('district_name', 191)->nullable()->after('city_name');
            $table->string('state_name', 191)->nullable()->after('district_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropColumn([
                'visibility_type',
                'city_name',
                'district_name',
                'state_name',
            ]);
        });
    }
};
