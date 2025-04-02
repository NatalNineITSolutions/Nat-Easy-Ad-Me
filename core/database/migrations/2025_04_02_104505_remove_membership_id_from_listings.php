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
        Schema::table('listings', function (Blueprint $table) {
            // Drop the foreign key first
            $table->dropForeign(['membership_id']);

            // Now drop the column
            $table->dropColumn('membership_id');
        });
    }

    public function down()
    {
        Schema::table('listings', function (Blueprint $table) {
            // Re-add column for rollback
            $table->unsignedBigInteger('membership_id')->nullable();

            // Restore foreign key
            $table->foreign('membership_id')->references('id')->on('memberships')->onDelete('cascade');
        });
    }
};
