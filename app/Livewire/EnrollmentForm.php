<?php

namespace App\Livewire;

use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class EnrollmentForm extends Component
{
    use WithFileUploads;

    public $current_step = 1;

    // Phase 1 intent
    public $grade_level;

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

    // Step 5: Uploads
    public $psa_file;
    public $sf9_file;
    public $good_moral_file;

    protected $rules = [
        1 => ['grade_level' => 'required'],
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
    ];

    public function mount()
    {
        $existing = Enrollment::where('user_id', Auth::id())->where('status', 'Draft')->first();

        if ($existing) {
            $this->fill($existing->toArray());
        }
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

        Enrollment::updateOrCreate(
            ['user_id' => Auth::id(), 'status' => 'Draft'],
            $data
        );
    }

    public function submit()
    {
        $this->validate([
            'psa_file' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
            'sf9_file' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
            'good_moral_file' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
        ]);

        $enrollment = Enrollment::where('user_id', Auth::id())->where('status', 'Draft')->first();

        if ($this->psa_file) {
            $enrollment->update(['psa_path' => $this->psa_file->store('enrollments/psa', 'public')]);
        }
        if ($this->sf9_file) {
            $enrollment->update(['sf9_path' => $this->sf9_file->store('enrollments/sf9', 'public')]);
        }
        if ($this->good_moral_file) {
            $enrollment->update(['good_moral_path' => $this->good_moral_file->store('enrollments/good_moral', 'public')]);
        }

        $enrollment->update(['status' => 'Submitted']);

        return redirect()->route('dashboard')->with('success', 'Your enrollment has been submitted for verification!');
    }

    public function render()
    {
        return view('livewire.enrollment-form');
    }
}
