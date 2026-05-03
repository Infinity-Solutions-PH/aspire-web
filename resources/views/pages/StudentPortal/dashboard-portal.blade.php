@php
    $adviser = $enrollment->section->adviser ?? null;
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-8">
        <!-- Welcome Section -->
        <div class="relative overflow-hidden bg-primary rounded-3xl p-8 text-white shadow-xl shadow-primary/20">
            <div class="relative z-10">
                <h2 class="text-3xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}!</h2>
                <p class="text-white/80 max-w-md">Your enrollment for SY 2024-2025 is active. Stay focused and keep achieving your goals.</p>
            </div>
            <!-- Decorative Elements -->
            <div class="absolute -right-10 -top-10 size-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -left-10 -bottom-10 size-48 bg-black/10 rounded-full blur-2xl"></div>
            <span class="material-symbols-outlined absolute right-8 bottom-8 text-8xl text-white/10 select-none">auto_awesome</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Basic Profile Information -->
            <section class="bg-white dark:bg-[#2d1818] rounded-2xl border border-[#e7cfcf] dark:border-[#3d2424] p-6 shadow-sm">
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-lg">person</span>
                    Basic Profile
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] text-gray-500 uppercase font-bold tracking-tighter">Full Name</p>
                        <p class="text-base font-bold text-[#1b0d0d] dark:text-white">{{ $enrollment->first_name }} {{ $enrollment->middle_name ? $enrollment->middle_name . ' ' : '' }}{{ $enrollment->last_name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-500 uppercase font-bold tracking-tighter">Learner Reference Number (LRN)</p>
                        <p class="text-base font-bold text-primary">{{ $enrollment->lrn }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-500 uppercase font-bold tracking-tighter">School Category</p>
                        <p class="text-base font-bold text-primary">{{ $enrollment->school_category }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-500 uppercase font-bold tracking-tighter">Grade Level & Strand</p>
                        <p class="text-sm font-bold text-gray-600 dark:text-gray-400">{{ $enrollment->grade_level }}@if($enrollment->strand || $enrollment->specialization) - {{ $enrollment->strand ?: $enrollment->specialization }}@endif</p>
                    </div>
                </div>
            </section>

            <!-- Enrollment & Section Info -->
            <section class="bg-white dark:bg-[#2d1818] rounded-2xl border border-[#e7cfcf] dark:border-[#3d2424] p-6 shadow-sm">
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-lg">school</span>
                    Academic Status
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] text-gray-500 uppercase font-bold tracking-tighter">Current Status</p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="size-2 bg-green-500 rounded-full animate-pulse"></span>
                            <span class="text-sm font-bold text-green-600 uppercase">{{ $enrollment->status }}</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-500 uppercase font-bold tracking-tighter">Current Section</p>
                        <p class="text-base font-bold text-primary">{{ $enrollment->section->name ?? 'Not Assigned' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-500 uppercase font-bold tracking-tighter">Class Adviser</p>
                        <p class="text-base font-bold">{{ $adviser->name ?? 'TBA' }}</p>
                        @if($adviser)
                            <p class="text-[10px] text-gray-400">{{ $adviser->email }}</p>
                        @endif
                    </div>
                </div>
            </section>
        </div>

        <!-- Today's Schedule -->
        <section class="bg-white dark:bg-[#2d1818] rounded-2xl border border-[#e7cfcf] dark:border-[#3d2424] overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-[#e7cfcf] dark:border-[#3d2424] flex items-center justify-between bg-primary/5">
                <h3 class="text-[#1b0d0d] dark:text-white font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">calendar_today</span>
                    Today's Schedule
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($schedules->sortBy('start_time') as $schedule)
                        <div class="flex items-center gap-4 p-4 bg-[#f8f6f6] dark:bg-[#3d2424] rounded-xl border border-[#e7cfcf] dark:border-[#3d2424]">
                            <div class="size-12 bg-white dark:bg-zinc-800 rounded-lg flex items-center justify-center text-primary shadow-sm border border-[#e7cfcf] dark:border-[#3d2424]">
                                <span class="material-symbols-outlined">{{ $schedule->room->type === 'shop' ? 'construction' : 'school' }}</span>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-bold">{{ $schedule->subject->name }}</h4>
                                <p class="text-xs text-gray-500">{{ $schedule->teacher->name }} | {{ $schedule->room->name }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-bold">{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}</p>
                                <p class="text-[10px] text-gray-400">to {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <span class="material-symbols-outlined text-4xl text-gray-200 mb-2">event_busy</span>
                            <p class="text-sm text-gray-500 italic">No classes scheduled for today.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>

    <!-- Sidebar: Virtual ID & Actions -->
    <div class="space-y-8">
        <!-- Virtual ID Card -->
        <div class="relative w-full aspect-[1/1.58] bg-gradient-to-br from-primary to-[#800000] rounded-3xl p-6 text-white shadow-2xl shadow-primary/30 flex flex-col items-center justify-between overflow-hidden group">
            <!-- ID Header -->
            <div class="w-full flex items-center justify-between mb-4 relative z-10">
                <div class="size-12 bg-white rounded-lg p-1">
                    <x-app-logo-image class="size-full" />
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-bold uppercase tracking-tighter opacity-80 leading-none">School Year</p>
                    <p class="text-xs font-bold leading-none mt-1">2024-2025</p>
                </div>
            </div>

            <!-- Student Photo -->
            <div class="relative z-10 size-40 rounded-2xl border-4 border-white/20 overflow-hidden shadow-xl mb-6">
                @if($enrollment->profile_picture)
                    <img src="{{ asset('storage/' . $enrollment->profile_picture) }}" class="size-full object-cover">
                @else
                    <div class="size-full bg-white/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-6xl opacity-20">person</span>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
            </div>

            <!-- Student Name & Info -->
            <div class="w-full text-center relative z-10">
                <h4 class="text-xl font-black uppercase tracking-tight leading-tight mb-1">{{ auth()->user()->name }}</h4>
                <p class="text-primary-container text-xs font-bold bg-white/10 py-1 px-4 rounded-full inline-block border border-white/10 mb-6">LRN: {{ $enrollment->lrn }}</p>
                
                <div class="grid grid-cols-3 gap-2 text-left pt-6 border-t border-white/10 mt-auto">
                    <div class="col-span-1">
                        <p class="text-[8px] uppercase font-bold opacity-60 tracking-widest">Grade</p>
                        <p class="text-xs font-bold leading-none">{{ $enrollment->grade_level }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-[8px] uppercase font-bold opacity-60 tracking-widest">Category</p>
                        <p class="text-xs font-bold leading-none truncate">{{ $enrollment->school_category }}</p>
                    </div>
                    @if($enrollment->strand || $enrollment->specialization)
                    <div class="col-span-3 mt-3 pt-3 border-t border-white/5">
                        <p class="text-[8px] uppercase font-bold opacity-60 tracking-widest">{{ $enrollment->strand ? 'Strand' : 'Specialization' }}</p>
                        <p class="text-xs font-bold leading-none truncate">{{ $enrollment->strand ?: $enrollment->specialization }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Decorative Patterns -->
            <div class="absolute -right-16 -bottom-16 size-48 bg-white/5 rounded-full blur-2xl group-hover:bg-white/10 transition-colors duration-700"></div>
            <div class="absolute top-0 right-0 p-4 opacity-10">
                <span class="material-symbols-outlined text-8xl">verified</span>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-2 bg-gradient-to-r from-yellow-400 via-white/20 to-yellow-400 opacity-30"></div>
        </div>

        <!-- COE Quick Download -->
        <div class="bg-white dark:bg-[#2d1818] rounded-2xl border border-[#e7cfcf] dark:border-[#3d2424] p-6 shadow-sm">
            <h4 class="text-sm font-bold mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-lg">download</span>
                Quick Access
            </h4>
            <div class="space-y-3">
                <a href="{{ route('enrollment.certificate') }}" target="_blank" class="w-full flex items-center justify-center gap-2 bg-[#f8f6f6] dark:bg-[#3d2424] border border-[#e7cfcf] dark:border-[#3d2424] text-[#1b0d0d] dark:text-white py-3 rounded-xl text-sm font-bold hover:bg-primary hover:text-white hover:border-primary transition-all group">
                    <span class="material-symbols-outlined text-lg group-hover:text-white">print</span>
                    View Certificate of Enrollment
                </a>
            </div>
        </div>
    </div>
</div>
