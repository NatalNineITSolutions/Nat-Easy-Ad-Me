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
        Schema::table('profile_listings', function (Blueprint $table) {
            $table->unsignedTinyInteger('age')->nullable()->after('date_of_birth');
        });
    }

    public function down()
    {
        Schema::table('profile_listings', function (Blueprint $table) {
            $table->dropColumn('age');
        });
    }

};
