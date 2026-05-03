<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Teacher;
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
                'dept' => 'TVL - Automotive',
                'status' => 'Active'
            ],
            [
                'name' => 'Maria Santos',
                'email' => 'maria.santos@tnts.edu.ph',
                'id' => 'TNTS-2024-042',
                'dept' => 'Academics',
                'status' => 'Active'
            ],
            [
                'name' => 'Ricardo Gomez',
                'email' => 'ricardo.gomez@tnts.edu.ph',
                'id' => 'TNTS-2024-015',
                'dept' => 'MAPEH',
                'status' => 'On Leave'
            ],
            [
                'name' => 'Elena Reyes',
                'email' => 'elena.reyes@tnts.edu.ph',
                'id' => 'TNTS-2024-088',
                'dept' => 'Science',
                'status' => 'Active'
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

            Teacher::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'teacher_id' => $f['id'],
                    'department' => $f['dept'],
                    'status' => $f['status']
                ]
            );
        }
    }
}
