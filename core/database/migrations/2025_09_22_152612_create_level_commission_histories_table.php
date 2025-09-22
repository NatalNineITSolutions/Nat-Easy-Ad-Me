<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelCommissionHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('level_commission_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('purchaser_id');  
            $table->unsignedBigInteger('upline_id');     
            $table->unsignedInteger('level');             
            $table->decimal('percentage', 8, 2);
            $table->decimal('bv_added', 12, 2);
            $table->timestamps();

            $table->index('purchaser_id');
            $table->index('upline_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('level_commission_histories');
    }
}
