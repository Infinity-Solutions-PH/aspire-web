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
        Schema::create('faculties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('faculty_id')->unique();
            $table->string('department');
            $table->string('status')->default('Active'); // Active, On Leave, Retired, Deceased, Vacant
            
            // Relational fields replacing raw text
            $table->foreignId('plantilla_position_id')->nullable()->constrained('plantilla_positions')->nullOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            
            // Secondary levels JHS / SHS
            $table->string('level')->default('JHS'); // JHS, SHS
            
            // New columns requested by USER
            $table->string('gender')->nullable();
            $table->string('inactive_reason')->nullable();
            $table->date('effective_date')->nullable();
            $table->string('transfer_school')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faculties');
    }
};
