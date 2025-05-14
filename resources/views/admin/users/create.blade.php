<x-app-layout>
    <div class="min-h-screen bg-gray-100 py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Add New User</h2>
                        <p class="text-gray-600">Create a new user account with specific role</p>
                    </div>

                    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                        @csrf

                        <!-- Name -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" 
                                name="name" 
                                id="name" 
                                value="{{ old('name') }}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                placeholder="Enter user's full name"
                                required 
                                autofocus>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" 
                                name="email" 
                                id="email" 
                                value="{{ old('email') }}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                placeholder="Enter user's email address"
                                required>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div class="space-y-2">
                            <label for="role" class="block text-sm font-medium text-gray-700">User Role</label>
                            <select name="role" 
                                id="role" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                required>
                                <option value="">Select a role</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="jobseeker" {{ old('role') == 'jobseeker' ? 'selected' : '' }}>Jobseeker</option>
                                <option value="company" {{ old('role') == 'company' ? 'selected' : '' }}>Company</option>
                            </select>
                            @error('role')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" 
                                name="password" 
                                id="password" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                placeholder="Enter password"
                                required>
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="space-y-2">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                            <input type="password" 
                                name="password_confirmation" 
                                id="password_confirmation" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                placeholder="Confirm password"
                                required>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-end space-x-4 pt-6">
                            <button type="button" 
                                onclick="window.history.back()"
                                class="px-8 py-3 bg-sky-200 text-black text-lg font-semibold rounded-lg hover:bg-sky-300 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:ring-offset-2 transition duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-8 py-3 bg-sky-200 text-black text-lg font-semibold rounded-lg hover:bg-sky-300 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:ring-offset-2 transition duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                Create User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 