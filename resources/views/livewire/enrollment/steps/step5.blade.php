<section wire:key="step-5" class="glass-card rounded-xl shadow-sm border border-[#e7cfcf] dark:border-white/10 overflow-hidden">
    <div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5">
        <h2 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-xl font-bold leading-tight tracking-tight">Academic History & Preferences</h2>
    </div>
    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        <label wire:key="f-last-grade" class="flex flex-col gap-2">
            <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Last Grade Level Completed</span>
            <select wire:model.live="formData.last_grade_level" 
                    @if(in_array($enrollment_type, ['Incoming Grade 7', 'Incoming Grade 11'])) disabled @endif
                    class="form-select rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm {{ in_array($enrollment_type, ['Incoming Grade 7', 'Incoming Grade 11']) ? 'bg-zinc-100 dark:bg-zinc-800 opacity-75 cursor-not-allowed' : '' }} @error('formData.last_grade_level') border-red-500 ring-red-500 @enderror">
                <option value="">Select Level</option>
                @foreach(['Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11'] as $lvl)
                    @php
                        $isSelected = false;
                        if ($enrollment_type === 'Incoming Grade 7' && $lvl === 'Grade 6') $isSelected = true;
                        if ($enrollment_type === 'Incoming Grade 11' && $lvl === 'Grade 10') $isSelected = true;
                        if ($formData['last_grade_level'] == $lvl) $isSelected = true;
                    @endphp
                    <option value="{{ $lvl }}" @if($isSelected) selected @endif>{{ $lvl }}</option>
                @endforeach
            </select>
            @if(in_array($enrollment_type, ['Incoming Grade 7', 'Incoming Grade 11']))
                <p class="text-[9px] text-primary italic font-medium">Auto-selected for {{ $enrollment_type }} applicants</p>
            @endif
            @error('formData.last_grade_level') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
        </label>
        <label wire:key="f-last-school" class="flex flex-col gap-2">
            <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Last School Attended</span>
            <input wire:model.live.debounce.500ms="formData.last_school_attended" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm @error('formData.last_school_attended') border-red-500 ring-red-500 @enderror" type="text"/>
            @error('formData.last_school_attended') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
        </label>
        <label wire:key="f-last-gwa" class="flex flex-col gap-2">
            <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Last General Weighted Average (GWA)</span>
            <input wire:model.live.debounce.500ms="formData.last_gwa" class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm @error('formData.last_gwa') border-red-500 ring-red-500 @enderror" placeholder="e.g. 88.5" type="number" step="0.01"/>
            @error('formData.last_gwa') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
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
