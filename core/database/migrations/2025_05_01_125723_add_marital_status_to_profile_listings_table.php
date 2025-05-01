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
            if (!Schema::hasColumn('profile_listings', 'marital_status')) {
                $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])
                      ->nullable()
                      ->after('gender'); // Adjust position as needed
            }
        });
    }

    public function down()
    {
        Schema::table('profile_listings', function (Blueprint $table) {
            if (Schema::hasColumn('profile_listings', 'marital_status')) {
                $table->dropColumn('marital_status');
            }
        });
    }
};
