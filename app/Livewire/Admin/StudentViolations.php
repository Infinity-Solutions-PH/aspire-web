<?php

namespace App\Livewire\Admin;

use App\Models\Student;
use App\Models\Violation;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class StudentViolations extends Component
{
    use WithPagination;

    // Filters
    public $search = '';
    public $severityFilter = '';
    public $schoolLevelFilter = '';
    public $gradeLevelFilter = '';

    // Modals
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showViewModal = false;

    // Selected / Active records
    public $selectedViolationId = null;
    public $selectedStudentId = null;
    public $selectedStudentName = '';

    // Form fields
    public $title = '';
    public $severity = 'Low';
    public $details = '';
    public $violation_date = '';
    public $studentSearch = '';
    public $studentSearchResults = [];

    // Details view
    public $viewingViolation = null;

    protected $rules = [
        'selectedStudentId' => 'required|exists:students,id',
        'title' => 'required|string|max:255',
        'severity' => 'required|in:Low,Medium,High',
        'details' => 'required|string',
        'violation_date' => 'required|date',
    ];

    public function mount()
    {
        $this->violation_date = date('Y-m-d');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSeverityFilter()
    {
        $this->resetPage();
    }

    public function updatingSchoolLevelFilter()
    {
        $this->resetPage();
        $this->gradeLevelFilter = '';
    }

    public function updatingGradeLevelFilter()
    {
        $this->resetPage();
    }

    public function updatedStudentSearch()
    {
        if (strlen($this->studentSearch) < 2) {
            $this->studentSearchResults = [];
            return;
        }

        $this->studentSearchResults = Student::where('first_name', 'like', '%' . $this->studentSearch . '%')
            ->orWhere('last_name', 'like', '%' . $this->studentSearch . '%')
            ->orWhere('lrn', 'like', '%' . $this->studentSearch . '%')
            ->with('enrollments')
            ->take(5)
            ->get()
            ->map(function ($student) {
                $student->name = $student->first_name . ' ' . $student->last_name;
                return $student;
            })
            ->toArray();
    }

    public function selectStudent($studentId, $studentName)
    {
        $this->selectedStudentId = $studentId;
        $this->selectedStudentName = $studentName;
        $this->studentSearch = '';
        $this->studentSearchResults = [];
    }

    public function clearSelectedStudent()
    {
        $this->selectedStudentId = null;
        $this->selectedStudentName = '';
        $this->studentSearch = '';
    }

    public function openCreateModal()
    {
        $this->resetValidation();
        $this->clearForm();
        $this->showCreateModal = true;
    }

    public function saveViolation()
    {
        $this->validate();

        Violation::create([
            'student_id' => $this->selectedStudentId,
            'title' => $this->title,
            'severity' => $this->severity,
            'details' => $this->details,
            'recorded_by' => Auth::id(),
            'violation_date' => $this->violation_date,
        ]);

        $this->showCreateModal = false;
        $this->clearForm();
        session()->flash('message', 'Violation recorded successfully.');
    }

    public function openEditModal($id)
    {
        $this->resetValidation();
        $this->clearForm();

        $violation = Violation::findOrFail($id);
        $this->selectedViolationId = $id;
        $this->selectedStudentId = $violation->student_id;
        $this->selectedStudentName = $violation->student->first_name . ' ' . $violation->student->last_name;
        $this->title = $violation->title;
        $this->severity = $violation->severity;
        $this->details = $violation->details;
        $this->violation_date = $violation->violation_date->format('Y-m-d');

        $this->showEditModal = true;
    }

    public function updateViolation()
    {
        $this->validate();

        $violation = Violation::findOrFail($this->selectedViolationId);
        $violation->update([
            'student_id' => $this->selectedStudentId,
            'title' => $this->title,
            'severity' => $this->severity,
            'details' => $this->details,
            'violation_date' => $this->violation_date,
        ]);

        $this->showEditModal = false;
        $this->clearForm();
        session()->flash('message', 'Violation record updated successfully.');
    }

    public function openViewModal($id)
    {
        $this->viewingViolation = Violation::with(['student.enrollments', 'recorder'])->findOrFail($id);
        $this->showViewModal = true;
    }

    public function deleteViolation($id)
    {
        $violation = Violation::findOrFail($id);
        $violation->delete();
        session()->flash('message', 'Violation record deleted successfully.');
    }

    private function clearForm()
    {
        $this->selectedViolationId = null;
        $this->selectedStudentId = null;
        $this->selectedStudentName = '';
        $this->title = '';
        $this->severity = 'Low';
        $this->details = '';
        $this->violation_date = date('Y-m-d');
        $this->studentSearch = '';
        $this->studentSearchResults = [];
    }

    public function render()
    {
        $violations = Violation::query()
            ->with(['student.enrollments', 'recorder'])
            ->when($this->search, function ($query) {
                $query->whereHas('student', function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%')
                        ->orWhere('lrn', 'like', '%' . $this->search . '%');
                })->orWhere('title', 'like', '%' . $this->search . '%');
            })
            ->when($this->severityFilter, function ($query) {
                $query->where('severity', $this->severityFilter);
            })
            ->when($this->schoolLevelFilter, function ($query) {
                $query->whereHas('student.enrollments', function ($q) {
                    if ($this->schoolLevelFilter === 'JHS') {
                        $q->whereIn('grade_level', ['Grade 7', 'Grade 8', 'Grade 9', 'Grade 10']);
                    } elseif ($this->schoolLevelFilter === 'SHS') {
                        $q->whereIn('grade_level', ['Grade 11', 'Grade 12']);
                    }
                });
            })
            ->when($this->gradeLevelFilter, function ($query) {
                $query->whereHas('student.enrollments', function ($q) {
                    $q->where('grade_level', $this->gradeLevelFilter);
                });
            })
            ->orderBy('violation_date', 'desc')
            ->paginate(10);

        return view('livewire.admin.student-violations', [
            'violations' => $violations,
        ]);
    }
}
