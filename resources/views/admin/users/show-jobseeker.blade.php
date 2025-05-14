<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Jobseeker Details</h2>
                        <div class="space-x-4">
                            <a href="{{ route('admin.jobseekers') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200">
                                Back to List
                            </a>
                            <form action="{{ route('admin.jobseekers.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this jobseeker? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200">Delete Jobseeker</button>
                            </form>
                        </div>
                    </div>

                    <!-- Profile Information -->
                    @if($user->jobseekerProfile)
                    <div class="bg-gray-50 p-6 rounded-lg mb-6">
                        <h3 class="text-lg font-semibold mb-4">Profile Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Phone</p>
                                <p class="font-medium">{{ $user->jobseekerProfile->phone ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Address</p>
                                <p class="font-medium">{{ $user->jobseekerProfile->address ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Skills</p>
                                <p class="font-medium">{{ $user->jobseekerProfile->skills ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Resume</p>
                                @if($user->jobseekerProfile->resume)
                                    <a href="{{ asset('storage/' . $user->jobseekerProfile->resume) }}" target="_blank" class="text-blue-600 hover:text-blue-800">View Resume</a>
                                @else
                                    <p class="font-medium">No resume uploaded</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Education Information -->
                    @if($user->jobseekerProfile && $user->jobseekerProfile->education)
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Education Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Education Level</p>
                                <p class="font-medium">{{ $user->jobseekerProfile->education->first()->level ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Field of Study</p>
                                <p class="font-medium">{{ $user->jobseekerProfile->education->first()->field_of_study ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Institution</p>
                                <p class="font-medium">{{ $user->jobseekerProfile->education->first()->institution ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Graduation Year</p>
                                <p class="font-medium">{{ $user->jobseekerProfile->education->first()->graduation_year ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 