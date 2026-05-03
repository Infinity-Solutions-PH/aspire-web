<?php

namespace App\Livewire\Admin;

use App\Models\Enrollment;
use App\Models\PreEnrollment;
use Livewire\Component;
use Livewire\WithPagination;

class EnrollmentDashboard extends Component
{
    use WithPagination;

    public $search = '';
    public $status = 'pending_approval'; // Default to the new pending status
    public $type = '';

    public function render()
    {
        // If status is pending_approval, we look into PreEnrollment table
        if ($this->status === 'pending_approval') {
            $enrollments = PreEnrollment::where('status', 'pending_approval')
                ->when($this->search, function($q) {
                    $q->where('lrn', 'like', "%{$this->search}%")
                      ->orWhere('form_data->first_name', 'like', "%{$this->search}%")
                      ->orWhere('form_data->last_name', 'like', "%{$this->search}%");
                })
                ->latest()
                ->paginate(10);
        } else {
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
        }

        return view('pages.Admin.enrollment-dashboard', [
            'enrollments' => $enrollments
        ]);
    }
}
