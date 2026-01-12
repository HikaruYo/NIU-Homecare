<div class="flex flex-col w-full h-full gap-4 pb-4 bg-mainGray shadow-lg rounded-lg">
    {{-- Notification --}}
    @if (session('status'))
        <div id="status-alert"
             class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg right-10 absolute z-50 mt-4 transition-opacity duration-1000 ease-out"
             role="alert">
            <span class="block sm:inline">{{ session('status') }}</span>
        </div>
    @endif

    @if($errors->any())
        <script>
            const modal = document.getElementById('editProfileModal');
            const modalContent = document.getElementById('modalContent');
            const openBtn = document.getElementById('openEditModal');
            const closeBtn = document.getElementById('closeEditModal');
            const cancelBtn = document.getElementById('btnCancel');

            modal.classList.remove('hidden');
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        </script>
    @endif

    <div class="mx-6 py-2.5 text-4xl font-semibold border-b-2 border-gray-200">
        Profil <span class="text-mainColor">{{ $full }}</span>
    </div>

    <div class="flex flex-col bg-white mx-6 p-4 shadow rounded-md gap-2">
        <div class="text-2xl font-semibold">
            Informasi Akun
        </div>

        {{-- User Information --}}
        <div class="grid grid-cols-2 gap-2">
            <div class="flex flex-col">
                <p class="text-gray-600 text-sm">Nama Pengguna</p>
                <p class="">{{ $full }}</p>
            </div>

            <div class="flex flex-col">
                <p class="text-gray-600 text-sm">Email</p>
                <p class=" text-left">{{ $email }}</p>
            </div>

            <div class="flex flex-col">
                <p class="text-gray-600 text-sm">Nomor Handphone</p>
                @if(empty($no_hp))
                    <p class=" text-left text-gray-500 italic">Belum terisi</p>
                @else
                    <p class=" text-left">{{ $no_hp }}</p>
                @endif
            </div>

            <div class="flex flex-col">
                <p class="text-gray-600 text-sm">Alamat</p>
                @if(empty($alamat))
                    <p class=" text-left text-gray-500 italic">Belum terisi</p>
                @else
                    <p class=" text-left">{{ $alamat }}</p>
                @endif
            </div>
        </div>

        {{-- Edit Profile Button --}}
        <div class="mt-2">
            <button id="openEditModal" type="button"
                    class="px-6 py-2 bg-mainColor text-white font-semibold rounded-md shadow hover:bg-green-700 transition duration-300 cursor-pointer">
                Edit Profil
            </button>
        </div>
    </div>

    {{-- Jadwal Booking Mendatang --}}
    <div class="flex flex-col flex-1 bg-white mx-6 p-4 shadow rounded-md gap-4 overflow-y-auto">
        <div class="flex justify-between items-center border-b border-mainGray pb-2">
            <div class="text-xl font-semibold text-gray-400">
                Jadwal Booking Mendatang
            </div>
            <a href="{{ route('dashboard.histori') }}" class="text-sm text-mainColor">Lihat Semua</a>
        </div>

        @if($upcomingBookings->isEmpty())
            <div class="flex flex-col gap-2 items-center text-center">
                <p class="italic text-gray-500">Belum ada jadwal booking untuk beberapa hari kedepan.</p>
                <a href="/#pesan" class="bg-mainColor py-1.5 px-3 rounded shadow hover:shadow-md text-white">Pesan Sekarang</a>
            </div>
        @else
            <div class="overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 ">
                    @foreach($upcomingBookings as $booking)
                        <div class="border border-gray-500 rounded-lg p-4 flex flex-col gap-2 shadow-sm border-l-4
                            {{ $booking->status == 'diterima' ? 'border-l-green-500' : 'border-l-yellow-500' }}"
                        >
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Tanggal</p>
                                    <p class="font-semibold text-gray-800">
                                        {{ \Carbon\Carbon::parse($booking->tanggal_booking)->translatedFormat('l, d F Y') }}
                                    </p>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full font-semibold uppercase
                                    {{ $booking->status == 'diterima' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $booking->status }}
                                </span>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Layanan yang Dipesan</p>
                                <ul class="text-sm text-gray-700 list-disc list-inside">
                                    @foreach($booking->bookingLayanans as $bl)
                                        <li>{{ $bl->layanan->nama_layanan }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    {{-- Modal Edit Profil --}}
    <div id="editProfileModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/50 backdrop-blur-sm px-4">
        <div class="bg-white rounded-md shadow-2xl w-full max-w-lg p-8 relative transform transition-all duration-300 scale-95 opacity-0" id="modalContent">

            {{-- Close Button --}}
            <button id="closeEditModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>

            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Edit Informasi Akun</h3>
                <p class="text-gray-500 text-sm">Perbarui detail profil Anda untuk mempermudah layanan.</p>
            </div>

            <form method="POST" action="{{ route('profile.update') }}" class="flex flex-col gap-5">
                @csrf
                @method('PUT')

                {{-- Username Field --}}
                <div class="flex flex-col gap-1">
                    <label for="username" class="text-sm font-semibold text-gray-700 ml-1">Nama Pengguna</label>
                    <input type="text" name="username" id="username" value="{{ old('username', $full) }}"
                           placeholder="Masukkan nama lengkap"
                           class="w-full p-3 bg-gray-50 border border-gray-200 rounded-md focus:ring-2 focus:ring-mainColor focus:border-mainColor outline-none transition @error('username') border-red-500 @enderror">
                    @error('username')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- No HP Field --}}
                <div class="flex flex-col gap-1">
                    <label for="no_hp" class="text-sm font-semibold text-gray-700 ml-1">Nomor Handphone (WhatsApp)</label>
                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $no_hp) }}"
                           placeholder="08123456789"
                           class="w-full p-3 bg-gray-50 border border-gray-200 rounded-md focus:ring-2 focus:ring-mainColor focus:border-mainColor outline-none transition @error('no_hp') border-red-500 @enderror">
                    @error('no_hp')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Alamat Field --}}
                <div class="flex flex-col gap-1">
                    <label for="alamat" class="text-sm font-semibold text-gray-700 ml-1">Alamat Lengkap</label>
                    <textarea name="alamat" id="alamat" rows="3"
                              placeholder="Masukkan alamat lengkap untuk kedatangan petugas"
                              class="w-full p-3 bg-gray-50 border border-gray-200 rounded-md focus:ring-2 focus:ring-mainColor focus:border-mainColor outline-none transition @error('alamat') border-red-500 @enderror">{{ old('alamat', $alamat) }}</textarea>
                    @error('alamat')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-3 mt-4">
                    <button type="button" id="btnCancel"
                            class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 font-bold rounded-md hover:bg-gray-200 transition duration-150 cursor-pointer">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 px-4 py-3 bg-mainColor text-white font-bold rounded-md hover:bg-green-700 shadow-lg shadow-green-200 transition duration-150 cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
