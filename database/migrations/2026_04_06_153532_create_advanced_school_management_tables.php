<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Buildings
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // 2. Rooms
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // lecture, lab
            $table->integer('capacity');
            $table->foreignId('building_id')->nullable()->constrained('buildings')->cascadeOnDelete();
            $table->string('floor')->default('1st floor');
            $table->timestamps();
        });

        // 2. Sections
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('grade_level');
            $table->string('track')->nullable();
            $table->string('strand')->nullable();
            $table->string('specialization')->nullable();
            $table->integer('capacity');
            $table->foreignId('room_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('adviser_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // 3. Subjects
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_tech_voc')->default(false);
            $table->timestamps();
        });

        // 4. Schedules
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('teacher_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('day'); // Monday, Tuesday, etc.
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();

            $table->unique(['teacher_id', 'day', 'start_time', 'end_time'], 'schedules_teacher_slot_unique');
            $table->unique(['room_id', 'day', 'start_time', 'end_time'], 'schedules_room_slot_unique');
            $table->unique(['section_id', 'day', 'start_time', 'end_time'], 'schedules_section_slot_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('sections');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('buildings');
    }
};
