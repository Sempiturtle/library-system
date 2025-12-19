<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Borrow;
use App\Models\Book;
use App\Models\User;

class BorrowController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']); // Only admin/librarian
    }

    // List all borrows
    public function index()
    {
        $borrows = Borrow::with(['user', 'book'])->get();
        return view('admin.borrows.index', compact('borrows'));
    }

    // Mark book as returned
    public function returnBook(Borrow $borrow)
    {
        $borrow->return_date = now();
        $borrow->save();

        // Increase book copies
        $borrow->book->increment('copies');

        return redirect()->back()->with('success', 'Book marked as returned.');
    }

    // Optional: Delete borrow record
    public function destroy(Borrow $borrow)
    {
        $borrow->delete();
        return redirect()->back()->with('success', 'Borrow record deleted.');
    }
}
