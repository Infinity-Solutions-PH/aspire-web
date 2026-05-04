<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ($title ?? '') ? $title . ' · TNTS ASPIRE Admin Portal' : 'TNTS ASPIRE Admin Portal' }}</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <!-- Scripts & Styles -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    
    <script id="tailwind-config">
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              colors: {
                "primary": "#d41111",
                "background-light": "#f8f6f6",
                "background-dark": "#221010",
                "maroon-accent": "#800000",
              },
              fontFamily: {
                "display": ["Lexend", "sans-serif"]
              },
              borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
            },
          },
        }
    </script>
    
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            font-family: 'Lexend', sans-serif;
        }
        [x-cloak] { display: none !important; }
    </style>
    
    @livewireStyles
</head>
<body class="bg-background-light dark:bg-background-dark text-[#1b0d0d] dark:text-[#fcf8f8] min-h-screen">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 border-r border-[#e7cfcf] dark:border-[#422020] bg-white dark:bg-[#1a0c0c] flex flex-col sticky top-0 h-screen">
            <div class="p-6">
                <div class="flex items-center gap-3 mb-8">
                    <div class="size-10 rounded-xl overflow-hidden flex items-center justify-center bg-white border border-[#e7cfcf] dark:border-[#422020] shadow-sm">
                        <x-app-logo-image class="w-8 h-8 object-contain" />
                    </div>
                    <div>
                        <h1 class="text-primary text-lg font-black leading-none">TNTS Admin</h1>
                        <p class="text-[#9a4c4c] dark:text-[#c48d8d] text-[10px] font-bold uppercase tracking-wider">Management System</p>
                    </div>
                </div>
                
                <nav class="flex flex-col gap-1.5">
                    @if(auth()->user()->role !== 'guidance')
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-primary/10 text-primary shadow-sm shadow-primary/5' : 'text-[#1b0d0d] dark:text-[#fcf8f8] hover:bg-[#f3e7e7] dark:hover:bg-[#361a1a]' }}" href="{{ route('admin.dashboard') }}">
                        <span class="material-symbols-outlined {{ request()->routeIs('admin.dashboard') ? 'fill-1' : '' }}" style="{{ request()->routeIs('admin.dashboard') ? "font-variation-settings: 'FILL' 1" : '' }}">dashboard</span>
                        <span class="text-sm font-bold">Dashboard</span>
                    </a>
                    
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.admissions') ? 'bg-primary/10 text-primary shadow-sm shadow-primary/5' : 'text-[#1b0d0d] dark:text-[#fcf8f8] hover:bg-[#f3e7e7] dark:hover:bg-[#361a1a]' }}" href="{{ route('admin.admissions') }}">
                        <span class="material-symbols-outlined {{ request()->routeIs('admin.admissions') ? 'fill-1' : '' }}" style="{{ request()->routeIs('admin.admissions') ? "font-variation-settings: 'FILL' 1" : '' }}">how_to_reg</span>
                        <span class="text-sm font-bold">Admissions</span>
                    </a>
                    @endif

                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.students.masterlist') ? 'bg-primary/10 text-primary shadow-sm shadow-primary/5' : 'text-[#1b0d0d] dark:text-[#fcf8f8] hover:bg-[#f3e7e7] dark:hover:bg-[#361a1a]' }}" href="{{ route('admin.students.masterlist') }}">
                        <span class="material-symbols-outlined {{ request()->routeIs('admin.students.masterlist') ? 'fill-1' : '' }}" style="{{ request()->routeIs('admin.students.masterlist') ? "font-variation-settings: 'FILL' 1" : '' }}">group</span>
                        <span class="text-sm font-bold">Student Masterlist</span>
                    </a>

                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.faculty') ? 'bg-primary/10 text-primary shadow-sm shadow-primary/5' : 'text-[#1b0d0d] dark:text-[#fcf8f8] hover:bg-[#f3e7e7] dark:hover:bg-[#361a1a]' }}" href="{{ route('admin.faculty') }}">
                        <span class="material-symbols-outlined {{ request()->routeIs('admin.faculty') ? 'fill-1' : '' }}" style="{{ request()->routeIs('admin.faculty') ? "font-variation-settings: 'FILL' 1" : '' }}">school</span>
                        <span class="text-sm font-bold">Faculty</span>
                    </a>
                    
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.sections') ? 'bg-primary/10 text-primary shadow-sm shadow-primary/5' : 'text-[#1b0d0d] dark:text-[#fcf8f8] hover:bg-[#f3e7e7] dark:hover:bg-[#361a1a]' }}" href="{{ route('admin.sections') }}">
                        <span class="material-symbols-outlined {{ request()->routeIs('admin.sections') ? 'fill-1' : '' }}" style="{{ request()->routeIs('admin.sections') ? "font-variation-settings: 'FILL' 1" : '' }}">meeting_room</span>
                        <span class="text-sm font-bold tracking-wide">Sections</span>
                    </a>
                    @if(auth()->user()->role !== 'guidance')
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.school-years') ? 'bg-primary/10 text-primary shadow-sm shadow-primary/5' : 'text-[#1b0d0d] dark:text-[#fcf8f8] hover:bg-[#f3e7e7] dark:hover:bg-[#361a1a]' }}" href="{{ route('admin.school-years') }}">
                        <span class="material-symbols-outlined {{ request()->routeIs('admin.school-years') ? 'fill-1' : '' }}" style="{{ request()->routeIs('admin.school-years') ? "font-variation-settings: 'FILL' 1" : '' }}">calendar_month</span>
                        <span class="text-sm font-bold tracking-wide">School Years</span>
                    </a>

                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.schedules') ? 'bg-primary/10 text-primary shadow-sm shadow-primary/5' : 'text-[#1b0d0d] dark:text-[#fcf8f8] hover:bg-[#f3e7e7] dark:hover:bg-[#361a1a]' }}" href="{{ route('admin.schedules') }}">
                        <span class="material-symbols-outlined {{ request()->routeIs('admin.schedules') ? 'fill-1' : '' }}" style="{{ request()->routeIs('admin.schedules') ? "font-variation-settings: 'FILL' 1" : '' }}">calendar_month</span>
                        <span class="text-sm font-bold">Schedules</span>
                    </a>
                    @endif
                </nav>
            </div>

            <div class="mt-auto p-6 space-y-4">
                <div class="flex items-center gap-3 p-3 rounded-xl bg-background-light dark:bg-[#2a1515] border border-[#e7cfcf] dark:border-[#422020]">
                    @if(!empty(auth()->user()->avatar))
                        <div class="size-9 rounded-full shrink-0 bg-cover bg-center border-2 border-primary/20" style="background-image: url('{{ auth()->user()->avatar }}')"></div>
                    @else
                        <div class="size-9 rounded-full shrink-0 bg-primary/20 text-primary flex items-center justify-center font-bold text-xs uppercase tracking-widest border-2 border-primary/20">
                            {{ auth()->user()->initials() }}
                        </div>
                    @endif
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold truncate leading-none">{{ auth()->user()->name }}</p>
                        <p class="text-[9px] text-[#9a4c4c] uppercase font-bold tracking-tighter mt-1">Admin Access</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl h-10 border border-[#e7cfcf] dark:border-[#422020] text-[#1b0d0d] dark:text-[#fcf8f8] text-xs font-bold hover:bg-primary hover:text-white hover:border-primary transition-all group">
                        <span class="material-symbols-outlined text-sm group-hover:fill-1">logout</span>
                        Sign Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col overflow-y-auto bg-background-light dark:bg-background-dark">
            <!-- Top Header -->
            <header class="h-16 border-b border-[#e7cfcf] dark:border-[#422020] bg-white dark:bg-[#1a0c0c] px-8 flex items-center justify-between sticky top-0 z-10">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-[#9a4c4c] dark:text-[#c48d8d] uppercase tracking-widest">Main</span>
                    <span class="material-symbols-outlined text-xs text-[#9a4c4c]">chevron_right</span>
                    <span class="text-sm font-bold text-gray-900 dark:text-white">
                        @yield('page-title', 'Overview')
                    </span>
                </div>
                
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-2">
                        <button class="p-2 rounded-xl hover:bg-background-light dark:hover:bg-[#361a1a] relative text-[#9a4c4c] transition-colors">
                            <span class="material-symbols-outlined">notifications</span>
                            <span class="absolute top-2 right-2 w-2 h-2 bg-primary rounded-full border-2 border-white dark:border-[#1a0c0c]"></span>
                        </button>
                        <button class="p-2 rounded-xl hover:bg-background-light dark:hover:bg-[#361a1a] text-[#9a4c4c] transition-colors">
                            <span class="material-symbols-outlined">settings</span>
                        </button>
                    </div>
                    
                    <div class="h-8 w-px bg-[#e7cfcf] dark:bg-[#422020]"></div>
                    
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <p class="text-xs font-bold leading-none text-gray-900 dark:text-white">{{ auth()->user()->role === 'guidance' ? 'Guidance Portal' : 'Admin Portal' }}</p>
                            <p class="text-[9px] text-[#9a4c4c] uppercase font-bold tracking-wider mt-1">{{ auth()->user()->role === 'guidance' ? 'Counselor Session' : 'Active Session' }}</p>
                        </div>
                        <div class="size-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">shield_person</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="p-8 max-w-[1400px] mx-auto w-full">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <footer class="mt-auto px-8 py-6 border-t border-[#e7cfcf] dark:border-[#422020] text-center">
                <p class="text-[10px] font-bold text-[#9a4c4c] dark:text-[#c4a1a1] uppercase tracking-widest">© 2026 Tanza National Trade School &sdot; ASPIRE Management System</p>
            </footer>
        </main>
    </div>

    @livewireScripts
</body>
</html>
