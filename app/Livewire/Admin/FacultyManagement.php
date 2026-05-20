<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Branch;
use App\Models\Faculty;
use Livewire\Component;
use App\Models\Position;
use App\Models\Department;
use Livewire\WithPagination;
use App\Models\PlantillaPosition;
use Illuminate\Support\Facades\Hash;

class FacultyManagement extends Component
{
    use WithPagination;

    // Filters
    public $search = '';
    public $department = '';
    public $status = '';
    public $level = '';
    public $branch_id = '';
    public $position_id = '';
    public $gender_filter = '';

    // Form Properties
    public $showModal = false;
    public $editingId = null;
    public $faculty_id = '';
    public $name = '';
    public $email = '';
    public $form_department_id = '';
    public $form_status = 'Active';
    public $form_position_id = '';
    public $plantilla_item_number = '';
    public $form_branch_id = '';
    public $form_level = '';
    public $gender = 'Male';
    public $inactive_reason = '';
    public $effective_date = '';
    public $transfer_school = '';

    // Password Confirmation States & Dirty Tracking
    public $showPasswordModal = false;
    public $confirmPassword = '';
    public $initialValues = [];
    public $isDirty = false;

    protected $validationAttributes = [
        'form_department_id' => 'department',
        'form_position_id' => 'position',
        'form_branch_id' => 'branch',
        'form_status' => 'status',
        'form_level' => 'secondary level',
    ];

    protected $messages = [
        'effective_date.required_if' => 'The effective date field is required when status is Inactive.',
        'inactive_reason.required_if' => 'The inactive reason field is required when status is Inactive.',
    ];

    protected function rules()
    {
        $faculty = $this->editingId ? Faculty::find($this->editingId) : null;
        $userId = $faculty ? $faculty->user_id : null;

        $rules = [
            'faculty_id' => 'required|unique:faculties,faculty_id,' . $this->editingId,
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $userId,
            'form_department_id' => 'required|exists:departments,id',
            'form_status' => 'required|in:Active,On Leave,Inactive',
            'form_position_id' => 'required|exists:positions,id',
            'plantilla_item_number' => 'required|string',
            'form_branch_id' => 'required|exists:branches,id',
            'form_level' => 'required|in:JHS,SHS',
            'gender' => 'required|in:Male,Female,Other',
            'inactive_reason' => 'nullable|required_if:form_status,Inactive|in:Resigned,Retired,Transferred',
            'effective_date' => 'nullable|required_if:form_status,Inactive|date',
            'transfer_school' => 'nullable|string',
        ];

        return $rules;
    }

    public function updatedFormLevel($value)
    {
        $this->form_department_id = '';
    }

    public function updatedPlantillaItemNumber($value)
    {
        if (empty($value)) {
            return;
        }

        $plantilla = PlantillaPosition::where('plantilla_number', $value)->first();

        if ($plantilla) {
            // Check if vacant (no active/on-leave faculty holds it, excluding current editing id)
            $assignedFaculty = Faculty::where('plantilla_position_id', $plantilla->id)
                ->whereIn('status', ['Active', 'On Leave'])
                ->when($this->editingId, function ($q) {
                    $q->where('id', '!=', $this->editingId);
                })
                ->exists();

            if (!$assignedFaculty) {
                $this->form_position_id = $plantilla->position_id;
            }
        }
    }


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updated($propertyName)
    {
        if ($this->editingId) {
            $currentValues = [
                'faculty_id' => $this->faculty_id,
                'name' => $this->name,
                'email' => $this->email,
                'form_department_id' => $this->form_department_id,
                'form_status' => $this->form_status,
                'form_position_id' => $this->form_position_id,
                'plantilla_item_number' => $this->plantilla_item_number,
                'form_branch_id' => $this->form_branch_id,
                'form_level' => $this->form_level,
                'gender' => $this->gender ?: '',
                'inactive_reason' => $this->inactive_reason ?: '',
                'effective_date' => $this->effective_date ?: '',
                'transfer_school' => $this->transfer_school ?: '',
            ];

            $this->isDirty = $currentValues !== $this->initialValues;
        } else {
            $this->isDirty = true;
        }
    }

    protected function resetForm()
    {
        $this->reset([
            'editingId', 'faculty_id', 'name', 'email', 'form_department_id', 
            'form_status', 'form_position_id', 'plantilla_item_number', 'form_branch_id', 'form_level',
            'gender', 'confirmPassword',
            'inactive_reason', 'effective_date', 'transfer_school'
        ]);
        $this->form_status = 'Active';
        $this->form_level = '';
        $this->gender = 'Male';
        
        // Default school branch to "Main"
        $mainBranch = Branch::where('name', 'Main')->first();
        $this->form_branch_id = $mainBranch ? $mainBranch->id : '';

        $this->initialValues = [];
        $this->isDirty = false;
        $this->showPasswordModal = false;
    }

