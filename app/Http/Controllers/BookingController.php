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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
            'no_hp'           => 'string|max:15',
            'alamat'          => 'string|max:255',
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
            // Update Data User (Alamat & No HP)
            // Data user akan selalu diupdate dengan inputan terakhir dari form konfirmasi
            $user = Auth::user();
            $user->update([
                'no_hp' => $req->no_hp,
                'alamat' => $req->alamat
            ]);

            // Simpan booking
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'tanggal_booking' => \Carbon\Carbon::parse($req->tanggal_booking),
                'status' => 'menunggu'
            ]);

            // Variabel bantu untuk data n8n
            $listLayananDikirim = [];
            $totalTagihan = 0;

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

                // Kumpulkan data untuk n8n
                $totalTagihan += $harga;
                $listLayananDikirim[] = [
                    'nama_layanan' => $layan->nama_layanan ?? 'Layanan ID: '.$layananId,
                    'durasi' => $durasiInput,
                ];
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

            // Kirim data ke n8n setelah commit DB berhasil
            try {
                // Ambil slot pertama yang dipilih user sebagai "Jam Mulai"
                $slotPertamaId = $req->slot_jadwal_id[0] ?? null;
                $jamMulai = '00:00'; // Default fallback

                if ($slotPertamaId) {
                    $slotData = SlotJadwal::find($slotPertamaId);
                    if ($slotData) {
                        // Ambil kolom 'waktu' dari tabel slot_jadwals
                        $jamMulai = \Carbon\Carbon::parse($slotData->waktu)->format('H:i');
                    }
                }

                // Payload JSON
                $payloadN8n = [
                    'booking_id' => $booking->booking_id,
                    'tanggal_booking' => $booking->tanggal_booking->locale('id')->isoFormat('dddd, D MMMM Y'),
                    'jam_booking' => $jamMulai,
                    'customer' => [
                        'nama' => $user->username,
                        'email' => $user->email,
                        'whatsapp' => $req->no_hp,
                        'alamat' => $req->alamat,
                    ],
                    'detail_pesanan' => $listLayananDikirim,
                    'total_biaya' => $totalTagihan,
                    'status' => 'menunggu'
                ];

                $n8nUrl = env('N8N_WEBHOOK_URL', 'http://localhost:5678/webhook-test/niu-homecare');

                Http::post($n8nUrl, $payloadN8n);

            } catch (\Exception $e) {
                // gunakan try-catch terpisah agar jika n8n error/down,
                // user tetap berhasil booking (tidak error page)
                Log::error('Gagal mengirim webhook ke n8n: ' . $e->getMessage());
            }

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
