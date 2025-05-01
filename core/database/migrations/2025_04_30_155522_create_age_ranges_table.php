<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('age_ranges', function (Blueprint $table) {
            $table->id();
            $table->integer('from_age');
            $table->integer('to_age');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('age_ranges');
    }
};
