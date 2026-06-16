@section('page-title', 'Student Violations')

<div x-data="{ showCreateModal: @entangle('showCreateModal'), showEditModal: @entangle('showEditModal'), showViewModal: @entangle('showViewModal') }">
    <!-- Page Heading -->
    <div class="flex flex-wrap justify-between items-end gap-4 mb-8">
        <div class="flex flex-col gap-1">
            <h2 class="text-3xl font-black tracking-tight text-[#1b0d0d] dark:text-[#fcf8f8]">Student Violations</h2>
            <p class="text-[#9a4c4c] dark:text-[#c48d8d] text-base font-medium">Record, track, and manage student violation logs and disciplinary reports.</p>
        </div>
        <div class="flex items-center gap-3">
            <button wire:click="openCreateModal" class="flex items-center gap-2 px-6 py-2.5 bg-primary hover:bg-primary/90 text-white rounded-lg font-bold text-sm transition-all shadow-lg shadow-primary/20 hover:scale-[1.02]">
                <span class="material-symbols-outlined text-lg">gavel</span>
                <span>Record Violation</span>
            </button>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 5000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-[-10px]"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-[-10px]"
             class="mb-6 p-4 bg-green-50 dark:bg-green-950/30 border border-green-200 dark:border-green-800/30 rounded-2xl flex items-center justify-between text-green-800 dark:text-green-400 shadow-sm shadow-green-100/10">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-green-600 dark:text-green-400">check_circle</span>
                <span class="text-sm font-semibold">{{ session('message') }}</span>
            </div>
            <button @click="show = false" class="text-green-500 hover:text-green-700 dark:hover:text-green-300 transition-colors">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
    @endif

    <!-- Filters & Search -->
    <div class="bg-white dark:bg-[#1a0c0c] rounded-2xl border border-[#e7cfcf] dark:border-[#422020] p-5 mb-6 shadow-sm">
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-[300px] relative">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-[#9a4c4c]">search</span>
                <input wire:model.live.debounce.300ms="search" class="w-full pl-12 pr-4 py-3.5 bg-background-light dark:bg-[#2a1515] border-[#e7cfcf] dark:border-[#422020] rounded-xl focus:ring-primary focus:border-primary text-sm transition-all placeholder:text-gray-400" placeholder="Search by student name, LRN, or violation..." type="text"/>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full sm:w-auto">
                <!-- School Level Filter -->
                <div class="flex items-center justify-between sm:justify-start bg-background-light dark:bg-[#361a1a] rounded-xl px-4 py-1.5 border border-[#e7cfcf] dark:border-[#422020] w-full sm:w-auto">
                    <span class="text-[10px] font-bold text-[#9a4c4c] uppercase mr-3 tracking-wider whitespace-nowrap">School Level</span>
                    <select wire:model.live="schoolLevelFilter" class="bg-transparent border-none focus:ring-0 text-sm font-bold py-1 pl-0 pr-8 text-gray-700 dark:text-gray-200 w-full sm:w-auto text-right sm:text-left">
                        <option value="">All Levels</option>
                        <option value="JHS">Junior High (JHS)</option>
                        <option value="SHS">Senior High (SHS)</option>
                    </select>
                </div>

                <!-- Grade Level Filter -->
                <div class="flex items-center justify-between sm:justify-start bg-background-light dark:bg-[#361a1a] rounded-xl px-4 py-1.5 border border-[#e7cfcf] dark:border-[#422020] w-full sm:w-auto">
                    <span class="text-[10px] font-bold text-[#9a4c4c] uppercase mr-3 tracking-wider whitespace-nowrap">Grade Level</span>
                    <select wire:model.live="gradeLevelFilter" class="bg-transparent border-none focus:ring-0 text-sm font-bold py-1 pl-0 pr-8 text-gray-700 dark:text-gray-200 w-full sm:w-auto text-right sm:text-left">
                        <option value="">All Grades</option>
                        @if(!$schoolLevelFilter || $schoolLevelFilter === 'JHS')
                            <option value="Grade 7">Grade 7</option>
                            <option value="Grade 8">Grade 8</option>
                            <option value="Grade 9">Grade 9</option>
                            <option value="Grade 10">Grade 10</option>
                        @endif
                        @if(!$schoolLevelFilter || $schoolLevelFilter === 'SHS')
                            <option value="Grade 11">Grade 11</option>
                            <option value="Grade 12">Grade 12</option>
                        @endif
                    </select>
                </div>

                <!-- Severity Filter -->
                <div class="flex items-center justify-between sm:justify-start bg-background-light dark:bg-[#361a1a] rounded-xl px-4 py-1.5 border border-[#e7cfcf] dark:border-[#422020] w-full sm:w-auto">
                    <span class="text-[10px] font-bold text-[#9a4c4c] uppercase mr-3 tracking-wider whitespace-nowrap">Severity</span>
                    <select wire:model.live="severityFilter" class="bg-transparent border-none focus:ring-0 text-sm font-bold py-1 pl-0 pr-8 text-gray-700 dark:text-gray-200 w-full sm:w-auto text-right sm:text-left">
                        <option value="">All Severity Levels</option>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap items-center justify-between gap-2 mt-4 pt-4 border-t border-[#f3e7e7] dark:border-[#361a1a]">
            <div class="flex flex-wrap items-center gap-2">
                <button wire:click="$set('severityFilter', '')" class="px-3 py-1 rounded-full text-xs font-medium transition-all {{ $severityFilter === '' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-[#f3e7e7] dark:bg-[#361a1a] text-[#1b0d0d] dark:text-[#fcf8f8] hover:bg-primary/20' }}">All</button>
                <button wire:click="$set('severityFilter', 'Low')" class="px-3 py-1 rounded-full text-xs font-medium transition-all {{ $severityFilter === 'Low' ? 'bg-[#1b0d0d] text-white' : 'bg-[#f3e7e7] dark:bg-[#361a1a] text-[#1b0d0d] dark:text-[#fcf8f8] hover:bg-primary/20' }}">Low</button>
                <button wire:click="$set('severityFilter', 'Medium')" class="px-3 py-1 rounded-full text-xs font-medium transition-all {{ $severityFilter === 'Medium' ? 'bg-amber-600 text-white shadow-lg shadow-amber-600/20' : 'bg-[#f3e7e7] dark:bg-[#361a1a] text-[#1b0d0d] dark:text-[#fcf8f8] hover:bg-primary/20' }}">Medium</button>
                <button wire:click="$set('severityFilter', 'High')" class="px-3 py-1 rounded-full text-xs font-medium transition-all {{ $severityFilter === 'High' ? 'bg-red-600 text-white shadow-lg shadow-red-600/20' : 'bg-[#f3e7e7] dark:bg-[#361a1a] text-[#1b0d0d] dark:text-[#fcf8f8] hover:bg-primary/20' }}">High</button>
            </div>
            <div class="text-xs font-bold text-[#9a4c4c] dark:text-[#c48d8d] uppercase tracking-wider">
                Total Logs: <span class="text-sm font-black text-[#1b0d0d] dark:text-[#fcf8f8]">{{ $violations->total() }}</span> reports
            </div>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white dark:bg-[#1a0c0c] rounded-2xl border border-[#e7cfcf] dark:border-[#422020] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-background-light dark:bg-[#2a1515] border-b border-[#e7cfcf] dark:border-[#422020]">
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Date</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Student</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Grade / Section</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Violation Description</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Severity</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Recorded By</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c] text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f3e7e7] dark:divide-[#361a1a]">
                    @forelse($violations as $v)
                    <tr class="hover:bg-background-light/50 dark:hover:bg-[#2a1515]/30 transition-colors group">
                        <td class="px-6 py-4 text-xs font-bold text-gray-600 dark:text-gray-400 font-mono">{{ $v->violation_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="size-9 rounded-xl bg-primary/10 flex items-center justify-center font-black text-xs text-primary border border-primary/20 uppercase">
                                    {{ substr($v->student->name, 0, 2) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-900 dark:text-white leading-none">{{ $v->student->name }}</span>
                                    <span class="text-[10px] text-primary mt-1 font-bold font-mono uppercase tracking-tighter">{{ $v->student->student_id ?: 'NO LRN' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($v->student->enrollment)
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-gray-800 dark:text-gray-200">{{ $v->student->enrollment->grade_level }}</span>
                                    @if($v->student->enrollment->section)
                                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-tight">{{ $v->student->enrollment->section->name }}</span>
                                    @else
                                        <span class="text-[10px] text-gray-300 italic font-semibold">Unassigned</span>
                                    @endif
                                </div>
                            @else
                                <span class="text-xs text-gray-400 italic">No Enrollment</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-800 dark:text-gray-200 max-w-[200px] truncate">{{ $v->title }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wide
                                {{ $v->severity == 'Low' ? 'bg-gray-100 text-gray-700 border border-gray-200' :
                                   ($v->severity == 'Medium' ? 'bg-amber-100 text-amber-700 border border-amber-200' :
                                   'bg-red-100 text-red-700 border border-red-200') }}">
                                {{ $v->severity }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs font-medium text-gray-600 dark:text-gray-400">{{ $v->recorder->name }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-1">
                                <button wire:click="openViewModal({{ $v->id }})" class="p-2 text-[#9a4c4c] hover:bg-primary/10 hover:text-primary rounded-xl transition-all" title="View Report">
                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                </button>
                                <button wire:click="openEditModal({{ $v->id }})" class="p-2 text-[#9a4c4c] hover:bg-primary/10 hover:text-primary rounded-xl transition-all" title="Edit Log">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </button>
                                <button wire:click="deleteViolation({{ $v->id }})" wire:confirm="Are you sure you want to delete this violation record?" class="p-2 text-[#9a4c4c] hover:bg-red-55/10 hover:text-red-600 rounded-xl transition-all" title="Delete Log">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <span class="material-symbols-outlined text-5xl mb-4 opacity-20">gavel</span>
                                <p class="text-sm font-bold uppercase tracking-widest italic opacity-50">No violation records logged</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-background-light/30 dark:bg-white/5 border-t border-[#f3e7e7] dark:border-white/10">
            {{ $violations->links() }}
        </div>
    </div>

    <!-- Create Violation Modal -->
    <div x-show="showCreateModal" class="fixed inset-0 lg:left-64 z-40 overflow-y-auto" x-cloak>
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="absolute inset-0 transition-opacity bg-black/60 backdrop-blur-sm" @click="showCreateModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            
            <div class="inline-block w-full max-w-xl overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-[#1a0c0c] rounded-3xl shadow-2xl border border-[#e7cfcf] dark:border-[#422020]">
                <!-- Modal Header -->
                <div class="px-8 py-6 border-b border-[#e7cfcf] dark:border-[#422020] flex items-center justify-between bg-primary/5">
                    <div>
                        <h3 class="text-xl font-black text-primary uppercase tracking-tight">Record Student Violation</h3>
                        <p class="text-xs text-[#9a4c4c] dark:text-white/60">Log student disobedience, rules violations or misconduct events.</p>
                    </div>
                    <button @click="showCreateModal = false" class="text-gray-400 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <form wire:submit.prevent="saveViolation" class="p-8 space-y-5">
                    <!-- Student Selection Search -->
                    <div class="space-y-1 relative">
                        <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Search Student</label>
                        @if($selectedStudentId)
                            <div class="flex items-center justify-between p-3.5 bg-primary/5 rounded-xl border border-primary text-primary font-bold text-sm">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-lg">person</span>
                                    <span>{{ $selectedStudentName }}</span>
                                </div>
                                <button type="button" wire:click="clearSelectedStudent" class="hover:text-red-700 transition-colors flex items-center">
                                    <span class="material-symbols-outlined text-lg">cancel</span>
                                </button>
                            </div>
                        @else
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-[#9a4c4c]">search</span>
                                <input wire:model.live.debounce.300ms="studentSearch" type="text" placeholder="Type student name or LRN..." class="w-full pl-12 pr-4 py-3 bg-[#fdfafb] dark:bg-[#2a1515] border-[#e7cfcf] dark:border-[#422020] rounded-xl text-sm focus:ring-primary focus:border-primary text-gray-800 dark:text-white">
                            </div>
                            
                            @if(!empty($studentSearchResults))
                                <div class="absolute z-50 w-full left-0 mt-1 bg-white dark:bg-[#1a0c0c] border border-[#e7cfcf] dark:border-[#422020] rounded-xl shadow-lg overflow-hidden divide-y divide-[#f3e7e7] dark:divide-[#361a1a]">
                                    @foreach($studentSearchResults as $s)
                                        <div wire:click="selectStudent({{ $s['id'] }}, '{{ addslashes($s['name']) }}')" class="flex items-center justify-between p-3 hover:bg-primary/5 cursor-pointer transition-colors">
                                            <div class="flex flex-col">
                                                <span class="text-sm font-bold text-gray-800 dark:text-white">{{ $s['name'] }}</span>
                                                <span class="text-[10px] text-gray-400 font-mono">LRN: {{ $s['student_id'] }}</span>
                                            </div>
                                            @if($s['enrollment'])
                                                <span class="text-[10px] font-black uppercase text-primary bg-primary/10 px-2 py-0.5 rounded">{{ $s['enrollment']['grade_level'] }}</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endif
                        <input type="hidden" wire:model="selectedStudentId">
                        @error('selectedStudentId') <span class="text-[10px] text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Title -->
                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Violation Title</label>
                        <input wire:model="title" type="text" placeholder="e.g. Uniform Disobedience, Vandalism, Tardiness" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#2a1515] border-[#e7cfcf] dark:border-[#422020] rounded-xl text-sm focus:ring-primary focus:border-primary text-gray-800 dark:text-white">
                        @error('title') <span class="text-[10px] text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Date & Severity -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Violation Date</label>
                            <input wire:model="violation_date" type="date" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#2a1515] border-[#e7cfcf] dark:border-[#422020] rounded-xl text-sm focus:ring-primary focus:border-primary text-gray-800 dark:text-white">
                            @error('violation_date') <span class="text-[10px] text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Severity</label>
                            <select wire:model="severity" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#2a1515] border-[#e7cfcf] dark:border-[#422020] rounded-xl text-sm focus:ring-primary text-gray-800 dark:text-white">
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                            @error('severity') <span class="text-[10px] text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Incident Details / Full Report</label>
                        <textarea wire:model="details" rows="5" placeholder="Provide complete facts, witness statements, actions taken, or description..." class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#2a1515] border-[#e7cfcf] dark:border-[#422020] rounded-xl text-sm focus:ring-primary focus:border-primary text-gray-800 dark:text-white"></textarea>
                        @error('details') <span class="text-[10px] text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Modal Footer -->
                    <div class="pt-6 border-t border-[#e7cfcf] dark:border-[#422020] flex justify-end gap-3">
                        <button type="button" @click="showCreateModal = false" class="px-6 py-3 rounded-xl text-sm font-bold text-[#9a4c4c] hover:bg-gray-100 dark:hover:bg-white/5 transition-colors">Cancel</button>
                        <button type="submit" class="px-8 py-3 bg-primary text-white rounded-xl text-sm font-black shadow-lg shadow-primary/20 hover:scale-[1.02] transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">save</span>
                            Record Violation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Violation Modal -->
    <div x-show="showEditModal" class="fixed inset-0 lg:left-64 z-40 overflow-y-auto" x-cloak>
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="absolute inset-0 transition-opacity bg-black/60 backdrop-blur-sm" @click="showEditModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            
            <div class="inline-block w-full max-w-xl overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-[#1a0c0c] rounded-3xl shadow-2xl border border-[#e7cfcf] dark:border-[#422020]">
                <!-- Modal Header -->
                <div class="px-8 py-6 border-b border-[#e7cfcf] dark:border-[#422020] flex items-center justify-between bg-primary/5">
                    <div>
                        <h3 class="text-xl font-black text-primary uppercase tracking-tight">Edit Violation Record</h3>
                        <p class="text-xs text-[#9a4c4c] dark:text-white/60">Modify existing violation information.</p>
                    </div>
                    <button @click="showEditModal = false" class="text-gray-400 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <form wire:submit.prevent="updateViolation" class="p-8 space-y-5">
                    <!-- Selected Student Display -->
                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Student</label>
                        <div class="p-3.5 bg-gray-50 dark:bg-white/5 rounded-xl border border-gray-200 dark:border-white/5 text-gray-700 dark:text-gray-300 font-bold text-sm">
                            {{ $selectedStudentName }}
                        </div>
                    </div>

                    <!-- Title -->
                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Violation Title</label>
                        <input wire:model="title" type="text" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#2a1515] border-[#e7cfcf] dark:border-[#422020] rounded-xl text-sm focus:ring-primary focus:border-primary text-gray-800 dark:text-white">
                        @error('title') <span class="text-[10px] text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Date & Severity -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Violation Date</label>
                            <input wire:model="violation_date" type="date" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#2a1515] border-[#e7cfcf] dark:border-[#422020] rounded-xl text-sm focus:ring-primary focus:border-primary text-gray-800 dark:text-white">
                            @error('violation_date') <span class="text-[10px] text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Severity</label>
                            <select wire:model="severity" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#2a1515] border-[#e7cfcf] dark:border-[#422020] rounded-xl text-sm focus:ring-primary text-gray-800 dark:text-white">
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                            @error('severity') <span class="text-[10px] text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Incident Details / Full Report</label>
                        <textarea wire:model="details" rows="5" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#2a1515] border-[#e7cfcf] dark:border-[#422020] rounded-xl text-sm focus:ring-primary focus:border-primary text-gray-800 dark:text-white"></textarea>
                        @error('details') <span class="text-[10px] text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Modal Footer -->
                    <div class="pt-6 border-t border-[#e7cfcf] dark:border-[#422020] flex justify-end gap-3">
                        <button type="button" @click="showEditModal = false" class="px-6 py-3 rounded-xl text-sm font-bold text-[#9a4c4c] hover:bg-gray-100 dark:hover:bg-white/5 transition-colors">Cancel</button>
                        <button type="submit" class="px-8 py-3 bg-primary text-white rounded-xl text-sm font-black shadow-lg shadow-primary/20 hover:scale-[1.02] transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">save</span>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Violation Details Modal -->
    <div x-show="showViewModal" class="fixed inset-0 lg:left-64 z-40 overflow-y-auto" x-cloak>
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="absolute inset-0 transition-opacity bg-black/60 backdrop-blur-sm" @click="showViewModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            
            <div class="inline-block w-full max-w-xl overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-[#1a0c0c] rounded-3xl shadow-2xl border border-[#e7cfcf] dark:border-[#422020]">
                @if($viewingViolation)
                    <!-- Modal Header -->
                    <div class="px-8 py-6 border-b border-[#e7cfcf] dark:border-[#422020] flex items-center justify-between bg-primary/5">
                        <div>
                            <h3 class="text-xl font-black text-primary uppercase tracking-tight">Violation Incident Report</h3>
                            <p class="text-xs text-[#9a4c4c] dark:text-white/60">Full disciplinary details and log history.</p>
                        </div>
                        <button @click="showViewModal = false" class="text-gray-400 hover:text-primary transition-colors">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-8 space-y-6">
                        <div class="flex items-start justify-between gap-4 p-4 bg-background-light dark:bg-white/5 border border-[#e7cfcf] dark:border-white/5 rounded-2xl">
                            <div>
                                <h4 class="text-base font-black text-gray-900 dark:text-white">{{ $viewingViolation->student->name }}</h4>
                                <p class="text-xs text-gray-400 mt-1 uppercase font-bold font-mono">LRN: {{ $viewingViolation->student->student_id ?: 'N/A' }}</p>
                                @if($viewingViolation->student->enrollment)
                                    <p class="text-xs text-[#9a4c4c] dark:text-white/60 mt-1 font-semibold">{{ $viewingViolation->student->enrollment->grade_level }} &middot; {{ $viewingViolation->student->enrollment->section ? $viewingViolation->student->enrollment->section->name : 'Unassigned Section' }}</p>
                                @endif
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wide
                                {{ $viewingViolation->severity == 'Low' ? 'bg-gray-100 text-gray-700 border border-gray-200' :
                                   ($viewingViolation->severity == 'Medium' ? 'bg-amber-100 text-amber-700 border border-amber-200' :
                                   'bg-red-100 text-red-700 border border-red-200') }}">
                                {{ $viewingViolation->severity }} Severity
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h5 class="text-[10px] font-black text-[#9a4c4c] uppercase tracking-widest mb-1">Violation Date</h5>
                                <p class="text-sm font-bold text-gray-800 dark:text-white font-mono">{{ $viewingViolation->violation_date->format('F d, Y') }}</p>
                            </div>
                            <div>
                                <h5 class="text-[10px] font-black text-[#9a4c4c] uppercase tracking-widest mb-1">Recorded By</h5>
                                <p class="text-sm font-bold text-gray-800 dark:text-white">{{ $viewingViolation->recorder->name }}</p>
                            </div>
                        </div>

                        <div>
                            <h5 class="text-[10px] font-black text-[#9a4c4c] uppercase tracking-widest mb-1">Incident Title</h5>
                            <p class="text-sm font-extrabold text-gray-800 dark:text-white">{{ $viewingViolation->title }}</p>
                        </div>

                        <div>
                            <h5 class="text-[10px] font-black text-[#9a4c4c] uppercase tracking-widest mb-2">Detailed Report</h5>
                            <div class="p-5 bg-[#fdfafb] dark:bg-[#2a1515] border border-[#e7cfcf] dark:border-[#422020] rounded-2xl text-sm text-gray-700 dark:text-gray-300 leading-relaxed max-h-[200px] overflow-y-auto whitespace-pre-line">
                                {{ $viewingViolation->details }}
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="pt-6 border-t border-[#e7cfcf] dark:border-[#422020] flex justify-end gap-3">
                            <button type="button" @click="showViewModal = false" class="px-8 py-3 bg-primary text-white rounded-xl text-sm font-black shadow-lg shadow-primary/20 hover:scale-[1.02] transition-all flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">check</span>
                                Close Report
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
