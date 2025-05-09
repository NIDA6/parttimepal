<x-guest-layout>
    <!-- Session Status -->
    <h2 class="text-3xl font-semibold text-center mb-6">
        <span class="text-black">Log</span><span class="text-pink-600">in</span>
    </h2>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="bg-pink-100 p-6 rounded-lg">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
            <x-text-input id="email" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700" />

            <x-text-input id="password" class="block mt-1 w-full border-pink-100 bg-white focus:border-pink-200 focus:ring focus:ring-pink-100 focus:ring-opacity-50 rounded-md shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-pink-100 bg-white text-pink-600 shadow-sm focus:ring-pink-200" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
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
                <label class="inline-flex items-center">
                    <input type="radio" name="role" value="Admin" class="form-radio text-pink-600 border-pink-100 bg-white">
                    <span class="ml-2 text-gray-700">Admin</span>
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>
        <div class="flex items-center justify-end mt-4">
            <div class="flex items-center space-x-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-pink-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-200" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
                <a class="underline text-sm text-gray-600 hover:text-pink-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-200" href="{{ route('register') }}">
                    {{ __('New User?') }}
                </a>
            </div>
            <x-primary-button class="ms-3 bg-white hover:bg-pink-50 text-black border-pink-100">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
