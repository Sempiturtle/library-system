<nav x-data="{ open: false }"
    class="bg-white/70 backdrop-blur-xl border-b border-gray-200 shadow-md sticky top-0 z-50 font-poppins">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- Left: Logo / Brand -->
            <div class="flex items-center">
                <div
                    class="text-2xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-pink-400 via-purple-400 to-indigo-400">
                    📚 AISAT Library
                </div>
            </div>

            <!-- Center: Navigation Links -->
            <div class="hidden sm:flex sm:items-center sm:space-x-6">
                @php
                    $dashboardRoute =
                        Auth::user()->usertype === 'admin' ? route('admin.dashboard') : route('student.dashboard'); // student dashboard
                @endphp

                <x-nav-link :href="$dashboardRoute" :active="request()->routeIs('student.dashboard') || request()->routeIs('admin.dashboard')"
                    class="relative px-3 py-2 rounded-md text-gray-700 hover:text-white hover:bg-indigo-500 transition-colors duration-200 font-medium">
                    Dashboard
                    @if (request()->routeIs('dashboard') || request()->routeIs('admin.dashboard'))
                        <span class="absolute bottom-0 left-0 w-full h-1 bg-indigo-500 rounded-t-full"></span>
                    @endif
                </x-nav-link>
            </div>


            <!-- Right: User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 shadow transition">
                            <div class="font-semibold">{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')"
                            class="text-gray-700 hover:bg-purple-100 hover:text-purple-700 font-medium">
                            Profile
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger Menu -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Responsive Navigation -->
    <div :class="{ 'block': open, 'hidden': !open }"
        class="hidden sm:hidden bg-white/80 backdrop-blur-xl border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('student.dashboard')" :active="request()->routeIs('student.dashboard')" class="px-4 py-2 font-medium">
                Dashboard
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="px-4 py-2 font-medium">
                    Profile
                </x-responsive-nav-link>
            </div>
        </div>
    </div>
</nav>
