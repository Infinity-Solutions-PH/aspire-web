@extends('layouts.landing')
@section('title', 'Tanza National Trade School · ASPIRE')
@push('styles')
<style>
.hero-gradient {
    background: linear-gradient(to right, rgba(87, 0, 0, 0.95), rgba(128, 0, 0, 0.7)), url('https://lh3.googleusercontent.com/aida-public/AB6AXuDyt6qZirvEpduHdFc54kItKQBe-_dWS-eBUXxd3EZWSYJs-1E1DQ9XWY7uHdKgPgzA1hY-sMvCjnKsCJi17WFavGIP6oE41MuihtZQewsXhVgP2rmz3qSavXawfCe__CfYPQ0slud_nsmdEwVmPolrLehFNtq3Sm1anFYf0ATa9FxTt_7D-T_Xz9gS5eu6cJbcfT3HyO9CMEgPkvrq2Nmkiny2-JXVWacJiSuc-9QuDtsoYxCdYqCV9Z7-wIZPwFim-vT8osv7hTQ');
    background-size: cover;
    background-position: center;
}
.no-scrollbar::-webkit-scrollbar {
    display: none;
}
</style>
@endpush
@section('content')
<!-- Hero Section -->
    <header class="relative min-h-[85vh] flex items-center pt-20 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDyt6qZirvEpduHdFc54kItKQBe-_dWS-eBUXxd3EZWSYJs-1E1DQ9XWY7uHdKgPgzA1hY-sMvCjnKsCJi17WFavGIP6oE41MuihtZQewsXhVgP2rmz3qSavXawfCe__CfYPQ0slud_nsmdEwVmPolrLehFNtq3Sm1anFYf0ATa9FxTt_7D-T_Xz9gS5eu6cJbcfT3HyO9CMEgPkvrq2Nmkiny2-JXVWacJiSuc-9QuDtsoYxCdYqCV9Z7-wIZPwFim-vT8osv7hTQ" alt="TNTS Campus"/>
            <div class="absolute inset-0 bg-gradient-to-r from-primary/95 via-primary/70 to-transparent"></div>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-8 w-full grid grid-cols-1 md:grid-cols-2">
            <div class="max-w-xl">
                <span class="inline-block px-3 py-1 bg-primary-container text-on-primary-container text-[10px] font-black tracking-widest uppercase mb-6 rounded-sm">Established 1963</span>
                <h1 class="text-5xl md:text-7xl font-headline font-black text-white leading-[1.1] mb-6 tracking-tight">
                    Crafting Your <span class="text-on-primary-container">Technical</span> Legacy
                </h1>
                <p class="text-xl text-white font-medium mix-blend-screen leading-relaxed mb-10 opacity-90 max-w-lg">
                    The premier institution for technical mastery and academic excellence in Cavite. Where craftsmanship meets innovation.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-primary font-bold rounded-lg hover:bg-surface-container-low transition-all duration-300 shadow-xl shadow-primary/20">
                        Start Enrollment 2026
                    </a>
                    <a href="{{ route('programs') }}" class="px-8 py-4 border border-white/30 text-white font-bold rounded-lg hover:bg-white/10 transition-all duration-300 backdrop-blur-sm">
                        Explore Programs
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Academic Programs Preview -->
    <section class="py-24 bg-surface px-8">
        <div class="max-w-7xl mx-auto">
            <div class="mb-16 grid grid-cols-1 md:grid-cols-3 items-end gap-8">
                <div class="md:col-span-2">
                    <h2 class="text-xs font-headline text-secondary uppercase tracking-[0.4em] mb-4">Academic Architecture</h2>
                    <h3 class="text-4xl md:text-5xl font-headline font-black text-on-surface tracking-tighter">Pathways to Mastery</h3>
                </div>
                <p class="text-on-surface-variant font-body leading-relaxed border-l-2 border-primary/20 pl-6">
                    Comprehensive technical-vocational training designed to bridge the gap between classroom theory and industry demands.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                <!-- JHS Block -->
                <div class="md:col-span-4 bg-surface-container-low p-10 rounded-2xl flex flex-col justify-between group overflow-hidden relative border border-outline-variant/10">
                    <div class="relative z-10">
                        <span class="text-primary font-bold text-sm mb-2 block tracking-widest uppercase">Junior High School</span>
                        <h4 class="text-3xl font-headline font-black mb-4 tracking-tight">Foundational Excellence</h4>
                        <p class="text-on-surface-variant mb-8 text-sm leading-relaxed">Grades 7 to 10 focusing on core academic values and early technical discovery.</p>
                        <ul class="space-y-3 mb-10">
                            <li class="flex items-center gap-3 text-sm font-semibold">
                                <span class="material-symbols-outlined text-primary text-xl">verified</span>
                                Values-Based Education
                            </li>
                            <li class="flex items-center gap-3 text-sm font-semibold">
                                <span class="material-symbols-outlined text-primary text-xl">science</span>
                                STEM Foundations
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- SHS TVL Block -->
                <div class="md:col-span-8 bg-surface-container-highest p-10 rounded-2xl relative overflow-hidden group min-h-[400px]">
                    <div class="relative z-10 max-w-md">
                        <span class="text-primary font-bold text-sm mb-2 block tracking-widest uppercase">Senior High School</span>
                        <h4 class="text-4xl font-headline font-black mb-6 tracking-tight">Technical-Vocational Track</h4>
                        <div class="grid grid-cols-2 gap-x-8 gap-y-4">
                            <div>
                                <h5 class="font-bold text-primary mb-2 text-[10px] uppercase tracking-widest">Industrial Arts</h5>
                                <p class="text-xs text-on-surface-variant">Automotive, Electrical, and Welding mastery.</p>
                            </div>
                            <div>
                                <h5 class="font-bold text-primary mb-2 text-[10px] uppercase tracking-widest">ICT</h5>
                                <p class="text-xs text-on-surface-variant">Programming, Animation, and Networking.</p>
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-0 right-0 p-8">
                        <a href="{{ route('programs') }}" class="text-primary font-black text-sm uppercase tracking-widest flex items-center gap-2 group-hover:gap-3 transition-all">
                            View All Strands <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why TNTS -->
    <section class="py-24 bg-stone-900 text-white px-8">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="p-8 border border-white/10 rounded-2xl bg-white/5 backdrop-blur-sm">
                <span class="material-symbols-outlined text-4xl text-on-primary-container mb-6 block">precision_manufacturing</span>
                <h5 class="text-xl font-headline font-bold mb-4">Modern Workshops</h5>
                <p class="text-sm text-stone-400 leading-relaxed">State-of-the-art facilities mimicking real-world industrial environments.</p>
            </div>
            <div class="p-8 border border-white/10 rounded-2xl bg-white/5 backdrop-blur-sm">
                <span class="material-symbols-outlined text-4xl text-on-primary-container mb-6 block">devices</span>
                <h5 class="text-xl font-headline font-bold mb-4">Digital-First</h5>
                <p class="text-sm text-stone-400 leading-relaxed">Integrating advanced computing across all trade disciplines.</p>
            </div>
            <div class="p-8 border border-white/10 rounded-2xl bg-white/5 backdrop-blur-sm">
                <span class="material-symbols-outlined text-4xl text-on-primary-container mb-6 block">school</span>
                <h5 class="text-xl font-headline font-bold mb-4">Expert Faculty</h5>
                <p class="text-sm text-stone-400 leading-relaxed">Certified practitioners with years of industry experience.</p>
            </div>
            <div class="p-8 border border-white/10 rounded-2xl bg-white/5 backdrop-blur-sm">
                <span class="material-symbols-outlined text-4xl text-on-primary-container mb-6 block">diversity_3</span>
                <h5 class="text-xl font-headline font-bold mb-4">Character First</h5>
                <p class="text-sm text-stone-400 leading-relaxed">Developing value-oriented leaders and professional tradesmen.</p>
            </div>
        </div>
    </section>

    <!-- Enrollment Timeline -->
    <section class="py-24 bg-surface px-8">
        <div class="max-w-5xl mx-auto text-center mb-16">
            <h2 class="text-xs font-headline text-secondary uppercase tracking-[0.4em] mb-4">Digital Enrollment</h2>
            <h3 class="text-4xl font-headline font-black text-on-surface tracking-tighter">Your Journey Starts Here</h3>
        </div>
        <div class="max-w-6xl mx-auto relative px-12">
            <div class="absolute top-1/2 left-0 w-full h-px bg-stone-200 hidden md:block -translate-y-1/2 z-0"></div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative z-10">
                <div class="flex flex-col items-center bg-surface px-6">
                    <div class="w-16 h-16 bg-primary text-white flex items-center justify-center rounded-2xl text-2xl font-black mb-8 shadow-xl shadow-primary/20">1</div>
                    <h4 class="text-xl font-headline font-bold mb-3">Create Profile</h4>
                    <p class="text-on-surface-variant text-sm text-center">Register through our secure online portal.</p>
                </div>
                <div class="flex flex-col items-center bg-surface px-6">
                    <div class="w-16 h-16 bg-primary text-white flex items-center justify-center rounded-2xl text-2xl font-black mb-8 shadow-xl shadow-primary/20">2</div>
                    <h4 class="text-xl font-headline font-bold mb-3">Scan Documents</h4>
                    <p class="text-on-surface-variant text-sm text-center">Digital upload of academic records.</p>
                </div>
                <div class="flex flex-col items-center bg-surface px-6">
                    <div class="w-16 h-16 bg-primary text-white flex items-center justify-center rounded-2xl text-2xl font-black mb-8 shadow-xl shadow-primary/20">3</div>
                    <h4 class="text-xl font-headline font-bold mb-3">Official Section</h4>
                    <p class="text-on-surface-variant text-sm text-center">Final verification and assignment.</p>
                </div>
            </div>
            @guest
            <div class="mt-20 text-center">
                <a href="{{ route('enroll.public') }}" class="px-12 py-5 bg-primary text-white font-black rounded-xl hover:scale-105 transition-all shadow-2xl shadow-primary/30 uppercase tracking-widest text-sm">
                    Begin Application
                </a>
            </div>
            @endguest
        </div>
    </section>

    @endsection


