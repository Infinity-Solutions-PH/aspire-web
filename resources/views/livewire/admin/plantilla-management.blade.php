<div>
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

    @if (session()->has('error'))
        <div x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 5000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-[-10px]"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-[-10px]"
             class="mb-6 p-4 bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-800/30 rounded-2xl flex items-center justify-between text-red-800 dark:text-red-400 shadow-sm shadow-red-100/10">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-red-600 dark:text-red-400">error</span>
                <span class="text-sm font-semibold">{{ session('error') }}</span>
            </div>
            <button @click="show = false" class="text-red-500 hover:text-red-700 dark:hover:text-red-300 transition-colors">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
    @endif

    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <div class="size-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                <span class="material-symbols-outlined">receipt_long</span>
            </div>
            <div>
                <h1 class="text-2xl font-black text-[#1b0d0d] dark:text-white tracking-tight">Plantilla Positions</h1>
                <p class="text-sm text-[#9a4c4c] dark:text-white/60">Manage authorized DepEd positions and track vacancies</p>
            </div>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 my-8">
        <!-- Card 1: Total -->
        <div class="p-4 bg-white dark:bg-[#2a1515] rounded-xl border border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center gap-3 shadow-sm">
            <div class="size-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-xl">groups</span>
            </div>
            <div>
                <p class="text-[#9a4c4c] dark:text-white/60 text-xs font-semibold uppercase tracking-wider">Total Plantillas</p>
                <p class="text-xl font-black text-[#1b0d0d] dark:text-white tracking-tight">{{ $stats['total'] }}</p>
            </div>
        </div>

        <!-- Card 2: Assigned -->
        <div class="p-4 bg-white dark:bg-[#2a1515] rounded-xl border border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center gap-3 shadow-sm">
            <div class="size-10 rounded-lg bg-green-50 dark:bg-green-950/30 text-green-600 dark:text-green-400 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-xl">check_circle</span>
            </div>
            <div>
                <p class="text-[#9a4c4c] dark:text-white/60 text-xs font-semibold uppercase tracking-wider">Assigned</p>
                <p class="text-xl font-black text-[#1b0d0d] dark:text-white tracking-tight">{{ $stats['assigned'] }}</p>
            </div>
        </div>

        <!-- Card 3: Vacancies -->
        <div class="p-4 bg-white dark:bg-[#2a1515] rounded-xl border border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center gap-3 shadow-sm border-dashed border-gray-300 dark:border-red-950/40 cursor-pointer hover:bg-gray-50 transition-colors" wire:click="$set('status', 'vacant')">
            <div class="size-10 rounded-lg bg-gray-50 dark:bg-gray-900/30 text-gray-500 dark:text-gray-400 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-xl">contact_support</span>
            </div>
            <div>
                <p class="text-[#9a4c4c] dark:text-white/60 text-xs font-semibold uppercase tracking-wider">Vacant Slots</p>
                <p class="text-xl font-black text-gray-700 dark:text-gray-300 tracking-tight">{{ $stats['vacancies'] }}</p>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="flex flex-wrap items-center gap-3 mb-6 bg-white dark:bg-[#2a1515] p-3 rounded-xl border border-[#f3e7e7] dark:border-[#3a1f1f]">
        <div class="flex-1 min-w-[250px] relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#9a4c4c] text-xl">search</span>
            <input wire:model.live="search" type="text" placeholder="Search Plantilla Number..." class="w-full pl-10 pr-4 py-2 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-lg text-sm focus:ring-primary focus:border-primary transition-all">
        </div>

        <!-- Position Filter -->
        <select wire:model.live="position_id" class="px-4 py-2 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-lg text-sm focus:ring-primary">
            <option value="">All Positions</option>
            @foreach($positions as $p)
                <option value="{{ $p->id }}">{{ $p->name }}</option>
            @endforeach
        </select>

        <!-- Status Filter -->
        <select wire:model.live="status" class="px-4 py-2 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-lg text-sm focus:ring-primary">
            <option value="">All Statuses</option>
            <option value="assigned">Assigned</option>
            <option value="vacant">Vacant</option>
        </select>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-[#2a1515] rounded-2xl border border-[#f3e7e7] dark:border-[#3a1f1f] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-[#fdfafb] dark:bg-[#361a1a] border-b border-[#f3e7e7] dark:border-[#3a1f1f]">
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Plantilla Number</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Position</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Status</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Current Assignee</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c] text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f3e7e7] dark:divide-[#3a1f1f]">
                    @forelse($plantillas as $plantilla)
                        @php
                            $activeFaculty = $plantilla->faculty && in_array($plantilla->faculty->status, ['Active', 'On Leave']) ? $plantilla->faculty : null;
                        @endphp
                        <tr class="hover:bg-primary/[0.02] dark:hover:bg-white/[0.02] transition-colors group">
                            <!-- Plantilla Number -->
                            <td class="px-6 py-4">
                                <span class="text-xs font-mono font-bold text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-900/30 px-2 py-1 rounded">
                                    {{ $plantilla->plantilla_number }}
                                </span>
                            </td>
                            <!-- Position -->
                            <td class="px-6 py-4">
                                <span class="text-xs font-semibold text-primary">
                                    {{ $plantilla->position->name }}
                                </span>
                            </td>
                            <!-- Status -->
                            <td class="px-6 py-4">
                                @if($activeFaculty)
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-green-100 text-green-700 dark:bg-green-950/30 dark:text-green-400">
                                        Assigned
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-400">
                                        Vacant
                                    </span>
                                @endif
                            </td>
                            <!-- Assignee -->
                            <td class="px-6 py-4">
                                @if($activeFaculty)
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-[#1b0d0d] dark:text-white">{{ $activeFaculty->user->name ?? 'Unknown' }}</span>
                                        <span class="text-[10px] text-[#9a4c4c] dark:text-white/40">Faculty ID: {{ $activeFaculty->faculty_id }}</span>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 italic">No Assignee</span>
                                @endif
                            </td>
                            <!-- Actions -->
                            <td class="px-6 py-4 text-center">
                                @if(!$activeFaculty)
                                    <button wire:click="deletePlantilla({{ $plantilla->id }})" wire:confirm="Are you sure you want to delete this vacant plantilla position?" class="p-1.5 text-red-600 hover:bg-red-50 dark:hover:bg-red-950/20 rounded transition-colors group/btn" title="Delete Plantilla">
                                        <span class="material-symbols-outlined text-lg group-hover/btn:scale-110 transition-transform">delete</span>
                                    </button>
                                @else
                                    <span class="text-xs text-gray-400 italic font-medium">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">No plantilla items found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($plantillas->hasPages())
            <div class="px-6 py-4 border-t border-[#f3e7e7] dark:border-[#3a1f1f] bg-[#fdfafb] dark:bg-[#361a1a]">
                {{ $plantillas->links() }}
            </div>
        @endif
    </div>
</div>
