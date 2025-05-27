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
            $table->enum('position', ['left', 'right'])
                ->nullable()
                ->after('type')
                ->comment('child’s placement');
        });
    }

    public function down()
    {
        Schema::table('users_bvs', function (Blueprint $table) {
            $table->dropColumn('position');
        });
    }
};