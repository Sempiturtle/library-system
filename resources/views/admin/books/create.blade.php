<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-400 via-purple-400 to-indigo-400">
            Add New Book
        </h2>
        <p class="text-sm text-gray-600 mt-1 tracking-wide">
            AISAT Library Management System — Admin
        </p>
    </x-slot>

    <div class="py-10 max-w-4xl mx-auto">
        <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-white/40 p-8">
            <form action="{{ route('admin.books.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Title</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="w-full p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Author</label>
                    <input type="text" name="author" value="{{ old('author') }}"
                        class="w-full p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('author') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Copies</label>
                    <input type="number" name="copies" value="{{ old('copies',1) }}" min="0"
                        class="w-full p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('copies') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-between items-center">
                    <a href="{{ route('admin.books.index') }}"
                        class="px-4 py-2 rounded-xl bg-gray-300 text-gray-700 hover:bg-gray-400 transition">Cancel</a>
                    <button type="submit"
                        class="px-4 py-2 rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold shadow-md hover:scale-105 transition">Add Book</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
