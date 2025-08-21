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
        Schema::table('order_details', function (Blueprint $table) {
            $table->text('product_id')->change();
            $table->text('product_quantity')->change();
            $table->text('product_total_price')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->integer('product_id')->change();
            $table->integer('product_quantity')->change();
            $table->decimal('product_total_price', 10, 2)->change();
        });
    }
};
