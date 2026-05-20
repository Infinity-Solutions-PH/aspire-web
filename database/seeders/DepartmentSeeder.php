<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'SHS' => ['Techpro', 'Academic'],
            'JHS' => [
                'English', 'Science', 'Mathematics', 'Filipino', 
                'Araling Panlipunan', 'Edukasyon sa Pagpapakatao', 
                'MAPEH', 'Industrial Arts', 'Home Economics', 'Personnel'
            ]
        ];

        foreach ($departments as $level => $names) {
            foreach ($names as $name) {
                Department::firstOrCreate(['name' => $name, 'level' => $level]);
            }
        }
    }
}
