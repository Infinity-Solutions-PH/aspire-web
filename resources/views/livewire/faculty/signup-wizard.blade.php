<div class="max-w-[800px] w-full flex flex-col gap-6 mx-auto py-8 px-4" 
     x-data="{ 
        currentStep: @entangle('currentStep'),
        submitted: @entangle('submitted')
     }"
     x-init="
        $watch('currentStep', () => window.scrollTo({top: 0, behavior: 'smooth'}));
        $watch('submitted', () => window.scrollTo({top: 0, behavior: 'smooth'}));
     ">
    
    @teleport('#header-action')
        <a href="{{ route('home') }}" class="text-sm font-bold text-gray-500 hover:text-primary transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">home</span>
            Return Home
        </a>
    @endteleport

    @if($submitted)
        <!-- Success State -->
        <div class="glass-card rounded-3xl shadow-xl border border-green-200 dark:border-green-950/20 overflow-hidden text-center p-12 flex flex-col items-center gap-6">
            <div class="size-20 rounded-full bg-green-100 dark:bg-green-950/30 text-green-600 dark:text-green-400 flex items-center justify-center animate-bounce">
                <span class="material-symbols-outlined text-5xl">check_circle</span>
            </div>
            
            <div class="space-y-2">
                <h2 class="text-2xl font-black text-green-800 dark:text-green-400 uppercase tracking-tight">Registration Request Submitted</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 max-w-md mx-auto leading-relaxed">
                    Thank you for signing up! Your faculty access request is currently pending administrator review and approval.
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-500 max-w-sm mx-auto leading-relaxed mt-2">
                    Once approved, you will be able to log into the ASPIRE Portal using your official email and password.
                </p>
            </div>

            <div class="pt-4 border-t border-gray-100 dark:border-white/5 w-full max-w-xs flex flex-col gap-2">
                <a href="{{ route('home') }}" class="w-full py-3 bg-primary text-white rounded-xl text-sm font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] transition-transform">
                    Go back to Homepage
                </a>
            </div>
        </div>
    @else
        <!-- Progress Tracker -->
        <div class="glass-card rounded-2xl p-6 shadow-sm border border-[#e7cfcf] dark:border-white/10">
            <div class="flex flex-col gap-4">
                <div class="flex justify-between items-center">
                    <div>
                        <span class="text-xs font-black uppercase tracking-widest text-[#9a4c4c] dark:text-white/60">Faculty Access Request</span>
                        <h2 class="text-xl font-bold text-[#1b0d0d] dark:text-[#fcf8f8] mt-0.5">
                            Step {{ $currentStep }} of 4: 
                            @if($currentStep == 1) Account Information
                            @elseif($currentStep == 2) Professional Details
                            @elseif($currentStep == 3) Assignment & Plantilla
                            @elseif($currentStep == 4) Review & Submit
                            @endif
                        </h2>
                    </div>
                    <span class="text-primary font-bold text-sm bg-primary/5 px-3 py-1.5 rounded-xl border border-primary/10">
                        {{ round((($currentStep - 1) / 3) * 100) }}% Complete
                    </span>
                </div>
                
                <!-- Stepper Progress Bar -->
                <div class="relative w-full h-2 bg-gray-200 dark:bg-white/10 rounded-full overflow-hidden">
                    <div class="absolute top-0 left-0 h-full bg-primary transition-all duration-500 rounded-full" style="width: {{ (($currentStep - 1) / 3) * 100 }}%"></div>
                </div>

                <!-- Stepper Labels (Desktop Only) -->
                <div class="hidden sm:grid grid-cols-4 text-[10px] font-black uppercase tracking-wider text-center text-gray-500 dark:text-gray-400">
                    <div class="{{ $currentStep >= 1 ? 'text-primary' : '' }}">Account Info</div>
                    <div class="{{ $currentStep >= 2 ? 'text-primary' : '' }}">Professional</div>
                    <div class="{{ $currentStep >= 3 ? 'text-primary' : '' }}">Plantilla & Position</div>
                    <div class="{{ $currentStep >= 4 ? 'text-primary' : '' }}">Review</div>
                </div>
            </div>
        </div>

        <form wire:submit.prevent="submit" class="space-y-6">
            @if($currentStep == 1)
                <!-- STEP 1: Account Information -->
                <section wire:key="signup-step-1" class="glass-card rounded-2xl shadow-sm border border-[#e7cfcf] dark:border-white/10 overflow-hidden">
                    <div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5">
                        <h3 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-lg font-bold leading-tight tracking-tight uppercase">Account Credentials</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Please enter your personal details and desired password to secure your portal access.</p>
                    </div>
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Full Name -->
                        <div class="md:col-span-2 space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Full Name</label>
                            <input wire:model.live.debounce.250ms="name" type="text" 
                                   class="w-full px-4 py-3 bg-white/50 dark:bg-black/20 border border-[#e7cfcf] dark:border-white/20 rounded-xl text-sm focus:ring-primary focus:border-primary @error('name') border-red-500 ring-red-500 @enderror" 
                                   placeholder="e.g. Maria Clara M. Santos">
                            @error('name') <span class="text-[10px] text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Gender -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Gender</label>
                            <select wire:model.live="gender" 
                                    class="w-full px-4 py-3 bg-white/50 dark:bg-black/20 border border-[#e7cfcf] dark:border-white/20 rounded-xl text-sm focus:ring-primary focus:border-primary @error('gender') border-red-500 ring-red-500 @enderror">
                                <option value="" selected disabled>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            @error('gender') <span class="text-[10px] text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Official Email</label>
                            <input wire:model.live.debounce.250ms="email" type="email" 
                                   class="w-full px-4 py-3 bg-white/50 dark:bg-black/20 border border-[#e7cfcf] dark:border-white/20 rounded-xl text-sm focus:ring-primary focus:border-primary @error('email') border-red-500 ring-red-500 @enderror" 
                                   placeholder="e.g. maria.clara@tnts.edu.ph">
                            @error('email') <span class="text-[10px] text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Password -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Password</label>
                            <input wire:model.live.debounce.250ms="password" type="password" 
                                   class="w-full px-4 py-3 bg-white/50 dark:bg-black/20 border border-[#e7cfcf] dark:border-white/20 rounded-xl text-sm focus:ring-primary focus:border-primary @error('password') border-red-500 ring-red-500 @enderror" 
                                   placeholder="Minimum 8 characters">
                            @error('password') <span class="text-[10px] text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Confirm Password</label>
                            <input wire:model.live.debounce.250ms="password_confirmation" type="password" 
                                   class="w-full px-4 py-3 bg-white/50 dark:bg-black/20 border border-[#e7cfcf] dark:border-white/20 rounded-xl text-sm focus:ring-primary focus:border-primary @error('password_confirmation') border-red-500 ring-red-500 @enderror" 
                                   placeholder="Repeat your password">
                            @error('password_confirmation') <span class="text-[10px] text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </section>
            @elseif($currentStep == 2)
                <!-- STEP 2: Professional Details -->
                <section wire:key="signup-step-2" class="glass-card rounded-2xl shadow-sm border border-[#e7cfcf] dark:border-white/10 overflow-hidden">
                    <div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5">
                        <h3 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-lg font-bold leading-tight tracking-tight uppercase">Professional Details</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Provide your official Faculty ID, target secondary level, and department allocation.</p>
                    </div>
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Faculty ID -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Faculty ID Number</label>
                            <input wire:model.live.debounce.250ms="faculty_id" type="text" 
                                   class="w-full px-4 py-3 bg-white/50 dark:bg-black/20 border border-[#e7cfcf] dark:border-white/20 rounded-xl text-sm focus:ring-primary focus:border-primary @error('faculty_id') border-red-500 ring-red-500 @enderror" 
                                   placeholder="e.g. TNTS-2026-008">
                            @error('faculty_id') <span class="text-[10px] text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Level Select -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Secondary Level</label>
                            <select wire:model.live="level" 
                                    class="w-full px-4 py-3 bg-white/50 dark:bg-black/20 border border-[#e7cfcf] dark:border-white/20 rounded-xl text-sm focus:ring-primary focus:border-primary @error('level') border-red-500 ring-red-500 @enderror">
                                <option value="" selected disabled>Choose Secondary Level</option>
                                <option value="JHS">Junior High School (JHS)</option>
                                <option value="SHS">Senior High School (SHS)</option>
                            </select>
                            @error('level') <span class="text-[10px] text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Department Select -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Department</label>
                            <select wire:model.live="department_id" 
                                    class="w-full px-4 py-3 bg-white/50 dark:bg-black/20 border border-[#e7cfcf] dark:border-white/20 rounded-xl text-sm focus:ring-primary focus:border-primary disabled:opacity-50 disabled:cursor-not-allowed @error('department_id') border-red-500 ring-red-500 @enderror" 
                                    {{ empty($level) ? 'disabled' : '' }}>
                                <option value="" selected disabled>Choose Department</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                            @error('department_id') <span class="text-[10px] text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </section>
            @elseif($currentStep == 3)
                <!-- STEP 3: Position & Plantilla -->
                <section wire:key="signup-step-3" class="glass-card rounded-2xl shadow-sm border border-[#e7cfcf] dark:border-white/10 overflow-hidden">
                    <div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5">
                        <h3 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-lg font-bold leading-tight tracking-tight uppercase">Position & Plantilla Assignment</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Specify your official Plantilla Item Number and designation.</p>
                    </div>
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Plantilla Item Number -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Plantilla Item Number <span class="text-gray-400 lowercase normal-case ml-1">(Optional)</span></label>
                            <input wire:model.live.debounce.250ms="plantilla_item_number" type="text" 
                                   class="w-full px-4 py-3 bg-white/50 dark:bg-black/20 border border-[#e7cfcf] dark:border-white/20 rounded-xl text-sm focus:ring-primary focus:border-primary @error('plantilla_item_number') border-red-500 ring-red-500 @enderror" 
                                   placeholder="e.g. OSEC-DECSB-TCH1-310009-2024">
                            <span class="text-[10px] text-gray-500 mt-1 block">If plantilla item number is not known, leave it blank.</span>
                            @error('plantilla_item_number') <span class="text-[10px] text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Position Select -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Position</label>
                            <select wire:model.live="position_id" 
                                    class="w-full px-4 py-3 bg-white/50 dark:bg-black/20 border border-[#e7cfcf] dark:border-white/20 rounded-xl text-sm focus:ring-primary focus:border-primary @error('position_id') border-red-500 ring-red-500 @enderror">
                                <option value="" selected disabled>Choose Position</option>
                                @foreach($positions->groupBy('type') as $type => $group)
                                    <optgroup label="{{ $type }}">
                                        @foreach($group as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            @error('position_id') <span class="text-[10px] text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </section>
            @elseif($currentStep == 4)
                <!-- STEP 4: Review Details -->
                <section wire:key="signup-step-4" class="glass-card rounded-2xl shadow-sm border border-[#e7cfcf] dark:border-white/10 overflow-hidden">
                    <div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5">
                        <h3 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-lg font-bold leading-tight tracking-tight uppercase">Review and Verify Details</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Please double-check all details below. Once verified, click submit to forward your signup request to administrators.</p>
                    </div>
                    
                    <div class="p-8 space-y-6">
                        <!-- Summary Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                            <div>
                                <span class="text-[9px] font-black uppercase tracking-wider text-gray-400">Full Name</span>
                                <p class="text-sm font-bold text-[#1b0d0d] dark:text-[#fcf8f8]">{{ $name }}</p>
                            </div>
                            <div>
                                <span class="text-[9px] font-black uppercase tracking-wider text-gray-400">Gender</span>
                                <p class="text-sm font-bold text-[#1b0d0d] dark:text-[#fcf8f8]">{{ $gender }}</p>
                            </div>
                            <div>
                                <span class="text-[9px] font-black uppercase tracking-wider text-gray-400">Official Email</span>
                                <p class="text-sm font-bold text-[#1b0d0d] dark:text-[#fcf8f8]">{{ $email }}</p>
                            </div>
                            <div>
                                <span class="text-[9px] font-black uppercase tracking-wider text-gray-400">Faculty ID</span>
                                <p class="text-sm font-bold text-[#1b0d0d] dark:text-[#fcf8f8]">{{ $faculty_id }}</p>
                            </div>
                            <div>
                                <span class="text-[9px] font-black uppercase tracking-wider text-gray-400">Secondary Level</span>
                                <p class="text-sm font-bold text-[#1b0d0d] dark:text-[#fcf8f8]">{{ $level }}</p>
                            </div>
                            <div>
                                <span class="text-[9px] font-black uppercase tracking-wider text-gray-400">Department</span>
                                <p class="text-sm font-bold text-[#1b0d0d] dark:text-[#fcf8f8]">
                                    {{ \App\Models\Department::find($department_id)?->name ?? 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <span class="text-[9px] font-black uppercase tracking-wider text-gray-400">Designation Position</span>
                                <p class="text-sm font-bold text-[#1b0d0d] dark:text-[#fcf8f8]">
                                    {{ \App\Models\Position::find($position_id)?->name ?? 'N/A' }}
                                </p>
                            </div>
                            <div class="md:col-span-2">
                                <span class="text-[9px] font-black uppercase tracking-wider text-gray-400">Plantilla Item Number</span>
                                <p class="text-sm font-bold font-mono text-[#1b0d0d] dark:text-[#fcf8f8] bg-black/5 dark:bg-white/5 px-3 py-1.5 rounded-lg border border-black/5 dark:border-white/5 w-fit">
                                    {{ empty($plantilla_item_number) ? 'N/A' : $plantilla_item_number }}
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            <!-- Stepper Actions -->
            <div class="flex items-center justify-between pt-4">
                @if($currentStep > 1)
                    <button type="button" wire:click="previousStep" 
                            class="px-6 py-3 bg-white dark:bg-white/5 border border-[#e7cfcf] dark:border-white/10 text-gray-700 dark:text-gray-300 rounded-xl text-sm font-bold shadow-sm hover:bg-gray-50 dark:hover:bg-white/10 transition-colors flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm">arrow_back</span>
                        Back
                    </button>
                @else
                    <div></div> <!-- Empty placeholder for flex alignment -->
                @endif

                @if($currentStep < 4)
                    <button type="button" wire:click="nextStep" 
                            class="px-8 py-3 bg-primary text-white rounded-xl text-sm font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] transition-transform flex items-center gap-1.5">
                        Continue
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </button>
                @else
                    <button type="submit" 
                            class="px-10 py-3 bg-primary text-white rounded-xl text-sm font-black shadow-lg shadow-primary/20 hover:scale-[1.02] transition-transform flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">publish</span>
                        Submit Signup Request
                    </button>
                @endif
            </div>
        </form>
    @endif
</div>
