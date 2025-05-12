<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <div class="flex items-center space-x-6">
                <!-- Applications Link -->
                <a href="{{ route('applications.index') }}" class="relative group">
                    <div class="p-2 rounded-lg hover:bg-indigo-50 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 group-hover:text-indigo-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <span class="absolute -top-1 -right-1 bg-pink-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                        5
                    </span>
                </a>

                <!-- Notifications Link -->
                <a href="{{ route('notifications.index') }}" class="relative group">
                    <div class="p-2 rounded-lg hover:bg-indigo-50 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 group-hover:text-indigo-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <span class="absolute -top-1 -right-1 bg-pink-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                        3
                    </span>
                </a>

                <!-- Reviews Link -->
                <a href="{{ route('reviews.index') }}" class="relative group">
                    <div class="p-2 rounded-lg hover:bg-indigo-50 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 group-hover:text-indigo-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <span class="absolute -top-1 -right-1 bg-pink-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                        8
                    </span>
                </a>
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
                        @if (session('success'))
                            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-green-800">{{ session('success') }}</p>
                                </div>
                            </div>
                        @endif

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

                        <!-- Job Listings Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Title</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Time</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Salary</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posted Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse(auth()->user()->companyProfile->jobListings()->latest()->get() as $jobListing)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $jobListing->title }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $jobListing->job_time }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $jobListing->salary }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $jobListing->created_at->format('M d, Y') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-3">
                                                    <a href="{{ route('job-listings.edit', $jobListing) }}" 
                                                       class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                    <a href="{{ route('job-listings.show', $jobListing) }}" 
                                                       class="text-pink-600 hover:text-pink-900">View</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                                No job listings found. Click "Post New Job" to create your first job listing.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
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
