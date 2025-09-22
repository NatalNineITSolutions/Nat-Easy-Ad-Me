<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelBasedCommissionPayoutsAndAddHistoryColumns extends Migration
{
    public function up()
    {
        Schema::create('level_based_commission_payouts', function (Blueprint $table) {
            $table->id();
            $table->string('batch_id')->index(); 
            $table->unsignedBigInteger('user_id')->nullable()->index(); 
            $table->decimal('total_bv', 12, 2)->default(0); 
            $table->string('payment_type')->nullable(); 
            $table->string('status')->default('pending');
            $table->json('details')->nullable();
            $table->timestamp('payout_date')->nullable();
            $table->timestamps();
        });

        Schema::table('level_commission_histories', function (Blueprint $table) {
            if (! Schema::hasColumn('level_commission_histories', 'payout_id')) {
                $table->unsignedBigInteger('payout_id')->nullable()->after('bv_added')->index();
            }
            if (! Schema::hasColumn('level_commission_histories', 'is_paid')) {
                $table->boolean('is_paid')->default(false)->after('payout_id');
            }
        });
    }

    public function down()
    {
        Schema::table('level_commission_histories', function (Blueprint $table) {
            if (Schema::hasColumn('level_commission_histories', 'payout_id')) {
                $table->dropColumn('payout_id');
            }
            if (Schema::hasColumn('level_commission_histories', 'is_paid')) {
                $table->dropColumn('is_paid');
            }
        });

        Schema::dropIfExists('level_based_commission_payouts');
    }
}
