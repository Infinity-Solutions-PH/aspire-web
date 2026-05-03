@use('App\Models\Enrollment')
@use('App\Models\PreEnrollment')
@use('Illuminate\Support\Facades\Auth')

@php
    // User request: pending enrollments are from pre_enrollments with status 'pending_approval'
    $pendingCount = PreEnrollment::where('status', 'pending_approval')->count();
    $approvedCount = Enrollment::where('status', 'Approved')->count();
    $enrolledCount = Enrollment::where('status', 'Enrolled')->count();
    $totalApplicants = $pendingCount + Enrollment::count();

    $recentPending = PreEnrollment::where('status', 'pending_approval')
        ->latest('updated_at')
        ->limit(5)
        ->get();
@endphp

<x-layouts::app :title="__('Admin Dashboard')">
    @section('page-title', 'Admin Dashboard')
    <div class="flex flex-col gap-10">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h2 class="text-4xl font-black tracking-tight text-[#1b0d0d] dark:text-white">Admin Dashboard</h2>
                <p class="text-neutral-500 mt-2 font-medium">System overview for {{ now()->format('F j, Y') }}</p>
            </div>
            <div class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-zinc-800 rounded-xl border border-neutral-200 dark:border-white/10 shadow-sm">
                <span class="size-2 rounded-full bg-green-500 animate-pulse"></span>
                <span class="text-xs font-bold text-neutral-600 dark:text-neutral-400 uppercase tracking-widest">System Online</span>
            </div>
        </div>
        
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Applicants -->
            <div class="glass-card p-6 rounded-3xl border border-neutral-200 dark:border-white/10 bg-white/50 dark:bg-white/5 shadow-sm hover:shadow-md transition-all group">
                <div class="flex justify-between items-start mb-4">
                    <div class="size-12 bg-neutral-100 dark:bg-white/10 rounded-2xl flex items-center justify-center text-neutral-600 dark:text-neutral-300 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-2xl">groups</span>
                    </div>
                    <span class="text-[10px] font-black text-neutral-400 uppercase tracking-tighter">Overall</span>
                </div>
                <p class="text-4xl font-black text-neutral-800 dark:text-white tracking-tighter">{{ number_format($totalApplicants) }}</p>
                <p class="text-xs font-bold text-neutral-500 uppercase mt-1">Total Applicants</p>
            </div>

            <!-- Pending Review -->
            <a href="{{ route('admin.enrollments', ['status' => 'pending_approval']) }}" class="glass-card p-6 rounded-3xl border border-amber-200/50 bg-amber-50/50 dark:bg-amber-900/10 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all group">
                <div class="flex justify-between items-start mb-4">
                    <div class="size-12 bg-amber-100 dark:bg-amber-900/30 rounded-2xl flex items-center justify-center text-amber-600 group-hover:rotate-12 transition-transform">
                        <span class="material-symbols-outlined text-2xl">pending_actions</span>
                    </div>
                    <div class="px-2 py-1 bg-amber-100 dark:bg-amber-900/50 rounded-lg text-[8px] font-black text-amber-700 dark:text-amber-300 uppercase tracking-widest">Action Needed</div>
                </div>
                <p class="text-4xl font-black text-amber-700 dark:text-amber-400 tracking-tighter">{{ number_format($pendingCount) }}</p>
                <p class="text-xs font-bold text-amber-600/80 uppercase mt-1">Pending Review</p>
            </a>

            <!-- Approved -->
            <a href="{{ route('admin.enrollments', ['status' => 'Approved']) }}" class="glass-card p-6 rounded-3xl border border-blue-200/50 bg-blue-50/50 dark:bg-blue-900/10 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all group">
                <div class="flex justify-between items-start mb-4">
                    <div class="size-12 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-2xl">verified</span>
                    </div>
                </div>
                <p class="text-4xl font-black text-blue-700 dark:text-blue-400 tracking-tighter">{{ number_format($approvedCount) }}</p>
                <p class="text-xs font-bold text-blue-600/80 uppercase mt-1">Approved Cases</p>
            </a>

            <!-- Officially Enrolled -->
            <a href="{{ route('admin.enrollments', ['status' => 'Enrolled']) }}" class="glass-card p-6 rounded-3xl border border-green-200/50 bg-green-50/50 dark:bg-green-900/10 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all group">
                <div class="flex justify-between items-start mb-4">
                    <div class="size-12 bg-green-100 dark:bg-green-900/30 rounded-2xl flex items-center justify-center text-green-600 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-2xl">school</span>
                    </div>
                    <div class="px-2 py-1 bg-green-100 dark:bg-green-900/50 rounded-lg text-[8px] font-black text-green-700 dark:text-green-300 uppercase tracking-widest">Finalized</div>
                </div>
                <p class="text-4xl font-black text-green-700 dark:text-green-400 tracking-tighter">{{ number_format($enrolledCount) }}</p>
                <p class="text-xs font-bold text-green-600/80 uppercase mt-1">Officially Enrolled</p>
            </a>
        </div>

        <!-- Main Content Area -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Pending Applications -->
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center justify-between px-2">
                    <h3 class="text-lg font-bold flex items-center gap-2 text-neutral-800 dark:text-white">
                        <span class="material-symbols-outlined text-primary">new_releases</span>
                        Recent Pending Applications
                    </h3>
                    <a href="{{ route('admin.enrollments', ['status' => 'pending_approval']) }}" class="text-xs font-bold text-primary hover:underline">View All Applications</a>
                </div>
                
                <div class="bg-white dark:bg-zinc-800 border border-neutral-200 dark:border-white/10 rounded-3xl overflow-hidden shadow-sm">
                    <div class="divide-y divide-neutral-100 dark:divide-white/5">
                        @forelse($recentPending as $pre)
                            @php $data = $pre->form_data; @endphp
                            <div class="p-5 flex items-center justify-between hover:bg-neutral-50 dark:hover:bg-white/5 transition-colors group">
                                <div class="flex items-center gap-4">
                                    <div class="size-10 rounded-xl bg-primary/5 text-primary flex items-center justify-center font-bold text-xs">
                                        {{ substr($data['first_name'] ?? 'S', 0, 1) }}{{ substr($data['last_name'] ?? 'T', 0, 1) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-neutral-800 dark:text-neutral-200">{{ $data['last_name'] }}, {{ $data['first_name'] }}</span>
                                        <span class="text-[10px] text-neutral-400 font-mono tracking-tighter uppercase">{{ $data['grade_level'] }} &sdot; LRN: {{ $pre->lrn }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-[10px] font-bold text-neutral-400">{{ $pre->updated_at->diffForHumans() }}</span>
                                    <a href="{{ route('admin.enrollment.review', $pre->id) }}" class="p-2 text-primary hover:bg-primary/10 rounded-lg transition-all opacity-0 group-hover:opacity-100">
                                        <span class="material-symbols-outlined text-lg">arrow_forward</span>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 flex flex-col items-center justify-center text-center opacity-30">
                                <span class="material-symbols-outlined text-5xl mb-2">inbox</span>
                                <p class="text-sm font-bold">No pending reviews at the moment</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Quick Stats & Actions -->
            <div class="space-y-8">
                <!-- Academic Year Status -->
                <div class="bg-primary p-8 rounded-3xl text-white shadow-xl shadow-primary/20 relative overflow-hidden group">
                    <div class="absolute -right-10 -bottom-10 size-40 bg-white/10 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-700"></div>
                    <div class="relative z-10">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80">Current Term</p>
                        <h4 class="text-2xl font-black mt-1">S.Y. 2026-2027</h4>
                        <div class="mt-6 flex items-center gap-4">
                            <div class="flex-1 h-2 bg-white/20 rounded-full overflow-hidden">
                                <div class="h-full bg-white rounded-full" style="width: 65%"></div>
                            </div>
                            <span class="text-[10px] font-bold">65% Capacity</span>
                        </div>
                        <p class="text-[10px] mt-4 leading-relaxed opacity-80">
                            Enrollment is currently active for all levels. Regular verification schedules are ongoing.
                        </p>
                    </div>
                </div>

                <!-- Sectioning Quick Link -->
                <div class="bg-white dark:bg-zinc-800 border border-neutral-200 dark:border-white/10 p-6 rounded-3xl space-y-4 shadow-sm">
                    <h3 class="text-sm font-bold text-neutral-800 dark:text-white uppercase tracking-widest">Fast Track</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('admin.sections') }}" class="p-4 rounded-2xl bg-neutral-50 dark:bg-white/5 border border-neutral-100 dark:border-white/5 flex flex-col items-center gap-2 hover:border-primary/30 transition-all group">
                            <span class="material-symbols-outlined text-primary group-hover:scale-110 transition-transform">meeting_room</span>
                            <span class="text-[10px] font-bold text-neutral-600 dark:text-neutral-400">Sections</span>
                        </a>
                        <a href="{{ route('admin.schedules') }}" class="p-4 rounded-2xl bg-neutral-50 dark:bg-white/5 border border-neutral-100 dark:border-white/5 flex flex-col items-center gap-2 hover:border-primary/30 transition-all group">
                            <span class="material-symbols-outlined text-primary group-hover:scale-110 transition-transform">calendar_month</span>
                            <span class="text-[10px] font-bold text-neutral-600 dark:text-neutral-400">Schedules</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
