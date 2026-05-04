<?php

namespace App\Livewire\Admin;

use App\Models\SchoolYear;
use Livewire\Component;
use Livewire\WithPagination;

class SchoolYearManagement extends Component
{
    use WithPagination;

    public $showModal = false;
    public $isEdit = false;
    public $schoolYearId;

    public $form = [
        'name' => '',
        'status' => 'Upcoming',
        'enrollment_start' => '',
        'enrollment_end' => '',
        'classes_start' => '',
    ];

    public function openModal($isEdit = false, $id = null)
    {
        $this->resetValidation();
        $this->isEdit = $isEdit;
        $this->schoolYearId = $id;

        if ($isEdit && $id) {
            $sy = SchoolYear::find($id);
            $this->form = [
                'name' => $sy->name,
                'status' => $sy->status,
                'enrollment_start' => $sy->enrollment_start ? $sy->enrollment_start->format('Y-m-d') : '',
                'enrollment_end' => $sy->enrollment_end ? $sy->enrollment_end->format('Y-m-d') : '',
                'classes_start' => $sy->classes_start ? $sy->classes_start->format('Y-m-d') : '',
            ];
        } else {
            $this->form = [
                'name' => '',
                'status' => 'Upcoming',
                'enrollment_start' => '',
                'enrollment_end' => '',
                'classes_start' => '',
            ];
        }

        $this->showModal = true;
    }

    public function save()
    {
        $nameRule = $this->isEdit 
            ? 'required|string|max:255|unique:school_years,name,' . $this->schoolYearId
            : 'required|string|max:255|unique:school_years,name';

        $this->validate([
            'form.name' => $nameRule,
            'form.status' => 'required|in:Upcoming,Active,Closed',
            'form.enrollment_start' => 'nullable|date',
            'form.enrollment_end' => 'nullable|date|after_or_equal:form.enrollment_start',
            'form.classes_start' => 'nullable|date',
        ], [
            'form.name.required' => 'The school year name is required.',
            'form.name.unique' => 'This school year already exists.',
            'form.enrollment_end.after_or_equal' => 'The end date must be after or equal to the start date.',
        ]);

        if ($this->form['status'] === 'Active') {
            // Only one active school year allowed
            SchoolYear::where('status', 'Active')->update(['status' => 'Closed']);
        }

        $dataToSave = [
            'name' => $this->form['name'],
            'status' => $this->form['status'],
            'enrollment_start' => empty($this->form['enrollment_start']) ? null : $this->form['enrollment_start'],
            'enrollment_end' => empty($this->form['enrollment_end']) ? null : $this->form['enrollment_end'],
            'classes_start' => empty($this->form['classes_start']) ? null : $this->form['classes_start'],
        ];

        if ($this->isEdit) {
            SchoolYear::find($this->schoolYearId)->update($dataToSave);
            session()->flash('message', 'School Year updated successfully.');
        } else {
            SchoolYear::create($dataToSave);
            session()->flash('message', 'School Year created successfully.');
        }

        $this->showModal = false;
    }

    public function render()
    {
        $totalRecords = SchoolYear::count();
        $activeYear = SchoolYear::where('status', 'Active')->first();
        $nextUpcoming = SchoolYear::where('status', 'Upcoming')->orderBy('enrollment_start', 'asc')->first();

        $schoolYears = SchoolYear::orderBy('name', 'desc')->paginate(10);

        return view('pages.Admin.school-year-management', [
            'schoolYears' => $schoolYears,
            'totalRecords' => $totalRecords,
            'activeYear' => $activeYear,
            'nextUpcoming' => $nextUpcoming,
        ])->layout('layouts.app');
    }
}
