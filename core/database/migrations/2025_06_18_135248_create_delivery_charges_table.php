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
        Schema::create('delivery_charges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('zone_id');
            $table->decimal('min_order', 10, 2)->nullable();
            $table->decimal('delivery_charge', 10, 2);
            $table->integer('weight_in_grams')->nullable();
            $table->string('setting_type')->default('na'); // values: na, min_order
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_charges');
    }
};
