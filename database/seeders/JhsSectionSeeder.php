<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Section;

class JhsSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grades = ['Grade 7', 'Grade 8', 'Grade 9', 'Grade 10'];
        $normalSections = ['A (Rizal)', 'B (Bonifacio)', 'C (Mabini)'];

        // 1. Normal Sections (Grades 7 to 10)
        foreach ($grades as $grade) {
            foreach ($normalSections as $sec) {
                Section::firstOrCreate(
                    [
                        'name' => "{$grade} - {$sec}",
                    ],
                    [
                        'grade_level' => $grade,
                        'track' => null,
                        'strand' => null,
                        'specialization' => null,
                        'capacity' => 45,
                    ]
                );
            }
        }

        // 2. Vocational Sections (Grades 8 to 10)
        $vocationalGrades = ['Grade 8', 'Grade 9', 'Grade 10'];
        $specializations = [
            'Computer Systems Servicing',
            'SMAW Welding',
            'Cookery',  
            'Agriculture'
        ];

        foreach ($vocationalGrades as $grade) {
            foreach ($specializations as $spec) {
                Section::firstOrCreate(
                    [
                        'name' => "{$grade} - {$spec}",
                    ],
                    [
                        'grade_level' => $grade,
                        'track' => 'TVE', // Technical-Vocational Education for JHS
                        'strand' => null,
                        'specialization' => $spec,
                        'capacity' => 30, // Smaller capacity for lab/shop classes
                    ]
                );
            }
        }
    }
}
