<?php

namespace App\Livewire\StudentPortal;

use App\Models\Fee;
use Livewire\Component;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class DashboardPortal extends Component
{
    public Enrollment $enrollment;
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
        $schedules = $this->enrollment->section ? $this->enrollment->section->schedules : collect();
        
        $fees = Fee::where(function($query) {
            $query->where('track', $this->enrollment->track)
                  ->orWhere('strand', $this->enrollment->strand)
                  ->orWhere('specialization', $this->enrollment->specialization)
                  ->orWhereNull('track');
        })->get();

        return view('pages.StudentPortal.dashboard-portal', [
            'schedules' => $schedules,
            'fees' => $fees,
            'totalFees' => $fees->sum('amount'),
        ]);
    }
}
