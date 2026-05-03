<div class="max-w-[960px] w-full flex flex-col gap-6 mx-auto py-4 px-4" x-data="{ resumed: @entangle('is_resumed') }">
    @teleport('#header-action')
        @if($currentStep == 0 && $initStep == 0)
            <a href="{{ route('home') }}" class="text-sm font-bold text-gray-500 hover:text-primary transition-colors">Return Home</a>
        @else
            <a href="{{ route('enroll.public') }}" class="text-sm font-bold text-gray-500 hover:text-primary transition-colors">Cancel & Return</a>
        @endif
    @endteleport

    @if($submitted)
        @include('livewire.enrollment.partials.success')
    @else
        @if($currentStep == 0)
            <!-- Step 0: Initiation Flow -->
            <div class="glass-card rounded-xl shadow-sm border border-[#e7cfcf] dark:border-white/10 overflow-hidden">
                @if($initStep == 0)
                    @include('livewire.enrollment.initial.identity')
                @elseif($initStep == 1)
                    @include('livewire.enrollment.initial.category')
                @elseif($initStep == 2)
                    @include('livewire.enrollment.initial.type')
                @endif
            </div>
        @else
            <!-- Main Form Wrapper -->
            <!-- Progress Tracker -->
            @include('livewire.enrollment.partials.progress')

            <form wire:submit.prevent="submit" class="space-y-6">
                @if($currentStep == 1)
                    @include('livewire.enrollment.steps.step1')
                @elseif($currentStep == 2)
                    @include('livewire.enrollment.steps.step2')
                @elseif($currentStep == 3)
                    @include('livewire.enrollment.steps.step3')
                @elseif($currentStep == 4)
                    @include('livewire.enrollment.steps.step4')
                @elseif($currentStep == 5)
                    @include('livewire.enrollment.steps.step5')
                @elseif($currentStep == 6)
                    @include('livewire.enrollment.steps.step6')
                @endif

                <!-- Navigation Buttons -->
                @include('livewire.enrollment.partials.navigation')
            </form>
        @endif
    @endif

    @include('livewire.enrollment.partials.already-enrolled-modal')
    @include('livewire.enrollment.partials.resume-modal')
    @include('livewire.enrollment.partials.psa-help-modal')
</div>
