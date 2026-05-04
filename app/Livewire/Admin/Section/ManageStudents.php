<?php

namespace App\Livewire\Admin\Section;

use App\Models\Section;
use App\Models\Enrollment;
use Livewire\Component;
use Livewire\WithPagination;

class ManageStudents extends Component
{
    use WithPagination;

    public Section $section;
    public $search = '';
    public $activeSex = 'All';

    public function mount(Section $section)
    {
        $this->section = $section->load('adviser');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingActiveSex()
    {
        $this->resetPage();
    }

    public function render()
    {
        $sectionColumn = $this->section->track === 'TVL' ? 'tech_voc_section_id' : 'section_id';

        $baseQuery = Enrollment::with('techVocSection')->where($sectionColumn, $this->section->id)
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%')
                      ->orWhere('lrn', 'like', '%' . $this->search . '%');
                });
            });

        $totalMales = (clone $baseQuery)->where('sex', 'Male')->count();
        $totalFemales = (clone $baseQuery)->where('sex', 'Female')->count();

        $students = $baseQuery->when($this->activeSex !== 'All', function($query) {
                $query->where('sex', $this->activeSex);
            })
            ->orderBy('sex', 'desc') // 'Male' before 'Female'
            ->orderBy('last_name', 'asc')
            ->orderBy('first_name', 'asc')
            ->paginate(10);

        return view('livewire.admin.section.manage-students', [
            'students' => $students,
            'totalMales' => $totalMales,
            'totalFemales' => $totalFemales,
        ])->layout('layouts.app');
    }
}
