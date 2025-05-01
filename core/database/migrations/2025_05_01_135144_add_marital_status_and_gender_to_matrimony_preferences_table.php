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
            $table->string('marital_status')->nullable()->after('partner_age');
            $table->string('gender')->nullable()->after('marital_status');
        });
    }

    public function down()
    {
        Schema::table('matrimony_preferences', function (Blueprint $table) {
            $table->dropColumn(['marital_status', 'gender']);
        });
    }

};
