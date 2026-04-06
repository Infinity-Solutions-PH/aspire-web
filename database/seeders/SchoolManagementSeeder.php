<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Schedule;
use App\Models\Fee;
use App\Models\User;
use Illuminate\Database\Seeder;

class SchoolManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Rooms
        $rooms = [
            ['name' => 'IT Lab 01 (Shop)', 'type' => 'shop', 'capacity' => 20],
            ['name' => 'IT Lab 02 (Shop)', 'type' => 'shop', 'capacity' => 20],
            ['name' => 'Welding Shop B', 'type' => 'shop', 'capacity' => 15],
            ['name' => 'Lecture Hall 01', 'type' => 'lecture', 'capacity' => 45],
            ['name' => 'Lecture Hall 02', 'type' => 'lecture', 'capacity' => 45],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }

        // 2. Sections
        $sections = [
            ['name' => '11-CSS-A', 'grade_level' => '11', 'track' => 'TVL', 'strand' => 'ICT', 'specialization' => 'Computer Systems Servicing', 'capacity' => 20],
            ['name' => '12-PROG-B', 'grade_level' => '12', 'track' => 'TVL', 'strand' => 'ICT', 'specialization' => 'Programming', 'capacity' => 20],
            ['name' => '11-SMAW-A', 'grade_level' => '11', 'track' => 'TVL', 'strand' => 'Industrial Arts', 'specialization' => 'SMAW Welding', 'capacity' => 15],
        ];

        foreach ($sections as $section) {
            Section::create($section);
        }

        // 3. Subjects
        $subjects = [
            ['name' => 'Web Development 01', 'grade_level' => '12', 'track' => 'TVL', 'strand' => 'ICT', 'specialization' => 'Programming'],
            ['name' => 'Comp Servicing II', 'grade_level' => '11', 'track' => 'TVL', 'strand' => 'ICT', 'specialization' => 'Computer Systems Servicing'],
            ['name' => 'Arc Welding Practical', 'grade_level' => '11', 'track' => 'TVL', 'strand' => 'Industrial Arts', 'specialization' => 'SMAW Welding'],
            ['name' => 'Empowerment Tech', 'grade_level' => '11', 'track' => 'TVL', 'strand' => 'ICT', 'specialization' => 'Computer Systems Servicing'],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }

        // 4. Fees
        $fees = [
            ['name' => 'Registration Fee', 'amount' => 500.00, 'track' => null],
            ['name' => 'Library Fee', 'amount' => 200.00, 'track' => null],
            ['name' => 'Shop Lab Consumables', 'amount' => 1500.00, 'track' => 'TVL'],
            ['name' => 'Digital Tools Subscription', 'amount' => 800.00, 'track' => 'TVL', 'strand' => 'ICT'],
        ];

        foreach ($fees as $fee) {
            Fee::create($fee);
        }

        // 5. Schedules (Manual link for first few)
        $teacher = User::where('role', 'dept_head')->first();
        if ($teacher) {
            Schedule::create([
                'section_id' => Section::first()->id,
                'subject_id' => Subject::first()->id,
                'room_id' => Room::first()->id,
                'teacher_id' => $teacher->id,
                'day' => 'Monday',
                'start_time' => '07:30',
                'end_time' => '09:30',
            ]);
        }
    }
}
