<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            'Teaching' => [
                'Teacher I',
                'Teacher II',
                'Teacher III',
                'Master Teacher I',
                'Master Teacher II',
            ],
            'Non-Teaching' => [
                'Administrative Aide I',
                'Administrative Aide III',
                'Administrative Aide IV',
                'Administrative Assistant II',
                'Administrative Assistant III',
                'Administrative Officer I',
                'Administrative Officer II',
                'Guidance Counselor III',
                'Head Teacher I',
                'Head Teacher III',
                'Head Teacher IV',
                'Head Teacher VI',
                'Nurse II',
                'School Librarian III',
                'School Principal IV',
                'Security Guard I',
                'Watchman I',
            ]
        ];

        // Ensure foreign key checks are disabled if deleting all, or just let it update existing
        // but the user wants to "remove the existing and replace with this"
        // Since it's a dev DB, wiping is usually safe, but we can also just wipe them if they aren't referenced.
        // Actually, using truncate on a table with foreign key constraints will fail unless checks are disabled.
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Position::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach ($positions as $type => $names) {
            foreach ($names as $name) {
                Position::create(['name' => $name, 'type' => $type]);
            }
        }
    }
}
