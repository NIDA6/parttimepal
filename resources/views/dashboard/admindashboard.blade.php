<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Notification and Report Bar -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4">
                    <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                        <!-- Notifications -->
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <button class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    <span>Notifications</span>
                                    @if(isset($unreadNotifications) && $unreadNotifications > 0)
                                        <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                                            {{ $unreadNotifications }}
                                        </span>
                                    @endif
                                </button>
                            </div>
                            <div class="relative">
                                <button class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Reports</span>
                                </button>
                            </div>
                        </div>

                        <!-- Quick Stats -->
                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                <span>Active Users: {{ $activeUsers ?? 0 }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Last Updated: {{ now()->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Dashboard Content -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-semibold mb-6">Admin Dashboard</h1>
                    
                    <!-- Stats Overview -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-blue-100 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-blue-800">Total Users</h3>
                            <p class="text-3xl font-bold text-blue-600">{{ $totalUsers ?? 0 }}</p>
                        </div>
                        <div class="bg-green-100 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-green-800">Total Jobs</h3>
                            <p class="text-3xl font-bold text-green-600">{{ $totalJobs ?? 0 }}</p>
                        </div>
                        <div class="bg-purple-100 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-purple-800">Total Companies</h3>
                            <p class="text-3xl font-bold text-purple-600">{{ $totalCompanies ?? 0 }}</p>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-gray-50 p-6 rounded-lg mb-8">
                        <h2 class="text-xl font-semibold mb-4">Recent Activity</h2>
                        <div class="space-y-4">
                            @forelse($recentActivities ?? [] as $activity)
                                <div class="flex items-center justify-between border-b pb-2">
                                    <div>
                                        <p class="font-medium">{{ $activity->description }}</p>
                                        <p class="text-sm text-gray-500">{{ $activity->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500">No recent activity</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white border rounded-lg p-6">
                            <h2 class="text-xl font-semibold mb-4">User Management</h2>
                            <div class="space-y-2">
                                <a href="#" class="block text-blue-600 hover:text-blue-800">View All Users</a>
                                <a href="#" class="block text-blue-600 hover:text-blue-800">Manage User Roles</a>
                                <a href="#" class="block text-blue-600 hover:text-blue-800">User Reports</a>
                            </div>
                        </div>
                        <div class="bg-white border rounded-lg p-6">
                            <h2 class="text-xl font-semibold mb-4">System Settings</h2>
                            <div class="space-y-2">
                                <a href="#" class="block text-blue-600 hover:text-blue-800">General Settings</a>
                                <a href="#" class="block text-blue-600 hover:text-blue-800">Email Templates</a>
                                <a href="#" class="block text-blue-600 hover:text-blue-800">System Logs</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 