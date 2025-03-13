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
        Schema::create('matrimony_users', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->string('name'); // Name field
            $table->string('email')->unique(); // Unique email field
            $table->string('password'); // Password field
            $table->string('gender')->nullable()->change();
            $table->date('dob')->nullable()->change();
            $table->string('country')->nullable()->change();
            $table->string('location')->nullable()->change();
            $table->string('mobile', 15); // Mobile number field
            $table->timestamps(); // Created_at and updated_at fields
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matrimony_users');
    }
};
