<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-3xl font-semibold text-center mb-6">
                        <span class="text-black">{{ $profile ? 'Edit Your' : 'Complete Your' }}</span> <span class="text-pink-600">Profile</span>
                    </h2>

                    <form method="POST" action="{{ $profile ? route('jobseeker.profile.update') : route('jobseeker.profile.store') }}" class="bg-pink-100 p-6 rounded-lg">
                        @csrf
                        @if($profile)
                            @method('PUT')
                        @endif

                        <!-- Basic Information -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="name" :value="__('Name')" class="text-gray-700" />
                                    <x-text-input id="name" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm" type="text" value="{{ $user->name }}" disabled />
                                </div>
                                <div>
                                    <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
                                    <x-text-input id="email" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm" type="email" value="{{ $user->email }}" disabled />
                                </div>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div>
                            <x-input-label for="phone" :value="__('Phone Number')" class="text-gray-700" />
                            <x-text-input id="phone" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm" type="text" name="phone" :value="old('phone', $profile?->phone)" required />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <!-- Address -->
                        <div class="mt-4">
                            <x-input-label for="address" :value="__('Address')" class="text-gray-700" />
                            <x-text-input id="address" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm" type="text" name="address" :value="old('address', $profile?->address)" required />
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <!-- Skills -->
                        <div class="mt-4">
                            <x-input-label for="skills" :value="__('Skills')" class="text-gray-700" />
                            <textarea id="skills" name="skills" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm" rows="3">{{ old('skills', $profile?->skills) }}</textarea>
                            <x-input-error :messages="$errors->get('skills')" class="mt-2" />
                        </div>

                        <!-- Education Section -->
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Education</h3>
                            
                            <!-- School -->
                            <div class="mb-4 p-4 bg-white rounded-lg border border-pink-100">
                                <h4 class="font-medium text-gray-700 mb-2">School</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="school_name" :value="__('School Name')" class="text-gray-700" />
                                        <x-text-input id="school_name" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm" type="text" name="school_name" :value="old('school_name', $education?->whereNotNull('school_name')->first()?->school_name)" />
                                    </div>
                                    <div>
                                        <x-input-label for="school_year" :value="__('Year')" class="text-gray-700" />
                                        <x-text-input id="school_year" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm" type="text" name="school_year" :value="old('school_year', $education?->whereNotNull('school_name')->first()?->school_year)" />
                                    </div>
                                </div>
                            </div>

                            <!-- College -->
                            <div class="mb-4 p-4 bg-white rounded-lg border border-pink-100">
                                <h4 class="font-medium text-gray-700 mb-2">College</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="college_name" :value="__('College Name')" class="text-gray-700" />
                                        <x-text-input id="college_name" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm" type="text" name="college_name" :value="old('college_name', $education?->whereNotNull('college_name')->first()?->college_name)" />
                                    </div>
                                    <div>
                                        <x-input-label for="college_year" :value="__('Year')" class="text-gray-700" />
                                        <x-text-input id="college_year" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm" type="text" name="college_year" :value="old('college_year', $education?->whereNotNull('college_name')->first()?->college_year)" />
                                    </div>
                                </div>
                            </div>

                            <!-- Universities -->
                            <div id="universities-container">
                                @if($education && $education->whereNotNull('university_name')->count() > 0)
                                    @foreach($education->whereNotNull('university_name') as $index => $edu)
                                        <div class="mb-4 p-4 bg-white rounded-lg border border-pink-100 university-entry">
                                            <div class="flex justify-between items-center mb-2">
                                                <h4 class="font-medium text-gray-700">University</h4>
                                                <button type="button" class="text-pink-600 hover:text-pink-700" onclick="removeUniversity(this)">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <x-input-label for="university_name[]" :value="__('University Name')" class="text-gray-700" />
                                                    <x-text-input name="university_name[]" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm" type="text" :value="$edu->university_name" />
                                                </div>
                                                <div>
                                                    <x-input-label for="university_year[]" :value="__('Year')" class="text-gray-700" />
                                                    <x-text-input name="university_year[]" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm" type="text" :value="$edu->university_year" />
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="mb-4 p-4 bg-white rounded-lg border border-pink-100 university-entry">
                                        <div class="flex justify-between items-center mb-2">
                                            <h4 class="font-medium text-gray-700">University</h4>
                                            <button type="button" class="text-pink-600 hover:text-pink-700" onclick="removeUniversity(this)">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <x-input-label for="university_name[]" :value="__('University Name')" class="text-gray-700" />
                                                <x-text-input name="university_name[]" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm" type="text" />
                                            </div>
                                            <div>
                                                <x-input-label for="university_year[]" :value="__('Year')" class="text-gray-700" />
                                                <x-text-input name="university_year[]" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm" type="text" />
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="button" onclick="addUniversity()" class="mt-2 text-pink-600 hover:text-pink-700 flex items-center">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add Another University
                            </button>
                        </div>

                        <!-- Work Experience Section -->
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Work Experience</h3>
                            <div id="workplaces-container">
                                @if($workplaces && $workplaces->count() > 0)
                                    @foreach($workplaces as $workplace)
                                        <div class="mb-4 p-4 bg-white rounded-lg border border-pink-100 workplace-entry">
                                            <div class="flex justify-between items-center mb-2">
                                                <h4 class="font-medium text-gray-700">Workplace</h4>
                                                <button type="button" class="text-pink-600 hover:text-pink-700" onclick="removeWorkplace(this)">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <x-input-label for="workplace_name[]" :value="__('Company Name')" class="text-gray-700" />
                                                    <x-text-input name="workplace_name[]" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm" type="text" :value="$workplace->company_name" />
                                                </div>
                                                <div>
                                                    <x-input-label for="workplace_designation[]" :value="__('Designation')" class="text-gray-700" />
                                                    <x-text-input name="workplace_designation[]" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm" type="text" :value="$workplace->designation" />
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="mb-4 p-4 bg-white rounded-lg border border-pink-100 workplace-entry">
                                        <div class="flex justify-between items-center mb-2">
                                            <h4 class="font-medium text-gray-700">Workplace</h4>
                                            <button type="button" class="text-pink-600 hover:text-pink-700" onclick="removeWorkplace(this)">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <x-input-label for="workplace_name[]" :value="__('Company Name')" class="text-gray-700" />
                                                <x-text-input name="workplace_name[]" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm" type="text" />
                                            </div>
                                            <div>
                                                <x-input-label for="workplace_designation[]" :value="__('Designation')" class="text-gray-700" />
                                                <x-text-input name="workplace_designation[]" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm" type="text" />
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="button" onclick="addWorkplace()" class="mt-2 text-pink-600 hover:text-pink-700 flex items-center">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add Another Workplace
                            </button>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="bg-white hover:bg-pink-50 text-black border-pink-100">
                                {{ $profile ? __('Update Profile') : __('Complete Profile') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
function addUniversity() {
    const container = document.getElementById('universities-container');
    const template = container.querySelector('.university-entry').cloneNode(true);
    template.querySelectorAll('input').forEach(input => input.value = '');
    container.appendChild(template);
}

function removeUniversity(button) {
    const container = document.getElementById('universities-container');
    if (container.children.length > 1) {
        button.closest('.university-entry').remove();
    }
}

function addWorkplace() {
    const container = document.getElementById('workplaces-container');
    const template = container.querySelector('.workplace-entry').cloneNode(true);
    template.querySelectorAll('input').forEach(input => input.value = '');
    container.appendChild(template);
}

function removeWorkplace(button) {
    const container = document.getElementById('workplaces-container');
    if (container.children.length > 1) {
        button.closest('.workplace-entry').remove();
    }
}
</script> 