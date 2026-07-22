<?php

namespace App\Livewire\Admin\Section;

use App\Models\Section;
use App\Models\Student;
use Livewire\Component;
use App\Models\Enrollment;
use Livewire\WithPagination;

class ManageStudents extends Component
{
    use WithPagination;

    public Section $section;
    public $search = '';
    public $activeSex = 'All';

    // Transfer Modal state
    public $showTransferModal = false;
    public $selectedStudentId = null;
    public $selected_section_id = '';
    public $selected_tech_voc_section_id = '';

    public function mount(Section $section)
    {
        $this->section = $section->load('adviser');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingActiveSex()
    {
        $this->resetPage();
    }

    public function openTransferModal($id)
    {
        $student = Enrollment::findOrFail($id);
        $this->selectedStudentId = $id;
        $this->selected_section_id = $student->section_id;
        $this->selected_tech_voc_section_id = $student->tech_voc_section_id;
        $this->showTransferModal = true;
    }

    public function saveTransfer()
    {
        $student = Enrollment::findOrFail($this->selectedStudentId);

        $updateData = [
            'section_id' => $this->selected_section_id ?: null,
        ];

        $messages = [];
        if ($this->selected_section_id) {
            $newSec = Section::find($this->selected_section_id);
            $messages[] = "Transferred to Section: {$newSec->name}";
        } else {
            $messages[] = "Removed Academic Section";
        }

        if (in_array($student->grade_level, ['Grade 8', 'Grade 9', 'Grade 10'])) {
            $updateData['tech_voc_section_id'] = $this->selected_tech_voc_section_id ?: null;
            if ($this->selected_tech_voc_section_id) {
                $tvSec = Section::find($this->selected_tech_voc_section_id);
                $messages[] = "Transferred to Tech Voc Section: {$tvSec->name}";
            } else {
                $messages[] = "Removed Tech Voc Section";
            }
        }

        $student->update($updateData);

        $this->showTransferModal = false;
        session()->flash('message', 'Student section transfer completed: ' . implode(' & ', $messages));
    }

    public function render()
    {
        $sectionColumn = (!empty($this->section->specialization) && in_array($this->section->grade_level, ['Grade 8', 'Grade 9', 'Grade 10']))
            ? 'tech_voc_section_id'
            : 'section_id';

        $baseQuery = Enrollment::query()
            ->select('enrollments.*')
            ->addSelect(['last_name' => Student::select('last_name')->whereColumn('id', 'enrollments.student_id')->limit(1)])
            ->addSelect(['first_name' => Student::select('first_name')->whereColumn('id', 'enrollments.student_id')->limit(1)])
            ->addSelect(['sex' => Student::select('sex')->whereColumn('id', 'enrollments.student_id')->limit(1)])
            ->with(['techVocSection', 'student'])
            ->where('enrollments.'.$sectionColumn, $this->section->id)
            ->when($this->search, function($query) {
                $query->whereHas('student', function($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%')
                      ->orWhere('lrn', 'like', '%' . $this->search . '%');
                });
            });

        $totalMales = (clone $baseQuery)->whereHas('student', function($q){ $q->where('sex', 'Male'); })->count();
        $totalFemales = (clone $baseQuery)->whereHas('student', function($q){ $q->where('sex', 'Female'); })->count();

        $students = $baseQuery->when($this->activeSex !== 'All', function($query) {
                $query->having('sex', $this->activeSex);
            })
            ->orderBy('sex', 'desc') // 'Male' before 'Female'
            ->orderBy('last_name', 'asc')
            ->orderBy('first_name', 'asc')
            ->paginate(10);

        $availableSections = collect();
        $availableTechVocSections = collect();
        $selectedStudentForTransfer = null;

        if ($this->showTransferModal && $this->selectedStudentId) {
            $selectedStudentForTransfer = Enrollment::find($this->selectedStudentId);
            if ($selectedStudentForTransfer) {
                $sectionQuery = Section::where('grade_level', $selectedStudentForTransfer->grade_level);
                if ($selectedStudentForTransfer->strand) {
                    $sectionQuery->where('strand', $selectedStudentForTransfer->strand);
                } else {
                    $sectionQuery->whereNull('specialization');
                }
                $availableSections = $sectionQuery->withCount('enrollments')->get();

                if (in_array($selectedStudentForTransfer->grade_level, ['Grade 8', 'Grade 9', 'Grade 10'])) {
                    $availableTechVocSections = Section::where('grade_level', $selectedStudentForTransfer->grade_level)
                        ->whereNotNull('specialization')
                        ->withCount('techVocEnrollments')
                        ->get();
                }
            }
        }

        return view('livewire.admin.section.manage-students', [
            'students' => $students,
            'totalMales' => $totalMales,
            'totalFemales' => $totalFemales,
            'availableSections' => $availableSections,
            'availableTechVocSections' => $availableTechVocSections,
            'selectedStudentForTransfer' => $selectedStudentForTransfer,
        ])->layout('layouts.app');
    }
}

