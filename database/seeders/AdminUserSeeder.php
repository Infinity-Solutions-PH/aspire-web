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
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@tnts.edu.ph',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'School Registrar',
            'email' => 'registrar@tnts.edu.ph',
            'password' => Hash::make('password123'),
            'role' => 'registrar',
        ]);

        User::create([
            'name' => 'Department Head',
            'email' => 'depthead@tnts.edu.ph',
            'password' => Hash::make('password123'),
            'role' => 'dept_head',
        ]);
    }
}
