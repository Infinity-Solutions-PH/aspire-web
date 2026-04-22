<nav x-data="{ mobileMenuOpen: false }" class="fixed top-0 w-full z-50 bg-white/80 dark:bg-stone-950/80 backdrop-blur-md shadow-sm border-b border-stone-100/50">
    <div class="flex justify-between items-center max-w-7xl mx-auto px-6 h-20">
        <a href="{{ route('home') }}">
            <div class="flex items-center gap-4">
                <div class="size-12 flex items-center justify-center rounded-xl">
                    <x-app-logo-image class="size-full fill-current text-white" />
                </div>
                <div class="hidden md:flex flex-col justify-center leading-none mt-1">
                    <span class="text-2xl font-black text-primary-container tracking-tighter uppercase leading-[1rem]">Tanza National Trade School</span>
                    <span class="text-[10px] font-normal text-primary tracking-[0.3px] uppercase">
                        <span class="text-xs font-bold">A</span>cademic
                        <span class="text-xs font-bold">S</span>tudent
                        <span class="text-xs font-bold">P</span>ortal
                        <span class="text-xs font-bold">I</span>nformation
                        <span class="text-xs font-bold">R</span>ecords and
                        <span class="text-xs font-bold">E</span>nrollment
                    </span>
                </div>
                <div class="flex md:hidden flex-col justify-center leading-none mt-1">
                    <span class="text-2xl font-black text-primary-container tracking-tighter uppercase leading-[1rem]">TNTS</span>
                    <span class="text-[10px] font-normal text-primary tracking-[0.3px] uppercase">
                        <span class="text-xs font-bold">ASPIRE</span>
                    </span>
                </div>
            </div>
        </a>
        
        <div class="hidden md:flex gap-8 items-center font-headline font-semibold tracking-tight">
            <a class="{{ request()->routeIs('home') ? 'text-primary' : 'text-stone-500' }} hover:text-primary transition-all duration-300" href="{{ route('home') }}">Home</a>
            <a class="{{ request()->routeIs('programs') ? 'text-primary' : 'text-stone-500' }} hover:text-primary transition-all duration-300" href="{{ route('programs') }}">Programs</a>
            <!-- <a class="text-stone-500 hover:text-primary transition-all duration-300" href="#">Admissions</a> -->
            <!-- <a class="text-stone-500 hover:text-primary transition-all duration-300" href="#">Legacy</a> -->
            
            @guest
                <a class="text-stone-500 hover:text-primary transition-all duration-300" href="{{ route('portal.login') }}">Student Portal</a>
                <a href="{{ route('enroll.public') }}" class="bg-primary hover:bg-primary-container text-white px-6 py-2.5 rounded-lg transition-all duration-300 shadow-md">
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

        <!-- Mobile Menu Toggle -->
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 text-stone-500 hover:text-primary transition-colors rounded-lg hover:bg-stone-100">
            <span class="material-symbols-outlined text-3xl" x-text="mobileMenuOpen ? 'close' : 'menu'">menu</span>
        </button>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div x-show="mobileMenuOpen" 
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4"
            @click.away="mobileMenuOpen = false"
            class="md:hidden absolute top-20 left-0 w-full bg-white border-b border-stone-100 shadow-xl"
            style="display: none;">
        
        <div class="flex flex-col px-6 py-4 space-y-4 font-headline font-semibold tracking-tight shadow-inner bg-white">
            <a class="{{ request()->routeIs('home') ? 'text-primary' : 'text-stone-500' }} hover:text-primary transition-all duration-300 py-2 border-b border-stone-50" href="{{ route('home') }}">Home</a>
            <a class="{{ request()->routeIs('programs') ? 'text-primary' : 'text-stone-500' }} hover:text-primary transition-all duration-300 py-2 border-b border-stone-50" href="{{ route('programs') }}">Programs</a>
            
            @guest
                <a class="text-stone-500 hover:text-primary transition-all duration-300 py-2 border-b border-stone-50" href="{{ route('portal.login') }}">Student Portal</a>
                <a href="{{ route('enroll.public') }}" class="bg-primary hover:bg-primary-container text-white px-6 py-3 rounded-lg transition-all duration-300 shadow-md text-center mt-2">
                    Enroll Now
                </a>
            @endguest

            @auth
                <!-- Mobile User Section -->
                <div class="py-2 mt-2">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="size-10 rounded-full overflow-hidden border-2 border-primary/20 bg-primary/10 flex items-center justify-center">
                            @if(auth()->user()->avatar)
                                <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="size-full object-cover">
                            @else
                                <span class="text-primary font-black text-sm uppercase">{{ auth()->user()->initials() }}</span>
                            @endif
                        </div>
                        <div>
                            <p class="font-bold text-stone-900">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-stone-500">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    <div class="flex flex-col space-y-2">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 py-2 text-sm font-bold text-stone-600 hover:text-primary transition-colors border-b border-stone-50">
                            <span class="material-symbols-outlined text-lg">dashboard</span>
                            My Dashboard
                        </a>
                        <a href="{{ route('profile.show') }}" class="flex items-center gap-3 py-2 text-sm font-bold text-stone-600 hover:text-primary transition-colors border-b border-stone-50">
                            <span class="material-symbols-outlined text-lg">person</span>
                            Account Settings
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}" class="mt-2 pt-2">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 py-2 text-sm font-black text-red-600 hover:text-red-700 transition-colors uppercase tracking-widest text-left">
                                <span class="material-symbols-outlined text-lg">logout</span>
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>