<?php

namespace App\Livewire\Admin;

use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EnrollmentReview extends Component
{
    public Enrollment $enrollment;
    public $admin_remarks;
    public $selected_specialization;
    public $status;

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

    public function enroll(\App\Services\SectioningService $sectioningService, \App\Services\ProvisioningService $provisioningService)
    {
        try {
            // 1. Assign Section based on track and capacity
            $section = $sectioningService->assignSection($this->enrollment);

            // 2. Transition applicant to student role and provision IT accounts
            $user = $this->enrollment->user;
            $user->update(['role' => 'student']);
            $provisioningService->provisionAccount($user);

            // 3. Finalize Enrollment
            $this->enrollment->update([
                'status' => 'Enrolled',
                'finalized_at' => now(),
            ]);

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

    public function render()
    {
        return view('livewire.admin.enrollment-review');
    }
}
