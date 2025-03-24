<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('castes', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->string('caste')->unique(); // Caste name (unique to avoid duplicates)
            $table->timestamps(); // Adds created_at & updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() {
        Schema::dropIfExists('castes');
    }
};
