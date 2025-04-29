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
        Schema::table('users_bvs', function (Blueprint $table) {
            $table->string('type')->nullable()->after('bv_points'); // or any existing column
        });
    }

    public function down()
    {
        Schema::table('users_bvs', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
