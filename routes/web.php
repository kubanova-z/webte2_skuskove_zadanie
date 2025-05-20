<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\LoginHistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PDFController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

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

//Language change
Route::get('/lang/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'sk'])) {
        abort(400);
    }

    Cookie::queue('locale', $locale, 60 * 24 * 30); // auto-encrypted

    return redirect()->back();
})->name('lang.switch');


Route::get('/check-locale', function (\Illuminate\Http\Request $request) {
    $rawCookie = $_COOKIE['locale'] ?? 'not set';
    $queuedCookie = $request->cookie('locale', 'not found');
    $currentLocale = App::getLocale();

    return response()->json([
        'raw_cookie' => $rawCookie,
        'request_cookie' => $queuedCookie,
        'app_locale' => $currentLocale,
    ]);
});

Route::get('/debug-locale', function (\Illuminate\Http\Request $request) {
    return response()->json([
        'request_cookie' => $request->cookie('locale'),
        'app_locale' => app()->getLocale(),
    ]);
});




// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/login-history', [LoginHistoryController::class, 'index']);
    Route::delete('/login-history', [LoginHistoryController::class, 'destroyAll']);
    Route::get('/login-history/export', [LoginHistoryController::class, 'export']);

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //pdf functions
    Route::get('/pdf/remove-pages', [PDFController::class, 'showRemovePagesForm'])->name('pdf.remove-pages.form');
    Route::post('/pdf/remove-pages', [PDFController::class, 'processRemovePages'])->name('pdf.remove-pages.process');

    Route::get('/pdf/merge-pdfs', [PDFController::class, 'showMergePdfsForm'])->name('pdf.merge-pdfs.form');
    Route::post('/pdf/merge-pdfs', [PDFController::class, 'processMergePdfs'])->name('pdf.merge-pdfs.process');

    Route::get('/pdf/pdf-to-jpg', [PDFController::class, 'showPdfToJpgForm'])->name('pdf.pdf-to-jpg.form');
    Route::post('/pdf/pdf-to-jpg', [PDFController::class, 'processPdfToJpg'])->name('pdf.pdf-to-jpg.process');

    Route::get('/pdf/jpg-to-pdf', [PDFController::class, 'showJpgToPdfForm'])->name('pdf.jpg-to-pdf.form');
    Route::post('/pdf/jpg-to-pdf', [PDFController::class, 'processJpgToPdf'])->name('pdf.jpg-to-pdf.process');

    Route::get('/pdf/rotate-pages', [PDFController::class, 'showRotatePagesForm'])->name('pdf.rotate-pages.form');
    Route::post('/pdf/rotate-pages', [PDFController::class, 'processRotatePages'])->name('pdf.rotate-pages.process');

    Route::get('/pdf/split-pdf', [PDFController::class, 'showSplitPdfForm'])->name('pdf.split-pdf.form');
    Route::post('/pdf/split-pdf', [PDFController::class, 'processSplitPdf'])->name('pdf.split-pdf.process');

});

require __DIR__.'/auth.php';
