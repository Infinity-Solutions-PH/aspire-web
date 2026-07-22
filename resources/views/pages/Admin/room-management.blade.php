@section('page-title', 'Room Management')

<div>
    <div class="space-y-8">
        
        <!-- Page Heading -->
        <div class="flex flex-wrap justify-between items-center gap-4 mb-8">
            <div class="flex items-center gap-4">
                <div class="size-16 rounded-2xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-3xl">door_open</span>
                </div>
                <div class="flex flex-col gap-1">
                    <h2 class="text-3xl font-black tracking-tight text-[#1b0d0d] dark:text-[#fcf8f8]">Room Management</h2>
                    <p class="text-[#9a4c4c] dark:text-[#c48d8d] text-base font-medium">Manage buildings, rooms, and their capacities across the campus.</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button wire:click="openCreateModal" class="flex items-center gap-2 px-6 py-2.5 bg-primary hover:bg-primary/90 text-white rounded-lg font-bold text-sm transition-all shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined text-lg">add_circle</span>
                    <span>Create Building & Rooms</span>
                </button>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <div class="pb-10 grid grid-cols-1 gap-6">
            @forelse ($buildings as $building)
                <div class="bg-white dark:bg-[#2c1818] rounded-xl border border-[#f3e7e7] dark:border-[#3d2525] p-6 shadow-sm">
                    <div class="flex justify-between items-center mb-6 border-b border-[#f3e7e7] dark:border-[#3d2525] pb-4">
                        <div>
                            <h2 class="text-2xl font-black">{{ $building->name }}</h2>
                            <p class="text-sm text-[#9a4c4c] mt-1">{{ $building->rooms->count() }} Room(s)</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button wire:click="openEditModal({{ $building->id }})" class="text-blue-500 hover:text-blue-700 flex items-center gap-1 text-sm font-bold bg-blue-50 dark:bg-blue-900/20 px-4 py-2 rounded-lg transition-colors">
                                <span class="material-symbols-outlined text-lg">edit</span>
                                Edit
                            </button>
                            <button wire:click="deleteBuilding({{ $building->id }})" wire:confirm="Are you sure you want to delete this building and all its rooms?" class="text-red-500 hover:text-red-700 flex items-center gap-1 text-sm font-bold bg-red-50 dark:bg-red-900/20 px-4 py-2 rounded-lg transition-colors">
                                <span class="material-symbols-outlined text-lg">delete</span>
                                Delete
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                        @foreach ($building->rooms as $room)
                            <div wire:click="openRoomDetails({{ $room->id }})" class="border border-[#f3e7e7] dark:border-[#3d2525] rounded-xl p-4 hover:shadow-md transition-all bg-gray-50 dark:bg-gray-800/30 cursor-pointer hover:border-primary/50 relative group">
                                <div class="absolute inset-0 bg-primary/5 opacity-0 group-hover:opacity-100 rounded-xl transition-opacity"></div>
                                <div class="relative z-10">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                                            <span class="material-symbols-outlined">meeting_room</span>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-lg">{{ $room->name }}</h3>
                                            <p class="text-xs text-[#9a4c4c] capitalize">{{ $room->type }} • {{ $room->floor }}</p>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center text-sm border-t border-[#f3e7e7] dark:border-[#3d2525] pt-3 mt-3">
                                        <span class="text-[#9a4c4c]">Capacity / Sections</span>
                                        <span class="font-bold">
                                            {{ $room->capacity ?? 'N/A' }} / 
                                            <span class="text-primary">{{ $room->sections_count ?? 0 }}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-[#2c1818] rounded-xl border border-[#f3e7e7] dark:border-[#3d2525] p-12 text-center">
                    <span class="material-symbols-outlined text-6xl text-[#9a4c4c] mb-4">domain</span>
                    <h3 class="text-xl font-bold mb-2">No Buildings Found</h3>
                    <p class="text-[#9a4c4c]">Click the button above to create your first building and its rooms.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Create Building & Rooms Modal -->
    @if($showCreateModal)
        <div class="fixed inset-0 lg:left-64 z-40 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="absolute inset-0 -z-10 transition-opacity bg-black/60 backdrop-blur-sm" wire:click="closeCreateModal"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div class="inline-block w-full max-w-4xl overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-[#2a1515] rounded-3xl shadow-2xl relative z-10">
                    <div class="px-8 py-6 border-b border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center justify-between bg-primary/5 shrink-0">
                        <div>
                            <h3 class="text-xl font-black text-primary uppercase tracking-tight">
                                {{ $isEditMode ? 'Edit Building & Rooms' : 'Create Building & Rooms' }}
                            </h3>
                            <p class="text-xs text-[#9a4c4c] dark:text-white/60 mt-1">{{ $isEditMode ? 'Update building details and manage its rooms.' : 'Add a new building and generate its rooms simultaneously.' }}</p>
                        </div>
                        <button wire:click="closeCreateModal" class="text-gray-400 hover:text-primary transition-colors">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                    
                    <form wire:submit.prevent="save" class="flex flex-col flex-1 overflow-hidden">
                        <div class="p-8 overflow-y-auto space-y-6 flex-1">
                            <!-- Building Info -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50/50 dark:bg-black/20 p-6 rounded-2xl border border-[#f3e7e7] dark:border-[#3d2525]">
                                <div>
                                    <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Building Name <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model.defer="building_name" class="w-full px-4 py-3 mt-1 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary" placeholder="e.g. Maliksi Building" required>
                                    @error('building_name') <span class="text-[10px] text-red-500 font-bold uppercase mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Number of Rooms <span class="text-red-500">*</span></label>
                                    <input type="number" wire:model.live.debounce.500ms="number_of_rooms" min="1" max="20" class="w-full px-4 py-3 mt-1 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary" required>
                                    @error('number_of_rooms') <span class="text-[10px] text-red-500 font-bold uppercase mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Rooms List -->
                            <div>
                                <h4 class="text-[10px] font-black uppercase tracking-widest text-gray-500 mb-4 border-b border-[#f3e7e7] dark:border-[#3a1f1f] pb-2">Room Details</h4>
                                <div class="space-y-4">
                                    @for($i = 0; $i < $number_of_rooms; $i++)
                                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end bg-[#fdfafb] dark:bg-[#3d2424] p-4 rounded-xl border border-[#f3e7e7] dark:border-[#4d3232]">
                                            <div class="md:col-span-1 flex justify-center items-center h-12">
                                                <span class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-xs">{{ $i + 1 }}</span>
                                            </div>
                                            <div class="md:col-span-3">
                                                <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Room Name <span class="text-red-500">*</span></label>
                                                <input type="text" wire:model.defer="rooms.{{ $i }}.name" class="w-full px-3 py-2 mt-1 bg-white dark:bg-[#2a1515] border-[#f3e7e7] dark:border-[#3a1f1f] rounded-lg text-sm focus:ring-primary focus:border-primary" placeholder="e.g. Maliksi 101" required>
                                                @error('rooms.'.$i.'.name') <span class="text-[10px] text-red-500 font-bold uppercase mt-1 block">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="md:col-span-3">
                                                <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Type <span class="text-red-500">*</span></label>
                                                <select wire:model.defer="rooms.{{ $i }}.type" class="w-full px-3 py-2 mt-1 bg-white dark:bg-[#2a1515] border-[#f3e7e7] dark:border-[#3a1f1f] rounded-lg text-sm focus:ring-primary focus:border-primary">
                                                    <option value="lecture">Lecture</option>
                                                    <option value="lab">Lab</option>
                                                </select>
                                                @error('rooms.'.$i.'.type') <span class="text-[10px] text-red-500 font-bold uppercase mt-1 block">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="md:col-span-2">
                                                <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Capacity</label>
                                                <input type="number" wire:model.defer="rooms.{{ $i }}.capacity" class="w-full px-3 py-2 mt-1 bg-white dark:bg-[#2a1515] border-[#f3e7e7] dark:border-[#3a1f1f] rounded-lg text-sm focus:ring-primary focus:border-primary">
                                                @error('rooms.'.$i.'.capacity') <span class="text-[10px] text-red-500 font-bold uppercase mt-1 block">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="md:col-span-3">
                                                <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Floor</label>
                                                <select wire:model.defer="rooms.{{ $i }}.floor" class="w-full px-3 py-2 mt-1 bg-white dark:bg-[#2a1515] border-[#f3e7e7] dark:border-[#3a1f1f] rounded-lg text-sm focus:ring-primary focus:border-primary">
                                                    <option value="1st floor">1st floor</option>
                                                    <option value="2nd floor">2nd floor</option>
                                                    <option value="3rd floor">3rd floor</option>
                                                    <option value="4th floor">4th floor</option>
                                                    <option value="5th floor">5th floor</option>
                                                    <option value="Ground floor">Ground floor</option>
                                                    <option value="Basement">Basement</option>
                                                </select>
                                                @error('rooms.'.$i.'.floor') <span class="text-[10px] text-red-500 font-bold uppercase mt-1 block">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-end gap-3 px-8 py-6 border-t border-[#f3e7e7] dark:border-[#3a1f1f] shrink-0">
                            <button type="button" wire:click="closeCreateModal" class="px-6 py-2.5 text-sm font-bold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-primary hover:bg-primary/90 rounded-xl shadow-lg shadow-primary/30 transition-all flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">save</span>
                                {{ $isEditMode ? 'Save Changes' : 'Save Building & Rooms' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Room Details Modal -->
    @if($showRoomDetailsModal && $selectedRoom)
        <div class="fixed inset-0 lg:left-64 z-40 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="absolute inset-0 -z-10 transition-opacity bg-black/60 backdrop-blur-sm" wire:click="closeRoomDetails"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div class="inline-block w-full max-w-4xl overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-[#2a1515] rounded-3xl shadow-2xl relative z-10">
                    <div class="px-8 py-6 border-b border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center justify-between bg-primary/5 shrink-0">
                        <div>
                            <h3 class="text-xl font-black text-primary uppercase tracking-tight">
                                {{ $selectedRoom->name }} Details
                            </h3>
                            <p class="text-xs text-[#9a4c4c] dark:text-white/60 mt-1 capitalize">{{ $selectedRoom->type }} • {{ $selectedRoom->floor }} • Capacity: {{ $selectedRoom->capacity ?? 'N/A' }}</p>
                        </div>
                        <button wire:click="closeRoomDetails" class="text-gray-400 hover:text-primary transition-colors">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                    
                    <div class="p-8">
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c] mb-4">Assigned Sections</h4>
                        @if($selectedRoom->sections->count() > 0)
                            <div class="overflow-x-auto rounded-2xl border border-[#f3e7e7] dark:border-[#3a1f1f]">
                                <table class="w-full text-left text-sm text-[#1b0d0d] dark:text-white">
                                    <thead class="bg-[#fdfafb] dark:bg-[#3d2424] text-[#9a4c4c] font-black uppercase tracking-widest text-[10px]">
                                        <tr>
                                            <th scope="col" class="px-6 py-4">Section Name</th>
                                            <th scope="col" class="px-6 py-4">Adviser</th>
                                            <th scope="col" class="px-6 py-4 text-center">No. of Students</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-[#f3e7e7] dark:divide-[#3a1f1f]">
                                        @foreach($selectedRoom->sections as $section)
                                            @php
                                                $studentCount = (!empty($section->specialization) && in_array($section->grade_level, ['Grade 8', 'Grade 9', 'Grade 10'])) 
                                                    ? $section->tech_voc_enrollments_count 
                                                    : $section->enrollments_count;
                                            @endphp
                                            <tr class="hover:bg-gray-50/50 dark:hover:bg-white/5 transition-colors">
                                                <td class="px-6 py-4 font-bold">
                                                    {{ $section->name }} 
                                                    <span class="text-[10px] text-[#9a4c4c] block font-black uppercase tracking-widest">{{ $section->grade_level }}</span>
                                                </td>
                                                <td class="px-6 py-4 text-sm font-medium">{{ $section->adviser ? $section->adviser->name : 'No Adviser' }}</td>
                                                <td class="px-6 py-4 text-center">
                                                    <span class="inline-flex items-center justify-center min-w-[2rem] bg-primary/10 text-primary px-2.5 py-1 rounded-lg font-black text-xs">
                                                        {{ $studentCount }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="bg-gray-50/50 dark:bg-black/20 rounded-2xl border border-[#f3e7e7] dark:border-[#3a1f1f] p-12 text-center">
                                <span class="material-symbols-outlined text-4xl text-gray-300 dark:text-gray-600 mb-2">inbox</span>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-1">No Sections Assigned</h3>
                                <p class="text-xs text-gray-500">There are no sections assigned to this room yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
