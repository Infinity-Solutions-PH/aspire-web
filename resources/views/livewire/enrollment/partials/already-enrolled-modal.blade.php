<div x-data="{ open: @entangle('showAlreadyEnrolledModal') }" 
     x-show="open" 
     class="fixed inset-0 z-50 overflow-y-auto" 
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
             class="relative bg-white dark:bg-zinc-900 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-lg sm:w-full border border-zinc-200 dark:border-zinc-800">
            
            <div class="relative">
                <!-- Decorative Header -->
                <div class="bg-primary/10 h-32 flex items-center justify-center relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10">
                        <x-app-logo-image class="size-48 -rotate-12 absolute -right-8 -top-8" />
                    </div>
                    <div class="size-16 bg-white dark:bg-zinc-800 rounded-2xl flex items-center justify-center shadow-lg relative z-10">
                        <span class="material-symbols-outlined text-primary text-3xl">verified</span>
                    </div>
                </div>

                <div class="p-8 pt-6">
                    <div class="text-center">
                        <h3 class="text-2xl font-black tracking-tighter text-zinc-900 dark:text-white" id="modal-title">
                            Enrollment Verified
                        </h3>
                        <div class="mt-4">
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                                Our records show that you are <strong>already officially enrolled</strong> for the current school year. You don't need to submit another application.
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 space-y-3">
                        <a href="{{ route('login') }}" class="w-full inline-flex items-center justify-center gap-3 bg-primary text-white px-6 py-4 rounded-2xl font-bold text-sm tracking-wide shadow-xl shadow-primary/20 hover:bg-primary/90 hover:scale-[1.02] transition-all">
                            <span class="material-symbols-outlined text-lg">login</span>
                            Sign in to Student Portal
                        </a>
                        <button type="button" 
                                @click="open = false" 
                                class="w-full inline-flex items-center justify-center gap-3 bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 px-6 py-4 rounded-2xl font-bold text-sm tracking-wide hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-all">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
