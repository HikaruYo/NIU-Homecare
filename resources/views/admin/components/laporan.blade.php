<div class="flex flex-col w-full h-full gap-4 bg-mainGray shadow-lg rounded-lg">
    {{-- Notification --}}
    @if (session('status'))
        <div id="status-alert"
             class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg right-2 absolute mb-4 transition-opacity duration-1000 ease-out"
             role="alert">
            <span class="block sm:inline">{{ session('status') }}</span>
        </div>
    @endif

    <div class="mx-6 py-2.5 text-4xl font-semibold border-b-2 border-gray-200">
        Laporan Penghasilan
    </div>

    <div class="grid grid-cols-1 mx-6 py-2 md:grid-cols-5 gap-4">
        <!-- Total Booking Bulan Ini -->
        <div class="bg-white p-4 rounded-2xl shadow">
            <p class="text-gray-400 text-sm">Booking Bulan Ini</p>
            <h2 class="text-2xl font-bold text-mainColor">
                {{ $totalBookingBulanIni }}
            </h2>
        </div>

        <!-- Diterima -->
        <div class="bg-white p-4 rounded-2xl shadow">
            <p class="text-gray-400 text-sm">Diterima</p>
            <h2 class="text-2xl font-bold text-green-600">
                {{ $bookingDiterima }}
            </h2>
        </div>

        <!-- Menunggu -->
        <div class="bg-white p-4 rounded-2xl shadow">
            <p class="text-gray-400 text-sm">Menunggu</p>
            <h2 class="text-2xl font-bold text-yellow-500">
                {{ $bookingMenunggu }}
            </h2>
        </div>

        <!-- Ditolak -->
        <div class="bg-white p-4 rounded-2xl shadow">
            <p class="text-gray-400 text-sm">Ditolak</p>
            <h2 class="text-2xl font-bold text-red-500">
                {{ $bookingDitolak }}
            </h2>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow">
            <p class="text-gray-400 text-sm">Dibatalkan</p>
            <h2 class="text-2xl font-bold text-gray-600">
                {{ $bookingDibatalkan }}
            </h2>
        </div>
    </div>

    {{-- TODO: buat graph pendapatan --}}

    <div class="mx-6 flex gap-4">
        <div class="bg-white w-1/2 h-fit p-4 rounded-2xl shadow mb-1">
            <p class="text-gray-400 text-sm">Total Pendapatan</p>
            <h2 class="text-2xl font-bold text-mainColor">
                Rp {{ number_format($pendapatan, 0, ',', '.') }}
            </h2>
            <p class="text-gray-500 mt-2">
                Dari booking dengan status <span class="font-semibold">diterima</span>
            </p>
        </div>

        <div class="bg-white p-4 w-1/2 rounded-2xl shadow">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">
                Booking per Tahun {{ \Carbon\Carbon::now()->year }}
            </h3>

            <div class="max-h-52 overflow-y-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                    <tr class="text-gray-500 border-b">
                        <th class="pb-3">Bulan</th>
                        <th class="pb-3">Total Booking</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($bookingBulanan as $item)
                        <tr class="border-b border-mainGray last:border-none">
                            <td class="py-3">
                                {{ \Carbon\Carbon::create()->month($item->bulan)->translatedFormat('F') }}
                            </td>
                            <td class="py-3 font-semibold text-mainColor">
                                {{ $item->total }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
