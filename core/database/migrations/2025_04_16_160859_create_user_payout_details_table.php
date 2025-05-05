<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('user_payout_details')) {

        Schema::create('user_payout_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payout_summary_id')->constrained('income_payout_manage');
            $table->decimal('left_bv', 15, 2)->default(0);
            $table->decimal('right_bv', 15, 2)->default(0);
            $table->integer('matching_pairs')->default(0);
            $table->decimal('payout_amount', 15, 2)->default(0);
            $table->decimal('tds_deduction', 15, 2)->default(0);
            $table->decimal('service_charge', 15, 2)->default(0);
            $table->decimal('net_amount', 15, 2)->default(0);
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->index(['user_id', 'payout_summary_id']);
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_payout_details');
    }
};
