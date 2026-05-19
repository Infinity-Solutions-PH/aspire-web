<?php

namespace App\Livewire\Admin;

use App\Models\PlantillaPosition;
use App\Models\Position;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class PlantillaManagement extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    #[Url]
    public $position_id = '';

    #[Url]
    public $status = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPositionId()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        $plantillasQuery = PlantillaPosition::with(['position', 'faculty.user'])
            ->when($this->search, function ($query) {
                $query->where('plantilla_number', 'like', '%' . $this->search . '%');
            })
            ->when($this->position_id, function ($query) {
                $query->where('position_id', $this->position_id);
            });

        if ($this->status === 'vacant') {
            $plantillasQuery->doesntHave('faculty', 'and', function ($query) {
                $query->whereIn('status', ['Active', 'On Leave']);
            });
        } elseif ($this->status === 'assigned') {
            $plantillasQuery->whereHas('faculty', function ($query) {
                $query->whereIn('status', ['Active', 'On Leave']);
            });
        }

        $plantillas = $plantillasQuery->orderBy('plantilla_number')->paginate(15);

        // Calculate stats
        $totalPositions = PlantillaPosition::count();
        $assignedPositions = PlantillaPosition::whereHas('faculty', function ($query) {
            $query->whereIn('status', ['Active', 'On Leave']);
        })->count();
        
        $stats = [
            'total' => $totalPositions,
            'assigned' => $assignedPositions,
            'vacancies' => max(0, $totalPositions - $assignedPositions),
        ];

        return view('livewire.admin.plantilla-management', [
            'plantillas' => $plantillas,
            'positions' => Position::orderBy('id')->get(),
            'stats' => $stats,
        ]);
    }
}
