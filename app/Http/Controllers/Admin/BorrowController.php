<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Borrow;

class BorrowController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function index()
    {
        $borrows = Borrow::with(['user','book'])->get();
        return view('admin.borrows.index', compact('borrows'));
    }

    public function returnBook(Borrow $borrow)
    {
        if ($borrow->return_date) {
            return redirect()->back()->with('error','Book already returned.');
        }

        $borrow->update(['return_date' => now()]);

        $borrow->book->increment('copies');

        return redirect()->back()->with('success','Book marked as returned.');
    }

    public function destroy(Borrow $borrow)
    {
        $borrow->delete();
        return redirect()->back()->with('success','Borrow record deleted.');
    }
}
