<?php

namespace App\Livewire;

use Livewire\Component;

class EnrollmentPipeline extends Component
{
    public $currentStep = 2; 

    public $steps = [
        1 => ['id' => 1, 'title' => 'Portal Registration', 'status' => 'completed', 'icon' => 'user-plus'],
        2 => ['id' => 2, 'title' => 'DepEd Form Annex 1', 'status' => 'active', 'icon' => 'document-text'],
        3 => ['id' => 3, 'title' => 'Registrar Verification', 'status' => 'pending', 'icon' => 'shield-check'],
        4 => ['id' => 4, 'title' => 'Sectioning (Grade 7/8)', 'status' => 'pending', 'icon' => 'user-group'],
        5 => ['id' => 5, 'title' => 'Officially Enrolled', 'status' => 'pending', 'icon' => 'academic-cap'],
    ];

    public function advancePipeline()
    {
        if ($this->currentStep < 5) {
            $this->steps[$this->currentStep]['status'] = 'completed';
            $this->currentStep++;
            $this->steps[$this->currentStep]['status'] = 'active';
        }
    }

    public function render()
    {
        return view('livewire.enrollment-pipeline');
    }
}
