<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <h2
                class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-400 via-purple-400 to-indigo-400">
                Welcome, {{ Auth::user()->name }}! 👋
            </h2>

            <p
                class="text-sm font-semibold bg-clip-text text-transparent bg-gradient-to-r from-pink-400 via-purple-400 to-indigo-400 text-center">
                AISAT Library Management System 📚
            </p>

        </div>
    </x-slot>

    <div class="py-6 bg-gradient-to-br from-pink-100 via-indigo-100 to-purple-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Total Books -->
                <div class="bg-gradient-to-r from-indigo-400 to-purple-400 shadow-lg rounded-3xl p-8 text-white">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold">📚 Total Books</h3>
                        <span class="text-4xl font-bold">1,234</span>
                    </div>
                    <p class="mt-3 text-base opacity-80">All books in the library</p>
                </div>

                <!-- Borrowed Books -->
                <div class="bg-gradient-to-r from-pink-400 to-indigo-400 shadow-lg rounded-3xl p-8 text-white">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold">📝 Borrowed Books</h3>
                        <span class="text-4xl font-bold">256</span>
                    </div>
                    <p class="mt-3 text-base opacity-80">Books currently borrowed</p>
                </div>

                <!-- Registered Users -->
                <div class="bg-gradient-to-r from-green-400 to-teal-400 shadow-lg rounded-3xl p-8 text-white">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold">👤 Registered Users</h3>
                        <span class="text-4xl font-bold">542</span>
                    </div>
                    <p class="mt-3 text-base opacity-80">Students & staff</p>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- Recent Activity -->
                <div class="bg-white/60 backdrop-blur-2xl border border-white/40 shadow-md rounded-3xl p-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">Recent Activity</h3>
                    <ul class="space-y-3 text-gray-700 text-base">
                        <li>📖 John Doe borrowed "Digital Systems"</li>
                        <li>📖 Jane Smith returned "Web Development 101"</li>
                        <li>📖 Michael borrowed "Data Structures"</li>
                        <li>👤 New user registered: Emily Clark</li>
                    </ul>
                </div>

                <!-- Quick Actions -->
                <div
                    class="bg-white/60 backdrop-blur-2xl border border-white/40 shadow-md rounded-3xl p-8 flex flex-col gap-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Quick Actions</h3>
                    <div class="grid grid-cols-1 gap-4">
                        <a href="#"
                            class="block px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-500 hover:from-indigo-600 hover:to-purple-600 text-white font-semibold rounded-2xl shadow transition">
                            Add New Book 📚
                        </a>
                        <a href="#"
                            class="block px-6 py-4 bg-gradient-to-r from-pink-500 to-indigo-500 hover:from-pink-600 hover:to-indigo-600 text-white font-semibold rounded-2xl shadow transition">
                            View Borrowed Books 📝
                        </a>
                        <a href="#"
                            class="block px-6 py-4 bg-gradient-to-r from-green-500 to-teal-500 hover:from-green-600 hover:to-teal-600 text-white font-semibold rounded-2xl shadow transition">
                            Manage Users 👤
                        </a>
                        <a href="#"
                            class="block px-6 py-4 bg-gradient-to-r from-purple-500 to-indigo-500 hover:from-purple-600 hover:to-indigo-600 text-white font-semibold rounded-2xl shadow transition">
                            Generate Reports 📊
                        </a>
                    </div>
                </div>

            </div>

            <!-- Footer / Credits -->
            <p class="text-center text-sm text-gray-600 mt-6">
                © {{ date('Y') }} AISAT Library Management System
            </p>

        </div>
    </div>
</x-app-layout>
