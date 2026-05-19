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
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('faculty_id')->unique();
            $table->string('department');
            $table->string('status')->default('Active'); // Active, On Leave, Retired, Deceased, Vacant
            $table->string('specialization')->nullable();
            
            // New columns requested by USER
            $table->string('plantilla_item_number')->nullable();
            $table->string('gender')->nullable();
            $table->date('resigned_date')->nullable();
            $table->date('transfer_date')->nullable(); // date of transfer if transferred out
            
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
