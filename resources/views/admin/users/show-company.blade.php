<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Company Details</h2>
                        <a href="{{ route('admin.companies') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200">
                            Back to List
                        </a>
                    </div>

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if($companyProfile)
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Company Name</p>
                                <p class="font-medium">{{ $companyProfile->company_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Email</p>
                                <p class="font-medium">{{ $companyProfile->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Phone</p>
                                <p class="font-medium">{{ $companyProfile->phone }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Location</p>
                                <p class="font-medium">{{ $companyProfile->location }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Establish Date</p>
                                <p class="font-medium">{{ $companyProfile->establish_date ? $companyProfile->establish_date->format('M d, Y') : 'N/A' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-sm text-gray-600">Description</p>
                                <p class="font-medium">{{ $companyProfile->description }}</p>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <p class="text-gray-500">No company profile information available.</p>
                        @if(config('app.debug'))
                            <div class="mt-4 p-4 bg-gray-100 rounded">
                                <p class="text-sm text-gray-600">Debug Information:</p>
                                <p class="text-sm">User ID: {{ $user->id }}</p>
                                <p class="text-sm">User Role: {{ $user->role }}</p>
                                <p class="text-sm">Has Company Profile: {{ $user->companyProfile ? 'Yes' : 'No' }}</p>
                            </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 