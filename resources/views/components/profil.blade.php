<div class="flex flex-col w-full h-full gap-4 bg-mainGray shadow-lg rounded-lg">
    {{-- Notification --}}
    @if (session('status'))
        <div id="status-alert"
             class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg right-2 absolute mb-4 transition-opacity duration-1000 ease-out"
             role="alert">
            <span class="block sm:inline">{{ session('status') }}</span>
        </div>
    @endif
    @php
        $isEditMode = $isEditMode ?? false;
    @endphp

    <div class="mx-6 py-2.5 text-4xl font-semibold border-b-2 border-gray-200">
        Profil {{ $full }}
    </div>

    <div class="px-6 text-2xl font-semibold">
        Informasi Akun
    </div>

    {{-- User Information --}}
    <div class="flex flex-col gap-2">
        <div class="flex px-6 justify-between">
            <p class="w-full">Nama Pengguna</p>
            <p class="w-full text-left">: {{ $full }}</p>
        </div>

        <div class="flex px-6 justify-between">
            <p class="w-full">Email</p>
            <p class="w-full text-left">: {{ $email }}</p>
        </div>

        <div class="flex px-6 justify-between">
            <p class="w-full">Nomor Handphone</p>
            @if(empty($no_hp))
                <p class="w-full text-left text-gray-500 italic">: Belum terisi</p>
            @else
                <p class="w-full text-left">: {{ $no_hp }}</p>
            @endif
        </div>

        <div class="flex px-6 justify-between">
            <p class="w-full">Alamat</p>
            @if(empty($alamat))
                <p class="w-full text-left text-gray-500 italic">: Belum terisi</p>
            @else
                <p class="w-full text-left">: {{ $alamat }}</p>
            @endif
        </div>
    </div>

    {{-- Edit Profile --}}
    @if (!$isEditMode)
        <div class="ml-5">
            <a href="{{ route('profile.edit') }}"
               class="inline-block px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow hover:bg-blue-600 transition duration-150">
                Edit Profil
            </a>
        </div>
    @endif

    {{-- TODO: buat laporan singkat sudah berapa kali memesan layanan, berapa yang berhasil, ditolak, atau menunggu --}}
    {{-- TODO: bikin grid-3 menyamping, yang akan muncul jika form edit profil kosong, dan akan hilang jika user edit profil --}}
    {{-- TODO: biking component seperti membuka profil dan histori --}}

    {{-- Edit Profile Form --}}
    <div id="edit-mode" class="{{ $isEditMode ? 'block' : 'hidden' }}">
        <div class="mx-5 text-2xl font-semibold text-gray-800">
            Edit Informasi Akun
        </div>

        <form method="POST" action="{{ route('profile.update') }}" class="flex flex-col gap-4 mx-5">
            @csrf
            @method('PUT')
            {{-- Username Field --}}
            <div class="grid grid-cols-2 items-center">
                <label for="username" class="font-medium">Nama Pengguna</label>
                <div>
                    <input type="text" name="username" id="username" value="{{ old('username', $full) }}"
                           class="w-full p-2 bg-white rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('username') border-red-500 @enderror">
                    @error('username')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- No HP Field --}}
            <div class="grid grid-cols-2 items-center">
                <label for="no_hp" class="font-medium">Nomor Handphone</label>
                <div>
                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $no_hp) }}"
                           class="w-full p-2 bg-white rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('no_hp') border-red-500 @enderror">
                    @error('no_hp')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Alamat Field --}}
            <div class="grid grid-cols-2 items-center">
                <label for="alamat" class="font-medium">Alamat</label>
                <div>
                    <textarea name="alamat" id="alamat" rows="3"
                              class="w-full p-2 bg-white rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('alamat') border-red-500 @enderror">{{ old('alamat', $alamat) }}</textarea>
                    @error('alamat')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Action Button --}}
            <div class="flex gap-4">
                <button type="submit"
                        class="px-4 py-2 bg-mainColor font-semibold rounded-lg hover:shadow-lg transition duration-150 cursor-pointer">
                    Simpan Perubahan
                </button>
                <a href="{{ route('dashboard.profil') }}"
                   class="px-4 py-2 bg-gray-400 text-gray-800 font-semibold rounded-lg hover:shadow-lg transition duration-150">
                    Batal
                </a>
            </div>
        </form>
    </div>

</div>
