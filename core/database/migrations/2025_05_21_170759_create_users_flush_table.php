<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users_flush', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->decimal('flushed_left_bv', 12, 2)->default(0);
            $table->decimal('flushed_right_bv', 12, 2)->default(0);
            $table->tinyInteger('payout')->default(0)->comment('0 = not paid out, 1 = paid');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users_flush');
    }
    
};
