<?php

namespace App\Livewire\Admin;

use App\Models\Teacher;
use Livewire\Component;
use Livewire\WithPagination;

class TeacherManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $department = '';
    public $status = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $teachers = Teacher::with('user')
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })->orWhere('teacher_id', 'like', '%' . $this->search . '%');
            })
            ->when($this->department, fn ($q) => $q->where('department', $this->department))
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->paginate(10);

        $stats = [
            'total' => Teacher::count(),
            'active' => Teacher::where('status', 'Active')->count(),
            'on_leave' => Teacher::where('status', 'On Leave')->count(),
        ];

        return view('livewire.admin.teacher-management', [
            'teachers' => $teachers,
            'stats' => $stats
        ]);
    }
}
