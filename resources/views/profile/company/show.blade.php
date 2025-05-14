<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $companyProfile->company_name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Company Information -->
                    <div class="mb-8">
                        <div class="flex items-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-pink-600 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">{{ $companyProfile->company_name }}</h1>
                                <p class="text-gray-600">{{ $companyProfile->location }}</p>
                            </div>
                        </div>

                        <!-- Company Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Company Information</h3>
                                <div class="space-y-4">
                                    @if($companyProfile->website_url)
                                        <div>
                                            <p class="text-sm text-gray-600">Website</p>
                                            <a href="{{ $companyProfile->website_url }}" target="_blank" class="text-indigo-600 hover:text-indigo-800">
                                                {{ $companyProfile->website_url }}
                                            </a>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-sm text-gray-600">Email</p>
                                        <p class="text-gray-900">{{ $companyProfile->company_email }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Phone</p>
                                        <p class="text-gray-900">{{ $companyProfile->phone_number }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Established</p>
                                        <p class="text-gray-900">{{ $companyProfile->establish_date->format('F Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">About Us</h3>
                                <p class="text-gray-700">{{ $companyProfile->description }}</p>
                            </div>
                        </div>

                        <!-- Social Media Links -->
                        @if($companyProfile->socialMedia->isNotEmpty())
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Social Media</h3>
                                <div class="flex flex-wrap gap-4">
                                    @foreach($companyProfile->socialMedia as $social)
                                        <a href="{{ $social->url }}" target="_blank" class="text-indigo-600 hover:text-indigo-800">
                                            {{ $social->platform }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Job Listings -->
                        @if($companyProfile->jobListings->isNotEmpty())
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Current Job Openings</h3>
                                <div class="space-y-4">
                                    @foreach($companyProfile->jobListings as $job)
                                        <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                            <h4 class="text-xl font-semibold text-gray-900">{{ $job->title }}</h4>
                                            <div class="mt-2 flex items-center gap-4 text-sm text-gray-600">
                                                <span>{{ $job->job_time }}</span>
                                                <span>•</span>
                                                <span>${{ $job->salary }}</span>
                                                <span>•</span>
                                                <span>Posted {{ $job->created_at->diffForHumans() }}</span>
                                            </div>
                                            <div class="mt-4">
                                                <a href="{{ route('job-listings.show', $job) }}" class="text-indigo-600 hover:text-indigo-800">
                                                    View Details →
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-4 mt-8">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Dashboard
                        </a>
                        @if(auth()->id() === $companyProfile->user_id)
                            <a href="{{ route('company.profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                                Edit Profile
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 