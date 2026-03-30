@extends('admin.dashboard')

@section('content')
    <div class="flex flex-col w-full h-full gap-4 bg-mainGray shadow-lg rounded-lg">
        <div class="mx-6 py-4 border-b-2 border-gray-200 flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-semibold text-gray-800">Tambah Layanan</h1>
                <p class="text-sm text-gray-500 mt-1">Lengkapi informasi layanan yang akan ditampilkan ke pelanggan.</p>
            </div>
        </div>

        <div class="px-6 pb-6 flex-1 min-h-0 overflow-y-auto">
            <div class="bg-white shadow rounded-2xl p-6 md:p-8">
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                        <strong class="font-semibold">Ada kesalahan pada input:</strong>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form enctype="multipart/form-data" method="POST" action="{{ route('admin.dashboard.layanan.store') }}"
                    class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Layanan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_layanan" value="{{ old('nama_layanan') }}" required
                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-mainColor">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tarif <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="nominal" value="{{ old('nominal') }}" required
                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-mainColor">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Durasi (menit) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="durasi" value="{{ old('durasi') }}" required
                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-mainColor">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tarif per 30 menit</label>
                            <input type="number" id="hargaPer30" name="harga_per_30menit"
                                value="{{ old('harga_per_30menit') }}"
                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-mainColor">
                        </div>
                    </div>

                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Apakah Durasi Fleksibel?</label>
                        <div class="flex items-center gap-6">
                            <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                                <input id="flexYes" type="radio" name="is_flexible_duration" value="1"
                                    class="text-mainColor focus:ring-mainColor"
                                    {{ old('is_flexible_duration') == '1' ? 'checked' : '' }}>
                                Ya
                            </label>
                            <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                                <input id="flexNo" type="radio" name="is_flexible_duration" value="0"
                                    class="text-mainColor focus:ring-mainColor"
                                    {{ old('is_flexible_duration', '0') == '0' ? 'checked' : '' }}>
                                Tidak
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Layanan</label>
                        <input type="file" name="gambar"
                            class="w-full rounded-xl border border-dashed border-gray-300 bg-white p-3 text-sm text-gray-600 cursor-pointer file:mr-4 file:rounded-lg file:border-0 file:bg-mainColor file:px-4 file:py-2 file:text-white hover:file:opacity-90">
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit"
                            class="bg-mainColor px-6 py-2.5 rounded-xl text-white font-medium hover:shadow-md transition cursor-pointer">
                            Simpan
                        </button>
                        <a href="{{ route('admin.dashboard.layanan') }}"
                            class="bg-gray-500 hover:shadow-md px-6 py-2.5 rounded-xl text-white font-medium transition flex items-center justify-center">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const flexYes = document.getElementById('flexYes');
            const flexNo = document.getElementById('flexNo');
            const hargaPer30 = document.getElementById('hargaPer30');

            if (!flexYes || !flexNo || !hargaPer30) return;

            const baseEnabledClass =
                'w-full rounded-xl border border-gray-300 px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-mainColor';
            const baseDisabledClass =
                'w-full rounded-xl border border-gray-200 bg-gray-100 px-4 py-2.5 text-gray-400 cursor-not-allowed';

            const updateHargaPer30State = () => {
                const isFlexible = flexYes.checked;

                if (isFlexible) {
                    hargaPer30.disabled = false;
                    hargaPer30.className = `${baseEnabledClass} bg-white`;
                } else {
                    hargaPer30.disabled = true;
                    hargaPer30.className = baseDisabledClass;
                }
            };

            flexYes.addEventListener('change', updateHargaPer30State);
            flexNo.addEventListener('change', updateHargaPer30State);
            updateHargaPer30State();
        });
    </script>
@endsection
