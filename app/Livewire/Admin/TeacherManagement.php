<?php
 
namespace App\Livewire\Admin;
 
use App\Models\User;
use App\Models\Teacher;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
 
class TeacherManagement extends Component
{
    use WithPagination;
 
    public $search = '';
    public $department = '';
    public $status = '';
 
    // Form Properties
    public $showModal = false;
    public $editingId = null;
    public $teacher_id = '';
    public $name = '';
    public $email = '';
    public $form_department = '';
    public $form_status = 'Active';
    public $specialization = '';
 
    protected function rules()
    {
        $teacher = $this->editingId ? Teacher::find($this->editingId) : null;
        $userId = $teacher ? $teacher->user_id : null;

        return [
            'teacher_id' => 'required|unique:teachers,teacher_id,' . $this->editingId,
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $userId,
            'form_department' => 'required',
            'form_status' => 'required',
            'specialization' => 'nullable|string',
        ];
    }
 
    public function updatingSearch()
    {
        $this->resetPage();
    }
 
    public function create()
    {
        $this->reset(['editingId', 'teacher_id', 'name', 'email', 'form_department', 'form_status', 'specialization']);
        $this->showModal = true;
    }

    public function edit(Teacher $teacher)
    {
        $this->editingId = $teacher->id;
        $this->teacher_id = $teacher->teacher_id;
        $this->name = $teacher->user->name;
        $this->email = $teacher->user->email;
        $this->form_department = $teacher->department;
        $this->form_status = $teacher->status;
        $this->specialization = $teacher->specialization;
        $this->showModal = true;
    }
 
    public function save()
    {
        $this->validate();
 
        if ($this->editingId) {
            $teacher = Teacher::findOrFail($this->editingId);
            $user = $teacher->user;

            $user->update([
                'name' => $this->name,
                'email' => $this->email,
            ]);

            $teacher->update([
                'teacher_id' => $this->teacher_id,
                'department' => $this->form_department,
                'status' => $this->form_status,
                'specialization' => $this->specialization,
            ]);

            $message = 'Teacher information successfully updated.';
        } else {
            // 1. Create/Find User
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make('password'), // Default password
                'role' => 'teacher',
            ]);
    
            // 2. Create Teacher record
            Teacher::create([
                'user_id' => $user->id,
                'teacher_id' => $this->teacher_id,
                'department' => $this->form_department,
                'status' => $this->form_status,
                'specialization' => $this->specialization,
            ]);

            $message = 'Teacher successfully registered.';
        }
 
        $this->showModal = false;
        $this->dispatch('teacher-saved', message: $message);
    }
 
    public function render()
    {
        $teachers = Teacher::with('user')
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })->orWhere('teacher_id', 'like', '%' . $this->search . '%');
            })
            ->when($this->department, fn ($q) => $q->where('department', $this->department))
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->paginate(10);
 
        $stats = [
            'total' => Teacher::count(),
            'active' => Teacher::where('status', 'Active')->count(),
            'on_leave' => Teacher::where('status', 'On Leave')->count(),
        ];
 
        return view('livewire.admin.teacher-management', [
            'teachers' => $teachers,
            'stats' => $stats
        ]);
    }
}
