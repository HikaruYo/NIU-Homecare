<div class="flex flex-col h-full bg-mainGray shadow-lg rounded-lg">
    @if (session('status'))
        <div id="status-alert"
             class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg right-2 absolute mb-4 transition-opacity duration-1000 ease-out"
             role="alert">
            <span class="block sm:inline">{{ session('status') }}</span>
        </div>
    @endif

    <div class="mx-6 py-2.5 text-4xl font-semibold border-b-2 border-gray-200">
        Riwayat Pemesanan
    </div>

    {{-- TODO: buat filter --}}
    <div class="flex justify-between items-center w-full my-4 mx-6">
        {{-- Dropdown Container --}}
        <div class="relative w-[26%] justify-between">
            {{-- Tombol Filter --}}
            <button
                id="filterDropdownBtn"
                type="button"
                class="flex items-center cursor-pointer text-gray-800 focus:outline-none font-medium w-full justify-between"
            >
                <p>Filter Berdasarkan : <span class="ml-1  capitalize">{{ $currentStatus ?? 'Semua' }}</span></p>
                <svg class="w-6 h-6 ml-1 transition-transform duration-300" id="filterDropdownArrow"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="currentColor" d="m12 15l-4-4h8l-4 4"/>
                </svg>
            </button>

            {{-- Dropdown Menu --}}
            <div id="filterDropdownMenu" class="absolute left-0 mt-2 w-48 bg-white border border-gray-200 rounded-xl shadow-xl hidden z-50">
                <a href="{{ route('dashboard.histori') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition">Semua</a>
                <a href="{{ route('dashboard.histori', ['status' => 'menunggu']) }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition">Menunggu</a>
                <a href="{{ route('dashboard.histori', ['status' => 'diterima']) }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition">Diterima</a>
                <a href="{{ route('dashboard.histori', ['status' => 'ditolak']) }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition">Ditolak</a>
                <a href="{{ route('dashboard.histori', ['status' => 'dibatalkan']) }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition">Dibatalkan</a>
            </div>

        </div>
    </div>

    <div class="mx-6 mb-4 overflow-y-auto no-scrollbar">
        @if($bookings->isEmpty())
            <div class="text-center text-lg text-gray-500 mt-10">
                <p>Belum ada riwayat pemesanan.</p>
                <a href="{{ url('/') }}#pesan" class="text-mainColor underline hover:text-shadow-green-600"
                >
                    Pesan sekarang
                </a>
            </div>
        @else
            <div class="grid gap-6">
                @foreach($bookings as $booking)
                    <div class="booking-card cursor-pointer transform transition-all bg-white p-4 shadow-sm rounded-xl border border-gray-100 flex flex-col gap-4 relative"
                         data-booking="{{ json_encode([
                         'id' => $booking->booking_id,
                         'nama' => $booking->user->username,
                         'no_hp' => $booking->user->no_hp,
                         'alamat' => $booking->user->alamat,
                         'tanggal_booking' => $booking->tanggal_booking->format('Y-m-d'),
                         'tanggal_indo' => $booking->tanggal_booking->locale('id')->isoFormat('dddd, D MMMM Y'),
                         'status' => $booking->status,
                         'layanans' => $booking->bookingLayanans->map(function($bl) {
                             return [
                                 'nama' => $bl->layanan->nama_layanan ?? 'Layanan',
                                 'harga' => number_format($bl->harga, 0, ',', '.'),
                                 'durasi' => $bl->durasi
                             ];
                         })
                     ]) }}">
                        <div class="flex justify-between items-start mb-4">
                            <div>
{{--                                <p class="text-sm text-gray-500">No. Booking: #{{ $booking->booking_id }}</p>--}}
                                <p class="font-semibold text-lg">
                                    {{ \Carbon\Carbon::parse($booking->tanggal_booking)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                                </p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-sm font-medium capitalize
                                {{ $booking->status == 'menunggu' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $booking->status == 'diterima' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $booking->status == 'ditolak' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $booking->status == 'dibatalkan' ? 'bg-gray-100 text-gray-700' : '' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>

                        <div class="border-t border-gray-200 pt-2">
                            <h3 class="text-gray-400 mb-2">Detail Layanan:</h3>
                            <ul class="">
                                @php $totalTagihan = 0; @endphp
                                @foreach($booking->bookingLayanans as $item)
                                    <li class="flex justify-between text-gray-700">
                                    <span>
                                        {{ $item->layanan->nama_layanan ?? 'Layanan Dihapus' }}
                                        <span class="text-xs text-gray-500">({{ $item->durasi }} menit)</span>
                                    </span>
                                        <span>Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                    </li>
                                    @php $totalTagihan += $item->harga; @endphp
                                @endforeach
                            </ul>
                        </div>

                        <div class="border-t border-gray-200 mt-4 pt-4 flex justify-between items-center">
                            <span class="font-bold text-lg">Total Tarif</span>
                            <span
                                class="font-bold text-lg">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <div id="detailModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity bg-black/40 backdrop-blur-sm"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                    <div id="detailModalContent" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full opacity-0 scale-95 duration-300">
                        <div class="bg-white px-8 py-7">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6">Detail Pesanan</h2>

                            <div class="space-y-4">
                                {{-- Info Pelanggan --}}
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-[10px] text-gray-400 uppercase font-bold">Nama Pelanggan</p>
                                        <p id="modal-nama" class="text-sm font-semibold text-gray-800"></p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] text-gray-400 uppercase font-bold">No. WhatsApp</p>
                                        <p id="modal-hp" class="text-sm font-semibold text-gray-800"></p>
                                    </div>
                                </div>

                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold">Alamat Kedatangan</p>
                                    <p id="modal-alamat" class="text-sm font-semibold text-gray-800"></p>
                                </div>

                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold mb-2">Layanan Yang Dipilih</p>
                                    <div id="modal-layanans-list" class="space-y-2 bg-gray-50 p-3 rounded-xl">
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-gray-100">
                                    <p class="text-[10px] text-gray-400 uppercase font-bold">Waktu Jadwal</p>
                                    <p id="modal-jadwal" class="text-sm font-bold text-mainColor"></p>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="mt-8 flex gap-3">
                                <button type="button" class="close-detail-modal flex-1 px-4 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition cursor-pointer">
                                    Tutup
                                </button>

                                <form id="cancelForm" method="POST" class="flex-1 hidden">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" id="btn-cancel-submit" class="w-full px-4 py-3 font-bold rounded-xl transition">
                                        Batalkan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .custom-tooltip {
                    position: fixed; display: none; background: #374151; color: white;
                    padding: 8px 12px; border-radius: 8px; font-size: 12px; z-index: 9999;
                    pointer-events: none; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
                }
            </style>
            <div id="tooltip-msg" class="custom-tooltip">Tidak bisa membatalkan di hari yang sama dengan jadwal</div>
        @endif
    </div>
</div>
