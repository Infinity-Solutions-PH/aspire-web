<?php

namespace App\Livewire\StudentPortal;

use App\Models\Violation;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Violations extends Component
{
    public function render()
    {
        $violations = Violation::where('user_id', Auth::id())
            ->orderBy('violation_date', 'desc')
            ->get();

        return view('livewire.student-portal.violations', [
            'violations' => $violations,
        ]);
    }
}
