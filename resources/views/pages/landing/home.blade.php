<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Tanza National Trade School | ASPIRE</title>
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
        .hero-gradient {
            background: linear-gradient(to right, rgba(87, 0, 0, 0.95), rgba(128, 0, 0, 0.7)), url('https://lh3.googleusercontent.com/aida-public/AB6AXuDyt6qZirvEpduHdFc54kItKQBe-_dWS-eBUXxd3EZWSYJs-1E1DQ9XWY7uHdKgPgzA1hY-sMvCjnKsCJi17WFavGIP6oE41MuihtZQewsXhVgP2rmz3qSavXawfCe__CfYPQ0slud_nsmdEwVmPolrLehFNtq3Sm1anFYf0ATa9FxTt_7D-T_Xz9gS5eu6cJbcfT3HyO9CMEgPkvrq2Nmkiny2-JXVWacJiSuc-9QuDtsoYxCdYqCV9Z7-wIZPwFim-vT8osv7hTQ');
            background-size: cover;
            background-position: center;
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>
<body class="bg-surface text-on-surface font-body selection:bg-primary-container selection:text-on-primary-container">
    <!-- Top Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-white/80 dark:bg-stone-950/80 backdrop-blur-md shadow-sm border-b border-stone-100/50">
        <div class="flex justify-between items-center max-w-7xl mx-auto px-6 h-20">
            <a href="{{ route('home') }}">
                <div class="flex items-center gap-4">
                    <div class="size-12 flex items-center justify-center rounded-xl">
                        <x-app-logo-image class="size-full fill-current text-white" />
                    </div>
                    <div class="flex flex-col justify-center leading-none mt-1">
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
                <a class="text-stone-500 hover:text-primary transition-all duration-300" href="{{ route('programs') }}">Programs</a>
                <!-- <a class="text-stone-500 hover:text-primary transition-all duration-300" href="#">Admissions</a> -->
                <!-- <a class="text-stone-500 hover:text-primary transition-all duration-300" href="#">Legacy</a> -->
                
                @guest
                    <a class="text-stone-500 hover:text-primary transition-all duration-300" href="{{ route('login-portal') }}">Student Portal</a>
                    <a href="{{ route('login-portal') }}" class="bg-primary hover:bg-primary-container text-white px-6 py-2.5 rounded-lg transition-all duration-300 shadow-md">
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
                <a href="{{ route('enrollment.index') }}" class="px-12 py-5 bg-primary text-white font-black rounded-xl hover:scale-105 transition-all shadow-2xl shadow-primary/30 uppercase tracking-widest text-sm">
                    Begin Application
                </a>
            </div>
            @endguest
        </div>
    </section>

    <!-- Footer -->
    
    @include('pages.landing.partials.footer')
</body>
</html>
