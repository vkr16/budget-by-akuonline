<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PocketController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Public Design Guide System
Route::get('/design-guide', function () {
    return view('design-guide');
})->name('design-guide');

// PWA Assets Routes (Ensures proper MIME types & headers across all web servers)
Route::get('/manifest.webmanifest', function () {
    return response(file_get_contents(public_path('manifest.webmanifest')), 200, [
        'Content-Type' => 'application/manifest+json',
        'Cache-Control' => 'no-cache, must-revalidate',
    ]);
});
Route::get('/manifest.json', function () {
    return response(file_get_contents(public_path('manifest.json')), 200, [
        'Content-Type' => 'application/manifest+json',
        'Cache-Control' => 'no-cache, must-revalidate',
    ]);
});
Route::get('/sw.js', function () {
    return response(file_get_contents(public_path('sw.js')), 200, [
        'Content-Type' => 'application/javascript',
        'Service-Worker-Allowed' => '/',
        'Cache-Control' => 'no-cache, no-store, must-revalidate',
    ]);
});

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pockets (Kantong)
    Route::get('/kantong', [PocketController::class, 'index'])->name('pockets.index');
    Route::post('/kantong', [PocketController::class, 'store'])->name('pockets.store');
    Route::get('/kantong/{pocket}', [PocketController::class, 'show'])->name('pockets.show');
    Route::put('/kantong/{pocket}', [PocketController::class, 'update'])->name('pockets.update');
    Route::delete('/kantong/{pocket}', [PocketController::class, 'destroy'])->name('pockets.destroy');

    // Transactions (Transaksi In / Out)
    Route::get('/transaksi', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transaksi', [TransactionController::class, 'store'])->name('transactions.store');
    Route::delete('/transaksi/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
});
