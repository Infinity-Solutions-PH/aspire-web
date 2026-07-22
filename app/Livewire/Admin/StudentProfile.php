<?php

namespace App\Livewire\Admin;

use App\Models\Enrollment;
use Livewire\Component;

class StudentProfile extends Component
{
    public Enrollment $enrollment;

    public function mount(Enrollment $student)
    {
        // Route parameter is {student} which maps to Enrollment model
        $this->enrollment = $student;
    }

    public function render()
    {
        return view('livewire.admin.student-profile')
            ->layout('layouts.app');
    }
}
