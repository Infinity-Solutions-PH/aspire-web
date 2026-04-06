<div class="flex flex-col gap-6 p-8 bg-white dark:bg-zinc-900 min-h-screen">
    <div class="flex justify-between items-center border-b border-gray-100 pb-6">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Enrollment Review Dashboard</h2>
            <p class="text-gray-500 text-sm mt-1 tracking-tight italic font-mono">TNTS ASPIRE Administrator Portal</p>
        </div>
        <div class="flex gap-3">
            <div class="relative group">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">search</span>
                <input wire:model.live="search" class="h-10 pl-10 pr-4 rounded-xl border-gray-200 bg-gray-50/50 text-sm w-64 focus:ring-primary focus:border-primary transition-all" placeholder="Search LRN, name..." type="text"/>
            </div>
            <select wire:model.live="status" class="h-10 rounded-xl border-gray-200 bg-gray-50/50 text-sm focus:ring-primary">
                <option value="">All Status</option>
                <option value="Submitted">Pending Review</option>
                <option value="Approved">Approved</option>
                <option value="Enrolled">Officially Enrolled</option>
                <option value="Rejected">Rejected</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Stats summary can go here -->
    </div>

    <div class="overflow-hidden bg-white dark:bg-zinc-800 rounded-2xl border border-gray-100 dark:border-white/5 shadow-sm">
        <table class="w-full text-left">
            <thead class="bg-primary/5 border-b border-primary/10">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-primary uppercase tracking-wider">Student Name & LRN</th>
                    <th class="px-6 py-4 text-xs font-bold text-primary uppercase tracking-wider">Cohort Type</th>
                    <th class="px-6 py-4 text-xs font-bold text-primary uppercase tracking-wider">Grade Level</th>
                    <th class="px-6 py-4 text-xs font-bold text-primary uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-primary uppercase tracking-wider text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                @forelse($enrollments as $enrollment)
                <tr class="hover:bg-gray-50/80 dark:hover:bg-white/5 transition-colors group">
                    <td class="px-6 py-5">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $enrollment->last_name }}, {{ $enrollment->first_name }}</span>
                            <span class="text-xs text-gray-400 font-mono">{{ $enrollment->lrn }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <span class="inline-flex px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase {{ 
                            $enrollment->type == 'Promoted' ? 'bg-blue-100 text-blue-600' : 
                            ($enrollment->type == 'Transferee' ? 'bg-orange-100 text-orange-600' : 'bg-green-100 text-green-600')
                        }}">
                            {{ $enrollment->type }}
                        </span>
                    </td>
                    <td class="px-6 py-5">
                        <span class="text-sm font-medium text-gray-700">{{ $enrollment->grade_level }}</span>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-2">
                            <span class="size-1.5 rounded-full {{ 
                                $enrollment->status == 'Submitted' ? 'bg-amber-400' : 
                                ($enrollment->status == 'Enrolled' ? 'bg-green-500' : 'bg-gray-300') 
                            }}"></span>
                            <span class="text-xs font-bold uppercase tracking-tight">{{ $enrollment->status }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-right">
                        <a href="{{ route('admin.enrollment.review', $enrollment->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary/5 hover:bg-primary text-primary hover:text-white text-xs font-bold rounded-lg transition-all">
                            Review Details
                            <span class="material-symbols-outlined text-sm">visibility</span>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-24 text-center">
                        <div class="flex flex-col items-center justify-center opacity-40">
                            <span class="material-symbols-outlined text-5xl mb-4">folder_managed</span>
                            <p class="text-sm font-medium">No pending applications found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $enrollments->links() }}
    </div>
</div>
