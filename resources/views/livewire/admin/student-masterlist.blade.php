@section('page-title', 'Student Masterlist')

<div>
    <!-- Page Heading -->
    <div class="flex flex-wrap justify-between items-end gap-4 mb-8">
        <div class="flex flex-col gap-1">
            <h2 class="text-3xl font-black tracking-tight text-[#1b0d0d] dark:text-[#fcf8f8]">Student Masterlist</h2>
            <p class="text-[#9a4c4c] dark:text-[#c48d8d] text-base font-medium">Manage and view all enrolled students for S.Y. 2023-2024.</p>
        </div>
        <button class="flex items-center gap-2 px-6 py-2.5 bg-primary hover:bg-primary/90 text-white rounded-lg font-bold text-sm transition-all shadow-lg shadow-primary/20">
            <span class="material-symbols-outlined text-lg">person_add</span>
            <span>Add Student</span>
        </button>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white dark:bg-[#1a0c0c] rounded-2xl border border-[#e7cfcf] dark:border-[#422020] p-5 mb-6 shadow-sm">
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-[300px] relative">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-[#9a4c4c]">search</span>
                <input wire:model.live.debounce.300ms="search" class="w-full pl-12 pr-4 py-3.5 bg-background-light dark:bg-[#2a1515] border-[#e7cfcf] dark:border-[#422020] rounded-xl focus:ring-primary focus:border-primary text-sm transition-all placeholder:text-gray-400" placeholder="Search by student name, LRN, or track..." type="text"/>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex items-center bg-background-light dark:bg-[#361a1a] rounded-xl px-4 py-1.5 border border-[#e7cfcf] dark:border-[#422020]">
                    <span class="text-[10px] font-bold text-[#9a4c4c] uppercase mr-3 tracking-wider">Grade Level</span>
                    <select wire:model.live="grade_level" class="bg-transparent border-none focus:ring-0 text-sm font-bold py-1 pl-0 pr-8 text-gray-700 dark:text-gray-200">
                        <option value="All Levels">All Levels</option>
                        <option value="Grade 7">Grade 7</option>
                        <option value="Grade 8">Grade 8</option>
                        <option value="Grade 9">Grade 9</option>
                        <option value="Grade 10">Grade 10</option>
                        <option value="Grade 11">Grade 11</option>
                        <option value="Grade 12">Grade 12</option>
                    </select>
                </div>
                <div class="flex items-center bg-background-light dark:bg-[#361a1a] rounded-xl px-4 py-1.5 border border-[#e7cfcf] dark:border-[#422020]">
                    <span class="text-[10px] font-bold text-[#9a4c4c] uppercase mr-3 tracking-wider">Status</span>
                    <select wire:model.live="status" class="bg-transparent border-none focus:ring-0 text-sm font-bold py-1 pl-0 pr-8 text-gray-700 dark:text-gray-200">
                        <option value="All Status">All Status</option>
                        <option value="Enrolled">Enrolled</option>
                        <option value="Dropped">Dropped</option>
                        <option value="Graduated">Graduated</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white dark:bg-[#1a0c0c] rounded-2xl border border-[#e7cfcf] dark:border-[#422020] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-background-light dark:bg-[#2a1515] border-b border-[#e7cfcf] dark:border-[#422020]">
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">LRN / ID</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Full Name</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Course / Track</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Grade Level</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Status</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c] text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f3e7e7] dark:divide-[#361a1a]">
                    @forelse($students as $student)
                    <tr class="hover:bg-background-light/50 dark:hover:bg-[#2a1515]/30 transition-colors group">
                        <td class="px-6 py-4 text-sm font-bold text-primary font-mono tracking-tight">{{ $student->lrn }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="size-9 rounded-xl bg-primary/10 flex items-center justify-center font-black text-xs text-primary border border-primary/20">
                                    {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-900 dark:text-white leading-none">{{ $student->last_name }}, {{ $student->first_name }}</span>
                                    <span class="text-[10px] text-gray-400 mt-1 uppercase font-bold tracking-tighter">Verified Account</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-600 dark:text-gray-400">
                            @if($student->shs_track)
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-gray-800 dark:text-gray-200">{{ $student->shs_track }}</span>
                                    <span class="text-[10px] text-gray-400 italic">{{ $student->strand }}</span>
                                </div>
                            @elseif($student->specialization)
                                <span class="text-xs font-bold text-gray-800 dark:text-gray-200">{{ $student->specialization }}</span>
                            @else
                                <span class="text-gray-300 italic">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-black text-gray-700 dark:text-gray-300 px-3 py-1 bg-background-light dark:bg-white/5 rounded-lg border border-gray-100 dark:border-white/5">
                                {{ $student->grade_level }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wide
                                {{ $student->status == 'Enrolled' ? 'bg-green-100 text-green-700' : 
                                   ($student->status == 'Dropped' ? 'bg-primary/10 text-primary' : 'bg-blue-100 text-blue-700') }}">
                                {{ $student->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-1">
                                <a href="{{ route('admin.enrollment.review', $student->id) }}" class="p-2 text-[#9a4c4c] hover:bg-primary/10 hover:text-primary rounded-xl transition-all" title="View Profile">
                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                </a>
                                <button class="p-2 text-[#9a4c4c] hover:bg-primary/10 hover:text-primary rounded-xl transition-all" title="Edit Student">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <span class="material-symbols-outlined text-5xl mb-4 opacity-20">group_off</span>
                                <p class="text-sm font-bold uppercase tracking-widest italic opacity-50">No students found matching the criteria</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 bg-background-light/30 dark:bg-white/5 border-t border-[#f3e7e7] dark:border-white/10">
            {{ $students->links() }}
        </div>
    </div>
</div>
