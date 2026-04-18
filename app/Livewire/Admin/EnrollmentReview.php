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
    public Enrollment $enrollment;
    public $admin_remarks;
    public $selected_specialization;
    public $status;
    public $selected_section_id;

    public function mount(Enrollment $enrollment)
    {
        $this->enrollment = $enrollment;
        $this->admin_remarks = $enrollment->admin_remarks;
        $this->selected_specialization = $enrollment->specialization;
        $this->status = $enrollment->status;
    }

    public function approve()
    {
        $this->enrollment->update([
            'status' => 'Approved',
            'specialization' => $this->selected_specialization,
            'admin_remarks' => $this->admin_remarks,
            'verified_by' => Auth::id(),
        ]);

        session()->flash('message', 'Application approved successfully.');
    }

    public function enroll(SectioningService $sectioningService, ProvisioningService $provisioningService)
    {
        try {
            // 1. Transition applicant to student role and provision IT accounts
            $user = $this->enrollment->user;
            $user->update(['role' => 'student']);
            $provisioningService->provisionAccount($user);

            // 2. Finalize Enrollment Status
            $this->enrollment->update([
                'status' => 'Enrolled',
                'finalized_at' => now(),
            ]);

            // 3. Assign Section (Manual choice takes priority)
            if ($this->selected_section_id) {
                $section = \App\Models\Section::findOrFail($this->selected_section_id);
                $sectioningService->manualAssign($this->enrollment, $section);
            } else {
                $section = $sectioningService->assignSection($this->enrollment);
            }

            session()->flash('message', "Student officially enrolled in {$section->name} and account provisioned.");
            return redirect()->route('admin.enrollments');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function reject()
    {
        $this->enrollment->update([
            'status' => 'Rejected',
            'admin_remarks' => $this->admin_remarks,
            'verified_by' => Auth::id(),
        ]);

        session()->flash('message', 'Application rejected.');
    }

    public function render(SectioningService $sectioningService)
    {
        return view('pages.Admin.enrollment-review', [
            'isStarQualified' => $sectioningService->checkStarQualification($this->enrollment),
            'availableSections' => $sectioningService->getAvailableSectionsForEnrollment($this->enrollment),
        ]);
    }
}
