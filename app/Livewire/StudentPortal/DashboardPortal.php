<?php

namespace App\Livewire\StudentPortal;

use App\Models\Fee;
use Livewire\Component;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class DashboardPortal extends Component
{
    public ?Enrollment $enrollment = null;
    public $activeTab = 'schedule';

    public function mount()
    {
        $this->enrollment = Enrollment::where('user_id', Auth::id())
            ->where('status', 'Enrolled')
            ->with(['section.schedules.subject', 'section.schedules.room', 'section.schedules.teacher'])
            ->latest()
            ->first();
    }

    public function render()
    {
        if (!$this->enrollment) {
            return view('pages.StudentPortal.dashboard-portal', [
                'schedules' => collect()
            ]);
        }

        $schedules = $this->enrollment->section ? $this->enrollment->section->schedules : collect();

        return view('pages.StudentPortal.dashboard-portal', [
            'schedules' => $schedules
        ]);
    }
}
