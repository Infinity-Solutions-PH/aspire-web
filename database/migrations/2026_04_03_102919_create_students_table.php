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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Global State Management
            $table->string('global_status')->default('active'); // active, alumni, inactive, transferred
            $table->boolean('is_jhs_alumni')->default(false);
            $table->boolean('is_shs_alumni')->default(false);

            // Learner Information
            $table->string('grade_level')->nullable();
            $table->string('psa_no')->nullable();
            $table->string('lrn')->unique()->nullable();
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('extension_name')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('sex')->nullable();
            
            // Dynamic Toggles
            $table->boolean('is_ip')->default(false);
            $table->string('ip_community')->nullable();
            $table->boolean('is_4ps')->default(false);
            $table->string('household_id')->nullable();
            $table->boolean('has_disability')->default(false);
            $table->json('disability_types')->nullable();

            // Address Information
            $table->string('current_house_no')->nullable();
            $table->string('current_street')->nullable();
            $table->string('current_barangay')->nullable();
            $table->string('current_municipality')->nullable();
            $table->string('current_province')->nullable();
            $table->string('current_zip')->nullable();
            $table->boolean('is_same_address')->default(true);
            $table->string('permanent_house_no')->nullable();
            $table->string('permanent_street')->nullable();
            $table->string('permanent_barangay')->nullable();
            $table->string('permanent_municipality')->nullable();
            $table->string('permanent_province')->nullable();
            $table->string('permanent_zip')->nullable();

            // Parent's/Guardian's Information
            $table->string('father_name')->nullable();
            $table->string('mother_maiden_name')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('contact_no')->nullable();

            // Academic History
            $table->string('last_grade_level')->nullable();
            $table->string('last_school_year')->nullable();
            $table->string('last_school_attended')->nullable();
            $table->string('last_school_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
