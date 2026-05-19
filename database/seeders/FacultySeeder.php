<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Faculty;
use App\Models\Branch;
use App\Models\PlantillaPosition;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $main = Branch::where('name', 'Main')->first()->id;
        $annex = Branch::where('name', 'Annex')->first()->id;

        $plantillas = PlantillaPosition::all()->keyBy('plantilla_number');
        if ($plantillas->isEmpty()) {
            return;
        }

        $faculty = [
            [
                'name' => 'Juan Dela Cruz',
                'email' => 'juan.delacruz@tnts.edu.ph',
                'id' => 'TNTS-2024-001',
                'dept' => 'TVE',
                'status' => 'Active',
                'gender' => 'Male',
                'plantilla_position_id' => $plantillas['OSEC-DECSB-TCH1-310001-2021']->id ?? null,
                'branch_id' => $main,
                'level' => 'JHS',
                'resigned_date' => null,
                'transfer_date' => null,
            ],
            [
                'name' => 'Maria Santos',
                'email' => 'maria.santos@tnts.edu.ph',
                'id' => 'TNTS-2024-042',
                'dept' => 'Academic',
                'status' => 'Active',
                'gender' => 'Female',
                'plantilla_position_id' => $plantillas['OSEC-DECSB-TCH3-310006-2021']->id ?? null,
                'branch_id' => $main,
                'level' => 'SHS',
                'resigned_date' => null,
                'transfer_date' => null,
            ],
            [
                'name' => 'Ricardo Gomez',
                'email' => 'ricardo.gomez@tnts.edu.ph',
                'id' => 'TNTS-2024-015',
                'dept' => 'MAPEH',
                'status' => 'On Leave',
                'gender' => 'Male',
                'plantilla_position_id' => $plantillas['OSEC-DECSB-TCH2-310004-2021']->id ?? null,
                'branch_id' => $annex,
                'level' => 'JHS',
                'resigned_date' => null,
                'transfer_date' => null,
            ],
            [
                'name' => 'Elena Reyes',
                'email' => 'elena.reyes@tnts.edu.ph',
                'id' => 'TNTS-2024-088',
                'dept' => 'Science',
                'status' => 'Active',
                'gender' => 'Female',
                'plantilla_position_id' => $plantillas['OSEC-DECSB-MTCH1-310007-2021']->id ?? null,
                'branch_id' => $main,
                'level' => 'SHS',
                'resigned_date' => null,
                'transfer_date' => null,
            ],
            [
                'name' => 'Thomas Edison',
                'email' => 'thomas.edison@tnts.edu.ph',
                'id' => 'TNTS-2020-009',
                'dept' => 'TVE',
                'status' => 'Retired',
                'gender' => 'Male',
                'plantilla_position_id' => $plantillas['OSEC-DECSB-TCH2-310005-2021']->id ?? null,
                'branch_id' => $annex,
                'level' => 'JHS',
                'resigned_date' => null,
                'transfer_date' => null,
            ],
            [
                'name' => 'Marie Curie',
                'email' => 'marie.curie@tnts.edu.ph',
                'id' => 'TNTS-2021-022',
                'dept' => 'Science',
                'status' => 'Inactive', // Replaced Deceased with Inactive
                'gender' => 'Female',
                'plantilla_position_id' => $plantillas['OSEC-DECSB-HTCH1-310008-2021']->id ?? null,
                'branch_id' => $main,
                'level' => 'SHS',
                'resigned_date' => null,
                'transfer_date' => null,
            ]
            // We intentionally leave some PlantillaPosition items unassigned to represent Vacancies.
        ];

        foreach ($faculty as $f) {
            $userId = null;
            if ($f['email']) {
                $user = User::firstOrCreate(
                    ['email' => $f['email']],
                    [
                        'name' => $f['name'],
                        'password' => Hash::make('password123'),
                        'role' => 'teacher'
                    ]
                );
                $userId = $user->id;
            }

            if ($f['plantilla_position_id']) {
                Faculty::updateOrCreate(
                    ['faculty_id' => $f['id']],
                    [
                        'user_id' => $userId,
                        'department' => $f['dept'],
                        'status' => $f['status'],
                        'gender' => $f['gender'],
                        'plantilla_position_id' => $f['plantilla_position_id'],
                        'branch_id' => $f['branch_id'],
                        'level' => $f['level'],
                        'resigned_date' => $f['resigned_date'],
                        'transfer_date' => $f['transfer_date'],
                    ]
                );
            }
        }
    }
}
