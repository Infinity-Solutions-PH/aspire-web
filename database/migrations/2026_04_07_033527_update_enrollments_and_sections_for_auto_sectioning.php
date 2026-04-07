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
        Schema::table('enrollments', function (Blueprint $table) {
            $table->decimal('gwa', 5, 2)->nullable()->after('middle_name');
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->boolean('is_star_section')->default(false)->after('name');
            $table->string('room')->nullable()->after('is_star_section');
            $table->foreignId('adviser_id')->nullable()->constrained('users')->nullOnDelete()->after('room');
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');

        Schema::table('sections', function (Blueprint $table) {
            $table->dropForeign(['adviser_id']);
            $table->dropColumn(['is_star_section', 'room', 'adviser_id']);
        });

        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropColumn('gwa');
        });
    }
};
