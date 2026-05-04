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
    public $activeCourse = 'All';
    
    // Create Modal state
    public $showCreateModal = false;
    public $newSection = [
        'type' => 'normal', // normal or tvl
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
    // Auto Sectioning Modal state
    public $showAutoSectionModal = false;
    public $activeAutoTab = 'jhs'; // jhs, tvl, shs
    public $autoGrade = '';
    public $autoCourseStrand = '';

    public function mount()
    {
        $this->newSection['capacity'] = Setting::get('global_default_capacity', 40);
        $this->newSection['type'] = 'normal';
        $this->autoGrade = 'Grade 7'; // Default
    }

    public function updatedActiveAutoTab($value)
    {
        if ($value === 'jhs') {
            $this->autoGrade = 'Grade 7';
            $this->autoCourseStrand = '';
        } elseif ($value === 'tvl') {
            $this->autoGrade = 'Grade 8';
            $this->autoCourseStrand = '';
        } elseif ($value === 'shs') {
            $this->autoGrade = 'Grade 11';
            $this->autoCourseStrand = 'STEM';
        }
    }

    public function updated($property, $value)
    {
        if (str_starts_with($property, 'newSection.')) {
            $this->generateAutoSectionName();
        }
    }

    public function generateAutoSectionName()
    {
        $type = $this->newSection['type'] ?? 'normal';
        $gradeLevel = $this->newSection['grade_level'] ?? '';
        
        $isTechVoc = ($type === 'tvl');
        $isShs = ($type === 'normal' && in_array($gradeLevel, ['Grade 11', 'Grade 12']));

        if (!$gradeLevel || (!$isTechVoc && !$isShs)) {
            // For JHS Normal sections, we don't auto-generate names
            if ($isTechVoc || $isShs) {
                $this->newSection['name'] = '';
            }
            return;
        }

        $gradeNumber = str_replace('Grade ', '', $gradeLevel);
        $prefix = "G-{$gradeNumber}";
        $suffixBase = '';

        if ($isTechVoc && !empty($this->newSection['specialization'])) {
            $suffixBase = $this->newSection['specialization'];
        } elseif ($isShs && !empty($this->newSection['strand'])) {
            $suffixBase = $this->newSection['strand'];
        }

        if ($suffixBase) {
            $basePattern = "{$prefix} - {$suffixBase}-";
            
            $existingCount = Section::where('name', 'like', "{$basePattern}%")->count();
            $letter = chr(65 + $existingCount);
            
            while (Section::where('name', "{$basePattern}{$letter}")->exists()) {
                $existingCount++;
                $letter = chr(65 + $existingCount);
            }

            $this->newSection['name'] = "{$basePattern}{$letter}";
        } else {
            $this->newSection['name'] = '';
        }
    }

    public function createSection()
    {
        $this->validate([
            'newSection.type' => 'required|in:normal,tvl',
            'newSection.name' => 'required|string|max:255',
            'newSection.grade_level' => 'required',
            'newSection.capacity' => 'required|integer|min:1',
        ]);
 
        $data = $this->newSection;
        
        if ($data['type'] === 'tvl') {
            $data['track'] = 'TVL';
            $data['is_star_section'] = false;
            $data['strand'] = null; // Not using strand for TVL here
        } else {
            // Normal section
            if (!in_array($data['grade_level'], ['Grade 11', 'Grade 12'])) {
                $data['strand'] = null;
            }
            $data['specialization'] = null; // Normal sections don't have TVL specialization
        }
        
        unset($data['type']); // Remove helper property before DB insertion

        Section::create($data);
        
        $this->showCreateModal = false;
        $this->reset('newSection');
        $this->newSection['capacity'] = Setting::get('global_default_capacity', 40);
        $this->newSection['type'] = 'normal';
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

    public function getUnsectionedStatsProperty()
    {
        $query = Enrollment::where('status', 'Enrolled')->whereNull('section_id');

        if ($this->autoGrade) {
            $query->where('grade_level', $this->autoGrade);
        }

        if ($this->activeAutoTab === 'jhs') {
            $query->where(function($q) {
                $q->whereNull('track')->orWhere('track', '!=', 'TVL');
            });
        } elseif ($this->activeAutoTab === 'tvl') {
            $query->where('track', 'TVL');
            if ($this->autoCourseStrand) {
                // Assuming specialization or strand represents the course in TVL
                $query->where(function($q) {
                    $q->where('specialization', $this->autoCourseStrand)
                      ->orWhere('strand', $this->autoCourseStrand);
                });
            }
        } elseif ($this->activeAutoTab === 'shs') {
            if ($this->autoCourseStrand) {
                $query->where('strand', $this->autoCourseStrand);
            }
        }

        $students = $query->get();

        return [
            'total' => $students->count(),
            'male' => $students->where('sex', 'Male')->count(),
            'female' => $students->where('sex', 'Female')->count(),
        ];
    }
 
    public function runAutoSectioning(SectioningService $service)
    {
        if (!$this->autoGrade) {
            session()->flash('error', 'Please select a specific grade level to run auto-sectioning.');
            return;
        }
 
        try {
            if ($this->activeAutoTab === 'jhs') {
                $result = $service->runJhsShsSectioning($this->autoGrade);
            } elseif ($this->activeAutoTab === 'tvl') {
                $result = $service->runTechVocSectioning($this->autoGrade, $this->autoCourseStrand);
            } elseif ($this->activeAutoTab === 'shs') {
                $result = $service->runJhsShsSectioning($this->autoGrade, $this->autoCourseStrand);
            }
 
            session()->flash('message', $result['message']);
            $this->showAutoSectionModal = false;
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }
 
    public function render()
    {
        $query = Section::with(['adviser', 'enrollments'])
            ->withCount('enrollments')
            ->orderBy('is_star_section', 'desc')
            ->orderBy('name', 'asc');
 
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
 
        if ($this->activeGrade !== 'All') {
            $query->where('grade_level', $this->activeGrade);
        }
 
        if ($this->activeStrand !== 'All') {
            $query->where('strand', $this->activeStrand);
        }

        if ($this->activeCourse !== 'All') {
            $query->where(function($q) {
                $q->where('specialization', $this->activeCourse)
                  ->orWhere('strand', $this->activeCourse);
            });
        }

 
        return view('pages.Admin.section-management', [
            'sections' => $query->get(),
            'teachers' => User::where('role', 'teacher')->orWhere('role', 'dept_head')->get(),
        ])->layout('layouts.app'); // Or pipeline if that's the base
    }
}
