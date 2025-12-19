<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\BorrowController;

// Landing page
Route::get('/', function () {
    return view('welcome');
});

// Auth routes
require __DIR__.'/auth.php';

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Student Dashboard & Actions
Route::middleware('auth')->group(function() {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::post('/borrow/{book}', [StudentController::class, 'borrow'])->name('student.borrow');
    Route::post('/return/{borrow}', [StudentController::class, 'returnBook'])->name('student.return');
});


Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function() {
    Route::get('/dashboard', [AdminController::class,'dashboard'])->name('dashboard');

    // Books
    Route::resource('books', BookController::class);

    // Borrows
    Route::get('borrows', [BorrowController::class,'index'])->name('borrows.index');
    Route::post('borrows/{borrow}/return', [BorrowController::class,'returnBook'])->name('borrows.return');
    Route::delete('borrows/{borrow}', [BorrowController::class,'destroy'])->name('borrows.destroy');

    // Logout
    Route::post('logout', function() {
        auth()->logout();
        return redirect('/');
    })->name('logout');
});
