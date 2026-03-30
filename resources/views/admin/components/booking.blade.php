<div class="flex flex-col w-full h-full gap-4 bg-mainGray shadow-lg rounded-lg">
    {{-- Notification --}}
    @if (session('status'))
        <div id="status-alert"
            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg right-2 absolute mb-4 transition-opacity duration-1000 ease-out"
            role="alert">
            <span class="block sm:inline">{{ session('status') }}</span>
        </div>
    @endif
    @if (session('success'))
        {{-- TODO: sesuaikan penempatan dan ubah animasi jadi bergeser ke samping --}}
        <div id="status-alert"
            class="bg-thirdColor border border-gray-400 text-black px-4 py-3 rounded-lg right-3 top-2 absolute mb-4 transition-opacity duration-1000 ease-out"
            role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="mx-6 py-2.5 text-4xl font-semibold border-b-2 border-gray-200">
        Daftar Pesanan Masuk
    </div>

    <div class="flex justify-between items-center w-full px-6">
        {{-- Dropdown Container --}}
        <div class="relative">
            {{-- Tombol Filter --}}
            <button id="filterDropdownBtn" type="button"
                class="flex items-center cursor-pointer text-gray-800 focus:outline-none font-medium w-full justify-between">
                <p>Filter Berdasarkan : <span class="ml-1 capitalize">{{ $currentStatus ?? 'Semua' }}</span></p>
                <svg class="w-6 h-6 ml-1 transition-transform duration-300" id="filterDropdownArrow"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="currentColor" d="m12 15l-4-4h8l-4 4" />
                </svg>
            </button>

            {{-- Dropdown Menu --}}
            {{-- TODO: tambah filter dibatalkan --}}
            <div id="filterDropdownMenu"
                class="absolute left-0 mt-2 w-44 bg-white rounded-lg shadow-xl z-50 py-2 border border-gray-200 hidden">
                <a href="{{ route('admin.dashboard.booking') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Semua</a>
                <a href="{{ route('admin.dashboard.booking', ['filter' => 'menunggu']) }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Menunggu</a>
                <a href="{{ route('admin.dashboard.booking', ['filter' => 'diterima']) }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Diterima</a>
                <a href="{{ route('admin.dashboard.booking', ['filter' => 'ditolak']) }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ditolak</a>
            </div>
        </div>
    </div>

    <div class="px-6 flex-1 min-h-0">
        <div class="bg-white shadow rounded-lg border border-gray-200 flex flex-col h-full">
            <div class="overflow-y-auto h-full relative scrollbar-thin scrollbar-thumb-gray-300">
                <table class="w-full table-fixed border-separate border-spacing-0">
                    <thead class="sticky top-0 z-10">
                        <tr class="bg-gray-200 font-bold">
                            <th class="p-3 pl-6 text-left w-[5%] border-b border-gray-300 bg-gray-200">No</th>
                            <th class="p-3 pl-6 text-left w-[15%] border-b border-gray-300 bg-gray-200">Pelanggan</th>
                            <th class="p-3 pl-6 text-left w-[20%] border-b border-gray-300 bg-gray-200">Tanggal & Jam
                            </th>
                            <th class="p-3 pl-6 text-left w-[35%] border-b border-gray-300 bg-gray-200">Layanan & Total
                            </th>
                            <th class="p-3 text-center w-[10%] border-b border-gray-300 bg-gray-200">Status</th>
                            <th class="p-3 text-center w-[15%] border-b border-gray-300 bg-gray-200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 font-light">
                        @forelse($bookings as $index => $booking)
                            @php
                                $firstSlot = $booking->bookingSlots->sortBy('slotJadwal.waktu')->first();
                                $jamMulai = $firstSlot
                                    ? \Carbon\Carbon::parse($firstSlot->slotJadwal->waktu)->format('H:i')
                                    : '-';
                                $total = $booking->bookingLayanans->sum('harga');
                                $bookingPayload = [
                                    'id' => $booking->booking_id,
                                    'nama' => $booking->user->username ?? 'User Terhapus',
                                    'no_hp' => $booking->user->no_hp ?? '-',
                                    'alamat' => $booking->user->alamat ?? '-',
                                    'tanggal_indo' => \Carbon\Carbon::parse($booking->tanggal_booking)
                                        ->locale('id')
                                        ->isoFormat('dddd, D MMMM Y'),
                                    'jam_mulai' => $jamMulai,
                                    'status' => $booking->status,
                                    'status_label' => ucfirst($booking->status),
                                    'total' => number_format($total, 0, ',', '.'),
                                    'update_url' => route('admin.booking.update', $booking->booking_id),
                                    'layanans' => $booking->bookingLayanans
                                        ->map(function ($detail) {
                                            return [
                                                'nama' => $detail->layanan->nama_layanan ?? '-',
                                                'durasi' => $detail->durasi,
                                                'harga' => number_format($detail->harga, 0, ',', '.'),
                                            ];
                                        })
                                        ->values()
                                        ->all(),
                                ];
                            @endphp
                            <tr class="admin-booking-row border-b border-gray-200 hover:bg-gray-50 transition cursor-pointer"
                                data-booking='@json($bookingPayload)'>
                                <td class="p-3 pl-6 text-left border-b border-gray-100">
                                    {{ $bookings->firstItem() + $index }}
                                </td>
                                <td class="p-3 pl-6 text-left border-b border-gray-100">
                                    <p class="font-medium text-gray-800">
                                        {{ $booking->user->username ?? 'User Terhapus' }}</p>
                                    <p class="text-sm text-gray-500">{{ $booking->user->no_hp ?? '-' }}</p>
                                </td>
                                <td class="p-3 pl-6 text-left border-b border-gray-100">
                                    <p>{{ \Carbon\Carbon::parse($booking->tanggal_booking)->locale('id')->format('d M Y') }}
                                    </p>
                                    <p class="text-sm font-bold text-mainColor">Jam {{ $jamMulai }}</p>
                                </td>
                                <td class="p-3 pl-6 text-left text-sm border-b border-gray-100">
                                    <ul class="list-disc list-inside">
                                        @foreach ($booking->bookingLayanans as $detail)
                                            <li>{{ $detail->layanan->nama_layanan ?? '-' }} ({{ $detail->durasi }}
                                                menit)</li>
                                        @endforeach
                                    </ul>
                                    <p class="font-bold text-gray-800">Rp {{ number_format($total, 0, ',', '.') }},00
                                    </p>
                                </td>
                                <td class="p-3 text-center border-b border-gray-100">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold uppercase
                                        {{ $booking->status == 'diterima'
                                            ? 'bg-green-200 text-green-800'
                                            : ($booking->status == 'ditolak'
                                                ? 'bg-red-200 text-red-800'
                                                : ($booking->status == 'dibatalkan'
                                                    ? 'bg-gray-200 text-gray-800'
                                                    : 'bg-yellow-200 text-yellow-800')) }}
                                    ">
                                        {{ $booking->status }}
                                    </span>
                                </td>
                                <td class="p-3 text-center border-b border-gray-100">
                                    <span class="text-gray-500 text-xs font-semibold uppercase">Klik untuk detail</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-10 text-gray-400">Tidak ada data pesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="adminDetailModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-black/40 backdrop-blur-sm"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div id="adminDetailModalContent"
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full opacity-0 scale-95 duration-300">
                <div class="bg-white px-8 py-7">
                    <div class="flex items-start justify-between gap-3 mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Detail Pesanan</h2>
                        <span id="admin-modal-status" class="px-3 py-1 rounded-full text-xs font-bold uppercase"></span>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-bold">Nama Pelanggan</p>
                                <p id="admin-modal-nama" class="text-sm font-semibold text-gray-800"></p>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-bold">No. WhatsApp</p>
                                <p id="admin-modal-hp" class="text-sm font-semibold text-gray-800"></p>
                            </div>
                        </div>

                        <div>
                            <p class="text-[10px] text-gray-400 uppercase font-bold">Alamat Kedatangan</p>
                            <p id="admin-modal-alamat" class="text-sm font-semibold text-gray-800"></p>
                        </div>

                        <div>
                            <p class="text-[10px] text-gray-400 uppercase font-bold mb-2">Layanan Yang Dipilih</p>
                            <div id="admin-modal-layanans-list" class="space-y-2 bg-gray-50 p-3 rounded-xl"></div>
                        </div>

                        <div class="pt-4 border-t border-gray-100">
                            <p class="text-[10px] text-gray-400 uppercase font-bold">Waktu Jadwal</p>
                            <p id="admin-modal-jadwal" class="text-sm font-bold text-mainColor"></p>
                        </div>

                        <div class="flex justify-between items-center border-t border-gray-100 pt-4">
                            <p class="text-[10px] text-gray-400 uppercase font-bold">Total Tarif</p>
                            <p id="admin-modal-total" class="text-base font-bold text-gray-900"></p>
                        </div>
                    </div>

                    <p id="admin-modal-status-note" class="hidden mt-6 text-sm font-semibold text-gray-500"></p>

                    <div class="mt-8 flex gap-3">
                        <button type="button"
                            class="close-admin-detail-modal flex-1 px-4 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition cursor-pointer">
                            Tutup
                        </button>

                        <form id="adminRejectForm" method="POST" class="flex-1 hidden"
                            onsubmit="return confirm('Tolak pesanan ini? Slot jadwal akan dibuka kembali.');">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="ditolak">
                            <button type="submit"
                                class="w-full px-4 py-3 bg-red-50 text-red-600 font-bold rounded-xl hover:bg-red-100 transition cursor-pointer">
                                Tolak
                            </button>
                        </form>

                        <form id="adminAcceptForm" method="POST" class="flex-1 hidden"
                            onsubmit="return confirm('Terima pesanan ini?');">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="diterima">
                            <button type="submit"
                                class="w-full px-4 py-3 bg-green-50 text-green-600 font-bold rounded-xl hover:bg-green-100 transition cursor-pointer">
                                Terima
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        {{ $bookings->links() }}
    </div>
</div>
