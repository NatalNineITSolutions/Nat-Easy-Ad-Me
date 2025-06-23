<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->integer('product_quantity')->default(1);
            $table->decimal('product_total_price', 10, 2);
            $table->decimal('total_delivery_charge', 10, 2)->default(0);
            $table->decimal('grand_total', 10, 2);

            $table->string('name');
            $table->string('email');
            $table->string('phone_number', 15);
            $table->text('address');

            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();

            $table->enum('order_status', ['pending', 'packaging', 'shipped', 'delivered'])->default('pending');
            $table->boolean('is_paid')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
