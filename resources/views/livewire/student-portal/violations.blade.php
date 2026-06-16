<!-- Page Heading -->
<div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h1 class="text-3xl font-black text-[#1b0d0d] dark:text-white tracking-tight">Violations Log</h1>
        <p class="text-[#9a4c4c] dark:text-[#c4a1a1]">View your recorded disciplinary incidents and status logs.</p>
    </div>
</div>

<!-- Info Notice -->
<div class="mb-6 p-4 bg-primary/5 border border-primary/20 rounded-2xl flex items-start gap-3 text-sm text-gray-600 dark:text-gray-400">
    <span class="material-symbols-outlined text-primary shrink-0">info</span>
    <div>
        <span class="font-bold text-gray-800 dark:text-white">Note on Disciplinary Actions:</span>
        All logged violations represent official school record entries. For questions regarding full reports or penalty details, please contact the **Office of Violation and Penalties for Discipline (OVPD)**.
    </div>
</div>

<!-- Violations Table -->
<div class="bg-white dark:bg-background-dark/30 rounded-2xl border border-[#e7cfcf] dark:border-[#3d2424] shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#f3e7e7] dark:bg-[#3d2424]/20 border-b border-[#e7cfcf] dark:border-[#3d2424]">
                    <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Date</th>
                    <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Violation Title</th>
                    <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Severity</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#f3e7e7] dark:divide-[#3d2424]/40">
                @forelse($violations as $v)
                <tr class="hover:bg-gray-50/50 dark:hover:bg-white/5 transition-colors">
                    <td class="px-6 py-4 text-xs font-bold text-gray-600 dark:text-gray-400 font-mono">
                        {{ $v->violation_date->format('F d, Y') }}
                    </td>
                    <td class="px-6 py-4 text-sm font-bold text-gray-900 dark:text-white">
                        {{ $v->title }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wide
                            {{ $v->severity == 'Low' ? 'bg-gray-100 text-gray-700 border border-gray-200' :
                                ($v->severity == 'Medium' ? 'bg-amber-100 text-amber-700 border border-amber-200' :
                                'bg-red-100 text-red-700 border border-red-200') }}">
                            {{ $v->severity }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <span class="material-symbols-outlined text-5xl mb-4 opacity-25">check_circle</span>
                            <p class="text-sm font-bold uppercase tracking-widest italic opacity-60">You have no recorded violations. Keep it up!</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
