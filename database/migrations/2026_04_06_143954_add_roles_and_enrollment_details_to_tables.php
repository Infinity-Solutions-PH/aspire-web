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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('applicant')->after('password'); 
            $table->string('student_id')->nullable()->unique()->after('role');
        });

        Schema::table('enrollments', function (Blueprint $table) {
            $table->string('type')->nullable()->after('current_step');
            $table->json('tech_voc_choices')->nullable()->after('type');
            $table->string('shs_track')->nullable()->after('strand');
            $table->boolean('is_shs_aligned')->default(false)->after('shs_track');
            $table->text('admin_remarks')->nullable()->after('good_moral_path');
            $table->foreignId('verified_by')->nullable()->constrained('users')->after('admin_remarks');
            $table->timestamp('finalized_at')->nullable()->after('verified_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'student_id']);
        });

        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn(['type', 'tech_voc_choices', 'shs_track', 'is_shs_aligned', 'admin_remarks', 'verified_by', 'finalized_at']);
        });
    }
};
