<?php

namespace App\Livewire\StudentPortal;

use Livewire\Component;
use App\Models\Enrollment;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class EnrollmentForm extends Component
{
    use WithFileUploads;

    public $current_step = 1;
    private $prefix = 'TNTS-';

    // Phase 1 intent
    public $enrollment_type;
    public $grade_level;
    public $consent = false;

    // Step 1: Learner Info
    public $psa_no;
    public $lrn;
    public $last_name;
    public $first_name;
    public $middle_name;
    public $extension_name;
    public $birthdate;
    public $sex;
    public $is_ip = false;
    public $ip_community;
    public $is_4ps = false;
    public $household_id;
    public $has_disability = false;
    public $disability_types = [];

    // Step 2: Address
    public $current_house_no;
    public $current_street;
    public $current_barangay;
    public $current_municipality;
    public $current_province;
    public $current_zip;
    public $is_same_address = true;
    public $permanent_house_no;
    public $permanent_street;
    public $permanent_barangay;
    public $permanent_municipality;
    public $permanent_province;
    public $permanent_zip;

    // Step 3: Family
    public $father_name;
    public $mother_maiden_name;
    public $guardian_name;
    public $contact_no;

    // Step 4: Academic History
    public $last_grade_level;
    public $last_school_year;
    public $last_school_attended;
    public $last_school_id;
    public $semester;
    public $track;
    public $strand;
    public $specialization;
    public $modality;

    // Specialized Logic
    public $shs_track;
    public $rank1;
    public $rank2;
    public $rank3;
    public $is_shs_aligned = false;

    // Step 5: Uploads
    public $psa_file;
    public $sf9_file;
    public $good_moral_file;
    public $honorable_dismissal_file;

    protected $rules = [
        1 => [
            'enrollment_type' => 'required',
            'grade_level' => 'required'
        ],
        2 => [
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'birthdate' => 'required|date',
            'sex' => 'required',
        ],
        3 => [
            'current_barangay' => 'required',
            'current_municipality' => 'required',
        ],
        4 => [
            'contact_no' => 'required|numeric',
        ],
        5 => [
            'last_grade_level' => 'required',
            'last_school_attended' => 'required',
        ],
        // Step 6 Specialized Logic (Handled in nextStep)
    ];

    public function mount()
    {
        $user = Auth::user();
        
        // Conditional Auto-Progression Detection (Phase 2 Recommendation)
        if ($user->role === 'student' || $user->role === 'student') {
            $this->enrollment_type = 'Promoted';
            
            // Fetch the most recent finalized enrollment to pre-fill
            $latest = Enrollment::where('user_id', $user->id)
                ->where('status', 'Enrolled')
                ->latest()
                ->first();

            if ($latest) {
                // Pre-fill student, address, and family info
                $this->fill($latest->only([
                    'psa_no', 'lrn', 'last_name', 'first_name', 'middle_name', 'extension_name', 'birthdate', 'sex',
                    'is_ip', 'ip_community', 'is_4ps', 'household_id', 'has_disability', 'disability_types',
                    'current_house_no', 'current_street', 'current_barangay', 'current_municipality', 'current_province', 'current_zip',
                    'is_same_address', 'permanent_house_no', 'permanent_street', 'permanent_barangay', 'permanent_municipality', 'permanent_province', 'permanent_zip',
                    'father_name', 'mother_maiden_name', 'guardian_name', 'contact_no'
                ]));
                
                // Auto-set the next grade level
                $this->last_grade_level = $latest->grade_level;
                $this->grade_level = $this->calculateNextGrade($latest->grade_level);
            }
        }

        $existing = Enrollment::where('user_id', Auth::id())->where('status', 'Draft')->first();

        if ($existing) {
            $this->fill($existing->toArray());
            if ($existing->tech_voc_choices) {
                $this->rank1 = $existing->tech_voc_choices[0] ?? null;
                $this->rank2 = $existing->tech_voc_choices[1] ?? null;
                $this->rank3 = $existing->tech_voc_choices[2] ?? null;
            }
        }
    }

    private function calculateNextGrade($current)
    {
        $map = [
            'Grade 7' => 'Grade 8',
            'Grade 8' => 'Grade 9',
            'Grade 9' => 'Grade 10',
            'Grade 10' => 'Grade 11',
            'Grade 11' => 'Grade 12',
        ];
        return $map[$current] ?? null;
    }

    public function nextStep()
    {
        if (isset($this->rules[$this->current_step])) {
            $this->validate($this->rules[$this->current_step]);
        }

        $this->saveDraft();
        $this->current_step++;
    }

    public function previousStep()
    {
        $this->current_step--;
    }

    public function saveDraft()
    {
        $data = $this->all();
        $data['user_id'] = Auth::id();
        $data['status'] = 'Draft';
        $data['type'] = $this->enrollment_type;
        
        if ($this->rank1 || $this->rank2 || $this->rank3) {
            $data['tech_voc_choices'] = [$this->rank1, $this->rank2, $this->rank3];
        }

        Enrollment::updateOrCreate(
            ['user_id' => Auth::id(), 'status' => 'Draft'],
            $data
        );
    }

    public function submit()
    {
        $this->validate([
            'consent' => 'accepted',
            'psa_file' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
            'sf9_file' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
            'good_moral_file' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
            'honorable_dismissal_file' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
        ]);

        $this->saveDraft();

        $enrollment = Enrollment::where('user_id', Auth::id())->where('status', 'Draft')->first();

        if (!$enrollment) {
            // Fallback if somehow draft was already submitted or lost
            $enrollment = Enrollment::where('user_id', Auth::id())->latest()->first();
        }

        if ($this->psa_file) {
            $enrollment->update(['psa_path' => $this->psa_file->store('enrollments/psa', 'public')]);
        }
        if ($this->sf9_file) {
            $enrollment->update(['sf9_path' => $this->sf9_file->store('enrollments/sf9', 'public')]);
        }
        if ($this->good_moral_file) {
            $enrollment->update(['good_moral_path' => $this->good_moral_file->store('enrollments/good_moral', 'public')]);
        }
        if ($this->honorable_dismissal_file) {
            $enrollment->update(['honorable_dismissal_path' => $this->honorable_dismissal_file->store('enrollments/dismissal', 'public')]);
        }

        $enrollment->update([
            'status' => 'Submitted',
            'transaction_number' => $this->prefix . now()->format('Y') . '-' . str_pad($enrollment->id, 5, '0', STR_PAD_LEFT),
        ]);

        return redirect()->route('enrollment.index');
    }

    public function render()
    {
        return view('pages.StudentPortal.enrollment.form')
            ->layout('layouts.student-portal');
    }
}
