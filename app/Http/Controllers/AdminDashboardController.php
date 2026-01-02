<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\SlotJadwal;
use Illuminate\Http\Request;
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

    public function layanan()
    {
        $data = array_merge($this->userData(), [
            'currentTab' => 'layanan',
            'layanan' => \App\Models\Layanan::orderBy('created_at', 'desc')->get()
        ]);
        return view('admin.dashboard.layanan', $data);
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

        return back()->with('success', "Booking berhasil {$newStatus}.");
    }

    public function laporan()
    {
        // Tambahkan logic pengambilan data laporan di sini nanti
        $data = array_merge($this->userData(), ['currentTab' => 'laporan']);
        return view('admin.dashboard.laporan', $data);
    }
}
