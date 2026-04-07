<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@tnts.edu.ph'],
            ['name' => 'System Admin', 'password' => Hash::make('password123'), 'role' => 'admin']
        );

        User::updateOrCreate(
            ['email' => 'registrar@tnts.edu.ph'],
            ['name' => 'School Registrar', 'password' => Hash::make('password123'), 'role' => 'registrar']
        );

        User::updateOrCreate(
            ['email' => 'guidance@tnts.edu.ph'],
            ['name' => 'Guidance Counselor', 'password' => Hash::make('password123'), 'role' => 'guidance']
        );

        User::updateOrCreate(
            ['email' => 'depthead@tnts.edu.ph'],
            ['name' => 'Department Head', 'password' => Hash::make('password123'), 'role' => 'dept_head']
        );
    }
}
