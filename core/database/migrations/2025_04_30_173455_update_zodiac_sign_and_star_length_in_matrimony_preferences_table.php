<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('matrimony_preferences', function (Blueprint $table) {
            $table->string('zodiac_sign', 255)->nullable()->change();
            $table->string('star',        255)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('matrimony_preferences', function (Blueprint $table) {
            $table->string('zodiac_sign', 100)->nullable()->change();
            $table->string('star',        100)->nullable()->change();
        });
    }
};
