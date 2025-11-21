<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('dashboard.profil');
    })->name('dashboard');

    Route::redirect('/dashboard', '/dashboard/profil');
    Route::get('/dashboard/profil', [DashboardController::class, 'profil'])->name('dashboard.profil');
    Route::get('/dashboard/histori', [DashboardController::class, 'histori'])->name('dashboard.histori');

    Route::get('/dashboard/profil/edit', [DashboardController::class, 'edit'])
        ->name('profile.edit');
    Route::put('/dashboard/profil', [DashboardController::class, 'updateProfile'])
        ->name('profile.update');
});

Route::middleware(['admin'])->group(function () {
    Route::redirect('/', '/admin/dashboard/layanan');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::redirect('/', '/admin/dashboard/layanan');

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/layanan', [AdminDashboardController::class, 'layanan'])->name('dashboard.layanan');
    Route::get('/dashboard/booking', [AdminDashboardController::class, 'booking'])->name('dashboard.booking');
    Route::get('/dashboard/laporan', [AdminDashboardController::class, 'laporan'])->name('dashboard.laporan');
});
