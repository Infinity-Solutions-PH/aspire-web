<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Faculty;
use App\Models\Position;
use App\Models\Branch;
use Livewire\Component;
use Livewire\WithPagination;
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
    public $form_department = '';
    public $form_status = 'Active';
    public $form_position_id = '';
    public $form_branch_id = '';
    public $form_level = 'JHS';
    public $plantilla_item_number = '';
    public $gender = 'Male';
    public $resigned_date = '';
    public $transfer_date = '';

    // Password Confirmation States & Dirty Tracking
    public $showPasswordModal = false;
    public $confirmPassword = '';
    public $initialValues = [];
    public $isDirty = false;

    protected function rules()
    {
        $faculty = $this->editingId ? Faculty::find($this->editingId) : null;
        $userId = $faculty ? $faculty->user_id : null;

        $rules = [
            'faculty_id' => 'required|unique:faculties,faculty_id,' . $this->editingId,
            'form_department' => 'required',
            'form_status' => 'required|in:Active,On Leave,Retired,Deceased,Vacant',
            'form_position_id' => 'required|exists:positions,id',
            'form_branch_id' => 'required|exists:branches,id',
            'form_level' => 'required|in:JHS,SHS',
            'plantilla_item_number' => 'nullable|string',
            'gender' => $this->form_status === 'Vacant' ? 'nullable|in:Male,Female,Other' : 'required|in:Male,Female,Other',
            'resigned_date' => 'nullable|date',
            'transfer_date' => 'nullable|date',
        ];

        if ($this->form_status === 'Vacant') {
            $rules['name'] = 'nullable|string';
            $rules['email'] = 'nullable|email';
        } else {
            $rules['name'] = 'required|min:3';
            $rules['email'] = 'required|email|unique:users,email,' . $userId;
        }

        return $rules;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'form_status' && $this->form_status === 'Vacant') {
            $this->name = '';
            $this->email = '';
            $this->gender = '';
        }

        if ($this->editingId) {
            $currentValues = [
                'faculty_id' => $this->faculty_id,
                'name' => $this->name,
                'email' => $this->email,
                'form_department' => $this->form_department,
                'form_status' => $this->form_status,
                'form_position_id' => $this->form_position_id,
                'form_branch_id' => $this->form_branch_id,
                'form_level' => $this->form_level,
                'plantilla_item_number' => $this->plantilla_item_number ?: '',
                'gender' => $this->gender ?: '',
                'resigned_date' => $this->resigned_date ?: '',
                'transfer_date' => $this->transfer_date ?: '',
            ];

            $this->isDirty = $currentValues !== $this->initialValues;
        } else {
            $this->isDirty = true;
        }
    }

    public function create()
    {
        $this->reset([
            'editingId', 'faculty_id', 'name', 'email', 'form_department', 
            'form_status', 'form_position_id', 'form_branch_id', 'form_level',
            'plantilla_item_number', 'gender', 'resigned_date', 'transfer_date', 'confirmPassword'
        ]);
        $this->form_status = 'Active';
        $this->form_level = 'JHS';
        $this->gender = 'Male';
        $this->initialValues = [];
        $this->isDirty = true;
        $this->showPasswordModal = false;
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
        
        $this->form_department = $faculty->department;
        $this->form_status = $faculty->status;
        $this->form_position_id = $faculty->position_id;
        $this->form_branch_id = $faculty->branch_id;
        $this->form_level = $faculty->level;
        $this->plantilla_item_number = $faculty->plantilla_item_number;
        $this->gender = $faculty->gender ?: '';
        $this->resigned_date = $faculty->resigned_date ? $faculty->resigned_date->format('Y-m-d') : '';
        $this->transfer_date = $faculty->transfer_date ? $faculty->transfer_date->format('Y-m-d') : '';

        $this->initialValues = [
            'faculty_id' => $this->faculty_id,
            'name' => $this->name,
            'email' => $this->email,
            'form_department' => $this->form_department,
            'form_status' => $this->form_status,
            'form_position_id' => $this->form_position_id,
            'form_branch_id' => $this->form_branch_id,
            'form_level' => $this->form_level,
            'plantilla_item_number' => $this->plantilla_item_number ?: '',
            'gender' => $this->gender ?: '',
            'resigned_date' => $this->resigned_date ?: '',
            'transfer_date' => $this->transfer_date ?: '',
        ];

        $this->isDirty = false;
        $this->confirmPassword = '';
        $this->showPasswordModal = false;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        // Prompt password confirmation
        $this->confirmPassword = '';
        $this->showPasswordModal = true;
    }

    public function confirmPasswordAndSave()
    {
        $this->validate();

        $admin = auth()->user();
        if (!Hash::check($this->confirmPassword, $admin->password)) {
            $this->addError('confirmPassword', 'The password you entered is incorrect.');
            return;
        }

        $userId = null;

        // Only manage user accounts for non-vacant positions
        if ($this->form_status !== 'Vacant') {
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
        }

        if ($this->editingId) {
            $faculty = Faculty::findOrFail($this->editingId);
            $faculty->update([
                'user_id' => $userId,
                'faculty_id' => $this->faculty_id,
                'department' => $this->form_department,
                'status' => $this->form_status,
                'position_id' => $this->form_position_id,
                'branch_id' => $this->form_branch_id,
                'level' => $this->form_level,
                'plantilla_item_number' => $this->plantilla_item_number ?: null,
                'gender' => $this->form_status === 'Vacant' ? null : $this->gender,
                'resigned_date' => $this->resigned_date ?: null,
                'transfer_date' => $this->transfer_date ?: null,
            ]);

            $message = 'Faculty information successfully updated.';
        } else {
            Faculty::create([
                'user_id' => $userId,
                'faculty_id' => $this->faculty_id,
                'department' => $this->form_department,
                'status' => $this->form_status,
                'position_id' => $this->form_position_id,
                'branch_id' => $this->form_branch_id,
                'level' => $this->form_level,
                'plantilla_item_number' => $this->plantilla_item_number ?: null,
                'gender' => $this->form_status === 'Vacant' ? null : $this->gender,
                'resigned_date' => $this->resigned_date ?: null,
                'transfer_date' => $this->transfer_date ?: null,
            ]);

            $message = 'Faculty successfully registered.';
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
        $faculties = Faculty::with(['user', 'position', 'branch'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('user', function ($uq) {
                        $uq->where('name', 'like', '%' . $this->search . '%')
                           ->orWhere('email', 'like', '%' . $this->search . '%');
                    })
                    ->orWhere('faculty_id', 'like', '%' . $this->search . '%')
                    ->orWhere('plantilla_item_number', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->department, fn ($q) => $q->where('department', $this->department))
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->when($this->level, fn ($q) => $q->where('level', $this->level))
            ->when($this->branch_id, fn ($q) => $q->where('branch_id', $this->branch_id))
            ->when($this->position_id, fn ($q) => $q->where('position_id', $this->position_id))
            ->when($this->gender_filter, fn ($q) => $q->where('gender', $this->gender_filter))
            ->paginate(10);

        $stats = [
            'total' => Faculty::count(),
            'active' => Faculty::where('status', 'Active')->count(),
            'on_leave' => Faculty::where('status', 'On Leave')->count(),
            'retired' => Faculty::where('status', 'Retired')->count(),
            'deceased' => Faculty::where('status', 'Deceased')->count(),
            'vacant' => Faculty::where('status', 'Vacant')->count(),
        ];

        return view('livewire.admin.faculty-management', [
            'faculties' => $faculties,
            'stats' => $stats,
            'positions' => Position::orderBy('id')->get(),
            'branches' => Branch::orderBy('name')->get(),
        ]);
    }
}
