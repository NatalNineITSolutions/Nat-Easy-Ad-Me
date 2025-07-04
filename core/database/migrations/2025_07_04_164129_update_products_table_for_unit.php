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
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('weight'); // remove old column
            $table->unsignedBigInteger('unit_id')->nullable()->after('id');
            $table->decimal('unit_measurement', 10, 2)->nullable()->after('unit_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('weight', 10, 2)->nullable(); // add back if rolled back
            $table->dropForeign(['unit_id']);
            $table->dropColumn(['unit_id', 'unit_measurement']);
        });
    }
};
