<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\SchoolYear;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;

class SelfEnrollment extends Component
{
    public $student;
    public $lastEnrollment;
    public $activeSchoolYear;
    public $suggestedGradeLevel;
    public $isEligibleForEnrollment = false;
    public $alreadyEnrolled = false;
    public $selectedTrack;
    public $selectedStrand;
    public $selectedSpec;

    public function mount()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'student') {
            abort(403, 'Unauthorized action.');
        }

        $this->student = Student::where('user_id', $user->id)->first();
        if (!$this->student) {
            abort(404, 'Student record not found.');
        }

        $this->activeSchoolYear = SchoolYear::where('status', 'active')->first();
        if (!$this->activeSchoolYear) {
            return;
        }

        // Check if already enrolled this active school year
        $this->alreadyEnrolled = Enrollment::where('student_id', $this->student->id)
            ->where('school_year_id', $this->activeSchoolYear->id)
            ->exists();

        if ($this->alreadyEnrolled) {
            return;
        }

        // Fetch last enrollment
        $this->lastEnrollment = Enrollment::where('student_id', $this->student->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($this->lastEnrollment) {
            $this->evaluateEligibility();
        }
    }

    private function evaluateEligibility()
    {
        // If term is not completed, they can't enroll for next year yet
        if ($this->lastEnrollment->term_status !== 'completed') {
            $this->isEligibleForEnrollment = false;
            return;
        }

        $this->isEligibleForEnrollment = true;

        $gradeNumber = (int) str_replace('Grade ', '', $this->lastEnrollment->grade_level);

        if ($this->lastEnrollment->academic_result === 'failed') {
            // Retained
            $this->suggestedGradeLevel = $this->lastEnrollment->grade_level;
        } elseif ($this->lastEnrollment->academic_result === 'passed' || $this->lastEnrollment->academic_result === 'graduated') {
            // Promoted
            if ($gradeNumber < 12) {
                $this->suggestedGradeLevel = 'Grade ' . ($gradeNumber + 1);
            } else {
                $this->isEligibleForEnrollment = false; // Already graduated Grade 12
            }
        }
    }

    public function submitEnrollment()
    {
        if (!$this->isEligibleForEnrollment) return;

        $enrollment = Enrollment::create([
            'student_id' => $this->student->id,
            'user_id' => Auth::id(),
            'school_year_id' => $this->activeSchoolYear->id,
            'grade_level' => $this->suggestedGradeLevel,
            'status' => 'Pending',
            'term_status' => 'enrolled',
            'type' => 'Old',
            'track' => $this->selectedTrack ?? $this->lastEnrollment->track,
            'strand' => $this->selectedStrand ?? $this->lastEnrollment->strand,
            'specialization' => $this->selectedSpec ?? $this->lastEnrollment->specialization,
            // Re-use demographics or they are already fetched from student model
        ]);

        session()->flash('message', 'Successfully submitted enrollment for the new school year.');
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.student.self-enrollment');
    }
}
