<?php

namespace App\Livewire\Admin;

use App\Models\Section;
use Livewire\Component;
use App\Models\Enrollment;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class StudentMasterlist extends Component
{
    use WithPagination, WithFileUploads;

    #[Url]
    public $search = '';

    #[Url]
    public $grade_level = '';

    #[Url]
    public $status = 'Enrolled';

    #[Url]
    public $category = '';

    // Modal state
    public $showEditModal = false;

    public $showSectionModal = false;

    public $selectedStudentId = null;

    public $showExportModal = false;

    // Export Modal state
    public $export_school_level = 'All';

    public $export_grade_level = 'All';

    public $export_section_id = 'All';

    public $isExporting = false;

    // Edit fields
    public $edit_first_name = '';

    public $edit_last_name = '';

    public $edit_middle_name = '';

    public $edit_extension_name = '';

    public $edit_lrn = '';

    public $edit_birthdate = '';

    public $edit_sex = '';

    public $edit_gwa = '';

    public $edit_contact_no = '';

    public $edit_status = '';

    public $edit_grade_level = '';

    public $edit_profile_picture_upload;

    public $edit_profile_picture = '';

    public $delete_current_photo = false;

    // Section assignment fields
    public $selected_section_id = '';

    public $selected_tech_voc_section_id = '';

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

    public function editStudent($id)
    {
        $student = Enrollment::findOrFail($id);
        $this->selectedStudentId = $id;
        $this->edit_first_name = $student->first_name;
        $this->edit_last_name = $student->last_name;
        $this->edit_middle_name = $student->middle_name;
        $this->edit_extension_name = $student->extension_name;
        $this->edit_lrn = $student->lrn;
        $this->edit_birthdate = $student->birthdate ? $student->birthdate->format('Y-m-d') : '';
        $this->edit_sex = $student->sex;
        $this->edit_gwa = $student->gwa;
        $this->edit_contact_no = $student->contact_no;
        $this->edit_status = $student->status;
        $this->edit_grade_level = $student->grade_level;
        $this->edit_profile_picture = $student->profile_picture;
        $this->edit_profile_picture_upload = null;
        $this->delete_current_photo = false;

        $this->showEditModal = true;
    }

    public function removeCurrentPhoto()
    {
        $this->edit_profile_picture = null;
        $this->delete_current_photo = true;
        $this->edit_profile_picture_upload = null;
    }

    public function saveStudent()
    {
        $this->validate([
            'edit_first_name' => 'required|string|max:255',
            'edit_last_name' => 'required|string|max:255',
            'edit_middle_name' => 'nullable|string|max:255',
            'edit_extension_name' => 'nullable|string|max:255',
            'edit_lrn' => 'required|string|max:20',
            'edit_birthdate' => 'required|date',
            'edit_sex' => 'required|in:Male,Female',
            'edit_gwa' => 'nullable|numeric|min:50|max:100',
            'edit_contact_no' => 'required|string|max:20',
            'edit_status' => 'required|string',
            'edit_grade_level' => 'required|string',
            'edit_profile_picture_upload' => 'nullable|image|max:5120',
        ]);

        $student = Enrollment::findOrFail($this->selectedStudentId);
        $oldGrade = $student->grade_level;

        $updateData = [
            'first_name' => $this->edit_first_name,
            'last_name' => $this->edit_last_name,
            'middle_name' => $this->edit_middle_name,
            'extension_name' => $this->edit_extension_name,
            'lrn' => $this->edit_lrn,
            'birthdate' => $this->edit_birthdate,
            'sex' => $this->edit_sex,
            'gwa' => $this->edit_gwa,
            'contact_no' => $this->edit_contact_no,
            'status' => $this->edit_status,
            'grade_level' => $this->edit_grade_level,
        ];

        if ($this->edit_profile_picture_upload) {
            // Delete old photo file if exists
            if ($student->profile_picture && Storage::disk('public')->exists($student->profile_picture)) {
                Storage::disk('public')->delete($student->profile_picture);
            }

            $path = $this->edit_profile_picture_upload->store('enrollments/photos', 'public');
            $updateData['profile_picture'] = $path;

            // Also update corresponding user's avatar if they have a user account
            if ($student->user) {
                $student->user->update(['avatar' => $path]);
            }
        } elseif ($this->delete_current_photo) {
            // Delete old photo file if exists
            if ($student->profile_picture && Storage::disk('public')->exists($student->profile_picture)) {
                Storage::disk('public')->delete($student->profile_picture);
            }
            $updateData['profile_picture'] = null;

            // Also clear corresponding user's avatar if they have a user account
            if ($student->user) {
                $student->user->update(['avatar' => null]);
            }
        }

        $student->update($updateData);

        if ($oldGrade !== $this->edit_grade_level) {
            $student->update([
                'section_id' => null,
                'tech_voc_section_id' => null,
            ]);
        }

        $this->showEditModal = false;
        session()->flash('message', 'Student record updated successfully.');
    }

    public function openSectionModal($id)
    {
        $student = Enrollment::findOrFail($id);
        $this->selectedStudentId = $id;
        $this->selected_section_id = $student->section_id;
        $this->selected_tech_voc_section_id = $student->tech_voc_section_id;
        $this->showSectionModal = true;
    }

    public function saveSection()
    {
        $student = Enrollment::findOrFail($this->selectedStudentId);

        $updateData = [
            'section_id' => $this->selected_section_id ?: null,
        ];

        $messages = [];
        if ($this->selected_section_id) {
            $section = Section::find($this->selected_section_id);
            $messages[] = "Assigned to Section: {$section->name}";
        } else {
            $messages[] = 'Removed Academic Section';
        }

        if (in_array($student->grade_level, ['Grade 8', 'Grade 9', 'Grade 10'])) {
            $updateData['tech_voc_section_id'] = $this->selected_tech_voc_section_id ?: null;
            if ($this->selected_tech_voc_section_id) {
                $tvSection = Section::find($this->selected_tech_voc_section_id);
                $messages[] = "Assigned to Tech Voc Section: {$tvSection->name}";
            } else {
                $messages[] = 'Removed Tech Voc Section';
            }
        }

        $student->update($updateData);

        $this->showSectionModal = false;
        session()->flash('message', 'Section assignments updated: '.implode(' & ', $messages));
    }

    public function render()
    {
        $students = Enrollment::query()
            ->with(['section', 'techVocSection'])
            ->whereIn('status', ['Enrolled', 'Approved', 'Rejected', 'Submitted', 'Dropped', 'Graduated'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('first_name', 'like', '%'.$this->search.'%')
                        ->orWhere('last_name', 'like', '%'.$this->search.'%')
                        ->orWhere('lrn', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->grade_level && $this->grade_level !== 'All Levels', fn ($q) => $q->where('grade_level', $this->grade_level))
            ->when($this->category, function ($q) {
                if ($this->category === 'HS') {
                    $q->whereIn('grade_level', ['Grade 7', 'Grade 8', 'Grade 9', 'Grade 10']);
                } elseif ($this->category === 'SHS') {
                    $q->whereIn('grade_level', ['Grade 11', 'Grade 12']);
                }
            })
            ->when($this->status && $this->status !== 'All Status', fn ($q) => $q->where('status', $this->status))
            ->orderBy('last_name')
            ->paginate(15);

        $availableSections = collect();
        $availableTechVocSections = collect();
        $selectedStudentForSection = null;

        if ($this->showSectionModal && $this->selectedStudentId) {
            $selectedStudentForSection = Enrollment::find($this->selectedStudentId);
            if ($selectedStudentForSection) {
                $sectionQuery = Section::where('grade_level', $selectedStudentForSection->grade_level);
                if ($selectedStudentForSection->strand) {
                    $sectionQuery->where('strand', $selectedStudentForSection->strand);
                } else {
                    $sectionQuery->whereNull('specialization');
                }
                $availableSections = $sectionQuery->withCount('enrollments')->get();

                if (in_array($selectedStudentForSection->grade_level, ['Grade 8', 'Grade 9', 'Grade 10'])) {
                    $availableTechVocSections = Section::where('grade_level', $selectedStudentForSection->grade_level)
                        ->whereNotNull('specialization')
                        ->withCount('techVocEnrollments')
                        ->get();
                }
            }
        }

        $exportSections = collect();
        if ($this->export_school_level !== 'All' && $this->export_grade_level !== 'All') {
            $exportSections = Section::where('grade_level', $this->export_grade_level)
                ->orderBy('name')
                ->get();
        }

        // Calculate summary counts
        $gradeStats = [];
        $gradesList = ['Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'];
        foreach ($gradesList as $grade) {
            $gradeStats[$grade] = [
                'enrolled' => Enrollment::where('grade_level', $grade)->where('status', 'Enrolled')->count(),
                'total' => Enrollment::where('grade_level', $grade)->whereIn('status', ['Enrolled', 'Approved', 'Rejected', 'Submitted', 'Dropped', 'Graduated'])->count(),
            ];
        }
        $totalEnrolled = Enrollment::where('status', 'Enrolled')->count();
        $totalAll = Enrollment::whereIn('status', ['Enrolled', 'Approved', 'Rejected', 'Submitted', 'Dropped', 'Graduated'])->count();

        return view('livewire.admin.student-masterlist', [
            'students' => $students,
            'availableSections' => $availableSections,
            'availableTechVocSections' => $availableTechVocSections,
            'selectedStudentForSection' => $selectedStudentForSection,
            'exportSections' => $exportSections,
            'gradeStats' => $gradeStats,
            'totalEnrolled' => $totalEnrolled,
            'totalAll' => $totalAll,
        ]);
    }

    public function updatedExportSchoolLevel($value)
    {
        $this->export_grade_level = 'All';
        $this->export_section_id = 'All';
    }

    public function updatedExportGradeLevel($value)
    {
        $this->export_section_id = 'All';
    }

    public function openExportModal()
    {
        $this->export_school_level = 'All';
        $this->export_grade_level = 'All';
        $this->export_section_id = 'All';
        $this->showExportModal = true;
    }

    private function formatStudentRow($student)
    {
        $middleInitial = $student->middle_name ? ' ' . strtoupper(substr($student->middle_name, 0, 1)) : '';
        $name = strtoupper("{$student->last_name}, {$student->first_name}{$middleInitial}");

        $address = trim("{$student->current_house_no} {$student->current_street} {$student->current_barangay} {$student->current_municipality} {$student->current_province}");

        $sectionName = 'N/A';
        $adviserName = 'N/A';
        if ($student->section) {
            $sectionName = $student->section->name;
            if ($student->section->adviser) {
                $adviserName = $student->section->adviser->name;
            }
            if ($student->techVocSection) {
                $sectionName .= ' / TVL: ' . $student->techVocSection->name;
                if ($adviserName === 'N/A' && $student->techVocSection->adviser) {
                    $adviserName = $student->techVocSection->adviser->name;
                }
            }
        } elseif ($student->techVocSection) {
            $sectionName = 'TVL: ' . $student->techVocSection->name;
            if ($student->techVocSection->adviser) {
                $adviserName = $student->techVocSection->adviser->name;
            }
        }

        return [
            $student->lrn,
            $name,
            $student->birthdate ? $student->birthdate->format('Y-m-d') : 'N/A',
            $student->guardian_name ?? 'N/A',
            $address ?: 'N/A',
            $student->contact_no ?? 'N/A',
            $student->grade_level,
            $sectionName,
            $adviserName,
        ];
    }

    public function exportMasterlist()
    {
        $filters = [
            'status' => $this->status,
            'export_school_level' => $this->export_school_level,
            'export_grade_level' => $this->export_grade_level,
            'export_section_id' => $this->export_section_id,
        ];

        \App\Jobs\ExportStudentMasterlistJob::dispatch(auth()->id(), $filters);

        $this->showExportModal = false;
        $this->isExporting = true;
        
        session()->flash('message', 'Export is processing in the background. You can continue using the system.');
    }

    public function checkExportStatus()
    {
        if (!$this->isExporting) {
            return;
        }

        $statusData = \Illuminate\Support\Facades\Cache::get('export_status_' . auth()->id());

        if (!$statusData) {
            return;
        }

        if ($statusData['status'] === 'completed') {
            $this->isExporting = false;
            \Illuminate\Support\Facades\Cache::forget('export_status_' . auth()->id());
            
            session()->flash('message', 'Export completed successfully! Downloading...');
            
            $this->js('window.location.href = "' . route('admin.export.download', ['file' => $statusData['file']]) . '";');
        } elseif ($statusData['status'] === 'failed') {
            $this->isExporting = false;
            \Illuminate\Support\Facades\Cache::forget('export_status_' . auth()->id());
            
            $errorMessage = $statusData['message'] ?? 'An error occurred during export.';
            session()->flash('error', 'Export failed: ' . $errorMessage);
        }
    }
}
