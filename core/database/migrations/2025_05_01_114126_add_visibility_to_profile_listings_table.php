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
            if (!Schema::hasColumn('profile_listings', 'visibility')) {
                $table->tinyInteger('visibility')->default(0)->comment('0=public, 1=private')->after('star');
            }
        });
    }

    public function down()
    {
        Schema::table('profile_listings', function (Blueprint $table) {
            if (Schema::hasColumn('profile_listings', 'visibility')) {
                $table->dropColumn('visibility');
            }
        });
    }
};
