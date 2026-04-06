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
        // 1. Rooms
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // shop, lecture, lab
            $table->integer('capacity');
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
            $table->timestamps();
        });

        // 3. Subjects
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('grade_level');
            $table->string('track')->nullable();
            $table->string('strand')->nullable();
            $table->string('specialization')->nullable();
            $table->timestamps();
        });

        // 4. Schedules
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $table->string('day'); // Monday, Tuesday, etc.
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
        });

        // 5. Fees
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('amount', 10, 2);
            $table->string('track')->nullable();
            $table->string('strand')->nullable();
            $table->string('specialization')->nullable();
            $table->timestamps();
        });

        // 6. Safety Waivers
        Schema::create('safety_waivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('signed_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('safety_waivers');
        Schema::dropIfExists('fees');
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('sections');
        Schema::dropIfExists('rooms');
    }
};
