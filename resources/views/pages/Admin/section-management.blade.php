@section('page-title', 'Section Management')

<div>
    <div class="space-y-8">
        
        <!-- Page Heading -->
        <div class="flex flex-wrap justify-between items-center gap-4 mb-8">
            <div class="flex items-center gap-4">
                <div class="size-16 rounded-2xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-3xl">meeting_room</span>
                </div>
                <div class="flex flex-col gap-1">
                    <h2 class="text-3xl font-black tracking-tight text-[#1b0d0d] dark:text-[#fcf8f8]">Section Management</h2>
                    <p class="text-[#9a4c4c] dark:text-[#c48d8d] text-base font-medium">Manage class sections, advisers, and student capacities for Tanza National Trade School.</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button wire:click="$set('showAutoSectionModal', true)" class="flex items-center gap-2 px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg font-bold text-sm transition-all shadow-lg shadow-green-600/20">
                    <span class="material-symbols-outlined text-lg">auto_fix_high</span>
                    <span>Run Auto-Sectioning</span>
                </button>
                <button wire:click="$set('showCreateModal', true)" class="flex items-center gap-2 px-6 py-2.5 bg-primary hover:bg-primary/90 text-white rounded-lg font-bold text-sm transition-all shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined text-lg">add_circle</span>
                    <span>Create New Section</span>
                </button>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- ToolBar & Chips -->
        <div class="bg-white dark:bg-[#2c1818] rounded-xl p-4 mb-8 shadow-sm border border-[#f3e7e7] dark:border-[#3d2525] flex flex-wrap items-center justify-between gap-4">
            <div class="flex gap-3 flex-wrap items-center w-full md:w-auto">
                <div class="relative w-full md:w-auto">
                    <input wire:model.live.debounce.300ms="search" class="form-input flex w-full min-w-[240px] border-none bg-[#f3e7e7] dark:bg-[#3d2525] text-[#1b0d0d] dark:text-[#fcf8f8] focus:ring-0 h-10 placeholder:text-[#9a4c4c] px-10 rounded-lg text-sm font-normal" placeholder="Search sections..." />
                    <span class="material-symbols-outlined absolute left-3 top-2.5 text-[#9a4c4c] text-xl">search</span>
                </div>

                <div class="hidden md:block h-10 w-[1px] bg-[#f3e7e7] dark:bg-[#3d2525] mx-2"></div>

                <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                    <select wire:model.live="activeGrade" class="bg-[#f3e7e7] dark:bg-[#3d2525] border-none rounded-lg text-xs font-bold text-[#1b0d0d] dark:text-[#fcf8f8] focus:ring-primary h-10 px-4 w-full sm:w-auto">
                        <option value="All">All Grades</option>
                        @foreach(['Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'] as $grade)
                            <option value="{{ $grade }}">{{ $grade }}</option>
                        @endforeach
                    </select>

                    <select wire:model.live="activeStrand" class="bg-[#f3e7e7] dark:bg-[#3d2525] border-none rounded-lg text-xs font-bold text-[#1b0d0d] dark:text-[#fcf8f8] focus:ring-primary h-10 px-4 w-full sm:w-auto">
                        <option value="All">All Strands</option>
                        @foreach(['STEM', 'ICT', 'HUMSS', 'ABM', 'HE', 'Industrial Arts'] as $strand)
                            <option value="{{ $strand }}">{{ $strand }}</option>
                        @endforeach
                    </select>

                    <select wire:model.live="activeCourse" class="bg-[#f3e7e7] dark:bg-[#3d2525] border-none rounded-lg text-xs font-bold text-[#1b0d0d] dark:text-[#fcf8f8] focus:ring-primary h-10 px-4 w-full sm:w-auto">
                        <option value="All">All TVL Courses</option>
                        @foreach(['ICT', 'CSS', 'Food Industry', 'Automotive', 'Drafting', 'SMAW', 'HE'] as $course)
                            <option value="{{ $course }}">{{ $course }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Section Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pb-20">
            @forelse($sections as $section)
            <div class="bg-white dark:bg-[#2c1818] rounded-xl overflow-hidden border border-[#f3e7e7] dark:border-[#3d2525] flex flex-col shadow-sm hover:shadow-md transition-shadow relative">
                <div class="h-32 bg-primary/10 relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#d41111 2px, transparent 2px); background-size: 20px 20px;"></div>
                    <div class="absolute bottom-4 left-4">
                        <span class="bg-primary text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider mb-1 inline-block">
                            {{ $section->grade_level }} {{ $section->strand ? '• ' . $section->strand : '' }}
                        </span>
                        <hgroup>
                            <h3 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-xl font-bold">{{ $section->name }}</h3>
                            @if($section->specialization)
                                <p class="text-[10px] text-primary/70 font-bold uppercase">{{ $section->specialization }}</p>
                            @endif
                        </hgroup>
                    </div>
                    <!-- Delete Section Button (only if no students assigned) -->
                    @php
                        $hasStudents = (!empty($section->specialization) && in_array($section->grade_level, ['Grade 8', 'Grade 9', 'Grade 10'])) ? $section->tech_voc_enrollments_count > 0 : $section->enrollments_count > 0;
                    @endphp
                    @if(!$hasStudents)
                        <button wire:click="deleteSection({{ $section->id }})" wire:confirm="Are you sure you want to delete the section '{{ $section->name }}'?" class="absolute top-4 right-4 text-primary hover:text-red-700 transition-colors bg-white/80 hover:bg-white dark:bg-black/40 dark:hover:bg-black/60 size-8 rounded-lg flex items-center justify-center shadow-sm z-10" title="Delete Section">
                            <span class="material-symbols-outlined text-lg">delete</span>
                        </button>
                    @endif
                </div>
                <div class="p-5 flex-1">
                    <div class="space-y-3 mb-6">
                        <div class="flex items-center gap-3 text-[#1b0d0d] dark:text-[#fcf8f8]">
                            <span class="material-symbols-outlined text-primary text-xl">person</span>
                            <div>
                                <p class="text-xs text-[#9a4c4c] font-medium uppercase tracking-tighter">Adviser</p>
                                <p class="text-sm font-semibold">{{ $section->adviser ? $section->adviser->name : 'No Adviser Assigned' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 text-[#1b0d0d] dark:text-[#fcf8f8]">
                            <span class="material-symbols-outlined text-primary text-xl">meeting_room</span>
                            <div>
                                <p class="text-xs text-[#9a4c4c] font-medium uppercase tracking-tighter">Room</p>
                                <p class="text-sm font-semibold">{{ $section->room ? $section->room->name : 'TBA' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center text-xs">
                            <span class="font-medium text-[#9a4c4c]">Enrollment Capacity</span>
                            @php
                                $currentCount = (!empty($section->specialization) && in_array($section->grade_level, ['Grade 8', 'Grade 9', 'Grade 10'])) ? $section->tech_voc_enrollments_count : $section->enrollments_count;
                            @endphp
                            <span class="font-bold text-[#1b0d0d] dark:text-[#fcf8f8]">{{ $currentCount }}/{{ $section->capacity }}</span>
                        </div>
                        <div class="w-full bg-[#f3e7e7] dark:bg-[#3d2525] h-2 rounded-full overflow-hidden">
                            @php
                                $percent = min(100, ($currentCount / max(1, $section->capacity)) * 100);
                                $color = $percent >= 100 ? 'bg-[#1b0d0d]' : 'bg-primary';
                            @endphp
                            <div class="{{ $color }} h-full rounded-full" style="width: {{ $percent }}%;"></div>
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-[#fcf8f8] dark:bg-[#221010] border-t border-[#f3e7e7] dark:border-[#3d2525] grid grid-cols-2 gap-3">
                    <button wire:click="openAdviserModal({{ $section->id }})" class="h-9 flex items-center justify-center rounded-lg border border-primary text-primary text-xs font-bold hover:bg-primary/5 transition-colors">
                        Assign Teacher
                    </button>
                    <button wire:click="openRoomModal({{ $section->id }})" class="h-9 flex items-center justify-center rounded-lg border border-primary text-primary text-xs font-bold hover:bg-primary/5 transition-colors">
                        Assign Room
                    </button>
                    <a href="{{ route('admin.sections.students', $section->id) }}" class="col-span-2 h-9 flex items-center justify-center rounded-lg bg-primary text-white text-xs font-bold hover:opacity-90 transition-opacity">
                        Manage Section
                    </a>
                </div>
            </div>
            @empty
                @if($totalSectionsCount > 0)
                <div class="col-span-full py-20 text-center">
                    <span class="material-symbols-outlined text-6xl text-[#f3e7e7]">inventory_2</span>
                    <p class="text-[#9a4c4c] mt-4 font-bold">No sections found matching your search.</p>
                </div>
                @endif
            @endforelse

            @if($sections->isNotEmpty() || $totalSectionsCount === 0)
            <!-- Add New Card Placeholder -->
            <div wire:click="$set('showCreateModal', true)" class="border-2 border-dashed border-[#f3e7e7] dark:border-[#3d2525] rounded-xl flex flex-col items-center justify-center p-8 gap-4 hover:border-primary transition-colors group cursor-pointer">
                <div class="size-16 rounded-full bg-[#f3e7e7] dark:bg-[#3d2525] flex items-center justify-center group-hover:bg-primary/10 transition-colors">
                    <span class="material-symbols-outlined text-3xl text-[#9a4c4c] group-hover:text-primary transition-colors">add_circle</span>
                </div>
                <div class="text-center">
                    <p class="text-[#1b0d0d] dark:text-[#fcf8f8] font-bold">Add Another Section</p>
                    <p class="text-[#9a4c4c] text-sm">Create a new class for the semester</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Auto Sectioning Modal -->
        </div>
        @if($showAutoSectionModal)
        <div class="fixed inset-0 lg:left-64 z-40 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="absolute inset-0 -z-10 transition-opacity bg-black/60 backdrop-blur-sm" wire:click="$set('showAutoSectionModal', false)"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div class="inline-block w-full max-w-2xl overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-[#2a1515] rounded-3xl shadow-2xl flex flex-col max-h-[90vh] relative z-10">
                    <div class="px-8 py-6 border-b border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center justify-between bg-primary/5 shrink-0">
                        <div>
                            <h3 class="text-xl font-black text-primary uppercase tracking-tight flex items-center gap-2">
                                <span class="material-symbols-outlined text-green-600">auto_fix_high</span>
                                Auto-Sectioning Engine
                            </h3>
                            <p class="text-xs text-[#9a4c4c] dark:text-white/60 mt-1">Automatically distribute unsectioned students based on performance, track, and capacity constraints.</p>
                        </div>
                        <button wire:click="$set('showAutoSectionModal', false)" class="text-gray-400 hover:text-primary transition-colors">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <div class="flex border-b border-[#f3e7e7] dark:border-[#3a1f1f] bg-gray-50/50 dark:bg-black/20 shrink-0">
                        <button wire:click="$set('activeAutoTab', 'jhs')" class="flex-1 py-4 text-xs uppercase tracking-widest font-black text-center border-b-2 transition-colors {{ $activeAutoTab === 'jhs' ? 'border-primary text-primary bg-white dark:bg-[#2a1515]' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}">
                            High School (7-10)
                        </button>
                        <button wire:click="$set('activeAutoTab', 'tvl')" class="flex-1 py-4 text-xs uppercase tracking-widest font-black text-center border-b-2 transition-colors {{ $activeAutoTab === 'tvl' ? 'border-primary text-primary bg-white dark:bg-[#2a1515]' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}">
                            Tech Voc (8-10)
                        </button>
                        <button wire:click="$set('activeAutoTab', 'shs')" class="flex-1 py-4 text-xs uppercase tracking-widest font-black text-center border-b-2 transition-colors {{ $activeAutoTab === 'shs' ? 'border-primary text-primary bg-white dark:bg-[#2a1515]' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}">
                            Senior High (11-12)
                        </button>
                    </div>

                    <div class="p-8 overflow-y-auto space-y-6 flex-1">
                        @if($activeAutoTab === 'jhs')
                            <div>
                                <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Select Grade Level</label>
                                <select wire:model.live="autoGrade" class="w-full px-4 py-3 mt-1 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary">
                                    <option value="All">All JHS Grades</option>
                                    @foreach(['Grade 7', 'Grade 8', 'Grade 9', 'Grade 10'] as $grade)
                                        <option value="{{ $grade }}">{{ $grade }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @elseif($activeAutoTab === 'tvl')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Grade Level</label>
                                    <select wire:model.live="autoGrade" class="w-full px-4 py-3 mt-1 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary">
                                        <option value="All">All Grades</option>
                                        @foreach(['Grade 8', 'Grade 9', 'Grade 10'] as $grade)
                                            <option value="{{ $grade }}">{{ $grade }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Tech Voc Course</label>
                                    <select wire:model.live="autoCourseStrand" class="w-full px-4 py-3 mt-1 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary">
                                        <option value="All">All Courses</option>
                                        @foreach(['ICT', 'CSS', 'Food Industry', 'Automotive', 'Drafting', 'SMAW', 'HE'] as $course)
                                            <option value="{{ $course }}">{{ $course }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @elseif($activeAutoTab === 'shs')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Grade Level</label>
                                    <select wire:model.live="autoGrade" class="w-full px-4 py-3 mt-1 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary">
                                        <option value="All">All SHS Grades</option>
                                        <option value="Grade 11">Grade 11</option>
                                        <option value="Grade 12">Grade 12</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Strand</label>
                                    <select wire:model.live="autoCourseStrand" class="w-full px-4 py-3 mt-1 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary">
                                        <option value="All">All Strands</option>
                                        @foreach(['STEM', 'ICT', 'HUMSS', 'ABM', 'HE', 'Industrial Arts'] as $strand)
                                            <option value="{{ $strand }}">{{ $strand }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                        <div class="bg-primary/5 border border-primary/20 rounded-2xl p-6 text-center">
                            <p class="text-[10px] font-black text-[#9a4c4c] uppercase tracking-widest mb-2">Unsectioned Students Found</p>
                            <div class="text-5xl font-black text-primary mb-3">{{ $this->unsectionedStats['total'] }}</div>
                            <div class="flex justify-center gap-6 text-sm font-semibold text-gray-500">
                                <span class="flex items-center gap-1"><span class="material-symbols-outlined text-blue-500 text-lg">male</span> {{ $this->unsectionedStats['male'] }} Male</span>
                                <span class="flex items-center gap-1"><span class="material-symbols-outlined text-pink-500 text-lg">female</span> {{ $this->unsectionedStats['female'] }} Female</span>
                            </div>
                        </div>

                        <div class="bg-yellow-50 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-200 p-4 rounded-xl text-xs flex gap-3 border border-yellow-200 dark:border-yellow-900/50">
                            <span class="material-symbols-outlined text-yellow-600 dark:text-yellow-400 shrink-0">info</span>
                            <p><strong>Note:</strong> The algorithm will first fill designated Star Sections (GWA 90+) based on merit, followed by gender-balanced round-robin allocation for regular sections. Ensure you have created sufficient sections before running.</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 px-8 py-6 border-t border-[#f3e7e7] dark:border-[#3a1f1f] shrink-0">
                        <button type="button" wire:click="$set('showAutoSectionModal', false)" class="px-6 py-2.5 text-sm font-bold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">Cancel</button>
                        <button type="button" wire:click="runAutoSectioning" class="px-6 py-2.5 text-sm font-black text-white bg-green-600 hover:bg-green-700 rounded-xl shadow-lg shadow-green-600/30 transition-all flex items-center gap-2" {{ $this->unsectionedStats['total'] == 0 ? 'disabled' : '' }} @disabled($this->unsectionedStats['total'] == 0)>
                            <span wire:loading wire:target="runAutoSectioning" class="size-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                            Execute Sectioning
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($showCreateModal)
        <div class="fixed inset-0 lg:left-64 z-40 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="absolute inset-0 -z-10 transition-opacity bg-black/60 backdrop-blur-sm" wire:click="$set('showCreateModal', false)"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div class="inline-block w-full max-w-2xl overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-[#2a1515] rounded-3xl shadow-2xl relative z-10">
                    <div class="px-8 py-6 border-b border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center justify-between bg-primary/5">
                        <div>
                            <h3 class="text-xl font-black text-primary uppercase tracking-tight">New Section</h3>
                            <p class="text-xs text-[#9a4c4c] dark:text-white/60">Create a new class section for the academic year.</p>
                        </div>
                        <button wire:click="$set('showCreateModal', false)" class="text-gray-400 hover:text-primary transition-colors">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <form wire:submit.prevent="createSection" class="p-8 space-y-6">
                        <div class="flex gap-2 p-1 bg-[#fdfafb] dark:bg-[#3d2424] border border-[#f3e7e7] dark:border-[#4d3232] rounded-xl mb-4">
                            <button type="button" wire:click="setNewSectionType('normal')" class="flex-1 py-2.5 text-xs uppercase tracking-widest font-black rounded-lg transition-colors {{ $newSection['type'] === 'normal' ? 'bg-white dark:bg-[#2a1515] shadow text-primary' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400' }}">Normal Section</button>
                            <button type="button" wire:click="setNewSectionType('tvl')" class="flex-1 py-2.5 text-xs uppercase tracking-widest font-black rounded-lg transition-colors {{ $newSection['type'] === 'tvl' ? 'bg-white dark:bg-[#2a1515] shadow text-primary' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400' }}">TechVoc Section</button>
                        </div>

                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Section Name</label>
                            @if(($newSection['type'] === 'tvl') || ($newSection['type'] === 'normal' && in_array($newSection['grade_level'], ['Grade 11', 'Grade 12'])))
                                <input type="text" readonly value="{{ $newSection['name'] }}" class="w-full px-4 py-3 mt-1 bg-gray-100 dark:bg-black/20 text-gray-500 border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm cursor-not-allowed font-bold" placeholder="Auto-generated (e.g. G-8 - CSS-A)" />
                            @else
                                <input wire:model.defer="newSection.name" type="text" placeholder="e.g. Sampaguita, Newton" class="w-full px-4 py-3 mt-1 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary" />
                            @endif
                            @error('newSection.name') <span class="text-[10px] text-red-500 font-bold uppercase mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Grade Level</label>
                                <select wire:model.live="newSection.grade_level" class="w-full px-4 py-3 mt-1 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary">
                                    <option value="">Select...</option>
                                    @if($newSection['type'] === 'normal')
                                        @foreach(['Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'] as $grade)
                                            <option value="{{ $grade }}">{{ $grade }}</option>
                                        @endforeach
                                    @else
                                        @foreach(['Grade 8', 'Grade 9', 'Grade 10'] as $grade)
                                            <option value="{{ $grade }}">{{ $grade }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('newSection.grade_level') <span class="text-[10px] text-red-500 font-bold uppercase mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Capacity</label>
                                <input wire:model.defer="newSection.capacity" type="number" class="w-full px-4 py-3 mt-1 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary" />
                                @error('newSection.capacity') <span class="text-[10px] text-red-500 font-bold uppercase mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        @if($newSection['type'] === 'normal' && in_array($newSection['grade_level'], ['Grade 11', 'Grade 12']))
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Track</label>
                                    <select wire:model.live="newSection.track" class="w-full px-4 py-3 mt-1 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary">
                                        <option value="">Select Track...</option>
                                        <option value="ACADEMIC">ACADEMIC</option>
                                        <option value="TECHPRO">TECHPRO</option>
                                    </select>
                                    @error('newSection.track') <span class="text-[10px] text-red-500 font-bold uppercase mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Strand</label>
                                    <select wire:model.live="newSection.strand" class="w-full px-4 py-3 mt-1 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary">
                                        <option value="">Select Strand...</option>
                                        @if($newSection['track'] === 'ACADEMIC')
                                            <option value="ABM">ABM</option>
                                            <option value="ABS">ABS</option>
                                            <option value="GAS">GAS</option>
                                            <option value="HUMSS">HUMSS</option>
                                            <option value="STEM">STEM</option>
                                        @elseif($newSection['track'] === 'TECHPRO')
                                            <option value="ICT">ICT</option>
                                            <option value="HE">HE</option>
                                            <option value="Industrial Arts">Industrial Arts</option>
                                        @endif
                                    </select>
                                    @error('newSection.strand') <span class="text-[10px] text-red-500 font-bold uppercase mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @endif

                        @if($newSection['type'] === 'tvl')
                            <div>
                                <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">TechVoc Course</label>
                                <select wire:model.live="newSection.specialization" class="w-full px-4 py-3 mt-1 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary">
                                    <option value="">Select Course...</option>
                                    @foreach(['ICT', 'CSS', 'Food Industry', 'Automotive', 'Drafting', 'SMAW', 'HE'] as $course)
                                        <option value="{{ $course }}">{{ $course }}</option>
                                    @endforeach
                                </select>
                                @error('newSection.specialization') <span class="text-[10px] text-red-500 font-bold uppercase mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        @endif

                        <div class="flex items-center justify-end gap-3 pt-6 mt-6 border-t border-[#f3e7e7] dark:border-[#3a1f1f]">
                            <button type="button" wire:click="$set('showCreateModal', false)" class="px-6 py-2.5 text-sm font-bold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">Cancel</button>
                            <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-primary hover:bg-primary/90 rounded-xl shadow-lg shadow-primary/30 transition-all">
                                Confirm Creation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif

        <!-- Assign Adviser Modal -->
        @if($showAdviserModal)
        <div class="fixed inset-0 lg:left-64 z-40 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="absolute inset-0 -z-10 transition-opacity bg-black/60 backdrop-blur-sm" wire:click="$set('showAdviserModal', false)"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div class="inline-block w-full max-w-2xl overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-[#2a1515] rounded-3xl shadow-2xl relative z-10">
                    <div class="px-8 py-6 border-b border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center justify-between bg-primary/5">
                        <div>
                            <h3 class="text-xl font-black text-primary uppercase tracking-tight">Assign Adviser</h3>
                            <p class="text-xs text-[#9a4c4c] dark:text-white/60">Section: {{ $currentSectionName }}</p>
                        </div>
                        <button wire:click="$set('showAdviserModal', false)" class="text-gray-400 hover:text-primary transition-colors">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <form wire:submit.prevent="assignAdviser" class="p-8 space-y-6">
                        <!-- Search Input -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Search Faculty</label>
                            <div class="relative mt-1">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-[#9a4c4c]">search</span>
                                <input wire:model.live.debounce.300ms="adviserSearch" type="text" placeholder="Search by name or Employee ID..." class="w-full pl-12 pr-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary text-[#1b0d0d] dark:text-white" />
                            </div>
                        </div>

                        <!-- Results List (Max 5) -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Faculty Members</label>
                            <div class="space-y-2 max-h-[250px] overflow-y-auto pr-1 mt-1">
                                @forelse($this->facultySearchResults as $faculty)
                                    @php
                                        $isSelected = $selectedAdviserId == $faculty->user_id;
                                        $parts = explode(' ', $faculty->user->name);
                                        $initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
                                    @endphp
                                    <div wire:click="$set('selectedAdviserId', {{ $isSelected ? 'null' : $faculty->user_id }})"
                                         class="flex items-center justify-between p-3.5 rounded-xl border cursor-pointer transition-all hover:scale-[1.01] {{ $isSelected ? 'bg-primary/10 border-primary text-primary shadow-sm' : 'bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] hover:bg-gray-50' }}">
                                        <div class="flex items-center gap-3">
                                            <div class="size-8 rounded-full flex items-center justify-center font-bold text-xs uppercase {{ $isSelected ? 'bg-primary text-white' : 'bg-primary/10 text-primary' }}">
                                                {{ $initials }}
                                            </div>
                                            <div class="flex flex-col text-left">
                                                <span class="text-sm font-bold truncate leading-tight">{{ $faculty->user->name }}</span>
                                                <span class="text-[10px] text-[#9a4c4c] dark:text-white/40 mt-0.5 uppercase tracking-tighter">ID: {{ $faculty->faculty_id }}</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            @if($isSelected)
                                                <span class="material-symbols-outlined text-primary text-xl">check_circle</span>
                                            @else
                                                <span class="material-symbols-outlined text-gray-300 text-xl">radio_button_unchecked</span>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-6 text-xs text-gray-400 italic">
                                        No faculty members found matching "{{ $adviserSearch }}"
                                    </div>
                                @endforelse
                            </div>
                            @error('selectedAdviserId') <span class="text-[10px] text-red-500 font-bold uppercase mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex items-center justify-end gap-3 pt-6 mt-6 border-t border-[#f3e7e7] dark:border-[#3a1f1f]">
                            <button type="button" wire:click="$set('showAdviserModal', false)" class="px-6 py-2.5 text-sm font-bold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">Cancel</button>
                            <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-primary hover:bg-primary/90 rounded-xl shadow-lg shadow-primary/30 transition-all">
                                Save Assignment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif

        <!-- Assign Room Modal -->
        @if($showRoomModal)
        <div class="fixed inset-0 lg:left-64 z-40 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="absolute inset-0 -z-10 transition-opacity bg-black/60 backdrop-blur-sm" wire:click="$set('showRoomModal', false)"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div class="inline-block w-full max-w-2xl overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-[#2a1515] rounded-3xl shadow-2xl">
                    <div class="px-8 py-6 border-b border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center justify-between bg-primary/5">
                        <div>
                            <h3 class="text-xl font-black text-primary uppercase tracking-tight">Assign Room</h3>
                            <p class="text-xs text-[#9a4c4c] dark:text-white/60">Section: {{ $currentSectionName }}</p>
                        </div>
                        <button wire:click="$set('showRoomModal', false)" class="text-gray-400 hover:text-primary transition-colors">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <form wire:submit.prevent="assignRoom" class="p-8 space-y-6">
                        <!-- Search Input -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Search Room or Building</label>
                            <div class="relative mt-1">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-[#9a4c4c]">search</span>
                                <input wire:model.live.debounce.300ms="roomSearch" type="text" placeholder="Search by name or building..." class="w-full pl-12 pr-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary text-[#1b0d0d] dark:text-white" />
                            </div>
                        </div>

                        <!-- Results List (Max 5) -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Rooms</label>
                            <div class="space-y-2 max-h-[250px] overflow-y-auto pr-1 mt-1">
                                @forelse($this->roomSearchResults as $room)
                                    @php
                                        $isSelected = $selectedRoomId == $room->id;
                                    @endphp
                                    <div wire:click="$set('selectedRoomId', {{ $isSelected ? 'null' : $room->id }})"
                                         class="flex items-center justify-between p-3.5 rounded-xl border cursor-pointer transition-all hover:scale-[1.01] {{ $isSelected ? 'bg-primary/10 border-primary text-primary shadow-sm' : 'bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] hover:bg-gray-50' }}">
                                        <div class="flex items-center gap-3">
                                            <div class="size-8 rounded-full flex items-center justify-center font-bold text-xs uppercase {{ $isSelected ? 'bg-primary text-white' : 'bg-primary/10 text-primary' }}">
                                                <span class="material-symbols-outlined text-sm">meeting_room</span>
                                            </div>
                                            <div class="flex flex-col text-left">
                                                <span class="text-sm font-bold truncate leading-tight">{{ $room->name }}</span>
                                                <span class="text-[10px] text-[#9a4c4c] dark:text-white/40 mt-0.5 uppercase tracking-tighter">{{ $room->building->name ?? 'No Building' }} • {{ $room->floor }}</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            @if($isSelected)
                                                <span class="material-symbols-outlined text-primary text-xl">check_circle</span>
                                            @else
                                                <span class="material-symbols-outlined text-gray-300 text-xl">radio_button_unchecked</span>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-6 text-xs text-gray-400 italic">
                                        No rooms found matching "{{ $roomSearch }}"
                                    </div>
                                @endforelse
                            </div>
                            @error('selectedRoomId') <span class="text-[10px] text-red-500 font-bold uppercase mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex items-center justify-end gap-3 pt-6 mt-6 border-t border-[#f3e7e7] dark:border-[#3a1f1f]">
                            <button type="button" wire:click="$set('showRoomModal', false)" class="px-6 py-2.5 text-sm font-bold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">Cancel</button>
                            <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-primary hover:bg-primary/90 rounded-xl shadow-lg shadow-primary/30 transition-all">
                                Save Assignment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
</div>
