<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-6">
        <!-- Summary of Fees -->
        <section class="bg-white dark:bg-[#2d1818] rounded-2xl border border-[#e7cfcf] dark:border-[#3d2424] overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-[#e7cfcf] dark:border-[#3d2424] flex items-center justify-between">
                <h3 class="text-[#1b0d0d] dark:text-white font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">receipt_long</span>
                    Summary of Fees
                </h3>
                <span class="text-[10px] font-bold text-green-600 uppercase bg-green-100 px-2 py-1 rounded">Paid in Full</span>
            </div>
            <div class="p-6">
                <table class="w-full text-sm">
                    <thead class="text-[#9a4c4c] dark:text-[#c4a1a1] text-xs uppercase">
                        <tr>
                            <th class="text-left pb-4 font-bold">Description</th>
                            <th class="text-right pb-4 font-bold">Amount (PHP)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f3e7e7] dark:divide-[#3d2424]">
                        @forelse($fees as $fee)
                            <tr>
                                <td class="py-3">{{ $fee->name }}</td>
                                <td class="py-3 text-right">{{ number_format($fee->amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="py-3" colspan="2">No fee records found.</td>
                            </tr>
                        @endforelse
                        <tr class="font-bold text-lg text-[#1b0d0d] dark:text-white">
                            <td class="pt-6">Total Amount</td>
                            <td class="pt-6 text-right">PHP {{ number_format($totalFees, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Notice Section -->
        <section class="bg-primary/5 dark:bg-primary/10 rounded-2xl p-6 border border-primary/20">
            <div class="flex gap-4">
                <div class="shrink-0 size-10 rounded-full bg-primary flex items-center justify-center text-white">
                    <span class="material-symbols-outlined">info</span>
                </div>
                <div>
                    <p class="text-sm font-bold mb-1">Notice to Enrolled Students</p>
                    <p class="text-sm text-[#9a4c4c] dark:text-[#c4a1a1]">Classes for the upcoming semester will officially start on August 15, 2024. Please ensure you have your physical Certificate of Enrollment (COE) on the first day of classes for verification by your instructors.</p>
                </div>
            </div>
        </section>

        <!-- Academic Schedule (Added for functionality) -->
        <section class="bg-white dark:bg-[#2d1818] rounded-2xl border border-[#e7cfcf] dark:border-[#3d2424] overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-[#e7cfcf] dark:border-[#3d2424] flex items-center justify-between">
                <h3 class="text-[#1b0d0d] dark:text-white font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">calendar_today</span>
                    Today's Schedule
                </h3>
                <span class="text-[10px] font-bold text-primary uppercase bg-primary/10 px-2 py-1 rounded">Active</span>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($schedules->sortBy('start_time') as $schedule)
                        <div class="flex items-center gap-4 p-4 bg-[#f8f6f6] dark:bg-[#3d2424] rounded-xl">
                            <div class="size-12 bg-white dark:bg-zinc-800 rounded-lg flex items-center justify-center text-primary shadow-sm">
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
                        <div class="text-center py-8 text-gray-500 italic">No classes scheduled for today.</div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>

    <!-- Sidebar Info -->
    <div class="space-y-6">
        <!-- COE Download -->
        <div class="bg-white dark:bg-[#2d1818] rounded-2xl border border-[#e7cfcf] dark:border-[#3d2424] p-6 text-center shadow-sm">
            <div class="size-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-primary text-4xl">verified_user</span>
            </div>
            <h4 class="text-lg font-bold mb-2">Certificate of Enrollment</h4>
            <p class="text-xs text-[#9a4c4c] dark:text-[#c4a1a1] mb-6">Your enrollment is verified. You can now download or print your official COE for this semester.</p>
            <div class="space-y-3">
                <a href="{{ route('enrollment.certificate') }}" target="_blank" class="w-full flex items-center justify-center gap-2 bg-primary text-white py-3 rounded-xl text-sm font-bold shadow-lg shadow-primary/20 hover:bg-maroon-accent transition-all">
                    <span class="material-symbols-outlined">print</span>
                    View / Print COE
                </a>
                <a href="{{ route('enrollment.certificate') }}?download=1" class="w-full flex items-center justify-center gap-2 border border-primary text-primary py-3 rounded-xl text-sm font-bold hover:bg-primary/5 transition-all">
                    <span class="material-symbols-outlined">download</span>
                    Download PDF
                </a>
            </div>
        </div>

        <!-- Registration Details -->
        <div class="bg-white dark:bg-[#2d1818] rounded-2xl border border-[#e7cfcf] dark:border-[#3d2424] p-6 shadow-sm">
            <h4 class="text-sm font-bold mb-4">Registration Details</h4>
            <div class="space-y-4">
                <div class="flex justify-between items-center text-xs">
                    <span class="text-gray-500">Student ID</span>
                    <span class="font-bold">{{ auth()->user()->student_id ?: 'PENDING' }}</span>
                </div>
                <div class="flex justify-between items-center text-xs">
                    <span class="text-gray-500">Date Enrolled</span>
                    <span class="font-bold">{{ $enrollment->updated_at->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between items-center text-xs">
                    <span class="text-gray-500">Assigned Section</span>
                    <span class="font-bold text-primary">{{ $enrollment->section->name ?? 'Not Assigned' }}</span>
                </div>
                <div class="flex justify-between items-center text-xs">
                    <span class="text-gray-500">Track/Strand</span>
                    <span class="font-bold">{{ $enrollment->track }} - {{ $enrollment->strand }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
