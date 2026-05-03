<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use App\Models\Enrollment;
use App\Services\SectioningService;
use Illuminate\Support\Facades\Auth;
use App\Services\ProvisioningService;

class EnrollmentReview extends Component
{
    public $record;
    public $isPre = false;
    public $admin_remarks;
    public $selected_specialization;
    public $status;
    public $selected_section_id;

    public function mount(Enrollment $enrollment = null, \App\Models\PreEnrollment $preEnrollment = null)
    {
        if ($preEnrollment && $preEnrollment->exists) {
            $this->record = $preEnrollment;
            $this->isPre = true;
            // Normalize for UI
            $data = $preEnrollment->form_data;
            $this->admin_remarks = $data['admin_remarks'] ?? '';
            $this->selected_specialization = $data['specialization'] ?? ($data['tech_voc_course1'] ?? '');
            $this->status = $preEnrollment->status;
        } else {
            $this->record = $enrollment;
            $this->admin_remarks = $enrollment->admin_remarks;
            $this->selected_specialization = $enrollment->specialization;
            $this->status = $enrollment->status;
        }
    }

    public function approve()
    {
        if ($this->isPre) {
            // Promote PreEnrollment to Enrollment
            $data = $this->record->form_data;
            
            $enrollment = Enrollment::create(array_merge($data, [
                'user_id' => $this->record->user_id ?? auth()->id(), // Fallback if no user_id
                'lrn' => $this->record->lrn,
                'birthdate' => $this->record->birthdate,
                'transaction_number' => $this->record->transaction_number,
                'status' => 'Approved',
                'specialization' => $this->selected_specialization,
                'admin_remarks' => $this->admin_remarks,
                'verified_by' => Auth::id(),
                'type' => $data['enrollment_type'] ?? 'New',
                'gwa' => $data['last_gwa'] ?? null,
            ]));

            // Update PreEnrollment status
            $this->record->update(['status' => 'approved']);
            
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

    public function enroll(SectioningService $sectioningService, ProvisioningService $provisioningService)
    {
        if ($this->isPre) return;

        try {
            // 1. Transition applicant to student role and provision IT accounts
            $user = $this->record->user;
            if ($user) {
                $user->update(['role' => 'student']);
                $provisioningService->provisionAccount($user);
            }

            // 2. Assign Section
            $section = $this->selected_section_id 
                ? \App\Models\Section::find($this->selected_section_id)
                : $sectioningService->assignSection($this->record);

            // 3. Finalize Enrollment Status
            $this->record->update([
                'status' => 'Enrolled',
                'section_id' => $section->id,
                'enrolled_at' => now(),
            ]);

            session()->flash('message', "Student officially enrolled in Section: {$section->name}");
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

        if ($this->isPre) {
            $data = $this->record->form_data;
            // Create a wrapper object that behaves like an Enrollment model for the view
            $enrollment = (object) array_merge($data, [
                'id' => $this->record->id,
                'status' => $this->record->status,
                'lrn' => $this->record->lrn,
                'birthdate' => \Carbon\Carbon::parse($this->record->birthdate),
                'type' => $data['enrollment_type'] ?? 'N/A',
                'gwa' => $data['last_gwa'] ?? null,
                'tech_voc_choices' => array_filter([$data['tech_voc_course1'] ?? null, $data['tech_voc_course2'] ?? null, $data['tech_voc_course3'] ?? null]),
                'psa_path' => $data['psa_path'] ?? null,
                'sf9_path' => $data['sf9_path'] ?? null,
                'good_moral_path' => $data['good_moral_path'] ?? null,
                'honorable_dismissal_path' => $data['honorable_dismissal_path'] ?? null,
            ]);
        }

        return view('pages.Admin.enrollment-review', [
            'enrollment' => $enrollment,
            'isStarQualified' => $sectioningService->checkStarQualification($enrollment),
            'availableSections' => $sectioningService->getAvailableSectionsForEnrollment($enrollment),
        ]);
    }
}
