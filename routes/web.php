<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\AdminLayananController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', function() {
    abort(404);
});

// Redirect setelah login berdasarkan role
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard.layanan');
    } else {
        return redirect()->route('dashboard.profil');
    }
})->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/profil', [DashboardController::class, 'profil'])->name('dashboard.profil');
    Route::get('/dashboard/histori', [DashboardController::class, 'histori'])->name('dashboard.histori');

    Route::get('/dashboard/profil/edit', [DashboardController::class, 'edit'])
        ->name('profile.edit');
    Route::put('/dashboard/profil', [DashboardController::class, 'updateProfile'])
        ->name('profile.update');

    // Booking route
    Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
});

Route::middleware(['admin'])->group(function () {
    Route::get('admin/dashboard', function () {
        return redirect()->route('admin.dashboard.layanan');
    })->name('dashboard');

    Route::get('admin/dashboard/layanan', [AdminDashboardController::class, 'layanan'])->name('admin.dashboard.layanan');
    Route::get('admin/dashboard/layanan/tambah', [AdminLayananController::class, 'create'])
        ->name('admin.dashboard.layanan.tambah');
    Route::post('admin/dashboard/layanan/tambah', [AdminLayananController::class, 'store'])
        ->name('admin.dashboard.layanan.store');
    Route::get('admin/dashboard/layanan/{id}/edit', [AdminLayananController::class, 'edit'])
        ->name('admin.dashboard.layanan.edit');
    Route::put('admin/dashboard/layanan/{id}', [AdminLayananController::class, 'update'])
        ->name('admin.dashboard.layanan.update');
    Route::delete('admin/dashboard/layanan/{id}', [AdminLayananController::class, 'destroy'])
        ->name('admin.dashboard.layanan.destroy');
    Route::get('admin/dashboard/layanan/search', [AdminLayananController::class, 'search'])
        ->name('admin.dashboard.layanan.search');

    Route::get('admin/dashboard/booking', [AdminDashboardController::class, 'booking'])
        ->name('admin.dashboard.booking');
    Route::put('admin/dashboard/booking/{id}', [AdminDashboardController::class, 'updateStatus'])
        ->name('admin.booking.update');

    Route::get('admin/dashboard/laporan', [AdminLaporanController::class, 'index'])->name('admin.dashboard.laporan');
});
