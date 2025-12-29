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
    Schema::table('matrimony_kyc', function (Blueprint $table) {
        $table->unsignedBigInteger('district')->nullable()->after('state');

        $table->foreign('district')
              ->references('id')
              ->on('districts')
              ->nullOnDelete();
    });
}

public function down(): void
{
    Schema::table('matrimony_kyc', function (Blueprint $table) {
        $table->dropForeign(['district']);
        $table->dropColumn('district');
    });
}

};
