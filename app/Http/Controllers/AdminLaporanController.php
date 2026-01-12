<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminLaporanController extends Controller
{
    public function index()
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;

        $rawBookingBulanan = Booking::selectRaw('MONTH(tanggal_booking) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_booking', $year)
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $bookingBulanan = collect(range(1, 12))->map(function ($bulan) use ($rawBookingBulanan) {
            return (object) [
                'bulan' => $bulan,
                'total' => $rawBookingBulanan[$bulan] ?? 0
            ];
        });

        // Booking bulan ini
        $totalBookingBulanIni = Booking::whereMonth('tanggal_booking', $month)
            ->whereYear('tanggal_booking', $year)
            ->count();

        // Booking per status
        $bookingDiterima = Booking::where('status', 'diterima')->count();
        $bookingMenunggu = Booking::where('status', 'menunggu')->count();
        $bookingDitolak  = Booking::where('status', 'ditolak')->count();

        // Pendapatan (hanya yang diterima)
        $pendapatan = BookingLayanan::join(
            'bookings',
            'booking_layanans.booking_id',
            '=',
            'bookings.booking_id'
        )
            ->where('bookings.status', 'diterima')
            ->selectRaw('SUM(booking_layanans.harga) as total')
            ->value('total');

        return view('admin.dashboard.laporan', ['currentTab' => 'laporan',], compact(
            'totalBookingBulanIni',
            'bookingDiterima',
            'bookingMenunggu',
            'bookingDitolak',
            'pendapatan',
            'bookingBulanan'
        ));
    }

}
