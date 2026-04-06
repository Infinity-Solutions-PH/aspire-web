<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class EnrollmentPost extends Component
{
    public function mount()
    {
        $enrollment = Enrollment::where('user_id', Auth::id())->first();

        // If the enrollment is already verified (i.e. registrar checked), 
        // they shouldn't be seeing the post-enrollment schedule screen anymore.
        if ($enrollment && $enrollment->status === 'Verified') {
            return redirect()->route('dashboard');
        }
    }

    public function render()
    {
        return view('livewire.enrollment-post');
    }
}
