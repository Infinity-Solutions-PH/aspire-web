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
