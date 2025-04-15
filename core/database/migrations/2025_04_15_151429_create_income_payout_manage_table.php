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
        Schema::create('income_payout_manage', function (Blueprint $table) {
            $table->id();
            $table->date('payout_date')->index();

            $table->decimal('previous_case_on_hand', 10, 2)->default(0);
            $table->decimal('current_day_bv', 10, 2)->default(0);
            $table->decimal('total_bv', 10, 2)->default(0);

            $table->integer('matching_pairs')->default(0);
            $table->integer('actual_pairs_paid')->default(0);

            $table->decimal('pair_income', 10, 2)->default(0);
            $table->decimal('total_output_amount', 10, 2)->default(0);
            $table->decimal('balance_case_on_hand', 10, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('income_payout_manage');
    }
};
