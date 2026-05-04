@section('page-title', 'Manage Students - ' . $section->name)

<main class="flex-1 px-10 py-8 max-w-[1400px] mx-auto w-full">
    <!-- Breadcrumbs & Back Link -->
    <div class="flex items-center gap-2 mb-6">
        <a href="{{ route('admin.sections') }}" class="flex items-center gap-1 text-[#9a4c4c] hover:text-primary transition-colors text-sm font-bold">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            Back to Sections
        </a>
    </div>

    <!-- Section Header Information -->
    <div class="bg-white dark:bg-[#2a1515] rounded-[32px] border border-[#f3e7e7] dark:border-[#3a1f1f] p-8 mb-8 shadow-sm relative overflow-hidden">
        <!-- Decorative Background Element -->
        <div class="absolute top-0 right-0 p-8 opacity-5">
            <span class="material-symbols-outlined text-[120px]">groups</span>
        </div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex flex-wrap items-center gap-6">
                <div class="size-20 rounded-2xl bg-primary/10 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-4xl text-primary">meeting_room</span>
                </div>
                <div>
                    <h1 class="text-4xl font-black text-[#1b0d0d] dark:text-white tracking-tight leading-none mb-2">{{ $section->name }}</h1>
                    <div class="flex flex-wrap items-center gap-4">
                        <span class="px-3 py-1 bg-primary text-white text-[10px] font-black uppercase rounded-lg tracking-widest">{{ $section->grade_level }}</span>
                        @if($section->strand)
                            <span class="px-3 py-1 bg-gray-100 dark:bg-white/5 text-gray-600 dark:text-gray-400 text-[10px] font-black uppercase rounded-lg tracking-widest">{{ $section->strand }}</span>
                        @endif
                        <div class="h-4 w-[1px] bg-gray-200 dark:bg-gray-700"></div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg text-primary">person</span>
                            <span class="text-sm font-bold text-gray-700 dark:text-gray-300">
                                Adviser: <span class="text-primary">{{ $section->adviser ? $section->adviser->name : 'No Adviser Assigned' }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Export Actions -->
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.sections.export.csv', $section->id) }}" class="flex items-center gap-2 h-11 px-5 rounded-xl bg-white dark:bg-[#361a1a] text-gray-700 dark:text-gray-300 font-bold text-sm shadow-sm hover:shadow-md transition-all border border-gray-200 dark:border-[#4d3232]">
                    <span class="material-symbols-outlined text-lg text-green-600">table_view</span>
                    Export CSV
                </a>
                <a href="{{ route('admin.sections.export.pdf', $section->id) }}" target="_blank" class="flex items-center gap-2 h-11 px-5 rounded-xl bg-primary text-white font-bold text-sm shadow-sm hover:shadow-md hover:bg-primary/90 transition-all">
                    <span class="material-symbols-outlined text-lg">picture_as_pdf</span>
                    Export PDF
                </a>
            </div>
        </div>
    </div>

    <!-- Student List Section -->
    <div class="space-y-6">
        <!-- Filters & Search -->
        <div class="flex flex-wrap items-center justify-between gap-4 bg-white dark:bg-[#2a1515] p-4 rounded-2xl border border-[#f3e7e7] dark:border-[#3a1f1f] shadow-sm">
            <div class="flex flex-1 gap-3 flex-wrap">
                <div class="flex-1 min-w-[200px] relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#9a4c4c] text-xl">search</span>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search students in this section..." class="w-full pl-10 pr-4 py-2.5 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm focus:ring-primary focus:border-primary transition-all">
                </div>
                <div class="w-40 relative shrink-0">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#9a4c4c] text-xl">wc</span>
                    <select wire:model.live="activeSex" class="w-full pl-10 pr-8 py-2.5 bg-[#fdfafb] dark:bg-[#3d2424] border-[#f3e7e7] dark:border-[#4d3232] rounded-xl text-sm font-bold text-[#1b0d0d] dark:text-white focus:ring-primary focus:border-primary transition-all appearance-none">
                        <option value="All">All Students</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-1.5" title="Male Students">
                    <span class="material-symbols-outlined text-blue-500 text-lg">male</span>
                    <span class="text-sm font-black text-[#1b0d0d] dark:text-white">{{ $totalMales }}</span>
                </div>
                <div class="flex items-center gap-1.5" title="Female Students">
                    <span class="material-symbols-outlined text-pink-500 text-lg">female</span>
                    <span class="text-sm font-black text-[#1b0d0d] dark:text-white">{{ $totalFemales }}</span>
                </div>
                <div class="h-4 w-[1px] bg-gray-200 dark:bg-gray-700 mx-1"></div>
                <div class="flex items-center gap-2">
                    <p class="text-[10px] font-black text-[#9a4c4c] uppercase tracking-widest">Total:</p>
                    <span class="px-3 py-1 bg-primary/5 text-primary text-xs font-black rounded border border-primary/10">
                        {{ $students->total() }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Students Table -->
        <div class="bg-white dark:bg-[#2a1515] rounded-3xl border border-[#f3e7e7] dark:border-[#3a1f1f] shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-[#fdfafb] dark:bg-[#361a1a] border-b border-[#f3e7e7] dark:border-[#3a1f1f]">
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Full Name / LRN</th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Sex</th>
                            @if(in_array($section->grade_level, ['Grade 8', 'Grade 9', 'Grade 10']) && $section->track !== 'TVL')
                                <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">TVL Course</th>
                            @endif
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Contact No</th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Status</th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c] text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f3e7e7] dark:divide-[#3a1f1f]">
                        @forelse($students as $student)
                            <tr class="hover:bg-primary/[0.02] dark:hover:bg-white/[0.02] transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="size-9 rounded-xl bg-gray-100 dark:bg-white/5 flex items-center justify-center font-black text-xs text-primary group-hover:bg-primary/10 transition-colors">
                                            {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-[#1b0d0d] dark:text-white leading-none">{{ $student->last_name }}, {{ $student->first_name }}</span>
                                            <span class="text-[10px] text-[#9a4c4c] dark:text-white/40 mt-1 uppercase font-black">{{ $student->lrn }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs font-black px-2 py-1 rounded-md {{ $student->sex === 'Male' ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400' : 'bg-pink-50 text-pink-600 dark:bg-pink-900/20 dark:text-pink-400' }}">{{ $student->sex }}</span>
                                </td>
                                @if(in_array($section->grade_level, ['Grade 8', 'Grade 9', 'Grade 10']) && $section->track !== 'TVL')
                                    <td class="px-6 py-4">
                                        @if($student->techVocSection)
                                            <span class="px-3 py-1 bg-[#1b0d0d] text-white text-[10px] font-black uppercase rounded-lg tracking-widest whitespace-nowrap">{{ $student->techVocSection->specialization }}</span>
                                        @elseif($student->specialization)
                                            <span class="text-[10px] font-bold text-gray-400 uppercase">{{ $student->specialization }} (Pending)</span>
                                        @elseif(!empty($student->tech_voc_choices))
                                            <span class="text-[10px] font-bold text-gray-400 uppercase">{{ $student->tech_voc_choices[0] }} (Choice 1)</span>
                                        @else
                                            <span class="text-[10px] font-bold text-gray-400 uppercase">None</span>
                                        @endif
                                    </td>
                                @endif
                                <td class="px-6 py-4">
                                    <span class="text-xs font-medium text-gray-600 dark:text-gray-400">+63 {{ $student->contact_no ?? 'N/A' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider
                                        {{ $student->status === 'Enrolled' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ $student->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.enrollment.review', $student->id) }}" class="p-2 hover:bg-primary/10 text-primary rounded-xl transition-all" title="View Full Profile">
                                            <span class="material-symbols-outlined text-lg">visibility</span>
                                        </a>
                                        <button class="p-2 hover:bg-primary/10 text-primary rounded-xl transition-all" title="Transfer Student">
                                            <span class="material-symbols-outlined text-lg">swap_horiz</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center opacity-30">
                                        <span class="material-symbols-outlined text-6xl mb-4">person_off</span>
                                        <p class="text-sm font-black uppercase tracking-widest italic">No students assigned to this section yet.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-[#f3e7e7] dark:border-[#3a1f1f]">
                {{ $students->links() }}
            </div>
        </div>
    </div>
</main>
