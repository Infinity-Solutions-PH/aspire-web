@section('page-title', 'School Year Management')

<main class="flex-1 overflow-y-auto px-4 py-8 lg:px-12 bg-background-light dark:bg-background-dark">
<div class="max-w-6xl mx-auto space-y-8">
    
    @if(session()->has('message'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            <span class="font-medium">Success!</span> {{ session('message') }}
        </div>
    @endif

    <!-- PageHeading -->
    <div class="flex flex-wrap items-center justify-between gap-6">
        <div class="flex min-w-72 flex-col gap-1">
            <p class="text-[#1b0d0d] dark:text-white text-4xl font-black leading-tight tracking-tight">School Year Management</p>
            <p class="text-[#9a4c4c] dark:text-gray-400 text-base font-normal">Create and manage academic calendars for Tanza National Trade School.</p>
        </div>
        <button wire:click="openModal" class="flex min-w-[120px] cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-lg h-12 px-6 bg-primary text-white text-sm font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
            <span class="material-symbols-outlined text-lg">add_circle</span>
            <span class="truncate">Create New School Year</span>
        </button>
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

    <!-- Modal for Create/Edit -->
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div class="bg-white dark:bg-[#2a1515] rounded-3xl w-full max-w-xl overflow-hidden shadow-2xl">
            <div class="p-6 border-b border-[#f3e7e7] dark:border-[#3a1f1f] flex justify-between items-center bg-[#fdfafb] dark:bg-[#3d2424]">
                <h3 class="text-xl font-black text-[#1b0d0d] dark:text-white uppercase tracking-tight">
                    {{ $isEdit ? 'Edit School Year' : 'Create School Year' }}
                </h3>
                <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-primary transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            
            <form wire:submit.prevent="save" class="p-6 space-y-5">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">School Year Name</label>
                    <input type="text" wire:model="form.name" placeholder="e.g. 2024-2025" class="w-full rounded-xl border-[#f3e7e7] focus:ring-primary text-sm h-12">
                    @error('form.name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Status</label>
                    <select wire:model="form.status" class="w-full rounded-xl border-[#f3e7e7] focus:ring-primary text-sm h-12">
                        <option value="Upcoming">Upcoming</option>
                        <option value="Active">Active</option>
                        <option value="Closed">Closed</option>
                    </select>
                    @error('form.status') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Enrollment Start</label>
                        <input type="date" wire:model="form.enrollment_start" class="w-full rounded-xl border-[#f3e7e7] focus:ring-primary text-sm h-12">
                        @error('form.enrollment_start') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Enrollment End</label>
                        <input type="date" wire:model="form.enrollment_end" class="w-full rounded-xl border-[#f3e7e7] focus:ring-primary text-sm h-12">
                        @error('form.enrollment_end') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Classes Start Date</label>
                    <input type="date" wire:model="form.classes_start" class="w-full rounded-xl border-[#f3e7e7] focus:ring-primary text-sm h-12">
                    @error('form.classes_start') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4 flex justify-end gap-3 border-t border-[#f3e7e7] dark:border-[#3a1f1f]">
                    <button type="button" wire:click="$set('showModal', false)" class="px-5 py-2.5 rounded-xl text-gray-600 font-bold hover:bg-gray-100 transition-colors text-sm">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-primary text-white font-bold hover:bg-primary/90 transition-colors shadow-lg shadow-primary/30 text-sm">Save School Year</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
</main>
