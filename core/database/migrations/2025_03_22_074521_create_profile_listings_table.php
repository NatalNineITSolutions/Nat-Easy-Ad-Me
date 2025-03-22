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
        Schema::create('profile_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link to users table
            $table->string('name');
            $table->integer('age');
            $table->string('occupation');
            $table->decimal('annual_income', 10, 2);
            $table->string('caste')->nullable();
            $table->string('mother_tongue');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->string('image')->nullable(); // Store image path
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('profile_listings');
    }
};