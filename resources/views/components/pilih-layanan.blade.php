<div class="w-1/2 pl-5">
    {{-- Header --}}
    <div class="flex w-full items-center text-lg">
        <p class="">Pilih Jenis Layanan</p>
    </div>

    <div id="layanan-wrapper" class="max-h-40 overflow-y-auto">
        {{-- Template untuk membuat baris pilih layanan baru --}}
        <template id="layanan-template">
            <div class="flex items-center gap-4 layanan-row pb-1">
                <select name="layanan_id[]" class="layanan-select p-2 rounded w-1/3 cursor-pointer" required>
                    <option value="" disabled selected>Pilih layanan</option>
                    @foreach ($layanans as $l)
                        <option value="{{ $l->layanan_id }}"
                                data-durasi="{{ $l->durasi }}"
                                data-flex="{{ $l->is_flexible_duration }}"
                                data-harga="{{ $l->nominal }}"
                                data-harga30="{{ $l->harga_per_30menit }}">
                            {{ $l->nama_layanan }}
                        </option>
                    @endforeach
                </select>

                <div class="w-1/4">
                    {{-- Class untuk layanan yang memiliki durasi fleksibel --}}
                    <select class="durasi-select p rounded w-full hidden cursor-pointer"></select>
                    {{-- Menunjukkan durasi layanan jika layanan tidak memiliki durasi fleksibel --}}
                    <span class="durasi-text font-medium hidden"></span>
                    <input type="hidden" name="durasi[]" class="durasi-input" value="0">
                </div>

                <div class="harga-field font-semibold w-1/5">Rp 0</div>
                <div class="justify-end flex">
                    <button type="button" class="remove-row text-right cursor-pointer text-red-500">Hapus</button>
                </div>
            </div>
        </template>

        {{-- Baris pertama --}}
        <div class="flex items-center gap-4 layanan-row">
            <select name="layanan_id[]" class="layanan-select p-2 rounded w-1/3 cursor-pointer" required>
                <option value="" disabled selected>Pilih layanan</option>
                @foreach ($layanans as $l)
                    <option value="{{ $l->layanan_id }}"
                            data-durasi="{{ $l->durasi }}"
                            data-flex="{{ $l->is_flexible_duration }}"
                            data-harga="{{ $l->nominal }}"
                            data-harga30="{{ $l->harga_per_30menit }}">
                        {{ $l->nama_layanan }}
                    </option>
                @endforeach
            </select>

            <div class="w-1/4">
                <select class="durasi-select rounded w-full hidden cursor-pointer"></select>
                <span class="durasi-text font-medium hidden"></span>
                <input type="hidden" name="durasi[]" class="durasi-input" value="0">
            </div>

            <div class="harga-field font-semibold w-1/5">Rp 0</div>
            <button type="button" class="remove-row text-red-500 text-xl hidden">Hapus</button>
        </div>

    </div>

    <button id="add-layanan" class="mt-3 bg-secondaryColor hover:shadow-md text-white px-3 py-2 rounded cursor-pointer">
        + Tambah Layanan
    </button>

{{--    <div class="mt-2 text-xl font-semibold">--}}
{{--        Total: <span id="total-harga">Rp 0</span>--}}
{{--    </div>--}}
</div>
