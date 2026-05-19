@section('page-title', 'Faculty Management')

<main class="flex-1 px-10 py-4 max-w-[1400px] mx-auto w-full" x-data="{ showModal: @entangle('showModal'), showDevModal: false, showPasswordModal: @entangle('showPasswordModal') }">
    <!-- Page Heading -->
    <div class="flex flex-wrap justify-between items-end gap-4 mb-8">
        <div class="flex flex-col gap-1">
            <h1 class="text-[#d41111] dark:text-primary text-4xl font-black leading-tight tracking-[-0.033em]">Faculty Directory</h1>
            <p class="text-[#9a4c4c] dark:text-white/60 text-base font-normal leading-normal">Manage Tanza National Trade School faculty records, departments, and teaching loads.</p>
        </div>
        <button wire:click="create" class="flex min-w-[180px] cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-lg h-12 px-6 bg-primary text-white text-base font-bold leading-normal shadow-lg shadow-primary/20 hover:scale-[1.02] transition-transform">
            <span class="material-symbols-outlined">person_add</span>
            <span class="truncate">Register New Faculty</span>
        </button>
    </div>

    <!-- Quick Stats Grid (5 Cards for Premium Detail) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 my-10">
        <!-- Card 1: Total -->
        <div class="p-4 bg-white dark:bg-[#2a1515] rounded-xl border border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center gap-3 shadow-sm">
            <div class="size-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-xl">groups</span>
            </div>
            <div>
                <p class="text-[#9a4c4c] dark:text-white/60 text-xs font-semibold uppercase tracking-wider">Total Faculty</p>
                <p class="text-xl font-black text-[#1b0d0d] dark:text-white tracking-tight">{{ $stats['total'] }}</p>
            </div>
        </div>

        <!-- Card 2: Active -->
        <div class="p-4 bg-white dark:bg-[#2a1515] rounded-xl border border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center gap-3 shadow-sm">
            <div class="size-10 rounded-lg bg-green-50 dark:bg-green-950/30 text-green-600 dark:text-green-400 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-xl">check_circle</span>
            </div>
            <div>
                <p class="text-[#9a4c4c] dark:text-white/60 text-xs font-semibold uppercase tracking-wider">Active</p>
                <p class="text-xl font-black text-[#1b0d0d] dark:text-white tracking-tight">{{ $stats['active'] }}</p>
            </div>
        </div>

        <!-- Card 3: On Leave -->
        <div class="p-4 bg-white dark:bg-[#2a1515] rounded-xl border border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center gap-3 shadow-sm">
            <div class="size-10 rounded-lg bg-amber-50 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-xl">event_busy</span>
            </div>
            <div>
                <p class="text-[#9a4c4c] dark:text-white/60 text-xs font-semibold uppercase tracking-wider">On Leave</p>
                <p class="text-xl font-black text-[#1b0d0d] dark:text-white tracking-tight">{{ $stats['on_leave'] }}</p>
            </div>
        </div>

        <!-- Card 4: Retired -->
        <div class="p-4 bg-white dark:bg-[#2a1515] rounded-xl border border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center gap-3 shadow-sm">
            <div class="size-10 rounded-lg bg-blue-50 dark:bg-blue-950/30 text-blue-600 dark:text-blue-400 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-xl">history</span>
            </div>
            <div>
                <p class="text-[#9a4c4c] dark:text-white/60 text-xs font-semibold uppercase tracking-wider">Retired</p>
                <p class="text-xl font-black text-[#1b0d0d] dark:text-white tracking-tight">{{ $stats['retired'] }}</p>
            </div>
        </div>

        <!-- Card 5: Deceased & Vacant -->
        <div class="p-4 bg-white dark:bg-[#2a1515] rounded-xl border border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center gap-3 shadow-sm">
            <div class="size-10 rounded-lg bg-rose-50 dark:bg-rose-950/30 text-rose-600 dark:text-rose-400 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-xl">person_off</span>
            </div>
            <div>
                <p class="text-[#9a4c4c] dark:text-white/60 text-xs font-semibold uppercase tracking-wider">Other Status</p>
                <p class="text-xl font-black text-[#1b0d0d] dark:text-white tracking-tight">
                    {{ $stats['deceased'] + $stats['vacant'] }}
                    <span class="text-[10px] font-normal text-gray-400 dark:text-white/30">({{ $stats['deceased'] }}D / {{ $stats['vacant'] }}V)</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="flex flex-wrap items-center gap-3 mb-6 bg-white dark:bg-[#2a1515] p-3 rounded-xl border border-[#f3e7e7] dark:border-[#3a1f1f]">
        <div class="flex-1 min-w-[300px] relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#9a4c4c] text-xl">search</span>
            <input wire:model.live="search" type="text" placeholder="Search by name, email, Faculty ID or Plantilla..." class="w-full pl-10 pr-4 py-2 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-lg text-sm focus:ring-primary focus:border-primary transition-all">
        </div>
        <select wire:model.live="department" class="px-4 py-2 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-lg text-sm focus:ring-primary">
            <option value="">All Departments</option>
            <option value="TVE">TVE</option>
            <option value="Academic">Academic</option>
            <option value="MAPEH">MAPEH</option>
            <option value="AP">AP</option>
            <option value="Filipino">Filipino</option>
            <option value="English">English</option>
            <option value="Science">Science</option>
            <option value="Mathematics">Mathematics</option>
        </select>
        <select wire:model.live="status" class="px-4 py-2 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-lg text-sm focus:ring-primary">
            <option value="">All Statuses</option>
            <option value="Active">Active</option>
            <option value="On Leave">On Leave</option>
            <option value="Retired">Retired</option>
            <option value="Deceased">Deceased</option>
            <option value="Vacant">Vacant</option>
        </select>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-[#2a1515] rounded-2xl border border-[#f3e7e7] dark:border-[#3a1f1f] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-[#fdfafb] dark:bg-[#361a1a] border-b border-[#f3e7e7] dark:border-[#3a1f1f]">
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Faculty ID</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Full Name</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Plantilla Item #</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Gender</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Dept / Spec.</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Status</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Dates</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c] text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f3e7e7] dark:divide-[#3a1f1f]">
                    @forelse($faculties as $faculty)
                        <tr class="hover:bg-primary/[0.02] dark:hover:bg-white/[0.02] transition-colors group">
                            <!-- Faculty ID -->
                            <td class="px-6 py-4">
                                <span class="text-xs font-black text-primary bg-primary/5 px-2 py-1 rounded-md">{{ $faculty->faculty_id }}</span>
                            </td>
                            <!-- Full Name -->
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-[#1b0d0d] dark:text-white">{{ $faculty->user->name }}</span>
                                    <span class="text-[10px] text-[#9a4c4c] dark:text-white/40">{{ $faculty->user->email }}</span>
                                </div>
                            </td>
                            <!-- Plantilla Item # -->
                            <td class="px-6 py-4">
                                <span class="text-xs font-mono text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/30 px-2 py-1 rounded">
                                    {{ $faculty->plantilla_item_number ?: 'N/A' }}
                                </span>
                            </td>
                            <!-- Gender -->
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-wide
                                    {{ $faculty->gender === 'Male' ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-950/20 dark:text-indigo-400' : 
                                       ($faculty->gender === 'Female' ? 'bg-pink-50 text-pink-600 dark:bg-pink-950/20 dark:text-pink-400' : 
                                       'bg-slate-50 text-slate-600 dark:bg-slate-900 dark:text-slate-400') }}">
                                    {{ $faculty->gender ?: 'Male' }}
                                </span>
                            </td>
                            <!-- Department & Specialization -->
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-[#1b0d0d] dark:text-white">{{ $faculty->department }}</span>
                                    <span class="text-[10px] text-gray-500 truncate max-w-[150px]">{{ $faculty->specialization ?: 'No Specialization' }}</span>
                                </div>
                            </td>
                            <!-- Status -->
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                    {{ $faculty->status === 'Active' ? 'bg-green-100 text-green-700 dark:bg-green-950/30 dark:text-green-400' : 
                                       ($faculty->status === 'On Leave' ? 'bg-amber-100 text-amber-700 dark:bg-amber-950/30 dark:text-amber-400' : 
                                       ($faculty->status === 'Retired' ? 'bg-blue-100 text-blue-700 dark:bg-blue-950/30 dark:text-blue-400' : 
                                       ($faculty->status === 'Deceased' ? 'bg-rose-100 text-rose-700 dark:bg-rose-950/30 dark:text-rose-400' : 
                                       'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-400'))) }}">
                                    {{ $faculty->status }}
                                </span>
                            </td>
                            <!-- Dates (Resigned / Transfer) -->
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-0.5 text-[10px] text-gray-500">
                                    @if($faculty->resigned_date)
                                        <span class="font-medium text-rose-600 dark:text-rose-400">Resigned: {{ $faculty->resigned_date->format('Y-m-d') }}</span>
                                    @endif
                                    @if($faculty->transfer_date)
                                        <span class="font-medium text-purple-600 dark:text-purple-400">Transferred: {{ $faculty->transfer_date->format('Y-m-d') }}</span>
                                    @endif
                                    @if(!$faculty->resigned_date && !$faculty->transfer_date)
                                        <span class="italic text-gray-400">-</span>
                                    @endif
                                </div>
                            </td>
                            <!-- Actions -->
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button wire:click="edit({{ $faculty->id }})" class="p-1.5 hover:bg-primary/10 text-primary rounded transition-colors" title="Edit Profile">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </button>
                                    <button @click="showDevModal = true" class="p-1.5 hover:bg-primary/10 text-primary rounded transition-colors" title="View Schedule">
                                        <span class="material-symbols-outlined text-lg">calendar_month</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-400 italic">No faculty records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-[#f3e7e7] dark:border-[#3a1f1f]">
            {{ $faculties->links() }}
        </div>
    </div>

    <!-- Registration/Edit Modal -->
    <div x-show="showModal" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-black/60 backdrop-blur-sm" @click="showModal = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block w-full max-w-2xl overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-[#2a1515] rounded-3xl shadow-2xl">
                <!-- Modal Header -->
                <div class="px-8 py-6 border-b border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center justify-between bg-primary/5">
                    <div>
                        <h3 class="text-xl font-black text-primary uppercase tracking-tight">{{ $editingId ? 'Edit Faculty Details' : 'Register New Faculty' }}</h3>
                        <p class="text-xs text-[#9a4c4c] dark:text-white/60">{{ $editingId ? 'Update faculty information and official record.' : 'Create a new faculty record and system account.' }}</p>
                    </div>
                    <button @click="showModal = false" class="text-gray-400 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <form wire:submit.prevent="save" class="p-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Faculty ID -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Faculty ID</label>
                            <input wire:model.live.debounce.250ms="faculty_id" type="text" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary" placeholder="e.g. TNTS-2024-001">
                            @error('faculty_id') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Full Name -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Full Name</label>
                            <input wire:model.live.debounce.250ms="name" type="text" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary" placeholder="e.g. Juan Dela Cruz">
                            @error('name') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Official Email</label>
                            <input wire:model.live.debounce.250ms="email" type="email" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary" placeholder="e.g. juan@tnts.edu.ph">
                            @error('email') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Gender -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Gender</label>
                            <select wire:model.live="gender" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            @error('gender') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Plantilla Item Number -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Plantilla Item Number</label>
                            <input wire:model.live.debounce.250ms="plantilla_item_number" type="text" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary" placeholder="e.g. OSEC-DECSB-TCH1-310001-2021">
                            @error('plantilla_item_number') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Department -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Department</label>
                            <select wire:model.live="form_department" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary">
                                <option value="">Select Department</option>
                                <option value="TVE">TVE</option>
                                <option value="Academic">Academic</option>
                                <option value="MAPEH">MAPEH</option>
                                <option value="AP">AP</option>
                                <option value="Filipino">Filipino</option>
                                <option value="English">English</option>
                                <option value="Science">Science</option>
                                <option value="Mathematics">Mathematics</option>
                            </select>
                            @error('form_department') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Specialization -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Specialization</label>
                            <input wire:model.live.debounce.250ms="specialization" type="text" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary" placeholder="e.g. Computer Programming">
                            @error('specialization') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Employment Status -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Employment Status</label>
                            <select wire:model.live="form_status" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary">
                                <option value="Active">Active</option>
                                <option value="On Leave">On Leave</option>
                                <option value="Retired">Retired</option>
                                <option value="Deceased">Deceased (Decreased)</option>
                                <option value="Vacant">Vacant</option>
                            </select>
                            @error('form_status') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Date Columns Grid (Subtle and Premium collapsible styling) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 rounded-2xl bg-gray-50 dark:bg-[#201010]/30 border border-gray-150 dark:border-red-950/20">
                        <!-- Resigned Date -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-rose-500">Resigned Date</label>
                            <input wire:model.live="resigned_date" type="date" class="w-full px-4 py-3 bg-white dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary">
                            <p class="text-[9px] text-gray-400">Fill in if the faculty member has resigned from service.</p>
                            @error('resigned_date') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Transfer Date -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-purple-500">Date of Transfer (If Transferred Out)</label>
                            <input wire:model.live="transfer_date" type="date" class="w-full px-4 py-3 bg-white dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary">
                            <p class="text-[9px] text-gray-400">Fill in if the faculty member was transferred to another school/agency.</p>
                            @error('transfer_date') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="pt-6 border-t border-[#f3e7e7] dark:border-[#3a1f1f] flex justify-end gap-3">
                        <button type="button" @click="showModal = false" class="px-6 py-3 rounded-xl text-sm font-bold text-[#9a4c4c] hover:bg-gray-100 transition-colors">Cancel</button>
                        <button type="submit" 
                                @if(!$isDirty) disabled @endif
                                class="px-8 py-3 bg-primary text-white rounded-xl text-sm font-black shadow-lg shadow-primary/20 hover:scale-[1.02] transition-transform flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100">
                            <span wire:loading wire:target="save" class="size-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                            {{ $editingId ? 'Update Information' : 'Register Faculty' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Development/Feature Coming Soon Modal -->
    <div x-show="showDevModal" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-black/60 backdrop-blur-sm" @click="showDevModal = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-center align-middle transition-all transform bg-white dark:bg-[#2a1515] rounded-3xl shadow-2xl border-t-4 border-amber-500">
                <!-- Close Button -->
                <div class="flex justify-end">
                    <button @click="showDevModal = false" class="text-gray-400 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="flex flex-col items-center gap-4 py-4">
                    <!-- Pulser Container -->
                    <div class="size-16 rounded-full bg-amber-500/10 text-amber-500 flex items-center justify-center animate-pulse">
                        <span class="material-symbols-outlined text-3xl">construction</span>
                    </div>

                    <h3 class="text-xl font-black text-amber-600 dark:text-amber-500 uppercase tracking-tight mt-2">Feature In Development</h3>
                    
                    <p class="text-sm text-[#9a4c4c] dark:text-white/70 leading-relaxed max-w-xs">
                        We are currently building this schedule viewer tool to integrate real-time teaching loads. This feature will be available in an upcoming update.
                    </p>
                </div>

                <!-- Footer/Action Button -->
                <div class="mt-6">
                    <button @click="showDevModal = false" 
                            class="w-full py-3 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-sm font-black shadow-lg shadow-amber-500/20 transition-all hover:scale-[1.02]">
                        Got it, Thanks!
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Password Confirmation Modal -->
    <div x-show="showPasswordModal" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-black/60 backdrop-blur-sm" @click="showPasswordModal = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-[#2a1515] rounded-3xl shadow-2xl border-t-4 border-primary">
                <!-- Modal Header -->
                <div class="flex items-center justify-between pb-4 border-b border-[#f3e7e7] dark:border-[#3a1f1f] mb-4">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-2xl">shield_lock</span>
                        <h3 class="text-lg font-black text-primary uppercase tracking-tight">Confirm Security Password</h3>
                    </div>
                    <button @click="showPasswordModal = false" class="text-gray-400 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <form wire:submit.prevent="confirmPasswordAndSave" class="space-y-4">
                    <p class="text-xs text-[#9a4c4c] dark:text-white/60 leading-normal">
                        For security, please enter your administrator password to authorize these changes to the faculty directory.
                    </p>
                    
                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Administrator Password</label>
                        <input wire:model="confirmPassword" type="password" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary" placeholder="Enter your password" required>
                        @error('confirmPassword') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <!-- Modal Footer -->
                    <div class="pt-4 border-t border-[#f3e7e7] dark:border-[#3a1f1f] flex justify-end gap-3">
                        <button type="button" @click="showPasswordModal = false" class="px-6 py-2.5 rounded-xl text-xs font-bold text-[#9a4c4c] hover:bg-gray-100 transition-colors">Cancel</button>
                        <button type="submit" class="px-6 py-2.5 bg-primary text-white rounded-xl text-xs font-black shadow-lg shadow-primary/20 hover:scale-[1.02] transition-transform flex items-center gap-2">
                            <span wire:loading wire:target="confirmPasswordAndSave" class="size-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                            Authorize & Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
