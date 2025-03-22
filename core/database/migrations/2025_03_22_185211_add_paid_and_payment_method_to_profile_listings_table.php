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
        Schema::table('profile_listings', function (Blueprint $table) {
            $table->boolean('paid')->default(false); // Set default to false
            $table->string('payment_method')->nullable(); // Payment method can be null
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('profile_listings', function (Blueprint $table) {
            $table->dropColumn('paid');
            $table->dropColumn('payment_method');
        });
    }
};
