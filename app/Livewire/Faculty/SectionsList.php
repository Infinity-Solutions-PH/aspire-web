<?php

namespace App\Livewire\Faculty;

use App\Models\Section;
use App\Models\Schedule;
use App\Models\Enrollment;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.faculty-portal')]
class SectionsList extends Component
{
    public function render()
    {
        $userId = auth()->id();

        // Get section IDs where the teacher teaches
        $taughtSectionIds = Schedule::where('teacher_id', $userId)->pluck('section_id')->unique();

        // Fetch sections where they either teach OR are the adviser
        $sections = Section::with(['adviser', 'room'])
            ->where(function ($q) use ($userId, $taughtSectionIds) {
                $q->where('adviser_id', $userId)
                  ->orWhereIn('id', $taughtSectionIds);
            })
            ->get();

        // Map section details (role and student count)
        $mappedSections = $sections->map(function ($section) use ($userId) {
            $isAdviser = $section->adviser_id === $userId;
            
            // Student count logic based on track (normal vs TVL)
            $count = Enrollment::where('status', 'Enrolled')
                ->where(function ($q) use ($section) {
                    if (!empty($section->specialization) && in_array($section->grade_level, ['Grade 8', 'Grade 9', 'Grade 10'])) {
                        $q->where('tech_voc_section_id', $section->id);
                    } else {
                        $q->where('section_id', $section->id);
                    }
                })
                ->count();

            return (object) [
                'id' => $section->id,
                'name' => $section->name,
                'grade_level' => $section->grade_level,
                'track' => $section->track,
                'strand' => $section->strand,
                'specialization' => $section->specialization,
                'room' => $section->room ? $section->room->name : 'N/A',
                'role' => $isAdviser ? 'Adviser' : 'Subject Teacher',
                'student_count' => $count,
                'adviser_name' => $section->adviser ? $section->adviser->name : 'N/A',
            ];
        });

        return view('livewire.faculty.sections-list', [
            'sections' => $mappedSections,
        ]);
    }
}
