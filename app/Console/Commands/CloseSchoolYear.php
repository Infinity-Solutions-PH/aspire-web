<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SchoolYear;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CloseSchoolYear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schoolyear:close';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Close the active school year and run batch evaluation of all active enrollments.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $activeYear = SchoolYear::where('status', 'active')->first();

        if (!$activeYear) {
            $this->error('No active school year found.');
            return 1;
        }

        $this->info("Closing School Year: {$activeYear->name}");

        DB::transaction(function () use ($activeYear) {
            // Fetch all enrollments for the active school year that are currently enrolled
            $enrollments = Enrollment::where('school_year_id', $activeYear->id)
                ->where('term_status', 'enrolled')
                ->with('student')
                ->get();

            $passedCount = 0;
            $failedCount = 0;
            $graduatedCount = 0;

            foreach ($enrollments as $enrollment) {
                // Determine if student passed all subjects. 
                // Since full grading module is not yet attached, we assume pass unless explicitly failed.
                // In a real scenario, this would query the grades table.
                $hasFailedSubject = false; // Example: $enrollment->grades()->where('remarks', 'failed')->exists();

                if ($hasFailedSubject) {
                    $enrollment->update([
                        'academic_result' => 'failed',
                        'term_status' => 'completed'
                    ]);
                    $failedCount++;
                } else {
                    // Check for graduation (Terminal grades)
                    if ($enrollment->grade_level === 'Grade 10') {
                        $enrollment->update([
                            'academic_result' => 'graduated',
                            'term_status' => 'completed'
                        ]);
                        
                        if ($enrollment->student) {
                            $enrollment->student->update(['is_jhs_alumni' => true]);
                        }
                        $graduatedCount++;
                    } elseif ($enrollment->grade_level === 'Grade 12') {
                        $enrollment->update([
                            'academic_result' => 'graduated',
                            'term_status' => 'completed'
                        ]);
                        
                        if ($enrollment->student) {
                            $enrollment->student->update([
                                'is_shs_alumni' => true,
                                'global_status' => 'alumni'
                            ]);
                        }
                        $graduatedCount++;
                    } else {
                        // Promoted
                        $enrollment->update([
                            'academic_result' => 'passed',
                            'term_status' => 'completed'
                        ]);
                        $passedCount++;
                    }
                }
            }

            // Close the school year
            $activeYear->update(['status' => 'inactive']);

            $this->info("Processed " . $enrollments->count() . " enrollments.");
            $this->info("Passed: {$passedCount}, Failed: {$failedCount}, Graduated: {$graduatedCount}");
            $this->info("School Year closed successfully. Please create a new active school year.");
            
            Log::info("School year {$activeYear->name} closed. Passed: {$passedCount}, Failed: {$failedCount}, Graduated: {$graduatedCount}");
        });

        return 0;
    }
}
