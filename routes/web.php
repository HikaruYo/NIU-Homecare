<?php

use Illuminate\Support\Facades\Route;

use App\Models\Layanan;

Route::get('/', function () {
    // mengambil semua data di tabel layanan
    $layanans = Layanan::all();
    return view('app', compact('layanans'));
});

Route::get('/login', function () {
    return view('login');
});
Route::get('/logout', function () {
    return view('logout');
});
