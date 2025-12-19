<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\Borrow;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Only logged-in users
    }

    // Dashboard
    public function dashboard()
    {
        $user = Auth::user();

        // Borrow limit (you can change this)
        $borrowLimit = 5;

        // Books currently borrowed by this student
        $currentBorrows = Borrow::where('user_id', $user->id)
            ->whereNull('return_date')
            ->with('book')
            ->get();

        $borrowedBooks = $currentBorrows->count();

        // Overdue count
        $overdueCount = $currentBorrows->where('due_date', '<', now())->count();

        // Available books
        $books = Book::all();

        // Borrow history (all borrows by this student)
        $history = Borrow::where('user_id', $user->id)
            ->with('book')
            ->orderBy('borrow_date', 'desc')
            ->get();

        return view('dashboard', compact(
            'books', 'history', 'borrowedBooks', 'borrowLimit', 'overdueCount'
        ));
    }

    // Borrow a book
    public function borrow(Book $book)
    {
        $user = Auth::user();

        // Check borrow limit
        $currentBorrows = Borrow::where('user_id', $user->id)
            ->whereNull('return_date')
            ->count();

        if ($currentBorrows >= 5) {
            return redirect()->back()->with('error', 'You have reached your borrow limit.');
        }

        if ($book->copies <= 0) {
            return redirect()->back()->with('error', 'Book not available.');
        }

        // Borrow the book
        Borrow::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrow_date' => now(),
            'due_date' => now()->addDays(7), // 7-day borrow period
        ]);

        // Reduce book copies
        $book->decrement('copies');

        return redirect()->back()->with('success', 'Book borrowed successfully.');
    }

    // Return a book
    public function returnBook(Borrow $borrow)
    {
        $user = Auth::user();

        // Make sure the borrow belongs to the user
        if ($borrow->user_id !== $user->id) {
            abort(403);
        }

        if ($borrow->return_date) {
            return redirect()->back()->with('error', 'Book already returned.');
        }

        // Mark as returned
        $borrow->update([
            'return_date' => now()
        ]);

        // Increase book copies
        $borrow->book->increment('copies');

        return redirect()->back()->with('success', 'Book returned successfully.');
    }
}
