<div class="max-w-4xl mx-auto py-10">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Student Portal - Self Enrollment</h2>

        @if(session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        @if(!$activeSchoolYear)
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                Enrollment is currently closed. There is no active school year.
            </div>
        @elseif($alreadyEnrolled)
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
                You are already enrolled for the {{ $activeSchoolYear->name }} school year.
            </div>
        @elseif(!$lastEnrollment)
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                No previous enrollment record found. Please contact the registrar.
            </div>
        @elseif(!$isEligibleForEnrollment)
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                You are not currently eligible to self-enroll. Your previous school year might not be completed yet, or you have already graduated.
            </div>
        @else
            <div class="mb-6">
                <p class="text-gray-700 mb-2">Based on your previous academic result (<strong>{{ ucfirst($lastEnrollment->academic_result) }}</strong> in {{ $lastEnrollment->grade_level }}), you are eligible to enroll for:</p>
                <div class="text-xl font-semibold text-indigo-600 mb-4">
                    {{ $suggestedGradeLevel }}
                </div>

                @if(in_array($suggestedGradeLevel, ['Grade 11', 'Grade 12']))
                    <!-- Add track/strand selection if needed, simplified for demo -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Track / Strand</label>
                        <p class="text-sm text-gray-600">Continuing with: {{ $lastEnrollment->track }} - {{ $lastEnrollment->strand }}</p>
                    </div>
                @endif
            </div>

            <button wire:click="submitEnrollment" class="bg-indigo-600 text-white font-bold py-2 px-4 rounded hover:bg-indigo-700 transition">
                Confirm and Enroll
            </button>
        @endif
    </div>
</div>
