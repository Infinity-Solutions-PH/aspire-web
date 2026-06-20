<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Cache;

class GlobalExportMonitor extends Component
{
    public $isExporting = false;

    public function mount()
    {
        $statusData = Cache::get('export_status_' . auth()->id());
        if ($statusData && $statusData['status'] === 'processing') {
            $this->isExporting = true;
        }
    }

    #[On('export-started')]
    public function handleExportStarted()
    {
        $this->isExporting = true;
    }

    public function checkExportStatus()
    {
        if (!$this->isExporting) {
            return;
        }

        $statusData = Cache::get('export_status_' . auth()->id());

        if (!$statusData) {
            return;
        }

        if ($statusData['status'] === 'completed') {
            $this->isExporting = false;
            Cache::forget('export_status_' . auth()->id());
            
            session()->flash('message', 'Export completed successfully! Downloading...');
            
            $this->js('window.location.href = "' . route('admin.export.download', ['file' => $statusData['file']]) . '";');
        } elseif ($statusData['status'] === 'failed') {
            $this->isExporting = false;
            Cache::forget('export_status_' . auth()->id());
            
            $errorMessage = $statusData['message'] ?? 'An error occurred during export.';
            session()->flash('error', 'Export failed: ' . $errorMessage);
        }
    }

    public function render()
    {
        return view('livewire.admin.global-export-monitor');
    }
}
