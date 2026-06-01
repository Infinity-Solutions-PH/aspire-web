<div>
    <!-- Greeting Header -->
    <div class="glass-card rounded-3xl p-8 border border-[#e7cfcf] dark:border-white/10 shadow-sm mb-8 bg-gradient-to-r from-primary/5 to-transparent flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-black text-[#1b0d0d] dark:text-white tracking-tight">Welcome back, {{ auth()->user()->name }}!</h1>
            <p class="text-sm text-[#9a4c4c] dark:text-white/60 mt-1">Here is a quick overview of your classes, schedules, and student directory.</p>
        </div>
        <div class="px-4 py-2 bg-white dark:bg-[#3d2424] border border-[#e7cfcf] dark:border-white/10 rounded-2xl text-xs font-bold text-gray-500 dark:text-gray-400 flex items-center gap-2">
            <span class="material-symbols-outlined text-[16px] text-primary">calendar_today</span>
            {{ now()->format('F d, Y · l') }}
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Subjects Taught -->
        <div class="p-6 bg-white dark:bg-[#2a1515] rounded-2xl border border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center gap-4 shadow-sm hover:scale-[1.01] transition-transform">
            <div class="size-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-2xl">book</span>
            </div>
            <div>
                <p class="text-[#9a4c4c] dark:text-white/60 text-xs font-semibold uppercase tracking-wider">Handled Subjects</p>
                <p class="text-2xl font-black text-[#1b0d0d] dark:text-white tracking-tight mt-0.5">{{ $handledSubjectsCount }}</p>
            </div>
        </div>

        <!-- Sections Taught -->
        <div class="p-6 bg-white dark:bg-[#2a1515] rounded-2xl border border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center gap-4 shadow-sm hover:scale-[1.01] transition-transform">
            <div class="size-12 rounded-xl bg-green-50 dark:bg-green-950/30 text-green-600 dark:text-green-400 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-2xl">groups</span>
            </div>
            <div>
                <p class="text-[#9a4c4c] dark:text-white/60 text-xs font-semibold uppercase tracking-wider">Handled Sections</p>
                <p class="text-2xl font-black text-[#1b0d0d] dark:text-white tracking-tight mt-0.5">{{ $handledSectionsCount }}</p>
            </div>
        </div>

        <!-- Advisees count -->
        <div class="p-6 bg-white dark:bg-[#2a1515] rounded-2xl border border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center gap-4 shadow-sm hover:scale-[1.01] transition-transform">
            <div class="size-12 rounded-xl bg-amber-50 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-2xl">person_pin</span>
            </div>
            <div>
                <p class="text-[#9a4c4c] dark:text-white/60 text-xs font-semibold uppercase tracking-wider">Advisees</p>
                <p class="text-2xl font-black text-[#1b0d0d] dark:text-white tracking-tight mt-0.5">{{ $adviseesCount }}</p>
            </div>
        </div>

        <!-- Total Students Teaching -->
        <div class="p-6 bg-white dark:bg-[#2a1515] rounded-2xl border border-[#f3e7e7] dark:border-[#3a1f1f] flex items-center gap-4 shadow-sm hover:scale-[1.01] transition-transform">
            <div class="size-12 rounded-xl bg-blue-50 dark:bg-blue-950/30 text-blue-600 dark:text-blue-400 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-2xl">school</span>
            </div>
            <div>
                <p class="text-[#9a4c4c] dark:text-white/60 text-xs font-semibold uppercase tracking-wider">Total Students</p>
                <p class="text-2xl font-black text-[#1b0d0d] dark:text-white tracking-tight mt-0.5">{{ $totalStudentsCount }}</p>
            </div>
        </div>
    </div>

    <!-- Teaching Schedule -->
    <div class="bg-white dark:bg-[#2a1515] rounded-2xl border border-[#f3e7e7] dark:border-[#3a1f1f] shadow-sm overflow-hidden">
        <div class="border-b border-[#f3e7e7] dark:border-[#3a1f1f] px-6 py-5 bg-[#fdfafb] dark:bg-[#361a1a] flex items-center justify-between">
            <div class="flex items-center gap-2 text-primary">
                <span class="material-symbols-outlined font-bold">calendar_month</span>
                <h3 class="text-base font-black uppercase tracking-tight">Teaching Schedule</h3>
            </div>
            <span class="text-xs text-gray-500 font-medium">Daily teaching blocks</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-[#201010]/30 border-b border-[#f3e7e7] dark:border-[#3a1f1f]">
                        <th class="px-6 py-3.5 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Day</th>
                        <th class="px-6 py-3.5 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Time Block</th>
                        <th class="px-6 py-3.5 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Subject</th>
                        <th class="px-6 py-3.5 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Section</th>
                        <th class="px-6 py-3.5 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Room</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f3e7e7] dark:divide-[#3a1f1f]">
                    @forelse($schedules as $schedule)
                        <tr class="hover:bg-primary/[0.01] dark:hover:bg-white/[0.01] transition-colors">
                            <td class="px-6 py-4">
                                <span class="text-xs font-black text-primary bg-primary/5 px-2 py-1 rounded">
                                    {{ $schedule->day }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-medium text-[#1b0d0d] dark:text-white">
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-[#1b0d0d] dark:text-white">{{ $schedule->subject?->name }}</span>
                                    <span class="text-[10px] text-gray-500 font-mono">{{ $schedule->subject?->code }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-gray-700 dark:text-gray-300">
                                    {{ $schedule->section?->grade_level }} - {{ $schedule->section?->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-semibold text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-white/5 px-2 py-1 rounded">
                                    {{ $schedule->room?->name ?: 'N/A' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">No schedule blocks assigned yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
