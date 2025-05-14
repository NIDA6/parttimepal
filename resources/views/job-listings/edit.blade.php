<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">
                {{ __('Edit Job Listing') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('job-listings.update', $jobListing) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div>
                            <x-input-label for="title" :value="__('Job Title')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" 
                                :value="old('title', $jobListing->title)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Job Description')" />
                            <textarea id="description" name="description" 
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                                rows="4" required>{{ old('description', $jobListing->description) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <!-- Job Time -->
                        <div>
                            <x-input-label for="job_time" :value="__('Job Time')" />
                            <x-text-input id="job_time" name="job_time" type="text" class="mt-1 block w-full" 
                                :value="old('job_time', $jobListing->job_time)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('job_time')" />
                        </div>

                        <!-- Salary -->
                        <div>
                            <x-input-label for="salary" :value="__('Salary')" />
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <x-text-input id="salary" name="salary" type="number" step="0.01" min="0" max="99999999.99"
                                    class="pl-7 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                                    :value="old('salary', $jobListing->salary)" required />
                            </div>
                            <x-input-label for="salary" :value="__('Salary')" class="text-base font-semibold text-pink-600" />
                            <div class="mt-2 relative rounded-xl shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-pink-600 sm:text-sm font-medium">$</span>
                                </div>
                                <x-text-input id="salary" name="salary" type="text" 
                                    class="pl-8 block w-full rounded-xl border-indigo-200/50 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base bg-white/50 backdrop-blur-sm transition-all duration-200 hover:border-indigo-300 focus:shadow-md" 
                                    :value="old('salary', $jobListing->salary)" required />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('salary')" />
                        </div>

                        <!-- Requirements -->
                        <div>
                            <x-input-label for="requirements" :value="__('Requirements')" />
                            <textarea id="requirements" name="requirements" 
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                                rows="4" required>{{ old('requirements', $jobListing->requirements) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('requirements')" />
                        </div>

                        <!-- Responsibilities -->
                        <div>
                            <x-input-label for="responsibilities" :value="__('Responsibilities')" />
                            <textarea id="responsibilities" name="responsibilities" 
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                                rows="4" required>{{ old('responsibilities', $jobListing->responsibilities) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('responsibilities')" />
                        </div>

                        <!-- Additional Message -->
                        <div>
                            <x-input-label for="additional_message" :value="__('Additional Message (Optional)')" />
                            <textarea id="additional_message" name="additional_message" 
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                                rows="4">{{ old('additional_message', $jobListing->additional_message) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('additional_message')" />
                        </div>

                        

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update Job Listing') }}</x-primary-button>
                            <a href="{{ route('job-listings.show', $jobListing) }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors duration-200">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 