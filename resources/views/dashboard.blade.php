<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        <div>
            <h2 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-pink-400 via-purple-400 to-indigo-400 drop-shadow-sm">
                Welcome, {{ Auth::user()->name }}! 👋
            </h2>
            <p class="text-sm text-gray-600 mt-1 tracking-wide">
                AISAT Library
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto flex gap-8">

            <!-- Sidebar -->
            <aside class="w-72 bg-white/60 backdrop-blur-xl shadow-xl rounded-3xl p-6 border border-white/40">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">📚 Navigation</h3>

                <ul class="space-y-3 text-gray-700 font-medium">
                    <li>
                        <a href="#available-books"
                           class="px-4 py-3 block rounded-2xl bg-gradient-to-r from-pink-200 to-purple-200 hover:from-pink-300 hover:to-purple-300 transition shadow-md">
                            📘 Available Books
                        </a>
                    </li>

                    <li>
                        <a href="#borrow-history"
                           class="px-4 py-3 block rounded-2xl hover:bg-indigo-100 transition shadow-sm">
                            📄 Borrow History
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="px-4 py-3 block rounded-2xl hover:bg-red-100 transition shadow-sm">
                            🚪 Logout
                        </a>

                        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                            @csrf
                        </form>
                    </li>
                </ul>
            </aside>

            <!-- MAIN CONTENT -->
            <main class="flex-1 space-y-10">

                <!-- QUICK STATS -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                    <!-- Total Borrowed -->
                    <div class="p-6 bg-white/60 backdrop-blur-xl rounded-3xl shadow-lg border border-white/40 hover:shadow-2xl transition">
                        <p class="text-gray-600 text-sm">Total Borrowed</p>
                        <h3 class="text-4xl font-bold text-purple-600">
                            {{ $totalBorrowed ?? 0 }}
                        </h3>
                        <p class="text-xs text-gray-500 mt-1">All-time borrowed books</p>
                    </div>

                    <!-- Borrow Limit -->
                    <div class="p-6 bg-white/60 backdrop-blur-xl rounded-3xl shadow-lg border border-white/40 hover:shadow-2xl transition">
                        <p class="text-gray-600 text-sm">Borrow Limit</p>
                        <h3 class="text-4xl font-bold text-pink-600">
                            {{ $borrowLimit ?? 5 }} max
                        </h3>
                        <p class="text-xs text-gray-500 mt-1">Maximum books allowed</p>
                    </div>

                    <!-- Notifications -->
                    <div class="p-6 bg-white/60 backdrop-blur-xl rounded-3xl shadow-lg border border-white/40 hover:shadow-2xl transition">
                        <p class="text-gray-600 text-sm">Notifications</p>
                        <h3 class="text-4xl font-bold text-indigo-600">
                            {{ $overdueCount ?? 0 }} Overdue ⚠️
                        </h3>
                        <p class="text-xs text-gray-500 mt-1">Return overdue books ASAP</p>
                    </div>
                </div>

                <!-- AVAILABLE BOOKS -->
                <section id="available-books"
                         class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-white/40 p-8">
                    <h3 class="text-3xl font-bold text-gray-800 mb-6">
                        📘 Available Books
                    </h3>

                    @if(isset($books) && count($books) > 0)
                        <table class="w-full border-collapse text-gray-700">
                            <thead>
                                <tr class="bg-gradient-to-r from-purple-200 to-pink-200 text-gray-700">
                                    <th class="p-3 text-left rounded-l-2xl">Title</th>
                                    <th class="p-3 text-left">Author</th>
                                    <th class="p-3 text-left">Copies</th>
                                    <th class="p-3 text-left rounded-r-2xl">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">

                                @foreach($books as $book)
                                    <tr class="hover:bg-pink-50 transition">
                                        <td class="p-3">{{ $book->title }}</td>
                                        <td class="p-3">{{ $book->author }}</td>
                                        <td class="p-3 {{ $book->copies == 0 ? 'text-red-600 font-bold' : '' }}">
                                            {{ $book->copies }}
                                        </td>
                                        <td class="p-3">
                                            @if($book->copies > 0)
                                                <form action="{{ route('student.borrow', $book->id) }}" method="POST">
                                                    @csrf
                                                    <button class="px-5 py-2 bg-purple-500 text-white rounded-2xl hover:bg-purple-600 transition shadow-md">
                                                        Borrow
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-red-600 font-semibold">Not Available</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-500 text-center">No books available at the moment.</p>
                    @endif
                </section>

                <!-- BORROW HISTORY -->
                <section id="borrow-history"
                         class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-white/40 p-8">
                    <h3 class="text-3xl font-bold text-gray-800 mb-6">📄 Borrow History</h3>

                    @if(isset($history) && count($history) > 0)
                        <table class="w-full border-collapse text-gray-700">
                            <thead>
                                <tr class="bg-gradient-to-r from-indigo-200 to-purple-200">
                                    <th class="p-3 text-left rounded-l-2xl">Title</th>
                                    <th class="p-3 text-left">Borrow Date</th>
                                    <th class="p-3 text-left">Due Date</th>
                                    <th class="p-3 text-left">Return Date</th>
                                    <th class="p-3 text-left rounded-r-2xl">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">

                                @foreach($history as $record)
                                    <tr class="hover:bg-indigo-50 transition">
                                        <td class="p-3">{{ $record->book->title }}</td>
                                        <td class="p-3">{{ $record->borrow_date }}</td>
                                        <td class="p-3">{{ $record->due_date }}</td>
                                        <td class="p-3">{{ $record->return_date ?? '—' }}</td>
                                        <td class="p-3">
                                            @if($record->status == 'Overdue')
                                                <span class="text-red-600 font-bold">Overdue</span>
                                            @elseif($record->status == 'Returned')
                                                <span class="text-green-600 font-bold">Returned</span>
                                            @else
                                                <span class="text-purple-600 font-bold">Borrowed</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-600 text-sm">No history available yet...</p>
                    @endif
                </section>

            </main>
        </div>
    </div>
</x-app-layout>
