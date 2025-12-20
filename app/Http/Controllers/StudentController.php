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
        $this->middleware('auth');
    }

    // DASHBOARD
    public function dashboard()
    {
        $user = Auth::user();
        $borrowLimit = 5;

        // Current borrows
        $currentBorrows = Borrow::where('user_id', $user->id)
            ->whereNull('return_date')
            ->with('book')
            ->get();

        $borrowedBooks = $currentBorrows->count();
        $overdueCount = $currentBorrows->where('due_date', '<', now())->count();

        // Available books
        $books = Book::all();

        // Borrow history
        $history = Borrow::where('user_id', $user->id)
            ->with('book')
            ->orderBy('borrow_date', 'desc')
            ->get();

        return view('student.dashboard', compact(
            'books', 'history', 'borrowedBooks', 'borrowLimit', 'overdueCount'
        ));
    }

    // BORROW BOOK
    public function borrow(Book $book)
    {
        $user = Auth::user();

        if ($user->status === 'blocked') {
            return back()->with('error', 'Your account is blocked due to overdue books.');
        }

        $activeBorrows = Borrow::where('user_id', $user->id)->whereNull('return_date')->count();
        if ($activeBorrows >= 5) {
            return back()->with('error', 'You reached your borrow limit.');
        }

        if ($book->copies < 1) {
            return back()->with('error', 'No copies available.');
        }

        // Prevent double borrow of same book
        $existing = Borrow::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->whereNull('return_date')
            ->exists();

        if ($existing) {
            return back()->with('error', 'You already borrowed this book.');
        }

        Borrow::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrow_date' => now(),
            'due_date' => now()->addDays(7),
        ]);

        $book->decrement('copies');

        return back()->with('success', 'Book borrowed successfully!');
    }

    // RETURN BOOK
    public function returnBook(Borrow $borrow)
    {
        $borrow->update([
            'return_date' => now(),
            'penalty_fee' => $borrow->due_date < now()
                ? now()->diffInDays($borrow->due_date) * 10
                : 0
        ]);

        $borrow->book->increment('copies');

        // Unblock user if no overdue left
        $user = $borrow->user;
        $hasOverdue = Borrow::where('user_id', $user->id)
            ->whereNull('return_date')
            ->where('due_date', '<', now())
            ->exists();

        if (!$hasOverdue) {
            $user->update(['status' => 'active']);
        }

        return back()->with('success', 'Book returned successfully!');
    }
}
