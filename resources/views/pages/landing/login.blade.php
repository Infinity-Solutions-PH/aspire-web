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
                <div class="flex items-center gap-3 text-white mb-12">
                    <div class="size-10">
                        <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                            <path d="M36.7273 44C33.9891 44 31.6043 39.8386 30.3636 33.69C29.123 39.8386 26.7382 44 24 44C21.2618 44 18.877 39.8386 17.6364 33.69C16.3957 39.8386 14.0109 44 11.2727 44C7.25611 44 4 35.0457 4 24C4 12.9543 7.25611 4 11.2727 4C14.0109 4 16.3957 8.16144 17.6364 14.31C18.877 8.16144 21.2618 4 24 4C26.7382 4 29.123 8.16144 30.3636 14.31C31.6043 8.16144 33.9891 4 36.7273 4C40.7439 4 44 12.9543 44 24C44 35.0457 40.7439 44 36.7273 44Z" fill="white"></path>
                        </svg>
                        <!-- <img src="{{ asset('images/logo.png') }}"> -->
                    </div>
                    <span class="text-xl font-bold tracking-tight uppercase">ASPIRE</span>
                </div>
                <div>
                    <span class="text-xl font-bold tracking-tight uppercase">Tanza National Trade School</span>
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
            <div class="w-full max-w-[420px]">
                <div class="mb-10 text-center lg:text-left">
                    <h2 class="text-4xl font-bold text-gray-900 mb-3">Welcome back</h2>
                    <p class="text-gray-500 font-normal">Enter your details to access your school dashboard.</p>
                </div>
                <form class="space-y-5" onsubmit="return false;">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700 block ml-1">Student / Employee ID</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors">badge</span>
                            <input class="w-full h-14 bg-gray-50 border-none rounded-xl pl-12 pr-4 text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-primary/20 transition-all text-base" placeholder="ID Number (e.g. 2024-001)" type="text"/>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center ml-1">
                            <label class="text-sm font-semibold text-gray-700">Password</label>
                            <a class="text-primary text-xs font-bold hover:underline" href="#">Forgot password?</a>
                        </div>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors">lock</span>
                            <input class="w-full h-14 bg-gray-50 border-none rounded-xl pl-12 pr-12 text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-primary/20 transition-all text-base" placeholder="••••••••" type="password"/>
                            <button class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors" type="button">
                                <span class="material-symbols-outlined text-[22px]">visibility</span>
                            </button>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 ml-1">
                        <input class="rounded-md text-primary focus:ring-primary border-gray-300 h-4 w-4" id="remember" type="checkbox"/>
                        <label class="text-sm text-gray-600 cursor-pointer" for="remember">Keep me logged in</label>
                    </div>
                    <button class="w-full bg-accent-red hover:bg-primary text-white font-bold h-14 rounded-xl shadow-lg shadow-accent-red/10 transition-all flex items-center justify-center gap-2 mt-2" type="submit">
                        <span class="text-base">Sign In</span>
                        <span class="material-symbols-outlined text-lg">arrow_forward</span>
                    </button>
                </form>
                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-100"></div>
                    </div>
                    <div class="relative flex justify-center text-xs uppercase">
                        <span class="bg-white px-4 text-gray-400 font-bold tracking-[0.2em]">OR</span>
                    </div>
                </div>
                <a href="{{ route('google.redirect') }}" class="w-full bg-white border border-gray-200 hover:border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold h-14 rounded-xl transition-all flex items-center justify-center gap-3 px-4 shadow-sm">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"></path>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"></path>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"></path>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"></path>
                    </svg>
                    <span class="text-sm">Sign in with Google</span>
                </a>
                <div class="mt-12 text-center">
                    <p class="text-sm text-gray-500">
                        Don't have an account yet? 
                        <a class="text-primary font-bold hover:underline ml-1" href="#">Contact Registrar</a>
                    </p>
                </div>
            </div>
            <div class="mt-auto pt-8 text-center lg:hidden">
                <p class="text-[10px] text-gray-400 uppercase tracking-widest font-medium">
                    © 2024 Tanza National Trade School
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