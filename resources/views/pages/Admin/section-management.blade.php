<div class="bg-background-light dark:bg-background-dark text-[#1b0d0d] dark:text-[#fcf8f8] min-h-screen">
    <!-- Google Fonts: Lexend -->
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    
    <div class="layout-container flex h-full grow flex-col font-display" style="font-family: 'Lexend', sans-serif;">
        <!-- Page Heading -->
        <div class="flex flex-wrap justify-between items-end gap-4 mb-6 px-10 pt-8">
            <div class="flex flex-col gap-2">
                <h1 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-4xl font-black leading-tight tracking-tight">Section Management</h1>
                <p class="text-[#9a4c4c] dark:text-[#c08282] text-base font-normal">Manage class sections, advisers, and student capacities for Tanza National Trade School.</p>
            </div>
            <div class="flex gap-3">
                <button wire:click="$set('showAutoSectionModal', true)" class="flex items-center justify-center rounded-lg h-12 bg-green-600 text-white gap-2 text-base font-bold px-6 shadow-lg shadow-green-600/20 hover:scale-[1.02] transition-transform">
                    <span class="material-symbols-outlined">auto_fix_high</span>
                    <span>Run Auto-Sectioning</span>
                </button>
                <button wire:click="$set('showCreateModal', true)" class="flex items-center justify-center rounded-lg h-12 bg-primary text-white gap-2 text-base font-bold px-6 shadow-lg shadow-primary/20 hover:scale-[1.02] transition-transform">
                    <span class="material-symbols-outlined">add</span>
                    <span>Create New Section</span>
                </button>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="mx-10 mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mx-10 mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- ToolBar & Chips -->
        <div class="mx-10 bg-white dark:bg-[#2c1818] rounded-xl p-4 mb-8 shadow-sm border border-[#f3e7e7] dark:border-[#3d2525] flex flex-wrap items-center justify-between gap-4">
            <div class="flex gap-3 flex-wrap items-center">
                <div class="relative">
                    <input wire:model.live.debounce.300ms="search" class="form-input flex w-full min-w-[240px] border-none bg-[#f3e7e7] dark:bg-[#3d2525] text-[#1b0d0d] dark:text-[#fcf8f8] focus:ring-0 h-10 placeholder:text-[#9a4c4c] px-10 rounded-lg text-sm font-normal" placeholder="Search sections..." />
                    <span class="material-symbols-outlined absolute left-3 top-2.5 text-[#9a4c4c] text-xl">search</span>
                </div>
                
                <div class="h-10 w-[1px] bg-[#f3e7e7] dark:bg-[#3d2525] mx-2"></div>

                <div class="flex gap-2">
                    <select wire:model.live="activeGrade" class="bg-[#f3e7e7] dark:bg-[#3d2525] border-none rounded-lg text-xs font-bold text-[#1b0d0d] dark:text-[#fcf8f8] focus:ring-primary h-10 px-4">
                        <option value="All">All Grades</option>
                        @foreach(['Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'] as $grade)
                            <option value="{{ $grade }}">{{ $grade }}</option>
                        @endforeach
                    </select>

                    <select wire:model.live="activeStrand" class="bg-[#f3e7e7] dark:bg-[#3d2525] border-none rounded-lg text-xs font-bold text-[#1b0d0d] dark:text-[#fcf8f8] focus:ring-primary h-10 px-4">
                        <option value="All">All Strands</option>
                        @foreach(['STEM', 'ICT', 'HUMSS', 'ABM', 'HE', 'Industrial Arts'] as $strand)
                            <option value="{{ $strand }}">{{ $strand }}</option>
                        @endforeach
                    </select>

                    <select wire:model.live="activeCourse" class="bg-[#f3e7e7] dark:bg-[#3d2525] border-none rounded-lg text-xs font-bold text-[#1b0d0d] dark:text-[#fcf8f8] focus:ring-primary h-10 px-4">
                        <option value="All">All TVL Courses</option>
                        @foreach(['ICT', 'CSS', 'Food Industry', 'Automotive', 'Drafting', 'SMAW', 'HE'] as $course)
                            <option value="{{ $course }}">{{ $course }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Section Grid -->
        <div class="mx-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pb-20">
            @forelse($sections as $section)
            <div class="bg-white dark:bg-[#2c1818] rounded-xl overflow-hidden border border-[#f3e7e7] dark:border-[#3d2525] flex flex-col shadow-sm hover:shadow-md transition-shadow">
                <div class="h-32 bg-primary/10 relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#d41111 2px, transparent 2px); background-size: 20px 20px;"></div>
                    <div class="absolute bottom-4 left-4">
                        <span class="bg-primary text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider mb-1 inline-block">
                            {{ $section->grade_level }} {{ $section->strand ? '• ' . $section->strand : '' }}
                            @if($section->is_star_section)
                                <span class="ml-1 bg-yellow-400 text-black px-1 rounded">STAR</span>
                            @endif
                        </span>
                        <hgroup>
                            <h3 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-xl font-bold">{{ $section->name }}</h3>
                            @if($section->specialization)
                                <p class="text-[10px] text-primary/70 font-bold uppercase">{{ $section->specialization }}</p>
                            @endif
                        </hgroup>
                    </div>
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
                                <p class="text-sm font-semibold">{{ $section->room ?: 'TBA' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center text-xs">
                            <span class="font-medium text-[#9a4c4c]">Enrollment Capacity</span>
                            @php
                                $currentCount = $section->track === 'TVL' ? $section->tech_voc_enrollments_count : $section->enrollments_count;
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
                    <a href="{{ route('admin.sections.students', $section->id) }}" class="h-9 flex items-center justify-center rounded-lg bg-primary text-white text-xs font-bold hover:opacity-90 transition-opacity">
                        Manage Section
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full py-20 text-center">
                <span class="material-symbols-outlined text-6xl text-[#f3e7e7]">inventory_2</span>
                <p class="text-[#9a4c4c] mt-4 font-bold">No sections found matching your search.</p>
            </div>
            @endforelse

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
        </div>

        <!-- Auto Sectioning Modal -->
        @if($showAutoSectionModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" wire:click="$set('showAutoSectionModal', false)"></div>
            <div class="bg-white dark:bg-[#2c1818] rounded-3xl w-full max-w-2xl relative z-10 overflow-hidden shadow-2xl flex flex-col max-h-[90vh]">
                <div class="p-8 border-b border-[#f3e7e7] dark:border-[#3d2525] flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-black text-gray-900 dark:text-white flex items-center gap-2">
                            <span class="material-symbols-outlined text-green-600">auto_fix_high</span>
                            Auto-Sectioning Engine
                        </h2>
                        <p class="text-sm text-[#9a4c4c] dark:text-[#c08282] mt-1">Automatically distribute unsectioned students based on performance, track, and capacity constraints.</p>
                    </div>
                    <button wire:click="$set('showAutoSectionModal', false)" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="flex border-b border-[#f3e7e7] dark:border-[#3d2525] bg-gray-50/50 dark:bg-black/20">
                    <button wire:click="$set('activeAutoTab', 'jhs')" class="flex-1 py-4 text-sm font-bold text-center border-b-2 transition-colors {{ $activeAutoTab === 'jhs' ? 'border-primary text-primary bg-white dark:bg-[#2c1818]' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                        High School (7-10)
                    </button>
                    <button wire:click="$set('activeAutoTab', 'tvl')" class="flex-1 py-4 text-sm font-bold text-center border-b-2 transition-colors {{ $activeAutoTab === 'tvl' ? 'border-primary text-primary bg-white dark:bg-[#2c1818]' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                        Tech Voc (8-10)
                    </button>
                    <button wire:click="$set('activeAutoTab', 'shs')" class="flex-1 py-4 text-sm font-bold text-center border-b-2 transition-colors {{ $activeAutoTab === 'shs' ? 'border-primary text-primary bg-white dark:bg-[#2c1818]' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                        Senior High (11-12)
                    </button>
                </div>

                <div class="p-8 overflow-y-auto">
                    <div class="space-y-6">
                        @if($activeAutoTab === 'jhs')
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Select Grade Level</label>
                                <select wire:model.live="autoGrade" class="w-full rounded-xl border-[#f3e7e7] focus:ring-primary h-12 text-sm bg-gray-50">
                                    <option value="All">All JHS Grades</option>
                                    @foreach(['Grade 7', 'Grade 8', 'Grade 9', 'Grade 10'] as $grade)
                                        <option value="{{ $grade }}">{{ $grade }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @elseif($activeAutoTab === 'tvl')
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Grade Level</label>
                                    <select wire:model.live="autoGrade" class="w-full rounded-xl border-[#f3e7e7] focus:ring-primary h-12 text-sm bg-gray-50">
                                        <option value="All">All Grades</option>
                                        @foreach(['Grade 8', 'Grade 9', 'Grade 10'] as $grade)
                                            <option value="{{ $grade }}">{{ $grade }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Tech Voc Course</label>
                                    <select wire:model.live="autoCourseStrand" class="w-full rounded-xl border-[#f3e7e7] focus:ring-primary h-12 text-sm bg-gray-50">
                                        <option value="All">All Courses</option>
                                        @foreach(['ICT', 'CSS', 'Food Industry', 'Automotive', 'Drafting', 'SMAW', 'HE'] as $course)
                                            <option value="{{ $course }}">{{ $course }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @elseif($activeAutoTab === 'shs')
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Grade Level</label>
                                    <select wire:model.live="autoGrade" class="w-full rounded-xl border-[#f3e7e7] focus:ring-primary h-12 text-sm bg-gray-50">
                                        <option value="All">All SHS Grades</option>
                                        <option value="Grade 11">Grade 11</option>
                                        <option value="Grade 12">Grade 12</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Strand</label>
                                    <select wire:model.live="autoCourseStrand" class="w-full rounded-xl border-[#f3e7e7] focus:ring-primary h-12 text-sm bg-gray-50">
                                        <option value="All">All Strands</option>
                                        @foreach(['STEM', 'ICT', 'HUMSS', 'ABM', 'HE', 'Industrial Arts'] as $strand)
                                            <option value="{{ $strand }}">{{ $strand }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                        <div class="bg-primary/5 border border-primary/20 rounded-2xl p-6 text-center">
                            <p class="text-sm text-gray-600 font-bold mb-2">Unsectioned Students Found</p>
                            <div class="text-5xl font-black text-primary mb-3">{{ $this->unsectionedStats['total'] }}</div>
                            <div class="flex justify-center gap-6 text-sm font-semibold text-gray-500">
                                <span class="flex items-center gap-1"><span class="material-symbols-outlined text-blue-500 text-lg">male</span> {{ $this->unsectionedStats['male'] }} Male</span>
                                <span class="flex items-center gap-1"><span class="material-symbols-outlined text-pink-500 text-lg">female</span> {{ $this->unsectionedStats['female'] }} Female</span>
                            </div>
                        </div>

                        <div class="bg-yellow-50 text-yellow-800 p-4 rounded-xl text-xs flex gap-3 border border-yellow-200">
                            <span class="material-symbols-outlined text-yellow-600 shrink-0">info</span>
                            <p><strong>Note:</strong> The algorithm will first fill designated Star Sections (GWA 90+) based on merit, followed by gender-balanced round-robin allocation for regular sections. Ensure you have created sufficient sections before running.</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-[#f3e7e7] dark:border-[#3d2525] flex justify-end gap-3 bg-gray-50/50 dark:bg-black/20">
                    <button wire:click="$set('showAutoSectionModal', false)" class="px-6 py-3 rounded-xl font-bold text-gray-500 hover:bg-gray-100 transition-colors">Cancel</button>
                    <button wire:click="runAutoSectioning" class="px-8 py-3 bg-green-600 text-white rounded-xl font-black shadow-lg shadow-green-600/30 hover:opacity-90 transition-all flex items-center gap-2" {{ $this->unsectionedStats['total'] == 0 ? 'disabled' : '' }} @disabled($this->unsectionedStats['total'] == 0)>
                        <span wire:loading wire:target="runAutoSectioning" class="size-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                        Execute Sectioning
                    </button>
                </div>
            </div>
        </div>
        @endif

        @if($showCreateModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" wire:click="$set('showCreateModal', false)"></div>
            <div class="bg-white dark:bg-[#2c1818] rounded-3xl w-full max-w-md relative z-10 overflow-hidden shadow-2xl">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-black text-gray-900 dark:text-white">New Section</h2>
                        <button wire:click="$set('showCreateModal', false)" class="text-gray-400 hover:text-gray-600">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                    
                    <form wire:submit.prevent="createSection" class="space-y-4">
                        <div class="flex gap-2 p-1 bg-gray-100 rounded-xl mb-4">
                            <button type="button" wire:click="setNewSectionType('normal')" class="flex-1 py-2 text-sm font-bold rounded-lg transition-colors {{ $newSection['type'] === 'normal' ? 'bg-white shadow text-primary' : 'text-gray-500 hover:text-gray-700' }}">Normal Section</button>
                            <button type="button" wire:click="setNewSectionType('tvl')" class="flex-1 py-2 text-sm font-bold rounded-lg transition-colors {{ $newSection['type'] === 'tvl' ? 'bg-white shadow text-primary' : 'text-gray-500 hover:text-gray-700' }}">TechVoc Section</button>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Section Name</label>
                            @if(($newSection['type'] === 'tvl') || ($newSection['type'] === 'normal' && in_array($newSection['grade_level'], ['Grade 11', 'Grade 12'])))
                                <input type="text" readonly value="{{ $newSection['name'] }}" class="w-full rounded-xl border-[#f3e7e7] bg-gray-100 text-gray-600 px-4 py-3 text-sm cursor-not-allowed font-bold" placeholder="Auto-generated (e.g. G-8 - CSS-A)" />
                            @else
                                <input wire:model.defer="newSection.name" type="text" placeholder="e.g. Sampaguita, Newton" class="w-full rounded-xl border-[#f3e7e7] focus:ring-primary focus:border-primary px-4 py-3 text-sm" />
                            @endif
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Grade Level</label>
                                <select wire:model.live="newSection.grade_level" class="w-full rounded-xl border-[#f3e7e7] focus:ring-primary h-12 text-sm">
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
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Capacity</label>
                                <input wire:model.defer="newSection.capacity" type="number" class="w-full rounded-xl border-[#f3e7e7] focus:ring-primary h-12 text-sm px-4" />
                            </div>
                        </div>

                        @if($newSection['type'] === 'normal' && in_array($newSection['grade_level'], ['Grade 11', 'Grade 12']))
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Strand</label>
                                <select wire:model.live="newSection.strand" class="w-full rounded-xl border-[#f3e7e7] focus:ring-primary h-12 text-sm">
                                    <option value="">Select Strand...</option>
                                    @foreach(['STEM', 'ICT', 'HUMSS', 'ABM', 'HE', 'Industrial Arts'] as $strand)
                                        <option value="{{ $strand }}">{{ $strand }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        @if($newSection['type'] === 'tvl')
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">TechVoc Course</label>
                                <select wire:model.live="newSection.specialization" class="w-full rounded-xl border-[#f3e7e7] focus:ring-primary h-12 text-sm">
                                    <option value="">Select Course...</option>
                                    @foreach(['ICT', 'CSS', 'Food Industry', 'Automotive', 'Drafting', 'SMAW', 'HE'] as $course)
                                        <option value="{{ $course }}">{{ $course }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        @if($newSection['type'] === 'normal' && !in_array($newSection['grade_level'], ['Grade 11', 'Grade 12']))
                        <div class="flex items-center gap-3 bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <input type="checkbox" wire:model.defer="newSection.is_star_section" id="star_section" class="size-5 rounded text-primary focus:ring-primary" />
                            <label for="star_section" class="text-sm font-bold text-gray-700">Set as Star Section (Academically Selective)</label>
                        </div>
                        @endif

                        <button type="submit" class="w-full bg-primary text-white py-4 rounded-2xl font-black text-lg shadow-xl shadow-primary/30 hover:opacity-90 transition-all mt-4">
                            Confirm Creation
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif

        <!-- Assign Adviser Modal -->
        @if($showAdviserModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" wire:click="$set('showAdviserModal', false)"></div>
            <div class="bg-white dark:bg-[#2c1818] rounded-3xl w-full max-w-md relative z-10 overflow-hidden shadow-2xl">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Assign Adviser</h2>
                            <p class="text-xs text-[#9a4c4c] font-bold uppercase">Section: {{ $currentSectionName }}</p>
                        </div>
                        <button wire:click="$set('showAdviserModal', false)" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                    
                    <form wire:submit.prevent="assignAdviser" class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black text-[#9a4c4c] uppercase tracking-widest mb-2">Select Faculty Member</label>
                            <select wire:model="selectedAdviserId" class="w-full rounded-xl border-[#f3e7e7] dark:border-[#3d2525] bg-[#fdfafb] dark:bg-[#3d2424] focus:ring-primary focus:border-primary h-14 text-sm font-bold px-4">
                                <option value="">Choose a teacher...</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                            @error('selectedAdviserId') <span class="text-[10px] text-red-500 font-bold uppercase mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="w-full bg-primary text-white py-4 rounded-2xl font-black text-base shadow-xl shadow-primary/30 hover:scale-[1.02] transition-transform flex items-center justify-center gap-2">
                            <span wire:loading wire:target="assignAdviser" class="size-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                            Save Assignment
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
