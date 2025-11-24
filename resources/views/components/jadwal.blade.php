<div class="w-1/2 pr-5">
    {{-- Header --}}
    <div class="flex justify-between border-b-[2px] border-b-mainGray">
        <p class="">Pilih Tanggal dan Waktu</p>

        <div class="flex items-center cursor-pointer" id="openDatePicker">
            {{-- Ikon Kalender --}}
            <svg id="animated-calendar" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                 viewBox="0 0 24 24">
                <rect width="14" height="0" x="5" y="5" fill="currentColor"/>
                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                   stroke-width="2">
                    <path class="calendar-frame" stroke-dasharray="64" stroke-dashoffset="64"
                          d="M12 4h7c0.55 0 1 0.45 1 1v14c0 0.55 -0.45 1 -1 1h-14c-0.55 0 -1 -0.45 -1 -1v-14c0 -0.55 0.45 -1 1 -1Z"/>
                    <path class="calendar-top" stroke-dasharray="4" stroke-dashoffset="4" d="M7 4v-2M17 4v-2"/>
                    <path class="calendar-line-1" stroke-dasharray="12" stroke-dashoffset="12" d="M7 11h10"/>
                    <path class="calendar-line-2" stroke-dasharray="8" stroke-dashoffset="8" d="M7 15h7"/>
                </g>
            </svg>
            <p class="pl-2 font-medium">{{ $tanggalFormatted ?? (\Carbon\Carbon::parse($tanggal ?? now())->format('d F Y')) }}</p>

            {{-- Ikon Arrow yang membuka Kalender --}}
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                <path fill="currentColor" d="m18 9l-6-6l-6 6zm0 6l-6 6l-6-6z" />
            </svg>
        </div>

        {{-- Hidden input untuk diisi oleh flatpickr melalui app.js --}}
        <input type="text" id="datepicker" class="hidden">
    </div>

    {{-- List waktu --}}
    <div class="grid grid-cols-7 gap-2 mt-4">
        {{-- Mengambil seluruh waktu yang tersedia dari DB --}}
        @foreach ($slots as $slot)
            <div class="slot-item p-2 rounded-4xl text-center cursor-pointer
                {{ (!$slot->is_available || $slot->is_disabled)
                    ? 'bg-gray-300 text-gray-500 pointer-events-none'
                    : 'bg-gray-300 text-black hover:bg-secondaryColor hover:text-white transition duration-150'

                }}"
                 data-id="{{ $slot->slot_jadwal_id }}"
                 data-time="{{ \Carbon\Carbon::parse($slot->waktu)->format('H:i') }}"
            >
                {{ \Carbon\Carbon::parse($slot->waktu)->format('H:i') }}
            </div>
        @endforeach
    </div>

    <div id="selected-slots-container"></div>

    {{-- Booking --}}
    <div class="flex mt-4 gap-4 items-center">
        <div class="border-b-[2px] border-b-mainGray w-1/6">
            <p>Mulai</p>
            <div class="flex">
                <div id="displayStart">--:--</div>
            </div>
        </div>

        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="m18 8l4 4l-4 4M2 12h20" />
            </svg>
        </div>

        <div class="border-b-[2px] border-b-mainGray w-1/6">
            <p>Selesai</p>
            <div class="flex">
                <div id="displayStart">--:--</div>
            </div>
        </div>
    </div>
</div>
