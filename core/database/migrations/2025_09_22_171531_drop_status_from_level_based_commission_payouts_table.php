<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropStatusFromLevelBasedCommissionPayoutsTable extends Migration
{
    public function up()
    {
        Schema::table('level_based_commission_payouts', function (Blueprint $table) {
            if (Schema::hasColumn('level_based_commission_payouts', 'status')) {
                $table->dropColumn('status');
            }
        });
    }

    public function down()
    {
        Schema::table('level_based_commission_payouts', function (Blueprint $table) {
            if (! Schema::hasColumn('level_based_commission_payouts', 'status')) {
                $table->string('status')->default('pending')->after('payment_type');
            }
        });
    }
}
