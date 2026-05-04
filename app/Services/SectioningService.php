<?php

namespace App\Services;

use Exception;
use App\Models\Section;
use App\Models\Enrollment;

class SectioningService
{
    /**
     * Run JHS / SHS Sectioning (Star + Gender Balanced Round-Robin)
     */
    public function runJhsShsSectioning(string $gradeLevel, ?string $strand = null): array
    {
        $query = Enrollment::where('grade_level', $gradeLevel)
            ->where('status', 'Enrolled')
            ->whereNull('section_id');

        if ($strand) {
            $query->where('strand', $strand);
        } else {
            $query->where(function($q) {
                $q->whereNull('track')->orWhere('track', '!=', 'TVL');
            });
        }

        $unassignedStudents = $query->orderByDesc('gwa')
            ->orderBy('created_at')
            ->get();

        if ($unassignedStudents->isEmpty()) {
            return ['status' => 'info', 'message' => 'No unassigned students found for this criteria.'];
        }

        $sectionQuery = Section::where('grade_level', $gradeLevel);
        if ($strand) {
            $sectionQuery->where('strand', $strand);
        } else {
            $sectionQuery->where(function($q) {
                $q->whereNull('track')->orWhere('track', '!=', 'TVL');
            });
        }

        $sections = $sectionQuery->get();
        $starSections = $sections->where('is_star_section', true)->values();
        $regularSections = $sections->where('is_star_section', false)->values();

        if ($sections->isEmpty()) {
            throw new Exception("No sections found for {$gradeLevel}. Please create sections first.");
        }

        $assignedCount = 0;
        $remainingStudents = collect($unassignedStudents);

        // Step 1: Star Section Allocation (GWA >= 90)
        if ($starSections->isNotEmpty()) {
            $starCandidates = $remainingStudents->filter(function($student) {
                $gwa = (float) ($student->gwa ?? ($student->last_gwa ?? 0));
                return $gwa >= 90;
            });

            foreach ($starSections as $starSection) {
                $availableCapacity = $starSection->capacity - $starSection->enrollments()->count();
                if ($availableCapacity > 0) {
                    $toAssign = $starCandidates->take($availableCapacity);
                    foreach ($toAssign as $student) {
                        $student->update(['section_id' => $starSection->id]);
                        $assignedCount++;
                        // Remove from pools
                        $starCandidates = $starCandidates->reject(fn($s) => $s->id === $student->id);
                        $remainingStudents = $remainingStudents->reject(fn($s) => $s->id === $student->id);
                    }
                }
            }
        }

        // Step 2: Gender-Balanced Distribution for Regular Sections
        if ($regularSections->isNotEmpty() && $remainingStudents->isNotEmpty()) {
            $females = $remainingStudents->where('sex', 'Female')->values();
            $males = $remainingStudents->where('sex', 'Male')->values();

            $assignedCount += $this->serpentineDistribute($females, $regularSections);
            $assignedCount += $this->serpentineDistribute($males, $regularSections);
        }

        $totalRemaining = Enrollment::where('grade_level', $gradeLevel)
            ->where('status', 'Enrolled')
            ->whereNull('section_id');
        if ($strand) $totalRemaining->where('strand', $strand);

        return [
            'status' => 'success',
            'message' => "JHS/SHS Sectioning complete. {$assignedCount} students assigned. {$totalRemaining->count()} students remaining.",
        ];
    }

