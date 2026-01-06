<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ZIP API Client') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="bg-white dark:bg-black">
        <!-- Header Navigation -->
        <header class="border-b border-gray-200 dark:border-gray-700">
            <nav class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
                <div class="text-2xl font-bold text-gray-900 dark:text-neutral-100">
                    ZIP Manager
                </div>
                <div class="flex gap-4 items-center text-black">
                    @if (Route::has('login'))
                    @if ($auth->check)
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                        Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                            Logout
                        </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 dark:text-neutral-100 hover:text-gray-400 dark:hover:gray-400">
                        Login
                    </a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Register
                    </a>
                    @endif
                    @endif
                    @endif
                </div>
            </nav>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-6 py-16">
            <!-- Hero Section -->
            <div class="text-center mb-16">
                <h1 class="text-5xl font-bold text-gray-900 dark:text-white mb-4">
                    ZIP Code Management System
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-400 mb-8">
                    Manage counties and cities with ease. Search, browse, and export ZIP code data.
                </p>
            </div>

            <!-- Features Grid -->
            <div class="grid md:grid-cols-3 gap-8 mb-12">
                <!-- Counties Card -->
                <div class="p-2 bg-gray-50 dark:bg-gray-900 rounded-lg p-8 border border-gray-200 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        Counties
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Browse and manage all available counties in the system.
                    </p>
                    <a href="{{ route('counties.index') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        View Counties
                    </a>
                </div>

                <!-- Cities Card -->
                <div class="p-2 bg-gray-50 dark:bg-gray-900 rounded-lg p-8 border border-gray-200 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        Cities
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Search and browse cities by name or postal code.
                    </p>
                    <a href="{{ route('cities.filter') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Search Cities
                    </a>
                </div>

                <!-- Export Card -->
                <div class="p-2 bg-gray-50 dark:bg-gray-900 rounded-lg p-8 border border-gray-200 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        Export Data
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Export counties and cities data to CSV or PDF formats.
                    </p>
                    <div class="flex gap-2">
                        <a href="{{ route('export.counties.csv') }}" class="flex-1 px-4 py-2 bg-emerald-600 dark:bg-emerald-600 text-white rounded-lg hover:bg-green-700 text-center text-sm">
                            CSV
                        </a>
                        <a href="{{ route('export.counties.pdf') }}" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-center text-sm">
                            PDF
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg p-8 text-white text-center">
                <h2 class="text-2xl font-bold mb-4">Welcome to ZIP Manager</h2>
                <p class="text-blue-100 max-w-2xl mx-auto">
                    A comprehensive platform for managing and exploring postal code data. Access detailed information about counties and cities, perform searches, and export data in multiple formats.
                </p>
            </div>
        </main>

        <!-- Footer -->
        <footer class="border-t border-gray-200 dark:border-gray-700 mt-16">
            <div class="max-w-7xl mx-auto px-6 py-8 text-center text-gray-600 dark:text-gray-400">
                <p>&copy; 2025 ZIP Code Management System. All rights reserved.</p>
            </div>
        </footer>
    </div>
</body>

</html>