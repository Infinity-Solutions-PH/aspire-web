@section('page-title', 'Faculty Management')

<main class="flex-1 px-10 py-4 max-w-[1400px] mx-auto w-full" x-data="{ showModal: @entangle('showModal') }">
    <!-- Breadcrumbs -->
    <!-- <div class="flex flex-wrap gap-2 mb-4">
        <a class="text-[#9a4c4c] dark:text-primary/70 text-sm font-medium leading-normal hover:underline" href="#">School Management</a>
        <span class="text-[#9a4c4c] dark:text-primary/70 text-sm font-medium leading-normal">/</span>
        <span class="text-[#1b0d0d] dark:text-white text-sm font-medium leading-normal">Teacher Management</span>
    </div> -->

    <!-- Page Heading -->
    <div class="flex flex-wrap justify-between items-end gap-4 mb-8">
        <div class="flex flex-col gap-1">
            <h1 class="text-[#d41111] dark:text-primary text-4xl font-black leading-tight tracking-[-0.033em]">Faculty Directory</h1>
            <p class="text-[#9a4c4c] dark:text-white/60 text-base font-normal leading-normal">Manage Tanza National Trade School faculty records, departments, and teaching loads.</p>
        </div>
        <button wire:click="create" class="flex min-w-[180px] cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-lg h-12 px-6 bg-primary text-white text-base font-bold leading-normal shadow-lg shadow-primary/20 hover:scale-[1.02] transition-transform">
            <span class="material-symbols-outlined">person_add</span>
            <span class="truncate">Register New Teacher</span>
        </button>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-10">
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

    <!-- Filters & Search -->
    <div class="flex flex-wrap items-center gap-3 mb-6 bg-white dark:bg-[#2a1515] p-3 rounded-xl border border-[#f3e7e7] dark:border-[#3a1f1f]">
        <div class="flex-1 min-w-[300px] relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#9a4c4c] text-xl">search</span>
            <input wire:model.live="search" type="text" placeholder="Search by name or Teacher ID..." class="w-full pl-10 pr-4 py-2 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-lg text-sm focus:ring-primary focus:border-primary transition-all">
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
            <option value="">All Status</option>
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
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Teacher ID</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Full Name</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Department</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Specialization</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Status</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c] text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f3e7e7] dark:divide-[#3a1f1f]">
                    @forelse($teachers as $teacher)
                        <tr class="hover:bg-primary/[0.02] dark:hover:bg-white/[0.02] transition-colors group">
                            <td class="px-6 py-4">
                                <span class="text-xs font-black text-primary bg-primary/5 px-2 py-1 rounded-md">{{ $teacher->teacher_id }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-[#1b0d0d] dark:text-white">{{ $teacher->user->name }}</span>
                                    <span class="text-[10px] text-[#9a4c4c] dark:text-white/40">{{ $teacher->user->email }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-medium">{{ $teacher->department }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs text-gray-500">{{ $teacher->specialization ?: 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                    {{ $teacher->status === 'Active' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ $teacher->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button wire:click="edit({{ $teacher->id }})" class="p-1.5 hover:bg-primary/10 text-primary rounded transition-colors" title="Edit Profile">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </button>
                                    <button class="p-1.5 hover:bg-primary/10 text-primary rounded transition-colors" title="View Schedule">
                                        <span class="material-symbols-outlined text-lg">calendar_month</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic">No faculty records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-[#f3e7e7] dark:border-[#3a1f1f]">
            {{ $teachers->links() }}
        </div>
    </div>

    <!-- Registration Modal -->
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
                        <p class="text-xs text-[#9a4c4c] dark:text-white/60">{{ $editingId ? 'Update teacher information and record.' : 'Create a new teacher record and system account.' }}</p>
                    </div>
                    <button @click="showModal = false" class="text-gray-400 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <form wire:submit.prevent="save" class="p-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Teacher ID -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Teacher ID / LRN</label>
                            <input wire:model="teacher_id" type="text" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary" placeholder="e.g. 2024-001">
                            @error('teacher_id') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Full Name -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Full Name</label>
                            <input wire:model="name" type="text" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary" placeholder="e.g. Juan Dela Cruz">
                            @error('name') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Official Email</label>
                            <input wire:model="email" type="email" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary" placeholder="e.g. juan@tnts.edu.ph">
                            @error('email') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Department -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Department</label>
                            <select wire:model="form_department" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary">
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
                            <input wire:model="specialization" type="text" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary" placeholder="e.g. Computer Programming">
                        </div>

                        <!-- Employment Status -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Employment Status</label>
                            <select wire:model="form_status" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary">
                                <option value="Active">Active</option>
                                <option value="On Leave">On Leave</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                            @error('form_status') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="pt-6 border-t border-[#f3e7e7] dark:border-[#3a1f1f] flex justify-end gap-3">
                        <button type="button" @click="showModal = false" class="px-6 py-3 rounded-xl text-sm font-bold text-[#9a4c4c] hover:bg-gray-100 transition-colors">Cancel</button>
                        <button type="submit" class="px-8 py-3 bg-primary text-white rounded-xl text-sm font-black shadow-lg shadow-primary/20 hover:scale-[1.02] transition-transform flex items-center gap-2">
                            <span wire:loading wire:target="save" class="size-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                            {{ $editingId ? 'Update Information' : 'Register Teacher' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
