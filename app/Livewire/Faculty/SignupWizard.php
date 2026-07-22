<?php

namespace App\Livewire\Faculty;

use App\Models\User;
use App\Models\Branch;
use App\Models\Faculty;
use Livewire\Component;
use App\Models\Position;
use App\Models\Department;
use Livewire\Attributes\Layout;
use App\Models\PlantillaPosition;
use Illuminate\Support\Facades\Hash;

#[Layout('layouts.guest')]
class SignupWizard extends Component
{
    public $currentStep = 1;
    public $submitted = false;

    // Step 1: Account info
    public $name = '';
    public $gender = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    // Step 2: Professional info
    public $faculty_id = '';
    public $level = '';
    public $department_id = '';

    // Step 3: Position & Plantilla
    public $position_id = '';
    public $plantilla_item_number = '';

    protected $validationAttributes = [
        'department_id' => 'department',
        'position_id' => 'position',
        'plantilla_item_number' => 'plantilla item number',
    ];

    protected function getRulesForStep($step)
    {
        switch ($step) {
            Case 1:
                return [
                    'name' => 'required|min:3',
                    'gender' => 'required|in:Male,Female,Other',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|min:8|confirmed',
                ];
            Case 2:
                return [
                    'faculty_id' => 'required|unique:faculties,faculty_id',

                    'level' => 'required|in:JHS,SHS',
                    'department_id' => 'required|exists:departments,id',
                ];
            Case 3:
                return [
                    'position_id' => 'required|exists:positions,id',
                    'plantilla_item_number' => 'nullable|string',
                ];
            default:
                return [];
        }
    }

    public function updatedLevel()
    {
        $this->department_id = '';
    }

    public function updatedPlantillaItemNumber($value)
    {
        if (empty($value)) {
            return;
        }

        $plantilla = PlantillaPosition::where('plantilla_number', $value)->first();
        if ($plantilla) {
            $this->position_id = $plantilla->position_id;
        }
    }

    public function nextStep()
    {
        $rules = $this->getRulesForStep($this->currentStep);
        if ($rules) {
            $this->validate($rules);
        }

        if ($this->currentStep == 3) {
            // Validate Plantilla assignment
            if (!empty($this->plantilla_item_number)) {
                $plantilla = PlantillaPosition::where('plantilla_number', $this->plantilla_item_number)->first();
                if ($plantilla) {
                    $assignedFaculty = Faculty::where('plantilla_position_id', $plantilla->id)
                        ->whereIn('status', ['Active', 'On Leave'])
                        ->first();

                    if ($assignedFaculty) {
                        $this->addError('plantilla_item_number', 'This plantilla item number is already assigned to an active faculty member.');
                        return;
                    }
                }
            }
        }

        $this->currentStep++;
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function submit()
    {
        // Validate all rules across all steps
        $allRules = array_merge(
            $this->getRulesForStep(1),
            $this->getRulesForStep(2),
            $this->getRulesForStep(3)
        );

        $this->validate($allRules);

        // Double check plantilla assignment
        if (!empty($this->plantilla_item_number)) {
            $plantilla = PlantillaPosition::where('plantilla_number', $this->plantilla_item_number)->first();
            if ($plantilla) {
                $assignedFaculty = Faculty::where('plantilla_position_id', $plantilla->id)
                    ->whereIn('status', ['Active', 'On Leave'])
                    ->first();

                if ($assignedFaculty) {
                    $this->addError('plantilla_item_number', 'This plantilla item number is already assigned to an active faculty member.');
                    return;
                }
            }
        }

        // 1. Create the user
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $user->assignRole('faculty');

        // 2. Resolve/create the plantilla position
        $plantillaId = null;
        if (!empty($this->plantilla_item_number)) {
            $plantilla = PlantillaPosition::firstOrCreate(
                ['plantilla_number' => $this->plantilla_item_number],
                ['position_id' => $this->position_id]
            );
            $plantillaId = $plantilla->id;
        }

        // 3. Create the faculty record with status "Pending"
        Faculty::create([
            'user_id' => $user->id,
            'faculty_id' => $this->faculty_id,
            'department_id' => $this->department_id,
            'status' => 'Pending',
            'plantilla_position_id' => $plantillaId,
            'position_id' => empty($this->plantilla_item_number) ? $this->position_id : null,
            'level' => $this->level,
            'gender' => $this->gender,
        ]);

        $this->submitted = true;
    }

    public function render()
    {
        $departments = $this->level ? Department::where('level', $this->level)->orderBy('name')->get() : collect();
        $positions = Position::sortedForForm()->get();

        return view('livewire.faculty.signup-wizard', [
            'departments' => $departments,
            'positions' => $positions,
        ])->title('Faculty Registration Portal · TNTS ASPIRE');
    }
}
