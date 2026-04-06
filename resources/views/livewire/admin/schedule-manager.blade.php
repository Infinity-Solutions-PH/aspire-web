<div class="min-h-screen bg-background text-on-surface font-body selection:bg-primary-fixed selection:text-primary">
    <!-- Top Bar -->
    <header class="fixed top-0 right-0 left-64 h-16 bg-[#fff8f6]/80 backdrop-blur-md z-40 flex justify-between items-center px-8 shadow-[0_12px_40px_rgba(38,24,22,0.1)] border-b border-outline-variant/20">
        <div class="flex items-center gap-4">
            <div class="flex flex-col">
                <span class="text-[#570000] font-public-sans tracking-tight font-black text-xl uppercase">Academic Schedules</span>
                <span class="text-[10px] text-primary/60 font-black uppercase tracking-widest leading-none">Registrar Control Console</span>
            </div>
            <span class="bg-surface-container-high px-3 py-1 rounded-full text-[10px] font-black text-primary tracking-tight uppercase border border-primary/10">S.Y. 2024-2025</span>
        </div>
        <div class="flex items-center gap-6">
            <div class="relative">
                <span class="material-symbols-outlined text-[#4c616c] absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none text-lg">search</span>
                <input wire:model.live="search" class="bg-surface-container-low border-outline-variant/20 rounded-lg pl-10 pr-4 py-2 text-xs w-72 focus:ring-2 focus:ring-primary/20 placeholder:text-secondary/50 font-medium" placeholder="Search tracks or sections..." type="text"/>
            </div>
            <div class="flex items-center gap-2">
                <div class="h-8 w-[1px] bg-outline-variant/30 mx-2"></div>
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="text-xs font-black text-on-surface">{{ auth()->user()->name }}</p>
                        <p class="text-[9px] text-secondary font-bold uppercase tracking-tighter">Senior Registrar</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="pt-24 pb-12 px-12">
        @if (session()->has('message'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-6 py-4 rounded-xl flex items-center justify-between">
                <span class="text-sm font-bold uppercase tracking-wide">{{ session('message') }}</span>
                <button @click="$el.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
        @endif

        <!-- Sectioning Insight -->
        <section class="mb-10">
            <div class="flex justify-between items-start">
                <div class="max-w-2xl">
                    <nav class="flex items-center gap-2 text-[10px] font-black text-secondary/60 uppercase tracking-widest mb-4">
                        <a class="hover:text-primary transition-colors" href="#">Master Registry</a>
                        <span class="material-symbols-outlined text-[12px]">chevron_right</span>
                        <span class="text-primary">Curriculum Distribution</span>
                    </nav>
                    <h2 class="font-headline text-5xl font-black text-on-surface tracking-tighter mb-4 leading-none">Archival Precision.</h2>
                    <p class="text-secondary leading-relaxed text-sm font-medium max-w-xl opacity-90">
                        Synchronizing <span class="text-primary font-bold">{{ $sections->sum('enrollments_count') }} enrolled students</span> across TVL and Academic tracks. Real-time laboratory safety thresholds and conflict mitigation active.
                    </p>
                </div>
                <div class="flex gap-4">
                    <div class="bg-surface-container p-5 rounded-xl border-t-4 border-primary shadow-sm flex flex-col min-w-[160px]">
                        <span class="text-[10px] font-black text-secondary uppercase tracking-[0.1em] mb-1">System Load</span>
                        <div class="flex items-end gap-1">
                            <span class="text-3xl font-black text-primary">98.2%</span>
                            <span class="text-[10px] font-bold text-primary mb-1.5 uppercase">Optimized</span>
                        </div>
                    </div>
                    <div class="bg-surface-container-high p-5 rounded-xl border-t-4 border-secondary shadow-sm flex flex-col min-w-[160px]">
                        <span class="text-[10px] font-black text-secondary uppercase tracking-[0.1em] mb-1">Total Sections</span>
                        <div class="flex items-end gap-1">
                            <span class="text-3xl font-black text-secondary">{{ $sections->count() }}</span>
                            <span class="text-[10px] font-bold text-secondary mb-1.5 uppercase">Active</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Track Filters -->
        <div class="flex gap-2 mb-8 overflow-x-auto no-scrollbar pb-2">
            <button wire:click="$set('activeTrack', null)" class="px-6 py-2.5 rounded-full text-[10px] font-black uppercase tracking-widest transition-all {{ is_null($activeTrack) ? 'bg-primary text-on-primary shadow-lg shadow-primary/20' : 'bg-surface-container-high text-secondary hover:bg-surface-container-highest' }}">
                All Tracks
            </button>
            @foreach($tracks as $track)
                <button wire:click="$set('activeTrack', '{{ $track }}')" class="px-6 py-2.5 rounded-full text-[10px] font-black uppercase tracking-widest transition-all {{ $activeTrack === $track ? 'bg-primary text-on-primary shadow-lg shadow-primary/20' : 'bg-surface-container-high text-secondary hover:bg-surface-container-highest' }}">
                    {{ $track }}
                </button>
            @endforeach
        </div>

        <!-- Track Management Grid -->
        <div class="grid grid-cols-12 gap-8 mb-12">
            <!-- Sections Control -->
            <div class="col-span-8 bg-white border border-outline-variant/30 rounded-xl p-8 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4">
                    <span class="text-[10px] font-black text-primary/20 uppercase tracking-[0.2em] select-none">REGISTRY_UNIT_01</span>
                </div>
                <div class="flex justify-between items-center mb-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-secondary-container rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-on-secondary-container">groups</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-on-surface">Active Sections & Capacity</h3>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-[10px] font-black text-secondary uppercase tracking-widest">Load Status:</span>
                                <span class="text-[10px] font-black text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100 uppercase">Operational</span>
                            </div>
                        </div>
                    </div>
                    <button wire:click="recalculateLoad" class="bg-primary text-on-primary text-[10px] font-black px-5 py-2.5 rounded shadow-lg shadow-primary/20 hover:scale-105 transition-all uppercase tracking-widest">
                        Manage Batch Load
                    </button>
                </div>
                <div class="grid grid-cols-3 gap-6">
                    @forelse($sections as $section)
                        @php
                            $percentage = ($section->enrollments_count / max($section->capacity, 1)) * 100;
                            $atCapacity = $section->enrollments_count >= $section->capacity;
                        @endphp
                        <div class="bg-surface-container-lowest p-5 rounded-xl border {{ $atCapacity ? 'border-error/20 ring-1 ring-error/10' : 'border-outline-variant/30 hover:border-primary/40' }} transition-all">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <span class="text-xs font-black text-on-surface">{{ $section->name }}</span>
                                    <p class="text-[9px] text-secondary font-bold">{{ $section->specialization ?: $section->strand ?: $section->track }}</p>
                                </div>
                                <span class="text-[9px] font-black {{ $atCapacity ? 'bg-error/10 text-error border-error/20' : 'bg-primary/10 text-primary border-primary/20' }} px-2 py-1 rounded border flex items-center gap-1">
                                    @if($atCapacity)
                                        <span class="material-symbols-outlined text-[10px] font-black">block</span>
                                        AT CAPACITY
                                    @else
                                        {{ $section->capacity - $section->enrollments_count }} SLOTS OPEN
                                    @endif
                                </span>
                            </div>
                            <div class="space-y-3">
                                <div>
                                    <div class="flex justify-between text-[10px] font-black text-secondary mb-1">
                                        <span>OCCUPANCY</span>
                                        <span class="{{ $atCapacity ? 'text-error' : '' }}">{{ $section->enrollments_count }} / {{ $section->capacity }}</span>
                                    </div>
                                    <div class="h-2 bg-surface-container rounded-full overflow-hidden">
                                        <div class="h-full {{ $percentage >= 90 ? 'bg-error' : ($percentage >= 70 ? 'bg-orange-500' : 'bg-primary') }} transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-xs text-secondary">grade</span>
                                    <span class="text-[10px] font-bold text-on-surface">Grade {{ $section->grade_level }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 py-12 text-center bg-surface-container-low rounded-xl border-2 border-dashed border-outline-variant/30">
                            <span class="material-symbols-outlined text-4xl text-secondary/30 mb-2">search_off</span>
                            <p class="text-secondary text-xs font-bold uppercase tracking-widest">No matching sections found</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Shop Inventory & Capacity Guard -->
            <div class="col-span-4 bg-[#b22b1d] p-8 rounded-xl flex flex-col text-white relative overflow-hidden shadow-2xl border-4 border-white/10">
                <div class="absolute inset-0 opacity-10 mix-blend-soft-light">
                    <!-- Image placeholder for industrial pattern -->
                    <div class="w-full h-full bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-white/20 via-transparent to-transparent"></div>
                </div>
                <div class="relative z-10 flex flex-col h-full">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-white">shield</span>
                        </div>
                        <div>
                            <h3 class="font-black text-lg leading-tight uppercase tracking-tight">Shop Capacity Guard</h3>
                            <p class="text-white/60 text-[9px] font-bold tracking-widest uppercase">Safety Enforcement Active</p>
                        </div>
                    </div>
                    <div class="space-y-4 flex-1">
                        @foreach($rooms->where('type', 'shop') as $room)
                            @php
                                $totalInShop = $room->schedules->sum(fn($s) => $s->section->enrollments_count ?? 0);
                                $occupancy = ($totalInShop / max($room->capacity, 1)) * 100;
                            @endphp
                            <div class="group cursor-pointer">
                                <div class="flex justify-between items-center mb-1.5">
                                    <span class="text-[10px] font-black uppercase tracking-wider text-white/90">{{ $room->name }}</span>
                                    <span class="text-[9px] font-black {{ $occupancy >= 90 ? 'bg-error' : 'bg-white/20' }} text-white px-2 py-0.5 rounded">{{ round($occupancy) }}% CAP</span>
                                </div>
                                <div class="h-1.5 bg-white/10 rounded-full overflow-hidden">
                                    <div class="h-full bg-white transition-all duration-1000" style="width: {{ $occupancy }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="relative mt-8 bg-black/20 p-4 rounded-lg border border-white/10">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-orange-400 text-xl">warning</span>
                            <div>
                                <p class="text-[10px] font-black leading-tight">Critical Shop Overload Policy</p>
                                <p class="text-[9px] text-white/60 mt-0.5">Guidance review required for any section exceeding 1:15 ratio.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- High-Precision Matrix -->
        <section class="bg-[#f2dad7] rounded-xl p-8 border border-[#e2bfb9]">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h4 class="text-2xl font-black text-[#570000] tracking-tighter uppercase">Scholastic Heritage Load Matrix</h4>
                    <p class="text-[#4c616c] text-[10px] font-black uppercase tracking-widest mt-1 opacity-70">Cross-Referencing Academic & TVL Load Cycles</p>
                </div>
                <div class="flex gap-3">
                    <button class="flex items-center gap-2 bg-white/60 border border-outline-variant/40 text-on-surface px-5 py-2.5 rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-white transition-all">
                        <span class="material-symbols-outlined text-sm">print</span>
                        Print Registrar Copy
                    </button>
                    <button wire:click="recalculateLoad" class="flex items-center gap-2 bg-[#570000] text-white px-5 py-2.5 rounded-lg text-[10px] font-black uppercase tracking-widest hover:shadow-xl hover:shadow-primary/30 transition-all">
                        <span class="material-symbols-outlined text-sm">refresh</span>
                        Recalculate Load
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full text-left border-separate border-spacing-y-3">
                    <thead>
                        <tr class="text-[#4c616c] text-[10px] font-black uppercase tracking-[0.2em]">
                            <th class="pb-3 px-6">Schedule Block</th>
                            <th class="pb-3 px-4">Curriculum Component</th>
                            <th class="pb-3 px-4">Location & Asset</th>
                            <th class="pb-3 px-4">Designated Section</th>
                            <th class="pb-3 px-4 text-center">Status Indicators</th>
                        </tr>
                    </thead>
                    <tbody class="space-y-2">
                        @forelse($recentSchedules as $schedule)
                            <tr class="bg-white shadow-sm hover:shadow-md transition-all group">
                                <td class="py-5 px-6 rounded-l-xl border-l-8 border-primary">
                                    <span class="font-black text-on-surface block text-sm">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</span>
                                    <span class="text-[9px] text-primary font-black uppercase tracking-tighter">{{ $schedule->day }} Cycle</span>
                                </td>
                                <td class="py-5 px-4">
                                    <p class="font-black text-on-surface text-sm leading-tight">{{ $schedule->subject->name }}</p>
                                    <p class="text-[10px] text-secondary font-medium">Instr: {{ $schedule->teacher->name }}</p>
                                </td>
                                <td class="py-5 px-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded bg-secondary/10 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-secondary text-lg">{{ $schedule->room->type === 'shop' ? 'construction' : 'meeting_room' }}</span>
                                        </div>
                                        <div>
                                            <span class="text-[10px] font-black block leading-none">{{ $schedule->room->name }}</span>
                                            <span class="text-[9px] text-secondary font-bold uppercase tracking-tighter">{{ ucfirst($schedule->room->type) }} Zone</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-5 px-4">
                                    <span class="text-[10px] font-black px-3 py-1.5 bg-surface-container rounded-md border border-outline-variant/20">{{ $schedule->section->name }}</span>
                                </td>
                                <td class="py-5 px-4 rounded-r-xl">
                                    <div class="flex flex-col items-center gap-1">
                                        <div class="flex items-center gap-1.5 text-secondary-container bg-secondary px-3 py-1 rounded-full border border-secondary/20">
                                            <span class="material-symbols-outlined text-sm" data-icon="check_circle">check_circle</span>
                                            <span class="text-[9px] font-black uppercase">Schedule Cleared</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white/50 border-2 border-dashed border-outline-variant/20">
                                <td colspan="5" class="py-12 text-center">
                                    <span class="material-symbols-outlined text-4xl text-secondary/30 mb-2">event_busy</span>
                                    <p class="text-secondary text-xs font-bold uppercase tracking-widest">No active schedule entries found in current sync cycle</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Insights / System Status -->
        <div class="mt-12 flex gap-8">
            <div class="flex-1 bg-white border border-outline-variant/30 p-8 rounded-xl shadow-sm">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-10 h-10 bg-primary/5 text-primary rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined font-black">analytics</span>
                    </div>
                    <div>
                        <h5 class="text-lg font-black text-on-surface">Guidance Intake Analysis</h5>
                        <p class="text-[10px] text-secondary font-bold uppercase tracking-widest">Enrollment Bottlenecks Identified</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex gap-4 items-start p-4 bg-surface-container-low rounded-lg border-l-4 border-primary">
                        <span class="material-symbols-outlined text-primary text-lg mt-0.5">psychology</span>
                        <div>
                            <p class="text-[11px] font-black text-on-surface leading-normal">Section Re-balancing Suggestion</p>
                            <p class="text-[10px] text-secondary mt-1">TVL tracks identified with uneven student distribution. Registrar recommends a secondary sync before finalized capping.</p>
                            <div class="flex gap-3 mt-3">
                                <button class="text-[9px] font-black text-primary px-3 py-1.5 rounded bg-primary/10 uppercase tracking-widest hover:bg-primary/20 transition-colors" onclick="alert('Reviewing candidates...')">Review Candidates</button>
                                <button class="text-[9px] font-black text-secondary px-3 py-1.5 rounded border border-outline-variant uppercase tracking-widest">Dismiss</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-1/3 bg-[#570000] p-8 rounded-xl text-white relative overflow-hidden shadow-2xl">
                <div class="relative z-10 flex flex-col h-full">
                    <h5 class="text-xl font-black mb-1">Registrar Ledger</h5>
                    <p class="text-white/60 text-[10px] font-bold uppercase tracking-widest mb-8">System Sync Token: #REG-{{ now()->format('Ymd') }}</p>
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between items-end border-b border-white/10 pb-2">
                            <span class="text-[10px] font-bold text-white/70 uppercase">Ready for Sync</span>
                            <span class="text-2xl font-black">{{ $sections->sum('enrollments_count') }}</span>
                        </div>
                        <div class="flex justify-between items-end border-b border-white/10 pb-2">
                            <span class="text-[10px] font-bold text-white/70 uppercase">Asset Conflicts</span>
                            <span class="text-2xl font-black text-[#ffb4a8]">00</span>
                        </div>
                        <div class="flex justify-between items-end border-b border-white/10 pb-2">
                            <span class="text-[10px] font-bold text-white/70 uppercase">Room Utilization</span>
                            <span class="text-2xl font-black">84%</span>
                        </div>
                    </div>
                    <button class="w-full bg-white text-[#570000] py-3 rounded-lg text-[10px] font-black uppercase tracking-[0.2em] shadow-lg hover:scale-[1.02] transition-transform">
                        Finalize Schedule Sync
                    </button>
                </div>
                <div class="absolute -bottom-10 -right-10 opacity-10 rotate-12">
                    <span class="material-symbols-outlined text-[180px]">history_edu</span>
                </div>
            </div>
        </div>
    </main>

    <!-- Global System Trigger -->
    <button wire:click="recalculateLoad" class="fixed bottom-8 right-8 w-16 h-16 bg-primary text-on-primary rounded-2xl shadow-2xl flex items-center justify-center hover:scale-110 active:scale-95 transition-all z-50 border-4 border-white/20">
        <span class="material-symbols-outlined text-3xl font-black">bolt</span>
    </button>
</div>
