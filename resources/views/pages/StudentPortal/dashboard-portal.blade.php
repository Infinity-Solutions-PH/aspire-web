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
        <!-- Virtual ID Card (Redesign) -->
        <div class="relative w-full max-w-[340px] mx-auto aspect-[1/1.6] bg-white rounded-[32px] shadow-2xl overflow-hidden border border-gray-100 group">
            <!-- Red Header with Building Overlay -->
            <div class="absolute top-0 w-full h-[45%] bg-[#c1121f] overflow-hidden">
                <div class="absolute inset-0 opacity-20 mix-blend-overlay">
                    <!-- Building Pattern/Image would go here -->
                    <div class="w-full h-full bg-[url('https://tnts.edu.ph/wp-content/uploads/2023/10/TNTS-Building.jpg')] bg-cover bg-center"></div>
                </div>
                <div class="relative z-10 flex flex-col items-center pt-6 text-white text-center">
                    <div class="size-16 mb-2">
                        <x-app-logo-image class="size-full brightness-0 invert" />
                    </div>
                    <h1 class="text-xs font-black tracking-tight leading-tight uppercase">Tanza National Trade School</h1>
                    <p class="text-[8px] font-medium opacity-90 uppercase tracking-widest mt-0.5">Paradahan I, Tanza, Cavite</p>
                </div>
                <!-- Curve Bottom -->
                <div class="absolute bottom-0 w-full h-12 bg-white rounded-t-[100%] scale-x-125 translate-y-6"></div>
            </div>

            <!-- Student Photo -->
            <div class="absolute top-[28%] left-1/2 -translate-x-1/2 z-20 w-[45%]">
                <div class="w-full aspect-square rounded-[15%] md:rounded-[40px] border-[4px] md:border-[6px] border-white shadow-xl overflow-hidden bg-gray-50">
                    @if($enrollment->profile_picture)
                        <img src="{{ asset('storage/' . $enrollment->profile_picture) }}" class="size-full object-cover">
                    @else
                        <div class="size-full flex items-center justify-center text-gray-200">
                            <span class="material-symbols-outlined text-6xl">person</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Student Info -->
            <div class="absolute top-[58%] w-full flex flex-col items-center text-center px-4">
                <p class="text-base sm:text-xl font-black text-[#1b0d0d] tracking-wider mb-1">{{ $enrollment->lrn }}</p>
                <h2 class="text-2xl sm:text-3xl font-black text-[#1b0d0d] uppercase leading-none">{{ $enrollment->last_name }}</h2>
                <h3 class="text-lg sm:text-xl font-bold text-[#1b0d0d] uppercase mt-1">
                    {{ $enrollment->first_name }} {{ $enrollment->middle_name ? substr($enrollment->middle_name, 0, 1) . '.' : '' }}
                </h3>

                <!-- Principal Area -->
                <div class="mt-8 flex flex-col items-center">
                    <div class="relative">
                        <p class="text-[14px] font-black text-[#1b0d0d]">ROLANDO P. DILIDILI, EdD.</p>
                        <!-- Fake Signature -->
                        <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-32 h-12 opacity-80 pointer-events-none">
                            <svg viewBox="0 0 200 60" class="w-full h-full text-[#1b0d0d] fill-current">
                                <path d="M20,40 Q50,20 80,45 T140,30 Q160,20 180,40" stroke="currentColor" fill="none" stroke-width="2" />
                                <path d="M40,30 Q70,50 100,25 T160,35" stroke="currentColor" fill="none" stroke-width="1.5" />
                            </svg>
                        </div>
                    </div>
                    <div class="w-24 h-[1px] bg-black/20 my-0.5"></div>
                    <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest">School Principal IV</p>
                </div>
            </div>

            <!-- Red Footer -->
            <div class="absolute bottom-0 w-full h-12 bg-[#c1121f] flex items-center justify-center">
                <p class="text-white font-black uppercase tracking-[0.2em] text-sm">
                    {{ $enrollment->school_category === 'Senior High School' ? 'Senior High School' : 'Junior High School' }}
                </p>
            </div>
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
