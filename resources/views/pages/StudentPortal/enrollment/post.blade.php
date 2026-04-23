
    <div class="max-w-[800px] mx-auto py-8 px-4">
        <!-- Main Card -->
        <div class="bg-white dark:bg-zinc-900 shadow-xl rounded-2xl overflow-hidden border border-zinc-200 dark:border-zinc-800">
            <!-- Header -->
            <header class="bg-primary p-10 text-white text-center">
                <div class="size-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 p-3 shadow-lg">
                    <x-app-logo-image class="size-full fill-current text-primary" />
                </div>
                <h1 class="text-3xl font-black tracking-tighter">Application Submitted!</h1>
                <p class="text-sm uppercase tracking-[0.2em] opacity-80 mt-2">Tanza National Trade School</p>
            </header>
            
            <div class="p-8 md:p-12 space-y-10">
                <!-- Greeting -->
                <div class="space-y-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="space-y-2">
                            <h2 class="text-2xl font-black tracking-tight text-[#1b0d0d] dark:text-zinc-100">Hello, {{ Auth::user()->name }}!</h2>
                            <p class="text-zinc-600 dark:text-zinc-400 leading-relaxed max-w-xl">
                                We are excited to welcome you to the TNTS community. Your enrollment application has been successfully submitted and is currently in the <strong>Verification</strong> stage.
                            </p>
                        </div>
                        <div class="bg-primary/5 border border-primary/20 rounded-2xl p-6 text-center shrink-0">
                            <p class="text-[10px] font-black text-primary uppercase tracking-widest mb-1">Transaction Number</p>
                            <p class="text-2xl font-black text-[#1b0d0d] dark:text-white tracking-tighter">{{ $enrollment->transaction_number ?? 'PENDING' }}</p>
                        </div>
                    </div>

                    <!-- Announcement Banner -->
                    <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-2xl p-6 flex items-start gap-4">
                        <div class="size-10 bg-amber-100 dark:bg-amber-800 rounded-xl flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-amber-700 dark:text-amber-300">campaign</span>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-amber-900 dark:text-amber-100 mb-1">Physical Verification Notice</h3>
                            <p class="text-xs text-amber-800/80 dark:text-amber-200/60 leading-relaxed">
                                Please wait for further announcements regarding your schedule for physical document verification. We will post updates on our official Facebook page and school notice boards.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Checklist -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary">assignment_turned_in</span>
                        <h3 class="text-lg font-bold tracking-tight">Requirement Checklist</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @php
                            $items = [
                                'Original PSA Birth Certificate',
                                'Original Form 138 (Report Card)',
                                'Original Good Moral Certificate',
                                'Four (4) recent 2x2 ID Pictures',
                                'Printed Submission Pass'
                            ];
                        @endphp
                        @foreach($items as $item)
                        <div class="flex items-center gap-3 p-4 rounded-xl border border-zinc-100 dark:border-zinc-800 bg-zinc-50 dark:bg-black/20">
                            <span class="material-symbols-outlined text-green-600 text-sm">check_circle</span>
                            <p class="text-xs font-bold text-zinc-700 dark:text-zinc-300">{{ $item }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Action -->
                <div class="pt-6 flex flex-col md:flex-row items-center justify-center gap-4">
                    <a href="{{ route('dashboard') }}" class="w-full md:w-auto inline-flex items-center justify-center gap-2 bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 px-8 py-3.5 rounded-xl font-bold text-sm tracking-wide hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-all">
                        <span class="material-symbols-outlined text-lg">dashboard</span>
                        Return to Dashboard
                    </a>
                    <button wire:click="downloadPass" class="w-full md:w-auto inline-flex items-center justify-center gap-2 bg-primary text-white px-8 py-3.5 rounded-xl font-bold text-sm tracking-wide shadow-xl shadow-primary/20 hover:bg-primary/90 transition-all">
                        <span class="material-symbols-outlined text-lg">download</span>
                        Download Admission Pass
                    </button>
                </div>
            </div>
            
            <footer class="bg-zinc-50 dark:bg-zinc-800/50 p-6 border-t border-zinc-100 dark:border-zinc-800 text-center space-y-2">
                <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest leading-relaxed">
                    Transaction Reference: <span class="text-primary">{{ $enrollment->transaction_number }}</span>
                </p>
                <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest">© 2026 Tanza National Trade School | ASPIRE</p>
            </footer>
        </div>
    </div>

