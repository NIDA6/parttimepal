<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">
                {{ __('Browse') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form action="{{ route('browse.index') }}" method="GET" class="space-y-4">
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <input type="text" name="search" value="{{ $search }}" 
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       placeholder="Search by name, skills, company, education...">
                            </div>
                            <div>
                                <select name="type" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="all" {{ $type === 'all' ? 'selected' : '' }}>All</option>
                                    <option value="companies" {{ $type === 'companies' ? 'selected' : '' }}>Companies</option>
                                    <option value="jobseekers" {{ $type === 'jobseekers' ? 'selected' : '' }}>Jobseekers</option>
                                </select>
                            </div>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                                Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Results -->
            <div class="grid grid-cols-1 gap-6">
                @if(empty($search))
                    <div class="text-center py-8 bg-white rounded-lg shadow">
                        <p class="text-gray-600">Please enter a search term to find companies and jobseekers.</p>
                    </div>
                @else
                    @if($type === 'all' || $type === 'companies')
                        @forelse($companies as $company)
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-semibold text-indigo-900">
                                                <a href="{{ route('browse.company', $company->id) }}" class="hover:text-indigo-700">
                                                    {{ $company->companyProfile->company_name }}
                                                </a>
                                            </h3>
                                            <p class="text-sm text-gray-600 mt-1">{{ $company->companyProfile->location }}</p>
                                            <p class="text-gray-700 mt-2 line-clamp-2">{{ $company->companyProfile->description }}</p>
                                        </div>
                                        <div class="text-right">
                                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm">
                                                Company
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            @if($type === 'companies')
                                <div class="text-center py-8 bg-white rounded-lg shadow">
                                    <p class="text-gray-600">No companies found.</p>
                                </div>
                            @endif
                        @endforelse
                    @endif

                    @if($type === 'all' || $type === 'jobseekers')
                        @forelse($jobseekers as $jobseeker)
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-semibold text-indigo-900">
                                                <a href="{{ route('browse.jobseeker', $jobseeker->id) }}" class="hover:text-indigo-700">
                                                    {{ $jobseeker->name }}
                                                </a>
                                            </h3>
                                            <p class="text-sm text-gray-600 mt-1">{{ $jobseeker->jobseekerProfile->address }}</p>
                                            <div class="mt-2 flex flex-wrap gap-2">
                                                @foreach(explode(',', $jobseeker->jobseekerProfile->skills) as $skill)
                                                    <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm">
                                                        {{ trim($skill) }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="px-3 py-1 bg-pink-100 text-pink-800 rounded-full text-sm">
                                                Jobseeker
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            @if($type === 'jobseekers')
                                <div class="text-center py-8 bg-white rounded-lg shadow">
                                    <p class="text-gray-600">No jobseekers found.</p>
                                </div>
                            @endif
                        @endforelse
                    @endif

                    @if($type === 'all' && $companies->isEmpty() && $jobseekers->isEmpty())
                        <div class="text-center py-8 bg-white rounded-lg shadow">
                            <p class="text-gray-600">No results found.</p>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-app-layout> 