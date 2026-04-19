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
            ->orderBy('tanggal_booking', 'desc'); // Urutkan berdasarkan tanggal booking terbaru terlebih dahulu

        if ($status && in_array($status, ['menunggu', 'diterima', 'ditolak', 'dibatalkan', 'selesai'])) {
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
            'status' => 'required|in:diterima,ditolak,dibatalkan,selesai'
        ]);

        $booking = Booking::with('bookingSlots')->findOrFail($id);
        $oldStatus = $booking->status;
        $newStatus = $request->status;

        $allowedTransitions = [
            'menunggu' => ['diterima', 'ditolak'],
            'diterima' => ['selesai', 'dibatalkan'],
        ];

        if (!isset($allowedTransitions[$oldStatus]) || !in_array($newStatus, $allowedTransitions[$oldStatus])) {
            return back()->with('status', 'Transisi status tidak valid untuk booking ini.');
        }

        // Jika booking ditolak / dibatalkan, slot jadwal dibuka kembali
        if (in_array($newStatus, ['ditolak', 'dibatalkan'])) {
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

    public function searchBooking(Request $request)
    {
        $keyword = trim((string) $request->query('q', ''));
        $status = $request->query('filter');

        $query = Booking::with(['user', 'bookingLayanans.layanan', 'bookingSlots.slotJadwal'])
            ->orderBy('tanggal_booking', 'desc'); // Urutkan berdasarkan tanggal booking terbaru terlebih dahulu

        if ($status && in_array($status, ['menunggu', 'diterima', 'ditolak', 'dibatalkan', 'selesai'])) {
            $query->where('status', $status);
        }

        if ($keyword !== '') {
            $query->where(function ($builder) use ($keyword) {
                $builder->whereHas('user', function ($userQuery) use ($keyword) {
                    $userQuery->where('username', 'like', "%{$keyword}%")
                        ->orWhere('no_hp', 'like', "%{$keyword}%");
                })
                    ->orWhereDate('tanggal_booking', $keyword)
                    ->orWhereRaw("DATE_FORMAT(tanggal_booking, '%d-%m-%Y') LIKE ?", ["%{$keyword}%"])
                    ->orWhereRaw("DATE_FORMAT(tanggal_booking, '%d/%m/%Y') LIKE ?", ["%{$keyword}%"]);
            });
        }

        $bookings = $query->limit(100)->get();

        $result = $bookings->map(function ($booking) {
            $firstSlot = $booking->bookingSlots->sortBy('slotJadwal.waktu')->first();
            $jamMulai = $firstSlot ? Carbon::parse($firstSlot->slotJadwal->waktu)->format('H:i') : '-';
            $total = $booking->bookingLayanans->sum('harga');
            $tanggalIndo = Carbon::parse($booking->tanggal_booking)->locale('id')->isoFormat('dddd, D MMMM Y');

            return [
                'id' => $booking->booking_id,
                'nama' => $booking->user->username ?? 'User Terhapus',
                'no_hp' => $booking->user->no_hp ?? '-',
                'alamat' => $booking->user->alamat ?? '-',
                'tanggal_short' => Carbon::parse($booking->tanggal_booking)->locale('id')->format('d M Y'),
                'tanggal_indo' => $tanggalIndo,
                'jam_mulai' => $jamMulai,
                'status' => $booking->status,
                'status_label' => ucfirst($booking->status),
                'total' => number_format($total, 0, ',', '.'),
                'total_display' => 'Rp ' . number_format($total, 0, ',', '.') . ',00',
                'update_url' => route('admin.booking.update', $booking->booking_id),
                'layanans' => $booking->bookingLayanans->map(function ($detail) {
                    return [
                        'nama' => $detail->layanan->nama_layanan ?? '-',
                        'durasi' => $detail->durasi,
                        'harga' => number_format($detail->harga, 0, ',', '.'),
                    ];
                })->values(),
            ];
        })->values();

        return response()->json($result);
    }

    public function laporan()
    {
        $request = request();
        $availableYears = Booking::selectRaw('YEAR(tanggal_booking) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->filter()
            ->values();

        $currentYear = Carbon::now()->year;
        $year = (int) $request->query('year', $currentYear);
        if (!$availableYears->contains($year)) {
            $year = $availableYears->first() ?? $currentYear;
        }

        $month = Carbon::now()->month;

        $rawBookingBulanan = Booking::selectRaw('MONTH(tanggal_booking) as bulan, COUNT(*) as total')
            ->where('status', 'selesai')
            ->whereYear('tanggal_booking', $year)
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $bookingBulanan = collect(range(1, 12))->map(function ($bulan) use ($rawBookingBulanan) {
            return (object) [
                'bulan' => $bulan,
                'total' => $rawBookingBulanan[$bulan] ?? 0
            ];
        });

        // Booking bulan ini (dari tahun terpilih)
        $totalBookingBulanIni = Booking::where('status', 'selesai')
            ->whereMonth('tanggal_booking', $month)
            ->whereYear('tanggal_booking', $year)
            ->count();

        // Booking per status
        $bookingDiterima = Booking::where('status', 'diterima')->whereYear('tanggal_booking', $year)->count();
        $bookingMenunggu = Booking::where('status', 'menunggu')->whereYear('tanggal_booking', $year)->count();
        $bookingDitolak  = Booking::where('status', 'ditolak')->whereYear('tanggal_booking', $year)->count();
        $bookingDibatalkan  = Booking::where('status', 'dibatalkan')->whereYear('tanggal_booking', $year)->count();

        // Pendapatan per bulan (status selesai, tahun terpilih)
        $rawPendapatanBulanan = BookingLayanan::join(
            'bookings',
            'booking_layanans.booking_id',
            '=',
            'bookings.booking_id'
        )
            ->where('bookings.status', 'selesai')
            ->whereYear('bookings.tanggal_booking', $year)
            ->selectRaw('MONTH(bookings.tanggal_booking) as bulan, SUM(booking_layanans.harga) as total')
            ->groupByRaw('MONTH(bookings.tanggal_booking)')
            ->pluck('total', 'bulan');

        $pendapatanBulanan = collect(range(1, 12))->map(function ($bulan) use ($rawPendapatanBulanan) {
            return (float) ($rawPendapatanBulanan[$bulan] ?? 0);
        });

        $chartLabels = collect(range(1, 12))
            ->map(fn ($bulan) => Carbon::create()->month($bulan)->translatedFormat('F'))
            ->values();

        $chartData = $pendapatanBulanan;
        $chartLegend = 'Total Pendapatan Bulanan';

        $bookingChartLabels = $chartLabels;
        $bookingChartData = collect($bookingBulanan)->map(function ($item) {
            return (int) $item->total;
        })->values();

        $completedBookings = Booking::with(['user', 'bookingLayanans.layanan', 'bookingSlots.slotJadwal'])
            ->where('status', 'selesai')
            ->whereYear('tanggal_booking', $year)
            ->orderBy('tanggal_booking', 'asc')
            ->orderBy('booking_id', 'asc')
            ->get();

        $reportGroups = $completedBookings
            ->groupBy(function ($booking) {
                return Carbon::parse($booking->tanggal_booking)->format('m');
            })
            ->map(function ($bookingsByMonth, $monthNumber) {
                $monthNumber = (int) $monthNumber;

                return [
                    'month' => $monthNumber,
                    'label' => Carbon::create()->month($monthNumber)->locale('id')->isoFormat('MMMM'),
                    'items' => $bookingsByMonth->map(function ($booking) {
                        $firstSlot = $booking->bookingSlots->sortBy('slotJadwal.waktu')->first();
                        $jamMulai = $firstSlot ? Carbon::parse($firstSlot->slotJadwal->waktu)->format('H:i') : '-';
                        $total = $booking->bookingLayanans->sum('harga');

                        return [
                            'id' => $booking->booking_id,
                            'nama' => $booking->user->username ?? 'User Terhapus',
                            'no_hp' => $booking->user->no_hp ?? '-',
                            'alamat' => $booking->user->alamat ?? '-',
                            'tanggal_short' => Carbon::parse($booking->tanggal_booking)->locale('id')->format('d M Y'),
                            'tanggal_indo' => Carbon::parse($booking->tanggal_booking)->locale('id')->isoFormat('dddd, D MMMM Y'),
                            'jam_mulai' => $jamMulai,
                            'status' => $booking->status,
                            'status_label' => ucfirst($booking->status),
                            'total' => (int) $total,
                            'total_display' => 'Rp ' . number_format($total, 0, ',', '.') . ',00',
                            'layanans' => $booking->bookingLayanans->map(function ($detail) {
                                return [
                                    'nama' => $detail->layanan->nama_layanan ?? '-',
                                    'durasi' => $detail->durasi,
                                    'harga' => number_format($detail->harga, 0, ',', '.'),
                                ];
                            })->values(),
                        ];
                    })->values(),
                ];
            })
            ->sortBy('month')
            ->values();

        $pendapatan = $pendapatanBulanan->sum();

        return view('admin.dashboard.laporan', ['currentTab' => 'laporan',], compact(
            'availableYears',
            'year',
            'chartLabels',
            'chartData',
            'chartLegend',
            'bookingChartLabels',
            'bookingChartData',
            'reportGroups',
            'totalBookingBulanIni',
            'bookingDiterima',
            'bookingMenunggu',
            'bookingDitolak',
            'bookingDibatalkan',
            'pendapatan',
            'bookingBulanan'

        ));
    }

    public function jadwal()
    {
        $selectedDate = request()->query('tanggal', Carbon::tomorrow()->toDateString());

        $availableDates = SlotJadwal::query()
            ->select('tanggal')
            ->distinct()
            ->orderBy('tanggal', 'asc')
            ->pluck('tanggal')
            ->map(fn ($date) => Carbon::parse($date)->toDateString());

        if (!$availableDates->contains($selectedDate)) {
            $selectedDate = $availableDates->first() ?? Carbon::tomorrow()->toDateString();
        }

        $slots = SlotJadwal::query()
            ->whereDate('tanggal', $selectedDate)
            ->orderBy('waktu', 'asc')
            ->get();

        $timeOptions = $slots
            ->pluck('waktu')
            ->map(fn ($time) => Carbon::parse($time)->format('H:i'))
            ->values();

        $totalSlots = $slots->count();
        $disabledSlots = $slots->where('is_disabled', true)->count();
        $bookedSlots = $slots->where('is_disabled', false)->where('is_available', false)->count();
        $availableSlots = $slots->where('is_disabled', false)->where('is_available', true)->count();

        return view('admin.dashboard.jadwal', array_merge($this->userData(), [
            'currentTab' => 'jadwal',
            'selectedDate' => $selectedDate,
            'selectedDateLabel' => Carbon::parse($selectedDate)->locale('id')->isoFormat('dddd, D MMMM Y'),
            'availableDates' => $availableDates,
            'slots' => $slots,
            'timeOptions' => $timeOptions,
            'totalSlots' => $totalSlots,
            'disabledSlots' => $disabledSlots,
            'bookedSlots' => $bookedSlots,
            'availableSlots' => $availableSlots,
        ]));
    }

    public function updateJadwalDayStatus(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'action' => 'required|in:disable,enable',
        ]);

        $isDisabled = $validated['action'] === 'disable';

        $updated = SlotJadwal::query()
            ->whereDate('tanggal', $validated['tanggal'])
            ->update([
                'is_disabled' => $isDisabled,
            ]);

        $statusText = $isDisabled ? 'dinonaktifkan' : 'diaktifkan kembali';

        return redirect()
            ->route('admin.dashboard.jadwal', ['tanggal' => $validated['tanggal']])
            ->with('status', "Berhasil {$statusText} untuk {$updated} slot pada tanggal terpilih.");
    }

    public function updateJadwalRangeStatus(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'action' => 'required|in:disable,enable',
        ]);

        $isDisabled = $validated['action'] === 'disable';

        $updated = SlotJadwal::query()
            ->whereDate('tanggal', $validated['tanggal'])
            ->whereTime('waktu', '>=', $validated['start_time'])
            ->whereTime('waktu', '<', $validated['end_time'])
            ->update([
                'is_disabled' => $isDisabled,
            ]);

        $statusText = $isDisabled ? 'dinonaktifkan' : 'diaktifkan kembali';

        return redirect()
            ->route('admin.dashboard.jadwal', ['tanggal' => $validated['tanggal']])
            ->with('status', "Rentang jam berhasil {$statusText} untuk {$updated} slot.");
    }

    public function updateJadwalSlotStatus(Request $request, $slot)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'action' => 'required|in:disable,enable',
        ]);

        $slotJadwal = SlotJadwal::query()->findOrFail($slot);
        $isDisabled = $validated['action'] === 'disable';

        $slotJadwal->update([
            'is_disabled' => $isDisabled,
        ]);

        $statusText = $isDisabled ? 'dinonaktifkan' : 'diaktifkan kembali';
        $jam = Carbon::parse($slotJadwal->waktu)->format('H:i');

        return redirect()
            ->route('admin.dashboard.jadwal', ['tanggal' => $validated['tanggal']])
            ->with('status', "Slot {$jam} berhasil {$statusText}.");
    }
}