    public function create()
    {
        $this->resetForm();
        $this->isDirty = true;
        $this->showModal = true;
    }

    public function edit(Faculty $faculty)
    {
        $this->editingId = $faculty->id;
        $this->faculty_id = $faculty->faculty_id;
        
        if ($faculty->user) {
            $this->name = $faculty->user->name;
            $this->email = $faculty->user->email;
        } else {
            $this->name = '';
            $this->email = '';
        }
        
        $this->form_department_id = $faculty->department_id;
        $this->form_status = $faculty->status;
        $this->plantilla_item_number = $faculty->plantillaPosition ? $faculty->plantillaPosition->plantilla_number : '';
        $this->form_position_id = $faculty->plantillaPosition ? $faculty->plantillaPosition->position_id : '';
        $this->form_branch_id = $faculty->branch_id;
        $this->form_level = $faculty->level;
        $this->gender = $faculty->gender ?: '';
        $this->inactive_reason = $faculty->inactive_reason ?: '';
        $this->effective_date = $faculty->effective_date ? $faculty->effective_date->format('Y-m-d') : '';
        $this->transfer_school = $faculty->transfer_school ?: '';

        $this->initialValues = [
            'faculty_id' => $this->faculty_id,
            'name' => $this->name,
            'email' => $this->email,
            'form_department_id' => $this->form_department_id,
            'form_status' => $this->form_status,
            'form_position_id' => $this->form_position_id,
            'plantilla_item_number' => $this->plantilla_item_number,
            'form_branch_id' => $this->form_branch_id,
            'form_level' => $this->form_level,
            'gender' => $this->gender ?: '',
            'inactive_reason' => $this->inactive_reason ?: '',
            'effective_date' => $this->effective_date ?: '',
            'transfer_school' => $this->transfer_school ?: '',
        ];

        $this->isDirty = false;
        $this->confirmPassword = '';
        $this->showPasswordModal = false;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        // 1. Plantilla Validation Check
        $plantilla = PlantillaPosition::where('plantilla_number', $this->plantilla_item_number)->first();
        
        if ($plantilla) {
            $assignedFaculty = Faculty::where('plantilla_position_id', $plantilla->id)
                ->whereIn('status', ['Active', 'On Leave'])
                ->when($this->editingId, function($q) {
                    $q->where('id', '!=', $this->editingId);
                })
                ->first();

            if ($assignedFaculty) {
                $this->addError('plantilla_item_number', 'This plantilla is already assigned to another active faculty.');
                $this->addError('form_position_id', 'Cannot assign this position.');
                return;
            }
        }

        if ($this->editingId) {
            // Edit of faculty record: prompt password confirmation
            $this->confirmPassword = '';
            $this->showPasswordModal = true;
        } else {
            // Create of faculty: save directly
            // Handle Plantilla Position Dynamic Creation
            $plantilla = PlantillaPosition::firstOrCreate(
                ['plantilla_number' => $this->plantilla_item_number],
                ['position_id' => $this->form_position_id]
            );
            $this->executeSave($plantilla);
        }
    }

    public function confirmPasswordAndSave()
    {
        $this->validate();

        $admin = auth()->user();
        if (!Hash::check($this->confirmPassword, $admin->password)) {
            $this->addError('confirmPassword', 'The password you entered is incorrect.');
            return;
        }

        // Handle Plantilla Position Dynamic Creation
        $plantilla = PlantillaPosition::firstOrCreate(
            ['plantilla_number' => $this->plantilla_item_number],
            ['position_id' => $this->form_position_id]
        );

        // Double check assignment just in case
        $assignedFaculty = Faculty::where('plantilla_position_id', $plantilla->id)
            ->whereIn('status', ['Active', 'On Leave'])
            ->when($this->editingId, function($q) {
                $q->where('id', '!=', $this->editingId);
            })
            ->first();

        if ($assignedFaculty) {
            $this->showPasswordModal = false;
            $this->addError('plantilla_item_number', 'This plantilla is already assigned to another active faculty.');
            return;
        }

        $this->executeSave($plantilla);
    }

