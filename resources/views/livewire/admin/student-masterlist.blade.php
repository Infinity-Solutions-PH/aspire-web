@section('page-title', 'Student Masterlist')

<div x-data="{ showEditModal: @entangle('showEditModal'), showSectionModal: @entangle('showSectionModal') }">
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

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 5000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-[-10px]"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-[-10px]"
             class="mb-6 p-4 bg-green-50 dark:bg-green-950/30 border border-green-200 dark:border-green-800/30 rounded-2xl flex items-center justify-between text-green-800 dark:text-green-400 shadow-sm shadow-green-100/10">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-green-600 dark:text-green-400">check_circle</span>
                <span class="text-sm font-semibold">{{ session('message') }}</span>
            </div>
            <button @click="show = false" class="text-green-500 hover:text-green-700 dark:hover:text-green-300 transition-colors">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
    @endif

    <!-- Filters & Search -->
    <div class="bg-white dark:bg-[#1a0c0c] rounded-2xl border border-[#e7cfcf] dark:border-[#422020] p-5 mb-6 shadow-sm">
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-[300px] relative">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-[#9a4c4c]">search</span>
                <input wire:model.live.debounce.300ms="search" class="w-full pl-12 pr-4 py-3.5 bg-background-light dark:bg-[#2a1515] border-[#e7cfcf] dark:border-[#422020] rounded-xl focus:ring-primary focus:border-primary text-sm transition-all placeholder:text-gray-400" placeholder="Search by student name, LRN, or track..." type="text"/>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex items-center bg-background-light dark:bg-[#361a1a] rounded-xl px-4 py-1.5 border border-[#e7cfcf] dark:border-[#422020]">
                    <span class="text-[10px] font-bold text-[#9a4c4c] uppercase mr-3 tracking-wider">Category</span>
                    <select wire:model.live="category" class="bg-transparent border-none focus:ring-0 text-sm font-bold py-1 pl-0 pr-8 text-gray-700 dark:text-gray-200">
                        <option value="">All Categories</option>
                        <option value="HS">High School</option>
                        <option value="SHS">Senior High</option>
                    </select>
                </div>
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
                        <option value="Approved">Approved</option>
                        <option value="Enrolled">Enrolled</option>
                        <option value="Rejected">Rejected</option>
                        <option value="Dropped">Dropped</option>
                        <option value="Graduated">Graduated</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-[#f3e7e7] dark:border-[#361a1a]">
            <button wire:click="$set('status', 'Enrolled')" class="px-3 py-1 rounded-full text-xs font-medium transition-all {{ $status === 'Enrolled' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-[#f3e7e7] dark:bg-[#361a1a] text-[#1b0d0d] dark:text-[#fcf8f8] hover:bg-primary/20' }}">Enrolled</button>
            <button wire:click="$set('status', 'Approved')" class="px-3 py-1 rounded-full text-xs font-medium transition-all {{ $status === 'Approved' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-[#f3e7e7] dark:bg-[#361a1a] text-[#1b0d0d] dark:text-[#fcf8f8] hover:bg-primary/20' }}">Approved</button>
            <div class="w-px h-4 bg-gray-200 dark:bg-gray-700 mx-2 self-center"></div>
            <button wire:click="$set('category', 'HS')" class="px-3 py-1 rounded-full text-xs font-medium transition-all {{ $category === 'HS' ? 'bg-[#1b0d0d] text-white' : 'bg-[#f3e7e7] dark:bg-[#361a1a] text-[#1b0d0d] dark:text-[#fcf8f8] hover:bg-primary/20' }}">High School</button>
            <button wire:click="$set('category', 'SHS')" class="px-3 py-1 rounded-full text-xs font-medium transition-all {{ $category === 'SHS' ? 'bg-[#1b0d0d] text-white' : 'bg-[#f3e7e7] dark:bg-[#361a1a] text-[#1b0d0d] dark:text-[#fcf8f8] hover:bg-primary/20' }}">Senior High</button>
            <button wire:click="$set('category', '')" class="px-3 py-1 rounded-full text-xs font-medium transition-all {{ $category === '' ? 'text-primary' : 'text-gray-400 hover:text-primary' }}">Clear Category</button>
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
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Section</th>
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
                            @if($student->section)
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-xs font-bold text-gray-800 dark:text-gray-200">
                                        {{ $student->section->name }}
                                    </span>
                                    @if($student->techVocSection)
                                        <span class="text-[9px] text-primary font-black uppercase tracking-wider">
                                            TVL: {{ $student->techVocSection->name }}
                                        </span>
                                    @endif
                                </div>
                            @elseif($student->techVocSection)
                                <span class="text-xs font-bold text-primary">
                                    TVL: {{ $student->techVocSection->name }}
                                </span>
                            @else
                                <span class="text-xs text-gray-400 italic font-medium">Unassigned</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wide
                                {{ $student->status == 'Enrolled' ? 'bg-green-100 text-green-700' : 
                                   ($student->status == 'Approved' ? 'bg-blue-100 text-blue-700' : 
                                   ($student->status == 'Submitted' ? 'bg-amber-100 text-amber-700' :
                                   ($student->status == 'Rejected' ? 'bg-red-100 text-red-700' :
                                   ($student->status == 'Dropped' ? 'bg-primary/10 text-primary' : 'bg-gray-100 text-gray-700')))) }}">
                                {{ $student->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-1">
                                <a href="{{ route('admin.enrollment.review', $student->id) }}" class="p-2 text-[#9a4c4c] hover:bg-primary/10 hover:text-primary rounded-xl transition-all" title="View Profile">
                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                </a>
                                <button wire:click="editStudent({{ $student->id }})" class="p-2 text-[#9a4c4c] hover:bg-primary/10 hover:text-primary rounded-xl transition-all" title="Edit Student">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </button>
                                <button wire:click="openSectionModal({{ $student->id }})" class="p-2 text-[#9a4c4c] hover:bg-primary/10 hover:text-primary rounded-xl transition-all" title="Change Section">
                                    <span class="material-symbols-outlined text-lg">lan</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
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

    <!-- Edit Student Modal -->
    <div x-show="showEditModal" class="fixed inset-0 lg:left-64 z-40 overflow-y-auto" x-cloak>
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="absolute inset-0 transition-opacity bg-black/60 backdrop-blur-sm" @click="showEditModal = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block w-full max-w-2xl overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-[#1a0c0c] rounded-3xl shadow-2xl border border-[#e7cfcf] dark:border-[#422020]">
                <!-- Modal Header -->
                <div class="px-8 py-6 border-b border-[#e7cfcf] dark:border-[#422020] flex items-center justify-between bg-primary/5">
                    <div>
                        <h3 class="text-xl font-black text-primary uppercase tracking-tight">Edit Student Details</h3>
                        <p class="text-xs text-[#9a4c4c] dark:text-white/60">Update official record information for this student.</p>
                    </div>
                    <button @click="showEditModal = false" class="text-gray-400 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <form wire:submit.prevent="saveStudent" class="p-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- First Name -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">First Name</label>
                            <input wire:model="edit_first_name" type="text" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#2a1515] border-[#e7cfcf] dark:border-[#422020] rounded-xl text-sm focus:ring-primary focus:border-primary text-gray-800 dark:text-white">
                            @error('edit_first_name') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Last Name -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Last Name</label>
                            <input wire:model="edit_last_name" type="text" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#2a1515] border-[#e7cfcf] dark:border-[#422020] rounded-xl text-sm focus:ring-primary focus:border-primary text-gray-800 dark:text-white">
                            @error('edit_last_name') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Middle Name -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Middle Name</label>
                            <input wire:model="edit_middle_name" type="text" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#2a1515] border-[#e7cfcf] dark:border-[#422020] rounded-xl text-sm focus:ring-primary focus:border-primary text-gray-800 dark:text-white">
                            @error('edit_middle_name') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Extension Name -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Extension Name (e.g. Jr, III)</label>
                            <input wire:model="edit_extension_name" type="text" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#2a1515] border-[#e7cfcf] dark:border-[#422020] rounded-xl text-sm focus:ring-primary focus:border-primary text-gray-800 dark:text-white" placeholder="None">
                            @error('edit_extension_name') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- LRN -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">LRN</label>
                            <input wire:model="edit_lrn" type="text" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#2a1515] border-[#e7cfcf] dark:border-[#422020] rounded-xl text-sm focus:ring-primary focus:border-primary text-gray-800 dark:text-white">
                            @error('edit_lrn') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Birthdate -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Birthdate</label>
                            <input wire:model="edit_birthdate" type="date" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#2a1515] border-[#e7cfcf] dark:border-[#422020] rounded-xl text-sm focus:ring-primary focus:border-primary text-gray-800 dark:text-white">
                            @error('edit_birthdate') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Sex -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Sex</label>
                            <select wire:model="edit_sex" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#2a1515] border-[#e7cfcf] dark:border-[#422020] rounded-xl text-sm focus:ring-primary text-gray-800 dark:text-white">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            @error('edit_sex') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- GWA -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">GWA (Last Grade Level)</label>
                            <input wire:model="edit_gwa" type="number" step="0.01" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#2a1515] border-[#e7cfcf] dark:border-[#422020] rounded-xl text-sm focus:ring-primary focus:border-primary text-gray-800 dark:text-white">
                            @error('edit_gwa') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Contact Number -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Contact Number</label>
                            <input wire:model="edit_contact_no" type="text" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#2a1515] border-[#e7cfcf] dark:border-[#422020] rounded-xl text-sm focus:ring-primary focus:border-primary text-gray-800 dark:text-white">
                            @error('edit_contact_no') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Status -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Enrollment Status</label>
                            <select wire:model="edit_status" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#2a1515] border-[#e7cfcf] dark:border-[#422020] rounded-xl text-sm focus:ring-primary text-gray-800 dark:text-white">
                                <option value="Submitted">Submitted</option>
                                <option value="Approved">Approved</option>
                                <option value="Enrolled">Enrolled</option>
                                <option value="Rejected">Rejected</option>
                                <option value="Dropped">Dropped</option>
                                <option value="Graduated">Graduated</option>
                            </select>
                            @error('edit_status') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Grade Level -->
                        <div class="space-y-1 md:col-span-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Grade Level</label>
                            <select wire:model="edit_grade_level" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#2a1515] border-[#e7cfcf] dark:border-[#422020] rounded-xl text-sm focus:ring-primary text-gray-800 dark:text-white">
                                <option value="Grade 7">Grade 7</option>
                                <option value="Grade 8">Grade 8</option>
                                <option value="Grade 9">Grade 9</option>
                                <option value="Grade 10">Grade 10</option>
                                <option value="Grade 11">Grade 11</option>
                                <option value="Grade 12">Grade 12</option>
                            </select>
                            <p class="text-[10px] text-amber-600 dark:text-amber-400 font-medium italic mt-1">Note: Changing the grade level will clear the student's current section assignments to prevent mismatches.</p>
                            @error('edit_grade_level') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="pt-6 border-t border-[#e7cfcf] dark:border-[#422020] flex justify-end gap-3">
                        <button type="button" @click="showEditModal = false" class="px-6 py-3 rounded-xl text-sm font-bold text-[#9a4c4c] hover:bg-gray-100 dark:hover:bg-white/5 transition-colors">Cancel</button>
                        <button type="submit" class="px-8 py-3 bg-primary text-white rounded-xl text-sm font-black shadow-lg shadow-primary/20 hover:scale-[1.02] transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">save</span>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Section Modal -->
    <div x-show="showSectionModal" class="fixed inset-0 lg:left-64 z-40 overflow-y-auto" x-cloak>
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="absolute inset-0 transition-opacity bg-black/60 backdrop-blur-sm" @click="showSectionModal = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block w-full max-w-lg overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-[#1a0c0c] rounded-3xl shadow-2xl border border-[#e7cfcf] dark:border-[#422020]">
                <!-- Modal Header -->
                <div class="px-8 py-6 border-b border-[#e7cfcf] dark:border-[#422020] flex items-center justify-between bg-primary/5">
                    <div>
                        <h3 class="text-xl font-black text-primary uppercase tracking-tight">Assign Section</h3>
                        <p class="text-xs text-[#9a4c4c] dark:text-white/60">
                            @if($selectedStudentForSection)
                                Assign sections for <span class="font-bold text-gray-900 dark:text-white">{{ $selectedStudentForSection->first_name }} {{ $selectedStudentForSection->last_name }}</span> ({{ $selectedStudentForSection->grade_level }})
                            @else
                                Assign student sections
                            @endif
                        </p>
                    </div>
                    <button @click="showSectionModal = false" class="text-gray-400 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <form wire:submit.prevent="saveSection" class="p-8 space-y-6">
                    <div class="space-y-4">
                        <!-- Academic Section -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Academic Section</label>
                            <select wire:model="selected_section_id" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#2a1515] border-[#e7cfcf] dark:border-[#422020] rounded-xl text-sm focus:ring-primary text-gray-800 dark:text-white">
                                <option value="">-- Unassigned --</option>
                                @foreach($availableSections as $sec)
                                    <option value="{{ $sec->id }}">
                                        {{ $sec->name }} ({{ $sec->enrollments_count }}/{{ $sec->capacity }})
                                    </option>
                                @endforeach
                            </select>
                            @error('selected_section_id') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Tech Voc Specialization Section (Grade 8, 9, 10 only) -->
                        @if($selectedStudentForSection && in_array($selectedStudentForSection->grade_level, ['Grade 8', 'Grade 9', 'Grade 10']))
                            <div class="space-y-1">
                                <label class="text-[10px] font-black uppercase tracking-widest text-[#9a4c4c]">Tech Voc Specialization Section</label>
                                <select wire:model="selected_tech_voc_section_id" class="w-full px-4 py-3 bg-[#fdfafb] dark:bg-[#2a1515] border-[#e7cfcf] dark:border-[#422020] rounded-xl text-sm focus:ring-primary text-gray-800 dark:text-white">
                                    <option value="">-- Unassigned --</option>
                                    @foreach($availableTechVocSections as $sec)
                                        <option value="{{ $sec->id }}">
                                            {{ $sec->name }} - {{ $sec->specialization }} ({{ $sec->tech_voc_enrollments_count }}/{{ $sec->capacity }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('selected_tech_voc_section_id') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                            </div>
                        @endif
                    </div>

                    <!-- Modal Footer -->
                    <div class="pt-6 border-t border-[#e7cfcf] dark:border-[#422020] flex justify-end gap-3">
                        <button type="button" @click="showSectionModal = false" class="px-6 py-3 rounded-xl text-sm font-bold text-[#9a4c4c] hover:bg-gray-100 dark:hover:bg-white/5 transition-colors">Cancel</button>
                        <button type="submit" class="px-8 py-3 bg-primary text-white rounded-xl text-sm font-black shadow-lg shadow-primary/20 hover:scale-[1.02] transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">save</span>
                            Assign Section
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
