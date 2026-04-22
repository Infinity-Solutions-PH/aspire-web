@extends('layouts.landing')

@section('title', 'Academic Programs | TNTS ASPIRE')

@section('content')
<main class="pt-32 pb-24">
    <div class="max-w-7xl mx-auto px-8">
        <header class="mb-20">
            <span class="text-xs font-black uppercase tracking-[0.4em] text-primary mb-4 block">Our Curriculum</span>
            <h1 class="text-5xl md:text-6xl font-headline font-black tracking-tighter mb-6">Expertise in Every Domain</h1>
            <p class="text-lg text-on-surface-variant max-w-2xl leading-relaxed">
                From foundational technical skills in Junior High to specialized professional strands in Senior High, we provide a complete pathway to career readiness.
            </p>
        </header>

        <!-- Junior High School Section -->
        <section class="mb-24">
            <div class="flex items-center gap-4 mb-10">
                <div class="h-px flex-1 bg-primary/10"></div>
                <h2 class="text-2xl font-black tracking-tight text-primary">Junior High School (G7-G10)</h2>
                <div class="h-px flex-1 bg-primary/10"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @php
                    $jhs_courses = [
                        ['title' => 'Computer Systems Servicing', 'icon' => 'laptop_mac', 'desc' => 'Hardware repair, networking, and system configuration.'],
                        ['title' => 'Consumer Electronics', 'icon' => 'settings_input_component', 'desc' => 'Maintenance and repair of electronic devices.'],
                        ['title' => 'Electrical Installation', 'icon' => 'bolt', 'desc' => 'Residential and industrial electrical wiring systems.'],
                        ['title' => 'Automotive Servicing', 'icon' => 'directions_car', 'desc' => 'Engine maintenance and vehicle system diagnostics.'],
                        ['title' => 'SMA Welding', 'icon' => 'precision_manufacturing', 'desc' => 'Metal fabrication and arc welding mastery.'],
                        ['title' => 'Food & Beverage Services', 'icon' => 'restaurant', 'desc' => 'Professional hospitality and table services.'],
                        ['title' => 'Dressmaking', 'icon' => 'apparel', 'desc' => 'Garment construction and fashion technology.'],
                    ];
                @endphp

                @foreach($jhs_courses as $course)
                <div class="bg-surface-container-low border border-outline-variant/10 p-8 rounded-2xl hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <span class="material-symbols-outlined text-3xl text-primary mb-6 block">{{ $course['icon'] }}</span>
                    <h3 class="text-lg font-bold mb-3 tracking-tight">{{ $course['title'] }}</h3>
                    <p class="text-xs text-on-surface-variant leading-relaxed">{{ $course['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </section>

        <!-- Senior High School Section -->
        <section>
            <div class="flex items-center gap-4 mb-10">
                <div class="h-px flex-1 bg-primary/10"></div>
                <h2 class="text-2xl font-black tracking-tight text-primary">Senior High School (G11-G12)</h2>
                <div class="h-px flex-1 bg-primary/10"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Academic Track -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="material-symbols-outlined text-primary">history_edu</span>
                        <h3 class="text-xl font-black uppercase tracking-widest text-primary-container">Academic Track</h3>
                    </div>
                    <div class="grid gap-4">
                        @php
                            $academic = [
                                ['code' => 'STEM', 'name' => 'Science, Tech, Engineering & Math', 'desc' => 'For future scientists, engineers, and healthcare professionals.'],
                                ['code' => 'HUMSS', 'name' => 'Humanities & Social Sciences', 'desc' => 'Focus on communication, public service, and social analysis.'],
                                ['code' => 'ABM', 'name' => 'Accountancy, Business & Management', 'desc' => 'Corporate leadership, management, and financial mastery.'],
                                ['code' => 'GAS', 'name' => 'General Academic Strand', 'desc' => 'Versatile pathway for various university degrees.'],
                            ];
                        @endphp
                        @foreach($academic as $strand)
                        <div class="p-6 bg-white border border-stone-100 rounded-2xl shadow-sm">
                            <span class="text-[10px] font-black text-primary mb-1 block">{{ $strand['code'] }}</span>
                            <h4 class="font-bold mb-2">{{ $strand['name'] }}</h4>
                            <p class="text-xs text-on-surface-variant leading-relaxed">{{ $strand['desc'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- TVL Track -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="material-symbols-outlined text-primary">engineering</span>
                        <h3 class="text-xl font-black uppercase tracking-widest text-primary-container">TVL Track</h3>
                    </div>
                    <div class="grid gap-4">
                        @php
                            $tvl = [
                                ['strand' => 'ICT', 'spec' => 'Digital Animation & Programming', 'desc' => 'Advanced software development and multimedia arts.'],
                                ['strand' => 'Industrial Arts', 'spec' => 'AS, EIM, SMAW & Machinery', 'desc' => 'Heavy industry technical mastery and certification.'],
                                ['strand' => 'Home Economics', 'spec' => 'Cookery & Hospitality', 'desc' => 'Professional culinary and tourism management.'],
                                ['strand' => 'Agri-Fishery', 'spec' => 'Sustainable Technology', 'desc' => 'Modern farming and fishery management systems.'],
                            ];
                        @endphp
                        @foreach($tvl as $strand)
                        <div class="p-6 bg-primary-container text-white rounded-2xl shadow-lg">
                            <span class="text-[10px] font-black text-on-primary-container mb-1 block uppercase tracking-widest">{{ $strand['strand'] }}</span>
                            <h4 class="font-bold mb-2">{{ $strand['spec'] }}</h4>
                            <p class="text-xs text-white/70 leading-relaxed">{{ $strand['desc'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
@endsection