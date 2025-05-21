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
        Schema::table('users_flush', function (Blueprint $table) {
            // Add new foreign key column
            $table->unsignedBigInteger('payout_summary_id')->nullable()->after('user_id');
            $table->dropColumn('payout');
        });
    }

    public function down(): void
    {
        Schema::table('users_flush', function (Blueprint $table) {
            $table->decimal('payout', 15, 2)->nullable();
            $table->dropColumn('payout_summary_id');
        });
    }
};
