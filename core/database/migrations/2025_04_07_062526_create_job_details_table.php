<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('job_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Personal Information
            $table->string('full_name');
            $table->string('email');
            $table->string('phone', 20);
            $table->string('address', 500);
            $table->string('profile_picture')->nullable();

            // Resume/CV
            $table->text('work_experience');
            $table->text('education');
            $table->text('skills');
            $table->text('certifications')->nullable();
            $table->text('achievements')->nullable();
            $table->text('projects')->nullable();
            $table->string('summary', 1000);
            $table->text('portfolio_links')->nullable();

            // Application Details
            $table->date('availability_date');
            $table->enum('work_preference', ['remote', 'hybrid', 'onsite']);
            $table->decimal('expected_salary', 10, 2);
            $table->boolean('relocation_willingness');
            $table->string('work_authorization');

            // Location
            $table->foreignId('country_id')->constrained();
            $table->foreignId('state_id')->constrained();
            $table->foreignId('city_id')->constrained();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('job_details');
    }
};
