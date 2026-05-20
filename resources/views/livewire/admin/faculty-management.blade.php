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
             class="mb-8 p-4 bg-green-50 dark:bg-green-950/30 border border-green-200 dark:border-green-800/30 rounded-2xl flex items-center justify-between text-green-800 dark:text-green-400 shadow-sm shadow-green-100/10">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-green-600 dark:text-green-400">check_circle</span>
                <span class="text-sm font-semibold">{{ session('message') }}</span>
            </div>
            <button @click="show = false" class="text-green-500 hover:text-green-700 dark:hover:text-green-300 transition-colors">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
    @endif

    <!-- Quick Stats Grid (4 Cards for Premium Detail) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 my-10">
        <!-- Card 1: Total Positions -->
        <div class="p-4 bg-white dark:bg-[#2a1515] rounded-xl border border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center gap-3 shadow-sm">
            <div class="size-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-xl">groups</span>
            </div>
            <div>
                <p class="text-[#9a4c4c] dark:text-white/60 text-xs font-semibold uppercase tracking-wider">Total Positions</p>
                <p class="text-xl font-black text-[#1b0d0d] dark:text-white tracking-tight">{{ $stats['total_positions'] }}</p>
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

        <!-- Card 3: Other Status (On Leave / Inactive) -->
        <div class="p-4 bg-white dark:bg-[#2a1515] rounded-xl border border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center gap-3 shadow-sm">
            <div class="size-10 rounded-lg bg-amber-50 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-xl">pending_actions</span>
            </div>
            <div>
                <p class="text-[#9a4c4c] dark:text-white/60 text-xs font-semibold uppercase tracking-wider">Other Status</p>
                <p class="text-xl font-black text-[#1b0d0d] dark:text-white tracking-tight">{{ $stats['other_status'] }}</p>
            </div>
        </div>

        <!-- Card 4: Vacant Positions -->
        <a href="{{ route('admin.plantillas', ['status' => 'vacant']) }}" class="p-4 bg-white dark:bg-[#2a1515] rounded-xl border border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center gap-3 shadow-sm border-dashed border-gray-300 dark:border-red-950/40 hover:bg-gray-50 dark:hover:bg-[#3d2424] transition-colors cursor-pointer group block">
            <div class="size-10 rounded-lg bg-gray-50 dark:bg-gray-900/30 text-gray-500 dark:text-gray-400 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-xl">contact_support</span>
            </div>
            <div>
                <p class="text-[#9a4c4c] dark:text-white/60 text-xs font-semibold uppercase tracking-wider">Vacant Slots</p>
                <p class="text-xl font-black text-gray-700 dark:text-gray-300 tracking-tight">{{ $stats['vacancies'] }}</p>
            </div>
        </a>
    </div>

    <!-- Filters & Search -->
    <div class="flex flex-wrap items-center gap-3 mb-6 bg-white dark:bg-[#2a1515] p-3 rounded-xl border border-[#f3e7e7] dark:border-[#3a1f1f]">
        <div class="flex-1 min-w-[250px] relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#9a4c4c] text-xl">search</span>
            <input wire:model.live="search" type="text" placeholder="Search by name, Faculty ID or Plantilla..." class="w-full pl-10 pr-4 py-2 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-lg text-sm focus:ring-primary focus:border-primary transition-all">
        </div>

        <!-- School Branch Filter -->
        <select wire:model.live="branch_id" class="px-4 py-2 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-lg text-sm focus:ring-primary">
            <option value="">All Branches</option>
            @foreach($branches as $b)
                <option value="{{ $b->id }}">{{ $b->name }}</option>
            @endforeach
        </select>

        <!-- Level Filter -->
        <select wire:model.live="level" class="px-4 py-2 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-lg text-sm focus:ring-primary">
            <option value="">All Levels</option>
            <option value="JHS">JHS</option>
            <option value="SHS">SHS</option>
        </select>

        <!-- Dept Filter -->
        <select wire:model.live="department" class="px-4 py-2 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-lg text-sm focus:ring-primary">
            <option value="">All Departments</option>
            @foreach($allDepartments as $dept)
                <option value="{{ $dept->id }}">{{ $dept->name }} ({{ $dept->level }})</option>
            @endforeach
        </select>

        <!-- Position Filter -->
        <select wire:model.live="position_id" class="px-4 py-2 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-lg text-sm focus:ring-primary">
            <option value="">All Positions</option>
            @foreach($positions->groupBy('type') as $type => $group)
                <optgroup label="{{ $type }}">
                    @foreach($group as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>

        <!-- Gender Filter -->
        <select wire:model.live="gender_filter" class="px-4 py-2 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-lg text-sm focus:ring-primary">
            <option value="">All Genders</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>

        <!-- Status Filter -->
        <select wire:model.live="status" class="px-4 py-2 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-lg text-sm focus:ring-primary">
            <option value="">All Statuses</option>
            <option value="Active">Active</option>
            <option value="On Leave">On Leave</option>
            <option value="Inactive">Inactive</option>
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
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Dept / Position</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Branch / Level</th>
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
                                @if($faculty->status === 'Vacant' || !$faculty->user)
                                    <div class="flex flex-col">
                                        <span class="text-sm font-black text-gray-400 italic">Vacant Position</span>
                                        <span class="text-[10px] text-gray-400">Unassigned</span>
                                    </div>
                                @else
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-[#1b0d0d] dark:text-white">{{ $faculty->user->name }}</span>
                                        <span class="text-[10px] text-[#9a4c4c] dark:text-white/40">{{ $faculty->user->email }}</span>
                                    </div>
                                @endif
                            </td>
                            <!-- Plantilla Item # -->
                            <td class="px-6 py-4">
                                <span class="text-xs font-mono text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/30 px-2 py-1 rounded">
                                    {{ $faculty->plantillaPosition?->plantilla_number ?: 'N/A' }}
                                </span>
                            </td>
                            <!-- Gender -->
                            <td class="px-6 py-4">
                                @if($faculty->status === 'Vacant')
                                    <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-wide bg-slate-50 text-slate-600 dark:bg-slate-900 dark:text-slate-400">
                                        N/A
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-wide
                                        {{ $faculty->gender === 'Male' ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-950/20 dark:text-indigo-400' : 
                                           ($faculty->gender === 'Female' ? 'bg-pink-50 text-pink-600 dark:bg-pink-950/20 dark:text-pink-400' : 
                                           'bg-slate-50 text-slate-600 dark:bg-slate-900 dark:text-slate-400') }}">
                                        {{ $faculty->gender ?: 'Male' }}
                                    </span>
                                @endif
                            </td>
                            <!-- Department & Position -->
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-[#1b0d0d] dark:text-white">{{ $faculty->department?->name ?: 'Unassigned' }}</span>
                                    <span class="text-[10px] text-primary font-bold">{{ $faculty->plantillaPosition?->position?->name ?: 'Unassigned' }}</span>
                                </div>
                            </td>
                            <!-- Branch & Level -->
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-[#1b0d0d] dark:text-white">{{ $faculty->branch?->name ?: 'Unassigned' }}</span>
                                    <span class="text-[10px] text-gray-500 font-bold uppercase">{{ $faculty->level }}</span>
                                </div>
                            </td>
                            <!-- Status -->
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                    {{ $faculty->status === 'Active' ? 'bg-green-100 text-green-700 dark:bg-green-950/30 dark:text-green-400' : 
                                       ($faculty->status === 'On Leave' ? 'bg-amber-100 text-amber-700 dark:bg-amber-950/30 dark:text-amber-400' : 
                                       ($faculty->status === 'Inactive' ? 'bg-rose-100 text-rose-700 dark:bg-rose-950/30 dark:text-rose-400' : 
                                       'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-400')) }}">
                                    {{ $faculty->status }}
                                </span>
                            </td>
                            <!-- Dates (Inactive Details) -->
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-0.5 text-[10px] text-gray-500">
                                    @if($faculty->inactive_reason && $faculty->effective_date)
                                        <span class="font-medium {{ $faculty->inactive_reason === 'Transferred' ? 'text-purple-600 dark:text-purple-400' : 'text-rose-600 dark:text-rose-400' }}">
                                            {{ $faculty->inactive_reason }}: {{ $faculty->effective_date->format('Y-m-d') }}
                                        </span>
                                        @if($faculty->inactive_reason === 'Transferred' && $faculty->transfer_school)
                                            <span class="text-[9px] text-gray-400">To: {{ $faculty->transfer_school }}</span>
                                        @endif
                                    @else
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
                            <td colspan="9" class="px-6 py-12 text-center text-gray-400 italic">No faculty records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($faculties->hasPages())
            <div class="px-6 py-4 border-t border-[#f3e7e7] dark:border-[#3a1f1f] bg-[#fdfafb] dark:bg-[#361a1a]">
                {{ $faculties->links() }}
            </div>
        @endif
    </div>

    <!-- Registration / Edit Modal -->
    <div x-show="showModal" class="fixed inset-0 lg:left-64 z-40 overflow-y-auto" x-cloak>
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="absolute inset-0 transition-opacity bg-black/60 backdrop-blur-sm" @click="showModal = false"></div>

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

                        <!-- Full Name (Only show/editable if not vacant) -->
                        <div class="space-y-1 {{ $form_status === 'Vacant' ? 'opacity-40 pointer-events-none' : '' }}">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Full Name</label>
                            <input wire:model.live.debounce.250ms="name" type="text" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary" placeholder="{{ $form_status === 'Vacant' ? 'Unassigned (Vacant)' : 'e.g. Juan Dela Cruz' }}" {{ $form_status === 'Vacant' ? 'disabled' : '' }}>
                            @error('name') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email (Only show/editable if not vacant) -->
                        <div class="space-y-1 {{ $form_status === 'Vacant' ? 'opacity-40 pointer-events-none' : '' }}">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Official Email</label>
                            <input wire:model.live.debounce.250ms="email" type="email" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary" placeholder="{{ $form_status === 'Vacant' ? 'Unassigned (Vacant)' : 'e.g. juan@tnts.edu.ph' }}" {{ $form_status === 'Vacant' ? 'disabled' : '' }}>
                            @error('email') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Gender (Only show/editable if not vacant) -->
                        <div class="space-y-1 {{ $form_status === 'Vacant' ? 'opacity-40 pointer-events-none' : '' }}">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Gender</label>
                            <select wire:model.live="gender" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary" {{ $form_status === 'Vacant' ? 'disabled' : '' }}>
                                <option value="" selected disabled>Choose Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            @error('gender') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Employment Status -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Employment Status</label>
                            <select wire:model.live="form_status" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary">
                                <option value="Active">Active</option>
                                <option value="On Leave">On Leave</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                            @error('form_status') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Plantilla Item Number -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Plantilla Item Number</label>
                            <input wire:model.live.debounce.250ms="plantilla_item_number" type="text" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary" placeholder="e.g. OSEC-DECSB-TCH1-310001-2021">
                            @error('plantilla_item_number') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Position Select -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Position</label>
                            <select wire:model.live="form_position_id" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary">
                                <option value="" selected disabled>Choose Position</option>
                                @foreach($positions->groupBy('type') as $type => $group)
                                    <optgroup label="{{ $type }}">
                                        @foreach($group as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            @error('form_position_id') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Branch Select -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">School Branch</label>
                            <select wire:model.live="form_branch_id" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary">
                                <option value="" selected disabled>Choose School Branch</option>
                                @foreach($branches as $b)
                                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                                @endforeach
                            </select>
                            @error('form_branch_id') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Level Select -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Secondary Level</label>
                            <select wire:model.live="form_level" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary">
                                <option value="" selected disabled>Choose Secondary Level</option>
                                <option value="JHS">Junior High School (JHS)</option>
                                <option value="SHS">Senior High School (SHS)</option>
                            </select>
                            @error('form_level') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Department -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Department</label>
                            <select wire:model.live="form_department_id" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary disabled:opacity-50 disabled:cursor-not-allowed" {{ empty($form_level) ? 'disabled' : '' }}>
                                <option value="" selected disabled>Choose Department</option>
                                @foreach($formDepartments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                            @error('form_department_id') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Inactive Details Section -->
                    @if($form_status === 'Inactive')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 rounded-2xl bg-gray-50 dark:bg-[#201010]/30 border border-gray-150 dark:border-red-950/20">
                            <!-- Inactive Reason -->
                            <div class="space-y-1">
                                <label class="text-[10px] font-black uppercase tracking-widest text-rose-500">Reason for Inactivity <span class="text-red-500">*</span></label>
                                <select wire:model.live="inactive_reason" class="w-full px-4 py-3 bg-white dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary">
                                    <option value="" selected disabled>Choose Reason for Inactivity</option>
                                    <option value="Resigned">Resigned</option>
                                    <option value="Retired">Retired</option>
                                    <option value="Transferred">Transferred</option>
                                </select>
                                @error('inactive_reason') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                            </div>

                            <!-- Effective Date -->
                            <div class="space-y-1">
                                <label class="text-[10px] font-black uppercase tracking-widest text-rose-500">Effective Date <span class="text-red-500">*</span></label>
                                <input wire:model.live="effective_date" type="date" class="w-full px-4 py-3 bg-white dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary">
                                @error('effective_date') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                            </div>

                            <!-- Transfer School (Only for Transferred) -->
                            @if($inactive_reason === 'Transferred')
                                <div class="space-y-1 md:col-span-2">
                                    <label class="text-[10px] font-black uppercase tracking-widest text-purple-500">Transferring School Name (Optional)</label>
                                    <input wire:model.live.debounce.250ms="transfer_school" type="text" class="w-full px-4 py-3 bg-white dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary" placeholder="e.g. Trece Martires City National High School">
                                    @error('transfer_school') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Modal Footer -->
                    <div class="pt-6 border-t border-[#f3e7e7] dark:border-[#3a1f1f] flex justify-end gap-3">
                        <button type="button" @click="showModal = false" class="px-6 py-3 rounded-xl text-sm font-bold text-[#9a4c4c] hover:bg-gray-100 transition-colors">Cancel</button>
                        <button type="submit" 
                                @if(!$isDirty) disabled @endif
                                class="px-8 py-3 bg-primary text-white rounded-xl text-sm font-black shadow-lg shadow-primary/20 hover:scale-[1.02] transition-transform flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100">
                            <span class="material-symbols-outlined text-sm">save</span>
                            {{ $editingId ? 'Update Information' : 'Register Faculty' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Confirm Password Modal -->
    <div x-show="showPasswordModal" class="fixed inset-0 lg:left-64 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="absolute inset-0 transition-opacity bg-black/60 backdrop-blur-sm" @click="showPasswordModal = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block w-full max-w-md overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-[#2a1515] rounded-3xl shadow-2xl">
                <!-- Header -->
                <div class="px-6 py-5 border-b border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center justify-between bg-red-500/5">
                    <div class="flex items-center gap-2 text-[#d41111]">
                        <span class="material-symbols-outlined">security</span>
                        <h3 class="text-lg font-black uppercase tracking-tight">Confirm Action</h3>
                    </div>
                    <button @click="showPasswordModal = false" class="text-gray-400 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <!-- Form -->
                <form wire:submit.prevent="confirmPasswordAndSave" class="p-6 space-y-4">
                    <p class="text-xs text-[#9a4c4c] dark:text-white/60 leading-relaxed">
                        To apply changes to the official faculty record, please input your administrator password to authorize this action.
                    </p>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Administrator Password</label>
                        <input wire:model="confirmPassword" type="password" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary" placeholder="Enter your password">
                        @error('confirmPassword') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <!-- Footer Buttons -->
                    <div class="pt-4 border-t border-[#f3e7e7] dark:border-[#3a1f1f] flex justify-end gap-2">
                        <button type="button" @click="showPasswordModal = false" class="px-4 py-2 rounded-lg text-xs font-bold text-gray-500 hover:bg-gray-100 transition-colors">Cancel</button>
                        <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg text-xs font-black shadow-md hover:scale-[1.02] transition-transform">
                            Authorize & Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Calendar View Feature Under Development Modal -->
    <div x-show="showDevModal" class="fixed inset-0 lg:left-64 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Glassmorphism backdrop -->
            <div class="absolute inset-0 transition-opacity bg-[#1b0d0d]/40 backdrop-blur-md" @click="showDevModal = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block w-full max-w-md overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-[#2a1515] rounded-3xl shadow-2xl border border-[#f3e7e7] dark:border-[#3a1f1f]">
                <!-- Construction Visual Icon -->
                <div class="p-8 text-center bg-gradient-to-b from-amber-500/10 to-transparent flex flex-col items-center justify-center gap-3">
                    <div class="size-16 rounded-full bg-amber-100 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 flex items-center justify-center animate-pulse">
                        <span class="material-symbols-outlined text-4xl">construction</span>
                    </div>
                    <h3 class="text-xl font-black text-amber-800 dark:text-amber-400 uppercase tracking-tight mt-2">Feature Under Development</h3>
                    <p class="text-xs text-amber-700/70 dark:text-amber-400/60 max-w-xs mx-auto leading-relaxed">
                        The faculty teaching loads, scheduling modules, and calendar visualizers are currently under active development.
                    </p>
                </div>

                <!-- Footer button -->
                <div class="p-6 border-t border-[#f3e7e7] dark:border-[#3a1f1f] bg-gray-50/50 dark:bg-black/10 flex justify-center">
                    <button type="button" @click="showDevModal = false" class="px-8 py-3 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-sm font-black shadow-lg shadow-amber-500/20 hover:scale-[1.02] transition-transform">
                        Got it, Thanks!
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>
