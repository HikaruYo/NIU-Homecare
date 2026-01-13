<div class="flex flex-col w-full h-full gap-4 bg-mainGray shadow-lg rounded-lg">
    {{-- Notification --}}
    @if (session('status'))
        <div id="status-alert"
             class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg right-2 absolute mb-4 transition-opacity duration-1000 ease-out"
             role="alert">
            <span class="block sm:inline">{{ session('status') }}</span>
        </div>
    @endif

    <div class="flex justify-between items-center mx-6 py-2.5 border-b-2 border-gray-200">
        <div>
            <p class="text-4xl font-semibold">Daftar Layanan</p>
        </div>

        <div class="flex items-center gap-2 py-1 px-3 rounded-full bg-white shadow">
            <svg class="w-5 h-5 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
            </svg>
            <input
                type="text"
                id="search"
                placeholder="Cari layanan..."
                class="outline-none"
            >
        </div>
    </div>

    <div class="flex justify-between items-center w-full px-6">
        {{-- Dropdown Container --}}
        <div class="relative">
            {{-- Tombol Urutkan --}}
            <button
                id="sortDropdownBtn"
                type="button"
                class="flex items-center cursor-pointer text-gray-800 focus:outline-none font-medium w-full justify-between"
            >
                <p>Urutkan Berdasarkan : <span class="ml-1  capitalize">{{ $currentSort ?? 'ditambahkan' }}</span></p>
                <svg class="w-6 h-6 ml-1 transition-transform duration-300" id="sortDropdownArrow"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="currentColor" d="m12 15l-4-4h8l-4 4"/>
                </svg>
            </button>

            {{-- Dropdown Menu --}}
            <div id="sortDropdownMenu" class="absolute right-0 mt-2 w-44 bg-white rounded-lg shadow-xl z-50 py-2 border border-gray-200 hidden">
                <a href="{{ route('admin.dashboard.layanan') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ditambahkan</a>
                <a href="{{ route('admin.dashboard.layanan', ['sort' => 'harga']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Harga</a>
                <a href="{{ route('admin.dashboard.layanan', ['sort' => 'durasi']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Durasi</a>
            </div>
        </div>

        <div>
            <button
                onclick="window.location='{{ route('admin.dashboard.layanan.tambah') }}'"
                class="bg-mainColor p-2 rounded-md shadow hover:shadow-md transition duration-300 cursor-pointer"
            >
                Tambah Layanan
            </button>
        </div>
    </div>

    <div class="px-6 pb-6">
        {{-- TODO: paginate --}}
        <table class="w-full bg-white shadow rounded-lg table-fixed">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3 text-left w-[20%]">Nama Layanan</th>
                    <th class="p-3 text-left w-[15%]">Tarif</th>
                    <th class="p-3 text-left w-[30%]">Deskripsi</th>
                    <th class="p-3 text-left w-[15%]">Durasi</th>
                    <th class="p-3 text-left w-[20%]">Aksi</th>
                </tr>
            </thead>

            <tbody id="layanan-table-body">
                @foreach($layanan as $l)
                    <tr class="border-b border-gray-300 text-gray-600">
                        <td class="p-3">{{ $l->nama_layanan }}</td>
                        <td class="p-3">Rp {{ number_format($l->nominal, 0, ',', '.') }}</td>
                        <td class="p-3">{{ $l->deskripsi }}</td>
                        <td class="p-3">{{ $l->durasi }} menit</td>
                        <td class="p-3 flex gap-2">
                            <a href="{{ route('admin.dashboard.layanan.edit', $l->layanan_id) }}"
                               class="px-3 py-1 bg-mainGray text-white rounded">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.dashboard.layanan.destroy', $l->layanan_id) }}"
                                  onsubmit="return confirm('Hapus layanan ini?')">
                                @csrf @method('DELETE')
                                <button class="px-3 py-1 bg-red-600 text-white rounded cursor-pointer">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>
