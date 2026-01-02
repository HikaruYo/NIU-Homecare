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
        <div id="status-alert"
             class="bg-red-200 border border-gray-400 text-black px-4 py-3 rounded-lg right-3 -top-2 absolute mb-4 transition-opacity duration-1000 ease-out"
             role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="mx-6 py-2.5 text-4xl font-semibold border-b-2 border-gray-200">
        Daftar Pesanan Masuk
    </div>

    <div class="flex justify-between items-center w-full px-6 py-2">
        {{-- TODO: buat filter --}}
        {{-- Dropdown Container --}}
        <div class="relative">
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
            <div id="filterDropdownMenu" class="absolute right-0 mt-2 w-44 bg-white rounded-lg shadow-xl z-50 py-2 border border-gray-200 hidden">
                <a href="{{ route('admin.dashboard.booking') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Semua</a>
                <a href="{{ route('admin.dashboard.booking', ['filter' => 'menunggu']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Menunggu</a>
                <a href="{{ route('admin.dashboard.booking', ['filter' => 'diterima']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Diterima</a>
                <a href="{{ route('admin.dashboard.booking', ['filter' => 'ditolak']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ditolak</a>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-md rounded mx-6 overflow-x-auto">
        <table class="min-w-full w-full table-auto">
            <thead>
                <tr class="bg-gray-200 leading-normal">
                    <th class="py-3 pl-6 text-left">No</th>
                    <th class="py-3 pl-6 text-left">Pelanggan</th>
                    <th class="py-3 pl-6 text-left">Tanggal dan Jam</th>
                    <th class="py-3 pl-6 text-left">Layanan dan Total Harga</th>
                    <th class="py-3 pl-6 text-center">Status</th>
                    <th class="py-3 pl-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 font-light">
                @forelse($bookings as $index => $booking)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 pl-6 text-left whitespace-nowrap">
                            {{ $bookings->firstItem() + $index }}
                        </td>
                        <td class="py-3 pl-6 text-left">
                            <p class="font-medium">{{ $booking->user->username ?? 'User Terhapus' }}</p>
                            <p class="text-sm text-gray-500">{{ $booking->user->no_hp ?? '-' }}</p>
                        </td>
                        <td class="py-3 pl-6 text-left">
                            <p>{{ \Carbon\Carbon::parse($booking->tanggal_booking)->locale('id')->format('d M Y') }}</p>
                            {{-- Tampilkan jam mulai dari slot pertama --}}
                            @php
                                $firstSlot = $booking->bookingSlots->sortBy('slotJadwal.waktu')->first();
                                $jamMulai = $firstSlot ? \Carbon\Carbon::parse($firstSlot->slotJadwal->waktu)->format('H:i') : '-';
                            @endphp
                            <p class="text-sm font-bold">Jam {{ $jamMulai }}</p>
                        </td>
                        <td class="py-3 pl-6 text-left text-sm">
                            <ul class="list-disc list-inside">
                                @php $total = 0; @endphp
                                @foreach($booking->bookingLayanans as $detail)
                                    <li>{{ $detail->layanan->nama_layanan ?? '-' }} ({{ $detail->durasi }} menit)</li>
                                    @php $total += $detail->harga; @endphp
                                @endforeach
                            </ul>
                            <p class="font-bold ">Rp {{ number_format($total, 0, ',', '.') }}</p>
                        </td>
                        <td class="py-3 pl-6 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase
                                    {{ $booking->status == 'diterima' ? 'bg-green-200 text-green-800' : ($booking->status == 'ditolak' ? 'bg-red-200 text-red-800' : 'bg-yellow-200 text-yellow-800') }}">
                                    {{ $booking->status }}
                                </span>
                        </td>
                        <td class="py-3 pl-6 text-center">
                            @if($booking->status == 'menunggu')
                                <div class="flex item-center justify-center gap-2">
                                    {{-- Tombol Terima --}}
                                    <form action="{{ route('admin.booking.update', $booking->booking_id) }}" method="POST"
                                          onsubmit="return confirm('Terima pesanan ini?');">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="diterima">
                                        <button type="submit"
                                                class="w-8 h-8 rounded-full bg-green-100 text-green-600 hover:bg-green-200 flex items-center justify-center cursor-pointer"
                                                title="Terima">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </button>
                                    </form>

                                    {{-- Tombol Tolak --}}
                                    <form action="{{ route('admin.booking.update', $booking->booking_id) }}" method="POST"
                                          onsubmit="return confirm('Tolak pesanan ini? Slot jadwal akan dibuka kembali.');">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="ditolak">
                                        <button type="submit"
                                                class="w-8 h-8 rounded-full bg-red-100 text-red-600 hover:bg-red-200 flex items-center justify-center cursor-pointer"
                                                title="Tolak">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-gray-400 text-sm">Selesai</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">Tidak ada data pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mx-6 mb-2 items-center">
        {{ $bookings->links() }}
    </div>
</div>
