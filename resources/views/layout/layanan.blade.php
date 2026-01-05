<div class="flex flex-col h-screen gap-8 px-28 pt-28">

    <div class="flex text-center gap-3 w-fit px-8 py-1 rounded-full bg-white">
        <svg class="h-auto" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path class="justify-center" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m2 2l20 20M8.35 2.69A10 10 0 0 1 21.3 15.65m-2.22 3.43A10 10 0 1 1 4.92 4.92"/></svg>
        Layanan Kami
    </div>

    <h1 class="font-semibold text-4xl">
        Berbagai Jenis Layanan Kami Yang Tersedia
    </h1>

    <div class="overflow-x-auto overscroll-none no-scrollbar">
        {{-- TODO: Add arrow button to slide --}}
        @include('components.card-layanan', ['layanans' => $layanans])
    </div>

</div>
