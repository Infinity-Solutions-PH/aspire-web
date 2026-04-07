@use('App\Models\Enrollment')
@use('Illuminate\Support\Facades\Auth')

@php
    $pendingCount = Enrollment::where('status', 'Submitted')->count();
    $approvedCount = Enrollment::where('status', 'Approved')->count();
    $enrolledCount = Enrollment::where('status', 'Enrolled')->count();
@endphp

<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-8 rounded-xl p-4 sm:p-8">
        @can('access-admin')
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
        @else
            @php
                $enrollment = Enrollment::where('user_id', Auth::id())->latest()->first();
            @endphp

            <div class="flex flex-col gap-6">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight">Your Enrollment</h2>
                    <p class="text-neutral-500">Manage your application status and academic details.</p>
                </div>

                @if(!$enrollment)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <a href="{{ route('enrollment.form') }}" class="group relative overflow-hidden rounded-3xl border-2 border-dashed border-primary/20 bg-white hover:bg-primary/5 hover:border-primary/40 transition-all p-10 flex flex-col items-center justify-center text-center gap-6">
                            <div class="size-20 bg-primary/10 rounded-full flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-5xl">person_add</span>
                            </div>
                            <div class="space-y-2">
                                <h3 class="text-2xl font-black text-gray-900">Start New Enrollment</h3>
                                <p class="text-sm text-gray-500 max-w-xs mx-auto">Begin your application for the upcoming school year. It only takes a few minutes.</p>
                            </div>
                            <div class="px-6 py-2 bg-primary text-white rounded-full font-bold text-sm">Get Started</div>
                        </a>
                        
                        <div class="rounded-3xl border-2 border-dashed border-neutral-200 bg-neutral-50 dark:bg-neutral-800/50 p-10 flex flex-col items-center justify-center text-center gap-4 text-neutral-400">
                            <span class="material-symbols-outlined text-5xl">help_outline</span>
                            <p class="text-sm font-medium">Need help? Visit our Help Center or contact the Registrar's Office.</p>
                        </div>
                    </div>
                @else
                @if($enrollment->status === 'Enrolled')
                    @livewire('student.dashboard-portal')
                @else
                    <div class="glass-card rounded-3xl border border-primary/10 overflow-hidden shadow-xl shadow-primary/5">
                        <div class="p-8 bg-primary/5 border-b border-primary/5 flex justify-between items-center">
                            <div class="flex items-center gap-4">
                                <div class="size-12 bg-primary text-white rounded-2xl flex items-center justify-center shadow-lg shadow-primary/20">
                                    <span class="material-symbols-outlined">assignment</span>
                                </div>
                                <div>
                                    <h3 class="text-xl font-black text-gray-900">Application #{{ $enrollment->id }}</h3>
                                    <p class="text-xs text-primary/60 font-bold uppercase tracking-widest">{{ $enrollment->type }} - {{ $enrollment->grade_level }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end">
                                <p class="text-xs font-bold text-gray-400 uppercase">Current Status</p>
                                <span class="text-lg font-black text-primary uppercase">{{ $enrollment->status }}</span>
                            </div>
                        </div>
                        
                        <div class="p-8 space-y-8">
                            <div class="relative pt-6">
                                @php
                                    $steps = ['Draft', 'Submitted', 'Approved', 'Enrolled'];
                                    $currentIndex = array_search($enrollment->status, $steps) ?: (array_search($enrollment->status, $steps) === 0 ? 0 : 1);
                                    $progressPercent = ($currentIndex / (count($steps) - 1)) * 100;
                                    $progressStyle = "width: " . $progressPercent . "%;";
                                @endphp
                                <div class="flex items-center justify-between relative mb-2">
                                    @foreach($steps as $index => $step)
                                        <div class="flex flex-col items-center gap-2 z-10 w-1/4">
                                            <div class="size-6 rounded-full {{ $index <= $currentIndex ? 'bg-primary text-white' : 'bg-gray-200 text-gray-400' }} flex items-center justify-center text-[10px] font-bold">
                                                @if($index < $currentIndex) ✓ @else {{ $index + 1 }} @endif
                                            </div>
                                            <span class="text-[10px] font-black uppercase tracking-tighter {{ $index <= $currentIndex ? 'text-primary' : 'text-gray-400' }}">{{ $step }}</span>
                                        </div>
                                    @endforeach
                                    <div class="absolute top-3 inset-x-[12%] h-0.5 bg-gray-200 -z-0">
                                        <div class="h-full bg-primary transition-all duration-700" style="{{ $progressStyle }}"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                                <div class="space-y-4">
                                    <h4 class="text-sm font-bold text-gray-900 uppercase">Latest Remarks</h4>
                                    <div class="p-4 bg-gray-50 border border-gray-100 rounded-xl text-sm italic text-gray-600 min-h-[80px]">
                                        {{ $enrollment->admin_remarks ?: 'No remarks yet. Your application is being reviewed.' }}
                                    </div>
                                </div>
                                <div class="flex flex-col gap-3 justify-center">
                                    @if($enrollment->status === 'Draft')
                                        <a href="{{ route('enrollment.form') }}" class="w-full bg-primary text-white py-4 rounded-xl font-bold flex items-center justify-center gap-2 shadow-lg shadow-primary/20">
                                            Continue Application
                                            <span class="material-symbols-outlined">edit_square</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @endif
            </div>
        @endcan
    </div>
</x-layouts::app>
