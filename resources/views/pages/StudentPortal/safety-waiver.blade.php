<div class="relative">
    @if($showModal)
    <div class="fixed inset-0 bg-neutral-900/60 backdrop-blur-md z-[100] flex items-center justify-center p-6 transition-all duration-300">
        <div class="bg-white rounded-3xl max-w-2xl w-full shadow-2xl relative overflow-hidden border border-neutral-100 flex flex-col max-h-[90vh]">
            <!-- Header -->
            <div class="px-10 py-8 bg-[#570000] text-white flex justify-between items-center relative overflow-hidden">
                <div class="z-10">
                    <h2 class="text-3xl font-black tracking-tighter uppercase leading-none">Shop Safety Waiver</h2>
                    <p class="text-[10px] text-white/60 font-black uppercase tracking-widest mt-2">Institutional Safety & Hazard Compliance</p>
                </div>
                <div class="absolute -right-10 -bottom-10 opacity-10 rotate-12">
                    <span class="material-symbols-outlined text-[120px]">shield</span>
                </div>
            </div>

            <!-- Content -->
            <div class="p-10 flex-1 overflow-y-auto space-y-6 text-sm leading-relaxed text-neutral-600 font-medium">
                <p>By signing this waiver, I acknowledge that I have received, read, and understood the **TNTS Shop Safety Protocols**. I agree to abide by all laboratory and workshop safety rules, including but not limited to:</p>
                
                <ul class="space-y-4 list-none pl-2">
                    <li class="flex gap-4">
                        <span class="material-symbols-outlined text-primary text-xl">check_circle</span>
                        <span>Wearing the required **Personal Protective Equipment (PPE)** at all times within workshop zones.</span>
                    </li>
                    <li class="flex gap-4">
                        <span class="material-symbols-outlined text-primary text-xl">check_circle</span>
                        <span>Operating heavy machinery only under the direct supervision of an authorized instructor.</span>
                    </li>
                    <li class="flex gap-4">
                        <span class="material-symbols-outlined text-primary text-xl">check_circle</span>
                        <span>Maintaining a clean and hazard-free workstation to prevent accidents and equipment damage.</span>
                    </li>
                </ul>

                <div class="bg-amber-50 border border-amber-100 p-4 rounded-xl flex gap-4 items-center">
                    <span class="material-symbols-outlined text-amber-600 text-3xl">warning</span>
                    <div>
                        <p class="text-[10px] font-black text-amber-800 uppercase leading-tight tracking-tight">Legal Disclaimer</p>
                        <p class="text-[11px] text-amber-700/80 mt-1">Completion of this digital waiver is mandatory for Shop Access (ICT, SMAW, HE, AUTO). Access to workshop facilities will remain locked until signed.</p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="p-10 border-t border-neutral-100 flex gap-4 bg-neutral-50/50">
                <button wire:click="$set('showModal', false)" class="flex-1 py-4 border border-neutral-200 text-neutral-400 rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-white transition-all">Later</button>
                <button wire:click="sign" class="flex-[2] py-4 bg-[#570000] text-white rounded-2xl font-black uppercase tracking-widest text-[10px] shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">Sign Digital Waiver</button>
            </div>
        </div>
    </div>
    @endif

    @if(session()->has('message'))
        <div class="bg-emerald-50 border border-emerald-100 text-emerald-800 px-6 py-4 rounded-2xl flex items-center gap-4 animate-in fade-in slide-in-from-top-4">
            <span class="material-symbols-outlined text-emerald-500">verified</span>
            <span class="text-xs font-bold uppercase tracking-wide">{{ session('message') }}</span>
        </div>
    @endif
</div>