    /**
     * Run Tech Voc Sectioning (Choice Waterfall based on Merit)
     */
    public function runTechVocSectioning(string $gradeLevel, ?string $course = null): array
    {
        $query = Enrollment::where('grade_level', $gradeLevel)
            ->where('track', 'TVL')
            ->where('status', 'Enrolled')
            ->whereNull('section_id');

        if ($course) {
            $query->where(function($q) use ($course) {
                $q->where('specialization', $course)->orWhere('strand', $course);
            });
        }

        // Step 1: Preparation & Sorting by Merit
        $unassignedStudents = $query->orderByDesc('gwa')
            ->orderBy('created_at')
            ->get();

        if ($unassignedStudents->isEmpty()) {
            return ['status' => 'info', 'message' => 'No unassigned students found for Tech Voc.'];
        }

        // Fetch all TVL sections for this grade
        $sections = Section::where('grade_level', $gradeLevel)->where('track', 'TVL')->get();

        if ($sections->isEmpty()) {
            throw new Exception("No Tech Voc sections found for {$gradeLevel}. Please create sections first.");
        }

        $assignedCount = 0;

        // Step 2: Choice-Based Assignment Waterfall
        foreach ($unassignedStudents as $student) {
            $choices = $student->tech_voc_choices ?? [];
            if (empty($choices)) {
                // If they don't have choices but selected a specific strand/specialization during enrollment
                if ($student->specialization) $choices[] = $student->specialization;
                elseif ($student->strand) $choices[] = $student->strand;
            }

            $assigned = false;

            // Evaluate 1st, 2nd, 3rd choices
            foreach ($choices as $choice) {
                // Find a section that matches this choice and has capacity
                $matchingSection = $sections->filter(function($sec) use ($choice) {
                    return ($sec->specialization === $choice || $sec->strand === $choice) 
                           && $sec->enrollments()->count() < $sec->capacity;
                })->first();

                if ($matchingSection) {
                    $student->update(['section_id' => $matchingSection->id]);
                    $assignedCount++;
                    $assigned = true;
                    break; // Move to next student
                }
            }

            // If not assigned after checking all choices, student remains unassigned (requires manual review)
            if (!$assigned && empty($choices)) {
                 // Try to assign to ANY TVL section if they had no choices and didn't fit anywhere else
                 $anySection = $sections->filter(function($sec) {
                     return $sec->enrollments()->count() < $sec->capacity;
                 })->first();

                 if ($anySection) {
                     $student->update(['section_id' => $anySection->id]);
                     $assignedCount++;
                 }
            }
        }

        $totalRemaining = Enrollment::where('grade_level', $gradeLevel)
            ->where('track', 'TVL')
            ->where('status', 'Enrolled')
            ->whereNull('section_id')
            ->count();

        return [
            'status' => 'success',
            'message' => "Tech Voc Sectioning complete. {$assignedCount} students assigned. {$totalRemaining} students requiring manual review.",
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
    public function checkStarQualification($enrollment): bool
    {
        $avg = $this->getStarSectionAverage($enrollment->grade_level);
        $gwa = (float) ($enrollment->gwa ?? ($enrollment->last_gwa ?? 0));
        return $gwa >= $avg && $avg > 0;
    }

    /**
     * Manual assignment (Bypasses capacity if done by Guidance)
     */
    public function manualAssign($enrollment, Section $section): void
    {
        $enrollment->update(['section_id' => $section->id]);
    }

    /**
     * Legacy method for individual assignment (Modified to use new logic if needed)
     */
    public function assignSection($enrollment): Section
    {
        // For individual assignment, we just find the first available section matching criteria
        $query = Section::where('grade_level', $enrollment->grade_level);

        if ($enrollment->track ?? null) $query->where('track', $enrollment->track);
        if ($enrollment->strand ?? null) $query->where('strand', $enrollment->strand);
        if ($enrollment->specialization ?? null) $query->where('specialization', $enrollment->specialization);

        $sections = $query->get();

        foreach ($sections as $section) {
            /** @var Section $section */
            if ($section->enrollments()->count() < $section->capacity) {
                $enrollment->update(['section_id' => $section->id]);
                return $section;
            }
        }

        throw new \Exception("No available capacity in matching sections for Grade {$enrollment->grade_level}.");
    }

    /**
     * Get available sections matching enrollment criteria.
     */
    public function getAvailableSectionsForEnrollment($enrollment)
    {
        $query = Section::where('grade_level', $enrollment->grade_level);

        if ($enrollment->track ?? null) $query->where('track', $enrollment->track);
        if ($enrollment->strand ?? null) $query->where('strand', $enrollment->strand);
        if ($enrollment->specialization ?? null) $query->where('specialization', $enrollment->specialization);

        return $query->withCount('enrollments')->get()->filter(function($section) {
            return $section->enrollments_count < $section->capacity;
        });
    }
}
