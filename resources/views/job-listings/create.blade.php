<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-3xl text-pink-600 tracking-tight">
                {{ __('Post New Job') }}
            </h2>
            
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border border-indigo-100/50 backdrop-blur-sm">
                <div class="p-10">
                    <form method="POST" action="{{ route('job-listings.store') }}" class="space-y-10">
                        @csrf

                        <!-- Basic Information Section -->
                        <div class="bg-gradient-to-br from-indigo-50/80 via-purple-50/80 to-pink-50/80 p-8 rounded-2xl border border-indigo-200/50 shadow-lg backdrop-blur-sm transition-all duration-300 hover:shadow-xl">
                            <h3 class="text-xl font-bold text-pink-600 mb-8 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Basic Information
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Job Title -->
                                <div>
                                    <x-input-label for="title" :value="__('Job Title')" class="text-base font-semibold text-pink-600" />
                                    <x-text-input id="title" name="title" type="text" 
                                        class="mt-2 block w-full rounded-xl border-indigo-700/70 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base bg-white/50 backdrop-blur-sm transition-all duration-200 hover:border-indigo-300 focus:shadow-md" 
                                        :value="old('title')" required autofocus 
                                        placeholder="e.g., Senior Software Engineer" />
                                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                                </div>

                                <!-- Job Time -->
                                <div>
                                    <x-input-label for="job_time" :value="__('Job Time')" class="text-base font-semibold text-pink-600" />
                                    <x-text-input id="job_time" name="job_time" type="text" 
                                        class="mt-2 block w-full rounded-xl border-indigo-700/70 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base bg-white/50 backdrop-blur-sm transition-all duration-200 hover:border-indigo-300 focus:shadow-md"
                                        :value="old('job_time')" required/>
                                    <x-input-error class="mt-2" :messages="$errors->get('job_time')" />
                                </div>

                                <!-- Salary -->
                                <div>
                                    <x-input-label for="salary" :value="__('Annual Salary')" class="text-base font-semibold text-pink-600" />
                                    <div class="mt-2 relative rounded-xl shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <span class="text-pink-600 sm:text-sm font-medium">$</span>
                                        </div>
                                        <x-text-input id="salary" name="salary" type="number" step="0.01" min="0" max="99999999.99"
                                            class="pl-8 block w-full rounded-xl border-indigo-200/50 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base bg-white/50 backdrop-blur-sm transition-all duration-200 hover:border-indigo-300 focus:shadow-md" 
                                            :value="old('salary')" required 
                                            placeholder="e.g., 75000.00" />
                                    </div>
                                    <x-input-label for="salary" :value="__('Salary')" class="text-base font-semibold text-pink-600" />
                                    <x-text-input id="salary" name="salary" type="text" 
                                        class="mt-2 block w-full rounded-xl border-indigo-200/50 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base bg-white/50 backdrop-blur-sm transition-all duration-200 hover:border-indigo-300 focus:shadow-md" 
                                        :value="old('salary')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('salary')" />
                                </div>

                                <!-- Application Link -->
                                <div>
                                    <x-input-label for="application_link" :value="__('Application Link')" class="text-base font-semibold text-pink-600" />
                                    <x-text-input id="application_link" name="application_link" type="url" 
                                        class="mt-2 block w-full rounded-xl border-indigo-700/70 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base bg-white/50 backdrop-blur-sm transition-all duration-200 hover:border-indigo-300 focus:shadow-md"
                                        :value="old('application_link')" required placeholder="https://example.com/apply" />
                                    <x-input-error class="mt-2" :messages="$errors->get('application_link')" />
                                </div>
                            </div>
                        </div>

                        <!-- Detailed Information Section -->
                        <div class="bg-gradient-to-br from-indigo-50/80 via-purple-50/80 to-pink-50/80 p-8 rounded-2xl border border-indigo-200/50 shadow-lg backdrop-blur-sm transition-all duration-300 hover:shadow-xl">
                            <h3 class="text-xl font-bold text-indigo-900 mb-8 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Detailed Information
                            </h3>
                            <div class="space-y-8">
                                <!-- Job Description -->
                                <div>
                                    <x-input-label for="description" :value="__('Job Description')" class="text-base font-semibold text-pink-600" />
                                    <textarea id="description" name="description" rows="6" 
                                        class="mt-2 block w-full rounded-xl border-indigo-200/50 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base bg-white/50 backdrop-blur-sm transition-all duration-200 hover:border-indigo-300 focus:shadow-md resize-none" 
                                        required placeholder="Provide a detailed description of the job, including the role's purpose and impact">{{ old('description') }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                                </div>

                                <!-- Requirements -->
                                <div>
                                    <x-input-label for="requirements" :value="__('Requirements')" class="text-base font-semibold text-pink-600" />
                                    <textarea id="requirements" name="requirements" rows="6" 
                                        class="mt-2 block w-full rounded-xl border-indigo-200/50 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base bg-white/50 backdrop-blur-sm transition-all duration-200 hover:border-indigo-300 focus:shadow-md resize-none" 
                                        required placeholder="List the required skills, qualifications, and experience">{{ old('requirements') }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('requirements')" />
                                </div>

                                <!-- Responsibilities -->
                                <div>
                                    <x-input-label for="responsibilities" :value="__('Responsibilities')" class="text-base font-semibold text-pink-600" />
                                    <textarea id="responsibilities" name="responsibilities" rows="6" 
                                        class="mt-2 block w-full rounded-xl border-indigo-200/50 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base bg-white/50 backdrop-blur-sm transition-all duration-200 hover:border-indigo-300 focus:shadow-md resize-none" 
                                        required placeholder="Describe the main responsibilities and duties of the role">{{ old('responsibilities') }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('responsibilities')" />
                                </div>

                                <!-- Additional Information -->
                                <div>
                                    <x-input-label for="additional_message" :value="__('Additional Information')" class="text-base font-semibold text-pink-600" />
                                    <textarea id="additional_message" name="additional_message" rows="4" 
                                        class="mt-2 block w-full rounded-xl border-indigo-200/50 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base bg-white/50 backdrop-blur-sm transition-all duration-200 hover:border-indigo-300 focus:shadow-md resize-none" 
                                        placeholder="Add any additional information about the job, such as benefits, work environment, or company culture">{{ old('additional_message') }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('additional_message')" />
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end space-x-4 pt-8 border-t border-indigo-200/50">
                            <a href="{{ route('dashboard') }}" 
                                class="inline-flex items-center px-8 py-3 text-base font-semibold rounded-xl text-pink-600 hover:bg-indigo-50/80 transition-all duration-200 hover:shadow-md">
                                {{ __('Cancel') }}
                            </a>
                            <x-primary-button 
                                class="px-8 py-3 text-base font-semibold rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-[1.02]">
                                {{ __('Post Job') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 