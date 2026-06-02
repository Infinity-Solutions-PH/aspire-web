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
        Schema::table('faculties', function (Blueprint $table) {
            if (!Schema::hasColumn('faculties', 'inactive_reason')) {
                $table->string('inactive_reason')->nullable();
            }
            if (!Schema::hasColumn('faculties', 'effective_date')) {
                $table->date('effective_date')->nullable();
            }
            if (!Schema::hasColumn('faculties', 'transfer_school')) {
                $table->string('transfer_school')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faculties', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('faculties', 'inactive_reason')) {
                $columns[] = 'inactive_reason';
            }
            if (Schema::hasColumn('faculties', 'effective_date')) {
                $columns[] = 'effective_date';
            }
            if (Schema::hasColumn('faculties', 'transfer_school')) {
                $columns[] = 'transfer_school';
            }
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
