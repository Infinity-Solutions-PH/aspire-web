<div>
    <!-- Page Heading -->
    <div class="flex flex-col gap-1 mb-8">
        <h1 class="text-3xl font-black text-primary tracking-tight">Faculty Profile</h1>
        <p class="text-sm text-[#9a4c4c] dark:text-white/60">View your official credentials and manage your account security.</p>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 5000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-[-10px]"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-[-10px]"
             class="mb-6 p-4 bg-green-50 dark:bg-green-950/30 border border-green-200 dark:border-green-800/30 rounded-2xl flex items-center justify-between text-green-800 dark:text-green-400 shadow-sm shadow-green-100/10">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-green-600 dark:text-green-400">check_circle</span>
                <span class="text-sm font-semibold">{{ session('message') }}</span>
            </div>
            <button @click="show = false" class="text-green-500 hover:text-green-700 dark:hover:text-green-300 transition-colors">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Official Credentials Card (Left/Col-Span-2) -->
        <div class="lg:col-span-2 space-y-6">
            <section class="glass-card rounded-[32px] border border-[#e7cfcf] dark:border-white/10 shadow-sm p-8 bg-white dark:bg-[#2a1515]">
                <h3 class="text-lg font-black uppercase text-primary tracking-tight mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined font-bold text-xl">badge</span>
                    Official Credentials
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Faculty ID -->
                    <div class="p-4 bg-gray-50/50 dark:bg-black/10 rounded-2xl border border-gray-100 dark:border-white/5">
                        <span class="text-[9px] font-black uppercase tracking-wider text-[#9a4c4c] dark:text-white/40">Faculty ID</span>
                        <p class="text-sm font-bold text-[#1b0d0d] dark:text-white mt-1">{{ $faculty_id }}</p>
                    </div>

                    <!-- Full Name -->
                    <div class="p-4 bg-gray-50/50 dark:bg-black/10 rounded-2xl border border-gray-100 dark:border-white/5">
                        <span class="text-[9px] font-black uppercase tracking-wider text-[#9a4c4c] dark:text-white/40">Full Name</span>
                        <p class="text-sm font-bold text-[#1b0d0d] dark:text-white mt-1">{{ $name }}</p>
                    </div>

                    <!-- Email -->
                    <div class="p-4 bg-gray-50/50 dark:bg-black/10 rounded-2xl border border-gray-100 dark:border-white/5">
                        <span class="text-[9px] font-black uppercase tracking-wider text-[#9a4c4c] dark:text-white/40">Official Email</span>
                        <p class="text-sm font-bold text-[#1b0d0d] dark:text-white mt-1">{{ $email }}</p>
                    </div>

                    <!-- Gender -->
                    <div class="p-4 bg-gray-50/50 dark:bg-black/10 rounded-2xl border border-gray-100 dark:border-white/5">
                        <span class="text-[9px] font-black uppercase tracking-wider text-[#9a4c4c] dark:text-white/40">Gender</span>
                        <p class="text-sm font-bold text-[#1b0d0d] dark:text-white mt-1">{{ $gender }}</p>
                    </div>

                    <!-- Secondary Level -->
                    <div class="p-4 bg-gray-50/50 dark:bg-black/10 rounded-2xl border border-gray-100 dark:border-white/5">
                        <span class="text-[9px] font-black uppercase tracking-wider text-[#9a4c4c] dark:text-white/40">Secondary Level</span>
                        <p class="text-sm font-bold text-[#1b0d0d] dark:text-white mt-1">{{ $level }}</p>
                    </div>

                    <!-- Department -->
                    <div class="p-4 bg-gray-50/50 dark:bg-black/10 rounded-2xl border border-gray-100 dark:border-white/5">
                        <span class="text-[9px] font-black uppercase tracking-wider text-[#9a4c4c] dark:text-white/40">Department</span>
                        <p class="text-sm font-bold text-[#1b0d0d] dark:text-white mt-1">{{ $department_name }}</p>
                    </div>

                    <!-- Position -->
                    <div class="p-4 bg-gray-50/50 dark:bg-black/10 rounded-2xl border border-gray-100 dark:border-white/5">
                        <span class="text-[9px] font-black uppercase tracking-wider text-[#9a4c4c] dark:text-white/40">Designated Position</span>
                        <p class="text-sm font-bold text-[#1b0d0d] dark:text-white mt-1 text-primary">{{ $position_name }}</p>
                    </div>

                    <!-- Plantilla Item Number -->
                    <div class="p-4 bg-gray-50/50 dark:bg-black/10 rounded-2xl border border-gray-100 dark:border-white/5 md:col-span-2">
                        <span class="text-[9px] font-black uppercase tracking-wider text-[#9a4c4c] dark:text-white/40">Plantilla Item Number</span>
                        <p class="text-sm font-bold font-mono text-[#1b0d0d] dark:text-white mt-1">{{ $plantilla_number }}</p>
                    </div>

                    <!-- Status -->
                    <div class="p-4 bg-gray-50/50 dark:bg-black/10 rounded-2xl border border-gray-100 dark:border-white/5 md:col-span-2 flex items-center justify-between">
                        <div>
                            <span class="text-[9px] font-black uppercase tracking-wider text-[#9a4c4c] dark:text-white/40">Employment Status</span>
                            <p class="text-sm font-bold text-[#1b0d0d] dark:text-white mt-0.5">{{ $status }}</p>
                        </div>
                        <span class="px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider
                            {{ $status === 'Active' ? 'bg-green-100 text-green-700 dark:bg-green-950/30 dark:text-green-400' : 'bg-amber-100 text-amber-700 dark:bg-amber-950/30 dark:text-amber-400' }}">
                            {{ $status }}
                        </span>
                    </div>
                </div>
            </section>
        </div>

        <!-- Security / Password Card (Right) -->
        <div>
            <section class="glass-card rounded-[32px] border border-[#e7cfcf] dark:border-white/10 shadow-sm p-8 bg-white dark:bg-[#2a1515] h-fit">
                <h3 class="text-lg font-black uppercase text-primary tracking-tight mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined font-bold text-xl">lock_reset</span>
                    Update Password
                </h3>

                <form wire:submit.prevent="updatePassword" class="space-y-4">
                    <!-- Current Password -->
                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Current Password</label>
                        <input wire:model="current_password" type="password" 
                               class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary @error('current_password') border-red-500 ring-red-500 @enderror">
                        @error('current_password') <span class="text-[10px] text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- New Password -->
                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">New Password</label>
                        <input wire:model="new_password" type="password" 
                               class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary @error('new_password') border-red-500 ring-red-500 @enderror">
                        @error('new_password') <span class="text-[10px] text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Confirm New Password</label>
                        <input wire:model="new_password_confirmation" type="password" 
                               class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#3d2424] border border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary @error('new_password_confirmation') border-red-500 ring-red-500 @enderror">
                        @error('new_password_confirmation') <span class="text-[10px] text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" 
                            class="w-full py-3 mt-4 bg-primary text-white rounded-xl text-sm font-black shadow-lg shadow-primary/20 hover:scale-[1.02] transition-transform flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-sm">lock_open</span>
                        Save New Password
                    </button>
                </form>
            </section>
        </div>
    </div>
</div>
