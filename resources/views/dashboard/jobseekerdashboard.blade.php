<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <h2 class="font-semibold text-xl text-gray-900 leading-tight">
                    {{ __('Jobseeker Dashboard') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Browse Jobs Button -->
            <div class="mt-6 bg-indigo-50 p-6 rounded-lg shadow">
                <a href="{{ route('job-listings.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-white text-black rounded-lg hover:bg-gray-800 hover:text-white transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Browse 
                </a>
            </div>

            <!-- Available Jobs Section -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-indigo-900 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Available Jobs
                    </h3>
                    
                    <div class="grid grid-cols-1 gap-6">
                        @forelse($jobListings as $job)
                            <div class="bg-gradient-to-br from-indigo-50/80 via-purple-50/80 to-pink-50/80 p-6 rounded-xl border border-indigo-200/50 shadow-lg backdrop-blur-sm transition-all duration-300 hover:shadow-xl">
                                <!-- Company Name Banner -->
                                <div class="mb-4 pb-3 border-b border-indigo-200/50">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        <h3 class="text-lg font-semibold text-pink-600">{{ $job->companyProfile->name }}</h3>
                                    </div>
                                </div>

                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="text-xl font-bold text-indigo-900">{{ $job->title }}</h4>
                                        <p class="text-sm text-indigo-600 mt-1">
                                            <span class="font-semibold">Company:</span> 
                                            {{ $job->companyProfile->company_name }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-semibold text-pink-600">${{ number_format((float)$job->salary, 2) }}</p>
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
                                        <form action="{{ route('job-listings.apply', $job) }}" method="POST">
                                            @csrf
                                            <button type="submit" 
                                                    class="inline-flex items-center px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition-colors duration-200">
                                                Apply Now
                                            </button>
                                        </form>
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
            
            <!-- Jobseeker Information Section -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-indigo-900 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        My Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <h4 class="text-base font-bold text-indigo-900 bg-indigo-50 px-3 py-2 rounded-lg inline-block">Name</h4>
                            <p class="mt-2 text-lg text-gray-900">{{ auth()->user()->name }}</p>
                        </div>

                        <!-- Email -->
                        <div>
                            <h4 class="text-base font-bold text-indigo-900 bg-indigo-50 px-3 py-2 rounded-lg inline-block">Email</h4>
                            <p class="mt-2 text-lg text-gray-900">{{ auth()->user()->email }}</p>
                        </div>

                        <!-- Phone -->
                        <div>
                            <h4 class="text-base font-bold text-indigo-900 bg-indigo-50 px-3 py-2 rounded-lg inline-block">Phone Number</h4>
                            <p class="mt-2 text-lg text-gray-900">{{ auth()->user()->jobseekerProfile->phone ?? 'Not provided' }}</p>
                        </div>

                        <!-- Address -->
                        <div>
                            <h4 class="text-base font-bold text-indigo-900 bg-indigo-50 px-3 py-2 rounded-lg inline-block">Address</h4>
                            <p class="mt-2 text-lg text-gray-900">{{ auth()->user()->jobseekerProfile->address ?? 'Not provided' }}</p>
                        </div>

                        <!-- Skills -->
                        @if(auth()->user()->jobseekerProfile && auth()->user()->jobseekerProfile->skills)
                        <div class="md:col-span-2">
                            <h4 class="text-base font-bold text-indigo-900 bg-indigo-50 px-3 py-2 rounded-lg inline-block">Skills</h4>
                            <div class="mt-2 flex flex-wrap gap-2">
                                @foreach(explode(',', auth()->user()->jobseekerProfile->skills) as $skill)
                                    <p class="text-lg text-gray-900">{{ trim($skill) }}</p>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Education -->
                        <div class="md:col-span-2">
                            <h4 class="text-base font-bold text-indigo-900 bg-indigo-50 px-3 py-2 rounded-lg inline-block">Education</h4>
                            <div class="mt-2 space-y-4">
                                @if(auth()->user()->jobseekerProfile)
                                    @forelse(auth()->user()->jobseekerProfile->education as $edu)
                                        <div class="bg-indigo-50 p-4 rounded-lg">
                                            @if($edu->school_name)
                                                <p class="text-lg font-medium text-indigo-900">{{ $edu->school_name }}</p>
                                                <p class="text-sm text-indigo-600">{{ $edu->school_year }}</p>
                                            @endif
                                            @if($edu->college_name)
                                                <p class="text-lg font-medium text-indigo-900 mt-2">{{ $edu->college_name }}</p>
                                                <p class="text-sm text-indigo-600">{{ $edu->college_year }}</p>
                                            @endif
                                            @if($edu->university_name)
                                                <p class="text-lg font-medium text-indigo-900 mt-2">{{ $edu->university_name }}</p>
                                                <p class="text-sm text-indigo-600">{{ $edu->university_year }}</p>
                                            @endif
                                        </div>
                                    @empty
                                        <p class="text-gray-500">No education history provided</p>
                                    @endforelse
                                @else
                                    <p class="text-gray-500">No education history provided</p>
                                @endif
                            </div>
                        </div>

                        <!-- Work Experience -->
                        @if(auth()->user()->jobseekerProfile && auth()->user()->jobseekerProfile->workplaces && count(auth()->user()->jobseekerProfile->workplaces) > 0)
                        <div class="md:col-span-2">
                            <h4 class="text-base font-bold text-indigo-900 bg-indigo-50 px-3 py-2 rounded-lg inline-block">Work Experience</h4>
                            <div class="mt-2 space-y-4">
                                @foreach(auth()->user()->jobseekerProfile->workplaces as $workplace)
                                    <div class="bg-indigo-50 p-4 rounded-lg">
                                        <p class="text-lg font-medium text-indigo-900">{{ $workplace->company_name }}</p>
                                        <p class="text-sm text-indigo-600">{{ $workplace->designation }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>


        
