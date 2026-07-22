<?php
 
namespace App\Livewire\Admin;
 
use App\Models\Room;
use App\Models\Faculty;
use App\Models\Section;
use Livewire\Component;
use App\Models\Enrollment;
use Livewire\WithPagination;
use App\Models\SectionSetting;
use App\Services\SectioningService;
 
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
        'room_id' => null,
        'adviser_id' => null,
    ];

    // Adviser Modal state
    public $showAdviserModal = false;
    public $selectedSectionId = null;
    public $selectedAdviserId = null;
    public $currentSectionName = '';
    public $adviserSearch = '';

    // Room Modal state
    public $showRoomModal = false;
    public $selectedRoomId = null;
    public $roomSearch = '';
    // Auto Sectioning Modal state
    public $showAutoSectionModal = false;
    public $activeAutoTab = 'jhs'; // jhs, tvl, shs
    public $autoGrade = '';
    public $autoCourseStrand = '';

    protected $validationAttributes = [
        'newSection.name' => 'section name',
        'newSection.grade_level' => 'grade level',
        'newSection.capacity' => 'capacity',
        'newSection.track' => 'track',
        'newSection.strand' => 'strand',
        'newSection.specialization' => 'specialization',
    ];

    public function mount()
    {
        $this->newSection['capacity'] = SectionSetting::get('global_default_capacity', 40);
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
            $this->autoCourseStrand = 'All';
        } elseif ($value === 'shs') {
            $this->autoGrade = 'Grade 11';
            $this->autoCourseStrand = 'All';
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

    public function setNewSectionType($type)
    {
        $this->newSection['type'] = $type;
        $this->generateAutoSectionName();
    }

    public function createSection()
    {
        $rules = [
            'newSection.type' => 'required|in:normal,tvl',
            'newSection.name' => 'required|string|max:255',
            'newSection.grade_level' => 'required',
            'newSection.capacity' => 'required|integer|min:1',
        ];

        if ($this->newSection['type'] === 'tvl') {
            $rules['newSection.specialization'] = 'required';
        }

        if ($this->newSection['type'] === 'normal' && in_array($this->newSection['grade_level'], ['Grade 11', 'Grade 12'])) {
            $rules['newSection.track'] = 'required|in:ACADEMIC,TECHPRO';
            $rules['newSection.strand'] = 'required';
        }

        $this->validate($rules);
 
        $data = $this->newSection;
        
        if ($data['type'] === 'tvl') {
            $data['track'] = null;
            $data['strand'] = null;
        } else {
            // Normal section
            if (!in_array($data['grade_level'], ['Grade 11', 'Grade 12'])) {
                $data['track'] = null;
                $data['strand'] = null;
            }
            $data['specialization'] = null; // Normal sections don't have TVL specialization
        }
        
        unset($data['type']); // Remove helper property before DB insertion

        Section::create($data);
        
        $this->showCreateModal = false;
        $this->reset('newSection');
        $this->newSection['capacity'] = SectionSetting::get('global_default_capacity', 40);
        $this->newSection['type'] = 'normal';
        session()->flash('message', 'Section created successfully!');
    }

    public function openAdviserModal($sectionId)
    {
        $this->selectedSectionId = $sectionId;
        $section = Section::find($sectionId);
        $this->currentSectionName = $section->name;
        $this->selectedAdviserId = $section->adviser_id;
        $this->adviserSearch = '';
        $this->showAdviserModal = true;
    }
 
    public function assignAdviser()
    {
        $this->validate([
            'selectedAdviserId' => 'nullable|exists:users,id',
        ]);
 
        $section = Section::find($this->selectedSectionId);
        $section->update([
            'adviser_id' => $this->selectedAdviserId,
        ]);
 
        $this->showAdviserModal = false;
        $this->reset(['selectedSectionId', 'selectedAdviserId', 'currentSectionName', 'adviserSearch']);
        session()->flash('message', 'Adviser assigned successfully!');
    }

    public function getFacultySearchResultsProperty()
    {
        $search = trim($this->adviserSearch);
        return Faculty::where('status', 'Active')
            ->whereHas('user', function ($query) {
                $query->role('faculty');
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('faculty_id', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($uq) use ($search) {
                          $uq->where('name', 'like', "%{$search}%");
                      });
                });
            })
            ->with('user')
            ->limit(5)
            ->get();
    }

    public function openRoomModal($sectionId)
    {
        $this->selectedSectionId = $sectionId;
        $section = Section::find($sectionId);
        $this->currentSectionName = $section->name;
        $this->selectedRoomId = $section->room_id;
        $this->roomSearch = '';
        $this->showRoomModal = true;
    }

    public function assignRoom()
    {
        $this->validate([
            'selectedRoomId' => 'nullable|exists:rooms,id',
        ]);
 
        $section = Section::find($this->selectedSectionId);
        $section->update([
            'room_id' => $this->selectedRoomId,
        ]);
 
        $this->showRoomModal = false;
        $this->reset(['selectedSectionId', 'selectedRoomId', 'currentSectionName', 'roomSearch']);
        session()->flash('message', 'Room assigned successfully!');
    }

    public function getRoomSearchResultsProperty()
    {
        $search = trim($this->roomSearch);
        return Room::with('building')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhereHas('building', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
            })
            ->limit(5)
            ->get();
    }

    public function getUnsectionedStatsProperty()
    {
        $query = Enrollment::where('status', 'Enrolled');

        if ($this->activeAutoTab === 'tvl') {
            $query->whereNull('tech_voc_section_id');
        } else {
            $query->whereNull('section_id');
        }

        if ($this->autoGrade && $this->autoGrade !== 'All') {
            $query->where('grade_level', $this->autoGrade);
        }

        if ($this->activeAutoTab === 'jhs') {
            // All JHS students (including TVL) need a normal section, so we don't exclude the TVL track here.
        } elseif ($this->activeAutoTab === 'tvl') {
            if ($this->autoCourseStrand && $this->autoCourseStrand !== 'All') {
                // Assuming specialization or strand represents the course in TVL
                $query->where(function($q) {
                    $q->where('specialization', $this->autoCourseStrand)
                      ->orWhere('strand', $this->autoCourseStrand);
                });
            }
        } elseif ($this->activeAutoTab === 'shs') {
            if ($this->autoCourseStrand && $this->autoCourseStrand !== 'All') {
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
            $gradesToProcess = ($this->autoGrade === 'All') 
                ? ($this->activeAutoTab === 'jhs' ? ['Grade 7', 'Grade 8', 'Grade 9', 'Grade 10'] : 
                  ($this->activeAutoTab === 'tvl' ? ['Grade 8', 'Grade 9', 'Grade 10'] : 
                  ['Grade 11', 'Grade 12']))
                : [$this->autoGrade];

            $totalAssigned = 0;
            $summaryMessages = [];

            foreach ($gradesToProcess as $grade) {
                if ($this->activeAutoTab === 'jhs') {
                    $result = $service->runJhsShsSectioning($grade);
                } elseif ($this->activeAutoTab === 'tvl') {
                    $course = ($this->autoCourseStrand === 'All' || empty($this->autoCourseStrand)) ? null : $this->autoCourseStrand;
                    $result = $service->runTechVocSectioning($grade, $course);
                } elseif ($this->activeAutoTab === 'shs') {
                    $strand = ($this->autoCourseStrand === 'All' || empty($this->autoCourseStrand)) ? null : $this->autoCourseStrand;
                    $result = $service->runJhsShsSectioning($grade, $strand);
                }
                
                if (isset($result['message'])) {
                    $summaryMessages[] = "{$grade}: {$result['message']}";
                }
            }
 
            session()->flash('message', 'Auto-sectioning completed. ' . count($summaryMessages) . ' grade levels processed.');
            $this->showAutoSectionModal = false;
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function deleteSection($sectionId)
    {
        $section = Section::findOrFail($sectionId);

        // Check if there are active enrollments in the section
        $hasEnrollments = $section->enrollments()->exists() || $section->techVocEnrollments()->exists();

        if ($hasEnrollments) {
            session()->flash('error', 'Cannot delete section because it has students assigned to it.');
            return;
        }

        // Delete associated schedules first
        $section->schedules()->delete();

        $section->delete();
        session()->flash('message', 'Section deleted successfully.');
    }
 
    public function render()
    {
        $query = Section::with(['adviser', 'room', 'enrollments', 'techVocEnrollments'])
            ->withCount(['enrollments', 'techVocEnrollments'])
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
            'totalSectionsCount' => Section::count(),
        ])->layout('layouts.app'); // Or pipeline if that's the base
    }
}
