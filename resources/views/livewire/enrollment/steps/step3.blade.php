<section wire:key="step-3" class="glass-card rounded-xl shadow-sm border border-[#e7cfcf] dark:border-white/10 overflow-hidden">
    <div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5">
        <h2 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-xl font-bold leading-tight tracking-tight">Address Information</h2>
    </div>
    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        <label wire:key="f-current-house" class="flex flex-col gap-2">
            <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">House No. & Street</span>
            <input wire:model.live.debounce.500ms="formData.current_house_no" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm @error('formData.current_house_no') border-red-500 ring-red-500 @enderror" type="text"/>
        </label>
        <label wire:key="f-current-barangay" class="flex flex-col gap-2">
            <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Barangay</span>
            <input wire:model.live.debounce.500ms="formData.current_barangay" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm @error('formData.current_barangay') border-red-500 ring-red-500 @enderror" type="text"/>
        </label>
        <label class="flex flex-col gap-2">
            <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">City / Municipality</span>
            <input wire:model.live.debounce.500ms="formData.current_municipality" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm @error('formData.current_municipality') border-red-500 ring-red-500 @enderror" type="text"/>
        </label>
        <label class="flex flex-col gap-2">
            <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Province</span>
            <input wire:model.live.debounce.500ms="formData.current_province" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm @error('formData.current_province') border-red-500 ring-red-500 @enderror" type="text"/>
        </label>
        <label class="flex flex-col gap-2">
            <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">ZIP Code</span>
            <input wire:model.live.debounce.500ms="formData.current_zip" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm @error('formData.current_zip') border-red-500 ring-red-500 @enderror" placeholder="e.g. 1000" type="text"/>
        </label>
        <label wire:key="f-current-country" class="flex flex-col gap-2">
            <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Country</span>
            <input wire:model.live.debounce.500ms="formData.current_country" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm @error('formData.current_country') border-red-500 ring-red-500 @enderror" type="text"/>
        </label>

        <div class="md:col-span-2 pt-4 border-t border-[#e7cfcf] dark:border-white/10 space-y-6">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" wire:model.live="formData.is_same_address" class="rounded border-[#e7cfcf] text-primary focus:ring-primary" />
                <span class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Permanent address is same as current?</span>
            </label>

            @if(!$formData['is_same_address'])
            <div x-transition class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-black/5 dark:bg-white/5 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800">
                <label class="flex flex-col gap-2">
                    <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold opacity-70">Permanent House No.</span>
                    <input wire:model.defer="formData.permanent_house_no" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm @error('formData.permanent_house_no') border-red-500 ring-red-500 @enderror" type="text"/>
                </label>
                <label class="flex flex-col gap-2">
                    <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold opacity-70">Permanent Barangay</span>
                    <input wire:model.defer="formData.permanent_barangay" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm @error('formData.permanent_barangay') border-red-500 ring-red-500 @enderror" type="text"/>
                </label>
                <label class="flex flex-col gap-2">
                    <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold opacity-70">Permanent City / Municipality</span>
                    <input wire:model.defer="formData.permanent_municipality" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm @error('formData.permanent_municipality') border-red-500 ring-red-500 @enderror" type="text"/>
                </label>
                <label class="flex flex-col gap-2">
                    <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold opacity-70">Permanent Province</span>
                    <input wire:model.defer="formData.permanent_province" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm @error('formData.permanent_province') border-red-500 ring-red-500 @enderror" type="text"/>
                </label>
                <label class="flex flex-col gap-2">
                    <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold opacity-70">Permanent ZIP Code</span>
                    <input wire:model.defer="formData.permanent_zip" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm @error('formData.permanent_zip') border-red-500 ring-red-500 @enderror" type="text"/>
                </label>
                <label class="flex flex-col gap-2">
                    <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold opacity-70">Permanent Country</span>
                    <input wire:model.defer="formData.permanent_country" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm @error('formData.permanent_country') border-red-500 ring-red-500 @enderror" type="text"/>
                </label>
            </div>
            @endif
        </div>
    </div>
</section>
