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
