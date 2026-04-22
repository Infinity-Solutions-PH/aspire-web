<footer class="bg-stone-50 py-20 px-8 border-t border-stone-100">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12">
        <div>
            <div class="flex items-center gap-3 mb-6">
                <div class="flex items-center justify-center">
                    <x-app-logo-image class="w-[64px]" />
                </div>
                <div class="flex flex-col leading-none">
                    <span class="text-[10px] font-black text-primary uppercase tracking-widest">Tanza National Trade School</span>
                    <!-- <span class="text-lg font-black text-primary-container tracking-tighter">ASPIRE</span> -->
                    <span class="text-[8px] font-normal text-primary tracking-[0.3px] uppercase">
                        <span class="text-xs font-bold">A</span>cademic
                        <span class="text-xs font-bold">S</span>tudent
                        <span class="text-xs font-bold">P</span>ortal
                        <span class="text-xs font-bold">I</span>nformation
                        <span class="text-xs font-bold">R</span>ecords and
                        <span class="text-xs font-bold">E</span>nrollment
                    </span>
                </div>
            </div>
            <p class="text-xs text-stone-500 leading-loose">
                Developing technically skilled and value-oriented graduates since 1963. The premier hub for craftsmanship in Tanza, Cavite.
            </p>
        </div>
        <div>
            <h6 class="text-[10px] font-black uppercase tracking-[0.3em] text-primary mb-6">Links</h6>
            <ul class="space-y-4 text-xs font-bold text-stone-600 uppercase tracking-widest">
                <li><a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a></li>
                <li><a href="{{ route('enrollment.index') }}" class="hover:text-primary transition-colors">Enrollment</a></li>
                <li><a href="{{ route('programs') }}" class="hover:text-primary transition-colors">Programs</a></li>
                <li><a href="{{ route('portal.login') }}" class="hover:text-primary transition-colors">Student Portal</a></li>
                <li><a href="#" class="hover:text-primary transition-colors">Contact</a></li>
            </ul>
        </div>
        <div class="col-span-2">
            <div class="bg-primary/5 p-8 rounded-2xl border border-primary/10">
                <h5 class="text-primary font-black mb-4 uppercase tracking-widest text-xs">Ready to start?</h5>
                <p class="text-sm text-stone-600 mb-6 leading-relaxed">Join the next generation of technical experts and academic achievers. Online enrollment for 2026-2027 is now open.</p>
                @guest
                <a href="{{ route('enroll.public') }}" class="inline-block bg-primary text-white px-8 py-3 rounded-lg font-black text-xs uppercase tracking-[0.2em]">Apply Now</a>
                @endguest
                @auth
                <a href="{{ route('dashboard') }}" class="inline-block bg-primary text-white px-8 py-3 rounded-lg font-black text-xs uppercase tracking-[0.2em]">My Dashboard</a>
                @endauth
            </div>
        </div>
    </div>
</footer>