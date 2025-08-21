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
        Schema::table('delivery_charges', function (Blueprint $table) {
            // First, drop the foreign key constraint
            $table->dropForeign(['unit_id']);

            // Then drop the columns
            $table->dropColumn(['unit_id', 'unit_measurement']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('delivery_charges', function (Blueprint $table) {
            // Add columns back
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->string('unit_measurement')->nullable();

            // Re-add the foreign key constraint
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('set null');
        });
    }
};
