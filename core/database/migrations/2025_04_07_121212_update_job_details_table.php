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
        Schema::table('job_details', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['listing_id']);

            // Then drop the column
            $table->dropColumn('listing_id');
            $table->dropColumn('profile_picture');

            // Add child_category_id after sub_category_id
            if (!Schema::hasColumn('job_details', 'child_category_id')) {
                $table->unsignedBigInteger('child_category_id')->nullable()->after('sub_category_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('job_details', function (Blueprint $table) {
            // Add the columns back
            $table->string('profile_picture')->nullable();
            $table->unsignedBigInteger('listing_id')->nullable();

            // Restore the foreign key
            $table->foreign('listing_id')->references('id')->on('listings')->onDelete('cascade');

            // Drop child_category_id
            $table->dropColumn('child_category_id');
        });
    }
};
