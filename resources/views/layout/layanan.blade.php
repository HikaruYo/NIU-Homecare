<div class="flex flex-col min-h-screen md:gap-8 gap-6 md:px-28 px-6 md:pt-28 pt-24 pb-12">
    <div class="flex flex-col h-fit md:gap-8 gap-4">
        <div class="flex items-center text-center gap-3 w-fit md:px-8 px-6 py-1 md:text-base text-sm rounded-full bg-white shadow-sm">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m2 2l20 20M8.35 2.69A10 10 0 0 1 21.3 15.65m-2.22 3.43A10 10 0 1 1 4.92 4.92"/>
            </svg>
            Layanan Kami
        </div>

        <h1 class="font-semibold md:text-4xl text-2xl leading-tight text-white">
            Berbagai Jenis Layanan Kami Yang Tersedia
        </h1>
    </div>

    <div class="relative mt-4">
        {{-- Container Carousel dengan Snap Scrolling untuk Mobile --}}
        <div id="carousel-container" class="overflow-x-auto overscroll-none no-scrollbar snap-x snap-mandatory">
            @include('components.card-layanan', ['layanans' => $layanans])
        </div>

        <div class="absolute inset-0 pointer-events-none hidden md:block">
            <button type="button" class="absolute top-1/2 -translate-y-1/2 -left-6 z-30 flex items-center justify-center h-10 w-10 cursor-pointer group pointer-events-auto" data-carousel-prev>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white shadow-md hover:bg-gray-50 transition-all">
                    <svg class="w-5 h-5 text-mainColor" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="m15 19-7-7 7-7"/></svg>
                </span>
            </button>

            <button type="button" class="absolute top-1/2 -translate-y-1/2 -right-6 z-30 flex items-center justify-center h-10 w-10 cursor-pointer group pointer-events-auto" data-carousel-next>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white shadow-md hover:bg-gray-50 transition-all">
                    <svg class="w-5 h-5 text-mainColor" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="m9 5 7 7-7 7"/></svg>
                </span>
            </button>
        </div>
    </div>
</div>
