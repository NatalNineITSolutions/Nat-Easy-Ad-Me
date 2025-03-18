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
        Schema::table('matrimony_kyc', function (Blueprint $table) {
            // Drop columns including 'name'
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('matrimony_kyc', function (Blueprint $table) {
            // Re-add the dropped columns in case of rollback
            
        });
    }
};
