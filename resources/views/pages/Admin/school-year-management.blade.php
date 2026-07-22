@section('page-title', 'School Year Management')

<div>
    <div class="space-y-8">
    
    @if(session()->has('message'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            <span class="font-medium">Success!</span> {{ session('message') }}
        </div>
    @endif

    <!-- Page Heading -->
    <div class="flex flex-wrap justify-between items-center gap-4 mb-8">
        <div class="flex items-center gap-4">
            <div class="size-16 rounded-2xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-3xl">calendar_month</span>
            </div>
            <div class="flex flex-col gap-1">
                <h2 class="text-3xl font-black tracking-tight text-[#1b0d0d] dark:text-[#fcf8f8]">School Year Management</h2>
                <p class="text-[#9a4c4c] dark:text-[#c48d8d] text-base font-medium">Create and manage academic calendars for Tanza National Trade School.</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button wire:click="openModal" class="flex items-center gap-2 px-6 py-2.5 bg-primary hover:bg-primary/90 text-white rounded-lg font-bold text-sm transition-all shadow-lg shadow-primary/20">
                <span class="material-symbols-outlined text-lg">add_circle</span>
                <span>Create New School Year</span>
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="flex flex-col gap-2 rounded-xl p-6 border border-[#e7cfcf] dark:border-[#3d2020] bg-white dark:bg-[#1a0c0c] shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-[#1b0d0d] dark:text-gray-300 text-base font-medium">Total Records</p>
                <span class="material-symbols-outlined text-primary/50">history</span>
            </div>
            <p class="text-[#1b0d0d] dark:text-white tracking-tight text-3xl font-black">{{ $totalRecords }} Years</p>
            <p class="text-xs text-green-600 font-bold">All time records</p>
        </div>

        <div class="flex flex-col gap-2 rounded-xl p-6 border border-[#e7cfcf] dark:border-[#3d2020] bg-white dark:bg-[#1a0c0c] shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-[#1b0d0d] dark:text-gray-300 text-base font-medium">Active Status</p>
                <span class="material-symbols-outlined text-primary/50">toggle_on</span>
            </div>
            <p class="text-[#1b0d0d] dark:text-white tracking-tight text-3xl font-black">{{ $activeYear ? $activeYear->name : 'None' }}</p>
            @if($activeYear && $activeYear->classes_start)
                <p class="text-xs text-primary font-bold">Started {{ $activeYear->classes_start->diffForHumans() }}</p>
            @else
                <p class="text-xs text-gray-500 font-bold">No active classes</p>
            @endif
        </div>

        <div class="flex flex-col gap-2 rounded-xl p-6 border border-[#e7cfcf] dark:border-[#3d2020] bg-white dark:bg-[#1a0c0c] shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-[#1b0d0d] dark:text-gray-300 text-base font-medium">Next Enrollment</p>
                <span class="material-symbols-outlined text-primary/50">event_upcoming</span>
            </div>
            @if($nextUpcoming)
                <p class="text-[#1b0d0d] dark:text-white tracking-tight text-3xl font-black">{{ $nextUpcoming->enrollment_start ? $nextUpcoming->enrollment_start->format('M d, Y') : 'TBA' }}</p>
                <p class="text-xs text-blue-600 font-bold">For SY {{ $nextUpcoming->name }}</p>
            @else
                <p class="text-[#1b0d0d] dark:text-white tracking-tight text-3xl font-black">No upcoming</p>
                <p class="text-xs text-gray-500 font-bold">Please schedule next year</p>
            @endif
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white dark:bg-[#1a0c0c] rounded-xl border border-[#e7cfcf] dark:border-[#3d2020] overflow-hidden shadow-sm">
        <div class="p-6 border-b border-[#e7cfcf] dark:border-[#3d2020] flex items-center justify-between">
            <h3 class="font-bold text-lg">Academic History</h3>
        </div>
        <div class="@container overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-background-light dark:bg-[#221010]">
                        <th class="px-6 py-4 text-[#1b0d0d] dark:text-gray-300 text-xs font-bold uppercase tracking-wider">School Year</th>
                        <th class="px-6 py-4 text-[#1b0d0d] dark:text-gray-300 text-xs font-bold uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-[#1b0d0d] dark:text-gray-300 text-xs font-bold uppercase tracking-wider">Enrollment Period</th>
                        <th class="px-6 py-4 text-[#1b0d0d] dark:text-gray-300 text-xs font-bold uppercase tracking-wider">Classes Start</th>
                        <th class="px-6 py-4 text-[#1b0d0d] dark:text-gray-300 text-xs font-bold uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e7cfcf] dark:divide-[#3d2020]">
                    @forelse($schoolYears as $sy)
                        <tr class="hover:bg-gray-50 dark:hover:bg-[#221010] transition-colors">
                            <td class="px-6 py-6 text-[#1b0d0d] dark:text-white text-sm font-semibold">{{ $sy->name }}</td>
                            <td class="px-6 py-6">
                                @if($sy->status === 'Upcoming')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">Upcoming</span>
                                @elseif($sy->status === 'Active')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">Active</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400">Closed</span>
                                @endif
                            </td>
                            <td class="px-6 py-6 text-[#9a4c4c] dark:text-gray-400 text-sm font-medium">
                                @if($sy->enrollment_start && $sy->enrollment_end)
                                    {{ $sy->enrollment_start->format('M d') }} - {{ $sy->enrollment_end->format('M d, Y') }}
                                @else
                                    Not Set
                                @endif
                            </td>
                            <td class="px-6 py-6 text-[#9a4c4c] dark:text-gray-400 text-sm font-medium">
                                {{ $sy->classes_start ? $sy->classes_start->format('M d, Y') : 'Not Set' }}
                            </td>
                            <td class="px-6 py-6 text-right space-x-3">
                                <button wire:click="openModal(true, {{ $sy->id }})" class="text-primary font-bold text-sm hover:underline">Edit / Configure</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                No school years have been created yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-background-light/50 dark:bg-[#1a0c0c] border-t border-[#e7cfcf] dark:border-[#3d2020]">
            {{ $schoolYears->links() }}
        </div>
    </div>

    <!-- Configuration Alert -->
    <div class="p-6 bg-primary/10 border-l-4 border-primary rounded-lg flex items-start gap-4">
        <span class="material-symbols-outlined text-primary">info</span>
        <div>
            <p class="text-primary font-bold text-sm">Administrative Reminder</p>
            <p class="text-[#1b0d0d] dark:text-gray-300 text-sm mt-1">
                Make sure to set one Academic Year as "Active". This determines which school year data is shown to students and teachers across the portal.
            </p>
        </div>
    </div>

    </div>

    <!-- Modal for Create/Edit -->
    @if($showModal)
    <div class="fixed inset-0 lg:left-64 z-40 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="absolute inset-0 -z-10 transition-opacity bg-black/60 backdrop-blur-sm" wire:click="$set('showModal', false)"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block w-full max-w-2xl overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-[#2a1515] rounded-3xl shadow-2xl relative z-10">
                <!-- Modal Header -->
                <div class="px-8 py-6 border-b border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center justify-between bg-primary/5">
                    <div>
                        <h3 class="text-xl font-black text-primary uppercase tracking-tight">{{ $isEdit ? 'Edit School Year' : 'Create School Year' }}</h3>
                        <p class="text-xs text-[#9a4c4c] dark:text-white/60">{{ $isEdit ? 'Update academic calendar details.' : 'Create a new academic calendar.' }}</p>
                    </div>
                    <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                
                <form wire:submit.prevent="save" class="p-8 space-y-6">
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">School Year Name</label>
                        <input type="text" wire:model="form.name" placeholder="e.g. 2024-2025" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary mt-1">
                        @error('form.name') <span class="text-[10px] text-red-500 font-bold uppercase mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Status</label>
                        <select wire:model="form.status" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary mt-1">
                            <option value="Upcoming">Upcoming</option>
                            <option value="Active">Active</option>
                            <option value="Closed">Closed</option>
                        </select>
                        @error('form.status') <span class="text-[10px] text-red-500 font-bold uppercase mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Enrollment Start</label>
                            <input type="date" wire:model="form.enrollment_start" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary mt-1">
                            @error('form.enrollment_start') <span class="text-[10px] text-red-500 font-bold uppercase mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Enrollment End</label>
                            <input type="date" wire:model="form.enrollment_end" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary mt-1">
                            @error('form.enrollment_end') <span class="text-[10px] text-red-500 font-bold uppercase mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Classes Start Date</label>
                        <input type="date" wire:model="form.classes_start" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary mt-1">
                        @error('form.classes_start') <span class="text-[10px] text-red-500 font-bold uppercase mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-6 mt-6 border-t border-[#f3e7e7] dark:border-[#3a1f1f]">
                        <button type="button" wire:click="$set('showModal', false)" class="px-6 py-2.5 text-sm font-bold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">Cancel</button>
                        <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-primary hover:bg-primary/90 rounded-xl shadow-lg shadow-primary/30 transition-all">
                            Save School Year
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
