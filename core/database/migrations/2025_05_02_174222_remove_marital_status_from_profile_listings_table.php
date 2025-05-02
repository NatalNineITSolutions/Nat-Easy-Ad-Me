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
        Schema::table('profile_listings', function (Blueprint $table) {
            $table->dropColumn('marital_status');
        });
    }

    public function down()
    {
        Schema::table('profile_listings', function (Blueprint $table) {
            $table->enum('marital_status', ['unmarried', 'married', 'divorced', 'widowed'])->default('unmarried');
        });
    }
};
