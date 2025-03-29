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
        Schema::create('profile_requests', function (Blueprint $table) {
            $table->id();
            
            // The user who is sending the request (current logged-in user)
            $table->unsignedBigInteger('sender_id');
            $table->foreign('sender_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            
            // The profile being requested
            $table->unsignedBigInteger('profile_id');
            $table->foreign('profile_id')
                ->references('id')
                ->on('profile_listings')
                ->onDelete('cascade');
            
            // Request status (pending, accepted, rejected)
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            
            // Optional message with the request
            $table->text('message')->nullable();
            
            $table->timestamps();
            
            // Prevent duplicate requests
            $table->unique(['sender_id', 'profile_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_requests');
    }
};
