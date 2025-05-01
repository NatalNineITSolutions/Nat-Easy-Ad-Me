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
        Schema::table('profile_listings', function (Blueprint $table) {
            if (!Schema::hasColumn('profile_listings', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('name');
            }
            if (!Schema::hasColumn('profile_listings', 'religion')) {
                $table->string('religion')->nullable()->after('date_of_birth');
            }
            if (!Schema::hasColumn('profile_listings', 'gender')) {
                $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('religion');
            }
            
            // Remove the age column if it exists
            if (Schema::hasColumn('profile_listings', 'age')) {
                $table->dropColumn('age');
            }
        });
    }

    public function down()
    {
        Schema::table('profile_listings', function (Blueprint $table) {
            if (Schema::hasColumn('profile_listings', 'date_of_birth')) {
                $table->dropColumn('date_of_birth');
            }
            if (Schema::hasColumn('profile_listings', 'religion')) {
                $table->dropColumn('religion');
            }
            if (Schema::hasColumn('profile_listings', 'gender')) {
                $table->dropColumn('gender');
            }
            
            // Add back the age column if needed
            if (!Schema::hasColumn('profile_listings', 'age')) {
                $table->integer('age')->nullable();
            }
        });
    }
};
