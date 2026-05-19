<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Faculty;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class FacultyManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $department = '';
    public $status = '';

    // Form Properties
    public $showModal = false;
    public $editingId = null;
    public $faculty_id = '';
    public $name = '';
    public $email = '';
    public $form_department = '';
    public $form_status = 'Active';
    public $specialization = '';
    public $plantilla_item_number = '';
    public $gender = 'Male';
    public $resigned_date = '';
    public $transfer_date = '';

    protected function rules()
    {
        $faculty = $this->editingId ? Faculty::find($this->editingId) : null;
        $userId = $faculty ? $faculty->user_id : null;

        return [
            'faculty_id' => 'required|unique:faculties,faculty_id,' . $this->editingId,
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $userId,
            'form_department' => 'required',
            'form_status' => 'required|in:Active,On Leave,Retired,Deceased,Vacant',
            'specialization' => 'nullable|string',
            'plantilla_item_number' => 'nullable|string',
            'gender' => 'required|in:Male,Female,Other',
            'resigned_date' => 'nullable|date',
            'transfer_date' => 'nullable|date',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->reset([
            'editingId', 'faculty_id', 'name', 'email', 'form_department', 
            'form_status', 'specialization', 'plantilla_item_number', 
            'gender', 'resigned_date', 'transfer_date'
        ]);
        $this->form_status = 'Active';
        $this->gender = 'Male';
        $this->showModal = true;
    }

    public function edit(Faculty $faculty)
    {
        $this->editingId = $faculty->id;
        $this->faculty_id = $faculty->faculty_id;
        $this->name = $faculty->user->name;
        $this->email = $faculty->user->email;
        $this->form_department = $faculty->department;
        $this->form_status = $faculty->status;
        $this->specialization = $faculty->specialization;
        $this->plantilla_item_number = $faculty->plantilla_item_number;
        $this->gender = $faculty->gender ?: 'Male';
        $this->resigned_date = $faculty->resigned_date ? $faculty->resigned_date->format('Y-m-d') : '';
        $this->transfer_date = $faculty->transfer_date ? $faculty->transfer_date->format('Y-m-d') : '';
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editingId) {
            $faculty = Faculty::findOrFail($this->editingId);
            $user = $faculty->user;

            $user->update([
                'name' => $this->name,
                'email' => $this->email,
            ]);

            $faculty->update([
                'faculty_id' => $this->faculty_id,
                'department' => $this->form_department,
                'status' => $this->form_status,
                'specialization' => $this->specialization,
                'plantilla_item_number' => $this->plantilla_item_number ?: null,
                'gender' => $this->gender,
                'resigned_date' => $this->resigned_date ?: null,
                'transfer_date' => $this->transfer_date ?: null,
            ]);

            $message = 'Faculty information successfully updated.';
        } else {
            // 1. Create User
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make('password'), // Default password
                'role' => 'teacher',
            ]);

            // 2. Create Faculty record
            Faculty::create([
                'user_id' => $user->id,
                'faculty_id' => $this->faculty_id,
                'department' => $this->form_department,
                'status' => $this->form_status,
                'specialization' => $this->specialization,
                'plantilla_item_number' => $this->plantilla_item_number ?: null,
                'gender' => $this->gender,
                'resigned_date' => $this->resigned_date ?: null,
                'transfer_date' => $this->transfer_date ?: null,
            ]);

            $message = 'Faculty successfully registered.';
        }

        $this->showModal = false;
        $this->dispatch('faculty-saved', message: $message);
    }

    public function render()
    {
        $faculties = Faculty::with('user')
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
            'stats' => $stats
        ]);
    }
}
