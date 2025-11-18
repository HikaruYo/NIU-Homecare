<?php

namespace App\Http\Controllers;

use App\Models\Layanan;

class LayananController extends Controller
{
    public function index()
    {
        // Ambil semua layanan
        $layanans = Layanan::all();

        // Kirim ke blade
        return view('components.card-layanan', compact('layanans'));
    }
}
