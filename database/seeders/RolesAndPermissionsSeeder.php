<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $facultyRole = Role::firstOrCreate(['name' => 'faculty']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);

        // Create superadmin user
        $user = User::firstOrCreate(
            ['email' => config('admin.superadmin_email')],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make(config('admin.superadmin_password')),
                'email_verified_at' => now(),
            ]
        );

        // Assign role to superadmin
        if (!$user->hasRole('superadmin')) {
            $user->assignRole($superadminRole);
        }
    }
}
