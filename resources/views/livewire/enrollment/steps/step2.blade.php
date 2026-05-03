<section wire:key="step-2" class="glass-card rounded-xl shadow-sm border border-[#e7cfcf] dark:border-white/10 overflow-hidden">
    <div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5">
        <h2 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-xl font-bold leading-tight tracking-tight">Student Information</h2>
    </div>
    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        <label wire:key="f-first-name" class="flex flex-col gap-2">
            <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">First Name</span>
            <input @if($is_resumed) value="{{ $this->maskValue('first_name', $formData['first_name']) }}" @endif
                @focus="resumed = false"
                wire:model.live.debounce.500ms="formData.first_name" 
                class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm {{ $is_resumed ? 'text-gray-400' : '' }} @error('formData.first_name') border-red-500 ring-red-500 @enderror" type="text"/>
            @error('formData.first_name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
        </label>
        <label wire:key="f-last-name" class="flex flex-col gap-2">
            <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Last Name</span>
            <input @if($is_resumed) value="{{ $this->maskValue('last_name', $formData['last_name']) }}" @endif
                @focus="resumed = false"
                wire:model.live.debounce.500ms="formData.last_name" 
                class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm {{ $is_resumed ? 'text-gray-400' : '' }} @error('formData.last_name') border-red-500 ring-red-500 @enderror" type="text"/>
            @error('formData.last_name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
        </label>
        <label wire:key="f-middle-name" class="flex flex-col gap-2">
            <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Middle Name</span>
            <input wire:model.live.debounce.500ms="formData.middle_name" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm @error('formData.middle_name') border-red-500 ring-red-500 @enderror" type="text"/>
            @error('formData.middle_name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
        </label>
        <label class="flex flex-col gap-2">
            <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Extension Name</span>
            <input wire:model.live.debounce.500ms="formData.extension_name" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" placeholder="e.g. Jr., III" type="text"/>
        </label>
        <label wire:key="f-sex" class="flex flex-col gap-2">
            <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Sex</span>
            <select wire:model.live="formData.sex" class="form-select rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm @error('formData.sex') border-red-500 ring-red-500 @enderror">
                <option value="">Select Sex</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
            @error('formData.sex') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
        </label>
        <label class="flex flex-col gap-2">
            <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Mother Tongue</span>
            <input wire:model.defer="formData.mother_tongue" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" placeholder="e.g. Tagalog, Bisaya" type="text"/>
        </label>
        <label wire:key="f-psa-no" class="flex flex-col gap-2">
            <div class="flex items-center justify-between gap-2">
                <div class="flex items-center gap-2">
                    <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">PSA Birth Certificate No.</span>
                    <span class="text-[9px] text-zinc-500 bg-zinc-100 dark:bg-zinc-800 px-1.5 py-0.5 rounded italic leading-none">If available</span>
                </div>
                <button type="button" @click="$wire.set('showPSAModal', true)" class="text-[10px] font-bold text-primary flex items-center gap-1 hover:underline group">
                    <span class="material-symbols-outlined text-sm group-hover:scale-110 transition-transform">help</span>
                    How to locate?
                </button>
            </div>
            <input wire:model.defer="formData.psa_no" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" placeholder="Registry Number" type="text"/>
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

            <div class="space-y-4 pt-4 border-t border-[#e7cfcf] dark:border-white/10">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-bold text-zinc-900 dark:text-zinc-100">Learner with Disability (LSEN)</span>
                    <span class="text-[10px] text-zinc-500 italic bg-zinc-100 dark:bg-zinc-800 px-2 py-1 rounded">Select "None" by leaving all unchecked</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-3 p-5 rounded-2xl bg-black/5 dark:bg-white/5 border border-zinc-100 dark:border-white/5 shadow-inner">
                    @foreach([
                        'Visual Impairment (Blind)', 
                        'Visual Impairment (Low Vision)',
                        'Hearing Impairment', 
                        'Learning Disability', 
                        'Intellectual Disability', 
                        'Autism Spectrum Disorder', 
                        'Emotional-Behavioral Disorder',
                        'Orthopedic/Physical Handicap',
                        'Speech/Language Disorder',
                        'Cerebral Palsy',
                        'Special Health Problem (e.g. Cancer)',
                        'Multiple Disorder'
                    ] as $type)
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" value="{{ $type }}" wire:model.defer="formData.disability_types" class="rounded border-zinc-300 dark:border-zinc-700 text-primary focus:ring-primary h-4 w-4 transition-all" />
                        <span class="text-[11px] text-zinc-600 dark:text-zinc-400 group-hover:text-primary transition-colors">{{ $type }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
