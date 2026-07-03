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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('school_year_id')->nullable()->constrained('school_years')->nullOnDelete();
            $table->string('transaction_number')->nullable()->unique();
            $table->string('status')->default('Draft');
            $table->integer('current_step')->default(1);
            $table->string('type')->nullable(); // e.g. Regular, Returnee, Transferee
            
            // Academic Data
            $table->string('grade_level')->nullable();
            $table->foreignId('section_id')->nullable()->constrained('sections')->nullOnDelete();
            $table->foreignId('tech_voc_section_id')->nullable()->constrained('sections')->nullOnDelete();

            // Academic History & Preferences
            $table->string('last_grade_level')->nullable();
            $table->string('last_school_year')->nullable();
            $table->string('last_school_attended')->nullable();
            $table->string('last_school_id')->nullable();

            // Conditional SHS & Tech-Voc
            $table->string('semester')->nullable();
            $table->string('track')->nullable();
            $table->string('strand')->nullable();
            $table->string('shs_track')->nullable();
            $table->boolean('is_shs_aligned')->default(false);
            $table->string('specialization')->nullable();
            $table->json('tech_voc_choices')->nullable();
            $table->string('modality')->nullable();

            // Validation & Verification
            $table->decimal('gwa', 5, 2)->nullable();
            $table->text('admin_remarks')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('finalized_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
