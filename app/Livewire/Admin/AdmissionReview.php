<?php

namespace App\Livewire\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Section;
use App\Models\Student;
use Livewire\Component;
use App\Models\Admission;
use App\Models\Enrollment;
use App\Models\SchoolYear;
use App\Services\SectioningService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\ProvisioningService;

class AdmissionReview extends Component
{
    public $record;
    public $isAdmission = false;
    public $admin_remarks;
    public $selected_specialization;
    public $status;
    public $selected_section_id;
    public $selected_tech_voc_section_id;

    public function mount(Enrollment $enrollment = null, Admission $admission = null)
    {
        if ($admission && $admission->exists) {
            $this->record = $admission;
            $this->isAdmission = true;
            // Normalize for UI
            $data = $admission->form_data;
            $this->admin_remarks = $data['admin_remarks'] ?? '';
            $this->selected_specialization = $data['specialization'] ?? ($data['tech_voc_course1'] ?? '');
            $this->status = $admission->status;
        } else {
            $this->record = $enrollment;
            $this->admin_remarks = $enrollment->admin_remarks;
            $this->selected_specialization = $enrollment->specialization;
            $this->status = $enrollment->status;
        }
    }

    public function approve()
    {
        if ($this->isAdmission) {
            // Check for duplicate LRN in enrollment
            $exists = Enrollment::whereHas('student', function ($query) {
                $query->where('lrn', $this->record->lrn);
            })
                ->whereIn('status', ['Approved', 'Enrolled', 'pending_approval'])
                ->exists();

            if ($exists) {
                session()->flash('error', 'An active enrollment record with this LRN already exists.');
                return;
            }

            $data = $this->record->form_data;
            
            // 1. Create Student Portal Account
            $username = $this->record->lrn;
            $passwordStr = $this->record->birthdate->format('mdY');
            
            $user = User::firstOrCreate(
                ['email' => $username . '@tnts.edu.ph'],
                [
                    'name' => ($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? ''),
                    'password' => Hash::make($passwordStr),
                    'avatar' => $data['profile_picture'] ?? null,
                ]
            );
            if (!$user->hasRole('student')) {
                $user->assignRole('student');
            }

            if ($user->wasRecentlyCreated === false && empty($user->avatar) && !empty($data['profile_picture'])) {
                $user->update(['avatar' => $data['profile_picture']]);
            }

            // 2. Create Student Record
            $student = Student::firstOrCreate(
                ['lrn' => $this->record->lrn],
                array_merge($data, ['user_id' => $user->id])
            );

            // 3. Promote Admission to Enrollment
            $enrollment = Enrollment::create([
                'student_id' => $student->id,
                'school_year_id' => SchoolYear::where('status', 'Active')->value('id'),
                'birthdate' => $this->record->birthdate,
                'transaction_number' => $this->record->transaction_number,
                'status' => 'Approved',
                'specialization' => $this->selected_specialization,
                'admin_remarks' => $this->admin_remarks,
                'verified_by' => Auth::id(),
                'type' => $data['enrollment_type'] ?? 'New',
                'grade_level' => $data['grade_level'] ?? null,
                'track' => $data['track'] ?? null,
                'strand' => $data['strand'] ?? null,
            ]);

            // Delete Admission data once promoted to Enrollment
            $this->record->delete();
            
            session()->flash('message', 'Application promoted to Enrollment and approved.');
            return redirect()->route('admin.enrollment.review', $enrollment->id);
        }

        $this->record->update([
            'status' => 'Approved',
            'specialization' => $this->selected_specialization,
            'admin_remarks' => $this->admin_remarks,
            'verified_by' => Auth::id(),
        ]);

        session()->flash('message', 'Application approved successfully.');
    }

    public function enroll(ProvisioningService $provisioningService)
    {
        if ($this->isAdmission) return;

        try {
            // 1. Transition applicant to student role and provision IT accounts
            $user = $this->record->student ? $this->record->student->user : null;
            if ($user && !$user->hasRole('admin')) {
                $user->assignRole('student');
                $provisioningService->provisionAccount($user);
            }

            // 2. Finalize Enrollment Status
            $updateData = [
                'status' => 'Enrolled',
                'enrolled_at' => now(),
            ];

            $messages = [];
            if ($this->selected_section_id) {
                $updateData['section_id'] = $this->selected_section_id;
                $section = Section::find($this->selected_section_id);
                $messages[] = "Assigned to Section: {$section->name}";
            }

            if ($this->selected_tech_voc_section_id) {
                $updateData['tech_voc_section_id'] = $this->selected_tech_voc_section_id;
                $tvSection = Section::find($this->selected_tech_voc_section_id);
                $messages[] = "Assigned to Tech Voc: {$tvSection->name}";
            }

            $this->record->update($updateData);

            $message = "Student officially enrolled. " . implode(' & ', $messages);
            if (empty($messages)) $message .= " Awaiting section assignment.";

            session()->flash('message', $message);
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function reject()
    {
        $this->record->update(['status' => 'Rejected']);
        session()->flash('message', 'Application has been rejected.');
    }

    public function render(SectioningService $sectioningService)
    {
        $enrollment = $this->record;

        if ($this->isAdmission) {
            $data = $this->record->form_data;
            // Create a wrapper object that behaves like an Enrollment model for the view
            $enrollment = (object) array_merge($data, [
                'id' => $this->record->id,
                'status' => $this->record->status,
                'lrn' => $this->record->lrn,
                'birthdate' => Carbon::parse($this->record->birthdate),
                'type' => $data['enrollment_type'] ?? 'N/A',
                'gwa' => $data['last_gwa'] ?? null,
                'tech_voc_choices' => array_filter([$data['tech_voc_course1'] ?? null, $data['tech_voc_course2'] ?? null, $data['tech_voc_course3'] ?? null]),
                'psa_path' => $data['psa_path'] ?? null,
                'sf9_path' => $data['sf9_path'] ?? null,
                'good_moral_path' => $data['good_moral_path'] ?? null,
                'honorable_dismissal_path' => $data['honorable_dismissal_path'] ?? null,
                'profile_picture' => $data['profile_picture'] ?? null,
            ]);
        } else {
            $student = $this->record->student;
            $enrollment = (object) array_merge($student->toArray(), $this->record->toArray(), [
                'id' => $this->record->id,
                'birthdate' => clone $student->birthdate,
                'profile_picture' => $student->user->avatar ?? null,
                'type' => $this->record->type,
            ]);
        }

        return view('pages.Admin.admission.review', [
            'enrollment' => $enrollment,
            'availableSections' => $sectioningService->getAvailableSectionsForEnrollment($enrollment),
            'availableTechVocSections' => Section::where('grade_level', $enrollment->grade_level)
                ->whereNotNull('specialization')
                ->withCount('techVocEnrollments')
                ->get()
                ->filter(fn($s) => $s->tech_voc_enrollments_count < $s->capacity)
        ]);
    }
}
