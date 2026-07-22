<?php

namespace App\Livewire\StudentPortal;

use App\Models\Violation;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('layouts.student-portal')]
class Violations extends Component
{
    public function render()
    {
        $violations = Auth::user()->violations()
            ->orderBy('violation_date', 'desc')
            ->get();

        return view('livewire.student-portal.violations', [
            'violations' => $violations,
        ]);
    }
}
