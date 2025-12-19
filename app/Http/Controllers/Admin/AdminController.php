<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']); // Only admin/librarian access
    }

    public function dashboard()
    {
        // Quick stats
        $totalBooks = Book::count();
        $totalUsers = User::where('usertype', 'user')->count();
        $totalBorrows = Borrow::count();
        $overdueBorrows = Borrow::where('due_date', '<', now())->whereNull('return_date')->count();

        return view('admin.admin_dashboard', compact('totalBooks', 'totalUsers', 'totalBorrows', 'overdueBorrows'));
    }
}
