<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
{
    Schema::create('branch_commissions', function (Blueprint $table) {
        $table->id();

        
        $table->unsignedBigInteger('branch_id')->index()->nullable();

        
        $table->unsignedBigInteger('order_id')->index();

        
        $table->decimal('total_bv', 12, 2)->default(0);         
        $table->decimal('commission_percent', 5, 2)->default(0);
        $table->decimal('commission_amount', 12, 2)->default(0); 

        
        $table->enum('status', ['earned','paid'])->default('earned');

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_commissions');
    }
};
