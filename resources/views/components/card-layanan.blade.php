<div class="flex gap-4 w-max">

    @foreach($layanans as $layanan)
        <div
            class="w-48 h-64 rounded-lg text-white overflow-hidden relative group cursor-pointer"
            style="
                background-image: linear-gradient(rgba(0,0,0,0.1), rgba(0,0,0,0.4)),
                url('{{ $layanan->gambar ? asset('storage/' . $layanan->gambar) : asset('assets/default.jpg') }}');
                background-size: cover;
                background-position: center;
            "
        >
            <div
                class="absolute bottom-0 inset-x-0 p-2
                       bg-gradient-to-t from-black/60 to-transparent
                       transform translate-y-14
                       group-hover:translate-y-0
                       transition-transform duration-300 ease-out"
            >
                <p class="text-lg font-semibold">{{ $layanan->nama_layanan }}</p>

                <div>
                    <p class="text-sm font-light mb-1 line-clamp-1 hover:line-clamp-5">{{ $layanan->deskripsi }}</p>

                    <div class="w-fit text-black px-2 py-1 text-sm font-light bg-linear-to-r from-secondaryColor to-thirdColor rounded-full">

                        @if($layanan->is_flexible_duration)
                            Rp. {{ number_format($layanan->harga_per_30menit, 0, ',', '.') }}/30 menit
                        @else
                            Rp. {{ number_format($layanan->nominal, 0, ',', '.') }}
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @endforeach

</div>
