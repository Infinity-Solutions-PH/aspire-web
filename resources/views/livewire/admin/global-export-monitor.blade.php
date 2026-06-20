<div>
    @if($isExporting)
        <div wire:poll.2s="checkExportStatus" class="hidden"></div>
        <div class="fixed bottom-4 right-4 bg-white dark:bg-[#1a0c0c] border border-primary text-[#1b0d0d] dark:text-[#fcf8f8] px-6 py-4 rounded-xl shadow-2xl flex items-center gap-4 z-50 animate-bounce">
            <svg class="animate-spin h-6 w-6 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <div>
                <p class="font-bold">Export Processing</p>
                <p class="text-xs text-[#9a4c4c] dark:text-[#c4a1a1]">You can continue navigating the system...</p>
            </div>
        </div>
    @endif
</div>
