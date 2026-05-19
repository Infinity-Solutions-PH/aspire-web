<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            'Teacher I',
            'Teacher II',
            'Teacher III',
            'Special Science Teacher I',
            'Special Science Teacher II',
            'Special Science Teacher III',
            'Master Teacher I',
            'Master Teacher II',
            'Master Teacher III',
            'Master Teacher IV',
            'Head Teacher I',
            'Head Teacher II',
            'Head Teacher III',
            'Head Teacher IV',
            'Head Teacher V',
            'Head Teacher VI',
            'Principal I',
            'Principal II',
            'Principal III',
            'Principal IV',
        ];

        foreach ($positions as $position) {
            Position::firstOrCreate(['name' => $position]);
        }
    }
}
