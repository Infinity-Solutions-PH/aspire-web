<?php

namespace App\Livewire\Admin;

use App\Models\Room;
use App\Models\Building;
use Livewire\Component;

class RoomManagement extends Component
{
    public $buildings;
    
    // Create form fields
    public $building_name = '';
    public $number_of_rooms = 1;
    public $rooms = [];
    
    public $showCreateModal = false;

    // Edit state
    public $editingBuildingId = null;
    public $isEditMode = false;

    // Room Details state
    public $showRoomDetailsModal = false;
    public $selectedRoom = null;

    public function openRoomDetails($roomId)
    {
        $this->selectedRoom = Room::with([
            'sections.adviser',
            'sections' => function($q) {
                $q->withCount(['enrollments', 'techVocEnrollments']);
            }
        ])->findOrFail($roomId);
        
        $this->showRoomDetailsModal = true;
    }

    public function closeRoomDetails()
    {
        $this->showRoomDetailsModal = false;
        $this->selectedRoom = null;
    }

    public function mount()
    {
        $this->loadBuildings();
        $this->initializeRooms();
    }

    private function loadBuildings()
    {
        $this->buildings = Building::with(['rooms' => function ($query) {
            $query->withCount('sections');
        }])->get();
    }

    public function updatedNumberOfRooms()
    {
        // Enforce max 20 rooms for safety
        if ($this->number_of_rooms > 20) {
            $this->number_of_rooms = 20;
        }
        if ($this->number_of_rooms < 1) {
            $this->number_of_rooms = 1;
        }
        
        $this->initializeRooms();
    }

    private function initializeRooms()
    {
        $currentRooms = $this->rooms;
        $this->rooms = [];
        
        for ($i = 0; $i < $this->number_of_rooms; $i++) {
            $this->rooms[] = [
                'id' => $currentRooms[$i]['id'] ?? null,
                'name' => $currentRooms[$i]['name'] ?? '',
                'type' => $currentRooms[$i]['type'] ?? 'lecture',
                'capacity' => $currentRooms[$i]['capacity'] ?? 40,
                'floor' => $currentRooms[$i]['floor'] ?? '1st floor',
            ];
        }
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function openEditModal($buildingId)
    {
        $this->resetForm();
        
        $building = Building::with('rooms')->findOrFail($buildingId);
        
        $this->isEditMode = true;
        $this->editingBuildingId = $building->id;
        $this->building_name = $building->name;
        $this->number_of_rooms = $building->rooms->count() ?: 1;
        
        $this->rooms = [];
        foreach ($building->rooms as $room) {
            $this->rooms[] = [
                'id' => $room->id,
                'name' => $room->name,
                'type' => $room->type,
                'capacity' => $room->capacity,
                'floor' => $room->floor,
            ];
        }

        // Fill remaining if number_of_rooms > count
        $this->initializeRooms();
        
        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->isEditMode = false;
        $this->editingBuildingId = null;
        $this->building_name = '';
        $this->number_of_rooms = 1;
        $this->rooms = []; // Reset rooms array so initializeRooms creates fresh ones
        $this->initializeRooms();
        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate([
            'building_name' => 'required|string|max:255',
            'number_of_rooms' => 'required|integer|min:1|max:20',
            'rooms.*.name' => 'required|string|max:255',
            'rooms.*.type' => 'required|string',
            'rooms.*.capacity' => 'nullable|integer|min:1',
            'rooms.*.floor' => 'required|string',
        ], [
            'rooms.*.name.required' => 'Room name is required.',
        ]);

        if ($this->isEditMode) {
            $building = Building::findOrFail($this->editingBuildingId);
            $building->update([
                'name' => $this->building_name,
            ]);

            $existingRoomIds = $building->rooms->pluck('id')->toArray();
            $submittedRoomIds = collect($this->rooms)->pluck('id')->filter()->toArray();

            // Delete rooms that were removed
            $roomsToDelete = array_diff($existingRoomIds, $submittedRoomIds);
            if (!empty($roomsToDelete)) {
                Room::whereIn('id', $roomsToDelete)->delete();
            }

            // Update or create rooms
            foreach ($this->rooms as $roomData) {
                if (!empty($roomData['id'])) {
                    Room::where('id', $roomData['id'])->update([
                        'name' => $roomData['name'],
                        'type' => $roomData['type'],
                        'capacity' => empty($roomData['capacity']) ? null : $roomData['capacity'],
                        'floor' => $roomData['floor'],
                    ]);
                } else {
                    Room::create([
                        'building_id' => $building->id,
                        'name' => $roomData['name'],
                        'type' => $roomData['type'],
                        'capacity' => empty($roomData['capacity']) ? null : $roomData['capacity'],
                        'floor' => $roomData['floor'],
                    ]);
                }
            }

            session()->flash('message', 'Building and rooms updated successfully!');
        } else {
            $building = Building::create([
                'name' => $this->building_name,
            ]);

            foreach ($this->rooms as $roomData) {
                Room::create([
                    'building_id' => $building->id,
                    'name' => $roomData['name'],
                    'type' => $roomData['type'],
                    'capacity' => empty($roomData['capacity']) ? null : $roomData['capacity'],
                    'floor' => $roomData['floor'],
                ]);
            }

            session()->flash('message', 'Building and rooms created successfully!');
        }

        $this->closeCreateModal();
        $this->loadBuildings();
    }

    public function deleteBuilding($id)
    {
        $building = Building::findOrFail($id);
        $building->delete();
        
        session()->flash('message', 'Building and its rooms deleted successfully.');
        $this->loadBuildings();
    }

    public function render()
    {
        $this->loadBuildings();
        return view('pages.Admin.room-management')->layout('layouts.app');
    }
}
