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
            $table->dropColumn('weight_in_grams');
            $table->unsignedBigInteger('unit_id')->nullable()->after('zone_id');
            $table->string('unit_measurement')->nullable()->after('unit_id');

            $table->foreign('unit_id')->references('id')->on('units')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('delivery_charges', function (Blueprint $table) {
            $table->decimal('weight_in_grams', 8, 2)->nullable();
            $table->dropForeign(['unit_id']);
            $table->dropColumn(['unit_id', 'unit_measurement']);
        });
    }
};
