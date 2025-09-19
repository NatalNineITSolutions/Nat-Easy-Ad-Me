<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();

            // Account details
            $table->string('primary_contact_name');
            $table->string('company_name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable();

            // Other details
            $table->string('website')->nullable();
            $table->decimal('opening_balance', 15, 2)->default(0.00);
            $table->string('currency', 10)->default('INR'); // consider using 3-char ISO codes

            // Addresses
            $table->text('billing_address')->nullable();
            $table->text('shipping_address')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
}
