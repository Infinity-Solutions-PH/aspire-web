@use('App\Models\Enrollment')
@use('Illuminate\Support\Facades\Auth')

@php
    $pendingCount = Enrollment::where('status', 'Submitted')->count();
    $approvedCount = Enrollment::where('status', 'Approved')->count();
    $enrolledCount = Enrollment::where('status', 'Enrolled')->count();
@endphp

<x-layouts::app :title="__('Admin Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-8 rounded-xl p-4 sm:p-8">
        <div class="flex flex-col gap-6">
            <div>
                <h2 class="text-3xl font-bold tracking-tight">Management Overview</h2>
                <p class="text-neutral-500">Track and approve ongoing student enrollments.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('admin.enrollments', ['status' => 'Submitted']) }}" class="glass-card p-6 rounded-2xl border border-amber-100 bg-amber-50/30 hover:bg-amber-50/50 transition-all flex flex-col gap-4">
                    <div class="size-10 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600">
                        <span class="material-symbols-outlined">pending_actions</span>
                    </div>
                    <div>
                        <p class="text-4xl font-black text-amber-700">{{ $pendingCount }}</p>
                        <p class="text-sm font-bold text-amber-600/80 uppercase tracking-wider">Pending Review</p>
                    </div>
                </a>

                <a href="{{ route('admin.enrollments', ['status' => 'Approved']) }}" class="glass-card p-6 rounded-2xl border border-blue-100 bg-blue-50/30 hover:bg-blue-50/50 transition-all flex flex-col gap-4">
                    <div class="size-10 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                        <span class="material-symbols-outlined">verified</span>
                    </div>
                    <div>
                        <p class="text-4xl font-black text-blue-700">{{ $approvedCount }}</p>
                        <p class="text-sm font-bold text-blue-600/80 uppercase tracking-wider">Approved (Not Finalized)</p>
                    </div>
                </a>

                <a href="{{ route('admin.enrollments', ['status' => 'Enrolled']) }}" class="glass-card p-6 rounded-2xl border border-green-100 bg-green-50/30 hover:bg-green-50/50 transition-all flex flex-col gap-4">
                    <div class="size-10 bg-green-100 rounded-xl flex items-center justify-center text-green-600">
                        <span class="material-symbols-outlined">school</span>
                    </div>
                    <div>
                        <p class="text-4xl font-black text-green-700">{{ $enrolledCount }}</p>
                        <p class="text-sm font-bold text-green-600/80 uppercase tracking-wider">Officially Enrolled</p>
                    </div>
                </a>
            </div>

            <div class="bg-white dark:bg-zinc-800 border border-neutral-200 dark:border-neutral-700 rounded-2xl overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b border-neutral-100 dark:border-neutral-700 flex justify-between items-center">
                    <h3 class="font-bold">Recent Submissions</h3>
                    <a href="{{ route('admin.enrollments') }}" class="text-xs font-bold text-primary hover:underline">View All</a>
                </div>
                <div class="p-6 h-64 flex items-center justify-center text-neutral-400 italic text-sm">
                    Submission analytics and activity feed coming soon.
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
