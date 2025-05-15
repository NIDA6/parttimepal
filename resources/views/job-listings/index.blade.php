<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <h2 class="font-semibold text-xl text-gray-900 leading-tight">
                    {{ __('Available Jobs') }}
                </h2>
                <a href="{{ route('browse.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Browse 
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-6">
                        @forelse($jobListings as $job)
                            <div class="bg-gradient-to-br from-indigo-50/80 via-purple-50/80 to-pink-50/80 p-6 rounded-xl border border-indigo-200/50 shadow-lg backdrop-blur-sm transition-all duration-300 hover:shadow-xl">
                                <!-- Company Name Banner -->
                                <div class="mb-4 pb-3 border-b border-indigo-200/50">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        @if($job->companyProfile)
                                            <a href="/company/{{ $job->companyProfile->id }}" 
                                               class="text-lg font-semibold text-pink-600 hover:text-pink-700 hover:underline">
                                                {{ $job->companyProfile->company_name }}
                                            </a>
                                        @else
                                            <span class="text-lg font-semibold text-gray-500">Company Not Found</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="text-xl font-bold text-indigo-900">{{ $job->title }}</h4>
                                        <p class="text-sm text-indigo-600 mt-1">
                                            <span class="font-semibold">Location:</span> 
                                            {{ $job->companyProfile ? $job->companyProfile->location : 'Location not available' }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-semibold text-pink-600">${{ $job->salary }}</p>
                                        <p class="text-sm text-gray-600">{{ $job->job_time }}</p>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <p class="text-gray-700 line-clamp-2">{{ $job->description }}</p>
                                </div>

                                <div class="mt-4 flex flex-wrap gap-2">
                                    @foreach(explode(',', $job->requirements) as $requirement)
                                        <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm">
                                            {{ trim($requirement) }}
                                        </span>
                                    @endforeach
                                </div>

                                <div class="mt-6 flex justify-between items-center">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Posted {{ $job->created_at->diffForHumans() }}
                                    </div>
                                    <div class="flex gap-3">
                                        <a href="{{ route('job-listings.show', $job) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View Details
                                        </a>
                                        <<a href="{{ route('job-listings.apply.form', $jobListing) }}" class="btn btn-primary flex items-center px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition-colors duration-200"> Apply Now</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="mt-4 text-gray-600">No job listings available at the moment.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 