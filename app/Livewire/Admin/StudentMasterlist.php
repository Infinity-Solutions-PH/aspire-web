<?php

namespace App\Livewire\Admin;

use App\Models\Enrollment;
use Livewire\Component;
use Livewire\WithPagination;

class StudentMasterlist extends Component
{
    use WithPagination;

    public $search = '';
    public $grade_level = '';
    public $status = 'Enrolled';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingGradeLevel()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        $students = Enrollment::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%')
                        ->orWhere('lrn', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->grade_level && $this->grade_level !== 'All Levels', fn ($q) => $q->where('grade_level', $this->grade_level))
            ->when($this->status && $this->status !== 'All Status', fn ($q) => $q->where('status', $this->status))
            ->orderBy('last_name')
            ->paginate(15);

        return view('livewire.admin.student-masterlist', [
            'students' => $students
        ]);
    }
}
