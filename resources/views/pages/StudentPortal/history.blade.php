<x-layouts::student-portal :title="__('Enrollment History')">
    @php
        $currentEnrollment = $enrollments->firstWhere('schoolYear.status', 'Active');
        $pastEnrollments = $enrollments->reject(function($enrollment) use ($currentEnrollment) {
            return $currentEnrollment && $enrollment->id === $currentEnrollment->id;
        });
    @endphp

    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-black text-[#1b0d0d] dark:text-white tracking-tight">Enrollment History</h1>
            <p class="text-[#9a4c4c] dark:text-[#c4a1a1]">View your current and past academic records</p>
        </div>
        <div class="flex items-center gap-2 bg-primary/10 text-primary px-4 py-2 rounded-xl text-xs font-bold border border-primary/20">
            <span class="material-symbols-outlined text-sm">lock</span>
            READ-ONLY MODE
        </div>
    </div>

    <div class="space-y-8">
        @if($currentEnrollment)
            <!-- Current Enrollment Section -->
            <section>
                <div class="flex items-center gap-3 mb-4">
                    <span class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-xl">school</span>
                    <h2 class="text-xl font-bold text-[#1b0d0d] dark:text-white">Current Enrollment</h2>
                </div>
                
                <div class="bg-white dark:bg-[#2d1818] rounded-3xl border border-[#e7cfcf] dark:border-[#3d2424] p-6 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-[100px] -mr-8 -mt-8 pointer-events-none"></div>
                    
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative z-10">
                        <div class="flex-1 w-full">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="px-3 py-1 bg-primary text-white rounded-full text-[10px] font-bold tracking-wider">
                                    SY {{ $currentEnrollment->schoolYear->name }}
                                </span>
                                <span class="px-3 py-1 bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-full text-[10px] font-bold uppercase tracking-wider border border-green-200 dark:border-green-800">
                                    {{ $currentEnrollment->status }}
                                </span>
                            </div>
                            
                            <h3 class="text-2xl font-black text-[#1b0d0d] dark:text-white mb-1">
                                {{ $currentEnrollment->grade_level }}
                                @if($currentEnrollment->strand || $currentEnrollment->specialization)
                                    <span class="text-primary font-bold px-2">•</span>
                                    <span class="text-lg font-bold text-gray-600 dark:text-gray-300">{{ $currentEnrollment->strand ?: $currentEnrollment->specialization }}</span>
                                @endif
                            </h3>
                            
                            @php
                                $section = $currentEnrollment->section ?? $currentEnrollment->techVocSection;
                            @endphp
                            
                            <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="bg-gray-50 dark:bg-[#1b0d0d] p-3 rounded-xl border border-gray-100 dark:border-[#3d2424]">
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Section</p>
                                    <p class="font-bold text-sm text-[#1b0d0d] dark:text-white">{{ $section ? $section->name : 'TBA' }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-[#1b0d0d] p-3 rounded-xl border border-gray-100 dark:border-[#3d2424]">
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Adviser</p>
                                    <p class="font-bold text-sm text-[#1b0d0d] dark:text-white truncate" title="{{ $section && $section->adviser ? $section->adviser->name : 'TBA' }}">{{ $section && $section->adviser ? $section->adviser->name : 'TBA' }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-[#1b0d0d] p-3 rounded-xl border border-gray-100 dark:border-[#3d2424]">
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Track</p>
                                    <p class="font-bold text-sm text-[#1b0d0d] dark:text-white">{{ $currentEnrollment->track ?: 'N/A' }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-[#1b0d0d] p-3 rounded-xl border border-gray-100 dark:border-[#3d2424]">
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">GWA</p>
                                    <p class="font-bold text-sm text-primary">{{ $currentEnrollment->gwa ?: 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @else
            <!-- Current Enrollment Section (Not Enrolled) -->
            <section>
                <div class="flex items-center gap-3 mb-4">
                    <span class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-xl">school</span>
                    <h2 class="text-xl font-bold text-[#1b0d0d] dark:text-white">Current Enrollment</h2>
                </div>
                
                <div class="bg-white dark:bg-[#2d1818] rounded-3xl border border-[#e7cfcf] dark:border-[#3d2424] p-8 shadow-sm flex flex-col items-center justify-center text-center">
                    <div class="bg-gray-100 dark:bg-[#1b0d0d] p-3 rounded-full mb-3">
                        <span class="material-symbols-outlined text-gray-400">info</span>
                    </div>
                    <h3 class="text-lg font-bold text-[#1b0d0d] dark:text-white mb-1">Not Enrolled</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 max-w-md">You do not have an active enrollment record for the current school year.</p>
                </div>
            </section>
        @endif

        @if($pastEnrollments->count() > 0)
            <!-- Past Enrollments Section -->
            <section>
                <div class="flex items-center gap-3 mb-4 mt-8">
                    <span class="material-symbols-outlined text-gray-500 bg-gray-100 dark:bg-[#2d1818] p-2 rounded-xl">history</span>
                    <h2 class="text-xl font-bold text-[#1b0d0d] dark:text-white">Past Records</h2>
                </div>
                
                <div class="space-y-4">
                    @foreach($pastEnrollments as $enrollment)
                        <div class="bg-white dark:bg-[#2d1818] rounded-2xl border border-[#e7cfcf] dark:border-[#3d2424] p-5 hover:shadow-md transition-shadow group relative overflow-hidden">
                            <div class="absolute inset-y-0 left-0 w-1 bg-gray-200 dark:bg-[#3d2424] group-hover:bg-primary transition-colors"></div>
                            
                            <div class="flex flex-col lg:flex-row justify-between lg:items-center gap-4 pl-4">
                                <div class="min-w-[200px]">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="px-2 py-0.5 bg-gray-100 dark:bg-[#1b0d0d] text-gray-700 dark:text-gray-300 rounded text-[10px] font-bold tracking-wider border border-gray-200 dark:border-white/5">
                                            SY {{ $enrollment->schoolYear->name }}
                                        </span>
                                        <span class="px-2 py-0.5 bg-gray-100 dark:bg-[#1b0d0d] text-gray-600 dark:text-gray-400 rounded text-[10px] font-bold uppercase tracking-wider border border-gray-200 dark:border-white/5">
                                            {{ $enrollment->status }}
                                        </span>
                                    </div>
                                    <h4 class="text-lg font-black text-[#1b0d0d] dark:text-white">
                                        {{ $enrollment->grade_level }}
                                        @if($enrollment->strand || $enrollment->specialization)
                                            <span class="text-gray-400 font-normal mx-1">•</span>
                                            <span class="text-sm font-bold text-gray-500">{{ $enrollment->strand ?: $enrollment->specialization }}</span>
                                        @endif
                                    </h4>
                                </div>
                                
                                @php
                                    $section = $enrollment->section ?? $enrollment->techVocSection;
                                @endphp
                                
                                <div class="flex-1 flex flex-wrap gap-4 lg:justify-end border-t lg:border-t-0 lg:border-l border-gray-100 dark:border-[#3d2424] pt-3 lg:pt-0 lg:pl-6">
                                    <div class="min-w-[100px]">
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Section</p>
                                        <p class="font-bold text-sm">{{ $section ? $section->name : 'N/A' }}</p>
                                    </div>
                                    <div class="min-w-[140px]">
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Adviser</p>
                                        <p class="font-bold text-sm truncate max-w-[180px]" title="{{ $section && $section->adviser ? $section->adviser->name : 'N/A' }}">{{ $section && $section->adviser ? $section->adviser->name : 'N/A' }}</p>
                                    </div>
                                    @if($enrollment->gwa)
                                        <div class="min-w-[60px]">
                                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">GWA</p>
                                            <p class="font-bold text-sm text-primary">{{ $enrollment->gwa }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        @if(!$currentEnrollment && $pastEnrollments->count() === 0)
            <div class="bg-white dark:bg-[#2d1818] rounded-3xl border border-[#e7cfcf] dark:border-[#3d2424] p-12 text-center shadow-sm">
                <span class="material-symbols-outlined text-6xl text-gray-300 dark:text-[#3d2424] mb-4">history_edu</span>
                <h3 class="text-xl font-bold text-[#1b0d0d] dark:text-white mb-2">No Records Found</h3>
                <p class="text-gray-500 dark:text-gray-400">You don't have any enrollment history records yet.</p>
            </div>
        @endif
    </div>
</x-layouts::student-portal>
