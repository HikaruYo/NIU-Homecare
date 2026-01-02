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
        Daftar Layanan
    </div>

    <div class="flex justify-between items-center w-full px-6">
        {{-- TODO: buat filter --}}
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
                class="bg-mainColor p-2 rounded-md hover:shadow-md transition duration-300 cursor-pointer"
            >
                Tambah Layanan
            </button>
        </div>
    </div>

    <div class="px-6 pb-6">
        <table class="w-full bg-white shadow rounded-lg">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3 text-left">Nama Layanan</th>
                    <th class="p-3 text-left">Tarif</th>
                    <th class="p-3 text-left">Deskripsi</th>
                    <th class="p-3 text-left">Durasi</th>
                    <th class="p-3 text-left">Aksi</th>
                </tr>
            </thead>

            <tbody>
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
