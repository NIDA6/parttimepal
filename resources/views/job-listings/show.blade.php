<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <h2 class="font-semibold text-xl text-gray-900 leading-tight">
                    {{ __('Job Details') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Company Information -->
                    <div class="mb-8 pb-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-pink-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <div>
                                <h3 class="text-2xl font-bold text-pink-600">{{ $jobListing->companyProfile->company_name }}</h3>
                                <p class="text-gray-600">{{ $jobListing->companyProfile->location }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Job Title and Basic Info -->
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold text-indigo-900 mb-4">{{ $jobListing->title }}</h1>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-indigo-50 p-4 rounded-lg">
                                <p class="text-sm text-indigo-600">Salary</p>
                                <p class="text-xl font-semibold text-pink-600">${{ number_format($jobListing->salary, 2) }}</p>
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
                        <h2 class="text-xl font-bold text-indigo-900 mb-4">Job Description</h2>
                        <div class="prose max-w-none">
                            <p class="text-gray-700">{{ $jobListing->description }}</p>
                        </div>
                    </div>

                    <!-- Requirements -->
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-indigo-900 mb-4">Requirements</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(',', $jobListing->requirements) as $requirement)
                                <span class="px-4 py-2 bg-indigo-100 text-indigo-800 rounded-full text-sm">
                                    {{ trim($requirement) }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Company Details -->
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-indigo-900 mb-4">About the Company</h2>
                        <div class="bg-indigo-50 p-6 rounded-lg">
                            <p class="text-gray-700 mb-4">{{ $jobListing->companyProfile->description }}</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($jobListing->companyProfile->website_url)
                                    <div>
                                        <p class="text-sm text-indigo-600">Website</p>
                                        <a href="{{ $jobListing->companyProfile->website_url }}" target="_blank" class="text-indigo-900 hover:text-pink-600">
                                            {{ $jobListing->companyProfile->website_url }}
                                        </a>
                                    </div>
                                @endif
                                @if($jobListing->companyProfile->company_email)
                                    <div>
                                        <p class="text-sm text-indigo-600">Email</p>
                                        <p class="text-indigo-900">{{ $jobListing->companyProfile->company_email }}</p>
                                    </div>
                                @endif
                                @if($jobListing->companyProfile->phone_number)
                                    <div>
                                        <p class="text-sm text-indigo-600">Phone</p>
                                        <p class="text-indigo-900">{{ $jobListing->companyProfile->phone_number }}</p>
                                    </div>
                                @endif
                                @if($jobListing->companyProfile->establish_date)
                                    <div>
                                        <p class="text-sm text-indigo-600">Established</p>
                                        <p class="text-indigo-900">{{ $jobListing->companyProfile->establish_date }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('dashboard') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Dashboard
                        </a>
                        <form action="{{ route('job-listings.apply', $jobListing) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-3 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Apply Now
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 