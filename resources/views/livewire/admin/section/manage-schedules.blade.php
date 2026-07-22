@section('page-title', 'Manage Schedules - ' . $section->name)

<main class="flex-1 px-10 py-8 max-w-[1400px] mx-auto w-full" x-data="{ showTemplateModal: @entangle('showTemplateModal'), showAssignModal: @entangle('showAssignModal') }">
    <!-- Breadcrumbs & Back Link -->
    <div class="flex items-center gap-2 mb-6">
        <a href="{{ route('admin.sections') }}" class="flex items-center gap-1 text-[#9a4c4c] hover:text-primary transition-colors text-sm font-bold">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            Back to Sections
        </a>
    </div>

    <!-- Section Header Information -->
    <div class="flex flex-wrap justify-between items-center gap-4 mb-8">
        <div class="flex items-center gap-4">
            <div class="size-16 rounded-2xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-3xl">calendar_clock</span>
            </div>
            <div class="flex flex-col gap-1">
                <h2 class="text-3xl font-black tracking-tight text-[#1b0d0d] dark:text-[#fcf8f8]">Schedules - {{ $section->name }}</h2>
                <div class="flex flex-wrap items-center gap-2 mt-1">
                    <span class="px-2 py-0.5 bg-primary/10 text-primary text-[10px] font-black uppercase rounded-lg tracking-widest">{{ $section->grade_level }}</span>
                    @if($section->strand)
                        <span class="px-2 py-0.5 bg-gray-100 dark:bg-[#1a0c0c] border border-[#e7cfcf] dark:border-[#422020] text-[#9a4c4c] dark:text-[#c48d8d] text-[10px] font-black uppercase rounded-lg tracking-widest">{{ $section->strand }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.sections.students', $section->id) }}" class="flex items-center gap-2 px-6 py-2.5 bg-white hover:bg-gray-50 dark:bg-[#1a0c0c] dark:hover:bg-[#2a1515] text-[#9a4c4c] border border-[#e7cfcf] dark:border-[#422020] rounded-lg font-bold text-sm transition-all shadow-sm">
                <span class="material-symbols-outlined text-lg">groups</span>
                <span>Manage Students</span>
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 5000)"
             class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-6 py-4 rounded-xl flex items-center justify-between shadow-sm">
            <span class="text-sm font-bold uppercase tracking-wide flex items-center gap-2">
                <span class="material-symbols-outlined">check_circle</span>
                {{ session('message') }}
            </span>
            <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
    @endif
    
    @if (session()->has('error'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 8000)"
             class="mb-6 bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl flex items-center justify-between shadow-sm">
            <span class="text-sm font-bold tracking-wide flex items-center gap-2">
                <span class="material-symbols-outlined">error</span>
                {{ session('error') }}
            </span>
            <button @click="show = false" class="text-red-500 hover:text-red-700 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Add Schedule Form -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-[#2a1515] rounded-[24px] border border-[#f3e7e7] dark:border-[#3a1f1f] p-6 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-black text-[#1b0d0d] dark:text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">add_circle</span>
                        Assign Schedule
                    </h2>
                    <button type="button" wire:click="$set('showTemplateModal', true)" class="text-[10px] bg-primary/10 text-primary font-black uppercase tracking-widest px-3 py-1.5 rounded-lg hover:bg-primary hover:text-white transition-colors flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">file_copy</span>
                        Apply Template
                    </button>
                </div>

                <form wire:submit.prevent="addSchedule" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-widest mb-1.5">Subject</label>
                        <select wire:model="subject_id" class="w-full bg-[#fdfafb] dark:bg-[#361a1a] border border-[#f3e7e7] dark:border-[#4d3232] rounded-xl px-4 py-2.5 text-sm font-semibold focus:ring-primary focus:border-primary transition-all">
                            <option value="">Select a Subject</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                        @error('subject_id') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-widest mb-1.5">Teacher</label>
                        <select wire:model="teacher_id" class="w-full bg-[#fdfafb] dark:bg-[#361a1a] border border-[#f3e7e7] dark:border-[#4d3232] rounded-xl px-4 py-2.5 text-sm font-semibold focus:ring-primary focus:border-primary transition-all">
                            <option value="">Select a Teacher</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                        @error('teacher_id') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-widest mb-1.5">Room</label>
                        <select wire:model="room_id" class="w-full bg-[#fdfafb] dark:bg-[#361a1a] border border-[#f3e7e7] dark:border-[#4d3232] rounded-xl px-4 py-2.5 text-sm font-semibold focus:ring-primary focus:border-primary transition-all">
                            <option value="">Select a Room</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->name }}</option>
                            @endforeach
                        </select>
                        @error('room_id') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-widest mb-1.5">Day</label>
                        <select wire:model="day" class="w-full bg-[#fdfafb] dark:bg-[#361a1a] border border-[#f3e7e7] dark:border-[#4d3232] rounded-xl px-4 py-2.5 text-sm font-semibold focus:ring-primary focus:border-primary transition-all">
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select>
                        @error('day') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-widest mb-1.5">Start Time</label>
                            <input wire:model="start_time" type="time" class="w-full bg-[#fdfafb] dark:bg-[#361a1a] border border-[#f3e7e7] dark:border-[#4d3232] rounded-xl px-4 py-2.5 text-sm font-semibold focus:ring-primary focus:border-primary transition-all">
                            @error('start_time') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-widest mb-1.5">End Time</label>
                            <input wire:model="end_time" type="time" class="w-full bg-[#fdfafb] dark:bg-[#361a1a] border border-[#f3e7e7] dark:border-[#4d3232] rounded-xl px-4 py-2.5 text-sm font-semibold focus:ring-primary focus:border-primary transition-all">
                            @error('end_time') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 dark:border-[#4d3232] mt-6">
                        <button type="submit" class="w-full bg-primary text-white font-black text-sm uppercase tracking-widest py-3 rounded-xl hover:bg-primary/90 transition-all shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-lg">save</span>
                            Save Schedule
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Timetable View -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-[#2a1515] rounded-[24px] border border-[#f3e7e7] dark:border-[#3a1f1f] shadow-sm overflow-hidden">
                <div class="p-6 border-b border-[#f3e7e7] dark:border-[#3a1f1f] flex justify-between items-center">
                    <h2 class="text-xl font-black text-[#1b0d0d] dark:text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">view_timeline</span>
                        Current Timetable
                    </h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-[#fdfafb] dark:bg-[#361a1a] border-b border-[#f3e7e7] dark:border-[#3a1f1f]">
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Subject</th>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Day & Time</th>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Teacher</th>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Room</th>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c] text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#f3e7e7] dark:divide-[#3a1f1f]">
                            @forelse($section->schedules->sortBy(['day', 'start_time']) as $schedule)
                                <tr class="hover:bg-primary/[0.01] dark:hover:bg-white/[0.01] transition-colors group">
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-bold text-[#1b0d0d] dark:text-white">{{ $schedule->subject->name }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-[#1b0d0d] dark:text-white">{{ $schedule->day }}</span>
                                            <span class="text-[10px] text-gray-500 font-semibold tracking-wider">
                                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }} - 
                                                {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($schedule->teacher_id)
                                            <span class="text-sm font-bold text-[#1b0d0d] dark:text-white">{{ $schedule->teacher->name }}</span>
                                        @else
                                            <span class="text-[10px] font-black uppercase tracking-widest text-red-500 bg-red-50 px-2 py-1 rounded">Needs Teacher</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($schedule->room_id)
                                            <span class="text-xs font-semibold text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-white/5 px-2.5 py-1 rounded border border-gray-200 dark:border-white/10">
                                                {{ $schedule->room->name }}
                                            </span>
                                        @else
                                            <span class="text-[10px] font-black uppercase tracking-widest text-red-500 bg-red-50 px-2 py-1 rounded border border-red-100">Needs Room</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-1">
                                            @if(!$schedule->teacher_id || !$schedule->room_id)
                                                <button wire:click="openAssignModal({{ $schedule->id }})" class="p-2 text-primary hover:bg-primary/10 rounded-xl transition-all" title="Assign Teacher/Room">
                                                    <span class="material-symbols-outlined text-lg">person_add</span>
                                                </button>
                                            @endif
                                            <button wire:click="deleteSchedule({{ $schedule->id }})" wire:confirm="Are you sure you want to remove this schedule?" class="p-2 text-[#9a4c4c] hover:bg-red-50 hover:text-red-600 rounded-xl transition-all" title="Remove Schedule">
                                                <span class="material-symbols-outlined text-lg">delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <span class="material-symbols-outlined text-4xl mb-2 opacity-50">event_busy</span>
                                            <p class="text-sm font-semibold">No schedules assigned to this section yet.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Apply Template Modal -->
    <div x-show="showTemplateModal" style="display: none;" class="fixed inset-0 lg:left-64 z-40 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-cloak>
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showTemplateModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 -z-10 transition-opacity bg-black/60 backdrop-blur-sm" @click="showTemplateModal = false" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showTemplateModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-lg overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-[#2a1515] rounded-3xl shadow-2xl relative z-10">
                <!-- Modal Header -->
                <div class="px-8 py-6 border-b border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center justify-between bg-primary/5">
                    <div>
                        <h3 class="text-xl font-black text-primary uppercase tracking-tight" id="modal-title">Apply Template</h3>
                        <p class="text-xs text-[#9a4c4c] dark:text-white/60 mt-1">Select a schedule template to populate this section's timetable.</p>
                    </div>
                    <button @click="showTemplateModal = false" class="text-gray-400 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <form wire:submit.prevent="applyTemplate" class="p-8 space-y-6">
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Available Templates ({{ $section->grade_level }})</label>
                        <select wire:model="selectedTemplateId" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary transition-all mt-1">
                            <option value="">Select a Template</option>
                            @foreach($templates as $template)
                                <option value="{{ $template->id }}">{{ $template->name }} ({{ $template->type }})</option>
                            @endforeach
                        </select>
                        @error('selectedTemplateId') <span class="text-[10px] text-red-500 font-bold uppercase mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-6 mt-6 border-t border-[#f3e7e7] dark:border-[#3a1f1f]">
                        <button type="button" @click="showTemplateModal = false" class="px-6 py-2.5 text-sm font-bold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">Cancel</button>
                        <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-primary hover:bg-primary/90 rounded-xl shadow-lg shadow-primary/30 transition-all">Apply Template</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Assign Modal -->
    <div x-show="showAssignModal" style="display: none;" class="fixed inset-0 lg:left-64 z-40 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-cloak>
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showAssignModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 -z-10 transition-opacity bg-black/60 backdrop-blur-sm" @click="showAssignModal = false" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showAssignModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-lg overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-[#2a1515] rounded-3xl shadow-2xl relative z-10">
                <!-- Modal Header -->
                <div class="px-8 py-6 border-b border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center justify-between bg-primary/5">
                    <div>
                        <h3 class="text-xl font-black text-primary uppercase tracking-tight" id="modal-title">Assign Teacher and Room</h3>
                        <p class="text-xs text-[#9a4c4c] dark:text-white/60 mt-1">Assign resources to this scheduled block.</p>
                    </div>
                    <button @click="showAssignModal = false" class="text-gray-400 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <form wire:submit.prevent="saveAssignment" class="p-8 space-y-6">
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Teacher</label>
                        <select wire:model="assignTeacherId" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary transition-all mt-1">
                            <option value="">Select a Teacher</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                        @error('assignTeacherId') <span class="text-[10px] text-red-500 font-bold uppercase mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Room</label>
                        <select wire:model="assignRoomId" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary transition-all mt-1">
                            <option value="">Select a Room</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->name }}</option>
                            @endforeach
                        </select>
                        @error('assignRoomId') <span class="text-[10px] text-red-500 font-bold uppercase mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-6 mt-6 border-t border-[#f3e7e7] dark:border-[#3a1f1f]">
                        <button type="button" @click="showAssignModal = false" class="px-6 py-2.5 text-sm font-bold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">Cancel</button>
                        <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-primary hover:bg-primary/90 rounded-xl shadow-lg shadow-primary/30 transition-all">Save Assignment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
