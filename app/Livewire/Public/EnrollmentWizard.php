<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Enrollment;
use App\Models\PreEnrollment;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Barryvdh\DomPDF\Facade\Pdf;

#[Layout('layouts.guest')]
class EnrollmentWizard extends Component
{
    use WithFileUploads;

    public $currentStep = 0; // 0 = Gateway/Initiation, 1-6 = Form
    public $initStep = 0;    // 0 = LRN/Birthdate, 1 = Category, 2 = Type
    public $is_resumed = false;
    public $submitted = false;

    // Credentials
    public $lrn;
    public $birthdate;

    // Selections
    public $school_category; // HS or SHS
    public $enrollment_type; // New, Old, Transferee

    // All form data fields from old form
    public array $formData = [
        'enrollment_type' => '',
        'grade_level' => '',
        'psa_no' => '',
        'lrn' => '',
        'last_name' => '',
        'first_name' => '',
        'middle_name' => '',
        'extension_name' => '',
        'birthdate' => '',
        'sex' => '',
        'is_ip' => false,
        'ip_community' => '',
        'is_4ps' => false,
        'household_id' => '',
        'has_disability' => false,
        'disability_types' => [],
        'current_house_no' => '',
        'current_street' => '',
        'current_barangay' => '',
        'current_municipality' => '',
        'current_province' => '',
        'current_zip' => '',
        'is_same_address' => true,
        'permanent_house_no' => '',
        'permanent_street' => '',
        'permanent_barangay' => '',
        'permanent_municipality' => '',
        'permanent_province' => '',
        'permanent_zip' => '',
        'father_name' => '',
        'mother_maiden_name' => '',
        'guardian_name' => '',
        'contact_no' => '',
        'last_grade_level' => '',
        'last_school_year' => '',
        'last_school_attended' => '',
        'last_school_id' => '',
        'semester' => '',
        'track' => '',
        'strand' => '',
        'specialization' => '',
        'modality' => '',
        'shs_track' => '',
        'rank1' => '',
        'rank2' => '',
        'rank3' => '',
        'is_shs_aligned' => false,
        'profile_picture' => null,
        'last_gwa' => '',
        'mother_tongue' => '',
    ];

    public $profile_picture_upload;

    protected $stepRules = [
        1 => [
            'formData.grade_level' => 'required'
        ],
        2 => [
            'formData.first_name' => 'required|min:2',
            'formData.last_name' => 'required|min:2',
            'formData.sex' => 'required',
        ],
        3 => [
            'formData.current_barangay' => 'required',
            'formData.current_municipality' => 'required',
        ],
        4 => [
            'formData.contact_no' => 'required|numeric',
        ],
        5 => [
            'formData.last_grade_level' => 'required',
            'formData.last_school_attended' => 'required',
            'formData.last_gwa' => 'required|numeric|min:75|max:100',
        ],
    ];

    public function validateGateway()
    {
        $this->validate([
            'lrn' => 'required|digits:12',
            'birthdate' => 'required|date',
        ]);

        // Scenario C: Already Enrolled
        $alreadyEnrolled = Enrollment::where('lrn', $this->lrn)
            ->where('status', 'Enrolled')
            ->whereYear('finalized_at', now()->year)
            ->exists();

        if ($alreadyEnrolled) {
            return redirect()->route('home')->with('error', 'You are already officially enrolled for this school year. Please log in to the Student Portal.');
        }

        $preEnrollment = PreEnrollment::where('lrn', $this->lrn)->first();

        // Scenario B: Resume Draft
        if ($preEnrollment) {
            if ($preEnrollment->birthdate->format('Y-m-d') !== $this->birthdate) {
                $this->addError('birthdate', 'The birthdate does not match our records for this LRN.');
                return;
            }

            if ($preEnrollment->status === 'pending_approval') {
                return redirect()->route('home')->with('info', 'Your enrollment application is already pending review.');
            }

            // Hydrate state
            $this->formData = array_merge($this->formData, $preEnrollment->form_data ?? []);
            $this->currentStep = $preEnrollment->current_step;
            $this->enrollment_type = $this->formData['enrollment_type'] ?? '';
            $this->is_resumed = true;
            
            // Strictly skip Step 1 for Incoming Grade 7
            if ($this->currentStep == 1 && $this->enrollment_type === 'Incoming Grade 7') {
                $this->currentStep = 2;
            }

            // If they resumed at Step 0, move them to selections
            if ($this->currentStep == 0) {
                $this->initStep = 1;
            }
        } else {
            // Scenario A: initiation
            $this->initStep = 1;
        }
    }

