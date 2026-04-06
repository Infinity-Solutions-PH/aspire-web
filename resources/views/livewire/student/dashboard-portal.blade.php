<div class="flex flex-col gap-10">
    <!-- Student Header & ID Card -->
    <div class="grid grid-cols-12 gap-8">
        <div class="col-span-8 flex flex-col justify-center gap-4">
            <nav class="flex items-center gap-2 text-[10px] font-black text-secondary/60 uppercase tracking-widest">
                <a class="hover:text-primary transition-colors uppercase" href="#">Student Hub</a>
                <span class="material-symbols-outlined text-[12px]">chevron_right</span>
                <span class="text-primary uppercase">Academic Identity</span>
            </nav>
            <h2 class="font-headline text-5xl font-black text-on-surface tracking-tighter leading-none">Welcome, {{ auth()->user()->name }}.</h2>
            <p class="text-secondary leading-relaxed text-sm font-medium max-w-xl opacity-90">
                Your official enrollment at <span class="text-primary font-bold">Tanza National Trade School</span> is finalized. Access your digital identity, academic schedule, and institutional resources below.
            </p>
            <div class="flex gap-4 mt-4">
                <div class="px-6 py-3 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3">
                    <div class="size-8 bg-emerald-500 text-white rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-sm">verified_user</span>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-emerald-800 uppercase tracking-widest leading-none">Provisioned Email</p>
                        <p class="text-xs font-black text-emerald-600">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Digital ID Mockup -->
        <div class="col-span-4 perspective-[1000px] h-full flex items-center justify-center">
             <div class="w-full bg-gradient-to-br from-[#570000] to-[#b22b1d] rounded-[2rem] p-8 shadow-2xl relative overflow-hidden border-4 border-white/10 group hover:scale-[1.02] transition-all duration-500 transform-gpu">
                <div class="absolute inset-0 opacity-10 mix-blend-overlay">
                    <span class="material-symbols-outlined text-[300px] absolute -right-20 -bottom-20 rotate-12">school</span>
                </div>
                <div class="relative z-10 flex flex-col h-full justify-between gap-12">
                    <div class="flex justify-between items-start">
                        <img class="w-16 h-16 rounded-2xl bg-white border-4 border-white shadow-xl object-cover" src="{{ auth()->user()->avatar ?? 'https://api.dicebear.com/7.x/initials/svg?seed='.auth()->user()->name }}" alt="Student Avatar">
                        <div class="text-right">
                             <h4 class="text-white font-black text-lg leading-none uppercase tracking-tight">TNTS Student ID</h4>
                             <p class="text-white/40 text-[9px] font-black uppercase mt-1 tracking-[0.2em]">Academic Year 24-25</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-white font-black text-xl leading-none uppercase tracking-tight">{{ auth()->user()->name }}</p>
                        <p class="text-white/60 text-[9px] font-black uppercase mt-1 tracking-widest tracking-tighter">{{ $enrollment->track }} - Grade {{ $enrollment->grade_level }}</p>
                        <div class="mt-4 flex justify-between items-end border-t border-white/10 pt-4">
                            <div>
                                <p class="text-white/40 text-[8px] font-black uppercase">Official Student ID</p>
                                <p class="text-white font-black text-xs tracking-widest">{{ auth()->user()->student_id ?: '#REG-PENDING' }}</p>
                            </div>
                            <!-- Mock QR Code -->
                            <div class="bg-white p-1 rounded-md shadow-lg">
                                <div class="size-10 bg-neutral-900 rounded-[2px]"></div>
                            </div>
                        </div>
                    </div>
                </div>
             </div>
        </div>
    </div>

    <!-- Tabbed Navigation -->
    <div class="flex flex-col gap-8">
        <div class="flex gap-4 border-b border-neutral-100 pb-2">
            @php $tabs = ['schedule' => 'Academic Schedule', 'safety' => 'Shop Safety', 'assessment' => 'Assessment / SOA']; @endphp
            @foreach($tabs as $key => $label)
                <button wire:click="$set('activeTab', '{{ $key }}')" class="relative px-6 py-4 flex items-center gap-2 transition-all transition-colors {{ $activeTab === $key ? 'text-primary' : 'text-neutral-400' }}">
                    <span class="text-xs font-black uppercase tracking-widest italic leading-none">{{ $label }}</span>
                    @if($activeTab === $key)
                        <div class="absolute bottom-0 inset-x-0 h-1 bg-primary rounded-full animate-in fade-in slide-in-from-bottom-2"></div>
                    @endif
                </button>
            @endforeach
        </div>

        <div class="animate-in fade-in blur-in ease-out duration-500">
            @if($activeTab === 'schedule')
                <div class="grid grid-cols-12 gap-8">
                    <!-- Schedule Timeline -->
                    <div class="col-span-8 bg-white border border-neutral-100 rounded-[2rem] p-10 shadow-xl shadow-neutral-100/50">
                        <div class="flex justify-between items-center mb-10">
                            <div>
                                <h3 class="text-2xl font-black tracking-tight text-on-surface uppercase">Master Weekly Load</h3>
                                <p class="text-xs text-neutral-400 font-bold uppercase tracking-widest mt-1">Official section: <span class="text-primary font-black">{{ $enrollment->section->name }}</span></p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            @forelse($schedules->sortBy('start_time') as $schedule)
                                <div class="flex gap-6 group">
                                    <div class="w-24 text-right py-4">
                                        <p class="text-sm font-black text-on-surface leading-none">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</p>
                                        <p class="text-[9px] text-neutral-400 font-bold uppercase mt-1 tracking-tighter">{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</p>
                                    </div>
                                    <div class="flex-1 bg-neutral-50 rounded-2xl p-5 border-l-8 border-primary group-hover:bg-primary/5 transition-all flex justify-between items-center">
                                        <div class="flex items-center gap-6">
                                            <div class="size-12 bg-white rounded-xl flex items-center justify-center text-primary shadow-sm border border-neutral-100">
                                                <span class="material-symbols-outlined text-xl">{{ $schedule->room->type === 'shop' ? 'construction' : 'school' }}</span>
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-black text-on-surface leading-none mb-1">{{ $schedule->subject->name }}</h4>
                                                <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-widest italic">{{ $schedule->teacher->name }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-[10px] font-black text-primary uppercase leading-none tracking-widest italic">{{ $schedule->room->name }}</p>
                                            <p class="text-[9px] text-neutral-400 font-bold uppercase mt-1 tracking-tighter">{{ $schedule->day }} Cycle</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="py-12 text-center bg-neutral-50 rounded-3xl border-2 border-dashed border-neutral-100">
                                    <span class="material-symbols-outlined text-4xl text-neutral-200 mb-2">event_busy</span>
                                    <p class="text-xs font-bold text-neutral-400 uppercase tracking-widest">No assigned schedules for this section yet</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Room/Shop Details -->
                    <div class="col-span-4 flex flex-col gap-8">
                        @if($enrollment->section && $enrollment->section->specialization)
                        <div class="bg-[#570000] rounded-[2rem] p-10 text-white shadow-2xl relative overflow-hidden h-fit">
                            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-white/40 via-transparent to-transparent"></div>
                            <div class="relative z-10">
                                <span class="material-symbols-outlined text-4xl mb-6">psychology_alt</span>
                                <h3 class="text-xl font-black tracking-tight leading-tight uppercase">Specialization focus</h3>
                                <p class="text-white/60 text-xs font-bold uppercase tracking-widest mt-1">{{ $enrollment->section->specialization }}</p>
                                <div class="mt-8 pt-8 border-t border-white/10 flex flex-col gap-4">
                                     <div class="flex justify-between items-center">
                                         <span class="text-[10px] font-bold text-white/50 uppercase tracking-widest">Lab Access</span>
                                         <span class="text-[10px] font-black uppercase text-emerald-400 bg-emerald-400/10 px-2 py-1 rounded">Active</span>
                                     </div>
                                     <div class="flex justify-between items-center">
                                         <span class="text-[10px] font-bold text-white/50 uppercase tracking-widest">Required PPE</span>
                                         <span class="text-[10px] font-black uppercase text-white/90">Full Industrial</span>
                                     </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <div class="bg-white border border-neutral-100 rounded-[2rem] p-8 shadow-xl shadow-neutral-100/50 flex flex-col gap-6">
                            <h4 class="text-sm font-black text-on-surface uppercase tracking-widest">Quick Resources</h4>
                            <div class="grid grid-cols-1 gap-2">
                                <a href="#" class="p-4 bg-neutral-50 rounded-2xl flex items-center gap-4 hover:bg-primary/5 transition-all group">
                                    <span class="material-symbols-outlined text-primary group-hover:scale-110 transition-transform">auto_stories</span>
                                    <span class="text-[10px] font-black text-secondary uppercase tracking-widest">Curriculum Roadmap</span>
                                </a>
                                <a href="#" class="p-4 bg-neutral-50 rounded-2xl flex items-center gap-4 hover:bg-primary/5 transition-all group">
                                    <span class="material-symbols-outlined text-primary group-hover:scale-110 transition-transform">contact_support</span>
                                    <span class="text-[10px] font-black text-secondary uppercase tracking-widest">Help & Support Hub</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($activeTab === 'safety')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Safety Compliance -->
                    <div class="bg-[#261816] text-[#ffedea] rounded-[2rem] p-10 relative overflow-hidden shadow-2xl">
                        <div class="absolute inset-x-0 top-0 h-1 bg-primary"></div>
                        <h3 class="text-3xl font-black tracking-tighter leading-none uppercase mb-2 italic">Industrial Safety Protocol</h3>
                        <p class="text-[10px] text-primary font-black uppercase tracking-widest mb-10">Department of Occupational Safety Standards</p>
                        
                        @livewire('student.safety-waiver')
                    </div>

                    <!-- PPE Checklist -->
                    <div class="bg-white border border-neutral-100 rounded-[2rem] p-10 shadow-xl">
                        <h3 class="text-xl font-black tracking-tight text-on-surface uppercase mb-8">Personal Protective Equipment</h3>
                        <div class="space-y-4">
                            @php 
                                $ppe = [
                                    ['icon' => 'safety_helmet', 'label' => 'Hard Hat', 'desc' => 'High-visibility industrial protection'],
                                    ['icon' => 'safety_goggles', 'label' => 'Safety Eyewear', 'desc' => 'Z87.1 anti-fog laboratory goggles'],
                                    ['icon' => 'tools_power_drill', 'label' => 'Standard Toolbag', 'desc' => 'Personal tool inventory required'],
                                ]
                            @endphp
                            @foreach($ppe as $item)
                                <div class="flex items-center gap-6 p-4 rounded-2xl border border-neutral-100 transition-all hover:border-primary/20">
                                    <div class="size-14 bg-neutral-50 rounded-xl flex items-center justify-center text-primary border border-neutral-100">
                                        <span class="material-symbols-outlined text-2xl">{{ $item['icon'] }}</span>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-black text-on-surface mb-0.5">{{ $item['label'] }}</h4>
                                        <p class="text-[10px] text-neutral-400 font-medium italic mb-1">{{ $item['desc'] }}</p>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-[10px] font-black text-secondary/40 bg-neutral-50 px-3 py-1 rounded-full uppercase italic">Mandatory</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @elseif($activeTab === 'assessment')
                <div class="grid grid-cols-12 gap-8">
                    <!-- SOA Ledger -->
                    <div class="col-span-8 bg-white border border-neutral-100 rounded-[2rem] p-10 shadow-xl shadow-neutral-100/50">
                        <div class="flex justify-between items-center mb-12">
                            <div>
                                <h3 class="text-2xl font-black tracking-tight text-on-surface uppercase">Statement of Account</h3>
                                <p class="text-xs text-neutral-400 font-bold uppercase tracking-widest mt-1 italic italic">Semester: <span class="text-primary font-black uppercase">First Load Cycle</span></p>
                            </div>
                            <a href="{{ route('enrollment.certificate') }}?soa=1" class="px-6 py-3 bg-neutral-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl hover:scale-105 transition-all flex items-center gap-2 italic italic">
                                <span class="material-symbols-outlined text-sm">print</span>
                                Print Official Ledger
                            </a>
                        </div>
                        <div class="space-y-4">
                            @foreach($fees as $fee)
                                <div class="flex justify-between items-center py-4 border-b border-neutral-50">
                                    <div>
                                        <p class="text-sm font-black text-on-surface uppercase italic italic italic">{{ $fee->name }}</p>
                                        <p class="text-[10px] text-neutral-400 italic">Institutional component fee</p>
                                    </div>
                                    <p class="text-sm font-black text-on-surface">₱ {{ number_format($fee->amount, 2) }}</p>
                                </div>
                            @endforeach
                            <div class="flex justify-between items-center pt-8">
                                <p class="text-xl font-black text-on-surface uppercase italic">Total Balance Due</p>
                                <p class="text-3xl font-black text-primary italic italic">₱ {{ number_format($totalFees, 2) }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Information -->
                    <div class="col-span-4 bg-[#fff0ee] rounded-[2rem] p-8 border border-primary/10 shadow-xl h-fit">
                         <div class="flex items-center gap-3 mb-8">
                            <div class="size-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center">
                                <span class="material-symbols-outlined text-xl">payments</span>
                            </div>
                            <h4 class="text-sm font-black text-primary uppercase tracking-widest italic italic">Payment Channels</h4>
                         </div>
                         <div class="space-y-6">
                            <div class="bg-white/60 p-4 rounded-2xl flex items-center gap-4 border border-white/50">
                                <div class="size-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                                    <span class="material-symbols-outlined text-sm">qr_code</span>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-secondary uppercase italic">GCash Linkage</p>
                                    <p class="text-[9px] text-secondary/60">Pay via Merchant Code</p>
                                </div>
                            </div>
                            <div class="bg-white/60 p-4 rounded-2xl flex items-center gap-4 border border-white/50 opacity-50 gray-scale grayscale">
                                <div class="size-8 bg-zinc-200 text-zinc-500 rounded-lg flex items-center justify-center text-secondary">
                                    <span class="material-symbols-outlined text-sm">payments</span>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-zinc-500 uppercase italic italic">Cash (Registrar)</p>
                                    <p class="text-[9px] text-zinc-400">Walk-in physical clearance</p>
                                </div>
                            </div>
                            <div class="pt-6 relative text-center">
                                <span class="text-[9px] font-bold text-neutral-400 uppercase italic italic">Present your Enrollment Certificate when paying in person</span>
                            </div>
                         </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
