@section('page-title', 'Admission Applications')

<div class="flex flex-col gap-1">
    <!-- Page Heading -->
    <div class="flex flex-wrap justify-between items-end gap-4 mb-8">
        <div class="flex flex-col gap-1">
            <h2 class="text-3xl font-black tracking-tight text-[#1b0d0d] dark:text-[#fcf8f8]">Admission Dashboard</h2>
            <p class="text-[#9a4c4c] dark:text-[#c48d8d] text-base">Review and manage student admission applications.</p>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white dark:bg-[#1a0c0c] rounded-xl border border-[#e7cfcf] dark:border-[#422020] p-4 mb-6 shadow-sm">
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-[300px] relative">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-[#9a4c4c]">search</span>
                <input wire:model.live="search" class="w-full pl-12 pr-4 py-3 bg-background-light dark:bg-[#2a1515] border-[#e7cfcf] dark:border-[#422020] rounded-lg focus:ring-primary focus:border-primary text-sm transition-all" placeholder="Search by LRN, name, or track..." type="text"/>
            </div>
            <div class="flex items-center gap-3">
                @if($status !== 'Draft')
                <div class="flex items-center bg-[#f3e7e7] dark:bg-[#361a1a] rounded-lg px-3 py-1">
                    <span class="text-xs font-bold text-[#9a4c4c] uppercase mr-2">Category:</span>
                    <select wire:model.live="category" class="bg-transparent border-none focus:ring-0 text-sm font-medium py-1 pl-0 pr-8">
                        <option value="">All Categories</option>
                        <option value="HS">High School</option>
                        <option value="SHS">Senior High</option>
                    </select>
                </div>
                @endif
                <div class="flex items-center bg-[#f3e7e7] dark:bg-[#361a1a] rounded-lg px-3 py-1">
                    <span class="text-xs font-bold text-[#9a4c4c] uppercase mr-2">Status:</span>
                    <select wire:model.live="status" class="bg-transparent border-none focus:ring-0 text-sm font-medium py-1 pl-0 pr-8">
                        <option value="pending_approval">Pending Review</option>
                        <option value="Draft">Drafts</option>
                    </select>
                </div>
                @if($status !== 'Draft')
                <!-- <div class="flex items-center bg-[#f3e7e7] dark:bg-[#361a1a] rounded-lg px-3 py-1">
                    <span class="text-xs font-bold text-[#9a4c4c] uppercase mr-2">Type:</span>
                    <select wire:model.live="type" class="bg-transparent border-none focus:ring-0 text-sm font-medium py-1 pl-0 pr-8">
                        <option value="">All Types</option>
                        <option value="New Student">New Student</option>
                        <option value="Old Student">Old Student</option>
                        <option value="Transferee">Transferee</option>
                    </select>
                </div> -->
                @endif
            </div>
        </div>
        <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-[#f3e7e7] dark:border-[#361a1a]">
            <button wire:click="$set('status', 'pending_approval')" class="px-3 py-1 rounded-full text-xs font-medium transition-all {{ ($status === 'pending_approval' || $status === '') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-[#f3e7e7] dark:bg-[#361a1a] text-[#1b0d0d] dark:text-[#fcf8f8] hover:bg-primary/20' }}">Pending Review</button>
            <button wire:click="$set('status', 'Draft')" class="px-3 py-1 rounded-full text-xs font-medium transition-all {{ $status === 'Draft' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-[#f3e7e7] dark:bg-[#361a1a] text-[#1b0d0d] dark:text-[#fcf8f8] hover:bg-primary/20' }}">Drafts</button>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white dark:bg-[#1a0c0c] rounded-xl border border-[#e7cfcf] dark:border-[#422020] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-background-light dark:bg-[#2a1515] border-b border-[#e7cfcf] dark:border-[#422020]">
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-wider text-[#9a4c4c]">LRN</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-wider text-[#9a4c4c]">Student Name</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-wider text-[#9a4c4c]">Enrollment Type</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-wider text-[#9a4c4c]">Grade Level</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-wider text-[#9a4c4c]">Status</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-wider text-[#9a4c4c] text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f3e7e7] dark:divide-[#361a1a]">
                    @forelse($enrollments as $enrollment)
                        @php
                            $isPre = $enrollment instanceof \App\Models\PreEnrollment;
                            $data = $isPre ? $enrollment->form_data : $enrollment;
                            $firstName = $isPre ? ($data['first_name'] ?? 'N/A') : $enrollment->first_name;
                            $lastName = $isPre ? ($data['last_name'] ?? 'N/A') : $enrollment->last_name;
                            $type = $isPre ? ($data['enrollment_type'] ?? 'N/A') : $enrollment->type;
                            $gradeLevel = $isPre ? ($data['grade_level'] ?? 'N/A') : $enrollment->grade_level;
                            $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
                        @endphp
                        <tr class="hover:bg-background-light/50 dark:hover:bg-[#2a1515]/30 transition-colors group">
                            <td class="px-6 py-4 text-sm font-bold text-primary">{{ $enrollment->lrn }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="size-8 rounded-full bg-[#f3e7e7] dark:bg-[#361a1a] flex items-center justify-center font-bold text-xs text-primary group-hover:scale-110 transition-transform">{{ $initials }}</div>
                                    <span class="text-sm font-medium">{{ $lastName }}, {{ $firstName }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">{{ $type }}</td>
                            <td class="px-6 py-4 text-sm">{{ $gradeLevel }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ 
                                    $enrollment->status == 'pending_approval' ? 'bg-amber-100 text-amber-700' : 
                                    ($enrollment->status == 'Enrolled' ? 'bg-green-100 text-green-700' : 
                                    ($enrollment->status == 'Rejected' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700')) 
                                }}">
                                    {{ $enrollment->status == 'pending_approval' ? 'Pending Review' : $enrollment->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    @php
                                        $route = $isPre ? route('admin.pre_enrollment.review', ['preEnrollment' => $enrollment->id]) : route('admin.enrollment.review', ['enrollment' => $enrollment->id]);
                                    @endphp
                                    <a href="{{ $route }}" class="p-1.5 text-[#9a4c4c] hover:bg-[#f3e7e7] dark:hover:bg-[#361a1a] rounded transition-colors group/btn" title="Review Details">
                                        <span class="material-symbols-outlined text-lg group-hover/btn:scale-110 transition-transform">visibility</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-24 text-center">
                                <div class="flex flex-col items-center justify-center opacity-40">
                                    <span class="material-symbols-outlined text-5xl mb-4">folder_open</span>
                                    <p class="text-sm font-medium text-[#9a4c4c]">No admission applications found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-[#f3e7e7] dark:border-[#361a1a]">
            {{ $enrollments->links() }}
        </div>
    </div>
</div>