    public function selectCategory($cat)
    {
        $this->school_category = $cat;
        $this->initStep = 2;
    }

    public function selectType($type)
    {
        $this->enrollment_type = $type;
        $this->formData['enrollment_type'] = $type;
        $this->formData['lrn'] = $this->lrn;
        $this->formData['birthdate'] = $this->birthdate;

        if ($type === 'Incoming Grade 7') {
            $this->formData['grade_level'] = 'Grade 7';
            $this->formData['last_grade_level'] = 'Grade 6';
            $this->currentStep = 2;
        } else {
            $this->currentStep = 1;
        }
        
        $this->startForm();
    }

    public function startForm()
    {
        
        // Finalize draft creation if brand new
        $preEnrollment = PreEnrollment::where('lrn', $this->lrn)->first();
        if (!$preEnrollment) {
            PreEnrollment::create([
                'lrn' => $this->lrn,
                'birthdate' => $this->birthdate,
                'current_step' => 1,
                'status' => 'draft',
                'form_data' => $this->formData,
            ]);
        }
    }

    public function nextStep()
    {
        if (isset($this->stepRules[$this->currentStep])) {
            $this->validate($this->stepRules[$this->currentStep]);
        }
        
        $this->saveProgress();
        $this->currentStep++;
    }

    public function previousStep()
    {
        $this->currentStep--;

        if ($this->currentStep == 1 && $this->enrollment_type === 'Incoming Grade 7') {
            $this->currentStep = 0;
            $this->initStep = 2; // Back to type selection
        }
    }

    public function saveProgress()
    {
        $preEnrollment = PreEnrollment::where('lrn', $this->lrn)->first();
        if ($preEnrollment) {
            $preEnrollment->update([
                'current_step' => $this->currentStep,
                'form_data' => $this->formData,
            ]);
        }
    }

    public function submit()
    {
        $this->validate([
            'profile_picture_upload' => $this->is_resumed ? 'nullable|image|max:5120' : 'required|image|max:5120',
        ]);

        if ($this->profile_picture_upload) {
            $path = $this->profile_picture_upload->store('enrollments/photos', 'public');
            $this->formData['profile_picture'] = $path;
        }

        $preEnrollment = PreEnrollment::where('lrn', $this->lrn)->first();
        $preEnrollment->update([
            'status' => 'pending_approval',
            'current_step' => $this->currentStep,
            'form_data' => $this->formData,
        ]);

        $this->submitted = true;
    }

    public function downloadCertificate()
    {
        $enrollment = (object) [
            'type' => $this->enrollment_type ?? 'New',
            'lrn' => $this->lrn,
            'first_name' => $this->formData['first_name'],
            'last_name' => $this->formData['last_name'],
            'middle_name' => $this->formData['middle_name'] ?? '',
            'grade_level' => $this->formData['grade_level'],
            'strand' => $this->formData['strand'] ?? '',
            'specialization' => $this->formData['rank1'] ?? '',
            'finalized_at' => now(),
        ];

        $pdf = Pdf::loadView('pdf.enrollment-certificate', compact('enrollment'))
            ->setPaper('a4', 'portrait');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, "TNTS_Admission_Pass_{$this->lrn}.pdf");
    }

    public function maskValue($key, $value)
    {
        if (empty($value)) return '';
        if (in_array($key, ['last_name', 'first_name', 'middle_name'])) {
            if (strlen($value) <= 2) return $value;
            return substr($value, 0, 1) . str_repeat('*', strlen($value) - 2) . substr($value, -1);
        }
        if ($key === 'contact_no') {
            if (strlen($value) < 10) return str_repeat('*', strlen($value));
            return substr($value, 0, 4) . '-***-**' . substr($value, -2);
        }
        return $value;
    }

    public function render()
    {
        return view('livewire.public.enrollment-wizard');
    }
}
