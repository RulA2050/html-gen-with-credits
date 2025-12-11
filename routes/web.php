<?php

use App\Http\Controllers\TopupController;
use App\Http\Controllers\HtmlGenerationController;
use App\Http\Controllers\Admin\TopupAdminController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'phone.verified'])->group(function () {


    Route::get('/dashboard', DashboardController::class)
        ->middleware(['auth'])
        ->name('dashboard');


    // Topup (user)
    Route::get('/topups', [TopupController::class, 'index'])->name('topups.index');
    Route::get('/topups/create', [TopupController::class, 'create'])->name('topups.create');
    Route::post('/topups', [TopupController::class, 'store'])->name('topups.store');

    // Generate HTML
    Route::get('/generations', [HtmlGenerationController::class, 'index'])->name('generations.index');
    Route::get('/generations/create', [HtmlGenerationController::class, 'create'])->name('generations.create');
    Route::post('/generations', [HtmlGenerationController::class, 'store'])->name('generations.store');
    Route::get('/generations/{generation}/edit', [HtmlGenerationController::class, 'edit'])->name('generations.edit');
    Route::put('/generations/{generation}', [HtmlGenerationController::class, 'update'])->name('generations.update');
    Route::get('/generations/{generation}/preview', [HtmlGenerationController::class, 'preview'])->name('generations.preview');
});

// Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/topups', [TopupAdminController::class, 'index'])->name('topups.index');
    Route::post('/topups/{topup}/mark-paid', [TopupAdminController::class, 'markPaid'])->name('topups.markPaid');
});


require __DIR__ . '/auth.php';
