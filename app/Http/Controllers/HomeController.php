<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\SlotJadwal;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $layanans = Layanan::all();
        $tanggal = $request->query('tanggal', Carbon::tomorrow()->format('Y-m-d'));

        $slots = SlotJadwal::where('tanggal', $tanggal)
            ->orderBy('waktu')
            ->get();

        $allDates = SlotJadwal::distinct()
            ->orderBy('tanggal')
            ->pluck('tanggal')
            ->toArray();

        return view('app', compact('layanans','slots','tanggal','allDates'));
    }

}
