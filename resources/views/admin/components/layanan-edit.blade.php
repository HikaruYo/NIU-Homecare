@extends('admin.dashboard')

@section('content')
    <div class="flex flex-col w-full h-full gap-4 bg-mainGray shadow-lg rounded-lg">
        <div class="mx-6 py-2.5 text-4xl font-semibold border-b-2 border-gray-200">
            Edit Layanan
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form enctype="multipart/form-data" method="POST" action="{{ route('admin.dashboard.layanan.update', $layanan->layanan_id) }}"
            class="grid grid-cols-2 gap-2 px-6"
        >
            @csrf
            @method('PUT')

            <div class="">
                <label>Nama Layanan</label>
                <input type="text" name="nama_layanan" class="w-full p-2 rounded bg-white"
                       value="{{ old('nama_layanan', $layanan->nama_layanan) }}">
            </div>

            <div class="">
                <label>Tarif</label>
                <input type="number" name="nominal" class="w-full p-2 rounded bg-white"
                       value="{{ old('nominal', $layanan->nominal) }}">
            </div>

            <div class="">
                <label>Durasi (30 menit)</label>
                <input type="number" name="durasi" class="w-full p-2 rounded bg-white"
                       value="{{ old('durasi', $layanan->durasi) }}">
            </div>

            <div class="">
                <label class="block mb-1">Apakah Durasi Fleksibel?</label>
                <div class="flex gap-4">
                    <label class="flex gap-2 items-center">
                        <input type="radio" name="is_flexible_duration" value="1"
                            {{ old('is_flexible_duration', $layanan->is_flexible_duration) == 1 ? 'checked' : '' }}>
                        Ya
                    </label>
                    <label class="flex gap-2 items-center">
                        <input type="radio" name="is_flexible_duration" value="0"
                            {{ old('is_flexible_duration', $layanan->is_flexible_duration) == 0 ? 'checked' : '' }}>
                        Tidak
                    </label>
                </div>
            </div>

            <div class="">
                <label>Tarif per 30 menit</label>
                <input type="number" name="harga_per_30menit" class="w-full p-2 rounded bg-white"
                       value="{{ old('harga_per_30menit', $layanan->harga_per_30menit) }}">
            </div>

            <div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Gambar Layanan</label>
                    <input type="file" name="gambar" class=" p-2 w-full rounded-lg bg-white outline-none">

                    @if($layanan->gambar)
                        <div class="mt-2">
                            <p class="text-sm text-gray-600 mb-1">Gambar saat ini:</p>
                            <img src="{{ asset('storage/' . $layanan->gambar) }}" alt="Preview" class="h-20 w-auto rounded">
                        </div>
                    @endif
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="bg-mainColor px-4 py-2 rounded-lg text-white hover:shadow-md cursor-pointer">
                        Update
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
