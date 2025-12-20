<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrow;

class AdminController extends Controller
{

    public function dashboard()
    {
        $books = Book::all();
        $borrows = Borrow::with(['user', 'book'])->get();

        $totalBooks = $books->count();
        $totalBorrows = $borrows->count();
        $overdueBorrows = Borrow::whereNull('return_date')
            ->where('due_date', '<', now())
            ->count();

        // Chart data: borrow count per book
        $bookTitles = $books->pluck('title')->toArray();
        $borrowCounts = $books->map(function ($book) {
            return $book->borrows()->count(); // assumes Book has borrows() relation
        })->toArray();

        return view('admin.admin_dashboard', compact(
            'books',
            'borrows',
            'totalBooks',
            'totalBorrows',
            'overdueBorrows',
            'bookTitles',
            'borrowCounts'
        ));
    }
}
