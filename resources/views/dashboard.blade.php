<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <a href="{{ route('enrollment.form') }}" class="group relative aspect-video overflow-hidden rounded-xl border border-primary/20 bg-primary/5 hover:bg-primary/10 transition-all flex flex-col items-center justify-center gap-3">
                <div class="size-12 rounded-full bg-primary text-white flex items-center justify-center group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-2xl">school</span>
                </div>
                <div class="text-center">
                    <h3 class="font-bold text-primary">New Enrollment</h3>
                    <p class="text-xs text-primary/60">Start your ASPIRE application</p>
                </div>
            </a>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="absolute inset-0 flex flex-col items-center justify-center text-neutral-400">
                <span class="material-symbols-outlined text-6xl mb-4">analytics</span>
                <p class="text-sm font-medium">Application Analytics Coming Soon</p>
            </div>
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>
</x-layouts::app>
