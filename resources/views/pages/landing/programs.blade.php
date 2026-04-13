<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Academic Programs | TNTS ASPIRE</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&family=Inter:ital,wght@0,100..900;1,100..900&family=Lexend:wght@100..900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary": "#800000",
                        "primary-container": "#570000",
                        "on-primary": "#ffffff",
                        "on-primary-container": "#ffb4a8",
                        "surface": "#fff8f6",
                        "on-surface": "#261816",
                        "secondary": "#4c616c",
                        "surface-container-low": "#fff0ee",
                        "surface-container-highest": "#f7ddd8",
                        "outline-variant": "#e2bfb9",
                        "on-surface-variant": "#5a413d",
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.375rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "fontFamily": {
                        "headline": ["Public Sans", "sans-serif"],
                        "body": ["Inter", "sans-serif"],
                        "lexend": ["Lexend", "sans-serif"]
                    }
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-surface text-on-surface font-body selection:bg-primary-container selection:text-on-primary-container">
    <!-- Top Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md shadow-sm border-b border-stone-100/50">
        <div class="flex justify-between items-center max-w-7xl mx-auto px-6 h-20">
            <a href="{{ route('home') }}" class="flex items-center gap-4">
                <!-- <div class="size-10 bg-primary flex items-center justify-center rounded-lg p-1.5 ">
                    <x-app-logo-icon class="size-full fill-current text-white" />
                </div>
                <div class="flex flex-col justify-center leading-none">
                    <span class="text-[8px] font-bold text-primary tracking-[0.2em] uppercase">Tanza National Trade School</span>
                    <span class="text-xl font-black text-primary-container tracking-tighter">ASPIRE</span>
                </div> -->
                <div class="flex items-center gap-4">
                    <div class="size-12 flex items-center justify-center rounded-xl">
                        <x-app-logo-image class="size-full fill-current text-white" />
                    </div>
                    <div class="flex flex-col justify-center leading-none mt-2">
                        <span class="text-2xl font-black text-primary-container tracking-tighter uppercase leading-[1rem]">Tanza National Trade School</span>
                        <span class="text-[10px] font-normal text-primary tracking-[0.3px] uppercase">
                            <span class="text-xs font-bold">A</span>cademic
                            <span class="text-xs font-bold">S</span>tudent
                            <span class="text-xs font-bold">P</span>ortal
                            <span class="text-xs font-bold">I</span>nformation
                            <span class="text-xs font-bold">R</span>ecords and
                            <span class="text-xs font-bold">E</span>nrollment</span>
                    </div>
                </div>
            </a>
            
            <div class="hidden md:flex gap-8 items-center font-headline font-semibold tracking-tight">
                <a class="text-stone-500 hover:text-primary transition-all duration-300" href="{{ route('home') }}">Home</a>
                <a class="text-primary hover:text-primary transition-all duration-300" href="{{ route('programs') }}">Programs</a>
                
                @guest
                    <a class="text-stone-500 hover:text-primary transition-all duration-300" href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}" class="bg-primary hover:bg-primary-container text-white px-6 py-2.5 rounded-lg transition-all duration-300 shadow-md">
                        Enroll Now
                    </a>
                @endguest

                @auth
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 p-1 rounded-full hover:bg-stone-50 transition-all border border-transparent hover:border-stone-200">
                            <div class="size-10 rounded-full overflow-hidden border-2 border-primary/20 bg-primary/10 flex items-center justify-center">
                                @if(auth()->user()->avatar)
                                    <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="size-full object-cover">
                                @else
                                    <span class="text-primary font-black text-sm uppercase">{{ auth()->user()->initials() }}</span>
                                @endif
                            </div>
                            <span class="material-symbols-outlined text-stone-400 group-hover:text-primary transition-colors">expand_more</span>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-2xl border border-stone-100 py-2 z-50 overflow-hidden" 
                             style="display: none;">
                            
                            <div class="px-5 py-4 border-b border-stone-50 bg-stone-50/50">
                                <p class="text-xs font-black text-primary uppercase tracking-widest mb-1">Authenticated User</p>
                                <p class="font-bold text-stone-900 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-[10px] text-stone-500 truncate">{{ auth()->user()->email }}</p>
                            </div>

                            <div class="py-2">
                                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-5 py-3 text-xs font-bold text-stone-600 hover:text-primary hover:bg-stone-50 transition-colors">
                                    <span class="material-symbols-outlined text-lg">dashboard</span>
                                    My Dashboard
                                </a>
                                <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-5 py-3 text-xs font-bold text-stone-600 hover:text-primary hover:bg-stone-50 transition-colors">
                                    <span class="material-symbols-outlined text-lg">person</span>
                                    Account Settings
                                </a>
                            </div>

                            <div class="border-t border-stone-50 pt-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-5 py-4 text-xs font-black text-red-600 hover:bg-red-50 transition-colors uppercase tracking-widest text-left">
                                        <span class="material-symbols-outlined text-lg">logout</span>
                                        Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

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

    <!-- Footer -->
    <footer class="bg-stone-50 py-20 px-8 border-t border-stone-100">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12">
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="size-10 bg-primary flex items-center justify-center rounded-lg p-1.5 shadow-md">
                        <x-app-logo-icon class="size-full fill-current text-white" />
                    </div>
                    <div class="flex flex-col leading-none">
                        <span class="text-[8px] font-black text-primary uppercase tracking-widest">TNTS</span>
                        <span class="text-lg font-black text-primary-container tracking-tighter">ASPIRE</span>
                    </div>
                </div>
                <p class="text-xs text-stone-500 leading-loose">
                    Crafting technical legacies since 1964.
                </p>
            </div>
            <div>
                <h6 class="text-[10px] font-black uppercase tracking-[0.3em] text-primary mb-6">Links</h6>
                <ul class="space-y-4 text-xs font-bold text-stone-600 uppercase tracking-widest">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('register') }}">Enrollment</a></li>
                    <li><a href="{{ route('login') }}">Portal</a></li>
                </ul>
            </div>
            <div class="col-span-2">
                <div class="bg-primary/5 p-8 rounded-2xl border border-primary/10">
                    <h5 class="text-primary font-black mb-4 uppercase tracking-widest text-xs">Ready to start?</h5>
                    <p class="text-sm text-stone-600 mb-6 leading-relaxed">Join the next generation of technical experts and academic achievers. Online enrollment for 2026-2027 is now open.</p>
                    @guest
                    <a href="{{ route('register') }}" class="inline-block bg-primary text-white px-8 py-3 rounded-lg font-black text-xs uppercase tracking-[0.2em]">Apply Now</a>
                    @endguest
                    @auth
                    <a href="{{ route('dashboard') }}" class="inline-block bg-primary text-white px-8 py-3 rounded-lg font-black text-xs uppercase tracking-[0.2em]">My Dashboard</a>
                    @endauth
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
