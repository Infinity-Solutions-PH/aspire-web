<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $baseSubjects = [
            'Mathematics',
            'Science',
            'English',
            'Filipino',
            'Araling Panlipunan',
            'MAPEH',
            'Edukasyon sa Pagpapakatao (EsP)',
            'Technology and Livelihood Education (TLE)',
        ];

        $techVocSubjects = [
            'Computer Systems Servicing',
            'Cookery',
            'Bread and Pastry Production',
            'Electrical Installation and Maintenance',
            'Shielded Metal Arc Welding',
            'Automotive Servicing',
        ];

        foreach ($baseSubjects as $subjectName) {
            Subject::updateOrCreate([
                'name' => $subjectName,
            ], [
                'is_tech_voc' => false,
            ]);
        }
        
        foreach ($techVocSubjects as $subjectName) {
            Subject::updateOrCreate([
                'name' => $subjectName,
            ], [
                'is_tech_voc' => true,
            ]);
        }
    }
}
