<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div class="flex flex-col items-center">
                                    <div class="h-12 w-12 rounded-full bg-pink-100 flex items-center justify-center shadow-sm">
                                        <span class="text-pink-600 font-semibold text-lg">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <span class="text-sm text-gray-600 mt-1">{{ auth()->user()->name }}</span>
                                </div>

                                <div class="ms-2">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            @php
                                $user = Auth::user();
                                $hasProfile = $user->jobseekerProfile;
                                $role = $user->role;
                                
                                // Debug information
                                $debugInfo = [
                                    'role' => $role,
                                    'hasProfile' => $hasProfile ? 'Yes' : 'No',
                                    'userId' => $user->id
                                ];
                            @endphp

                            @if($role === 'Jobseeker')
                                @if($hasProfile)
                                    <x-dropdown-link :href="route('jobseeker.profile.edit')">
                                        {{ __('Edit Profile') }}
                                    </x-dropdown-link>
                                @else
                                    <x-dropdown-link :href="route('jobseeker.profile.create')">
                                        {{ __('Create Profile') }}
                                    </x-dropdown-link>
                                @endif
                            @elseif($role === 'Company')
                                <x-dropdown-link :href="$user->companyProfile ? route('company.profile.edit') : route('company.profile.create')">
                                    {{ __('Edit Profile') }}
                                </x-dropdown-link>
                            @endif

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" class="w-full p-0 m-0">
                                @csrf
                                <button type="submit" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:text-gray-900 focus:outline-none focus:text-gray-900 transition duration-150 ease-in-out">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-gray-900">Login</a>
                        <a href="{{ route('register') }}" class="text-sm text-gray-700 hover:text-gray-900">Register</a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="flex flex-col items-center">
                    <div class="h-16 w-16 rounded-full bg-pink-100 flex items-center justify-center shadow-sm">
                        <span class="text-pink-600 font-semibold text-xl">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </span>
                    </div>
                    <div class="font-medium text-base text-gray-800 mt-2">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if(Auth::user()->role === 'Jobseeker')
                    <x-responsive-nav-link :href="Auth::user()->jobseekerProfile ? route('jobseeker.profile.edit') : route('jobseeker.profile.create')">
                        {{ __('Edit Profile') }}
                    </x-responsive-nav-link>
                @elseif(Auth::user()->role === 'Company')
                    <x-responsive-nav-link :href="Auth::user()->companyProfile ? route('company.profile.edit') : route('company.profile.create')">
                        {{ __('Edit Profile') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" class="w-full p-0 m-0">
                    @csrf
                    <button type="submit" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:text-gray-900 focus:outline-none focus:text-gray-900 transition duration-150 ease-in-out">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
