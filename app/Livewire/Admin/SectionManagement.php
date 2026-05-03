<?php
 
namespace App\Livewire\Admin;
 
use App\Models\Section;
use App\Models\User;
use App\Models\Enrollment;
use App\Models\Setting;
use App\Services\SectioningService;
use Livewire\Component;
use Livewire\WithPagination;
 
class SectionManagement extends Component
{
    use WithPagination;
 
    public $search = '';
    public $activeGrade = 'All';
    public $activeStrand = 'All';
    
    // Create Modal state
    public $showCreateModal = false;
    public $newSection = [
        'name' => '',
        'grade_level' => '',
        'track' => '',
        'strand' => '',
        'specialization' => '',
        'capacity' => 40,
        'is_star_section' => false,
        'room' => '',
        'adviser_id' => null,
    ];

    // Adviser Modal state
    public $showAdviserModal = false;
    public $selectedSectionId = null;
    public $selectedAdviserId = null;
    public $currentSectionName = '';
 
    public function mount()
    {
        $this->newSection['capacity'] = Setting::get('global_default_capacity', 40);
    }
 
    public function createSection()
    {
        $this->validate([
            'newSection.name' => 'required|string|max:255',
            'newSection.grade_level' => 'required',
            'newSection.capacity' => 'required|integer|min:1',
        ]);
 
        Section::create($this->newSection);
        $this->showCreateModal = false;
        $this->reset('newSection');
        $this->newSection['capacity'] = Setting::get('global_default_capacity', 40);
        session()->flash('message', 'Section created successfully!');
    }

    public function openAdviserModal($sectionId)
    {
        $this->selectedSectionId = $sectionId;
        $section = Section::find($sectionId);
        $this->currentSectionName = $section->name;
        $this->selectedAdviserId = $section->adviser_id;
        $this->showAdviserModal = true;
    }
 
    public function assignAdviser()
    {
        $this->validate([
            'selectedAdviserId' => 'required',
        ]);
 
        $section = Section::find($this->selectedSectionId);
        $section->update([
            'adviser_id' => $this->selectedAdviserId,
        ]);
 
        $this->showAdviserModal = false;
        $this->reset(['selectedSectionId', 'selectedAdviserId', 'currentSectionName']);
        session()->flash('message', 'Adviser assigned successfully!');
    }
 
    public function runAutoSectioning(SectioningService $service)
    {
        if ($this->activeGrade === 'All') {
            session()->flash('error', 'Please select a specific grade level to run auto-sectioning.');
            return;
        }
 
        try {
            $result = $service->runBatchSectioning(
                $this->activeGrade,
                $this->activeStrand !== 'All' ? null : null, // Need to handle track/strand logic better
                $this->activeStrand !== 'All' ? $this->activeStrand : null
            );
 
            session()->flash($result['status'], $result['message']);
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }
 
    public function render()
    {
        $query = Section::with(['adviser', 'enrollments'])
            ->withCount('enrollments');
 
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
 
        if ($this->activeGrade !== 'All') {
            $query->where('grade_level', $this->activeGrade);
        }
 
        if ($this->activeStrand !== 'All') {
            $query->where('strand', $this->activeStrand);
        }
 
        return view('pages.Admin.section-management', [
            'sections' => $query->get(),
            'teachers' => User::where('role', 'teacher')->orWhere('role', 'dept_head')->get(),
        ])->layout('layouts.app'); // Or pipeline if that's the base
    }
}
