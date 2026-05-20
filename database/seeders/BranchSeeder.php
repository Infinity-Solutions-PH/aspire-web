<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = ['Main', 'Annex', 'Punta National High School'];

        foreach ($branches as $branch) {
            Branch::firstOrCreate(['name' => $branch]);
        }
    }
}
