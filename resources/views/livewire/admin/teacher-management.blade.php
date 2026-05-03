@section('page-title', 'Faculty Management')

<main class="flex-1 px-10 py-8 max-w-[1400px] mx-auto w-full">
    <!-- Breadcrumbs -->
    <div class="flex flex-wrap gap-2 mb-4">
        <a class="text-[#9a4c4c] dark:text-primary/70 text-sm font-medium leading-normal hover:underline" href="#">School Management</a>
        <span class="text-[#9a4c4c] dark:text-primary/70 text-sm font-medium leading-normal">/</span>
        <span class="text-[#1b0d0d] dark:text-white text-sm font-medium leading-normal">Teacher Management</span>
    </div>

    <!-- Page Heading -->
    <div class="flex flex-wrap justify-between items-end gap-4 mb-8">
        <div class="flex flex-col gap-1">
            <h1 class="text-[#d41111] dark:text-primary text-4xl font-black leading-tight tracking-[-0.033em]">Faculty Directory</h1>
            <p class="text-[#9a4c4c] dark:text-white/60 text-base font-normal leading-normal">Manage Tanza National Trade School faculty records, departments, and teaching loads.</p>
        </div>
        <button class="flex min-w-[180px] cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-lg h-12 px-6 bg-primary text-white text-base font-bold leading-normal shadow-lg shadow-primary/20 hover:scale-[1.02] transition-transform">
            <span class="material-symbols-outlined">person_add</span>
            <span class="truncate">Register New Teacher</span>
        </button>
    </div>

    <!-- Filters & Search -->
    <div class="flex flex-wrap items-center gap-3 mb-6 bg-white dark:bg-[#2a1515] p-3 rounded-xl border border-[#f3e7e7] dark:border-[#3a1f1f]">
        <div class="flex-1 min-w-[300px] relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#9a4c4c] text-xl">search</span>
            <input wire:model.live.debounce.300ms="search" class="w-full pl-10 pr-4 py-2 bg-[#fcf8f8] dark:bg-[#311818] border-[#f3e7e7] dark:border-[#3a1f1f] rounded-lg focus:ring-primary focus:border-primary text-sm transition-all" placeholder="Search by name or Teacher ID..." type="text"/>
        </div>
        
        <div class="flex gap-2">
            <select wire:model.live="department" class="h-10 bg-[#f3e7e7] dark:bg-[#3a1f1f] border-none rounded-lg text-sm font-medium text-[#1b0d0d] dark:text-white px-4 focus:ring-primary">
                <option value="">All Departments</option>
                <option value="TVL">TVL</option>
                <option value="Academics">Academics</option>
                <option value="MAPEH">MAPEH</option>
                <option value="Science">Science</option>
                <option value="Mathematics">Mathematics</option>
                <option value="English">English</option>
                <option value="Filipino">Filipino</option>
                <option value="Senior High">Senior High</option>
            </select>

            <select wire:model.live="status" class="h-10 bg-[#f3e7e7] dark:bg-[#3a1f1f] border-none rounded-lg text-sm font-medium text-[#1b0d0d] dark:text-white px-4 focus:ring-primary">
                <option value="">All Status</option>
                <option value="Active">Active</option>
                <option value="On Leave">On Leave</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>

        <div class="ml-auto flex items-center gap-2 text-sm text-[#9a4c4c] dark:text-white/40 pr-3">
            <span class="material-symbols-outlined text-base">info</span>
            Showing {{ $teachers->total() }} Faculty Members
        </div>
    </div>

    <!-- Faculty Table -->
    <div class="bg-white dark:bg-[#2a1515] rounded-xl border border-[#f3e7e7] dark:border-[#3a1f1f] overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#fcf8f8] dark:bg-[#311818] border-b border-[#f3e7e7] dark:border-[#3a1f1f]">
                        <th class="px-6 py-4 text-[#1b0d0d] dark:text-white text-xs font-bold uppercase tracking-wider">Faculty Member</th>
                        <th class="px-6 py-4 text-[#1b0d0d] dark:text-white text-xs font-bold uppercase tracking-wider">Department</th>
                        <th class="px-6 py-4 text-[#1b0d0d] dark:text-white text-xs font-bold uppercase tracking-wider">Assigned Loads</th>
                        <th class="px-6 py-4 text-[#1b0d0d] dark:text-white text-xs font-bold uppercase tracking-wider text-center">Status</th>
                        <th class="px-6 py-4 text-[#9a4c4c] dark:text-primary text-xs font-bold uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f3e7e7] dark:divide-[#3a1f1f]">
                    @forelse($teachers as $teacher)
                    <tr class="hover:bg-[#fcf8f8] dark:hover:bg-[#311818] transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="size-11 rounded-full border border-[#f3e7e7] dark:border-[#3a1f1f] bg-cover bg-center bg-[#fcf8f8] dark:bg-[#311818] flex items-center justify-center overflow-hidden">
                                    @if($teacher->user->avatar)
                                        <img src="{{ $teacher->user->avatar }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-xs font-black text-primary">{{ $teacher->user->initials() }}</span>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-[#1b0d0d] dark:text-white font-bold leading-tight">{{ $teacher->user->name }}</p>
                                    <p class="text-[#9a4c4c] dark:text-white/60 text-[10px] font-bold uppercase tracking-tighter mt-0.5">ID: {{ $teacher->teacher_id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-black uppercase tracking-wide">
                                {{ $teacher->department }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $sections = $teacher->assignedSections();
                            @endphp
                            <p class="text-[#1b0d0d] dark:text-white/80 text-xs font-medium">
                                @if($sections->count() > 0)
                                    {{ $sections->pluck('name')->implode(', ') }}
                                @else
                                    <span class="text-gray-400 italic">No assigned sections</span>
                                @endif
                            </p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wide
                                {{ $teacher->status == 'Active' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 
                                   ($teacher->status == 'On Leave' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' : 
                                   'bg-gray-100 text-gray-500') }}">
                                {{ $teacher->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button class="p-2 text-[#9a4c4c] hover:bg-primary/10 hover:text-primary rounded-lg transition-colors" title="Edit Profile">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </button>
                                <button class="p-2 text-[#9a4c4c] hover:bg-primary/10 hover:text-primary rounded-lg transition-colors" title="View Schedule">
                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <span class="material-symbols-outlined text-5xl mb-4 opacity-20">person_off</span>
                                <p class="text-sm font-bold uppercase tracking-widest italic opacity-50">No faculty members found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-[#f3e7e7] dark:border-[#3a1f1f] bg-[#fcf8f8] dark:bg-[#311818]">
            {{ $teachers->links() }}
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">
        <div class="p-6 bg-white dark:bg-[#2a1515] rounded-xl border border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center gap-4 shadow-sm">
            <div class="size-12 rounded-lg bg-primary/10 text-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">groups</span>
            </div>
            <div>
                <p class="text-[#9a4c4c] dark:text-white/60 text-sm font-medium">Total Faculty</p>
                <p class="text-2xl font-black text-[#1b0d0d] dark:text-white tracking-tight">{{ $stats['total'] }}</p>
            </div>
        </div>
        <div class="p-6 bg-white dark:bg-[#2a1515] rounded-xl border border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center gap-4 shadow-sm">
            <div class="size-12 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">check_circle</span>
            </div>
            <div>
                <p class="text-[#9a4c4c] dark:text-white/60 text-sm font-medium">Active Teachers</p>
                <p class="text-2xl font-black text-[#1b0d0d] dark:text-white tracking-tight">{{ $stats['active'] }}</p>
            </div>
        </div>
        <div class="p-6 bg-white dark:bg-[#2a1515] rounded-xl border border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center gap-4 shadow-sm">
            <div class="size-12 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">event_busy</span>
            </div>
            <div>
                <p class="text-[#9a4c4c] dark:text-white/60 text-sm font-medium">On Leave</p>
                <p class="text-2xl font-black text-[#1b0d0d] dark:text-white tracking-tight">{{ $stats['on_leave'] }}</p>
            </div>
        </div>
    </div>
</main>
