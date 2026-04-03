<div class="p-8 bg-gray-900 rounded-xl shadow-2xl max-w-5xl mx-auto font-sans">
    
    <div class="flex justify-between items-end mb-12">
        <h2 class="text-2xl font-bold text-white tracking-wide">ASPIRE <span class="text-gray-400 font-light">| Enrollment Pipeline</span></h2>
        
        <div class="text-right text-xs font-mono text-gray-400 space-y-1">
            <p><span class="text-gray-500">STATUS</span> <span class="text-green-400 font-bold ml-2">LIVE</span></p>
            <p><span class="text-gray-500">APPLICANT ID</span> <span class="text-white ml-2">TNTS-2026-001</span></p>
        </div>
    </div>

    <div class="relative py-12" x-data="{ hoveredNode: null }">
        
        <div class="absolute top-[calc(50%+10px)] left-0 w-full h-1 bg-gray-700 -translate-y-1/2 z-0 border-t border-dashed border-gray-600"></div>

        <div class="relative z-10 flex justify-between items-center w-full">
            @foreach($steps as $key => $step)
                <div class="flex flex-col items-center group cursor-pointer"
                     @mouseenter="hoveredNode = {{ $key }}"
                     @mouseleave="hoveredNode = null">
                    
                    <div class="mb-4 h-12 text-center transition-all duration-300" 
                         :class="hoveredNode === {{ $key }} ? 'opacity-100 translate-y-0' : 'opacity-70 translate-y-1'">
                        <span class="text-xs font-semibold tracking-wider uppercase
                            {{ $step['status'] === 'completed' ? 'text-green-400' : '' }}
                            {{ $step['status'] === 'active' ? 'text-blue-400' : '' }}
                            {{ $step['status'] === 'pending' ? 'text-gray-500' : '' }}">
                            {{ $step['title'] }}
                        </span>
                    </div>

                    <div class="relative flex justify-center items-center w-14 h-14 rounded-full border-2 transition-all duration-300 shadow-lg {{ $step['status'] === 'completed' ? 'bg-green-400' : '' }}"
                         :class="hoveredNode === {{ $key }} ? 'scale-110' : 'scale-100'"
                         class="
                            {{ $step['status'] === 'completed' ? 'bg-green-900/50 border-green-400 shadow-green-900/50' : '' }}
                            {{ $step['status'] === 'active' ? 'bg-blue-900/50 border-blue-400 shadow-blue-900/50' : '' }}
                            {{ $step['status'] === 'pending' ? 'bg-gray-800 border-gray-600' : '' }}">
                        
                        @if($step['status'] === 'active')
                            <span class="absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-20 animate-ping"></span>
                        @endif

                        <span class="font-bold text-sm
                            {{ $step['status'] === 'completed' ? 'text-white' : '' }}
                            {{ $step['status'] === 'active' ? 'text-blue-400' : '' }}
                            {{ $step['status'] === 'pending' ? 'text-gray-500' : '' }}">
                            {{ $key }}
                        </span>
                    </div>

                    <div class="mt-4 h-6">
                        @if($step['status'] === 'active')
                            <span class="px-2 py-1 text-[10px] font-mono text-blue-200 bg-blue-900/60 rounded-full border border-blue-700">IN PROGRESS</span>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-12 flex justify-center">
        <button 
            wire:click="advancePipeline"
            wire:loading.attr="disabled"
            class="px-8 py-3 bg-gray-800 hover:bg-gray-700 text-gray-200 text-sm font-medium rounded-lg border border-gray-600 transition-colors shadow-sm w-full max-w-md flex justify-center items-center group">
            <span wire:loading.remove class="flex items-center gap-2">
                Simulate Next Pipeline Step
                <svg class="w-4 h-4 text-gray-500 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                </svg>
            </span>
            <span wire:loading class="flex items-center gap-2">
                <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Processing...
            </span>
        </button>
    </div>
    
</div>
