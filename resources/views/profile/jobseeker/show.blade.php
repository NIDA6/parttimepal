<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">
                {{ __('Jobseeker Profile') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Basic Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-600">Name</p>
                                <p class="text-gray-900">{{ $jobseekerProfile->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Email</p>
                                <p class="text-gray-900">{{ $jobseekerProfile->user->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Address</p>
                                <p class="text-gray-900">{{ $jobseekerProfile->address }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Phone</p>
                                <p class="text-gray-900">{{ $jobseekerProfile->phone }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Skills -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Skills</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(',', $jobseekerProfile->skills) as $skill)
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm">
                                    {{ trim($skill) }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Education -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Education</h3>
                        <div class="space-y-4">
                            @forelse($jobseekerProfile->education as $education)
                                <div class="border-l-4 border-indigo-500 pl-4">
                                    @if($education->school_name)
                                        <p class="font-semibold text-gray-900">School</p>
                                        <p class="text-gray-600">{{ $education->school_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $education->school_year }}</p>
                                    @endif

                                    @if($education->college_name)
                                        <p class="font-semibold text-gray-900">College</p>
                                        <p class="text-gray-600">{{ $education->college_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $education->college_year }}</p>
                                    @endif

                                    @if($education->university_name)
                                        <p class="font-semibold text-gray-900">University</p>
                                        <p class="text-gray-600">{{ $education->university_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $education->university_year }}</p>
                                    @endif
                                </div>
                            @empty
                                <p class="text-gray-600">No education information available.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Work Experience -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Work Experience</h3>
                        <div class="space-y-4">
                            @forelse($jobseekerProfile->workplaces as $workplace)
                                <div class="border-l-4 border-indigo-500 pl-4">
                                    <p class="font-semibold text-gray-900">{{ $workplace->company_name }}</p>
                                    <p class="text-gray-600">{{ $workplace->position }}</p>
                                    <p class="text-sm text-gray-500">{{ $workplace->start_date }} - {{ $workplace->end_date ?? 'Present' }}</p>
                                    <p class="text-gray-700 mt-2">{{ $workplace->description }}</p>
                                </div>
                            @empty
                                <p class="text-gray-600">No work experience available.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Additional Information -->
                    @if($jobseekerProfile->additional_info)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Additional Information</h3>
                            <p class="text-gray-700">{{ $jobseekerProfile->additional_info }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 