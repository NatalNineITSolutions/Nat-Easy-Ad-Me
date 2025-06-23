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
        Schema::table('delivery_charges', function (Blueprint $table) {
            $table->decimal('default_delivery_charge', 10, 2)->default(0)->after('weight_in_grams');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('delivery_charges', function (Blueprint $table) {
            $table->dropColumn('default_delivery_charge');
        });
    }
    
};
