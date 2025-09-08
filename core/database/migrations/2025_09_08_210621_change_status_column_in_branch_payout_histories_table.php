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
        Schema::table('branch_payout_histories', function (Blueprint $table) {
            $table->tinyInteger('status')
                ->default(0)
                ->comment('0 = pending/unpaid, 1 = paid')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('branch_payout_histories', function (Blueprint $table) {
            $table->enum('status', ['pending', 'paid'])->default('pending')->change();
        });
    }
};
