<section wire:key="step-4" class="glass-card rounded-xl shadow-sm border border-[#e7cfcf] dark:border-white/10 overflow-hidden">
    <div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5">
        <h2 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-xl font-bold leading-tight tracking-tight">Parent / Guardian Information</h2>
    </div>
    <div class="p-8 grid grid-cols-1 gap-6">
        <label wire:key="f-father-name" class="flex flex-col gap-2">
            <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Father's Full Name</span>
            <input wire:model.live.debounce.500ms="formData.father_name" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm @error('formData.father_name') border-red-500 ring-red-500 @enderror" type="text"/>
            @error('formData.father_name') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
        </label>
        <label wire:key="f-mother-name" class="flex flex-col gap-2">
            <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Mother's Maiden Name</span>
            <input wire:model.live.debounce.500ms="formData.mother_maiden_name" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm @error('formData.mother_maiden_name') border-red-500 ring-red-500 @enderror" type="text"/>
            @error('formData.mother_maiden_name') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
        </label>
        <label wire:key="f-guardian-name" class="flex flex-col gap-2">
            <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Legal Guardian Name</span>
            <input wire:model.live.debounce.500ms="formData.guardian_name" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm @error('formData.guardian_name') border-red-500 ring-red-500 @enderror" placeholder="Full Name" type="text"/>
            @error('formData.guardian_name') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
        </label>
        <label class="flex flex-col gap-2 max-w-sm">
            <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Primary Contact Number</span>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-mono">+63</span>
                <input @if($is_resumed) value="{{ $this->maskValue('contact_no', $formData['contact_no']) }}" @endif
                       @focus="resumed = false"
                       wire:model.live.debounce.500ms="formData.contact_no" 
                       class="form-input w-full rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm pl-12 {{ $is_resumed ? 'text-gray-400' : '' }} @error('formData.contact_no') border-red-500 ring-red-500 @enderror" type="text" placeholder="9XXXXXXXXX"/>
            </div>
            <p class="text-[10px] text-zinc-500 mt-1 italic">Note: This number will be used for official school communications and as an <strong>emergency contact</strong>.</p>
            @error('formData.contact_no') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
        </label>
    </div>
</section>
