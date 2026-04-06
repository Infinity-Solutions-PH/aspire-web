<?php

namespace App\Livewire\Student;

use App\Models\SafetyWaiver as WaiverModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SafetyWaiver extends Component
{
    public $signed = false;
    public $showModal = false;

    public function mount()
    {
        $waiver = WaiverModel::where('user_id', Auth::id())->first();
        if (!$waiver) {
            $this->showModal = true;
        } else {
            $this->signed = true;
        }
    }

    public function sign()
    {
        WaiverModel::updateOrCreate(
            ['user_id' => Auth::id()],
            ['signed_at' => now()]
        );

        $this->signed = true;
        $this->showModal = false;
        $this->dispatch('waiver-signed');
        session()->flash('message', 'Safety waiver signed successfully. Laboratory access granted.');
    }

    public function render()
    {
        return view('livewire.student.safety-waiver');
    }
}
