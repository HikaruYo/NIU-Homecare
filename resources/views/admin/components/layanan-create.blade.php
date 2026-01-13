@extends('admin.dashboard')

@section('content')
    <div class="flex flex-col w-full h-full gap-4 bg-mainGray shadow-lg rounded-lg">
        {{-- TODO: update UI --}}
        {{-- TODO: buat flexible tarif, jika tarif_flexible true maka ada tambahan di depan display tarif yaitu mulai dari ...   --}}
        <div class="mx-6 py-2.5 text-4xl font-semibold border-b-2 border-gray-200">
            Tambah Layanan
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <strong class="font-bold">Ada kesalahan!</strong>
                <ul class="mt-1 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form enctype="multipart/form-data" method="POST" action="{{ route('admin.dashboard.layanan.store') }}"
            class="grid grid-cols-2 gap-2 px-6"
        >
            @csrf

            <div>
                <label>Nama Layanan</label>
                <input type="text" name="nama_layanan" value="{{ old('nama_layanan') }}" class="w-full p-2 rounded bg-white">
            </div>

            <div>
                <label>Tarif</label>
                <input type="number" name="nominal" value="{{ old('nominal') }}" class="w-full p-2 rounded bg-white">
            </div>

            <div>
                {{-- TODO: buat dropdown template durasi; 30,60,90,120,150 menit --}}
                <label>Durasi (30 menit)</label>
                <input type="number" name="durasi" value="{{ old('durasi') }}" class="w-full p-2 rounded bg-white">
            </div>

            <div class="">
                <label class="block mb-1">Apakah Durasi Fleksibel?</label>
                <div class="flex gap-4">
                    <label class="flex gap-2 items-center">
                        <input type="radio" name="is_flexible_duration" value="1">
                        Ya
                    </label>
                    <label class="flex gap-2 items-center">
                        <input type="radio" name="is_flexible_duration" value="0" checked>
                        Tidak
                    </label>
                </div>
            </div>

            <div>
                <label>Tarif per 30 menit</label>
                <input type="number" name="harga_per_30menit" value="{{ old('harga_per_30menit') }}" class="w-full p-2 rounded bg-white">
            </div>

            <div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Gambar Layanan</label>
                    <input type="file" name="gambar" class="bg-white p-2 w-full rounded-lg cursor-pointer">
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="bg-mainColor px-4 py-2 rounded-lg text-white hover:shadow-md cursor-pointer">
                        Simpan
                    </button>
                    <a href="{{ route('admin.dashboard.layanan') }}"
                       class="bg-gray-500 hover:shadow-md px-6 py-2 rounded-lg text-white font-medium transition flex items-center justify-center">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
