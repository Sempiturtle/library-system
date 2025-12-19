<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Student Dashboard
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');

    Route::post('/borrow/{book}', [StudentController::class, 'borrow'])->name('student.borrow');

    Route::post('/return/{borrow}', [StudentController::class, 'returnBook'])->name('student.return');
});





// Librarian / admin dashboard
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/admin_dashboard', [AdminController::class, 'showAdminDashboard'])->name('admin.dashboard');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])
        ->name('admin.users.destroy');
});
