<x-app-layout>
    <x-slot name="header">
        <div class="space-y-2">
            <h2 class="font-bold text-3xl text-indigo-900 tracking-tight">
                {{ $jobListing->title }}
            </h2>
            <div class="flex items-center">
                <span class="px-4 py-2 text-sm font-medium rounded-full {{ $jobListing->job_time === 'Part Time' ? 'bg-green-100 text-green-800' : ($jobListing->job_time === 'Contract' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800') }}">
                    {{ $jobListing->job_time }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Salary Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-indigo-900 mb-2">Salary</h3>
                        <p class="text-2xl font-bold text-indigo-600">${{ number_format($jobListing->salary) }}/year</p>
                        <h1 class="text-3xl font-bold text-indigo-900 mb-4">{{ $jobListing->title }}</h1>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-indigo-50 p-4 rounded-lg">
                                <p class="text-sm text-indigo-600">Salary</p>
                                <p class="text-xl font-semibold text-pink-600">{{ $jobListing->salary }}</p>
                            </div>
                            <div class="bg-indigo-50 p-4 rounded-lg">
                                <p class="text-sm text-indigo-600">Job Time</p>
                                <p class="text-xl font-semibold text-indigo-900">{{ $jobListing->job_time }}</p>
                            </div>
                            <div class="bg-indigo-50 p-4 rounded-lg">
                                <p class="text-sm text-indigo-600">Posted</p>
                                <p class="text-xl font-semibold text-indigo-900">{{ $jobListing->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Job Description -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-indigo-900 mb-4">Job Description</h3>
                        <div class="prose max-w-none">
                            {{ $jobListing->description }}
                        </div>
                    </div>

                    <!-- Responsibilities -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-indigo-900 mb-4">Requirements</h3>
                        <div class="prose max-w-none">
                            {{ $jobListing->requirements }}
                        <h2 class="text-xl font-bold text-indigo-900 mb-4">Responsibilities</h2>
                        <div class="prose max-w-none">
                            <p class="text-gray-700">{{ $jobListing->responsibilities }}</p>
                        </div>
                    </div>

                    <!-- Responsibilities -->
                    <!-- Requirements -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-indigo-900 mb-4">Responsibilities</h3>
                        <div class="prose max-w-none">
                            {{ $jobListing->responsibilities }}
                        </div>
                    </div>

                    @if($jobListing->additional_message)
                        <!-- Additional Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-indigo-900 mb-4">Additional Information</h3>
                            <div class="prose max-w-none">
                                {{ $jobListing->additional_message }}
                            </div>
                        <h2 class="text-xl font-bold text-indigo-900 mb-4">Requirements</h2>
                        <div class="prose max-w-none">
                            <p class="text-gray-700">{{ $jobListing->requirements }}</p>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="mt-8 pt-8 border-t border-gray-200 flex justify-end gap-4">
                        <a href="{{ route('dashboard') }}" 
                           title="Return to Dashboard"
                           class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" role="img">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            <span>Back to Dashboard</span>
                        </a>
                        @if(auth()->user()->role === 'Jobseeker')
                        <a href="{{ route('job-listings.apply', $jobListing) }}" class="btn btn-primary"> Apply Now</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 