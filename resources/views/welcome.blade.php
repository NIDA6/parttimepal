<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to PartTimePal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <!-- Header -->
    

    <header class="bg-pink-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex-1"></div>
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold">
                        <span class="text-black">Part</span><span class="text-pink-600">time</span><span class="text-black">Pal</span>
                    </h1>
                </div>
                <div class="flex-1 flex justify-end items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                    @else
                            <a href="{{ route('login') }}" class="text-black hover:text-pink-600">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-black hover:text-pink-600">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="min-h-screen bg-gray-100 flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-96">
            <h2 class="text-2xl font-bold text-center mb-6">
                <span class="text-black">Welcome to </span><span class="text-pink-600">Parttime</span><span class="text-black">Pal</span>
            </h2>
            <p class="text-gray-600 text-center mb-8">Your one-stop solution for part-time job opportunities</p>
            <div class="space-y-4">
                <a href="{{ route('login') }}" class="block w-full bg-pink-100 hover:bg-pink-200 text-black font-bold py-3 px-4 rounded text-center transition duration-300">
                    Login
                </a>
                <a href="{{ route('register') }}" class="block w-full bg-pink-100 hover:bg-pink-200 text-black font-bold py-3 px-4 rounded text-center transition duration-300">
                    Register
                </a>
            </div>
        </div>
    </div>
</body>
</html>
