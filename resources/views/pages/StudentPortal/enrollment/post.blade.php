
    <div class="max-w-[800px] mx-auto py-8 px-4">
        <!-- Main Card -->
        <div class="bg-white dark:bg-zinc-900 shadow-xl rounded-2xl overflow-hidden border border-zinc-200 dark:border-zinc-800">
            <!-- Header -->
            <header class="bg-primary p-10 text-white text-center">
                <div class="size-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 p-3 shadow-lg">
                    <x-app-logo-icon class="size-full fill-current text-primary" />
                </div>
                <h1 class="text-3xl font-black tracking-tighter">Application Received!</h1>
                <p class="text-sm uppercase tracking-[0.2em] opacity-80 mt-2">Tanza National Trade School</p>
            </header>
            
            <div class="p-8 md:p-12 space-y-10">
                <!-- Greeting -->
                <div class="space-y-4">
                    <h2 class="text-2xl font-black tracking-tight text-[#1b0d0d] dark:text-zinc-100">Hello, {{ Auth::user()->name }}!</h2>
                    <p class="text-zinc-600 dark:text-zinc-400 leading-relaxed">
                        We are excited to welcome you to the TNTS community. Your enrollment application for the upcoming school year has been successfully submitted and is currently in the <strong>Verification</strong> stage.
                    </p>
                </div>
                
                <!-- Appointment Box -->
                <div class="bg-primary/5 dark:bg-primary/20 border-2 border-primary/20 rounded-2xl overflow-hidden">
                    <div class="bg-primary/10 px-6 py-3 border-b border-primary/10">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-primary">Next Step: Physical Verification</p>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="flex items-start gap-4">
                            <span class="material-symbols-outlined text-primary text-3xl">calendar_today</span>
                            <div>
                                <p class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-1">Target Date</p>
                                <p class="font-bold text-[#1b0d0d] dark:text-white">Waiting for SMS Notification</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <span class="material-symbols-outlined text-primary text-3xl">location_on</span>
                            <div>
                                <p class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-1">Venue</p>
                                <p class="font-bold text-[#1b0d0d] dark:text-white">Registrar's Office, Main Building</p>
                            </div>
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
                <div class="pt-6 text-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 bg-primary text-white px-8 py-3.5 rounded-xl font-bold text-sm tracking-wide shadow-xl shadow-primary/20 hover:bg-primary/90 transition-all">
                        Return to Dashboard
                    </a>
                </div>
            </div>
            
            <footer class="bg-zinc-50 dark:bg-zinc-800/50 p-6 border-t border-zinc-100 dark:border-zinc-800 text-center">
                <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest">© 2026 Tanza National Trade School | ASPIRE</p>
            </footer>
        </div>
    </div>

