<div class="flex flex-col gap-8 px-28 pt-28">
    <div class="flex text-center gap-3 w-fit px-8 py-1 rounded-full bg-linear-to-br from-mainColor to-thirdColor">
        <svg class="h-auto" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
            <path class="justify-center" fill="none" stroke="currentColor" stroke-linecap="round"
                  stroke-linejoin="round" stroke-width="2"
                  d="m2 2l20 20M8.35 2.69A10 10 0 0 1 21.3 15.65m-2.22 3.43A10 10 0 1 1 4.92 4.92"/>
        </svg>
        Pesan Sekarang
    </div>

    <div class="w-1/2 ">
        Pesan layanan kami sekarang juga!
    </div>

    {{-- Konten Utama --}}
    <div class="flex w-full justify-between">
        <form action="{{ route('booking.store') }}" method="POST" class="flex flex-col w-full">
            @csrf
            {{-- Input hidden untuk mengirim data dari form website ke database --}}
            <input type="hidden" name="start_time" id="start_time">
            <input type="hidden" name="end_time" id="end_time">
            <input type="hidden" name="tanggal_booking" value="{{ $tanggal }}">

            <div class="flex">
                @include('components.jadwal')
                @include('components.pilih-layanan')
            </div>

            <div class="mt-6 w-1/6">
                <button
                    type="submit"
                    class="flex w-full justify-center items-center gap-3 px-5 py-2 text-lg rounded-full bg-secondaryColor cursor-pointer hover:shadow-md transition duration-300"
                >
                    Pesan
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    const dbDates = @json($allDates ?? []);
</script>
