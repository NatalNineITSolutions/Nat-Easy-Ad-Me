<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('level_based_commission_payouts', function (Blueprint $table) {
            $table->decimal('tds_percent', 5, 2)->default(0)->after('total_bv');
            $table->decimal('service_charge_percent', 5, 2)->default(0)->after('tds_percent');
            $table->decimal('payout_amount', 12, 2)->default(0)->after('service_charge_percent');
        });
    }

    public function down(): void
    {
        Schema::table('level_based_commission_payouts', function (Blueprint $table) {
            $table->dropColumn(['tds_percent', 'service_charge_percent', 'payout_amount']);
        });
    }
};
