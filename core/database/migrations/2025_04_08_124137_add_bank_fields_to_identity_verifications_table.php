<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('identity_verifications', function (Blueprint $table) {
            $table->string('bank_name')->nullable()->after('ifsc_code');
            $table->string('branch')->nullable()->after('bank_name');
            $table->string('account_type')->nullable()->after('branch');
            $table->string('relation_name')->nullable()->after('account_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('identity_verifications', function (Blueprint $table) {
            $table->dropColumn(['bank_name', 'branch', 'account_type', 'relation_name']);
        });
    }
};
