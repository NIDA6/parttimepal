<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-900">
            {{ __('Application Details') }}
        </h2>
    </x-slot>
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-900">
                            {{ $application->user->first_name }} {{ $application->user->last_name }}
                        </h2>
                        <p class="text-gray-600">
                            Applied for {{ $application->jobListing->title }} at {{ $application->jobListing->companyProfile->company_name }}
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                            @if($application->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($application->status === 'reviewed') bg-blue-100 text-blue-800
                            @elseif($application->status === 'shortlisted') bg-green-100 text-green-800
                            @elseif($application->status === 'rejected') bg-red-100 text-red-800
                            @elseif($application->status === 'hired') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($application->status) }}
                        </span>
                        <p class="text-sm text-gray-500 mt-1">
                            Applied on {{ $application->created_at->format('M d, Y') }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Contact Information</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-700">
                                <span class="font-medium">Email:</span> {{ $application->user->email }}
                            </p>
                            @if($application->phone)
                                <p class="text-gray-700 mt-1">
                                    <span class="font-medium">Phone:</span> {{ $application->phone }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Job Details</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-700">
                                <span class="font-medium">Position:</span> {{ $application->jobListing->title }}
                            </p>
                            <p class="text-gray-700 mt-1">
                                <span class="font-medium">Job Type:</span> {{ $application->jobListing->job_time }}
                            </p>
                            <p class="text-gray-700 mt-1">
                                <span class="font-medium">Salary:</span> {{ $application->jobListing->salary }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Cover Letter</h3>
                    <div class="bg-gray-50 p-4 rounded-lg whitespace-pre-line">
                        {{ $application->cover_letter }}
                    </div>
                </div>

                @if($application->additional_notes)
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Additional Notes</h3>
                        <div class="bg-gray-50 p-4 rounded-lg whitespace-pre-line">
                            {{ $application->additional_notes }}
                        </div>
                    </div>
                @endif

                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Resume</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        @if($application->application_link)
                            <a href="{{ asset('storage/' . $application->application_link) }}" 
                               target="_blank" 
                               class="inline-flex items-center text-indigo-600 hover:text-indigo-900">
                                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Download Resume
                            </a>
                        @else
                            <p class="text-gray-500">No resume uploaded</p>
                        @endif
                    </div>
                </div>

                <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('company.applications') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
                        <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Applications
                    </a>
                    
                    <div class="space-x-3">
                        <form action="{{ route('applications.update-status', [$application, 'status' => 'rejected']) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="px-4 py-2 border border-red-600 text-red-600 rounded-md hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Reject
                            </button>
                        </form>
                        
                        <form action="{{ route('applications.update-status', [$application, 'status' => 'shortlisted']) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="px-4 py-2 border border-green-600 text-green-600 rounded-md hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Shortlist
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
