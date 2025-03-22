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
        Schema::table('profile_listings', function (Blueprint $table) {
            $table->boolean('is_verified')->default(0)->after('description'); // Replace 'column_name' with the correct column after which you want to add 'is_verified'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profile_listings', function (Blueprint $table) {
            $table->dropColumn('is_verified');
        });
    }
};
