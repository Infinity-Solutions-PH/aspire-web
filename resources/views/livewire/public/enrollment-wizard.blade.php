<div class="max-w-[960px] w-full flex flex-col gap-6 mx-auto py-4 px-4" x-data="{ resumed: @entangle('is_resumed') }">
    @if($currentStep == 0)
        <!-- Step 0: Initiation Flow -->
        <div class="glass-card rounded-xl shadow-sm border border-[#e7cfcf] dark:border-white/10 overflow-hidden">
            @if($initStep == 0)
                <div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5">
                    <h2 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-xl font-bold leading-tight tracking-tight">Identity Verification</h2>
                    <p class="text-sm text-[#9a4c4c] dark:text-[#e7cfcf] mt-1">Please enter your credentials to initiate enrollment.</p>
                </div>
                <form wire:submit.prevent="validateGateway" class="p-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <label class="flex flex-col gap-2">
                            <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">LRN (12 digits)</span>
                            <input wire:model.defer="lrn" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" placeholder="Learner Reference Number" type="text"/>
                            @error('lrn') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </label>
                        <label class="flex flex-col gap-2">
                            <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Date of Birth</span>
                            <input wire:model.defer="birthdate" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" type="date"/>
                            @error('birthdate') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </label>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-primary text-white px-8 py-3 rounded-lg font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all flex items-center gap-2">
                            Verify Identity
                            <span class="material-symbols-outlined">verified_user</span>
                        </button>
                    </div>
                </form>
            @elseif($initStep == 1)
                <div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5 text-center">
                    <h2 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-xl font-bold leading-tight tracking-tight">Select School Category</h2>
                    <p class="text-sm text-[#9a4c4c] dark:text-[#e7cfcf] mt-1">Which education level are you applying for?</p>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <button wire:click="selectCategory('HS')" class="flex flex-col items-center gap-4 bg-white/50 dark:bg-black/20 p-10 rounded-2xl border border-[#e7cfcf] dark:border-white/10 hover:border-primary hover:bg-primary/5 transition-all group">
                        <span class="material-symbols-outlined text-5xl text-primary/50 group-hover:text-primary transition-colors">school</span>
                        <div class="text-center">
                            <h3 class="text-lg font-bold">High School</h3>
                            <p class="text-xs text-stone-500">Junior High Graduate or Promoted</p>
                        </div>
                    </button>
                    <button wire:click="selectCategory('SHS')" class="flex flex-col items-center gap-4 bg-white/50 dark:bg-black/20 p-10 rounded-2xl border border-[#e7cfcf] dark:border-white/10 hover:border-primary hover:bg-primary/5 transition-all group">
                        <span class="material-symbols-outlined text-5xl text-primary/50 group-hover:text-primary transition-colors">account_tree</span>
                        <div class="text-center">
                            <h3 class="text-lg font-bold">Senior High School</h3>
                            <p class="text-xs text-stone-500">Academic & TVL Strands</p>
                        </div>
                    </button>
                </div>
            @elseif($initStep == 2)
                <div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5 text-center">
                    <h2 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-xl font-bold leading-tight tracking-tight">Enrollment Type</h2>
                    <p class="text-sm text-[#9a4c4c] dark:text-[#e7cfcf] mt-1">Select your status for the upcoming school year.</p>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach(['Incoming Grade 7' => 'New Student', 'Transferee' => 'From Other School', 'Old Student' => 'Promoted Student'] as $val => $sub)
                    <button wire:click="selectType('{{ $val }}')" class="flex flex-col items-center gap-4 bg-white/50 dark:bg-black/20 p-8 rounded-2xl border border-[#e7cfcf] dark:border-white/10 hover:border-primary hover:bg-primary/5 transition-all group">
                        <span class="material-symbols-outlined text-4xl text-primary/50 group-hover:text-primary transition-colors">person_add</span>
                        <div class="text-center">
                            <h3 class="text-sm font-bold">{{ $val }}</h3>
                            <p class="text-[10px] text-stone-500">{{ $sub }}</p>
                        </div>
                    </button>
                    @endforeach
                </div>
            @endif
        </div>
    @else
        <!-- Main Form Wrapper -->
        <!-- Progress Tracker -->
        <div class="glass-card rounded-xl p-6 shadow-sm border border-[#e7cfcf] dark:border-white/10">
            <div class="flex flex-col gap-3">
                <div class="flex gap-6 justify-between items-center">
                    <p class="text-[#1b0d0d] dark:text-[#fcf8f8] text-lg font-bold leading-normal">
                        Step {{ $currentStep }} of 6: 
                        @if($currentStep == 1) Enrollment Intent
                        @elseif($currentStep == 2) Student Information
                        @elseif($currentStep == 3) Address Information
                        @elseif($currentStep == 4) Parent/Guardian Information
                        @elseif($currentStep == 5) Academic History & Preferences
                        @elseif($currentStep == 6) Document Upload
                        @endif
                    </p>
                    <p class="text-primary text-sm font-semibold leading-normal">{{ round(($currentStep / 6) * 100) }}% Complete</p>
                </div>
                <div class="rounded-full bg-[#e7cfcf] dark:bg-white/10 overflow-hidden h-2.5">
                    <div class="h-full rounded-full bg-primary transition-all duration-500" style="width: {{ ($currentStep / 6) * 100 }}%"></div>
                </div>
            </div>
        </div>

        <form wire:submit.prevent="submit" class="space-y-6">
            @if($currentStep == 1)
            <!-- Step 1: Enrollment Intent -->
            <section class="glass-card rounded-xl shadow-sm border border-[#e7cfcf] dark:border-white/10 overflow-hidden">
                <div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5">
                    <h2 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-xl font-bold leading-tight tracking-tight">Enrollment Intent</h2>
                    <p class="text-sm text-[#9a4c4c] dark:text-[#e7cfcf] mt-1">Specify your target grade level.</p>
                </div>
                <div class="p-8 space-y-6">
                    <div class="flex flex-col gap-2">
                        <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Grade Level to Enroll</span>
                        <select wire:model.defer="formData.grade_level" class="form-select rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm">
                            <option value="">Select Grade Level</option>
                            @if($school_category == 'HS')
                            <optgroup label="Junior High School">
                                <option value="Grade 7">Grade 7</option>
                                <option value="Grade 8">Grade 8</option>
                                <option value="Grade 9">Grade 9</option>
                                <option value="Grade 10">Grade 10</option>
                            </optgroup>
                            @else
                            <optgroup label="Senior High School">
                                <option value="Grade 11">Grade 11</option>
                                <option value="Grade 12">Grade 12</option>
                            </optgroup>
                            @endif
                        </select>
                        @error('formData.grade_level') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </section>
            @endif

            @if($currentStep == 2)
            <!-- Step 2: Student Information -->
            <section class="glass-card rounded-xl shadow-sm border border-[#e7cfcf] dark:border-white/10 overflow-hidden">
                <div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5">
                    <h2 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-xl font-bold leading-tight tracking-tight">Student Information</h2>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <label class="flex flex-col gap-2">
                        <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">First Name</span>
                        <input @if($is_resumed) value="{{ $this->maskValue('first_name', $formData['first_name']) }}" @endif
                               @focus="resumed = false"
                               wire:model.defer="formData.first_name" 
                               class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm {{ $is_resumed ? 'text-gray-400' : '' }}" type="text"/>
                    </label>
                    <label class="flex flex-col gap-2">
                        <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Last Name</span>
                        <input @if($is_resumed) value="{{ $this->maskValue('last_name', $formData['last_name']) }}" @endif
                               @focus="resumed = false"
                               wire:model.defer="formData.last_name" 
                               class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm {{ $is_resumed ? 'text-gray-400' : '' }}" type="text"/>
                    </label>
                    <label class="flex flex-col gap-2">
                        <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Middle Name</span>
                        <input wire:model.defer="formData.middle_name" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" type="text"/>
                    </label>
                    <label class="flex flex-col gap-2">
                        <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Extension Name</span>
                        <input wire:model.defer="formData.extension_name" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" placeholder="e.g. Jr., III" type="text"/>
                    </label>
                    <label class="flex flex-col gap-2">
                        <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Sex</span>
                        <select wire:model.defer="formData.sex" class="form-select rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm">
                            <option value="">Select Sex</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </label>

                    <!-- Dynamic Toggles -->
                    <div class="md:col-span-2 space-y-4 pt-4 border-t border-[#e7cfcf] dark:border-white/10">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" wire:model.live="formData.is_ip" class="rounded border-[#e7cfcf] text-primary focus:ring-primary" />
                            <span class="text-sm font-medium">Indigenous Peoples (IP) Community?</span>
                        </label>
                        @if($formData['is_ip'])
                        <div class="ml-8">
                            <input wire:model.defer="formData.ip_community" class="form-input w-full rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" placeholder="Specify IP Community" type="text"/>
                        </div>
                        @endif

                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" wire:model.live="formData.is_4ps" class="rounded border-[#e7cfcf] text-primary focus:ring-primary" />
                            <span class="text-sm font-medium">4Ps Beneficiary?</span>
                        </label>
                        @if($formData['is_4ps'])
                        <div class="ml-8">
                            <input wire:model.defer="formData.household_id" class="form-input w-full rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" placeholder="Household ID Number" type="text"/>
                        </div>
                        @endif

                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" wire:model.live="formData.has_disability" class="rounded border-[#e7cfcf] text-primary focus:ring-primary" />
                            <span class="text-sm font-medium">Learner with Disability (LSEN)?</span>
                        </label>
                        @if($formData['has_disability'])
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2 ml-8 bg-black/5 dark:bg-white/5 p-4 rounded-xl">
                            @foreach(['Visual Impairment', 'Learning Disability', 'Autism Spectrum Disorder', 'Hearing Impairment', 'Intellectual Disability', 'Speech/Language Impairment', 'Multiple Disability'] as $type)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" value="{{ $type }}" wire:model.defer="formData.disability_types" class="rounded text-primary focus:ring-primary" />
                                <span class="text-xs">{{ $type }}</span>
                            </label>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </section>
            @endif

            @if($currentStep == 3)
            <!-- Step 3: Address Information -->
            <section class="glass-card rounded-xl shadow-sm border border-[#e7cfcf] dark:border-white/10 overflow-hidden">
                <div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5">
                    <h2 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-xl font-bold leading-tight tracking-tight">Address Information</h2>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <label class="flex flex-col gap-2">
                        <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">House No. & Street</span>
                        <input wire:model.defer="formData.current_house_no" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" type="text"/>
                    </label>
                    <label class="flex flex-col gap-2">
                        <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Barangay</span>
                        <input wire:model.defer="formData.current_barangay" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" type="text"/>
                    </label>
                    <label class="flex flex-col gap-2">
                        <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">City / Municipality</span>
                        <input wire:model.defer="formData.current_municipality" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" type="text"/>
                    </label>
                    <label class="flex flex-col gap-2">
                        <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Province</span>
                        <input wire:model.defer="formData.current_province" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" type="text"/>
                    </label>

                    <div class="md:col-span-2 pt-4 border-t border-[#e7cfcf] dark:border-white/10 space-y-6">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" wire:model.live="formData.is_same_address" class="rounded border-[#e7cfcf] text-primary focus:ring-primary" />
                            <span class="text-sm font-medium">Permanent address is same as current?</span>
                        </label>

                        @if(!$formData['is_same_address'])
                        <div x-transition class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-black/5 dark:bg-white/5 p-6 rounded-xl">
                            <label class="flex flex-col gap-2">
                                <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold opacity-70">Permanent House No.</span>
                                <input wire:model.defer="formData.permanent_house_no" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" type="text"/>
                            </label>
                            <label class="flex flex-col gap-2">
                                <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold opacity-70">Permanent Barangay</span>
                                <input wire:model.defer="formData.permanent_barangay" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" type="text"/>
                            </label>
                        </div>
                        @endif
                    </div>
                </div>
            </section>
            @endif

            @if($currentStep == 4)
            <!-- Step 4: Parent Info -->
            <section class="glass-card rounded-xl shadow-sm border border-[#e7cfcf] dark:border-white/10 overflow-hidden">
                <div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5">
                    <h2 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-xl font-bold leading-tight tracking-tight">Parent / Guardian Information</h2>
                </div>
                <div class="p-8 grid grid-cols-1 gap-6">
                    <label class="flex flex-col gap-2">
                        <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Father's Full Name</span>
                        <input wire:model.defer="formData.father_name" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" type="text"/>
                    </label>
                    <label class="flex flex-col gap-2">
                        <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Mother's Maiden Name</span>
                        <input wire:model.defer="formData.mother_maiden_name" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" type="text"/>
                    </label>
                    <label class="flex flex-col gap-2 max-w-sm">
                        <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Primary Contact Number</span>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-mono">+63</span>
                            <input @if($is_resumed) value="{{ $this->maskValue('contact_no', $formData['contact_no']) }}" @endif
                                   @focus="resumed = false"
                                   wire:model.defer="formData.contact_no" 
                                   class="form-input w-full rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm pl-12 {{ $is_resumed ? 'text-gray-400' : '' }}" type="text"/>
                        </div>
                    </label>
                </div>
            </section>
            @endif

            @if($currentStep == 5)
            <!-- Step 5: Academic Preferences -->
            <section class="glass-card rounded-xl shadow-sm border border-[#e7cfcf] dark:border-white/10 overflow-hidden">
                <div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5">
                    <h2 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-xl font-bold leading-tight tracking-tight">Academic History & Preferences</h2>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <label class="flex flex-col gap-2">
                        <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Last Grade Level Completed</span>
                        <select wire:model.defer="formData.last_grade_level" class="form-select rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm">
                            <option value="">Select Level</option>
                            @foreach(['Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11'] as $lvl)
                                <option value="{{ $lvl }}">{{ $lvl }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="flex flex-col gap-2">
                        <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Last School Attended</span>
                        <input wire:model.defer="formData.last_school_attended" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" type="text"/>
                    </label>

                    <!-- Tech-Voc Ranking for G8 -->
                    @if($formData['grade_level'] == 'Grade 8')
                    <div class="md:col-span-2 p-6 bg-primary/5 rounded-xl border border-primary/20 space-y-4">
                        <h3 class="text-sm font-bold">Tech-Voc Specialization Ranking</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach(['rank1' => '1st', 'rank2' => '2nd', 'rank3' => '3rd'] as $rank => $label)
                            <select wire:model.defer="formData.{{ $rank }}" class="form-select text-xs rounded-lg border-[#e7cfcf]">
                                <option value="">{{ $label }} Choice</option>
                                <option value="Consumer Electronics">Consumer Electronics</option>
                                <option value="Computer Systems">Computer Systems</option>
                                <option value="Electrical">Electrical</option>
                                <option value="Automotive">Automotive</option>
                            </select>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- SHS Tracker -->
                    @if($school_category == 'SHS')
                    <div class="md:col-span-2 p-6 bg-primary/5 rounded-xl border border-primary/20 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="flex flex-col gap-2">
                                <span class="text-xs font-bold text-primary uppercase">Track</span>
                                <select wire:model.live="formData.shs_track" class="form-select rounded-lg border-[#e7cfcf] text-sm">
                                    <option value="">Select Track</option>
                                    <option value="Academic">Academic</option>
                                    <option value="TVL">TVL</option>
                                </select>
                            </label>
                            <label class="flex flex-col gap-2">
                                <span class="text-xs font-bold text-primary uppercase">Strand</span>
                                <select wire:model.defer="formData.strand" class="form-select rounded-lg border-[#e7cfcf] text-sm">
                                    <option value="">Select Strand</option>
                                    @if($formData['shs_track'] == 'Academic')
                                        <option value="STEM">STEM</option>
                                        <option value="HUMSS">HUMSS</option>
                                        <option value="GAS">GAS</option>
                                    @elseif($formData['shs_track'] == 'TVL')
                                        <option value="ICT">ICT</option>
                                        <option value="HE">HE</option>
                                    @endif
                                </select>
                            </label>
                        </div>
                    </div>
                    @endif
                </div>
            </section>
            @endif

            @if($currentStep == 6)
            <!-- Step 6: File Upload -->
            <section class="glass-card rounded-xl shadow-sm border border-[#e7cfcf] dark:border-white/10 overflow-hidden">
                <div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5">
                    <h2 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-xl font-bold leading-tight tracking-tight">Final Documentation</h2>
                </div>
                <div class="p-8 space-y-8">
                    <div class="flex flex-col items-center gap-4 py-12 border-2 border-dashed border-[#e7cfcf] rounded-2xl bg-white/20">
                        <div class="size-32 rounded-xl bg-primary/5 flex items-center justify-center relative overflow-hidden group">
                            @if($profile_picture_upload)
                                <img src="{{ $profile_picture_upload->temporaryUrl() }}" class="size-full object-cover">
                            @elseif($formData['profile_picture'])
                                <img src="{{ asset('storage/' . $formData['profile_picture']) }}" class="size-full object-cover">
                            @else
                                <span class="material-symbols-outlined text-4xl text-primary/30">add_a_photo</span>
                            @endif
                            <input type="file" wire:model="profile_picture_upload" class="absolute inset-0 opacity-0 cursor-pointer">
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-bold">Official Profile Picture</p>
                            <p class="text-[10px] text-[#9a4c4c] mt-1">White background, decent attire (Max 5MB)</p>
                        </div>
                    </div>

                    <div class="pt-8 border-t border-[#e7cfcf] dark:border-white/10">
                        <label class="flex items-start gap-4 p-4 bg-primary/5 rounded-xl border border-primary/10 cursor-pointer">
                            <input type="checkbox" required class="mt-1 rounded text-primary focus:ring-primary" />
                            <div class="flex flex-col gap-1">
                                <span class="text-sm font-bold text-gray-900 dark:text-white">Data Accuracy & Consent</span>
                                <p class="text-[10px] text-gray-500 leading-relaxed">
                                    I certify that all information provided is true and correct. I authorize the school to process my data for enrollment purposes.
                                </p>
                            </div>
                        </label>
                    </div>
                </div>
            </section>
            @endif

            <!-- Navigation Buttons -->
            <div class="flex @if($currentStep > 1) justify-between @else justify-end @endif items-center py-6">
                @if($currentStep > 1)
                <button type="button" wire:click="previousStep" class="flex items-center gap-2 px-6 py-3 rounded-lg font-bold text-[#1b0d0d] dark:text-[#fcf8f8] border border-[#e7cfcf] dark:border-white/20 hover:bg-white/50 transition-all">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Back
                </button>
                @endif

                <div class="flex gap-4">
                    <button type="button" wire:click="saveProgress" class="px-6 py-3 rounded-lg font-bold text-[#1b0d0d] dark:text-[#fcf8f8] hover:bg-white/50 transition-all">
                        Save Draft
                    </button>

                    @if($currentStep < 6)
                    <button type="button" wire:click="nextStep" class="bg-primary text-white px-8 py-3 rounded-lg font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all flex items-center gap-2">
                        Next
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                    @else
                    <button type="submit" class="bg-green-600 text-white px-10 py-3 rounded-lg font-bold shadow-lg shadow-green-600/20 hover:bg-green-700 transition-all flex items-center gap-2">
                        Submit Enrollment
                        <span class="material-symbols-outlined">rocket_launch</span>
                    </button>
                    @endif
                </div>
            </div>
        </form>
    @endif
</div>
