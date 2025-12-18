<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_add_radius_km_to_listings_table.php
public function up()
{
    Schema::table('listings', function (Blueprint $table) {
        $table->integer('radius_km')->default(10);
    });
}

public function down()
{
    Schema::table('listings', function (Blueprint $table) {
        $table->dropColumn('radius_km');
    });
}

};
