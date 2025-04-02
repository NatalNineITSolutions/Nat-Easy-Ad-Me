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
        Schema::table('memberships', function (Blueprint $table) {
            $table->integer('listing_limit')->nullable()->change();
            $table->integer('gallery_images')->nullable()->change();
            $table->integer('featured_listing')->nullable()->change();
            $table->boolean('enquiry_form')->nullable()->change();
            $table->boolean('business_hour')->nullable()->change();
            $table->boolean('membership_badge')->nullable()->change();
            $table->integer('profile_limit')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('memberships', function (Blueprint $table) {
            $table->integer('listing_limit')->default(0)->change();
            $table->integer('gallery_images')->default(0)->change();
            $table->integer('featured_listing')->default(0)->change();
            $table->boolean('enquiry_form')->default(0)->change();
            $table->boolean('business_hour')->default(0)->change();
            $table->boolean('membership_badge')->default(0)->change();
            $table->integer('profile_limit')->default(0)->change();
        });
    }
};
