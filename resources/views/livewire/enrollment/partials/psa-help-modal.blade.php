<div x-data="{ open: @entangle('showPSAModal') }" 
     x-show="open" 
     class="fixed inset-0 z-[60] overflow-y-auto" 
     aria-labelledby="modal-title" 
     role="dialog" 
     aria-modal="true"
     style="display: none;">
    <div class="flex items-start justify-center min-h-screen p-4 pt-32 text-center">
        <!-- Background overlay -->
        <div x-show="open" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             class="fixed inset-0 bg-zinc-900/80 backdrop-blur-sm transition-opacity" 
             aria-hidden="true"></div>

        <!-- Modal panel -->
        <div x-show="open" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0 -translate-y-4 sm:translate-y-0 sm:scale-95" 
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave-end="opacity-0 -translate-y-4 sm:translate-y-0 sm:scale-95" 
             class="relative bg-white dark:bg-zinc-900 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-xl sm:w-full border border-zinc-200 dark:border-zinc-800">
            
            <div class="relative">
                <!-- Close button -->
                <button @click="open = false" class="absolute right-4 top-4 z-20 size-10 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center hover:bg-white/20 transition-all text-zinc-500 hover:text-zinc-900 dark:hover:text-white">
                    <span class="material-symbols-outlined">close</span>
                </button>

                <div class="p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="size-12 bg-primary/10 rounded-2xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-2xl">description</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-black tracking-tighter text-zinc-900 dark:text-white">
                                Locating your PSA Registry No.
                            </h3>
                            <p class="text-xs text-zinc-500">How to find your Birth Certificate Number</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="relative rounded-2xl overflow-hidden border border-zinc-200 dark:border-zinc-800 shadow-inner bg-zinc-50 dark:bg-zinc-950">
                            <img src="{{ asset('images/psa-sample.png') }}" alt="PSA Certificate Sample" class="w-full h-auto">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 rounded-2xl bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-100 dark:border-zinc-800">
                                <h4 class="text-xs font-black uppercase tracking-widest text-primary mb-2">Location</h4>
                                <p class="text-[11px] text-zinc-600 dark:text-zinc-400 leading-relaxed">
                                    The <strong>Registry Number</strong> is typically found at the <strong>top right corner</strong> of your PSA Birth Certificate.
                                </p>
                            </div>
                            <div class="p-4 rounded-2xl bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-100 dark:border-zinc-800">
                                <h4 class="text-xs font-black uppercase tracking-widest text-primary mb-2">Format</h4>
                                <p class="text-[11px] text-zinc-600 dark:text-zinc-400 leading-relaxed">
                                    It usually consists of 4 digits for the year, followed by a dash and several numbers (e.g., <strong>2024-123456</strong>).
                                </p>
                            </div>
                        </div>

                        <div class="bg-amber-50 dark:bg-amber-900/10 border border-amber-200/50 dark:border-amber-900/30 p-4 rounded-2xl flex gap-3">
                            <span class="material-symbols-outlined text-amber-500">lightbulb</span>
                            <p class="text-[11px] text-amber-800 dark:text-amber-400 leading-tight">
                                Make sure to include the full number including the year and any leading zeros if present.
                            </p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <button @click="open = false" class="w-full bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 py-4 rounded-2xl font-bold text-sm hover:opacity-90 transition-all">
                            Got it, thanks!
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
