<div id="carousel-content" class="flex gap-4 w-max pb-6">
    @foreach($layanans as $layanan)
        <div
            class="md:w-48 w-[75vw] md:h-64 h-96 rounded-lg text-white overflow-hidden relative group cursor-pointer snap-center shrink-0"
            style="
                background-image: linear-gradient(rgba(0,0,0,0.1), rgba(0,0,0,0.5)),
                url('{{ $layanan->gambar ? asset('storage/' . $layanan->gambar) : asset('assets/default.jpg') }}');
                background-size: cover;
                background-position: center;
            "
            data-carousel-item
        >
            <div class="absolute bottom-0 inset-x-0 p-4 bg-gradient-to-t from-black/80 via-black/40 to-transparent transform transition-transform duration-300 ease-out">
                <p class="text-lg font-semibold leading-tight mb-1">{{ $layanan->nama_layanan }}</p>
                <div class="opacity-100">
                    <div class="w-fit text-black px-3 py-1 md:text-sm text-xs bg-gradient-to-r from-secondaryColor to-thirdColor rounded-full shadow-sm">
                        @if($layanan->is_flexible_duration)
                            Rp. {{ number_format($layanan->harga_per_30menit, 0, ',', '.') }}<span class="text-xs font-normal">/30 menit</span>
                        @else
                            Rp. {{ number_format($layanan->nominal, 0, ',', '.') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
