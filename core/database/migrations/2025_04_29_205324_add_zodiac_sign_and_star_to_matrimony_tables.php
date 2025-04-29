<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profile_listings', function (Blueprint $table) {
            $table->string('zodiac_sign')->nullable()->after('id');
            $table->string('star')->nullable()->after('zodiac_sign');
        });

        Schema::table('matrimony_kyc', function (Blueprint $table) {
            $table->string('zodiac_sign')->nullable()->after('id');
            $table->string('star')->nullable()->after('zodiac_sign');
        });

        Schema::table('matrimony_preferences', function (Blueprint $table) {
            $table->string('zodiac_sign')->nullable()->after('id');
            $table->string('star')->nullable()->after('zodiac_sign');
        });
    }

    public function down(): void
    {
        Schema::table('profile_listings', function (Blueprint $table) {
            $table->dropColumn(['zodiac_sign', 'star']);
        });

        Schema::table('matrimony_kyc', function (Blueprint $table) {
            $table->dropColumn(['zodiac_sign', 'star']);
        });

        Schema::table('matrimony_preferences', function (Blueprint $table) {
            $table->dropColumn(['zodiac_sign', 'star']);
        });
    }
};
