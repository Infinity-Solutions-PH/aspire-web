<div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5">
    <h2 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-xl font-bold leading-tight tracking-tight">Identity Verification</h2>
    <p class="text-sm text-[#9a4c4c] dark:text-[#e7cfcf] mt-1">Please enter your credentials to initiate enrollment.</p>
</div>
<form wire:submit.prevent="validateIdentity" class="p-8 space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <label class="flex flex-col gap-2">
            <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">LRN (12 digits)</span>
            <input wire:model.live.debounce.500ms="lrn" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm @error('lrn') border-red-500 ring-red-500 @enderror" placeholder="Learner Reference Number" type="text"/>
            @error('lrn') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
        </label>
        <label class="flex flex-col gap-2">
            <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Date of Birth</span>
            <input wire:model.live.debounce.500ms="birthdate" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm @error('birthdate') border-red-500 ring-red-500 @enderror" type="date"/>
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