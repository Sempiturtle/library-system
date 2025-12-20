<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AISAT Library</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-indigo-900 via-purple-900 to-slate-900 text-white min-h-screen">

    <!-- Navbar -->
    <nav class="flex items-center justify-between px-10 py-6">
        <h1 class="text-2xl font-bold tracking-wide">
            📚 AISAT <span class="text-indigo-400">Library</span>
        </h1>
        <div class="space-x-4">
            @auth
                <a href="{{ route('student.dashboard') }}"
                   class="px-5 py-2 rounded-full bg-indigo-500 hover:bg-indigo-600 transition shadow-lg">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="px-5 py-2 rounded-full border border-indigo-400 hover:bg-indigo-500/20 transition">
                    Login
                </a>
                <a href="{{ route('register') }}"
                   class="px-5 py-2 rounded-full bg-indigo-500 hover:bg-indigo-600 transition shadow-lg">
                    Register
                </a>
            @endauth
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="flex flex-col items-center justify-center text-center px-6 mt-24">
        <div class="max-w-3xl">
            <h2 class="text-5xl font-extrabold leading-tight mb-6">
                Welcome to the
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 to-pink-400">
                    AISAT Library
                </span>
            </h2>

            <p class="text-lg text-slate-300 mb-10">
                A modern, smart, and efficient way to manage books, borrowing, and learning —
                built for students and librarians of Aisat College Dasmariñas.
            </p>

            <div class="flex justify-center gap-6">
                <a href="{{ route('login') }}"
                   class="px-8 py-3 rounded-2xl bg-indigo-500 hover:bg-indigo-600 transition shadow-xl text-lg font-semibold">
                    Get Started 🚀
                </a>

                <a href="#features"
                   class="px-8 py-3 rounded-2xl border border-indigo-400 hover:bg-indigo-500/20 transition text-lg font-semibold">
                    Learn More
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="mt-32 px-10">
        <h3 class="text-3xl font-bold text-center mb-14">
            ✨ System Features
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-6xl mx-auto">

            <div class="bg-white/10 backdrop-blur-xl p-8 rounded-3xl shadow-xl hover:scale-105 transition">
                <h4 class="text-xl font-semibold mb-3">🔐 Secure Access</h4>
                <p class="text-slate-300">
                    Role-based login for librarians and students using a secure authentication system.
                </p>
            </div>

            <div class="bg-white/10 backdrop-blur-xl p-8 rounded-3xl shadow-xl hover:scale-105 transition">
                <h4 class="text-xl font-semibold mb-3">📖 Smart Borrowing</h4>
                <p class="text-slate-300">
                    Easily borrow and return books while the system tracks availability in real time.
                </p>
            </div>

            <div class="bg-white/10 backdrop-blur-xl p-8 rounded-3xl shadow-xl hover:scale-105 transition">
                <h4 class="text-xl font-semibold mb-3">📊 Organized Records</h4>
                <p class="text-slate-300">
                    View borrowing history, due dates, and reports in one clean dashboard.
                </p>
            </div>

        </div>
    </section>

    <!-- Footer -->
    <footer class="mt-32 py-10 text-center text-slate-400">
        <p>
            © {{ date('Y') }} AISAT Library Management System
        </p>
    </footer>

</body>
</html>
