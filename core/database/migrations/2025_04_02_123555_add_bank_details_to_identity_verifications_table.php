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
        Schema::table('identity_verifications', function (Blueprint $table) {
            $table->string('pancard_no')->nullable()->after('back_document');
            $table->string('bank_account_no')->nullable()->after('pancard_no');
            $table->string('ifsc_code')->nullable()->after('bank_account_no');
        });
    }

    public function down()
    {
        Schema::table('identity_verifications', function (Blueprint $table) {
            $table->dropColumn(['pancard_no', 'bank_account_no', 'ifsc_code']);
        });
    }
};
