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
        // Schema::create('matrimony_kyc', function (Blueprint $table) {
        //     $table->id(); // Primary Key
        //     $table->enum('marital_status', ['unmarried', 'married', 'divorce'])->nullable();
        //     $table->date('dob')->nullable();
        //     $table->string('family_status')->nullable();
        //     $table->string('family_values')->nullable();
        //     $table->string('family_type')->nullable();
        //     $table->string('disability')->nullable();
        //     $table->integer('height')->nullable();
        //     $table->integer('weight')->nullable();
        //     $table->string('caste')->nullable();
        //     $table->string('dosham')->nullable();
        //     $table->string('gothram')->nullable();
        //     $table->string('education')->nullable();
        //     $table->string('occupation')->nullable();
        //     $table->string('annual_income')->nullable();
        //     $table->string('employed_in')->nullable();
        //     $table->string('country')->nullable();
        //     $table->string('state')->nullable();
        //     $table->string('city')->nullable();
        //     $table->text('about')->nullable();
        //     $table->timestamps(); 
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('matrimony_kyc');
    }
};
