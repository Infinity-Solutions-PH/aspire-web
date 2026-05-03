<div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5 text-center">
    <h2 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-xl font-bold leading-tight tracking-tight">Select School Category</h2>
    <p class="text-sm text-[#9a4c4c] dark:text-[#e7cfcf] mt-1">Which education level are you applying for?</p>
</div>
<div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
    <button wire:click="selectCategory('HS')" class="flex flex-col items-center gap-4 bg-white/50 dark:bg-black/20 p-10 rounded-2xl border border-[#e7cfcf] dark:border-white/10 hover:border-primary hover:bg-primary/5 transition-all group">
        <span class="material-symbols-outlined text-5xl text-primary/50 group-hover:text-primary transition-colors">school</span>
        <div class="text-center">
            <h3 class="text-lg font-bold">High School</h3>
            <p class="text-xs text-stone-500">Junior High Graduate or Promoted</p>
        </div>
    </button>
    <button wire:click="selectCategory('SHS')" class="flex flex-col items-center gap-4 bg-white/50 dark:bg-black/20 p-10 rounded-2xl border border-[#e7cfcf] dark:border-white/10 hover:border-primary hover:bg-primary/5 transition-all group">
        <span class="material-symbols-outlined text-5xl text-primary/50 group-hover:text-primary transition-colors">account_tree</span>
        <div class="text-center">
            <h3 class="text-lg font-bold">Senior High School</h3>
            <p class="text-xs text-stone-500">Academic & TVL Strands</p>
        </div>
    </button>
</div>
