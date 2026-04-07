<?php

namespace App\Services;

use App\Models\Enrollment;
use App\Models\Section;
use Exception;

class SectioningService
{
    /**
     * Run the automated batch sectioning algorithm.
     */
    public function runBatchSectioning(string $gradeLevel, ?string $track = null, ?string $strand = null, ?string $specialization = null): array
    {
        // 1. Fetch unassigned students for the specific grade level/track
        $query = Enrollment::where('grade_level', $gradeLevel)
            ->where('status', 'Approved')
            ->whereNull('section_id');

        if ($track) $query->where('track', $track);
        if ($strand) $query->where('strand', $strand);
        if ($specialization) $query->where('specialization', $specialization);

        $unassignedStudents = $query->orderByDesc('gwa')
            ->orderBy('created_at') // Tie-breaker: Timestamp
            ->get();

        if ($unassignedStudents->isEmpty()) {
            return ['status' => 'info', 'message' => 'No unassigned students found for this criteria.'];
        }

        // 2. Fetch available sections
        $sectionQuery = Section::where('grade_level', $gradeLevel);
        if ($track) $sectionQuery->where('track', $track);
        if ($strand) $sectionQuery->where('strand', $strand);
        if ($specialization) $sectionQuery->where('specialization', $specialization);
        
        $sections = $sectionQuery->get();
        /** @var Section $starSection */
        $starSection = $sections->firstWhere('is_star_section', true);
        $regularSections = $sections->where('is_star_section', false)->values();

        if ($sections->isEmpty()) {
            throw new Exception("No sections found for {$gradeLevel}. Please create sections first.");
        }

        $assignedCount = 0;
        $remainingStudents = $unassignedStudents;

        // 3. Fill Star Section First
        if ($starSection && $starSection->enrollments()->count() < $starSection->capacity) {
            $toAssign = $remainingStudents->take($starSection->capacity - $starSection->enrollments()->count());
            
            foreach ($toAssign as $student) {
                $student->update(['section_id' => $starSection->id]);
                $assignedCount++;
            }
            $remainingStudents = $remainingStudents->slice($toAssign->count());
        }

        // 4. Gender-Balanced Serpentine Distribution for Regular Sections
        if ($regularSections->isNotEmpty() && $remainingStudents->isNotEmpty()) {
            $females = $remainingStudents->where('sex', 'Female')->values();
            $males = $remainingStudents->where('sex', 'Male')->values();

            $assignedCount += $this->serpentineDistribute($females, $regularSections);
            $assignedCount += $this->serpentineDistribute($males, $regularSections);
        }

        $totalRemaining = Enrollment::where('grade_level', $gradeLevel)
            ->where('status', 'Approved')
            ->whereNull('section_id')
            ->count();

        return [
            'status' => 'success',
            'message' => "Batch complete. {$assignedCount} students assigned. {$totalRemaining} students remaining.",
            'assigned' => $assignedCount,
            'remaining' => $totalRemaining
        ];
    }

    /**
     * Distribute students using a serpentine pattern across sections.
     */
    private function serpentineDistribute($students, $sections): int
    {
        $assigned = 0;
        $sectionCount = $sections->count();
        $direction = 1; // 1 for forward, -1 for backward
        $currentIndex = 0;

        foreach ($students as $student) {
            // Find a section starting from currentIndex that has capacity
            $found = false;
            $attempts = 0;

            while ($attempts < $sectionCount) {
                $section = $sections[$currentIndex];
                if ($section->enrollments()->count() < $section->capacity) {
                    $student->update(['section_id' => $section->id]);
                    $assigned++;
                    $found = true;
                    
                    // Move to next section in serpentine pattern
                    if ($direction == 1) {
                        if ($currentIndex == $sectionCount - 1) {
                            $direction = -1;
                        } else {
                            $currentIndex++;
                        }
                    } else {
                        if ($currentIndex == 0) {
                            $direction = 1;
                        } else {
                            $currentIndex--;
                        }
                    }
                    break;
                }

                // If full, skip to next in current direction or wrap
                $currentIndex += $direction;
                if ($currentIndex >= $sectionCount) { $currentIndex = $sectionCount - 1; $direction = -1; }
                if ($currentIndex < 0) { $currentIndex = 0; $direction = 1; }
                $attempts++;
            }

            if (!$found) break; // All sections full
        }

        return $assigned;
    }

    /**
     * Get the average GWA of the Star Section for comparison.
     */
    public function getStarSectionAverage(string $gradeLevel): float
    {
        $starSection = Section::where('grade_level', $gradeLevel)
            ->where('is_star_section', true)
            ->first();

        if (!$starSection) return 0;

        return (float) $starSection->enrollments()->avg('gwa') ?: 0;
    }

    /**
     * Check if a student qualifies for the Star Section.
     */
    public function checkStarQualification(Enrollment $enrollment): bool
    {
        $avg = $this->getStarSectionAverage($enrollment->grade_level);
        return $enrollment->gwa >= $avg && $avg > 0;
    }

    /**
     * Manual assignment (Bypasses capacity if done by Guidance)
     */
    public function manualAssign(Enrollment $enrollment, Section $section): void
    {
        $enrollment->update(['section_id' => $section->id]);
    }

    /**
     * Legacy method for individual assignment (Modified to use new logic if needed)
     */
    public function assignSection(Enrollment $enrollment): Section
    {
        // For individual assignment, we just find the first available section matching criteria
        $query = Section::where('grade_level', $enrollment->grade_level);

        if ($enrollment->track) $query->where('track', $enrollment->track);
        if ($enrollment->strand) $query->where('strand', $enrollment->strand);
        if ($enrollment->specialization) $query->where('specialization', $enrollment->specialization);

        $sections = $query->get();

        foreach ($sections as $section) {
            /** @var Section $section */
            if ($section->enrollments()->count() < $section->capacity) {
                $enrollment->update(['section_id' => $section->id]);
                return $section;
            }
        }

        throw new Exception("No available capacity in matching sections.");
    }
}
