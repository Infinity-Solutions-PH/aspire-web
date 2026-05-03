<div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5 text-center">
    <h2 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-xl font-bold leading-tight tracking-tight">Enrollment Type</h2>
    <p class="text-sm text-[#9a4c4c] dark:text-[#e7cfcf] mt-1">Select your status for the upcoming school year.</p>
</div>
<div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-6">
    @php
        $incomingLabel = $school_category == 'SHS' ? 'Incoming Grade 11' : 'Incoming Grade 7';
        $options = [
            $incomingLabel => 'New Student',
            'Old Student' => 'Promoted Student',
            'Transferee' => 'From Other School'
        ];
    @endphp
    @foreach($options as $val => $sub)
    <button wire:click="selectType('{{ $val }}')" class="flex flex-col items-center gap-4 bg-white/50 dark:bg-black/20 p-8 rounded-2xl border border-[#e7cfcf] dark:border-white/10 hover:border-primary hover:bg-primary/5 transition-all group">
        <span class="material-symbols-outlined text-4xl text-primary/50 group-hover:text-primary transition-colors">person_add</span>
        <div class="text-center">
            <h3 class="text-sm font-bold">{{ $val }}</h3>
            <p class="text-[10px] text-stone-500">{{ $sub }}</p>
        </div>
    </button>
    @endforeach
</div>
