<?php

namespace App\Livewire\Faculty;

use App\Models\User;
use App\Models\Section;
use App\Models\Schedule;
use App\Models\Enrollment;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.faculty-portal')]
class Dashboard extends Component
{
    public function render()
    {
        $userId = auth()->id();

        // 1. Handled subjects count
        $handledSubjectsCount = Schedule::where('teacher_id', $userId)
            ->distinct('subject_id')
            ->count('subject_id');

        // 2. Handled sections count
        $handledSectionsCount = Schedule::where('teacher_id', $userId)
            ->distinct('section_id')
            ->count('section_id');

        // 3. Advisees count (enrolled in sections where this teacher is adviser)
        $adviserSections = Section::where('adviser_id', $userId)->get();
        $adviserTvlSectionIds = $adviserSections->filter(function($section) {
            return !empty($section->specialization) && in_array($section->grade_level, ['Grade 8', 'Grade 9', 'Grade 10']);
        })->pluck('id');
        $adviserNormalSectionIds = $adviserSections->reject(function($section) {
            return !empty($section->specialization) && in_array($section->grade_level, ['Grade 8', 'Grade 9', 'Grade 10']);
        })->pluck('id');
        
        $adviseesCount = 0;
        if ($adviserNormalSectionIds->isNotEmpty() || $adviserTvlSectionIds->isNotEmpty()) {
            $adviseesCount = Enrollment::where('status', 'Enrolled')
                ->where(function ($q) use ($adviserNormalSectionIds, $adviserTvlSectionIds) {
                    $q->whereIn('section_id', $adviserNormalSectionIds)
                      ->orWhereIn('tech_voc_section_id', $adviserTvlSectionIds);
                })
                ->count();
        }

        // 4. Total students teaching count
        $taughtSectionIds = Schedule::where('teacher_id', $userId)->pluck('section_id')->unique();
        $taughtSections = Section::whereIn('id', $taughtSectionIds)->get();
        $taughtTvlSectionIds = $taughtSections->filter(function($section) {
            return !empty($section->specialization) && in_array($section->grade_level, ['Grade 8', 'Grade 9', 'Grade 10']);
        })->pluck('id');
        $taughtNormalSectionIds = $taughtSections->reject(function($section) {
            return !empty($section->specialization) && in_array($section->grade_level, ['Grade 8', 'Grade 9', 'Grade 10']);
        })->pluck('id');
        
        $totalStudentsCount = 0;
        if ($taughtNormalSectionIds->isNotEmpty() || $taughtTvlSectionIds->isNotEmpty()) {
            $totalStudentsCount = Enrollment::where('status', 'Enrolled')
                ->where(function ($q) use ($taughtNormalSectionIds, $taughtTvlSectionIds) {
                    $q->whereIn('section_id', $taughtNormalSectionIds)
                      ->orWhereIn('tech_voc_section_id', $taughtTvlSectionIds);
                })
                ->distinct('student_id')
                ->count('student_id');
        }

        // 5. Schedules for display
        $schedules = Schedule::with(['section', 'subject', 'room'])
            ->where('teacher_id', $userId)
            ->orderByRaw("CASE day 
                WHEN 'Monday' THEN 1 
                WHEN 'Tuesday' THEN 2 
                WHEN 'Wednesday' THEN 3 
                WHEN 'Thursday' THEN 4 
                WHEN 'Friday' THEN 5 
                ELSE 6 END")
            ->orderBy('start_time')
            ->get();

        return view('livewire.faculty.dashboard', [
            'handledSubjectsCount' => $handledSubjectsCount,
            'handledSectionsCount' => $handledSectionsCount,
            'adviseesCount' => $adviseesCount,
            'totalStudentsCount' => $totalStudentsCount,
            'schedules' => $schedules,
        ]);
    }
}
