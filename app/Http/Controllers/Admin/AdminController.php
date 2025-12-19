<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Borrow;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        $totalBooks = Book::count();
        $borrowedBooks = Borrow::whereNull('return_date')->count();
        $overdueBooks = Borrow::whereNull('return_date')->where('due_date', '<', now())->count();

        $books = Book::all();
        $borrows = Borrow::with(['user','book'])->get();

        return view('admin.admin_dashboard', compact(
            'totalBooks',
            'borrowedBooks',
            'overdueBooks',
            'books',
            'borrows'
        ));
    }
}
