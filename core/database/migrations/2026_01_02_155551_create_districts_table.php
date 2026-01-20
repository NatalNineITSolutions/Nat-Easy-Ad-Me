<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();

            $table->string('district');
            $table->boolean('status')->default(1);

            $table->timestamps();

            $table->foreign('country_id')
                  ->references('id')->on('countries')
                  ->onDelete('set null');

            $table->foreign('state_id')
                  ->references('id')->on('states')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('districts');
    }
};

