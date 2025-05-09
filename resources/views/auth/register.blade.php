<x-guest-layout>
    <h2 class="text-3xl font-semibold text-center mb-6">
        <span class="text-black">Reg</span><span class="text-pink-600">ister</span>
    </h2>
    <form method="POST" action="{{ route('register') }}" class="bg-pink-100 p-6 rounded-lg">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-gray-700" />
            <x-text-input id="name" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
            <x-text-input id="email" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700" />

            <x-text-input id="password" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-4">
            <div class="flex space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="role" value="Jobseeker" class="form-radio text-pink-600 border-pink-100 bg-white" required>
                    <span class="ml-2 text-gray-700">Jobseeker</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="role" value="Company" class="form-radio text-pink-600 border-pink-100 bg-white">
                    <span class="ml-2 text-gray-700">Company</span>
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>
        

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-pink-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-200" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4 bg-white hover:bg-pink-50 text-black border-pink-100">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
