<div class="glass-card rounded-xl p-6 shadow-sm border border-[#e7cfcf] dark:border-white/10">
    <div class="flex flex-col gap-3">
        <div class="flex flex-wrap items-center gap-3">
            <div class="px-3 py-1.5 rounded-xl bg-primary text-white shadow-lg shadow-primary/20 flex items-center gap-2">
                <span class="material-symbols-outlined text-[16px]">school</span>
                <span class="text-[10px] font-black uppercase tracking-wider leading-none">
                    {{ $school_category == 'HS' ? 'Junior High School' : 'Senior High School' }}
                </span>
            </div>
            <div class="px-3 py-1.5 rounded-xl bg-zinc-100 dark:bg-white/5 border border-[#e7cfcf] dark:border-white/10 text-zinc-600 dark:text-zinc-400 flex items-center gap-2">
                <span class="material-symbols-outlined text-[16px]">person_add</span>
                <span class="text-[10px] font-bold uppercase tracking-wide leading-none">
                    {{ $enrollment_type }}
                </span>
            </div>
        </div>
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
