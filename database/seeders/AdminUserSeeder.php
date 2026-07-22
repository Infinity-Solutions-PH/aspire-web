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
        $adminUsers = [
            ['email' => 'admin@tnts.edu.ph', 'name' => 'System Admin', 'password' => Hash::make('password123'), 'role' => 'admin'],
            ['email' => 'registrar@tnts.edu.ph', 'name' => 'Registrar', 'password' => Hash::make('password123'), 'role' => 'admin'],
            ['email' => 'guidance@tnts.edu.ph', 'name' => 'Guidance Counselor', 'password' => Hash::make('password123'), 'role' => 'admin'],
            ['email' => 'ovpd@tnts.edu.ph', 'name' => 'OVPD Office', 'password' => Hash::make('password123'), 'role' => 'admin'],
        ];

        foreach ($adminUsers as $userData) {
            $role = $userData['role'];
            unset($userData['role']);
            
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );

            if (!$user->hasRole($role)) {
                $user->assignRole($role);
            }
        }
    }
}
