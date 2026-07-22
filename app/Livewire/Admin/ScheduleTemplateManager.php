<?php

namespace App\Livewire\Admin;

use App\Models\Subject;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ScheduleTemplate;
use App\Models\ScheduleTemplateSlot;

class ScheduleTemplateManager extends Component
{
    use WithPagination;

    public $search = '';
    public $activeGradeLevel = 'All';

    // Template Modal
    public $showTemplateModal = false;
    public $templateId = null;
    public $name = '';
    public $grade_level = 'Grade 7';
    public $type = 'Normal';

    // Slots Modal
    public $showSlotsModal = false;
    public $managingTemplate = null;
    
    // Slot Form
    public $subject_id = '';
    public $day = 'Monday';
    public $start_time = '';
    public $end_time = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingActiveGradeLevel()
    {
        $this->resetPage();
    }

    public function openTemplateModal($id = null)
    {
        $this->resetValidation();
        $this->reset(['name', 'grade_level', 'type']);
        $this->templateId = $id;

        if ($id) {
            $template = ScheduleTemplate::findOrFail($id);
            $this->name = $template->name;
            $this->grade_level = $template->grade_level;
            $this->type = $template->type;
        }

        $this->showTemplateModal = true;
    }

    public function saveTemplate()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'grade_level' => 'required|string',
            'type' => 'required|in:Normal,TechVoc',
        ]);

        if ($this->templateId) {
            $template = ScheduleTemplate::findOrFail($this->templateId);
            $template->update([
                'name' => $this->name,
                'grade_level' => $this->grade_level,
                'type' => $this->type,
            ]);
            session()->flash('message', 'Template updated successfully.');
        } else {
            ScheduleTemplate::create([
                'name' => $this->name,
                'grade_level' => $this->grade_level,
                'type' => $this->type,
            ]);
            session()->flash('message', 'Template created successfully.');
        }

        $this->showTemplateModal = false;
    }

    public function deleteTemplate($id)
    {
        ScheduleTemplate::findOrFail($id)->delete();
        session()->flash('message', 'Template deleted successfully.');
    }

    public function manageSlots($id)
    {
        $this->managingTemplate = ScheduleTemplate::with('slots.subject')->findOrFail($id);
        $this->showSlotsModal = true;
    }

    public function addSlot()
    {
        $this->validate([
            'subject_id' => 'required|exists:subjects,id',
            'day' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $this->managingTemplate->slots()->create([
            'subject_id' => $this->subject_id,
            'day' => $this->day,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ]);

        $this->managingTemplate->load('slots.subject');
        $this->reset(['subject_id', 'start_time', 'end_time']);
    }

    public function deleteSlot($slotId)
    {
        ScheduleTemplateSlot::findOrFail($slotId)->delete();
        $this->managingTemplate->load('slots.subject');
    }

    public function render()
    {
        $templates = ScheduleTemplate::withCount('slots')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->activeGradeLevel !== 'All', function ($query) {
                $query->where('grade_level', $this->activeGradeLevel);
            })
            ->latest()
            ->paginate(10);

        $subjectsQuery = Subject::orderBy('name');
        if ($this->managingTemplate) {
            if ($this->managingTemplate->type === 'Normal') {
                $subjectsQuery->where('is_tech_voc', false);
            } elseif ($this->managingTemplate->type === 'TechVoc') {
                $subjectsQuery->where('is_tech_voc', true);
            }
        }
        $subjects = $subjectsQuery->get();

        return view('livewire.admin.schedule-template-manager', [
            'templates' => $templates,
            'subjects' => $subjects,
        ])->layout('layouts.app');
    }
}
