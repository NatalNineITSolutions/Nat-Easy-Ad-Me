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
        Schema::table('cities', function (Blueprint $table) {
            if (!Schema::hasColumn('cities', 'district_id')) {
                $table->unsignedBigInteger('district_id')->nullable()->after('state_id');

                $table->foreign('district_id')
                    ->references('id')
                    ->on('districts')
                    ->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropForeign(['district_id']);
            $table->dropColumn('district_id');
     });
  }

};
