<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">
                {{ __('Application Details') }}
            </h2>
            <div class="flex items-center space-x-4">
                <a href="{{ route('applications.index') }}" class="text-indigo-600 hover:text-indigo-900">Back to Applications</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Application Status -->
                    <div class="mb-6">
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                            {{ $application->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                               ($application->status === 'accepted' ? 'bg-green-100 text-green-800' : 
                               'bg-red-100 text-red-800') }}">
                            Status: {{ ucfirst($application->status ?? 'pending') }}
                        </span>
                    </div>

                    <!-- Job Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Job Information</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-lg font-semibold text-indigo-900">{{ $application->jobListing->title }}</p>
                            <p class="text-sm text-gray-600 mt-1">{{ $application->jobListing->companyProfile->company_name }}</p>
                        </div>
                    </div>

                    <!-- Applicant Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Applicant Information</h3>
                        <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Full Name</p>
                                <p class="mt-1 text-gray-900">{{ $application->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Email</p>
                                <p class="mt-1 text-gray-900">{{ $application->user->email }}</p>
                            </div>
                            @if($application->user->jobseekerProfile)
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Phone</p>
                                    <p class="mt-1 text-gray-900">{{ $application->user->jobseekerProfile->phone }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Address</p>
                                    <p class="mt-1 text-gray-900">{{ $application->user->jobseekerProfile->address }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Application Details -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Application Details</h3>
                        <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Cover Letter</p>
                                <p class="mt-1 text-gray-900 whitespace-pre-wrap">{{ $application->cover_letter }}</p>
                            </div>
                            @if($application->experience)
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Experience</p>
                                    <p class="mt-1 text-gray-900 whitespace-pre-wrap">{{ $application->experience }}</p>
                                </div>
                            @endif
                            @if($application->additional_notes)
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Additional Notes</p>
                                    <p class="mt-1 text-gray-900 whitespace-pre-wrap">{{ $application->additional_notes }}</p>
                                </div>
                            @endif
                            <div>
                                <p class="text-sm font-medium text-gray-500">Resume/CV</p>
                                <a href="{{ Storage::url($application->application_link) }}" 
                                   target="_blank"
                                   class="mt-1 inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Download Resume
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-4">
                        <form action="{{ route('applications.update-status', $application) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="accepted">
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Accept Application
                            </button>
                        </form>
                        <form action="{{ route('applications.update-status', $application) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Reject Application
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 