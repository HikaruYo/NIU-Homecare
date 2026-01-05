<div class="flex flex-col h-screen gap-8 px-28 pt-28">
    <div class="flex text-center gap-3 w-fit px-8 py-1 rounded-full bg-white">
        <svg class="h-auto" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path class="justify-center" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m2 2l20 20M8.35 2.69A10 10 0 0 1 21.3 15.65m-2.22 3.43A10 10 0 1 1 4.92 4.92"/></svg>
        Layanan Kami
    </div>

    <h1 class="font-semibold text-4xl">
        Berbagai Jenis Layanan Kami Yang Tersedia
    </h1>

    <div class="relative">

        <div id="carousel-container" class="overflow-x-auto overscroll-none no-scrollbar">
            @include('components.card-layanan', ['layanans' => $layanans])
        </div>

        {{-- Tombol Carousel --}}
        <div class="absolute inset-0 pointer-events-none">
            <button type="button" class="absolute top-1/2 -translate-y-1/2 start-0 z-30 flex items-center justify-center h-10 w-10 ml-[-20px] cursor-pointer group focus:outline-none pointer-events-auto" data-carousel-prev>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white shadow-md hover:bg-gray-50 transition-all">
                    <svg class="w-5 h-5 text-mainColor" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="m15 19-7-7 7-7"/></svg>
                </span>
            </button>

            <button type="button" class="absolute top-1/2 -translate-y-1/2 end-0 z-30 flex items-center justify-center h-10 w-10 mr-[-20px] cursor-pointer group focus:outline-none pointer-events-auto" data-carousel-next>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white shadow-md hover:bg-gray-50 transition-all">
                    <svg class="w-5 h-5 text-mainColor" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="m9 5 7 7-7 7"/></svg>
                </span>
            </button>
        </div>
    </div>
</div>
