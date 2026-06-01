<div>
    <!-- Page Heading -->
    <div class="flex flex-col gap-1 mb-8">
        <h1 class="text-3xl font-black text-primary tracking-tight">Handled Sections</h1>
        <p class="text-sm text-[#9a4c4c] dark:text-white/60">View all sections where you are currently designated as an Adviser or a Subject Teacher.</p>
    </div>

    <!-- Table of Sections -->
    <div class="bg-white dark:bg-[#2a1515] rounded-2xl border border-[#f3e7e7] dark:border-[#3a1f1f] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-[#fdfafb] dark:bg-[#361a1a] border-b border-[#f3e7e7] dark:border-[#3a1f1f]">
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Grade & Section</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Track / Strand</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Room</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Role</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Students</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c] text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f3e7e7] dark:divide-[#3a1f1f]">
                    @forelse($sections as $section)
                        <tr class="hover:bg-primary/[0.01] dark:hover:bg-white/[0.01] transition-colors group">
                            <!-- Grade & Section Name -->
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-[#1b0d0d] dark:text-white">{{ $section->grade_level }} - {{ $section->name }}</span>
                                    <span class="text-[10px] text-gray-500">Adviser: {{ $section->adviser_name }}</span>
                                </div>
                            </td>
                            <!-- Track & Strand -->
                            <td class="px-6 py-4">
                                @if($section->track)
                                    <div class="flex flex-col">
                                        <span class="text-xs font-semibold text-[#1b0d0d] dark:text-white">{{ $section->track }}</span>
                                        @if($section->strand)
                                            <span class="text-[9px] text-[#9a4c4c] dark:text-white/40 font-bold uppercase">{{ $section->strand }}</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 italic">N/A</span>
                                @endif
                            </td>
                            <!-- Room -->
                            <td class="px-6 py-4">
                                <span class="text-xs font-semibold text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-white/5 px-2.5 py-1 rounded">
                                    {{ $section->room ?: 'N/A' }}
                                </span>
                            </td>
                            <!-- Role -->
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wide
                                    {{ $section->role === 'Adviser' ? 'bg-green-100 text-green-700 dark:bg-green-950/30 dark:text-green-400' : 'bg-blue-100 text-blue-700 dark:bg-blue-950/30 dark:text-blue-400' }}">
                                    {{ $section->role }}
                                </span>
                            </td>
                            <!-- Student Count -->
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-[#1b0d0d] dark:text-white">{{ $section->student_count }} Students</span>
                            </td>
                            <!-- Actions -->
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('faculty.sections.students', $section->id) }}" 
                                   class="inline-flex items-center gap-1 px-4 py-2 bg-primary/10 hover:bg-primary text-primary hover:text-white rounded-xl text-xs font-bold transition-all hover:scale-[1.02] shadow-sm">
                                    <span class="material-symbols-outlined text-sm">groups</span>
                                    View Students
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic">No sections found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
