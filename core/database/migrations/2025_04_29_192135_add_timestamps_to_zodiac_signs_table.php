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
        Schema::table('zodiac_signs', function (Blueprint $table) {
            // Only add timestamps if they don't already exist
            if (! Schema::hasColumn('zodiac_signs', 'created_at') 
                && ! Schema::hasColumn('zodiac_signs', 'updated_at')) {
                $table->timestamps();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('zodiac_signs', function (Blueprint $table) {
            // Only drop them if they exist
            if (Schema::hasColumn('zodiac_signs', 'created_at') 
                && Schema::hasColumn('zodiac_signs', 'updated_at')) {
                $table->dropTimestamps();
            }
        });
    }
};
