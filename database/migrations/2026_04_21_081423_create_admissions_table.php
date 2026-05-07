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
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number')->nullable();
            $table->string('lrn')->unique();
            $table->date('birthdate');
            $table->integer('current_step')->default(0);
            $table->enum('status', ['draft', 'pending_review', 'approved', 'archived'])->default('draft');
            $table->json('form_data')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
