<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Company Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-3xl font-semibold text-center mb-6">
                        <span class="text-black">Edit Your</span> <span class="text-pink-600">Company Profile</span>
                    </h2>

                    <form method="POST" action="{{ route('company.profile.update') }}" class="bg-pink-100 p-6 rounded-lg" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Company Name -->
                        <div>
                            <x-input-label for="company_name" :value="__('Company Name')" class="text-gray-700" />
                            <x-text-input id="company_name" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm" type="text" name="company_name" :value="old('company_name', $profile->company_name)" required />
                            <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                        </div>

                        <!-- Phone -->
                        <div class="mt-4">
                            <x-input-label for="phone" :value="__('Phone Number')" class="text-gray-700" />
                            <x-text-input id="phone" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm" type="text" name="phone" :value="old('phone', $profile->phone_number)" required />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <!-- Address -->
                        <div class="mt-4">
                            <x-input-label for="address" :value="__('Company Address')" class="text-gray-700" />
                            <x-text-input id="address" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm" type="text" name="address" :value="old('address', $profile->location)" required />
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Company Description')" class="text-gray-700" />
                            <textarea id="description" name="description" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm" rows="4" required>{{ old('description', $profile->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Website -->
                        <div class="mt-4">
                            <x-input-label for="website" :value="__('Website (Optional)')" class="text-gray-700" />
                            <x-text-input id="website" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm" type="url" name="website" :value="old('website', $profile->website_url)" />
                            <x-input-error :messages="$errors->get('website')" class="mt-2" />
                        </div>

                        <!-- Establish Date -->
                        <div class="mt-4">
                            <x-input-label for="establish_date" :value="__('Establishment Date')" class="text-gray-700" />
                            <x-text-input id="establish_date" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm" type="date" name="establish_date" :value="old('establish_date', $profile->establish_date->format('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('establish_date')" class="mt-2" />
                        </div>

                        <!-- Social Media Links -->
                        <div class="mt-4">
                            <h3 class="text-lg font-medium text-gray-700 mb-2">Social Media Links (Optional)</h3>
                            <div id="social-media-container">
                                @if($profile->socialMedia->count() > 0)
                                    @foreach($profile->socialMedia as $index => $media)
                                        <div class="mb-4 p-4 bg-white rounded-lg border border-pink-100 social-media-entry">
                                            <div class="flex justify-between items-center mb-2">
                                                <h4 class="font-medium text-gray-700">Social Media</h4>
                                                <button type="button" class="text-pink-600 hover:text-pink-700" onclick="removeSocialMedia(this)">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div>
                                                <x-input-label for="url[]" :value="__('Social Media URL')" class="text-gray-700" />
                                                <x-text-input name="url[]" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm" type="url" :value="old('url.' . $index, $media->url)" placeholder="https://" />
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="mb-4 p-4 bg-white rounded-lg border border-pink-100 social-media-entry">
                                    <div class="flex justify-between items-center mb-2">
                                        <h4 class="font-medium text-gray-700">Social Media</h4>
                                        <button type="button" class="text-pink-600 hover:text-pink-700" onclick="removeSocialMedia(this)">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div>
                                        <x-input-label for="url[]" :value="__('Social Media URL')" class="text-gray-700" />
                                        <x-text-input name="url[]" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm" type="url" placeholder="https://" />
                                    </div>
                                </div>
                            </div>
                            <button type="button" onclick="addSocialMedia()" class="mt-2 text-pink-600 hover:text-pink-700 flex items-center">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add Social Media
                            </button>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="bg-white hover:bg-pink-50 text-black border-pink-100">
                                {{ __('Update Profile') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addSocialMedia() {
            const container = document.getElementById('social-media-container');
            const template = container.querySelector('.social-media-entry').cloneNode(true);
            
            // Clear the values
            template.querySelector('input[type="url"]').value = '';
            
            container.appendChild(template);
        }

        function removeSocialMedia(button) {
            const container = document.getElementById('social-media-container');
            if (container.children.length > 1) {
                button.closest('.social-media-entry').remove();
            }
        }
    </script>
</x-guest-layout> 