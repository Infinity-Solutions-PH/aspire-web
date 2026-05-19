<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Faculty;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faculty = [
            [
                'name' => 'Juan Dela Cruz',
                'email' => 'juan.delacruz@tnts.edu.ph',
                'id' => 'TNTS-2024-001',
                'dept' => 'TVE',
                'status' => 'Active',
                'gender' => 'Male',
                'plantilla_item_number' => 'OSEC-DECSB-TCH1-310001-2021',
                'specialization' => 'Automotive Servicing',
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
                'specialization' => 'General Mathematics',
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
                'specialization' => 'Physical Education',
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
                'specialization' => 'Chemistry & Physics',
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
                'specialization' => 'Electrical Installation & Maintenance',
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
                'specialization' => 'Nuclear Physics',
                'resigned_date' => null,
                'transfer_date' => null,
            ],
            [
                'name' => 'Vacant Position 1',
                'email' => 'vacant1@tnts.edu.ph',
                'id' => 'TNTS-VACANT-001',
                'dept' => 'Mathematics',
                'status' => 'Vacant',
                'gender' => 'Other',
                'plantilla_item_number' => 'OSEC-DECSB-TCH1-310002-2024',
                'specialization' => null,
                'resigned_date' => null,
                'transfer_date' => null,
            ]
        ];

        foreach ($faculty as $f) {
            $user = User::firstOrCreate(
                ['email' => $f['email']],
                [
                    'name' => $f['name'],
                    'password' => Hash::make('password123'),
                    'role' => 'teacher'
                ]
            );

            Faculty::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'faculty_id' => $f['id'],
                    'department' => $f['dept'],
                    'status' => $f['status'],
                    'gender' => $f['gender'],
                    'plantilla_item_number' => $f['plantilla_item_number'],
                    'specialization' => $f['specialization'],
                    'resigned_date' => $f['resigned_date'],
                    'transfer_date' => $f['transfer_date'],
                ]
            );
        }
    }
}
