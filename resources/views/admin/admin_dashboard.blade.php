<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-400 via-purple-400 to-indigo-400">
            Welcome, {{ Auth::user()->name }}! 👋
        </h2>
        <p class="text-sm text-gray-600 mt-1 tracking-wide">
            AISAT Library Management System — Admin Dashboard
        </p>
    </x-slot>

    <div class="py-10 bg-gradient-to-br from-indigo-200 via-purple-200 to-pink-200 min-h-screen">
        <div class="max-w-7xl mx-auto flex gap-6">

            <!-- Sidebar -->
            <div class="w-64 bg-white/60 backdrop-blur-xl shadow-xl rounded-2xl p-6 border border-white/40">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">📚 Navigation</h3>

                <ul class="space-y-3 text-gray-700 font-medium">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 block rounded-xl bg-gradient-to-r from-pink-200 to-purple-200 hover:from-pink-300 hover:to-purple-300 transition">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.books.index') }}" class="px-4 py-2 block rounded-xl hover:bg-indigo-100 transition">
                            📖 Manage Books
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.borrows.index') }}" class="px-4 py-2 block rounded-xl hover:bg-indigo-100 transition">
                            📝 Borrow Records
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile.edit') }}" class="px-4 py-2 block rounded-xl hover:bg-indigo-100 transition">
                            ⚙️ Profile
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="flex-1 space-y-8">

                <!-- Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-6 bg-white/30 backdrop-blur-xl rounded-2xl shadow-lg border border-white/20 hover:scale-[1.03] transition-all cursor-pointer">
                        <p class="text-gray-600 text-sm">Total Books</p>
                        <h3 class="text-3xl font-bold text-indigo-600">{{ $totalBooks ?? 0 }}</h3>
                    </div>
                    <div class="p-6 bg-white/30 backdrop-blur-xl rounded-2xl shadow-lg border border-white/20 hover:scale-[1.03] transition-all cursor-pointer">
                        <p class="text-gray-600 text-sm">Books Borrowed</p>
                        <h3 class="text-3xl font-bold text-purple-600">{{ $borrowedBooks ?? 0 }}</h3>
                    </div>
                    <div class="p-6 bg-white/30 backdrop-blur-xl rounded-2xl shadow-lg border border-white/20 hover:scale-[1.03] transition-all cursor-pointer">
                        <p class="text-gray-600 text-sm">Overdue Books</p>
                        <h3 class="text-3xl font-bold text-pink-600">{{ $overdueBooks ?? 0 }}</h3>
                    </div>
                </div>

                <!-- Books Table -->
                <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-white/40 p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-800 flex items-center gap-2">📖 Books List</h3>
                        <a href="{{ route('admin.books.create') }}" class="px-4 py-2 rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold shadow-md hover:scale-105 transition">
                            ➕ Add Book
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse text-left">
                            <thead>
                                <tr class="bg-gradient-to-r from-purple-200 to-pink-200 text-gray-700 uppercase text-sm">
                                    <th class="p-3 rounded-l-xl">Title</th>
                                    <th class="p-3">Author</th>
                                    <th class="p-3">Copies</th>
                                    <th class="p-3 rounded-r-xl">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($books as $book)
                                <tr class="hover:bg-pink-50 transition">
                                    <td class="p-3 font-medium">{{ $book->title }}</td>
                                    <td class="p-3">{{ $book->author }}</td>
                                    <td class="p-3">{{ $book->copies }}</td>
                                    <td class="p-3 flex gap-2">
                                        <a href="{{ route('admin.books.edit', $book->id) }}" class="px-3 py-1 rounded-xl bg-indigo-500 text-white hover:bg-indigo-600 transition">
                                            ✏️ Edit
                                        </a>
                                        <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Delete this book?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 rounded-xl bg-red-500 text-white hover:bg-red-600 transition">🗑 Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Borrow Records Table -->
                <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-white/40 p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">📝 Borrow Records</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse text-left">
                            <thead>
                                <tr class="bg-gradient-to-r from-purple-200 to-pink-200 text-gray-700 uppercase text-sm">
                                    <th class="p-3 rounded-l-xl">Student</th>
                                    <th class="p-3">Book</th>
                                    <th class="p-3">Borrowed At</th>
                                    <th class="p-3">Due Date</th>
                                    <th class="p-3">Status</th>
                                    <th class="p-3 rounded-r-xl">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($borrows as $borrow)
                                <tr class="hover:bg-pink-50 transition">
                                    <td class="p-3">{{ $borrow->user->name }}</td>
                                    <td class="p-3">{{ $borrow->book->title }}</td>
                                    <td class="p-3">{{ $borrow->borrow_date->format('M d, Y') }}</td>
                                    <td class="p-3">{{ $borrow->due_date->format('M d, Y') }}</td>
                                    <td class="p-3 font-semibold @if($borrow->status=='overdue') text-red-600 @elseif($borrow->status=='borrowed') text-purple-600 @else text-green-600 @endif">
                                        {{ ucfirst($borrow->status) }}
                                    </td>
                                    <td class="p-3 flex gap-2">
                                        @if($borrow->status != 'returned')
                                        <form action="{{ route('admin.borrows.return', $borrow->id) }}" method="POST">
                                            @csrf
                                            <button class="px-3 py-1 rounded-xl bg-green-500 text-white hover:bg-green-600 transition">✅ Return</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Footer -->
                <p class="mt-10 text-center text-gray-600 text-xs">
                    © {{ date('Y') }} AISAT Library Management System — Designed with 💗✨ for Admins
                </p>

            </div>
        </div>
    </div>
</x-app-layout>
