<div class="min-h-screen bg-background-light dark:bg-background-dark font-display">
    <div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
        <div class="layout-container flex h-full grow flex-col">
            <div class="flex flex-1 justify-center py-5 px-4 md:px-0 mt-8">
                <!-- Appointment Card Container -->
                <div class="layout-content-container flex flex-col max-w-[600px] flex-1 bg-white dark:bg-zinc-900 shadow-xl rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-800">
                    <!-- Header Section -->
                    <header class="flex flex-col items-center justify-center bg-primary p-8 text-white">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="size-10 bg-white rounded-full flex items-center justify-center p-1.5">
                                <svg class="text-primary w-full h-full" fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M36.7273 44C33.9891 44 31.6043 39.8386 30.3636 33.69C29.123 39.8386 26.7382 44 24 44C21.2618 44 18.877 39.8386 17.6364 33.69C16.3957 39.8386 14.0109 44 11.2727 44C7.25611 44 4 35.0457 4 24C4 12.9543 7.25611 4 11.2727 4C14.0109 4 16.3957 8.16144 17.6364 14.31C18.877 8.16144 21.2618 4 24 4C26.7382 4 29.123 8.16144 30.3636 14.31C31.6043 8.16144 33.9891 4 36.7273 4C40.7439 4 44 12.9543 44 24C44 35.0457 40.7439 44 36.7273 44Z" fill="currentColor"></path>
                                </svg>
                            </div>
                            <h1 class="text-xl font-bold tracking-tight">TNTS</h1>
                        </div>
                        <p class="text-sm uppercase tracking-widest opacity-90 font-medium">Tanza National Trade School</p>
                    </header>
                    
                    <!-- Hero Image & Title -->
                    <div class="pt-6">
                        <div class="px-6">
                            <div class="bg-cover bg-center flex flex-col justify-end overflow-hidden rounded-xl min-h-[160px]" style='background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.6) 0%, rgba(0, 0, 0, 0.1) 50%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuDrRd26ExunQ5DmnwBG4BeRabeseenJSaG8ksywd7jTmNokRHKpa69_AfKDHcTqYxkpewHklJ6VNinLa5htYlsE5sDClKUpTUk9kCkQYJOlmviev1eCHa-tyeua7s17MqiZevAfZXB8MKxskQabx__qXwb8ZfSWLbYvUMHCBDjFbaQVrUak2w5VU5qOzy2jIDhUE63r2XKcLBuLWORPm3kTV6SqYnTj8l5tcQExRItMtgxNwL6lqNg_7CmuXtoNXMV2AFl54cLUN98");'>
                                <div class="p-6">
                                    <h2 class="text-white text-2xl font-bold leading-tight">Appointment Reminder</h2>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Greeting -->
                        <div class="px-8 pt-8">
                            <h2 class="text-[#1b0d0d] dark:text-zinc-100 text-2xl font-bold leading-tight pb-2">Hello, {{ Auth::user()->name }}!</h2>
                            <p class="text-zinc-600 dark:text-zinc-400 text-base font-normal leading-relaxed">
                                We are excited to welcome you to the Tanza National Trade School community. This is a friendly reminder for your upcoming enrollment appointment.
                            </p>
                        </div>
                        
                        <!-- Appointment Card -->
                        <div class="px-8 pt-6 pb-2">
                            <div class="flex flex-col border-2 border-primary/20 bg-primary/5 dark:bg-primary/10 rounded-xl overflow-hidden">
                                <div class="bg-primary/10 dark:bg-primary/20 px-4 py-2 border-b border-primary/10">
                                    <p class="text-primary font-bold text-xs uppercase tracking-wider">Appointment Details</p>
                                </div>
                                <div class="p-5 flex flex-col gap-4">
                                    <div class="flex items-start gap-4">
                                        <span class="material-symbols-outlined text-primary">calendar_today</span>
                                        <div>
                                            <p class="text-zinc-500 text-xs font-semibold uppercase">Date</p>
                                            <p class="text-[#1b0d0d] dark:text-white font-bold">Please wait for SMS/Email</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-4">
                                        <span class="material-symbols-outlined text-primary">location_on</span>
                                        <div>
                                            <p class="text-zinc-500 text-xs font-semibold uppercase">Venue</p>
                                            <p class="text-[#1b0d0d] dark:text-white font-bold">School Registrar, Main Building</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-5 py-3 bg-white dark:bg-zinc-800/50 italic text-xs text-zinc-500">
                                    * Please remember to bring your original documents upon visiting.
                                </div>
                            </div>
                        </div>
                        
                        <!-- Checklist Section -->
                        <div class="px-8 pt-6">
                            <h3 class="text-[#1b0d0d] dark:text-zinc-100 text-lg font-bold mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">assignment_turned_in</span>
                                Checklist of Requirements
                            </h3>
                            <div class="space-y-3">
                                <div class="flex items-center gap-3 p-3 rounded-lg border border-zinc-100 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-800/30">
                                    <span class="material-symbols-outlined text-green-600 text-sm">check_circle</span>
                                    <p class="text-sm text-zinc-700 dark:text-zinc-300">PSA Birth Certificate (Original &amp; Photocopy)</p>
                                </div>
                                <div class="flex items-center gap-3 p-3 rounded-lg border border-zinc-100 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-800/30">
                                    <span class="material-symbols-outlined text-green-600 text-sm">check_circle</span>
                                    <p class="text-sm text-zinc-700 dark:text-zinc-300">Form 138 (Report Card)</p>
                                </div>
                                <div class="flex items-center gap-3 p-3 rounded-lg border border-zinc-100 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-800/30">
                                    <span class="material-symbols-outlined text-green-600 text-sm">check_circle</span>
                                    <p class="text-sm text-zinc-700 dark:text-zinc-300">Good Moral Certificate</p>
                                </div>
                                <div class="flex items-center gap-3 p-3 rounded-lg border border-zinc-100 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-800/30">
                                    <span class="material-symbols-outlined text-green-600 text-sm">check_circle</span>
                                    <p class="text-sm text-zinc-700 dark:text-zinc-300">Four (4) 2x2 ID Pictures</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="px-8 py-10 flex flex-col items-center gap-4">
                            <a href="{{ route('dashboard') }}" class="w-full flex min-w-[200px] max-w-sm cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-6 bg-primary text-white text-base font-bold leading-normal tracking-wide shadow-lg hover:bg-primary/90 transition-colors">
                                <span class="truncate">Back to Dashboard</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
