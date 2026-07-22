@section('page-title', 'Schedule Templates')

<div x-data="{ showTemplateModal: @entangle('showTemplateModal'), showSlotsModal: @entangle('showSlotsModal') }">
    <!-- Page Heading -->
    <div class="flex flex-wrap justify-between items-center gap-4 mb-8">
        <div class="flex items-center gap-4">
            <div class="size-16 rounded-2xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-3xl">dynamic_form</span>
            </div>
            <div class="flex flex-col gap-1">
                <h2 class="text-3xl font-black tracking-tight text-[#1b0d0d] dark:text-[#fcf8f8]">Schedule Templates</h2>
                <p class="text-[#9a4c4c] dark:text-[#c48d8d] text-base font-medium">Manage base timetables for automated scheduling</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button wire:click="openTemplateModal" class="flex items-center gap-2 px-6 py-2.5 bg-primary hover:bg-primary/90 text-white rounded-lg font-bold text-sm transition-all shadow-lg shadow-primary/20">
                <span class="material-symbols-outlined text-lg">add</span>
                <span>Create Template</span>
            </button>
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

    <!-- Controls -->
    <div class="flex flex-wrap gap-4 mb-6 justify-between items-center">
        <div class="flex gap-2 bg-white dark:bg-[#2a1515] p-1 rounded-xl border border-gray-100 dark:border-[#3a1f1f] shadow-sm">
            @foreach(['All', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10'] as $grade)
                <button wire:click="$set('activeGradeLevel', '{{ $grade }}')" 
                        class="px-4 py-2 rounded-lg text-xs font-black uppercase tracking-widest transition-all {{ $activeGradeLevel === $grade ? 'bg-primary text-white shadow-md' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5' }}">
                    {{ $grade }}
                </button>
            @endforeach
        </div>
        
        <div class="relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search templates..." class="w-64 pl-10 pr-4 py-2 bg-white dark:bg-[#2a1515] border border-gray-200 dark:border-[#3a1f1f] rounded-xl text-sm font-semibold focus:ring-primary focus:border-primary shadow-sm">
        </div>
    </div>

    <!-- Templates Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($templates as $template)
            <div class="bg-white dark:bg-[#2a1515] rounded-2xl border border-[#f3e7e7] dark:border-[#3a1f1f] p-6 shadow-sm hover:shadow-md transition-all flex flex-col h-full group relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1 h-full {{ $template->type === 'TechVoc' ? 'bg-orange-500' : 'bg-primary' }}"></div>
                
                <div class="flex justify-between items-start mb-4 pl-2">
                    <div>
                        <h3 class="text-xl font-black text-[#1b0d0d] dark:text-white mb-1">{{ $template->name }}</h3>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-1 bg-gray-100 dark:bg-white/5 text-gray-600 dark:text-gray-400 text-[10px] font-black uppercase rounded-lg tracking-widest">{{ $template->grade_level }}</span>
                            <span class="px-2.5 py-1 {{ $template->type === 'TechVoc' ? 'bg-orange-50 text-orange-600' : 'bg-primary/10 text-primary' }} text-[10px] font-black uppercase rounded-lg tracking-widest">{{ $template->type }}</span>
                        </div>
                    </div>
                    <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button wire:click="openTemplateModal({{ $template->id }})" class="p-2 text-gray-400 hover:text-primary hover:bg-primary/10 rounded-lg transition-colors">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                        </button>
                        <button wire:click="deleteTemplate({{ $template->id }})" wire:confirm="Delete this template?" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                        </button>
                    </div>
                </div>

                <div class="mt-auto pl-2 flex items-center justify-between border-t border-gray-100 dark:border-[#3a1f1f] pt-4">
                    <div class="flex items-center gap-1.5 text-gray-500">
                        <span class="material-symbols-outlined text-lg">format_list_bulleted</span>
                        <span class="text-sm font-bold">{{ $template->slots_count }} Slots</span>
                    </div>
                    <button wire:click="manageSlots({{ $template->id }})" class="text-sm font-bold text-primary hover:text-[#7a3c3c] flex items-center gap-1">
                        Build Timetable
                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 flex flex-col items-center justify-center bg-white dark:bg-[#2a1515] rounded-3xl border border-dashed border-gray-200 dark:border-[#3a1f1f]">
                <span class="material-symbols-outlined text-6xl text-gray-300 dark:text-gray-600 mb-4">calendar_view_week</span>
                <p class="text-xl font-bold text-gray-400 dark:text-gray-500">No schedule templates found.</p>
                <button wire:click="openTemplateModal" class="mt-4 text-primary font-bold text-sm hover:underline">Create your first template</button>
            </div>
        @endforelse
    </div>
    
    <div class="mt-6">
        {{ $templates->links() }}
    </div>

    <!-- Create/Edit Template Modal -->
    <div x-show="showTemplateModal" style="display: none;" class="fixed inset-0 lg:left-64 z-40 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-cloak>
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showTemplateModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 -z-10 transition-opacity bg-black/60 backdrop-blur-sm" @click="showTemplateModal = false" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showTemplateModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-2xl overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-[#2a1515] rounded-3xl shadow-2xl relative z-10">
                <!-- Modal Header -->
                <div class="px-8 py-6 border-b border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center justify-between bg-primary/5">
                    <div>
                        <h3 class="text-xl font-black text-primary uppercase tracking-tight" id="modal-title">{{ $templateId ? 'Edit Template' : 'Create Template' }}</h3>
                        <p class="text-xs text-[#9a4c4c] dark:text-white/60">Define the base attributes for this schedule template.</p>
                    </div>
                    <button @click="showTemplateModal = false" class="text-gray-400 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <form wire:submit.prevent="saveTemplate" class="p-8 space-y-6">
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Template Name</label>
                        <input wire:model="name" type="text" placeholder="e.g. Grade 7 Standard Block" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary transition-all mt-1">
                        @error('name') <span class="text-[10px] text-red-500 font-bold uppercase mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Grade Level</label>
                            <select wire:model="grade_level" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary transition-all mt-1">
                                <option value="Grade 7">Grade 7</option>
                                <option value="Grade 8">Grade 8</option>
                                <option value="Grade 9">Grade 9</option>
                                <option value="Grade 10">Grade 10</option>
                            </select>
                            @error('grade_level') <span class="text-[10px] text-red-500 font-bold uppercase mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Template Type</label>
                            <select wire:model="type" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary transition-all mt-1">
                                <option value="Normal">Normal</option>
                                <option value="TechVoc">Tech-Voc</option>
                            </select>
                            @error('type') <span class="text-[10px] text-red-500 font-bold uppercase mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-6 mt-6 border-t border-[#f3e7e7] dark:border-[#3a1f1f]">
                        <button type="button" @click="showTemplateModal = false" class="px-6 py-2.5 text-sm font-bold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">Cancel</button>
                        <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-primary hover:bg-primary/90 rounded-xl shadow-lg shadow-primary/30 transition-all">Save Template</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Manage Slots Modal -->
    <div x-show="showSlotsModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showSlotsModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 -z-10 transition-opacity bg-gray-900/75 backdrop-blur-sm" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showSlotsModal" @click.away="showSlotsModal = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block px-0 pt-0 pb-0 overflow-hidden text-left align-bottom transition-all transform bg-white dark:bg-[#1a0c0c] rounded-3xl shadow-2xl sm:my-8 sm:align-middle max-w-5xl w-full border border-gray-100 dark:border-[#3a1f1f] relative z-10">
                
                @if($managingTemplate)
                <div class="px-8 py-6 border-b border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center justify-between bg-primary/5">
                    <div>
                        <h3 class="text-xl font-black text-primary uppercase tracking-tight">{{ $managingTemplate->name }} - Timetable</h3>
                        <p class="text-xs text-[#9a4c4c] dark:text-white/60 mt-1">Add slots to outline this schedule's structure.</p>
                    </div>
                    <button @click="showSlotsModal = false" class="text-gray-400 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="flex flex-col md:flex-row h-[70vh]">
                    <!-- Add Slot Form -->
                    <div class="w-full md:w-1/3 p-6 border-r border-gray-100 dark:border-[#3a1f1f] bg-white dark:bg-transparent overflow-y-auto">
                        <h4 class="font-black text-[#1b0d0d] dark:text-white mb-4 uppercase tracking-widest text-xs">Add New Slot</h4>
                        
                        <form wire:submit.prevent="addSlot" class="space-y-4">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-700 dark:text-gray-300 uppercase tracking-widest mb-1.5">Subject</label>
                                <select wire:model="subject_id" class="w-full bg-[#fdfafb] dark:bg-[#361a1a] border border-[#f3e7e7] dark:border-[#4d3232] rounded-xl px-3 py-2 text-sm font-semibold focus:ring-primary focus:border-primary transition-all">
                                    <option value="">Select a Subject</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                                @error('subject_id') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-[10px] font-bold text-gray-700 dark:text-gray-300 uppercase tracking-widest mb-1.5">Day</label>
                                <select wire:model="day" class="w-full bg-[#fdfafb] dark:bg-[#361a1a] border border-[#f3e7e7] dark:border-[#4d3232] rounded-xl px-3 py-2 text-sm font-semibold focus:ring-primary focus:border-primary transition-all">
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                </select>
                                @error('day') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-700 dark:text-gray-300 uppercase tracking-widest mb-1.5">Start Time</label>
                                    <input wire:model="start_time" type="time" class="w-full bg-[#fdfafb] dark:bg-[#361a1a] border border-[#f3e7e7] dark:border-[#4d3232] rounded-xl px-3 py-2 text-sm font-semibold focus:ring-primary focus:border-primary transition-all">
                                    @error('start_time') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-700 dark:text-gray-300 uppercase tracking-widest mb-1.5">End Time</label>
                                    <input wire:model="end_time" type="time" class="w-full bg-[#fdfafb] dark:bg-[#361a1a] border border-[#f3e7e7] dark:border-[#4d3232] rounded-xl px-3 py-2 text-sm font-semibold focus:ring-primary focus:border-primary transition-all">
                                    @error('end_time') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            <div class="pt-4">
                                <button type="submit" class="w-full bg-primary text-white font-black text-xs uppercase tracking-widest py-2.5 rounded-xl hover:bg-primary/90 transition-all shadow-sm flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-[16px]">add</span> Add Slot
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Slots List -->
                    <div class="w-full md:w-2/3 p-0 bg-gray-50 dark:bg-[#150a0a] overflow-y-auto">
                        <table class="w-full text-left">
                            <thead class="sticky top-0 bg-white dark:bg-[#1a0c0c] border-b border-gray-200 dark:border-[#3a1f1f] shadow-sm z-10">
                                <tr>
                                    <th class="px-6 py-3 text-[10px] font-black uppercase tracking-widest text-gray-500">Day & Time</th>
                                    <th class="px-6 py-3 text-[10px] font-black uppercase tracking-widest text-gray-500">Subject</th>
                                    <th class="px-6 py-3 text-[10px] font-black uppercase tracking-widest text-gray-500 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-[#3a1f1f]">
                                @forelse($managingTemplate->slots->sortBy(['day', 'start_time']) as $slot)
                                    <tr class="hover:bg-white dark:hover:bg-white/5 transition-colors">
                                        <td class="px-6 py-3">
                                            <div class="flex flex-col">
                                                <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $slot->day }}</span>
                                                <span class="text-[10px] text-primary font-black uppercase tracking-widest">
                                                    {{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }} - 
                                                    {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-3">
                                            <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $slot->subject->name }}</span>
                                        </td>
                                        <td class="px-6 py-3 text-right">
                                            <button wire:click="deleteSlot({{ $slot->id }})" class="p-1.5 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center text-gray-400">
                                            <span class="material-symbols-outlined text-4xl mb-2 opacity-50">calendar_month</span>
                                            <p class="text-sm font-semibold">No slots defined for this template.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
