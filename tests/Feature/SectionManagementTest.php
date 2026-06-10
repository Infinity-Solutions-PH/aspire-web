<?php

use App\Models\User;
use App\Models\Faculty;
use App\Models\Section;
use Livewire\Livewire;
use App\Livewire\Admin\SectionManagement;

test('admin can search active teachers by name or employee ID in adviser assignment modal', function () {
    // 1. Create a section
    $section = Section::create([
        'name' => 'Grade 7 - Diamond',
        'grade_level' => 'Grade 7',
        'capacity' => 40,
    ]);

    // 2. Create several teachers
    $teacher1 = User::create([
        'name' => 'Alice Johnson',
        'email' => 'alice@tnts.edu.ph',
        'password' => bcrypt('password'),
        'role' => 'teacher',
    ]);
    $faculty1 = Faculty::create([
        'user_id' => $teacher1->id,
        'faculty_id' => 'TNTS-2026-001',
        'status' => 'Active',
        'gender' => 'Female',
    ]);

    $teacher2 = User::create([
        'name' => 'Bob Smith',
        'email' => 'bob@tnts.edu.ph',
        'password' => bcrypt('password'),
        'role' => 'teacher',
    ]);
    $faculty2 = Faculty::create([
        'user_id' => $teacher2->id,
        'faculty_id' => 'TNTS-2026-002',
        'status' => 'Active',
        'gender' => 'Male',
    ]);

    // An inactive teacher (should not show up in results)
    $teacher3 = User::create([
        'name' => 'Charlie Brown',
        'email' => 'charlie@tnts.edu.ph',
        'password' => bcrypt('password'),
        'role' => 'teacher',
    ]);
    $faculty3 = Faculty::create([
        'user_id' => $teacher3->id,
        'faculty_id' => 'TNTS-2026-003',
        'status' => 'Inactive',
        'gender' => 'Male',
    ]);

    // A non-teacher user (should not show up)
    $nonTeacher = User::create([
        'name' => 'David Miller',
        'email' => 'david@tnts.edu.ph',
        'password' => bcrypt('password'),
        'role' => 'student',
    ]);
    $faculty4 = Faculty::create([
        'user_id' => $nonTeacher->id,
        'faculty_id' => 'TNTS-2026-004',
        'status' => 'Active',
        'gender' => 'Male',
    ]);

    // Test the component search state
    $comp = Livewire::test(SectionManagement::class)
        ->call('openAdviserModal', $section->id)
        ->assertSet('selectedSectionId', $section->id)
        ->assertSet('currentSectionName', $section->name)
        ->assertSet('adviserSearch', '');

    // Verify default results list only active teachers (Alice and Bob, not Charlie or David)
    $results = $comp->instance()->facultySearchResults;
    $ids = $results->pluck('id')->toArray();
    expect($ids)->toContain($faculty1->id)
        ->toContain($faculty2->id)
        ->toHaveCount(2);

    // Search by name "Alice"
    $comp->set('adviserSearch', 'Alice');
    $results = $comp->instance()->facultySearchResults;
    expect($results)->toHaveCount(1);
    expect($results->first()->id)->toEqual($faculty1->id);

    // Search by employee ID "002"
    $comp->set('adviserSearch', '002');
    $results = $comp->instance()->facultySearchResults;
    expect($results)->toHaveCount(1);
    expect($results->first()->id)->toEqual($faculty2->id);
});

test('admin can assign and unassign adviser toggling selected faculty', function () {
    $section = Section::create([
        'name' => 'Grade 7 - Diamond',
        'grade_level' => 'Grade 7',
        'capacity' => 40,
    ]);

    $teacher = User::create([
        'name' => 'Alice Johnson',
        'email' => 'alice@tnts.edu.ph',
        'password' => bcrypt('password'),
        'role' => 'teacher',
    ]);
    $faculty = Faculty::create([
        'user_id' => $teacher->id,
        'faculty_id' => 'TNTS-2026-001',
        'status' => 'Active',
        'gender' => 'Female',
    ]);

    // 1. Assign adviser
    Livewire::test(SectionManagement::class)
        ->call('openAdviserModal', $section->id)
        ->set('selectedAdviserId', $teacher->id)
        ->call('assignAdviser')
        ->assertSet('showAdviserModal', false)
        ->assertSet('selectedAdviserId', null)
        ->assertSet('adviserSearch', '');

    expect($section->fresh()->adviser_id)->toEqual($teacher->id);

    // 2. Unassign (toggle off to null)
    Livewire::test(SectionManagement::class)
        ->call('openAdviserModal', $section->id)
        ->assertSet('selectedAdviserId', $teacher->id)
        ->set('selectedAdviserId', null)
        ->call('assignAdviser')
        ->assertSet('showAdviserModal', false)
        ->assertSet('selectedAdviserId', null);

    expect($section->fresh()->adviser_id)->toBeNull();
});
