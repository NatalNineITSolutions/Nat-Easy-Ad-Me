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
        Schema::table('matrimony_kyc', function (Blueprint $table) {
            $table->enum('marital_status', ['unmarried', 'married', 'divorce'])->nullable();
            $table->date('dob')->nullable();
            $table->string('family_status')->nullable();
            $table->string('family_values')->nullable();
            $table->enum('family_type', ['nuclear', 'joint', 'extended'])->nullable();
            $table->enum('disability', ['yes', 'no'])->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->integer('weight')->nullable(); // in kg
            $table->string('caste')->nullable();
            $table->enum('dosham', ['yes', 'no'])->nullable();
            $table->string('gothram')->nullable();
            $table->string('education')->nullable();
            $table->string('occupation')->nullable();
            $table->decimal('annual_income', 10, 2)->nullable();
            $table->enum('employed_in', ['government', 'private', 'defense', 'business', 'self-employed', 'not-working'])->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->text('about')->nullable();
            $table->string('image')->nullable();
            $table->string('matrimony_id')->unique()->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('mobile')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('matrimony_kyc', function (Blueprint $table) {
            $table->dropColumn([
                'marital_status', 'dob', 'family_status', 'family_values', 'family_type',
                'disability', 'height', 'weight', 'caste', 'dosham', 'gothram',
                'education', 'occupation', 'annual_income', 'employed_in',
                'country', 'state', 'city', 'about', 'image', 'matrimony_id'
            ]);
        });
    }
};
