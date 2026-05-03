<section class="glass-card rounded-xl shadow-sm border border-[#e7cfcf] dark:border-white/10 overflow-hidden">
    <div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5">
        <h2 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-xl font-bold leading-tight tracking-tight">Final Documentation</h2>
    </div>
    <div class="p-8 space-y-8">
        <div class="flex flex-col items-center gap-6 py-10 border-2 border-dashed border-[#e7cfcf] rounded-2xl bg-white/20">
            <div class="size-40 rounded-xl bg-primary/5 flex items-center justify-center relative overflow-hidden group border-4 border-white shadow-md">
                @if($profile_picture_upload)
                    <img src="{{ $profile_picture_upload->temporaryUrl() }}" class="size-full object-cover">
                @elseif($formData['profile_picture'])
                    <img src="{{ asset('storage/' . $formData['profile_picture']) }}" class="size-full object-cover">
                @else
                    <span class="material-symbols-outlined text-5xl text-primary/30">add_a_photo</span>
                @endif
                
                <!-- Loading Indicator -->
                <div wire:loading wire:target="profile_picture_upload" class="absolute inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-20">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-white"></div>
                </div>

                <input type="file" wire:model="profile_picture_upload" class="absolute inset-0 opacity-0 cursor-pointer z-10">
            </div>
            <div class="text-center">
                <p class="text-sm font-bold text-gray-800">2x2 Picture</p>
                <p class="text-[10px] text-[#9a4c4c] mt-1 font-medium">White background, formal/school attire (Max 5MB)</p>
            </div>

            <!-- Photo Guidelines -->
            <div class="grid grid-cols-2 gap-8 mt-4 w-full max-w-md px-8">
                <div class="space-y-2">
                    <p class="text-[10px] font-bold text-green-600 uppercase flex items-center justify-center gap-1">
                        <span class="material-symbols-outlined text-sm">check_circle</span> Applicable
                    </p>
                    <div class="aspect-square rounded-lg border-2 border-green-500/30 overflow-hidden shadow-sm">
                        <img src="{{ asset('images/examples/applicable.png') }}" class="size-full object-cover">
                    </div>
                </div>
                <div class="space-y-2">
                    <p class="text-[10px] font-bold text-red-600 uppercase flex items-center justify-center gap-1">
                        <span class="material-symbols-outlined text-sm">cancel</span> Not Applicable
                    </p>
                    <div class="aspect-square rounded-lg border-2 border-red-500/30 overflow-hidden shadow-sm grayscale opacity-60">
                        <img src="{{ asset('images/examples/not_applicable.png') }}" class="size-full object-cover">
                    </div>
                </div>
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
