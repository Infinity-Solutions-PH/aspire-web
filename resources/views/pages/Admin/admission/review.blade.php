<div class="max-w-5xl mx-auto py-10 px-6 bg-white dark:bg-zinc-900 min-h-screen border-x border-gray-100 dark:border-white/5 shadow-2xl">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12 pb-8 border-b border-gray-100 dark:border-white/10">
        <div>
            <div class="flex items-center gap-2 mb-2">
                @if($isPre)
                    <a href="{{ route('admin.admissions') }}" class="text-xs font-bold text-primary hover:underline uppercase tracking-widest flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">arrow_back</span>
                        Back to Admissions
                    </a>
                @else
                    <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold text-primary hover:underline uppercase tracking-widest flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">arrow_back</span>
                        Back to Enrollments
                    </a>
                @endif
            </div>
            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">Review Application</h1>
            <p class="text-gray-500 mt-2 font-medium flex items-center gap-2">
                Application ID: <span class="bg-gray-100 px-2 py-0.5 rounded font-mono text-gray-700">#{{ $enrollment->id }}</span>
                <span class="text-gray-300">|</span>
                Type: <span class="text-primary font-bold">{{ $enrollment->type }}</span>
            </p>
        </div>
        
        <div class="flex gap-3">
            @if($enrollment->status === 'Submitted' || $enrollment->status === 'pending_approval')
                <button wire:click="approve" class="bg-primary text-white px-8 py-3 rounded-xl font-bold hover:shadow-xl hover:shadow-primary/20 transition-all flex items-center gap-2">
                    Approve Application
                    <span class="material-symbols-outlined">verified</span>
                </button>
            @elseif($enrollment->status === 'Approved')
                <button wire:click="enroll" class="bg-green-600 text-white px-8 py-3 rounded-xl font-bold hover:shadow-xl hover:shadow-green-600/20 transition-all flex items-center gap-2">
                    Finalize Enrollment
                    <span class="material-symbols-outlined">stadium</span>
                </button>
            @endif
            <!-- <button wire:click="reject" class="bg-white border border-gray-200 text-red-600 px-6 py-3 rounded-xl font-bold hover:bg-red-50 transition-all">Reject</button> -->
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl mb-8 flex items-center gap-3">
            <span class="material-symbols-outlined">check_circle</span>
            <span class="font-bold">{{ session('message') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left Column: Student Details -->
        <div class="lg:col-span-7 space-y-10">
            <!-- Personal Information -->
            <section class="space-y-6">
                <div class="flex items-center gap-3 border-b border-gray-100 pb-3">
                    <span class="material-symbols-outlined text-primary">person</span>
                    <h3 class="text-lg font-bold text-gray-900 uppercase tracking-wider">Learner Information</h3>
                </div>
                <div class="grid grid-cols-2 gap-x-12 gap-y-6">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Full Name</p>
                        <p class="text-sm font-bold text-gray-900">{{ $enrollment->last_name }}, {{ $enrollment->first_name }} {{ $enrollment->middle_name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">LRN</p>
                        <p class="text-sm font-mono font-bold text-primary">{{ $enrollment->lrn }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Birthdate</p>
                        <p class="text-sm font-medium">{{ $enrollment->birthdate->format('M d, Y') }} ({{ $enrollment->birthdate->age }} yrs)</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Sex</p>
                        <p class="text-sm font-medium">{{ $enrollment->sex }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">GWA</p>
                        <div class="flex items-center gap-2">
                            <p class="text-sm font-bold text-primary">{{ $enrollment->gwa ?: 'N/A' }}</p>
                            @if($isStarQualified)
                                <span class="bg-yellow-100 text-yellow-700 text-[10px] font-black px-2 py-0.5 rounded flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[12px]">star</span>
                                    STAR QUALIFIED
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            <!-- Parent Information -->
            <section class="space-y-6">
                <div class="flex items-center gap-3 border-b border-gray-100 pb-3">
                    <span class="material-symbols-outlined text-primary">family_history</span>
                    <h3 class="text-lg font-bold text-gray-900 uppercase tracking-wider">Parent/Guardian</h3>
                </div>
                <div class="grid grid-cols-2 gap-x-12 gap-y-6">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Father</p>
                        <p class="text-sm font-bold text-gray-800">{{ $enrollment->father_name ?: 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Mother (Maiden)</p>
                        <p class="text-sm font-bold text-gray-800">{{ $enrollment->mother_maiden_name ?: 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Contact Number</p>
                        <p class="text-sm font-bold text-gray-800">+63 {{ $enrollment->contact_no }}</p>
                    </div>
                </div>
            </section>

            <!-- Academic Specializations -->
            @if($enrollment->grade_level === 'Grade 8')
            <section class="p-6 bg-primary/5 rounded-2xl p-6 border border-primary/10 space-y-4">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">verified_user</span>
                    <h3 class="text-lg font-bold text-gray-900">Track Selection Review</h3>
                </div>
                <div class="space-y-4">
                    <div class="flex flex-col gap-1">
                        <p class="text-[10px] font-bold text-primary uppercase">Student Choices (Ranked)</p>
                        <div class="flex flex-col gap-2">
                            @foreach($enrollment->tech_voc_choices ?: [] as $index => $choice)
                                <div class="flex items-center gap-3 bg-white p-3 rounded-xl border border-primary/5">
                                    <span class="size-6 bg-primary/10 rounded flex items-center justify-center text-[10px] font-bold text-primary">{{ $index + 1 }}</span>
                                    <span class="text-xs font-bold text-gray-700">{{ $choice }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-primary/10">
                        <p class="text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">Final Assigned Specialization</p>
                        <select wire:model.defer="selected_specialization" class="form-select w-full rounded-xl border-primary/20 bg-white text-sm focus:ring-primary focus:border-primary">
                            <option value="">Select Priority...</option>
                            @foreach($enrollment->tech_voc_choices ?: [] as $choice)
                                <option value="{{ $choice }}">{{ $choice }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </section>
            @endif

            @if(str_contains($enrollment->grade_level, 'Grade 11'))
            <section class="p-6 bg-primary/5 rounded-2xl p-6 border border-primary/10 space-y-4">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">lan</span>
                    <h3 class="text-lg font-bold text-gray-900">SHS Strand Alignment</h3>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white p-4 rounded-xl border border-primary/5">
                        <p class="text-[10px] text-gray-400 font-bold uppercase">Chosen Strand</p>
                        <p class="text-sm font-bold text-gray-900">{{ $enrollment->shs_track }} - {{ $enrollment->strand }}</p>
                    </div>
                    <div class="bg-white p-4 @if($enrollment->is_shs_aligned) bg-green-50 @endif rounded-xl border border-primary/5 flex items-center justify-between">
                        <div class="flex flex-col">
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Aligned?</p>
                            <p class="text-sm font-bold @if($enrollment->is_shs_aligned) text-green-600 @else text-red-600 @endif">
                                {{ $enrollment->is_shs_aligned ? 'YES' : 'NO' }}
                            </p>
                        </div>
                        <span class="material-symbols-outlined @if($enrollment->is_shs_aligned) text-green-600 @else text-red-300 @endif text-3xl">
                            {{ $enrollment->is_shs_aligned ? 'check_circle' : 'warning' }}
                        </span>
                    </div>
                </div>
            </section>
            @endif

            @if($enrollment->status === 'Approved')
            <section class="p-6 bg-green-50 rounded-2xl border border-green-100 space-y-4">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-green-600">stadium</span>
                    <h3 class="text-lg font-bold text-gray-900 uppercase tracking-tight">Final Section Assignment</h3>
                </div>
                
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-[10px] font-bold text-green-700 uppercase tracking-widest mb-1">Normal Section (Academic)</p>
                            <select wire:model.defer="selected_section_id" class="form-select w-full rounded-xl border-green-200 bg-white text-sm font-bold text-gray-700 focus:ring-green-500 focus:border-green-500">
                                <option value="">-- Let System Auto-Assign --</option>
                                @foreach($availableSections as $section)
                                    <option value="{{ $section->id }}">
                                        {{ $section->name }} ({{ $section->enrollments_count }}/{{ $section->capacity }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @if(in_array($enrollment->grade_level, ['Grade 8', 'Grade 9', 'Grade 10']))
                        <div>
                            <p class="text-[10px] font-bold text-green-700 uppercase tracking-widest mb-1">Tech Voc Specialization Section</p>
                            <select wire:model.defer="selected_tech_voc_section_id" class="form-select w-full rounded-xl border-green-200 bg-white text-sm font-bold text-gray-700 focus:ring-green-500 focus:border-green-500">
                                <option value="">-- Select Tech Voc Section --</option>
                                @foreach($availableTechVocSections as $section)
                                    <option value="{{ $section->id }}">
                                        {{ $section->name }} - {{ $section->specialization }} ({{ $section->tech_voc_enrollments_count }}/{{ $section->capacity }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                    </div>
                    <p class="text-[10px] text-gray-400 italic">Manual assignment is optional. Unassigned slots will be filled by the auto-sectioning engine.</p>
            </section>
            @endif

            <section class="space-y-4 pt-6 border-t border-gray-100">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Registrar Remarks</p>
                <textarea wire:model.defer="admin_remarks" class="w-full rounded-2xl border-gray-100 bg-gray-50/50 p-4 text-sm focus:ring-primary focus:border-primary placeholder:text-gray-300 min-h-[120px]" placeholder="Add notes about document deficiencies or track approval rationale..."></textarea>
            </section>
        </div>

        <!-- Right Column: Document Viewer -->
        <div class="lg:col-span-5 space-y-6">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <h3 class="text-lg font-bold text-gray-900 uppercase tracking-wider">Submitted Credentials</h3>
                <!-- <span class="text-[10px] font-bold text-primary bg-primary/10 px-2 py-0.5 rounded italic">Digital Dossier</span> -->
            </div>
            
            <div class="space-y-4">
                @if($enrollment->profile_picture)
                <div class="group relative bg-gray-50 dark:bg-zinc-800 rounded-2xl p-4 border border-gray-100 dark:border-white/5 hover:border-primary/30 transition-all text-center">
                    <div class="flex items-center justify-between mb-4 text-left">
                        <span class="text-xs font-bold text-gray-700 dark:text-gray-300">2x2 Student Photo</span>
                        <a href="{{ Storage::url($enrollment->profile_picture) }}" target="_blank" class="size-8 bg-white rounded-lg flex items-center justify-center text-primary shadow-sm hover:bg-primary hover:text-white transition-all">
                            <span class="material-symbols-outlined text-lg">open_in_new</span>
                        </a>
                    </div>
                    <div class="aspect-square max-w-[240px] mx-auto rounded-xl overflow-hidden bg-white border border-gray-100 relative shadow-inner">
                        <img src="{{ Storage::url($enrollment->profile_picture) }}" class="w-full h-full object-cover">
                    </div>
                    <p class="mt-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Digital Identification Photo</p>
                </div>
                @else
                <div class="py-12 text-center border-2 border-dashed border-gray-100 rounded-2xl">
                    <span class="material-symbols-outlined text-gray-200 text-5xl">no_photography</span>
                    <p class="text-xs font-bold text-gray-400 mt-2">No photo submitted</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
