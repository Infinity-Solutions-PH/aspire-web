<?php

use App\Models\User;
use App\Models\Enrollment;
use App\Models\Violation;
use Livewire\Livewire;
use App\Livewire\Admin\StudentViolations;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can filter student violations by school level (JHS/SHS) and grade level', function () {
    // 1. Create an admin who records the violations
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@tnts.edu.ph',
        'password' => bcrypt('password'),
        'role' => 'admin',
    ]);

    // 2. Create JHS student (Grade 7)
    $jhsStudent = User::create([
        'name' => 'JHS Student A',
        'student_id' => '100000000001',
        'email' => 'jhs@tnts.edu.ph',
        'password' => bcrypt('password'),
        'role' => 'student',
    ]);

    Enrollment::create([
        'user_id' => $jhsStudent->id,
        'transaction_number' => 'TNTS-JHS12345',
        'status' => 'Enrolled',
        'grade_level' => 'Grade 7',
        'lrn' => '100000000001',
        'last_name' => 'JHS',
        'first_name' => 'Student A',
        'sex' => 'Male',
        'birthdate' => '2012-01-01',
    ]);

    // 3. Create SHS student (Grade 11)
    $shsStudent = User::create([
        'name' => 'SHS Student B',
        'student_id' => '200000000002',
        'email' => 'shs@tnts.edu.ph',
        'password' => bcrypt('password'),
        'role' => 'student',
    ]);

    Enrollment::create([
        'user_id' => $shsStudent->id,
        'transaction_number' => 'TNTS-SHS12345',
        'status' => 'Enrolled',
        'grade_level' => 'Grade 11',
        'lrn' => '200000000002',
        'last_name' => 'SHS',
        'first_name' => 'Student B',
        'sex' => 'Female',
        'birthdate' => '2008-01-01',
    ]);

    // 4. Create violations for both
    $jhsViolation = Violation::create([
        'user_id' => $jhsStudent->id,
        'title' => 'Tardiness JHS',
        'severity' => 'Low',
        'details' => 'Late for morning class JHS',
        'recorded_by' => $admin->id,
        'violation_date' => now()->format('Y-m-d'),
    ]);

    $shsViolation = Violation::create([
        'user_id' => $shsStudent->id,
        'title' => 'Dress Code SHS',
        'severity' => 'Medium',
        'details' => 'No uniform SHS',
        'recorded_by' => $admin->id,
        'violation_date' => now()->format('Y-m-d'),
    ]);

    // 5. Test Livewire component with different filters
    $this->actingAs($admin);

    // Initial state: both violations should be visible
    $component = Livewire::test(StudentViolations::class);
    $violations = $component->instance()->render()->getData()['violations'];
    expect($violations->pluck('id')->toArray())->toContain($jhsViolation->id, $shsViolation->id);

    // Filter by School Level = JHS
    $component->set('schoolLevelFilter', 'JHS');
    $violations = $component->instance()->render()->getData()['violations'];
    expect($violations->pluck('id')->toArray())->toContain($jhsViolation->id);
    expect($violations->pluck('id')->toArray())->not->toContain($shsViolation->id);

    // Filter by School Level = SHS
    $component->set('schoolLevelFilter', 'SHS');
    $violations = $component->instance()->render()->getData()['violations'];
    expect($violations->pluck('id')->toArray())->toContain($shsViolation->id);
    expect($violations->pluck('id')->toArray())->not->toContain($jhsViolation->id);

    // Filter by Grade Level = Grade 7 (with no School Level filter explicitly set or it gets reset)
    $component->set('schoolLevelFilter', '');
    $component->set('gradeLevelFilter', 'Grade 7');
    $violations = $component->instance()->render()->getData()['violations'];
    expect($violations->pluck('id')->toArray())->toContain($jhsViolation->id);
    expect($violations->pluck('id')->toArray())->not->toContain($shsViolation->id);

    // Filter by Grade Level = Grade 11
    $component->set('gradeLevelFilter', 'Grade 11');
    $violations = $component->instance()->render()->getData()['violations'];
    expect($violations->pluck('id')->toArray())->toContain($shsViolation->id);
    expect($violations->pluck('id')->toArray())->not->toContain($jhsViolation->id);

    // Test that changing School Level resets the Grade Level filter
    $component->set('gradeLevelFilter', 'Grade 11');
    $component->set('schoolLevelFilter', 'JHS');
    expect($component->get('gradeLevelFilter'))->toBe('');
});
