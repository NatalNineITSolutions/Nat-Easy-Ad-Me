<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('job_details', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->default(54);
            $table->unsignedBigInteger('sub_category_id')->default(107);
        });
    }

    public function down()
    {
        Schema::table('job_details', function (Blueprint $table) {
            $table->dropColumn(['category_id', 'sub_category_id']);
        });
    }

};