    protected function executeSave($plantilla)
    {
        $userId = null;
        $isInactive = $this->form_status === 'Inactive';
        $assignedPlantillaId = $isInactive ? null : $plantilla->id;

        // If assigning this plantilla to an active/on leave faculty, clear it from any previous inactive holders
        if (!$isInactive) {
            Faculty::where('plantilla_position_id', $plantilla->id)
                ->when($this->editingId, function ($q) {
                    $q->where('id', '!=', $this->editingId);
                })
                ->update(['plantilla_position_id' => null]);
        }

        if ($this->editingId) {
            $faculty = Faculty::findOrFail($this->editingId);
            $user = $faculty->user;

            if (!$user) {
                $user = User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => Hash::make('password123'),
                    'role' => 'teacher',
                ]);
            } else {
                $user->update([
                    'name' => $this->name,
                    'email' => $this->email,
                ]);
            }
            $userId = $user->id;
        } else {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make('password123'),
                'role' => 'teacher',
            ]);
            $userId = $user->id;
        }

        if ($this->editingId) {
            $faculty = Faculty::findOrFail($this->editingId);
            $faculty->update([
                'user_id' => $userId,
                'faculty_id' => $this->faculty_id,
                'department_id' => $this->form_department_id,
                'status' => $this->form_status,
                'plantilla_position_id' => $assignedPlantillaId,
                'branch_id' => $this->form_branch_id,
                'level' => $this->form_level,
                'gender' => $this->gender,
                'inactive_reason' => $this->form_status === 'Inactive' ? $this->inactive_reason : null,
                'effective_date' => $this->form_status === 'Inactive' ? ($this->effective_date ?: null) : null,
                'transfer_school' => ($this->form_status === 'Inactive' && $this->inactive_reason === 'Transferred') ? $this->transfer_school : null,
            ]);

            $message = 'Faculty information successfully updated.';
        } else {
            Faculty::create([
                'user_id' => $userId,
                'faculty_id' => $this->faculty_id,
                'department_id' => $this->form_department_id,
                'status' => $this->form_status,
                'plantilla_position_id' => $assignedPlantillaId,
                'branch_id' => $this->form_branch_id,
                'level' => $this->form_level,
                'gender' => $this->gender,
                'inactive_reason' => $this->form_status === 'Inactive' ? $this->inactive_reason : null,
                'effective_date' => $this->form_status === 'Inactive' ? ($this->effective_date ?: null) : null,
                'transfer_school' => ($this->form_status === 'Inactive' && $this->inactive_reason === 'Transferred') ? $this->transfer_school : null,
            ]);

            $message = 'Faculty successfully registered.';
        }

        if (!$this->editingId) {
            $this->resetForm();
        }

        $this->showPasswordModal = false;
        $this->showModal = false;
        $this->confirmPassword = '';
        $this->isDirty = false;

        session()->flash('message', $message);
        $this->dispatch('faculty-saved', message: $message);
    }

    public function render()
    {
        $faculties = Faculty::with(['user', 'plantillaPosition.position', 'branch'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('user', function ($uq) {
                        $uq->where('name', 'like', '%' . $this->search . '%')
                           ->orWhere('email', 'like', '%' . $this->search . '%');
                    })
                    ->orWhere('faculty_id', 'like', '%' . $this->search . '%')
                    ->orWhereHas('plantillaPosition', function ($pq) {
                        $pq->where('plantilla_number', 'like', '%' . $this->search . '%');
                    });
                });
            })
            ->when($this->department, fn ($q) => $q->where('department_id', $this->department))
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->when($this->level, fn ($q) => $q->where('level', $this->level))
            ->when($this->branch_id, fn ($q) => $q->where('branch_id', $this->branch_id))
            ->when($this->position_id, fn ($q) => $q->whereHas('plantillaPosition', fn($pq) => $pq->where('position_id', $this->position_id)))
            ->when($this->gender_filter, fn ($q) => $q->where('gender', $this->gender_filter))
            ->paginate(10);

        $totalPlantillas = PlantillaPosition::count();
        $assignedPlantillas = Faculty::whereIn('status', ['Active', 'On Leave'])->whereNotNull('plantilla_position_id')->count();
        
        $stats = [
            'total_positions' => $totalPlantillas,
            'active' => Faculty::where('status', 'Active')->count(),
            'other_status' => Faculty::whereIn('status', ['On Leave', 'Inactive'])->count(),
            'vacancies' => max(0, $totalPlantillas - $assignedPlantillas),
        ];

        return view('livewire.admin.faculty-management', [
            'faculties' => $faculties,
            'stats' => $stats,
            'positions' => Position::sortedForForm()->get(),
            'branches' => Branch::orderBy('id')->get(),
            'allDepartments' => Department::orderBy('name')->get(),
            'formDepartments' => $this->form_level ? Department::where('level', $this->form_level)->orderBy('name')->get() : collect(),
        ]);
    }
}
