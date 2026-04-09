<?php

namespace App\Livewire\Admin;

use App\Models\Enrollment;
use Livewire\Component;
use Livewire\WithPagination;

class EnrollmentDashboard extends Component
{
    use WithPagination;

    public $search = '';
    public $status = 'Submitted';
    public $type = '';

    public function render()
    {
        $enrollments = Enrollment::where('status', '!=', 'Draft')
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->when($this->type, fn($q) => $q->where('type', $this->type))
            ->when($this->search, function($q) {
                $q->where('first_name', 'like', "%{$this->search}%")
                  ->orWhere('last_name', 'like', "%{$this->search}%")
                  ->orWhere('lrn', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate(10);

        return view('pages.Admin.enrollment-dashboard', [
            'enrollments' => $enrollments
        ]);
    }
}
