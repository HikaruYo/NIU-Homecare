<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingLayanan;
use App\Models\SlotJadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    private function userData()
    {
        $user = Auth::user();
        $full = $user->username;
        $short = strlen($full) > 20 ? substr($full, 0, 20) . '..' : $full;

        return [
            'user'   => $user,
            'full'   => $full,
            'short'  => $short,
            'email'  => $user->email,
            'no_hp'  => $user->no_hp,
            'alamat' => $user->alamat,
            'currentTab' => 'dashboard'
        ];
    }

    public function index()
    {
        $data = array_merge($this->userData(), ['currentTab' => 'dashboard']);
        return view('admin.dashboard', $data);
    }

    public function layanan(Request $request)
    {
        $sort = $request->query('sort');
        $query = \App\Models\Layanan::query();

        switch ($sort) {
            case 'harga':
                $query->orderBy('nominal', 'asc');
                break;
            case 'durasi':
                $query->orderBy('durasi', 'asc');
                break;
            case 'ditambahkan':
            default:
                $query->orderBy('created_at', 'desc');
                $sort = 'ditambahkan'; // Default label
                break;
        }

        $layanan = $query->get();

        return view('admin.dashboard.layanan', array_merge($this->userData(), [
            'currentTab' => 'layanan',
            'layanan' => $layanan,
            'currentSort' => $sort
        ]));
    }

    public function booking(Request $request)
    {
        $status = $request->query('filter');

        $query = Booking::with(['user', 'bookingLayanans.layanan', 'bookingSlots.slotJadwal'])
            ->orderBy('tanggal_booking', 'desc');

        if ($status && in_array($status, ['menunggu', 'diterima', 'ditolak'])) {
            $query->where('status', $status);
        }

        $bookings = $query->paginate(10)->withQueryString();

        return view('admin.dashboard.booking', array_merge($this->userData(), [
            'bookings'      => $bookings,
            'currentTab'    => 'booking',
            'currentStatus' => $status
        ]));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak'
        ]);

        $booking = Booking::with('bookingSlots')->findOrFail($id);
        $oldStatus = $booking->status;
        $newStatus = $request->status;

        // Jika booking ditolak, kembalikan slot menjadi svailable
        if ($newStatus === 'ditolak' && $oldStatus !== 'ditolak') {
            // Ambil semua ID slot yang dipakai booking ini
            $slotIds = $booking->bookingSlots->pluck('slot_jadwal_id');

            // Update tabel slot_jadwals
            SlotJadwal::whereIn('slot_jadwal_id', $slotIds)->update([
                'is_available' => true
            ]);
        }

        // Update status booking
        $booking->update([
            'status' => $newStatus
        ]);

        return back()->with('success', "Booking telah {$newStatus}.");
    }

    public function laporan()
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
