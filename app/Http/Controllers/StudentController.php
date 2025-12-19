<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrow;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class StudentController extends Controller
{
    // BORROW LIMIT
    private $limit = 5;

    public function dashboard()
    {
        $user = Auth::user();

        // update overdue statuses automatically
        Borrow::where('user_id', $user->id)
            ->whereNull('return_date')
            ->where('due_date', '<', Carbon::now())
            ->update(['status' => 'Overdue']);

        // stats
        $totalBorrowed = Borrow::where('user_id', $user->id)->count();
        $overdueCount = Borrow::where('user_id', $user->id)->where('status', 'Overdue')->count();

        // active borrows (still borrowed)
        $activeBorrowCount = Borrow::where('user_id', $user->id)
            ->whereNull('return_date')
            ->count();

        // available books
        $books = Book::orderBy('title', 'asc')->get();

        // borrow history
        $history = Borrow::where('user_id', $user->id)
            ->orderBy('borrow_date', 'desc')
            ->get();

        return view('dashboard', [
            'books' => $books,
            'history' => $history,
            'totalBorrowed' => $totalBorrowed,
            'borrowLimit' => $this->limit,
            'overdueCount' => $overdueCount,
            'activeBorrowCount' => $activeBorrowCount
        ]);
    }


    // BORROW A BOOK
    public function borrow(Book $book)
    {
        $user = Auth::user();

        // limit check
        $active = Borrow::where('user_id', $user->id)
            ->whereNull('return_date')
            ->count();

        if ($active >= $this->limit) {
            return back()->with('error', 'You have reached your borrow limit.');
        }

        // no copies left
        if ($book->copies <= 0) {
            return back()->with('error', 'Book is not available.');
        }

        // store borrow record
        Borrow::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrow_date' => Carbon::now(),
            'due_date' => Carbon::now()->addDays(7),
            'status' => 'Borrowed'
        ]);

        // subtract available copy
        $book->decrement('copies');

        return back()->with('success', 'Book borrowed successfully!');
    }


    // RETURN BOOK
    public function returnBook(Borrow $borrow)
    {
        if ($borrow->return_date != null) {
            return back()->with('error', 'Already returned.');
        }

        $borrow->update([
            'return_date' => Carbon::now(),
            'status' => 'Returned'
        ]);

        $borrow->book->increment('copies');

        return back()->with('success', 'Book returned successfully!');
    }
}
