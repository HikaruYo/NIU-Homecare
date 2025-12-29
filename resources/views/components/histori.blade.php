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
            <div id="filterDropdownMenu" class="absolute right-0 mt-2 w-44 bg-white rounded-lg shadow-xl z-50 py-2 border border-gray-200 hidden">
                <a href="{{ route('dashboard.histori') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Semua</a>
                <a href="{{ route('dashboard.histori', ['status' => 'menunggu']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Menunggu</a>
                <a href="{{ route('dashboard.histori', ['status' => 'diterima']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Diterima</a>
                <a href="{{ route('dashboard.histori', ['status' => 'ditolak']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ditolak</a>
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
                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4
                    {{ $booking->status == 'diterima' ? 'border-green-500' : ($booking->status == 'ditolak' ? 'border-red-500' : 'border-yellow-500') }}">

                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-sm text-gray-500">No. Booking: #{{ $booking->booking_id }}</p>
                                <p class="font-semibold text-lg">
                                    {{ \Carbon\Carbon::parse($booking->tanggal_booking)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                                </p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-sm font-medium capitalize
                            {{ $booking->status == 'diterima' ? 'bg-green-100 text-green-800' : ($booking->status == 'ditolak' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ $booking->status }}
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
        @endif
    </div>
</div>
