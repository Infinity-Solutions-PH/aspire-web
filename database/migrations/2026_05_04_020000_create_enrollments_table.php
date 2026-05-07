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
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            
            $table->string('status')->default('Draft');
            $table->integer('current_step')->default(1);
            $table->string('transaction_number')->nullable();
            $table->string('type')->nullable();
            
            // Term and Academic State
            $table->string('term_status')->default('enrolled'); // enrolled, completed, dropped
            $table->string('academic_result')->nullable(); // passed, failed, graduated
            $table->foreignId('school_year_id')->nullable()->constrained()->onDelete('set null');

            $table->string('grade_level')->nullable();
            $table->decimal('gwa', 5, 2)->nullable();
            
            // Conditional SHS & Tech-Voc
            $table->string('semester')->nullable();
            $table->string('track')->nullable();
            $table->string('strand')->nullable();
            $table->string('shs_track')->nullable();
            $table->boolean('is_shs_aligned')->default(false);
            $table->string('specialization')->nullable();
            $table->string('modality')->nullable();
            $table->json('tech_voc_choices')->nullable();

            // Sections
            $table->foreignId('section_id')->nullable()->constrained('sections')->onDelete('set null');
            $table->foreignId('tech_voc_section_id')->nullable()->constrained('sections')->onDelete('set null');

            // Document Uploads
            $table->string('profile_picture')->nullable();
            $table->string('psa_path')->nullable();
            $table->string('sf9_path')->nullable();
            $table->string('good_moral_path')->nullable();
            $table->string('honorable_dismissal_path')->nullable();
            
            $table->text('admin_remarks')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');
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
