<x-layouts::student-portal :title="__('Student Profile')">
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-black text-[#1b0d0d] dark:text-white tracking-tight">Student Profile</h1>
            <p class="text-[#9a4c4c] dark:text-[#c4a1a1]">Comprehensive view of your student information</p>
        </div>
        <div class="flex items-center gap-2 bg-primary/10 text-primary px-4 py-2 rounded-xl text-xs font-bold border border-primary/20">
            <span class="material-symbols-outlined text-sm">lock</span>
            READ-ONLY MODE
        </div>
    </div>

    <div class="space-y-8">
        <!-- Profile Header -->
        <div class="bg-white dark:bg-[#2d1818] rounded-3xl border border-[#e7cfcf] dark:border-[#3d2424] p-8 shadow-sm">
            <div class="flex flex-col md:flex-row items-center gap-8">
                <div class="size-32 rounded-3xl overflow-hidden border-4 border-primary/10 shadow-lg">
                    @if($enrollment->profile_picture)
                        <img src="{{ asset('storage/' . $enrollment->profile_picture) }}" class="size-full object-cover">
                    @else
                        <div class="size-full bg-primary/5 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-6xl opacity-20">person</span>
                        </div>
                    @endif
                </div>
                <div class="text-center md:text-left flex-1">
                    <h2 class="text-2xl font-black text-[#1b0d0d] dark:text-white uppercase leading-none mb-2">{{ $enrollment->first_name }} {{ $enrollment->middle_name ? $enrollment->middle_name . ' ' : '' }}{{ $enrollment->last_name }}</h2>
                    <p class="text-primary font-bold text-lg mb-4">LRN: {{ $enrollment->lrn }}</p>
                    <div class="flex flex-wrap justify-center md:justify-start gap-3">
                        <span class="px-3 py-1 bg-primary/10 rounded-full text-[10px] font-bold text-primary uppercase tracking-wider border border-primary/20">{{ $enrollment->school_category }}</span>
                        <span class="px-3 py-1 bg-gray-100 dark:bg-white/5 rounded-full text-[10px] font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider border border-gray-200 dark:border-white/10">{{ $enrollment->grade_level }}</span>
                        @if($enrollment->strand || $enrollment->specialization)
                            <span class="px-3 py-1 bg-gray-100 dark:bg-white/5 rounded-full text-[10px] font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider border border-gray-200 dark:border-white/10">{{ $enrollment->strand ?: $enrollment->specialization }}</span>
                        @endif
                        <span class="px-3 py-1 bg-green-100 rounded-full text-[10px] font-bold text-green-600 uppercase tracking-wider border border-green-200">{{ $enrollment->status }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Personal Information -->
            <section class="bg-white dark:bg-[#2d1818] rounded-2xl border border-[#e7cfcf] dark:border-[#3d2424] overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b border-[#e7cfcf] dark:border-[#3d2424] bg-primary/5">
                    <h3 class="text-sm font-bold text-[#1b0d0d] dark:text-white flex items-center gap-2 uppercase tracking-widest">
                        <span class="material-symbols-outlined text-primary">badge</span>
                        Personal Information
                    </h3>
                </div>
                <div class="p-6 grid grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Sex</p>
                        <p class="text-sm font-bold">{{ $enrollment->sex }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Birthdate</p>
                        <p class="text-sm font-bold">{{ $enrollment->birthdate->format('M d, Y') }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">PSA Number</p>
                        <p class="text-sm font-bold">{{ $enrollment->psa_no ?: 'N/A' }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Mother Tongue</p>
                        <p class="text-sm font-bold text-primary">{{ $enrollment->mother_tongue ?: 'N/A' }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">IP Community</p>
                        <p class="text-sm font-bold">{{ $enrollment->is_ip ? ($enrollment->ip_community ?: 'Yes') : 'No' }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">4Ps Recipient</p>
                        <p class="text-sm font-bold">{{ $enrollment->is_4ps ? ($enrollment->household_id ?: 'Yes') : 'No' }}</p>
                    </div>
                </div>
            </section>

            <!-- Contact & Address -->
            <section class="bg-white dark:bg-[#2d1818] rounded-2xl border border-[#e7cfcf] dark:border-[#3d2424] overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b border-[#e7cfcf] dark:border-[#3d2424] bg-primary/5">
                    <h3 class="text-sm font-bold text-[#1b0d0d] dark:text-white flex items-center gap-2 uppercase tracking-widest">
                        <span class="material-symbols-outlined text-primary">location_on</span>
                        Contact & Address
                    </h3>
                </div>
                <div class="p-6 space-y-6">
                    <div class="space-y-1">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Current Address</p>
                        <p class="text-sm font-bold leading-relaxed">
                            {{ $enrollment->current_house_no }} {{ $enrollment->current_street }}, 
                            {{ $enrollment->current_barangay }}, {{ $enrollment->current_municipality }}, 
                            {{ $enrollment->current_province }}, {{ $enrollment->current_zip }}
                        </p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Permanent Address</p>
                        <p class="text-sm font-bold leading-relaxed">
                            @if($enrollment->is_same_address)
                                <span class="text-xs text-gray-400 font-medium italic">Same as current address</span>
                            @else
                                {{ $enrollment->permanent_house_no }} {{ $enrollment->permanent_street }}, 
                                {{ $enrollment->permanent_barangay }}, {{ $enrollment->permanent_municipality }}, 
                                {{ $enrollment->permanent_province }}, {{ $enrollment->permanent_zip }}
                            @endif
                        </p>
                    </div>
                </div>
            </section>

            <!-- Family Information -->
            <section class="bg-white dark:bg-[#2d1818] rounded-2xl border border-[#e7cfcf] dark:border-[#3d2424] overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b border-[#e7cfcf] dark:border-[#3d2424] bg-primary/5">
                    <h3 class="text-sm font-bold text-[#1b0d0d] dark:text-white flex items-center gap-2 uppercase tracking-widest">
                        <span class="material-symbols-outlined text-primary">family_restroom</span>
                        Family Information
                    </h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Father's Full Name</p>
                        <p class="text-sm font-bold">{{ $enrollment->father_name ?: 'N/A' }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Mother's Maiden Name</p>
                        <p class="text-sm font-bold">{{ $enrollment->mother_maiden_name ?: 'N/A' }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Guardian's Full Name</p>
                        <p class="text-sm font-bold">{{ $enrollment->guardian_name ?: 'N/A' }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Emergency Contact No.</p>
                        <p class="text-sm font-bold text-primary">{{ $enrollment->contact_no ?: 'N/A' }}</p>
                    </div>
                </div>
            </section>

            <!-- Education History -->
            <section class="bg-white dark:bg-[#2d1818] rounded-2xl border border-[#e7cfcf] dark:border-[#3d2424] overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b border-[#e7cfcf] dark:border-[#3d2424] bg-primary/5">
                    <h3 class="text-sm font-bold text-[#1b0d0d] dark:text-white flex items-center gap-2 uppercase tracking-widest">
                        <span class="material-symbols-outlined text-primary">history_edu</span>
                        Education History
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Last Grade Level</p>
                            <p class="text-sm font-bold">{{ $enrollment->last_grade_level ?: 'N/A' }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Last School Year</p>
                            <p class="text-sm font-bold text-primary">{{ $enrollment->last_school_year ?: 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Last School Attended</p>
                        <p class="text-sm font-bold">{{ $enrollment->last_school_attended ?: 'N/A' }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Last School ID</p>
                        <p class="text-sm font-bold">{{ $enrollment->last_school_id ?: 'N/A' }}</p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-layouts::student-portal>
