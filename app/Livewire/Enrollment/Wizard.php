<?php

namespace App\Livewire\Enrollment;

use Livewire\Component;
use App\Models\Enrollment;
use App\Models\PreEnrollment;
use Livewire\WithFileUploads;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Layout;

#[Layout('layouts.guest')]
class Wizard extends Component
{
    use WithFileUploads;

    public $currentStep = 0; // 0 = Gateway/Initiation, 1-6 = Form
    public $initStep = 0;    // 0 = LRN/Birthdate, 1 = Category, 2 = Type
    public $is_resumed = false;
    public $submitted = false;
    public $showAlreadyEnrolledModal = false;
    public $showResumeModal = false;
    public $showPSAModal = false;
    public $transaction_number;

    private $prefix = "TNTS-";

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
        'mother_tongue' => '',
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
        'current_country' => 'Philippines',
        'is_same_address' => true,
        'permanent_house_no' => '',
        'permanent_street' => '',
        'permanent_barangay' => '',
        'permanent_municipality' => '',
        'permanent_province' => '',
        'permanent_zip' => '',
        'permanent_country' => 'Philippines',
        'father_name' => '',
        'mother_maiden_name' => '',
        'guardian_name' => '',
        'contact_no' => '',
        'last_grade_level' => '',
        'last_school_year' => '',
        'last_school_attended' => '',
        'last_school_id' => '',
        'last_gwa' => '',
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
        'profile_picture' => null
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
            'formData.current_house_no' => 'required',
            'formData.current_barangay' => 'required',
            'formData.current_municipality' => 'required',
            'formData.current_province' => 'required',
            'formData.current_zip' => 'required',
            'formData.current_country' => 'required',
        ],
        4 => [
            'formData.father_name' => 'required|min:2',
            'formData.mother_maiden_name' => 'required|min:2',
            'formData.guardian_name' => 'required|min:2',
            'formData.contact_no' => 'required|numeric|digits:10',
        ],
        5 => [
            'formData.last_grade_level' => 'required',
            'formData.last_school_attended' => 'required',
            'formData.last_gwa' => 'required|numeric|min:75|max:100',
        ],
    ];

    protected $validationAttributes = [
        'formData.grade_level' => 'grade level',
        'formData.first_name' => 'first name',
        'formData.last_name' => 'last name',
        'formData.sex' => 'sex',
        'formData.current_barangay' => 'barangay',
        'formData.current_municipality' => 'municipality',
        'formData.current_province' => 'province',
        'formData.current_zip' => 'ZIP code',
        'formData.current_country' => 'country',
        'formData.permanent_house_no' => 'permanent house no.',
        'formData.permanent_barangay' => 'permanent barangay',
        'formData.permanent_municipality' => 'permanent municipality',
        'formData.permanent_province' => 'permanent province',
        'formData.permanent_zip' => 'permanent ZIP code',
        'formData.permanent_country' => 'permanent country',
        'formData.father_name' => "father's name",
        'formData.mother_maiden_name' => "mother's maiden name",
        'formData.guardian_name' => "guardian's name",
        'formData.contact_no' => 'contact number',
        'formData.last_grade_level' => 'last grade level',
        'formData.last_school_attended' => 'last school attended',
        'formData.last_gwa' => 'GWA',
    ];

    public function rules()
    {
        $allRules = [
            'lrn' => 'required|digits:12',
            'birthdate' => 'required|date',
        ];

        foreach ($this->stepRules as $stepNum => $step) {
            $allRules = array_merge($allRules, $step);
            
            // Add conditional permanent address rules
            if ($stepNum == 3 && !($this->formData['is_same_address'] ?? true)) {
                $allRules['formData.permanent_house_no'] = 'required';
                $allRules['formData.permanent_barangay'] = 'required';
                $allRules['formData.permanent_municipality'] = 'required';
                $allRules['formData.permanent_province'] = 'required';
                $allRules['formData.permanent_zip'] = 'required';
                $allRules['formData.permanent_country'] = 'required';
            }
        }

        return $allRules;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        // Auto-sync addresses if "Same as current" is checked
        if ($propertyName === 'formData.is_same_address' && $this->formData['is_same_address']) {
            $this->syncAddresses();
        }

        if (str_starts_with($propertyName, 'formData.current_') && ($this->formData['is_same_address'] ?? false)) {
            $this->syncAddresses();
        }
    }

    private function syncAddresses()
    {
        $this->formData['permanent_house_no'] = $this->formData['current_house_no'] ?? '';
        $this->formData['permanent_barangay'] = $this->formData['current_barangay'] ?? '';
        $this->formData['permanent_municipality'] = $this->formData['current_municipality'] ?? '';
        $this->formData['permanent_province'] = $this->formData['current_province'] ?? '';
        $this->formData['permanent_zip'] = $this->formData['current_zip'] ?? '';
        $this->formData['permanent_country'] = $this->formData['current_country'] ?? '';
    }

    public function validateIdentity()
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
            $this->showAlreadyEnrolledModal = true;
            return;
        }

        $preEnrollment = PreEnrollment::where('lrn', $this->lrn)->first();

        // Scenario B: Resume Draft
        if ($preEnrollment) {
            if ($preEnrollment->birthdate->format('Y-m-d') !== $this->birthdate) {
                $this->addError('birthdate', 'The birthdate does not match our records for this LRN.');
                return;
            }

            if ($preEnrollment->status === 'pending_approval') {
                $this->formData = array_merge($this->formData, $preEnrollment->form_data ?? []);
                $this->transaction_number = $preEnrollment->transaction_number;
                $this->submitted = true;
                return;
            }

            if ($preEnrollment->status === 'draft') {
                $this->showResumeModal = true;
                return;
            }
        } else {
            // Scenario A: initiation
            $this->initStep = 1;
        }
    }

    public function resumeDraft()
    {
        $preEnrollment = PreEnrollment::where('lrn', $this->lrn)->first();
        if (!$preEnrollment) return;

        // Hydrate state
        $this->formData = array_merge($this->formData, $preEnrollment->form_data ?? []);
        $this->currentStep = $preEnrollment->current_step;
        $this->enrollment_type = $this->formData['enrollment_type'] ?? '';
        $this->is_resumed = true;
        
        // Strictly skip Step 1 and enforce Grade 6 for Incoming Grade 7
        if (in_array($this->enrollment_type, ['Incoming Grade 7', 'Incoming Grade 11'])) {
            $this->formData['last_grade_level'] = ($this->enrollment_type === 'Incoming Grade 7') ? 'Grade 6' : 'Grade 10';
            if ($this->currentStep == 1) {
                $this->currentStep = 2;
            }
        }

        // If they resumed at Step 0, move them to selections
        if ($this->currentStep == 0) {
            $this->initStep = 1;
        }

        $this->showResumeModal = false;
    }

    public function resetAndStartNew()
    {
        PreEnrollment::where('lrn', $this->lrn)->delete();
        $this->showResumeModal = false;
        $this->initStep = 1;
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
        } elseif ($type === 'Incoming Grade 11') {
            $this->formData['grade_level'] = 'Grade 11';
            $this->formData['last_grade_level'] = 'Grade 10';
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
            $rules = $this->stepRules[$this->currentStep];
            
            // Add conditional permanent address rules for Step 3
            if ($this->currentStep == 3 && !$this->formData['is_same_address']) {
                $rules['formData.permanent_house_no'] = 'required';
                $rules['formData.permanent_barangay'] = 'required';
                $rules['formData.permanent_municipality'] = 'required';
                $rules['formData.permanent_province'] = 'required';
                $rules['formData.permanent_zip'] = 'required';
                $rules['formData.permanent_country'] = 'required';
            }

            // Custom enforcement for Step 5
            if ($this->currentStep == 5 && in_array($this->enrollment_type, ['Incoming Grade 7', 'Incoming Grade 11'])) {
                $rules['formData.last_grade_level'] = 'required|in:' . ($this->enrollment_type === 'Incoming Grade 7' ? 'Grade 6' : 'Grade 10');
            }

            $this->validate($rules);
        }
        
        $this->saveProgress();
        $this->currentStep++;
    }

    public function previousStep()
    {
        $this->currentStep--;

        if ($this->currentStep == 1 && in_array($this->enrollment_type, ['Incoming Grade 7', 'Incoming Grade 11'])) {
            $this->currentStep = 0;
            $this->initStep = 2; // Back to type selection
        }
    }

    public function saveProgress()
    {
        $this->formData['has_disability'] = !empty($this->formData['disability_types']);
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
        $hasExistingPicture = !empty($this->formData['profile_picture'] ?? null);
        
        $this->validate([
            'profile_picture_upload' => $hasExistingPicture ? 'nullable|image|max:5120' : 'required|image|max:5120',
        ]);

        if ($this->profile_picture_upload) {
            $path = $this->profile_picture_upload->store('enrollments/photos', 'public');
            $this->formData['profile_picture'] = $path;
        }

        $this->formData['has_disability'] = !empty($this->formData['disability_types']);
        $preEnrollment = PreEnrollment::where('lrn', $this->lrn)->first();
        $this->transaction_number = $this->prefix . now()->format('Y') . '-' . str_pad($preEnrollment->id, 5, '0', STR_PAD_LEFT);
        $preEnrollment->update([
            'status' => 'pending_approval',
            'current_step' => $this->currentStep,
            'transaction_number' => $this->transaction_number,
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
            'transaction_number' => $this->transaction_number ?? 'PENDING',
            'finalized_at' => now(),
        ];

        $qrCode = null;
        try {
            $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($enrollment->transaction_number);
            $qrData = file_get_contents($qrUrl);
            $qrCode = 'data:image/png;base64,' . base64_encode($qrData);
        } catch (\Exception $e) {
            // Fallback
        }

        $pdf = Pdf::loadView('pdf.enrollment-certificate', compact('enrollment', 'qrCode'))
            ->setPaper('a4', 'portrait')
            ->setOption('isRemoteEnabled', true)
            ->setOption('isHtml5ParserEnabled', true);

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
        return view('livewire.enrollment.wizard');
    }
}
