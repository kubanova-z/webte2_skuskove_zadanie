<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\LoginHistoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/main', [MainPageController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


//user guide
Route::get('/user-guide', [\App\Http\Controllers\UserGuideController::class, 'show'])->name('user-guide');
Route::get('/user-guide/pdf', [\App\Http\Controllers\UserGuideController::class, 'downloadPdf'])->name('user-guide.pdf');


//  Password Reset GET form route — for user arriving from email
Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

//  Prevent people from manually visiting /reset-password without token
Route::get('/reset-password', function () {
    return redirect('/forgot-password');
});

// Dashboard (auth-only)
Route::get('/change-password', function () {
    return view('auth.change-password');
})->middleware(['auth'])->name('change-password');

Route::put('/update-password', [ProfileController::class, 'updatePassword'])->name('password.update');


// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/login-history', [LoginHistoryController::class, 'index']);
    Route::delete('/login-history', [LoginHistoryController::class, 'destroyAll']);
    Route::get('/login-history/export', [LoginHistoryController::class, 'export']);

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
