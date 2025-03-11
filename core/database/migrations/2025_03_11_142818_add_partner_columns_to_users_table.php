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
        Schema::table('users', function (Blueprint $table) {
            $table->string('partner_id', 50)->nullable()->after('id')->comment('Alphanumeric unique identifier for partner');
            $table->string('partner_name')->nullable()->after('partner_id')->comment('Name of the partner associated with the user');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['partner_id', 'partner_name']);
        });
    }
};
