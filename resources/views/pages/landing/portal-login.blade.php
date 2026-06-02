<x-landing-layout :title="$title ?? null">
    <div class="flex h-screen w-full overflow-hidden">
        <div class="hidden lg:flex w-[40%] bg-primary flex-col justify-between p-16 relative overflow-hidden"
             x-data="landingSlider">
            
            <!-- Dynamic Background -->
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="activeSlide === index"
                    x-transition:enter="transition ease-out duration-1000"
                    x-transition:enter-start="opacity-0 scale-105"
                    x-transition:enter-end="opacity-10 scale-100"
                    x-transition:leave="transition ease-in duration-1000"
                    x-transition:leave-start="opacity-10"
                    x-transition:leave-end="opacity-0"
                    class="absolute inset-0 bg-cover bg-center mix-blend-overlay opacity-10 pointer-events-none"
                    :style="'background-image: url(' + slide.img + ')'">
                </div>
            </template>

            <div class="relative z-10">
                <div class="flex flex-row items-center gap-3 text-white mb-12">
                    <div class="size-12 flex items-center justify-center rounded-xl p-2 bg-white shadow-lg shadow-primary/80">
                        <x-app-logo-image class="size-full fill-current text-white" />
                    </div>
                    <div class="hidden md:flex flex-col items-start mt-1.5">
                        <span class="text-lg text-white font-bold tracking-tight uppercase leading-[1rem]">Tanza National Trade School</span>
                        <span class="text-sm font-bold tracking-tight">
                            <span class="text-xl font-bold">A</span>cademic
                            <span class="text-xl font-bold">S</span>tudent
                            <span class="text-xl font-bold">P</span>ortal
                            <span class="text-xl font-bold">I</span>nformation
                            <span class="text-xl font-bold">R</span>ecords and
                            <span class="text-xl font-bold">E</span>nrollment</span>
                        </span>
                    </div>
                    <div class="flex md:hidden flex-col justify-center leading-none mt-1">
                        <span class="text-2xl font-black text-primary-container tracking-tighter uppercase leading-[1rem]">TNTS</span>
                        <span class="text-[10px] font-normal text-primary tracking-[0.3px] uppercase">
                            <span class="text-xs font-bold">ASPIRE</span>
                        </span>
                    </div>
                </div>
                <div class="space-y-6 relative h-48">
                    <template x-for="(slide, index) in slides" :key="index">
                        <div x-show="activeSlide === index"
                             x-transition:enter="transition ease-out duration-700 delay-300"
                             x-transition:enter-start="opacity-0 translate-x-8"
                             x-transition:enter-end="opacity-100 translate-x-0"
                             x-transition:leave="transition ease-in duration-500 absolute top-0"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0 -translate-x-8"
                             class="w-full">
                            <h1 class="text-5xl font-extrabold text-white leading-[1.1] tracking-tight mb-6" x-text="slide.title"></h1>
                            <p class="text-white/80 text-lg font-light leading-relaxed max-w-sm" x-text="slide.sub"></p>
                        </div>
                    </template>
                </div>
            </div>
            <div class="relative z-10">
                <div class="flex gap-4">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button 
                            @click="activeSlide = index; resetTimer()"
                            class="h-1 rounded-full transition-all duration-500"
                            :class="activeSlide === index ? 'w-16 bg-white' : 'w-8 bg-white/30 hover:bg-white/50'">
                        </button>
                    </template>
                </div>
                <p class="text-white/60 text-xs mt-6 tracking-widest uppercase font-medium">Tanza National Trade School</p>
            </div>
        </div>
        <div class="flex-1 bg-white flex flex-col justify-center items-center p-8 sm:p-12 lg:p-24 overflow-y-auto">
            <div class="w-full max-w-[420px]" x-data="{ view: 'returning' }">
                <a href="{{ route('home') }}" class="group inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-primary transition-all">
                    <span class="material-symbols-outlined text-lg group-hover:-translate-x-1 transition-transform">arrow_back</span>
                    Return Home
                </a>
                <div class="mb-10 text-center lg:text-left">
                    <h2 class="text-4xl font-bold text-gray-900 mb-3" x-text="view === 'returning' ? 'Welcome back' : 'Start your journey'">Welcome back</h2>
                    <p class="text-gray-500 font-normal" x-text="view === 'returning' ? 'Enter your details to access your school dashboard.' : 'Create an applicant account to begin your enrollment.'">Enter your details to access your school dashboard.</p>
                </div>

                <!-- View Switcher -->
                <div class="flex p-1 bg-gray-100 rounded-xl mb-8">
                    <button 
                        @click="view = 'returning'"
                        :class="view === 'returning' ? 'bg-white shadow-sm text-primary' : 'text-gray-500 hover:text-gray-700'"
                        class="flex-1 py-2.5 text-sm font-bold rounded-lg transition-all">
                        Returning Student
                    </button>
                    <button 
                        @click="view = 'new'"
                        :class="view === 'new' ? 'bg-white shadow-sm text-primary' : 'text-gray-500 hover:text-gray-700'"
                        class="flex-1 py-2.5 text-sm font-bold rounded-lg transition-all">
                        New Student
                    </button>
                </div>

                <!-- Returning Student Login -->
                <div x-show="view === 'returning'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <form class="space-y-5" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700 block ml-1">LRN</label>
                            <div class="relative group">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors">badge</span>
                                <input name="email" class="w-full h-14 bg-gray-50 border-none rounded-xl pl-12 pr-4 text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-primary/20 transition-all text-base" placeholder="LRN" type="text" required value="{{ old('email') }}"/>
                            </div>
                            @error('email') <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center ml-1">
                                <label class="text-sm font-semibold text-gray-700">Password</label>
                                <!-- @if (Route::has('password.request'))
                                    <a class="text-primary text-xs font-bold hover:underline" href="{{ route('password.request') }}">Forgot password?</a>
                                @endif -->
                            </div>
                            <div class="relative group" x-data="{ show: false }">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors">lock</span>
                                <input name="password" class="w-full h-14 bg-gray-50 border-none rounded-xl pl-12 pr-12 text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-primary/20 transition-all text-base" placeholder="••••••••" :type="show ? 'text' : 'password'" required/>
                                <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary transition-colors focus:outline-none">
                                    <span class="material-symbols-outlined select-none" x-text="show ? 'visibility' : 'visibility_off'"></span>
                                </button>
                            </div>
                        </div>
                        <!-- <div class="flex items-center gap-2 ml-1">
                            <input name="remember" class="rounded-md text-primary focus:ring-primary border-gray-300 h-4 w-4" id="remember" type="checkbox"/>
                            <label class="text-sm text-gray-600 cursor-pointer" for="remember">Keep me logged in</label>
                        </div> -->
                        <button class="w-full bg-accent-red hover:bg-primary text-white font-bold h-14 rounded-xl shadow-lg shadow-accent-red/10 transition-all flex items-center justify-center gap-2 mt-2" type="submit">
                            <span class="text-base">Sign In</span>
                            <span class="material-symbols-outlined text-lg">arrow_forward</span>
                        </button>
                    </form>
                </div>

                <!-- New Student / Applicant Section -->
                <div x-show="view === 'new'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div class="bg-primary/5 border border-primary/10 rounded-2xl p-6 space-y-4">
                        <div class="size-12 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-3xl">person_add</span>
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-lg font-bold text-gray-900">Incoming Student?</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">If you are an incoming Grade 7 student, a transferee, or starting Senior High, please create an applicant account to begin.</p>
                        </div>
                        <ul class="space-y-3">
                            <li class="flex items-center gap-3 text-sm text-gray-700">
                                <span class="material-symbols-outlined text-primary text-lg">check_circle</span>
                                Save your progress anytime
                            </li>
                            <li class="flex items-center gap-3 text-sm text-gray-700">
                                <span class="material-symbols-outlined text-primary text-lg">check_circle</span>
                                Track application status
                            </li>
                        </ul>
                    </div>
                    <a href="{{ route('enroll.public') }}" class="w-full bg-primary hover:bg-accent-red text-white font-bold h-14 rounded-xl shadow-lg shadow-primary/10 transition-all flex items-center justify-center gap-2 mt-2">
                        <span class="text-base">Create Applicant Account</span>
                        <span class="material-symbols-outlined text-lg">assignment_ind</span>
                    </a>
                </div>


                <div class="mt-12 text-center">
                    <p class="text-sm text-gray-500">
                        Need assistance? 
                        <a class="text-primary font-bold hover:underline ml-1" href="mailto:support@tnts.edu.ph">Contact Support</a>
                    </p>
                </div>
            </div>
            <div class="mt-auto pt-8 text-center lg:hidden">
                <p class="text-[10px] text-gray-400 uppercase tracking-widest font-medium">
                    © 2026 Tanza National Trade School
                </p>
            </div>
        </div>
    </div>

    <x-slot:scripts>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('landingSlider', () => ({
                    activeSlide: 0,
                    slides: [
                        { 
                            title: 'Empowering Excellence.', 
                            sub: 'Education is the most powerful weapon which you can use to change the world.', 
                            img: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBiofNX4MzCToArjGU8B5k-0ZJPcxyqG3pPl-Z6LBAOyi-xd5ICZ9qtFNzhjLqTdD45s0_866nNuvQVKQK6UjqkEfm0ywSJeAUvsCtnhMonYSc2FCH5kaFnVqd2gScU2tlty9OTJtXPr7udyZNUE2elq3tOb1HMB6MGriR_s_iztaVerYXh_3r4JY5yoQCl8T12I281iO3cjWGLVP275FmNtnmlz8yGKLn0cDqZcmj3BjOzunC4teUrsREnxyo-bxW3siyhU_QQE6Y' 
                        },
                        { 
                            title: 'Innovation in Learning.', 
                            sub: 'Fostering creativity and critical thinking for the next generation of leaders.', 
                            img: '/images/slider/academic_success.png' 
                        },
                        { 
                            title: 'Technical Mastery.', 
                            sub: 'Hands-on learning for real-world success in trade and modern technology.', 
                            img: '/images/slider/technical_workshop.png' 
                        }
                    ],
                    init() {
                        this.startTimer();
                    },
                    startTimer() {
                        this.interval = setInterval(() => {
                            this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                            console.log(this.activeSlide);
                        }, 5000);
                    },
                    resetTimer() {
                        clearInterval(this.interval);
                        this.startTimer();
                    }
                }))
            })
        </script>
    </x-slot:scripts>
</x-landing-layout>