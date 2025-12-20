<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\BorrowController;

// Landing page
Route::get('/', fn() => view('welcome'));

// Auth routes
require __DIR__.'/auth.php';

// Profile routes (authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Student routes (authenticated users)
Route::middleware('auth')->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');

    // Borrow / Return actions
    Route::post('/borrow/{book}', [StudentController::class, 'borrow'])->name('borrow');
    Route::post('/return/{borrow}', [StudentController::class, 'returnBook'])->name('return');

    // Borrow history (optional separate page)
    Route::get('/history', [StudentController::class, 'history'])->name('history');
});

// Admin routes (authenticated & admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Books management
    Route::resource('books', BookController::class);

    // Borrows management
    Route::get('borrows', [BorrowController::class, 'index'])->name('borrows.index');
    Route::post('borrows/{borrow}/return', [BorrowController::class, 'returnBook'])->name('borrows.return');
    Route::delete('borrows/{borrow}', [BorrowController::class, 'destroy'])->name('borrows.destroy');

    // Admin logout (optional, though user can use normal logout)
    Route::post('logout', function () {
        auth()->logout();
        return redirect('/');
    })->name('logout');
});
