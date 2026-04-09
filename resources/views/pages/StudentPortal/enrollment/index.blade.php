<x-layouts::student-portal :title="__('Enrollment')">
    <div class="max-w-7xl mx-auto py-4">
        @if(!$enrollment)
            <div class="max-w-[960px] mx-auto py-12 px-4">
                <div class="group relative overflow-hidden rounded-3xl border-2 border-dashed border-primary/20 bg-white dark:bg-zinc-900 hover:bg-primary/5 hover:border-primary/40 transition-all p-16 flex flex-col items-center justify-center text-center gap-8 shadow-2xl shadow-primary/5">
                    <div class="size-28 bg-primary/10 rounded-full flex items-center justify-center text-primary group-hover:scale-110 transition-transform shadow-inner">
                        <span class="material-symbols-outlined text-6xl">person_add</span>
                    </div>
                    <div class="space-y-4">
                        <h3 class="text-4xl font-black text-gray-900 dark:text-white tracking-tight">Start Your Journey</h3>
                        <p class="text-lg text-gray-500 max-w-md mx-auto leading-relaxed">Join the TNTS community. Begin your enrollment application for the upcoming school year today.</p>
                    </div>
                    
                    <div class="flex flex-col gap-4 w-full max-w-xs">
                        <form action="{{ route('enrollment.start') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full group/btn relative px-8 py-5 bg-primary text-white rounded-2xl font-black text-sm uppercase tracking-widest shadow-xl shadow-primary/30 hover:bg-primary-container transition-all flex items-center justify-center gap-3">
                                Begin Application
                                <span class="material-symbols-outlined text-xl group-hover/btn:translate-x-1 transition-transform">arrow_forward</span>
                            </button>
                        </form>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Takes approximately 10-15 minutes</p>
                    </div>

                    <!-- Decorative elements -->
                    <div class="absolute -top-10 -right-10 size-40 bg-primary/5 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-10 -left-10 size-40 bg-primary/5 rounded-full blur-3xl"></div>
                </div>
            </div>
        @elseif($enrollment->status === 'Draft')
            <div class="space-y-6">
                <div class="flex items-center gap-3 mb-6 px-4">
                    <div class="size-10 bg-amber-100 text-amber-700 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined">edit_note</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Continue Your Application</h2>
                        <p class="text-xs text-gray-500">Your progress has been saved. Complete the remaining steps below.</p>
                    </div>
                </div>
                @livewire('student-portal.enrollment-form')
            </div>
        @elseif(in_array($enrollment->status, ['Submitted', 'Approved']))
            <div class="space-y-6">
                @livewire('student-portal.enrollment-post')
            </div>
        @elseif($enrollment->status === 'Enrolled')
            <div class="max-w-[800px] mx-auto py-12 px-4">
                <div class="bg-white dark:bg-zinc-900 shadow-2xl rounded-3xl overflow-hidden border border-zinc-200 dark:border-zinc-800">
                    <header class="bg-green-600 p-12 text-white text-center relative overflow-hidden">
                        <div class="relative z-10">
                            <div class="size-20 bg-white rounded-2xl flex items-center justify-center mx-auto mb-6 p-4 shadow-xl">
                                <span class="material-symbols-outlined text-green-600 text-5xl">verified</span>
                            </div>
                            <h1 class="text-4xl font-black tracking-tighter mb-2">Officially Enrolled!</h1>
                            <p class="text-sm uppercase tracking-[0.3em] opacity-80 font-bold">Academic Year 2024-2025</p>
                        </div>
                        <!-- Patterns -->
                        <div class="absolute top-0 right-0 p-4 opacity-10">
                            <span class="material-symbols-outlined text-9xl">workspace_premium</span>
                        </div>
                    </header>

                    <div class="p-10 md:p-16 text-center space-y-8">
                        <div class="space-y-4">
                            <h2 class="text-2xl font-black text-gray-900 dark:text-white">Welcome to the Trade School, {{ Auth::user()->first_name }}!</h2>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed max-w-xl mx-auto">
                                Your enrollment has been finalized and your accounts are now being provisioned. You can now access your full student dashboard, view your section, and check your schedule.
                            </p>
                        </div>

                        <div class="flex flex-col md:flex-row gap-4 justify-center items-center">
                            <a href="{{ route('student.dashboard') }}" class="px-10 py-4 bg-primary text-white rounded-2xl font-black text-sm uppercase tracking-widest shadow-xl shadow-primary/20 hover:bg-primary-container transition-all flex items-center gap-3">
                                <span class="material-symbols-outlined">dashboard</span>
                                Go to Dashboard
                            </a>
                            <a href="#" class="px-10 py-4 border-2 border-zinc-200 dark:border-zinc-700 text-zinc-600 dark:text-zinc-300 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-all flex items-center gap-3">
                                <span class="material-symbols-outlined">description</span>
                                Download E-COR
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layouts::student-portal>