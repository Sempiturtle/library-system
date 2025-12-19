<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold">Books List</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <div class="bg-white p-6 rounded-xl shadow-lg">

            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold">📖 All Books</h3>
                <a href="{{ route('admin.books.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    ➕ Add Book
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700 uppercase text-sm">
                            <th class="p-3 rounded-l-lg">Title</th>
                            <th class="p-3">Author</th>
                            <th class="p-3">Copies</th>
                            <th class="p-3 rounded-r-lg">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($books as $book)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-3 font-medium">{{ $book->title }}</td>
                            <td class="p-3">{{ $book->author }}</td>
                            <td class="p-3">{{ $book->copies }}</td>
                            <td class="p-3 flex gap-2">
                                <a href="{{ route('admin.books.edit', $book->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Delete this book?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">🗑 Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @if($books->isEmpty())
                        <tr>
                            <td colspan="4" class="p-3 text-center text-gray-500">No books found.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
