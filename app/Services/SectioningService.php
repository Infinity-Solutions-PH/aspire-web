<?php

namespace App\Services;

use App\Models\Enrollment;
use App\Models\Section;
use Exception;

class SectioningService
{
    /**
     * Automatically assign a student to a section based on their enrollment details.
     */
    public function assignSection(Enrollment $enrollment): Section
    {
        // 1. Find potential sections matching the student's criteria
        $query = Section::where('grade_level', $enrollment->grade_level);

        if ($enrollment->track) {
            $query->where('track', $enrollment->track);
        }

        if ($enrollment->strand) {
            $query->where('strand', $enrollment->strand);
        }

        if ($enrollment->specialization) {
            $query->where('specialization', $enrollment->specialization);
        }

        $sections = $query->get();

        if ($sections->isEmpty()) {
            throw new Exception("No sections found for the specified track/grade level. Please create a section first.");
        }

        // 2. Find the first section with available capacity
        foreach ($sections as $section) {
            $currentEnrollments = $section->enrollments()->count();
            if ($currentEnrollments < $section->capacity) {
                $enrollment->update(['section_id' => $section->id]);
                return $section;
            }
        }

        throw new Exception("All matching sections are at full capacity. Please contact the Registrar to open a new section.");
    }
}
