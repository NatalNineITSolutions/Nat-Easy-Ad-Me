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
        Schema::table('matrimony_preferences', function (Blueprint $table) {
            $table->string('partner_age')->change();
        });
    }

    public function down()
    {
        Schema::table('matrimony_preferences', function (Blueprint $table) {
            $table->integer('partner_age')->change();
        });
    }
};
