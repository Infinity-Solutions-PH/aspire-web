<?php

use App\Models\User;
use Livewire\Livewire;
use App\Models\Admission;
use App\Models\Enrollment;
use App\Livewire\Admin\StudentMasterlist;
use App\Livewire\Admin\AdmissionDashboard;

test('admissions dashboard displays the correct total filtered count', function () {
    // 1. Create 3 Admissions with birthdate
    Admission::create([
        'lrn' => '100000000001',
        'birthdate' => '2010-01-01',
        'transaction_number' => 'TXN-001',
        'status' => 'pending_approval',
        'form_data' => [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'school_category' => 'HS',
            'grade_level' => 'Grade 7',
        ],
    ]);

    Admission::create([
        'lrn' => '100000000002',
        'birthdate' => '2010-01-01',
        'transaction_number' => 'TXN-002',
        'status' => 'pending_approval',
        'form_data' => [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'school_category' => 'HS',
            'grade_level' => 'Grade 8',
        ],
    ]);

    Admission::create([
        'lrn' => '100000000003',
        'birthdate' => '2010-01-01',
        'transaction_number' => 'TXN-003',
        'status' => 'pending_approval',
        'form_data' => [
            'first_name' => 'Bob',
            'last_name' => 'Smith',
            'school_category' => 'SHS',
            'grade_level' => 'Grade 11',
        ],
    ]);

    // 2. Test the Livewire component
    Livewire::test(AdmissionDashboard::class)
        ->assertViewHas('enrollments', function ($enrollments) {
            return $enrollments->total() === 3;
        })
        // Filter by category
        ->set('category', 'HS')
        ->assertViewHas('enrollments', function ($enrollments) {
            return $enrollments->total() === 2;
        })
        // Filter by grade_level
        ->set('grade_level', 'Grade 8')
        ->assertViewHas('enrollments', function ($enrollments) {
            return $enrollments->total() === 1;
        })
        // Search filter
        ->set('category', '')
        ->set('grade_level', '')
        ->set('search', 'Bob')
        ->assertViewHas('enrollments', function ($enrollments) {
            return $enrollments->total() === 1;
        });
});

test('student masterlist displays the correct total filtered count', function () {
    // Create users to associate with enrollments
    $user1 = User::create([
        'name' => 'Alice Wonder',
        'email' => 'alice.wonder@tnts.edu.ph',
        'password' => bcrypt('password'),
        'role' => 'student',
    ]);
    $user2 = User::create([
        'name' => 'Charlie Bucket',
        'email' => 'charlie.bucket@tnts.edu.ph',
        'password' => bcrypt('password'),
        'role' => 'student',
    ]);
    $user3 = User::create([
        'name' => 'David Copperfield',
        'email' => 'david.copperfield@tnts.edu.ph',
        'password' => bcrypt('password'),
        'role' => 'student',
    ]);

    // 1. Create 3 student enrollments with masterlist status ('Enrolled', 'Approved')
    Enrollment::create([
        'user_id' => $user1->id,
        'transaction_number' => 'TXN-M001',
        'lrn' => '200000000001',
        'first_name' => 'Alice',
        'last_name' => 'Wonder',
        'grade_level' => 'Grade 7',
        'status' => 'Enrolled',
        'contact_no' => '1234567890',
        'birthdate' => '2010-01-01',
        'sex' => 'Female',
    ]);

    Enrollment::create([
        'user_id' => $user2->id,
        'transaction_number' => 'TXN-M002',
        'lrn' => '200000000002',
        'first_name' => 'Charlie',
        'last_name' => 'Bucket',
        'grade_level' => 'Grade 8',
        'status' => 'Enrolled',
        'contact_no' => '1234567890',
        'birthdate' => '2010-01-01',
        'sex' => 'Male',
    ]);

    Enrollment::create([
        'user_id' => $user3->id,
        'transaction_number' => 'TXN-M003',
        'lrn' => '200000000003',
        'first_name' => 'David',
        'last_name' => 'Copperfield',
        'grade_level' => 'Grade 11',
        'status' => 'Approved',
        'contact_no' => '1234567890',
        'birthdate' => '2010-01-01',
        'sex' => 'Male',
    ]);

    // 2. Test Livewire component (default status is 'Enrolled')
    Livewire::test(StudentMasterlist::class)
        ->assertViewHas('students', function ($students) {
            return $students->total() === 2; // Alice & Charlie are Enrolled
        })
        // Filter by all statuses
        ->set('status', 'All Status')
        ->assertViewHas('students', function ($students) {
            return $students->total() === 3;
        })
        // Filter by category
        ->set('category', 'HS')
        ->assertViewHas('students', function ($students) {
            return $students->total() === 2;
        })
        // Filter by grade level
        ->set('grade_level', 'Grade 8')
        ->assertViewHas('students', function ($students) {
            return $students->total() === 1;
        });
});
