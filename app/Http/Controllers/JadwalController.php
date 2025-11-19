<?php

namespace App\Http\Controllers;

use App\Models\SlotJadwal;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalController extends Controller
{
    public function index(Request $req)
    {
        $tanggal = $req->query('tanggal', Carbon::tomorrow()->format('Y-m-d'));

        // Grab all slots in that date
        $slots = SlotJadwal::where('tanggal', $tanggal)
            ->orderBy('waktu', 'asc')
            ->get();

        $allDates = SlotJadwal::pluck('tanggal')->toArray();

        return view('components.pesan', [
            'tanggal' => $tanggal,
            'tanggalFormatted' => \Carbon\Carbon::parse($tanggal)->format('d F Y'),
            'allDates' => $allDates,
            'slots' => $slots
        ]);
    }
}
