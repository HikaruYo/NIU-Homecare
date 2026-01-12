<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\SlotJadwal;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
//        Handle untuk mengecek jika admin yang login maka langsung diarahkan ke dashboard admin
//        tanpa memiliki izin untuk melihat halaman utama
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard.laporan');
        }

        $layanans = Layanan::all();
        $tanggal = $request->query('tanggal', Carbon::tomorrow()->format('Y-m-d'));

        $slots = SlotJadwal::where('tanggal', $tanggal)
            ->orderBy('waktu')
            ->get();

        $allDates = SlotJadwal::distinct()
            ->orderBy('tanggal')
            ->pluck('tanggal')
            ->toArray();

        $user = Auth::user();

        return view('app', compact('layanans','slots','tanggal','allDates'));
    }

}
