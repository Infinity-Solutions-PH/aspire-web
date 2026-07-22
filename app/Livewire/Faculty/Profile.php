<?php

namespace App\Livewire\Faculty;

use App\Models\User;
use App\Models\Faculty;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

#[Layout('layouts.faculty-portal')]
class Profile extends Component
{
    public $name;
    public $email;
    public $gender;

    // Password fields
    public $current_password = '';
    public $new_password = '';
    public $new_password_confirmation = '';

    // Read only fields
    public $faculty_id;

    public $level;
    public $department_name;
    public $position_name;
    public $plantilla_number;
    public $status;

    public function mount()
    {
        $user = auth()->user();
        $faculty = $user->faculty;

        $this->name = $user->name;
        $this->email = $user->email;

        if ($faculty) {
            $this->faculty_id = $faculty->faculty_id;
            $this->gender = $faculty->gender;
            $this->level = $faculty->level === 'JHS' ? 'Junior High School (JHS)' : ($faculty->level === 'SHS' ? 'Senior High School (SHS)' : 'N/A');
            $this->department_name = $faculty->department ? $faculty->department->name : 'N/A';
            $this->position_name = $faculty->plantillaPosition && $faculty->plantillaPosition->position ? $faculty->plantillaPosition->position->name : 'N/A';
            $this->plantilla_number = $faculty->plantillaPosition ? $faculty->plantillaPosition->plantilla_number : 'N/A';
            $this->status = $faculty->status;
        }
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => ['required', 'confirmed', Password::defaults()],
        ], [], [
            'current_password' => 'current password',
            'new_password' => 'new password',
        ]);

        $user = auth()->user();

        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'The password you entered is incorrect.');
            return;
        }

        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

        session()->flash('message', 'Password updated successfully.');
    }

    public function render()
    {
        return view('livewire.faculty.profile');
    }
}
