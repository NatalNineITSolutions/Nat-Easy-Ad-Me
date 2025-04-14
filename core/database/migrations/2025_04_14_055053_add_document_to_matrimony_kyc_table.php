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
        Schema::table('matrimony_kyc', function (Blueprint $table) {
            // Update ENUM to match lowercase of form values
            DB::statement("ALTER TABLE matrimony_kyc MODIFY COLUMN marital_status ENUM('unmarried', 'married', 'second marriage') NOT NULL");

            // Add document column if not already added
            $table->string('document')->nullable()->after('marital_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('matrimony_kyc', function (Blueprint $table) {
            // Revert to original ENUM (update as needed)
            DB::statement("ALTER TABLE matrimony_kyc MODIFY COLUMN marital_status ENUM('unmarried', 'married') NOT NULL");

            $table->dropColumn('document');
        });
    }

};
