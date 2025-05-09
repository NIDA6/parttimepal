<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post New Job') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('job-posts.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="title" :value="__('Job Title')" />
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="job_time" :value="__('Job Time')" />
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('job_time')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Job Description')" />
                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4" required></textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="requirements" :value="__('Requirements')" />
                            <textarea id="requirements" name="requirements" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4" required></textarea>
                            <x-input-error :messages="$errors->get('requirements')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="responsibilities" :value="__('Responsibilities')" />
                            <textarea id="responsibilities" name="responsibilities" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4" required></textarea>
                            <x-input-error :messages="$errors->get('responsibilities')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="salary" :value="__('Salary')" />
                                <x-text-input id="salary" name="salary" type="number" step="0.01" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('salary')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="application_link" :value="__('Application Link')" />
                                <x-text-input id="application_link" name="application_link" type="url" class="mt-1 block w-full" required placeholder="https://example.com/apply" />
                                <x-input-error :messages="$errors->get('application_link')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="additional_message" :value="__('Additional Message (Optional)')" />
                            <textarea id="additional_message" name="additional_message" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4"></textarea>
                            <x-input-error :messages="$errors->get('additional_message')" class="mt-2" />
                        </div>

                        <div class="flex justify-end gap-4">
                            <x-primary-button>{{ __('Post Job') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 