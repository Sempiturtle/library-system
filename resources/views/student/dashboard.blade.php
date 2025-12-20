<x-app-layout>

    <!-- HEADER -->
    <x-slot name="header">
        <div>
            <h2 class="text-4xl font-extrabold text-transparent bg-clip-text
                       bg-gradient-to-r from-pink-400 via-purple-400 to-indigo-400 drop-shadow-sm">
                Welcome, {{ Auth::user()->name }}! 👋
            </h2>
            <p class="text-sm text-gray-600 mt-1 tracking-wide">
                AISAT Library — Student Portal
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto flex gap-8">

            <!-- SIDEBAR -->
            <aside class="w-72 bg-white/60 backdrop-blur-xl shadow-xl rounded-3xl
                           p-6 border border-white/40">

                <h3 class="text-lg font-semibold text-gray-700 mb-4">📚 Navigation</h3>

                <ul class="space-y-3 text-gray-700 font-medium">

                    <!-- Dashboard -->
                    <li>
                        <a href="#available-books"
                           class="px-4 py-3 block rounded-2xl
                                  bg-gradient-to-r from-pink-200 to-purple-200
                                  hover:from-pink-300 hover:to-purple-300
                                  transition shadow-md">
                            📘 Available Books
                        </a>
                    </li>

                    <!-- History -->
                    <li>
                        <a href="#borrow-history"
                           class="px-4 py-3 block rounded-2xl hover:bg-indigo-100
                                  transition shadow-sm">
                            📄 Borrow History
                        </a>
                    </li>

                    <!-- Logout -->
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

                    <!-- Currently Borrowed -->
                    <div class="p-6 bg-white/60 backdrop-blur-xl rounded-3xl shadow-lg
                                border border-white/40 hover:shadow-2xl transition">
                        <p class="text-gray-600 text-sm">Currently Borrowed</p>
                        <h3 class="text-4xl font-bold text-purple-600">
                            {{ $borrowedBooks }}
                        </h3>
                        <p class="text-xs text-gray-500 mt-1">Books you are holding</p>
                    </div>

                    <!-- Borrow Limit with Progress Bar -->
                    <div class="p-6 bg-white/60 backdrop-blur-xl rounded-3xl shadow-lg
                                border border-white/40 hover:shadow-2xl transition">
                        <p class="text-gray-600 text-sm">Borrow Limit</p>
                        <div class="flex justify-between items-center mb-1">
                            <h3 class="text-4xl font-bold text-pink-600">{{ $borrowedBooks }}/{{ $borrowLimit }}</h3>
                            <span class="text-xs text-gray-500">{{ round(($borrowedBooks/$borrowLimit)*100) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                            <div class="bg-pink-500 h-3 rounded-full transition-all"
                                 style="width: {{ min(100, ($borrowedBooks/$borrowLimit)*100) }}%;">
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Maximum books allowed</p>
                    </div>

                    <!-- Overdue -->
                    <div class="p-6 bg-white/60 backdrop-blur-xl rounded-3xl shadow-lg
                                border border-white/40 hover:shadow-2xl transition">
                        <p class="text-gray-600 text-sm">Overdue Books</p>
                        <h3 class="text-4xl font-bold text-red-600">
                            {{ $overdueCount }}
                        </h3>
                        <p class="text-xs text-gray-500 mt-1">Return overdue books ASAP</p>
                    </div>

                </div>

                <!-- AVAILABLE BOOKS SECTION -->
                <section id="available-books"
                         class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl
                                border border-white/40 p-8">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-3xl font-bold text-gray-800">
                            📘 Available Books
                        </h3>

                        <!-- SEARCH -->
                        <input type="text" id="searchBooks"
                               placeholder="Search book title or author..."
                               class="px-4 py-2 rounded-xl border border-gray-300
                                      focus:ring-2 focus:ring-purple-400 transition w-64">
                    </div>

                    @if(count($books) > 0)

                        <table class="w-full border-collapse text-gray-700" id="bookTable">
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
                                        <td class="p-3 font-medium">{{ $book->title }}</td>
                                        <td class="p-3">{{ $book->author }}</td>
                                        <td class="p-3 {{ $book->copies == 0 ? 'text-red-600 font-bold' : '' }}">
                                            {{ $book->copies }}
                                        </td>
                                        <td class="p-3">

                                            @if($book->copies > 0)
                                                <button
                                                    class="px-5 py-2 bg-purple-500 text-white rounded-2xl
                                                           hover:bg-purple-600 transition shadow-md"
                                                    onclick="openBorrowModal('{{ $book->id }}', '{{ $book->title }}')">
                                                    Borrow
                                                </button>
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
                         class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl
                                border border-white/40 p-8">

                    <h3 class="text-3xl font-bold text-gray-800 mb-6">
                        📄 Borrow History
                    </h3>

                    @if(count($history) > 0)

                        <table class="w-full border-collapse text-gray-700">
                            <thead>
                                <tr class="bg-gradient-to-r from-indigo-200 to-purple-200">
                                    <th class="p-3 rounded-l-2xl">Title</th>
                                    <th class="p-3">Borrow Date</th>
                                    <th class="p-3">Due Date</th>
                                    <th class="p-3">Return Date</th>
                                    <th class="p-3">Status</th>
                                    <th class="p-3 rounded-r-2xl">Action</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">

                                @foreach($history as $record)
                                    <tr class="hover:bg-indigo-50 transition
                                               @if(!$record->return_date && $record->due_date < now())
                                                   bg-red-50 border-l-4 border-red-500
                                               @endif
                                    ">
                                        <td class="p-3 font-medium">{{ $record->book->title }}</td>
                                        <td class="p-3">{{ $record->borrow_date }}</td>
                                        <td class="p-3">{{ $record->due_date }}</td>
                                        <td class="p-3">
                                            {{ $record->return_date ?? '—' }}
                                        </td>

                                        <!-- Status -->
                                        <td class="p-3">
                                            @if($record->return_date)
                                                <span class="text-green-600 font-bold">✅ Returned</span>
                                            @elseif($record->due_date < now())
                                                <span class="text-red-600 font-bold">⚠️ Overdue</span>
                                            @else
                                                <span class="text-purple-600 font-bold">📚 Borrowed</span>
                                            @endif
                                        </td>

                                        <!-- Return Button -->
                                        <td class="p-3">
                                            @if(!$record->return_date)
                                                <form action="{{ route('student.return', $record->id) }}"
                                                      method="POST">
                                                    @csrf
                                                    <button class="px-3 py-1 rounded-xl
                                                                   bg-green-500 text-white
                                                                   hover:bg-green-600 transition">
                                                        Return
                                                    </button>
                                                </form>
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

    <!-- BORROW CONFIRMATION MODAL -->
    <div id="borrowModal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center">
        <div class="bg-white p-8 rounded-3xl shadow-xl w-96">
            <h3 class="text-xl font-bold mb-4">Borrow Book</h3>
            <p class="text-gray-600 mb-4">
                Are you sure you want to borrow:
                <span id="modalBookTitle" class="font-semibold text-purple-600"></span>?
            </p>

            <form id="borrowForm" method="POST">
                @csrf
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeBorrowModal()"
                            class="px-4 py-2 rounded-xl bg-gray-300 hover:bg-gray-400">
                        Cancel
                    </button>

                    <button type="submit"
                            class="px-4 py-2 rounded-xl bg-purple-500 text-white hover:bg-purple-600">
                        Confirm
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openBorrowModal(id, title) {
            document.getElementById('modalBookTitle').textContent = title;
            document.getElementById('borrowForm').action = "/student/borrow/" + id;
            document.getElementById('borrowModal').classList.remove('hidden');
        }

        function closeBorrowModal() {
            document.getElementById('borrowModal').classList.add('hidden');
        }

        // Search Books
        const searchInput = document.getElementById('searchBooks');
        searchInput.addEventListener('input', function () {
            let filter = searchInput.value.toLowerCase();
            let rows = document.querySelectorAll('#bookTable tbody tr');

            rows.forEach(row => {
                let title = row.children[0].textContent.toLowerCase();
                let author = row.children[1].textContent.toLowerCase();
                row.style.display = (title.includes(filter) || author.includes(filter))
                    ? ""
                    : "none";
            });
        });
    </script>

</x-app-layout>
