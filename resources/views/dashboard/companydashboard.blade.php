<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <h2 class="font-semibold text-xl text-gray-900 leading-tight">
                    {{ __('Company Dashboard') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(auth()->user()->companyProfile)
                <!-- Company Information Section -->
                <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-indigo-900 mb-6 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Company Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Company Name -->
                            <div>
                                <h4 class="text-base font-bold text-indigo-900 bg-indigo-50 px-3 py-2 rounded-lg inline-block">Company Name</h4>
                                <p class="mt-2 text-lg text-gray-900">{{ auth()->user()->companyProfile->company_name }}</p>
                            </div>

                            <!-- Company Email -->
                            <div>
                                <h4 class="text-base font-bold text-indigo-900 bg-indigo-50 px-3 py-2 rounded-lg inline-block">Company Email</h4>
                                <p class="mt-2 text-lg text-gray-900">{{ auth()->user()->companyProfile->company_email }}</p>
                            </div>

                            <!-- Location -->
                            <div>
                                <h4 class="text-base font-bold text-indigo-900 bg-indigo-50 px-3 py-2 rounded-lg inline-block">Location</h4>
                                <p class="mt-2 text-lg text-gray-900">{{ auth()->user()->companyProfile->location }}</p>
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <h4 class="text-base font-bold text-indigo-900 bg-indigo-50 px-3 py-2 rounded-lg inline-block">Phone Number</h4>
                                <p class="mt-2 text-lg text-gray-900">{{ auth()->user()->companyProfile->phone_number }}</p>
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <h4 class="text-base font-bold text-indigo-900 bg-indigo-50 px-3 py-2 rounded-lg inline-block">Description</h4>
                                <p class="mt-2 text-lg text-gray-900">{{ auth()->user()->companyProfile->description }}</p>
                            </div>

                            <!-- Establishment Date -->
                            <div>
                                <h4 class="text-base font-bold text-indigo-900 bg-indigo-50 px-3 py-2 rounded-lg inline-block">Establishment Date</h4>
                                <p class="mt-2 text-lg text-gray-900">{{ auth()->user()->companyProfile->establish_date->format('F j, Y') }}</p>
                            </div>

                            <!-- Website URL -->
                            <div>
                                <h4 class="text-base font-bold text-indigo-900 bg-indigo-50 px-3 py-2 rounded-lg inline-block">Website</h4>
                                <p class="mt-2 text-lg text-gray-900">
                                    @if(auth()->user()->companyProfile->website_url)
                                        <a href="{{ auth()->user()->companyProfile->website_url }}" target="_blank" class="text-indigo-600 hover:text-indigo-800">
                                            {{ auth()->user()->companyProfile->website_url }}
                                        </a>
                                    @else
                                        <span class="text-gray-500">No website provided</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Job Listings Section -->
                <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold text-indigo-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Job Listings
                            </h3>
                            <a href="{{ route('job-listings.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-yellow-400 hover:text-blue-600 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Post New Job
                            </a>
                        </div>
                        <div class="space-y-4">
                            @forelse(auth()->user()->companyProfile->jobListings()->latest()->take(5)->get() as $jobListing)
                                <div class="bg-gradient-to-r from-indigo-50 to-white p-4 rounded-lg border border-indigo-100 hover:shadow-md transition-shadow duration-200">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="text-lg font-semibold text-indigo-900">{{ $jobListing->title }}</h4>
                                            <p class="text-sm text-gray-600 mt-1">{{ $jobListing->job_time }}</p>
                                        </div>
                                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-indigo-100 text-indigo-800">
                                            {{ $jobListing->salary }}
                                        </span>
                                    </div>
                                    <div class="mt-4 flex justify-between items-center">
                                        <span class="text-sm text-gray-500">
                                            Posted {{ $jobListing->created_at->diffForHumans() }}
                                        </span>
                                        <div class="flex items-center gap-4">
                                            <a href="{{ route('job-listings.edit', $jobListing) }}" 
                                               class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Edit
                                            </a>
                                            <a href="{{ route('job-listings.show', $jobListing) }}" 
                                               class="text-pink-600 hover:text-indigo-800 text-sm font-medium flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                View Details →
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <h3 class="mt-4 text-lg font-medium text-gray-900">No Job Listings Yet</h3>
                                    <p class="mt-2 text-sm text-gray-500">Start posting jobs to find the perfect candidates</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @else
                <!-- No Profile Section -->
                <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">No Company Profile Created Yet</h3>
                        <p class="mt-2 text-sm text-gray-500">Create your company profile to start posting jobs</p>
                        <div class="mt-6">
                            <a href="{{ route('company.profile.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-yellow-400 hover:text-blue-600 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Create Company Profile
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
