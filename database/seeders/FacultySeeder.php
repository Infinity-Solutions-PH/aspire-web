<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Faculty;
use App\Models\Position;
use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teacher1 = Position::where('name', 'Teacher I')->first()->id;
        $teacher2 = Position::where('name', 'Teacher II')->first()->id;
        $teacher3 = Position::where('name', 'Teacher III')->first()->id;
        $mt1 = Position::where('name', 'Master Teacher I')->first()->id;
        $mt2 = Position::where('name', 'Master Teacher II')->first()->id;

        $main = Branch::where('name', 'Main')->first()->id;
        $annex = Branch::where('name', 'Annex')->first()->id;

        $faculty = [
            [
                'name' => 'Juan Dela Cruz',
                'email' => 'juan.delacruz@tnts.edu.ph',
                'id' => 'TNTS-2024-001',
                'dept' => 'TVE',
                'status' => 'Active',
                'gender' => 'Male',
                'plantilla_item_number' => 'OSEC-DECSB-TCH1-310001-2021',
                'position_id' => $teacher1,
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
                'plantilla_item_number' => 'OSEC-DECSB-TCH3-310452-2018',
                'position_id' => $teacher3,
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
                'plantilla_item_number' => 'OSEC-DECSB-TCH2-310015-2020',
                'position_id' => $teacher2,
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
                'plantilla_item_number' => 'OSEC-DECSB-MTCH1-310088-2015',
                'position_id' => $mt1,
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
                'plantilla_item_number' => 'OSEC-DECSB-MTCH2-310009-2010',
                'position_id' => $mt2,
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
                'status' => 'Deceased',
                'gender' => 'Female',
                'plantilla_item_number' => 'OSEC-DECSB-TCH3-310022-2012',
                'position_id' => $teacher3,
                'branch_id' => $main,
                'level' => 'SHS',
                'resigned_date' => null,
                'transfer_date' => null,
            ],
            [
                'name' => null,
                'email' => null,
                'id' => 'TNTS-VACANT-001',
                'dept' => 'Mathematics',
                'status' => 'Vacant',
                'gender' => null,
                'plantilla_item_number' => 'OSEC-DECSB-TCH1-310002-2024',
                'position_id' => $teacher1,
                'branch_id' => $annex,
                'level' => 'JHS',
                'resigned_date' => null,
                'transfer_date' => null,
            ]
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

            Faculty::updateOrCreate(
                ['faculty_id' => $f['id']],
                [
                    'user_id' => $userId,
                    'department' => $f['dept'],
                    'status' => $f['status'],
                    'gender' => $f['gender'],
                    'plantilla_item_number' => $f['plantilla_item_number'],
                    'position_id' => $f['position_id'],
                    'branch_id' => $f['branch_id'],
                    'level' => $f['level'],
                    'resigned_date' => $f['resigned_date'],
                    'transfer_date' => $f['transfer_date'],
                ]
            );
        }
    }
}
