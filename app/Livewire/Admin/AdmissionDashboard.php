<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Admission;

class AdmissionDashboard extends Component
{
    use WithPagination;

    public $search = '';
    public $status = 'pending_approval'; // Default to the new pending status
    public $type = '';
    public $category = '';
    public $source = 'new'; // 'new' for Admission, 'returning' for Enrollment (pending_approval)

    public function render()
    {
        // On admission there are 2 status only: Pending approval and drafts
        if ($this->status === 'pending_approval' || $this->status === '') {
            $enrollments = Admission::where('status', 'pending_approval')
                ->when($this->category, fn($q) => $q->where('form_data->school_category', $this->category))
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
                ->when($this->type, fn($q) => $q->where('type', $this->type))
                ->when($this->category, function($q) {
                    if ($this->category === 'HS') {
                        $q->whereIn('grade_level', ['Grade 7', 'Grade 8', 'Grade 9', 'Grade 10']);
                    } elseif ($this->category === 'SHS') {
                        $q->whereIn('grade_level', ['Grade 11', 'Grade 12']);
                    }
                })
                ->when($this->search, function($q) {
                    $q->where('first_name', 'like', "%{$this->search}%")
                      ->orWhere('last_name', 'like', "%{$this->search}%")
                      ->orWhere('lrn', 'like', "%{$this->search}%");
                })
                ->latest()
                ->paginate(10);
        }

        return view('pages.Admin.admission.dashboard', [
            'enrollments' => $enrollments
        ]);
    }
}
