<section wire:key="step-1" class="glass-card rounded-xl shadow-sm border border-[#e7cfcf] dark:border-white/10 overflow-hidden">
    <div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5">
        <h2 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-xl font-bold leading-tight tracking-tight">Enrollment Intent</h2>
        <p class="text-sm text-[#9a4c4c] dark:text-[#e7cfcf] mt-1">Specify your target grade level.</p>
    </div>
    <div class="p-8 space-y-6">
        <div class="flex flex-col gap-2">
            <span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Grade Level to Enroll</span>
            <select wire:model.live="formData.grade_level" class="form-select rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm @error('formData.grade_level') border-red-500 ring-red-500 @enderror">
                <option value="">Select Grade Level</option>
                @if($school_category == 'HS')
                    <optgroup label="Junior High School">
                        <option value="Grade 7" @selected(($formData['grade_level'] ?? '') == 'Grade 7')>Grade 7</option>
                        <option value="Grade 8" @selected(($formData['grade_level'] ?? '') == 'Grade 8')>Grade 8</option>
                        <option value="Grade 9" @selected(($formData['grade_level'] ?? '') == 'Grade 9')>Grade 9</option>
                        <option value="Grade 10" @selected(($formData['grade_level'] ?? '') == 'Grade 10')>Grade 10</option>
                    </optgroup>
                @else
                    <optgroup label="Senior High School">
                        <option value="Grade 11" @selected(($formData['grade_level'] ?? '') == 'Grade 11')>Grade 11</option>
                        <option value="Grade 12" @selected(($formData['grade_level'] ?? '') == 'Grade 12')>Grade 12</option>
                    </optgroup>
                @endif
            </select>
            @error('formData.grade_level') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>
    </div>
</section>
