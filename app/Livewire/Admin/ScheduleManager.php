<?php

namespace App\Livewire\Admin;

use App\Models\Section;
use App\Models\Room;
use App\Models\Schedule;
use Livewire\Component;

class ScheduleManager extends Component
{
    public $search = '';
    public $activeTrack = null;

    protected $queryString = ['search', 'activeTrack'];

    public function render()
    {
        $sections = Section::withCount('enrollments')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('track', 'like', '%' . $this->search . '%');
            })
            ->when($this->activeTrack, function ($query) {
                $query->where('track', $this->activeTrack);
            })
            ->get();

        $rooms = Room::with(['schedules.section', 'schedules.subject'])->get();
        
        $schedules = Schedule::with(['section', 'subject', 'room', 'teacher'])
            ->latest()
            ->take(10)
            ->get();

        return view('livewire.admin.schedule-manager', [
            'sections' => $sections,
            'rooms' => $rooms,
            'recentSchedules' => $schedules,
            'tracks' => Section::distinct()->pluck('track')->filter(),
        ]);
    }

    public function recalculateLoad()
    {
        // Mock logic for recalculating system load
        session()->flash('message', 'System load recalculated based on latest enrollments.');
    }
}
