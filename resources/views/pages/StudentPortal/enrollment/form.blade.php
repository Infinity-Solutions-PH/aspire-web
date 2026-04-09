
<div class="max-w-[960px] w-full flex flex-col gap-6 mx-auto py-4 px-4">
    <!-- Progress Tracker -->
    <div class="glass-card rounded-xl p-6 shadow-sm border border-[#e7cfcf] dark:border-white/10">
        <div class="flex flex-col gap-3">
            <div class="flex gap-6 justify-between items-center">
                <p class="text-[#1b0d0d] dark:text-[#fcf8f8] text-lg font-bold leading-normal">
                    Step {{ $current_step }} of 6: 
                    @if($current_step == 1) Enrollment Intent
                    @elseif($current_step == 2) Student Information
                    @elseif($current_step == 3) Address Information
                    @elseif($current_step == 4) Parent/Guardian Information
                    @elseif($current_step == 5) Academic History & Preferences
                    @elseif($current_step == 6) Document Upload
                    @endif
                </p>
                <p class="text-primary text-sm font-semibold leading-normal">{{ round(($current_step / 6) * 100) }}% Complete</p>
            </div>
            <div class="rounded-full bg-[#e7cfcf] dark:bg-white/10 overflow-hidden h-2.5">
                <div class="h-full rounded-full bg-primary transition-all duration-500" :style="'width: ' + (($wire.current_step / 6) * 100) + '%'"></div>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="submit" class="space-y-6">
        @if($current_step == 1)
        <!-- Step 1: Enrollment Intent -->
        <section class="glass-card rounded-xl shadow-sm border border-[#e7cfcf] dark:border-white/10 overflow-hidden">
            <div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5">
                <h2 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-xl font-bold leading-tight tracking-tight">Enrollment Intent</h2>
                <p class="text-sm text-[#9a4c4c] dark:text-[#e7cfcf] mt-1">Specify your target grade level for the upcoming school year.</p>
            </div>
            <div class="p-8 space-y-6">
                <div class="flex flex-col gap-2">
                    <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Enrollment Type</span>
                    <div class="flex flex-wrap gap-4 mt-2">
                        <label class="flex items-center gap-3 bg-white/50 dark:bg-black/20 px-6 py-4 rounded-xl border border-[#e7cfcf] dark:border-white/20 cursor-pointer hover:border-primary transition-all flex-1 min-w-[200px]">
                            <input type="radio" value="Incoming Grade 7" wire:model.defer="enrollment_type" class="text-primary focus:ring-primary h-5 w-5" />
                            <div class="flex flex-col">
                                <span class="text-sm font-bold">Incoming Grade 7</span>
                                <span class="text-[10px] text-gray-400">Fresh from Elementary</span>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 bg-white/50 dark:bg-black/20 px-6 py-4 rounded-xl border border-[#e7cfcf] dark:border-white/20 cursor-pointer hover:border-primary transition-all flex-1 min-w-[200px]">
                            <input type="radio" value="Transferee" wire:model.defer="enrollment_type" class="text-primary focus:ring-primary h-5 w-5" />
                            <div class="flex flex-col">
                                <span class="text-sm font-bold">Transferee</span>
                                <span class="text-[10px] text-gray-400">From another school</span>
                            </div>
                        </label>
                        @if(Auth::user()->role === 'student')
                        <label class="flex items-center gap-3 bg-white/50 dark:bg-black/20 px-6 py-4 rounded-xl border border-[#e7cfcf] dark:border-white/20 cursor-pointer hover:border-primary transition-all flex-1 min-w-[200px]">
                            <input type="radio" value="Promoted" wire:model.defer="enrollment_type" class="text-primary focus:ring-primary h-5 w-5" />
                            <div class="flex flex-col">
                                <span class="text-sm font-bold">Promoted</span>
                                <span class="text-[10px] text-gray-400">Continuing Student</span>
                            </div>
                        </label>
                        @endif
                    </div>
                    @error('enrollment_type') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-2 pt-6 border-t border-[#e7cfcf] dark:border-white/10 mt-6">
                    <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Grade Level to Enroll</span>
                    <select wire:model.defer="grade_level" class="form-select rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm">
                        <option value="">Select Grade Level</option>
                        <optgroup label="Junior High School">
                            <option value="Grade 7">Grade 7</option>
                            <option value="Grade 8">Grade 8</option>
                            <option value="Grade 9">Grade 9</option>
                            <option value="Grade 10">Grade 10</option>
                        </optgroup>
                        <optgroup label="Senior High School">
                            <option value="Grade 11">Grade 11</option>
                            <option value="Grade 12">Grade 12</option>
                        </optgroup>
                    </select>
                    @error('grade_level') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
        </section>
        @endif

        @if($current_step == 2)
        <!-- Step 2: Student Information -->
        <section class="glass-card rounded-xl shadow-sm border border-[#e7cfcf] dark:border-white/10 overflow-hidden">
            <div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5">
                <h2 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-xl font-bold leading-tight tracking-tight">Student Information</h2>
                <p class="text-sm text-[#9a4c4c] dark:text-[#e7cfcf] mt-1">Please provide accurate personal information as it appears on your official records.</p>
            </div>
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <label class="flex flex-col gap-2">
                    <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">First Name</span>
                    <input wire:model.defer="first_name" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" placeholder="e.g. Juan" type="text"/>
                    @error('first_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </label>
                <label class="flex flex-col gap-2">
                    <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Last Name</span>
                    <input wire:model.defer="last_name" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" placeholder="e.g. Dela Cruz" type="text"/>
                    @error('last_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </label>
                <label class="flex flex-col gap-2">
                    <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Learner Reference Number (LRN)</span>
                    <input wire:model.defer="lrn" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" placeholder="12-digit number" type="text"/>
                    @error('lrn') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </label>
                <label class="flex flex-col gap-2">
                    <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Date of Birth</span>
                    <input wire:model.defer="birthdate" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" type="date"/>
                    @error('birthdate') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </label>
                <label class="flex flex-col gap-2">
                    <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Sex</span>
                    <select wire:model.defer="sex" class="form-select rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm">
                        <option value="">Select Sex</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </label>

                <!-- Dynamic Toggles -->
                <div class="md:col-span-2 space-y-4 pt-4 border-t border-[#e7cfcf] dark:border-white/10">
                    <label class="flex items-center gap-3">
                        <input type="checkbox" wire:model="is_ip" class="rounded border-[#e7cfcf] text-primary focus:ring-primary" />
                        <span class="text-sm font-medium">Do you belong to an Indigenous Peoples (IP) Community?</span>
                    </label>
                    <div x-show="$wire.is_ip" x-transition class="ml-8">
                        <input wire:model.defer="ip_community" class="form-input w-full rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" placeholder="Please specify IP Community" type="text"/>
                    </div>

                    <label class="flex items-center gap-3">
                        <input type="checkbox" wire:model="is_4ps" class="rounded border-[#e7cfcf] text-primary focus:ring-primary" />
                        <span class="text-sm font-medium">Is the family a 4Ps beneficiary?</span>
                    </label>
                    <div x-show="$wire.is_4ps" x-transition class="ml-8">
                        <input wire:model.defer="household_id" class="form-input w-full rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" placeholder="4Ps Household ID Number" type="text"/>
                    </div>

                    <label class="flex items-center gap-3">
                        <input type="checkbox" wire:model="has_disability" class="rounded border-[#e7cfcf] text-primary focus:ring-primary" />
                        <span class="text-sm font-medium">Are you a Learner with Disability (LSEN)?</span>
                    </label>
                    <div x-show="$wire.has_disability" x-transition class="grid grid-cols-2 md:grid-cols-3 gap-2 ml-8 bg-black/5 dark:bg-white/5 p-4 rounded-xl">
                        @foreach(['Visual Impairment', 'Learning Disability', 'Autism Spectrum Disorder', 'Hearing Impairment', 'Intellectual Disability', 'Speech/Language Impairment', 'Multiple Disability'] as $type)
                        <label class="flex items-center gap-2">
                            <input type="checkbox" value="{{ $type }}" wire:model.defer="disability_types" class="rounded text-primary focus:ring-primary" />
                            <span class="text-xs">{{ $type }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        @endif

        @if($current_step == 3)
        <!-- Step 3: Address Information -->
        <section class="glass-card rounded-xl shadow-sm border border-[#e7cfcf] dark:border-white/10 overflow-hidden">
            <div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5">
                <h2 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-xl font-bold leading-tight tracking-tight">Address Information</h2>
                <p class="text-sm text-[#9a4c4c] dark:text-[#e7cfcf] mt-1">Current place of residence.</p>
            </div>
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <label class="flex flex-col gap-2">
                    <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">House No. & Street</span>
                    <input wire:model.defer="current_house_no" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" placeholder="e.g. 123 Main St" type="text"/>
                </label>
                <label class="flex flex-col gap-2">
                    <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Barangay</span>
                    <input wire:model.defer="current_barangay" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" placeholder="e.g. Daang Amaya" type="text"/>
                </label>
                <label class="flex flex-col gap-2">
                    <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">City / Municipality</span>
                    <input wire:model.defer="current_municipality" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" placeholder="e.g. Tanza" type="text"/>
                </label>
                <label class="flex flex-col gap-2">
                    <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Province</span>
                    <input wire:model.defer="current_province" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" placeholder="e.g. Cavite" type="text"/>
                </label>

                <!-- Permanent Address Toggle -->
                <div class="md:col-span-2 pt-4 border-t border-[#e7cfcf] dark:border-white/10 space-y-6">
                    <label class="flex items-center gap-3">
                        <input type="checkbox" wire:model="is_same_address" class="rounded border-[#e7cfcf] text-primary focus:ring-primary" />
                        <span class="text-sm font-medium">Permanent address is the same with current address?</span>
                    </label>

                    <div x-show="!$wire.is_same_address" x-transition class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-black/5 dark:bg-white/5 p-6 rounded-xl">
                        <label class="flex flex-col gap-2">
                            <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold font-italic opacity-70">Permanent House No.</span>
                            <input wire:model.defer="permanent_house_no" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" type="text"/>
                        </label>
                        <label class="flex flex-col gap-2">
                            <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold font-italic opacity-70">Permanent Barangay</span>
                            <input wire:model.defer="permanent_barangay" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" type="text"/>
                        </label>
                        <label class="flex flex-col gap-2">
                            <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold font-italic opacity-70">Permanent City/Municipality</span>
                            <input wire:model.defer="permanent_municipality" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" type="text"/>
                        </label>
                    </div>
                </div>
            </div>
        </section>
        @endif

        @if($current_step == 4)
        <!-- Step 4: Parent's/Guardian's Information -->
        <section class="glass-card rounded-xl shadow-sm border border-[#e7cfcf] dark:border-white/10 overflow-hidden">
            <div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5">
                <h2 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-xl font-bold leading-tight tracking-tight">Parent / Guardian Information</h2>
            </div>
            <div class="p-8 grid grid-cols-1 gap-6">
                <label class="flex flex-col gap-2">
                    <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Father Full Name</span>
                    <input wire:model.defer="father_name" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" placeholder="First Name, M.I., Last Name" type="text"/>
                </label>
                <label class="flex flex-col gap-2">
                    <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Mother Maiden Name</span>
                    <input wire:model.defer="mother_maiden_name" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" placeholder="Full Maiden Name" type="text"/>
                </label>
                <label class="flex flex-col gap-2">
                    <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Legal Guardian Name</span>
                    <input wire:model.defer="guardian_name" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" placeholder="Full Name (if applicable)" type="text"/>
                </label>
                <label class="flex flex-col gap-2 max-w-sm">
                    <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Primary Contact Number</span>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-mono">+63</span>
                        <input wire:model.defer="contact_no" class="form-input w-full rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm pl-12" placeholder="9XXXXXXXXX" type="text"/>
                    </div>
                    @error('contact_no') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </label>
            </div>
        </section>
        @endif

        @if($current_step == 5)
        <!-- Step 5: Academic History & Preferences -->
        <section class="glass-card rounded-xl shadow-sm border border-[#e7cfcf] dark:border-white/10 overflow-hidden">
            <div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5">
                <h2 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-xl font-bold leading-tight tracking-tight">Academic History & Preferences</h2>
            </div>
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <label class="flex flex-col gap-2">
                    <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Last Grade Level Completed</span>
                    <select wire:model.defer="last_grade_level" class="form-select rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm">
                        <option value="">Select Level</option>
                        @foreach(['Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11'] as $lvl)
                            <option value="{{ $lvl }}">{{ $lvl }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="flex flex-col gap-2">
                    <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Last School Year Completed</span>
                    <input wire:model.defer="last_school_year" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" placeholder="e.g. 2023-2024" type="text"/>
                </label>
                <label class="flex flex-col gap-2 md:col-span-2">
                    <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Last School Attended</span>
                    <input wire:model.defer="last_school_attended" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" placeholder="Full School Name" type="text"/>
                </label>

                <!-- Grade 8 Track Selection Module -->
                @if(str_contains($grade_level, 'Grade 8'))
                <div class="md:col-span-2 p-8 bg-primary/5 rounded-2xl border border-primary/20 space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="size-10 bg-primary rounded-lg flex items-center justify-center text-white">
                            <span class="material-symbols-outlined">ranking</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Tech-Voc Specialization Ranking</h3>
                            <p class="text-xs text-gray-500">Rank your top 3 choices (1 = Most Preferred). Available based on G7 Exploratory grades.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @php
                            $specializations = [
                                'Consumer Electronics Servicing',
                                'Computer Systems Servicing',
                                'Electrical Installation and Maintenance',
                                'Automotive Servicing',
                                'Dressmaking/Tailoring',
                                'Food and Beverage Services',
                                'Shielded Metal Arc Welding'
                            ];
                        @endphp

                        @foreach(['rank1' => '1st Choice', 'rank2' => '2nd Choice', 'rank3' => '3rd Choice'] as $model => $label)
                        <label class="flex flex-col gap-2">
                            <span class="text-xs font-bold text-primary uppercase">{{ $label }}</span>
                            <select wire:model.defer="{{ $model }}" class="form-select w-full rounded-xl border-gray-200 bg-white text-sm focus:ring-primary focus:border-primary">
                                <option value="">Select Specialization</option>
                                @foreach($specializations as $spec)
                                    <option value="{{ $spec }}" @if(($rank1 == $spec && $model != 'rank1') || ($rank2 == $spec && $model != 'rank2') || ($rank3 == $spec && $model != 'rank3')) disabled @endif>
                                        {{ $spec }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- SHS Strand Selection Module -->
                @if(str_contains($grade_level, 'Grade 11') || str_contains($grade_level, 'Grade 12'))
                <div class="md:col-span-2 p-8 bg-primary/5 rounded-2xl border border-primary/20 space-y-6" x-data="{ track: @entangle('shs_track') }">
                    <div class="flex items-center gap-3">
                        <div class="size-10 bg-primary rounded-lg flex items-center justify-center text-white">
                            <span class="material-symbols-outlined">account_tree</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Senior High School Tracking</h3>
                            <p class="text-xs text-gray-500">Select your academic or vocational track and strand.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <label class="flex flex-col gap-2">
                            <span class="text-xs font-bold text-primary uppercase">SHS Track</span>
                            <select wire:model.lazy="shs_track" class="form-select rounded-xl border-gray-200 bg-white text-sm focus:ring-primary focus:border-primary">
                                <option value="">Select Track</option>
                                <option value="Academic">Academic</option>
                                <option value="TVL">TVL (Technical-Vocational-Livelihood)</option>
                            </select>
                        </label>

                        <label class="flex flex-col gap-2">
                            <span class="text-xs font-bold text-primary uppercase">Strand</span>
                            <select wire:model.defer="strand" class="form-select rounded-xl border-gray-200 bg-white text-sm focus:ring-primary focus:border-primary">
                                <option value="">Select Strand</option>
                                <template x-if="track === 'Academic'">
                                    <optgroup label="Academic Strands">
                                        <option value="STEM">STEM (Science, Tech, Engineering, Math)</option>
                                        <option value="HUMSS">HUMSS (Humanities and Social Sciences)</option>
                                        <option value="GAS">GAS (General Academic Strand)</option>
                                    </optgroup>
                                </template>
                                <template x-if="track === 'TVL'">
                                    <optgroup label="TVL Strands">
                                        <option value="ICT">ICT (Information and Communications Technology)</option>
                                        <option value="HE">HE (Home Economics)</option>
                                        <option value="IA">IA (Industrial Arts)</option>
                                    </optgroup>
                                </template>
                            </select>
                        </label>
                    </div>

                    <div class="flex items-center gap-3 p-4 bg-white/50 rounded-xl border border-primary/10">
                        <input type="checkbox" wire:model="is_shs_aligned" class="rounded text-primary focus:ring-primary" />
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-gray-900">Track Alignment Check</span>
                            <p class="text-[10px] text-gray-500">My chosen SHS strand aligns with my previous Technical-Vocational specialization.</p>
                        </div>
                    </div>
                </div>
                @endif

                <div class="md:col-span-2 pt-4 border-t border-[#e7cfcf] dark:border-white/10 flex flex-col gap-2">
                    <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Preferred Distance Learning Modality</span>
                    <div class="flex flex-wrap gap-4 mt-2">
                        @foreach(['Modular (Print)', 'Online', 'Blended', 'Modular (Digital)'] as $mode)
                        <label class="flex items-center gap-2 bg-white/30 dark:bg-black/30 px-4 py-2 rounded-lg border border-[#e7cfcf] dark:border-white/10 cursor-pointer hover:border-primary transition-all">
                            <input type="radio" value="{{ $mode }}" wire:model.defer="modality" class="text-primary focus:ring-primary" />
                            <span class="text-sm">{{ $mode }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        @endif

        @if($current_step == 6)
        <!-- Step 6: Document Uploads -->
        <section class="glass-card rounded-xl shadow-sm border border-[#e7cfcf] dark:border-white/10 overflow-hidden">
            <div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5">
                <h2 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-xl font-bold leading-tight tracking-tight">Document Upload</h2>
                <p class="text-sm text-[#9a4c4c] dark:text-[#e7cfcf] mt-1">Upload scanned copies or clear photos of required documents (Max 5MB each, PDF/JPG/PNG).</p>
            </div>
            <div class="p-8 flex flex-col gap-8">
                <!-- PSA Birth Certificate -->
                <div class="flex flex-col gap-2">
                    <p class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">PSA Birth Certificate</p>
                    <div class="relative border-2 border-dashed border-[#e7cfcf] dark:border-white/20 rounded-xl p-8 flex flex-col items-center justify-center gap-3 bg-white/20 dark:bg-black/10 hover:border-primary/50 transition-colors cursor-pointer group">
                        <input type="file" wire:model="psa_file" accept=".pdf,.jpg,.jpeg,.png" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                        <span class="material-symbols-outlined text-primary text-4xl group-hover:scale-110 transition-transform">upload_file</span>
                        <div class="text-center">
                            <p class="text-sm font-medium text-[#1b0d0d] dark:text-[#fcf8f8]">
                                @if($psa_file) <span class="text-green-500 font-bold">✓ {{ $psa_file->getClientOriginalName() }}</span> @else Drag and drop your file here or <span class="text-primary font-bold">browse</span> @endif
                            </p>
                            <p class="text-xs text-[#9a4c4c] dark:text-[#e7cfcf] mt-1">Accepts PDF, JPG, PNG</p>
                        </div>
                    </div>
                    @error('psa_file') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Form 138 -->
                    <div class="flex flex-col gap-2">
                        <p class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Form 138 (Report Card)</p>
                        <div class="relative border-2 border-dashed border-[#e7cfcf] dark:border-white/20 rounded-xl p-6 flex flex-col items-center justify-center gap-2 bg-white/20 dark:bg-black/10 hover:border-primary/50 transition-colors cursor-pointer group">
                            <input type="file" wire:model="sf9_file" accept=".pdf,.jpg,.jpeg,.png" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                            <span class="material-symbols-outlined text-primary text-2xl">@if($sf9_file) check_circle @else add_a_photo @endif</span>
                            <p class="text-xs font-medium text-[#1b0d0d] dark:text-[#fcf8f8]">@if($sf9_file) {{ $sf9_file->getClientOriginalName() }} @else Select File @endif</p>
                        </div>
                        @error('sf9_file') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <!-- Good Moral -->
                    <div class="flex flex-col gap-2">
                        <p class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Certificate of Good Moral @if($enrollment_type === 'Transferee') <span class="text-red-500 font-bold">*</span> @endif</p>
                        <div class="relative border-2 border-dashed border-[#e7cfcf] dark:border-white/20 rounded-xl p-6 flex flex-col items-center justify-center gap-2 bg-white/20 dark:bg-black/10 hover:border-primary/50 transition-colors cursor-pointer group">
                            <input type="file" wire:model="good_moral_file" accept=".pdf,.jpg,.jpeg,.png" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                            <span class="material-symbols-outlined text-primary text-2xl">@if($good_moral_file) check_circle @else add_a_photo @endif</span>
                            <p class="text-xs font-medium text-[#1b0d0d] dark:text-[#fcf8f8]">@if($good_moral_file) {{ $good_moral_file->getClientOriginalName() }} @else Select File @endif</p>
                        </div>
                        @error('good_moral_file') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Honorable Dismissal (Transferee Only) -->
                @if($enrollment_type === 'Transferee')
                <div class="flex flex-col gap-2">
                    <p class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Honorable Dismissal <span class="text-red-500 font-bold">*</span></p>
                    <div class="relative border-2 border-dashed border-[#e7cfcf] dark:border-white/20 rounded-xl p-6 flex flex-col items-center justify-center gap-2 bg-white/20 dark:bg-black/10 hover:border-primary/50 transition-colors cursor-pointer group">
                        <input type="file" wire:model="honorable_dismissal_file" accept=".pdf,.jpg,.jpeg,.png" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                        <span class="material-symbols-outlined text-primary text-2xl">upload</span>
                        <p class="text-xs font-medium text-[#1b0d0d] dark:text-[#fcf8f8]">Required for transferees</p>
                    </div>
                    @error('honorable_dismissal_file') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                @endif

                <div class="pt-8 border-t border-[#e7cfcf] dark:border-white/10">
                    <label class="flex items-start gap-4 p-4 bg-primary/5 rounded-xl border border-primary/10 cursor-pointer">
                        <input type="checkbox" wire:model.live="consent" class="mt-1 rounded text-primary focus:ring-primary @error('consent') border-red-500 @enderror" />
                        <div class="flex flex-col gap-1">
                            <span class="text-sm font-bold text-gray-900 dark:text-white">Data Privacy Consent</span>
                            @error('consent') <span class="text-red-500 text-[10px] font-bold">Please accept the data privacy consent.</span> @enderror
                            <p class="text-xs text-gray-500 leading-relaxed">
                                I hereby certify that all information provided is true and correct. I authorize Tanza National Trade School to collect and process my personal data for enrollment purposes in accordance with the Data Privacy Act of 2012.
                            </p>
                        </div>
                    </label>
                </div>
            </div>
        </section>
        @endif

        <!-- Navigation Buttons -->
        <div class="flex justify-between items-center py-6">
            @if($current_step > 1)
            <button type="button" wire:click="previousStep" class="flex items-center gap-2 px-6 py-3 rounded-lg font-bold text-[#1b0d0d] dark:text-[#fcf8f8] border border-[#e7cfcf] dark:border-white/20 hover:bg-white/50 dark:hover:bg-white/10 transition-all">
                <span class="material-symbols-outlined">arrow_back</span>
                Back
            </button>
            @else
            <div></div>
            @endif

            <div class="flex gap-4">
                <button type="button" wire:click="saveDraft" wire:loading.attr="disabled" class="px-6 py-3 rounded-lg font-bold text-[#1b0d0d] dark:text-[#fcf8f8] hover:bg-white/50 dark:hover:bg-white/10 transition-all">
                    <span wire:loading wire:target="saveDraft" class="animate-spin mr-2">...</span>
                    Save Draft
                </button>

                @if($current_step < 6)
                <button type="button" wire:click="nextStep" class="bg-primary text-white px-8 py-3 rounded-lg font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all flex items-center gap-2">
                    Next
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
                @else
                <button type="submit" wire:loading.attr="disabled" class="bg-green-600 text-white px-10 py-3 rounded-lg font-bold shadow-lg shadow-green-600/20 hover:bg-green-700 transition-all flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span wire:loading wire:target="submit" class="animate-spin material-symbols-outlined text-sm">progress_activity</span>
                    <span wire:loading.remove wire:target="submit">Submit Enrollment</span>
                    <span wire:loading wire:target="submit">Submitting...</span>
                    <span class="material-symbols-outlined" wire:loading.remove wire:target="submit">rocket_launch</span>
                </button>
                @endif
            </div>
        </div>
    </form>
</div>