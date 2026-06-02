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
            $columns = [];
            if (Schema::hasColumn('faculties', 'resigned_date')) {
                $columns[] = 'resigned_date';
            }
            if (Schema::hasColumn('faculties', 'transfer_date')) {
                $columns[] = 'transfer_date';
            }
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faculties', function (Blueprint $table) {
            if (!Schema::hasColumn('faculties', 'resigned_date')) {
                $table->date('resigned_date')->nullable();
            }
            if (!Schema::hasColumn('faculties', 'transfer_date')) {
                $table->date('transfer_date')->nullable();
            }
        });
    }
};
