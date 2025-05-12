<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">
                {{ $companyProfile->company_name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Company Overview -->
                    <div class="mb-8">
                        <div class="flex items-center gap-4 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <h3 class="text-2xl font-bold text-gray-900">Company Overview</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-600">Description</h4>
                                    <p class="mt-1 text-gray-900">{{ $companyProfile->description }}</p>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-600">Location</h4>
                                    <p class="mt-1 text-gray-900">{{ $companyProfile->location }}</p>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-600">Established</h4>
                                    <p class="mt-1 text-gray-900">{{ $companyProfile->establish_date->format('F Y') }}</p>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-600">Contact Information</h4>
                                    <div class="mt-2 space-y-2">
                                        <p class="text-gray-900">
                                            <span class="font-medium">Email:</span> {{ $companyProfile->company_email }}
                                        </p>
                                        <p class="text-gray-900">
                                            <span class="font-medium">Phone:</span> {{ $companyProfile->phone_number }}
                                        </p>
                                        @if($companyProfile->website_url)
                                            <p class="text-gray-900">
                                                <span class="font-medium">Website:</span>
                                                <a href="{{ $companyProfile->website_url }}" target="_blank" class="text-indigo-600 hover:text-indigo-800">
                                                    {{ $companyProfile->website_url }}
                                                </a>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                
                                @if($companyProfile->socialMedia->isNotEmpty())
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-600">Social Media</h4>
                                        <div class="mt-2 flex flex-wrap gap-2">
                                            @foreach($companyProfile->socialMedia as $social)
                                                <a href="{{ $social->url }}" target="_blank" 
                                                   class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm hover:bg-gray-200 transition-colors duration-200">
                                                    {{ $social->platform }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Current Job Openings -->
                    @if($companyProfile->jobListings->isNotEmpty())
                        <div class="mt-8">
                            <div class="flex items-center gap-4 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <h3 class="text-2xl font-bold text-gray-900">Current Job Openings</h3>
                            </div>

                            <div class="grid grid-cols-1 gap-4">
                                @foreach($companyProfile->jobListings as $job)
                                    <div class="bg-gradient-to-br from-indigo-50/80 via-purple-50/80 to-pink-50/80 p-4 rounded-lg border border-indigo-200/50">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="text-lg font-semibold text-indigo-900">{{ $job->title }}</h4>
                                                <p class="text-sm text-indigo-600 mt-1">{{ $job->job_time }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-lg font-semibold text-pink-600">${{ number_format($job->salary, 2) }}</p>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <p class="text-gray-700 line-clamp-2">{{ $job->description }}</p>
                                        </div>
                                        <div class="mt-4 flex justify-end">
                                            <a href="{{ route('job-listings.show', $job) }}" 
                                               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 