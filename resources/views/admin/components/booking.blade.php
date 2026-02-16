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
            <button
                id="filterDropdownBtn"
                type="button"
                class="flex items-center cursor-pointer text-gray-800 focus:outline-none font-medium w-full justify-between"
            >
                <p>Filter Berdasarkan : <span class="ml-1 capitalize">{{ $currentStatus ?? 'Semua' }}</span></p>
                <svg class="w-6 h-6 ml-1 transition-transform duration-300" id="filterDropdownArrow"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="currentColor" d="m12 15l-4-4h8l-4 4"/>
                </svg>
            </button>

            {{-- Dropdown Menu --}}
            {{-- TODO: tambah filter dibatalkan --}}
            <div id="filterDropdownMenu" class="absolute left-0 mt-2 w-44 bg-white rounded-lg shadow-xl z-50 py-2 border border-gray-200 hidden">
                <a href="{{ route('admin.dashboard.booking') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Semua</a>
                <a href="{{ route('admin.dashboard.booking', ['filter' => 'menunggu']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Menunggu</a>
                <a href="{{ route('admin.dashboard.booking', ['filter' => 'diterima']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Diterima</a>
                <a href="{{ route('admin.dashboard.booking', ['filter' => 'ditolak']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ditolak</a>
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
                        <th class="p-3 pl-6 text-left w-[20%] border-b border-gray-300 bg-gray-200">Tanggal & Jam</th>
                        <th class="p-3 pl-6 text-left w-[35%] border-b border-gray-300 bg-gray-200">Layanan & Total</th>
                        <th class="p-3 text-center w-[10%] border-b border-gray-300 bg-gray-200">Status</th>
                        <th class="p-3 text-center w-[15%] border-b border-gray-300 bg-gray-200">Aksi</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-600 font-light">
                    @forelse($bookings as $index => $booking)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                            <td class="p-3 pl-6 text-left border-b border-gray-100">
                                {{ $bookings->firstItem() + $index }}
                            </td>
                            <td class="p-3 pl-6 text-left border-b border-gray-100">
                                <p class="font-medium text-gray-800">{{ $booking->user->username ?? 'User Terhapus' }}</p>
                                <p class="text-sm text-gray-500">{{ $booking->user->no_hp ?? '-' }}</p>
                            </td>
                            <td class="p-3 pl-6 text-left border-b border-gray-100">
                                <p>{{ \Carbon\Carbon::parse($booking->tanggal_booking)->locale('id')->format('d M Y') }}</p>
                                @php
                                    $firstSlot = $booking->bookingSlots->sortBy('slotJadwal.waktu')->first();
                                    $jamMulai = $firstSlot ? \Carbon\Carbon::parse($firstSlot->slotJadwal->waktu)->format('H:i') : '-';
                                @endphp
                                <p class="text-sm font-bold text-mainColor">Jam {{ $jamMulai }}</p>
                            </td>
                            <td class="p-3 pl-6 text-left text-sm border-b border-gray-100">
                                <ul class="list-disc list-inside">
                                    @php $total = 0; @endphp
                                    @foreach($booking->bookingLayanans as $detail)
                                        <li>{{ $detail->layanan->nama_layanan ?? '-' }} ({{ $detail->durasi }} menit)</li>
                                        @php $total += $detail->harga; @endphp
                                    @endforeach
                                </ul>
                                <p class="font-bold text-gray-800">Rp {{ number_format($total, 0, ',', '.') }},00</p>
                            </td>
                            <td class="p-3 text-center border-b border-gray-100">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase
                                        {{
                                            $booking->status == 'diterima' ? 'bg-green-200 text-green-800' :
                                            ($booking->status == 'ditolak' ? 'bg-red-200 text-red-800' :
                                            ($booking->status == 'dibatalkan' ? 'bg-gray-200 text-gray-800' : 'bg-yellow-200 text-yellow-800'))
                                        }}
                                    ">
                                        {{ $booking->status }}
                                    </span>
                            </td>
                            <td class="p-3 text-center border-b border-gray-100">
                                @if($booking->status == 'menunggu')
                                    <div class="flex item-center justify-center gap-2">
                                        <form action="{{ route('admin.booking.update', $booking->booking_id) }}" method="POST"
                                              onsubmit="return confirm('Terima pesanan ini?');">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="diterima">
                                            <button type="submit" class="w-8 h-8 rounded-full bg-green-100 text-green-600 hover:bg-green-200 flex items-center justify-center cursor-pointer transition" title="Terima">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.booking.update', $booking->booking_id) }}" method="POST"
                                              onsubmit="return confirm('Tolak pesanan ini? Slot jadwal akan dibuka kembali.');">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="ditolak">
                                            <button type="submit" class="w-8 h-8 rounded-full bg-red-100 text-red-600 hover:bg-red-200 flex items-center justify-center cursor-pointer transition" title="Tolak">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-gray-400 text-xs font-semibold uppercase">Selesai</span>
                                @endif
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

    <div>
        {{ $bookings->links() }}
    </div>
</div>
