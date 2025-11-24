<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingLayanan;
use App\Models\BookingSlot;
use App\Models\SlotJadwal;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    // TODO: buat agar slot yang dipesan bertambah 2 secara otomatis (membuat jeda selama 1 jam antara pesanan)
    // TODO: buat admin dapat men-disable slot jadwal (tutup)
    // TODO: buat agar user dapat membatalkan booking (menghapus hingga data booking yang dilakukan user)

    // Form booking
    public function create()
    {
        return view('layout.pesan', [
            'layanans' => Layanan::all(),
            'slots' => SlotJadwal::where('is_available', true)->get()
        ]);
    }

    public function store(Request $req)
    {
        $req->validate([
            'tanggal_booking' => 'required|date',
            'layanan_id'      => 'required|array',
            'layanan_id.*'    => 'required|exists:layanans,layanan_id',
            'durasi'          => 'required|array', // Durasi dari input user
            'slot_jadwal_id'  => 'required|array',
        ]);

        // Validasi ketersediaan slot, mencegah tabrakan jadwal
        foreach ($req->slot_jadwal_id as $slotId) {
            // Cek apakah slot sudah dipesan orang lain
            $isBooked = \App\Models\BookingSlot::where('slot_jadwal_id', $slotId)->exists();
            // Cek juga apakah slot masih available
            $isSlotTaken = \App\Models\SlotJadwal::where('slot_jadwal_id', $slotId)
                ->where('is_available', false)
                ->exists();

            if ($isBooked || $isSlotTaken) {
                return back()->with('error', 'Maaf, salah satu slot waktu baru saja dipesan orang lain. Silakan pilih waktu ulang.');
            }
        }

        $tanggalBooking = \Carbon\Carbon::parse($req->tanggal_booking)->format('d-m-Y');

        \DB::beginTransaction();
        try {
            // Simpan booking
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'tanggal_booking' => \Carbon\Carbon::parse($req->tanggal_booking),
                'status' => 'menunggu'
            ]);

            // Simpan layanan dan hitung harga sesuai durasi pilihan user
            // Menggunakan $key untuk mencocokkan layanan ke-sekian dengan durasi ke-sekian
            foreach ($req->layanan_id as $key => $layananId) {
                $layan = Layanan::find($layananId);

                // Ambil durasi dari input user (jika merupakan layanan dengan durasi fleksibel
                // fallback int 30 jika kosong/error
                $durasiInput = (int) ($req->durasi[$key] ?? 30);

                // Hitung Harga
                if ($layan->is_flexible_duration) {
                    $harga = ($durasiInput / 30) * $layan->harga_per_30menit;
                } else {
                    $harga = $layan->nominal;
                    // Menggunakan durasi dari database jika layanan bukan merupakan layanan dengan durasi fleksibel
                    $durasiInput = $layan->durasi;
                }

                BookingLayanan::create([
                    'booking_id' => $booking->booking_id,
                    'layanan_id' => $layananId,
                    'durasi'     => $durasiInput, // Simpan durasi dari input user ke DB
                    'harga'      => $harga        // Simpan harga total
                ]);
            }

            // Simpan slot dan update status is_available menjadi false
            foreach ($req->slot_jadwal_id as $slotId) {
                // Simpan relasi booking_slot
                BookingSlot::create([
                    'booking_id'     => $booking->booking_id,
                    'slot_jadwal_id' => $slotId
                ]);

                // Update status slot agar tidak bisa dipilih lagi
                SlotJadwal::where('slot_jadwal_id', $slotId)->update([
                    'is_available' => 0
                ]);
            }

            \DB::commit();

            return redirect()
                ->route('dashboard.histori')
                ->with('status', 'Booking berhasil dibuat untuk tanggal ' . $tanggalBooking);

        } catch (\Exception $e) {
            \DB::rollBack();
            // Debugging: Tampilkan pesan error asli jika terjadi masalah
            return back()->with('status', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}
