<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class JhsSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            'Grade 7' => [
                'star' => 'Sampaguita',
                'regular' => ['Gladiola', 'Santan', 'Rose', 'Orchid', 'Daisy', 'Sunflower', 'Daffodil', 'Lily', 'Jasmine']
            ],
            'Grade 8' => [
                'star' => 'Narra',
                'regular' => ['Molave', 'Ipil-ipil', 'Yakal', 'Mahogany', 'Acacia', 'Oak', 'Pine', 'Bamboo', 'Eucalyptus']
            ],
            'Grade 9' => [
                'star' => 'Love',
                'regular' => ['Honesty', 'Hope', 'Loyalty', 'Charity', 'Courage', 'Perseverance', 'Faith', 'Humility', 'Modesty']
            ],
            'Grade 10' => [
                'star' => 'Diamond',
                'regular' => ['Ruby', 'Sapphire', 'Emerald', 'Jade', 'Pearl', 'Amethyst', 'Topaz', 'Garnet', 'Onyx']
            ]
        ];

        foreach ($sections as $grade => $data) {
            // Create Star Section
            Section::firstOrCreate(
                [
                    'name' => "{$grade} - {$data['star']}",
                    'grade_level' => $grade,
                ],
                [
                    'track' => null,
                    'strand' => null,
                    'specialization' => null,
                    'capacity' => 40,
                    'is_star_section' => true,
                ]
            );

            // Create Regular Sections
            foreach ($data['regular'] as $secName) {
                Section::firstOrCreate(
                    [
                        'name' => "{$grade} - {$secName}",
                        'grade_level' => $grade,
                    ],
                    [
                        'track' => null,
                        'strand' => null,
                        'specialization' => null,
                        'capacity' => 40,
                        'is_star_section' => false,
                    ]
                );
            }
        }
    }
}
