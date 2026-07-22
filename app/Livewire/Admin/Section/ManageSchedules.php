<?php

namespace App\Livewire\Admin\Section;

use App\Models\Room;
use App\Models\User;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Schedule;
use App\Models\ScheduleTemplate;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;

class ManageSchedules extends Component
{
    public Section $section;

    // Form state
    public $subject_id = '';
    public $teacher_id = '';
    public $room_id = '';
    public $day = 'Monday';
    public $start_time = '';
    public $end_time = '';

    // Template properties
    public $showTemplateModal = false;
    public $selectedTemplateId = '';

    // Assigning Teacher/Room to Incomplete Slot
    public $showAssignModal = false;
    public $assigningScheduleId = null;
    public $assignTeacherId = '';
    public $assignRoomId = '';

    public function mount(Section $section)
    {
        $this->section = $section->load('schedules.subject', 'schedules.teacher', 'schedules.room');
    }

    protected function rules()
    {
        return [
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'day' => ['required', Rule::in(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'])],
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ];
    }

    public function addSchedule()
    {
        $this->validate();

        // Application-level overlap checks to complement database constraints
        $hasTeacherOverlap = Schedule::where('teacher_id', $this->teacher_id)
            ->where('day', $this->day)
            ->where(function ($q) {
                $q->whereBetween('start_time', [$this->start_time, $this->end_time])
                  ->orWhereBetween('end_time', [$this->start_time, $this->end_time])
                  ->orWhere(function ($q2) {
                      $q2->where('start_time', '<=', $this->start_time)
                         ->where('end_time', '>=', $this->end_time);
                  });
            })->exists();

        if ($hasTeacherOverlap) {
            $this->addError('teacher_id', 'This teacher is already booked during this time slot.');
            return;
        }

        $hasRoomOverlap = Schedule::where('room_id', $this->room_id)
            ->where('day', $this->day)
            ->where(function ($q) {
                $q->whereBetween('start_time', [$this->start_time, $this->end_time])
                  ->orWhereBetween('end_time', [$this->start_time, $this->end_time])
                  ->orWhere(function ($q2) {
                      $q2->where('start_time', '<=', $this->start_time)
                         ->where('end_time', '>=', $this->end_time);
                  });
            })->exists();

        if ($hasRoomOverlap) {
            $this->addError('room_id', 'This room is already booked during this time slot.');
            return;
        }

        $hasSectionOverlap = Schedule::where('section_id', $this->section->id)
            ->where('day', $this->day)
            ->where(function ($q) {
                $q->whereBetween('start_time', [$this->start_time, $this->end_time])
                  ->orWhereBetween('end_time', [$this->start_time, $this->end_time])
                  ->orWhere(function ($q2) {
                      $q2->where('start_time', '<=', $this->start_time)
                         ->where('end_time', '>=', $this->end_time);
                  });
            })->exists();

        if ($hasSectionOverlap) {
            $this->addError('start_time', 'This section already has a class scheduled during this time slot.');
            return;
        }

        try {
            $this->section->schedules()->create([
                'subject_id' => $this->subject_id,
                'teacher_id' => $this->teacher_id,
                'room_id' => $this->room_id,
                'day' => $this->day,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
            ]);

            session()->flash('message', 'Schedule successfully added.');
            $this->reset(['subject_id', 'teacher_id', 'room_id', 'start_time', 'end_time']);
            $this->section->load('schedules.subject', 'schedules.teacher', 'schedules.room');
        } catch (QueryException $e) {
            // Catching unique constraint violations just in case race conditions happen
            if ($e->getCode() === '23000') {
                session()->flash('error', 'A scheduling conflict was detected at the database level. Please check the time slots.');
            } else {
                session()->flash('error', 'An error occurred while saving the schedule.');
            }
        }
    }

    public function deleteSchedule($id)
    {
        Schedule::where('id', $id)->where('section_id', $this->section->id)->delete();
        session()->flash('message', 'Schedule successfully removed.');
        $this->section->load('schedules.subject', 'schedules.teacher', 'schedules.room');
    }

    public function applyTemplate()
    {
        $this->validate([
            'selectedTemplateId' => 'required|exists:schedule_templates,id',
        ]);

        $template = ScheduleTemplate::with('slots')->findOrFail($this->selectedTemplateId);

        foreach ($template->slots as $slot) {
            $this->section->schedules()->create([
                'subject_id' => $slot->subject_id,
                'day' => $slot->day,
                'start_time' => $slot->start_time,
                'end_time' => $slot->end_time,
                'teacher_id' => null,
                'room_id' => null,
            ]);
        }

        session()->flash('message', 'Template successfully applied. Please assign teachers and rooms for the empty slots.');
        $this->showTemplateModal = false;
        $this->selectedTemplateId = '';
        $this->section->load('schedules.subject', 'schedules.teacher', 'schedules.room');
    }

    public function openAssignModal($id)
    {
        $this->assigningScheduleId = $id;
        $schedule = Schedule::findOrFail($id);
        $this->assignTeacherId = $schedule->teacher_id;
        $this->assignRoomId = $schedule->room_id;
        $this->showAssignModal = true;
    }

    public function saveAssignment()
    {
        $this->validate([
            'assignTeacherId' => 'required|exists:users,id',
            'assignRoomId' => 'required|exists:rooms,id',
        ]);

        $schedule = Schedule::findOrFail($this->assigningScheduleId);

        // Conflict checking for the specific slot
        $hasTeacherOverlap = Schedule::where('teacher_id', $this->assignTeacherId)
            ->where('id', '!=', $schedule->id)
            ->where('day', $schedule->day)
            ->where(function ($q) use ($schedule) {
                $q->whereBetween('start_time', [$schedule->start_time, $schedule->end_time])
                  ->orWhereBetween('end_time', [$schedule->start_time, $schedule->end_time])
                  ->orWhere(function ($q2) use ($schedule) {
                      $q2->where('start_time', '<=', $schedule->start_time)
                         ->where('end_time', '>=', $schedule->end_time);
                  });
            })->exists();

        if ($hasTeacherOverlap) {
            $this->addError('assignTeacherId', 'This teacher is already booked during this time slot.');
            return;
        }

        $hasRoomOverlap = Schedule::where('room_id', $this->assignRoomId)
            ->where('id', '!=', $schedule->id)
            ->where('day', $schedule->day)
            ->where(function ($q) use ($schedule) {
                $q->whereBetween('start_time', [$schedule->start_time, $schedule->end_time])
                  ->orWhereBetween('end_time', [$schedule->start_time, $schedule->end_time])
                  ->orWhere(function ($q2) use ($schedule) {
                      $q2->where('start_time', '<=', $schedule->start_time)
                         ->where('end_time', '>=', $schedule->end_time);
                  });
            })->exists();

        if ($hasRoomOverlap) {
            $this->addError('assignRoomId', 'This room is already booked during this time slot.');
            return;
        }

        $schedule->update([
            'teacher_id' => $this->assignTeacherId,
            'room_id' => $this->assignRoomId,
        ]);

        session()->flash('message', 'Assignment saved successfully.');
        $this->showAssignModal = false;
        $this->section->load('schedules.subject', 'schedules.teacher', 'schedules.room');
    }

    public function render()
    {
        $subjects = Subject::orderBy('name')->get();
        // Assuming faculty role is identified by a scope or specific relationship. Using basic all() for now, replace with proper faculty scope if exists.
        $teachers = User::whereHas('roles', function($q) { $q->where('name', 'faculty'); })->orderBy('name')->get();
        $rooms = Room::orderBy('name')->get();

        $templates = ScheduleTemplate::where('grade_level', $this->section->grade_level)->get();

        return view('livewire.admin.section.manage-schedules', [
            'subjects' => $subjects,
            'teachers' => $teachers,
            'rooms' => $rooms,
            'templates' => $templates,
        ]);
    }
}
