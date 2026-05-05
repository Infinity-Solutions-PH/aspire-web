<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'TNTS Student Portal' }}</title>
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
        .progress-step-active {
            @apply border-primary text-primary;
        }
        .progress-step-complete {
            @apply border-green-600 text-green-600;
        }
        [x-cloak] { display: none !important; }
    </style>
    
    @livewireStyles
</head>
<body class="bg-background-light dark:bg-background-dark text-[#1b0d0d] dark:text-[#fcf8f8] min-h-screen">
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen w-full">
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-[#1b0d0d]/40 backdrop-blur-sm z-40 lg:hidden" @click="sidebarOpen = false" x-cloak></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed lg:sticky top-0 left-0 z-50 w-full lg:w-64 border-r border-[#e7cfcf] dark:border-[#3d2424] bg-background-light dark:bg-background-dark flex flex-col justify-between p-6 h-screen transition-transform duration-300 lg:translate-x-0">
            <div class="flex flex-col gap-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center rounded-lg size-10 text-white shrink-0">
                            <x-app-logo-image />
                        </div>
                        <div class="flex flex-col">
                            <h1 class="text-[#1b0d0d] dark:text-white text-lg font-bold leading-none">TNTS</h1>
                            <p class="text-primary text-xs font-medium">Student Portal</p>
                        </div>
                    </div>
                    <button @click="sidebarOpen = false" class="lg:hidden flex items-center justify-center size-8 rounded-full bg-gray-100 dark:bg-white/5 text-gray-500 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </button>
                </div>
                
                @php
                    $enrollment = \App\Models\Enrollment::where('user_id', auth()->id())->latest()->first();
                    $isEnrolled = $enrollment && $enrollment->status === 'Enrolled';
                @endphp
                
                <nav class="flex flex-col gap-2">
                    <a class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.dashboard') ? 'bg-primary/10 text-primary font-bold' : 'text-[#1b0d0d] dark:text-[#fcf8f8] hover:bg-gray-100 dark:hover:bg-white/5' }} transition-colors" href="{{ route('student.dashboard') }}">
                        <span class="material-symbols-outlined">dashboard</span>
                        <span class="text-sm">Dashboard</span>
                    </a>
                    {{-- <a class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('enrollment.index') ? 'bg-primary/10 text-primary font-bold' : 'text-[#1b0d0d] dark:text-[#fcf8f8] hover:bg-gray-100 dark:hover:bg-white/5' }} transition-colors" href="{{ route('enrollment.index') }}">
                        <span class="material-symbols-outlined">how_to_reg</span>
                        <span class="text-sm">Enrolment Status</span>
                    </a> --}}
                    <a class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.profile') ? 'bg-primary/10 text-primary font-bold' : 'text-[#1b0d0d] dark:text-[#fcf8f8] hover:bg-gray-100 dark:hover:bg-white/5' }} transition-colors" href="{{ route('student.profile') }}">
                        <span class="material-symbols-outlined">person</span>
                        <span class="text-sm">Profile</span>
                    </a>
                    {{-- <a class="flex items-center gap-3 px-4 py-3 rounded-xl text-[#1b0d0d] dark:text-[#fcf8f8] hover:bg-gray-100 dark:hover:bg-white/5 transition-colors" href="#">
                        <span class="material-symbols-outlined">history_edu</span>
                        <span class="text-sm">Academic Records</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-xl text-[#1b0d0d] dark:text-[#fcf8f8] hover:bg-gray-100 dark:hover:bg-white/5 transition-colors" href="#">
                        <span class="material-symbols-outlined">folder_open</span>
                        <span class="text-sm">Resources</span>
                    </a> --}}
                </nav>
            </div>
            
            <div class="flex flex-col gap-4">
                <div class="flex items-center gap-3 p-3 rounded-xl bg-[#f3e7e7] dark:bg-[#3d2424]">
                    @if(!empty(auth()->user()->avatar))
                        <div class="size-10 rounded-full shrink-0 bg-cover bg-center" style="background-image: url('{{ auth()->user()->avatar }}')"></div>
                    @else
                        <div class="size-10 rounded-full shrink-0 bg-primary/20 text-primary flex items-center justify-center font-bold text-sm uppercase tracking-widest">
                            {{ auth()->user()->initials() }}
                        </div>
                    @endif
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-primary">Student Account</p>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl h-12 bg-primary text-white text-sm font-bold shadow-lg shadow-primary/20 hover:bg-maroon-accent transition-all">
                        <span class="material-symbols-outlined text-sm">logout</span>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <main class="flex-1 flex flex-col overflow-y-auto">
            <!-- Header -->
            <header class="flex items-center justify-between px-4 lg:px-8 py-4 bg-background-light dark:bg-background-dark border-b border-[#e7cfcf] dark:border-[#3d2424]">
                <div class="flex items-center gap-3 lg:gap-4 flex-1 max-w-xl">
                    <button @click="sidebarOpen = true" class="lg:hidden flex items-center justify-center size-10 rounded-xl bg-[#f3e7e7] dark:bg-[#3d2424] text-[#1b0d0d] dark:text-white shrink-0 transition-colors hover:bg-[#e7cfcf]">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <div class="relative w-full hidden sm:block">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                        <input class="w-full bg-[#f3e7e7] dark:bg-[#3d2424] border-none rounded-xl pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-primary/50 transition-all placeholder:text-gray-500" placeholder="Search status, fees or documents..." type="text"/>
                    </div>
                </div>
                <div class="flex items-center gap-2 lg:gap-4">
                    <button class="size-10 flex items-center justify-center rounded-xl bg-[#f3e7e7] dark:bg-[#3d2424] text-[#1b0d0d] dark:text-white relative">
                        <span class="material-symbols-outlined">notifications</span>
                        <span class="absolute top-2 right-2 size-2 bg-primary rounded-full"></span>
                    </button>
                    <button class="size-10 flex items-center justify-center rounded-xl bg-[#f3e7e7] dark:bg-[#3d2424] text-[#1b0d0d] dark:text-white">
                        <span class="material-symbols-outlined">settings</span>
                    </button>
                </div>
            </header>

            <!-- Content Area -->
            <div class="p-4 lg:p-8 max-w-7xl mx-auto w-full">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <footer class="mt-auto px-8 py-6 border-t border-[#e7cfcf] dark:border-[#3d2424] text-center">
                <p class="text-xs text-[#9a4c4c] dark:text-[#c4a1a1]">© 2026 Tanza National Trade School &sdot; ASPIRE. All rights reserved.</p>
            </footer>
        </main>
    </div>

    @livewireScripts
</body>
</html>
