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
        Schema::table('income_payout_manage', function (Blueprint $table) {
            $table->bigInteger('previous_case_on_hand')->change();
            $table->bigInteger('current_day_bv')->change();
            $table->bigInteger('total_bv')->change();
            $table->bigInteger('matching_pairs')->change();
            $table->bigInteger('actual_pairs_paid')->change();
            $table->bigInteger('pair_income')->change();
            $table->bigInteger('total_output_amount')->change();
            $table->bigInteger('balance_case_on_hand')->change();
        });
    }

    public function down()
    {
        Schema::table('income_payout_manage', function (Blueprint $table) {
            $table->integer('previous_case_on_hand')->change();
            $table->integer('current_day_bv')->change();
            $table->integer('total_bv')->change();
            $table->integer('matching_pairs')->change();
            $table->integer('actual_pairs_paid')->change();
            $table->integer('pair_income')->change();
            $table->integer('total_output_amount')->change();
            $table->integer('balance_case_on_hand')->change();
        });
    }
};
