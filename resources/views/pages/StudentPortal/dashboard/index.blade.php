@use('App\Models\SchoolYear')

<x-layouts::student-portal :title="__('Student Dashboard')">
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-black text-[#1b0d0d] dark:text-white tracking-tight">Student Dashboard</h1>
            <p class="text-[#9a4c4c] dark:text-[#c4a1a1]">Active School Year: <span class="text-primary font-bold">{{ SchoolYear::where('status', 'Active')->value('name') ?? 'N/A' }}</span></p>
        </div>
    </div>
        
    @livewire('student-portal.dashboard-portal')
</x-layouts::student-portal>
