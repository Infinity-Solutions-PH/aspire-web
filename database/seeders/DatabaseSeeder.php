<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            PositionSeeder::class,
            DepartmentSeeder::class,
            // SchoolManagementSeeder::class,
            // JhsSectionSeeder::class,
            // BranchSeeder::class,
            // PlantillaPositionSeeder::class,
            // FacultySeeder::class,
            // BulkEnrollmentSeeder::class,
        ]);
    }
}
