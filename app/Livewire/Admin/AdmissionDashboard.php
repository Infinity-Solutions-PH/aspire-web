<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Admission;
use Livewire\WithPagination;

class AdmissionDashboard extends Component
{
    use WithPagination;

    public $search = '';
    public $status = 'pending_approval'; // Default to the new pending status
    public $type = '';
    public $category = '';
    public $grade_level = '';
    public $source = 'new'; // 'new' for Admission, 'returning' for Enrollment (pending_approval)

    public function updatedCategory($value)
    {
        $this->grade_level = '';
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatus($value)
    {
        $this->category = '';
        $this->grade_level = '';
        $this->resetPage();
    }

    public function setStatus($status)
    {
        $this->status = $status;
        $this->category = '';
        $this->grade_level = '';
        $this->resetPage();
    }

    public function updatedGradeLevel()
    {
        $this->resetPage();
    }

    public function render()
    {
        // On admission there are 2 status only: Pending approval and drafts
        if ($this->status === 'pending_approval' || $this->status === '') {
            $enrollments = Admission::where('status', 'pending_approval')
                ->when($this->category, fn($q) => $q->where('form_data->school_category', $this->category))
                ->when($this->grade_level, fn($q) => $q->where('form_data->grade_level', $this->grade_level))
                ->when($this->search, function($q) {
                    $q->where('lrn', 'like', "%{$this->search}%")
                      ->orWhere('form_data->first_name', 'like', "%{$this->search}%")
                      ->orWhere('form_data->last_name', 'like', "%{$this->search}%");
                })
                ->latest()
                ->paginate(10);
        } else {
            // Show Drafts from Enrollment table
            $enrollments = Admission::where('status', 'draft')
                ->when($this->type, fn($q) => $q->where('form_data->enrollment_type', $this->type))
                ->when($this->category, fn($q) => $q->where('form_data->school_category', $this->category))
                ->when($this->grade_level, fn($q) => $q->where('form_data->grade_level', $this->grade_level))
                ->when($this->search, function($q) {
                    $q->where('lrn', 'like', "%{$this->search}%")
                      ->orWhere('form_data->first_name', 'like', "%{$this->search}%")
                      ->orWhere('form_data->last_name', 'like', "%{$this->search}%");
                })
                ->latest()
                ->paginate(10);
        }

        $enrollments->getCollection()->transform(function ($enrollment) {
            $data = $enrollment->form_data ?? [];
            $enrollment->first_name = $data['first_name'] ?? 'N/A';
            $enrollment->last_name = $data['last_name'] ?? 'N/A';
            $enrollment->type = $data['enrollment_type'] ?? 'N/A';
            $enrollment->grade_level = $data['grade_level'] ?? 'N/A';
            $enrollment->initials = strtoupper(substr($enrollment->first_name, 0, 1) . substr($enrollment->last_name, 0, 1));
            return $enrollment;
        });

        return view('pages.Admin.admission.dashboard', [
            'enrollments' => $enrollments
        ]);
    }
}
