<div class="flex flex-col gap-8 px-28 pt-28">

    <div class="flex text-center gap-3 w-fit px-8 py-1 rounded-full bg-linear-to-br from-mainColor to-thirdColor">
        <svg class="h-auto" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path class="justify-center" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m2 2l20 20M8.35 2.69A10 10 0 0 1 21.3 15.65m-2.22 3.43A10 10 0 1 1 4.92 4.92"/></svg>
        Pesan Sekarang
    </div>

    <div class="w-1/2 ">
        Pesan layanan kami sekarang juga!
    </div>

    {{-- Main Content --}}
    <div class="flex w-full justify-between">

        {{-- Jadwal --}}
        <div class="w-1/2 pr-5">
            {{-- Header --}}
            <div class="flex justify-between border-b-[2px] border-b-mainGray">
                <p>Pilih Tanggal dan Waktu</p>

                <div class="flex items-center">
                    {{-- Calendar Icon --}}
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

                    {{-- Dropdown icon --}}
                    <svg id="openDatePicker" class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                        <path fill="currentColor" d="m18 9l-6-6l-6 6zm0 6l-6 6l-6-6z" />
                    </svg>
                </div>

                {{-- Hidden input for flatpickr --}}
                <input type="text" id="datepicker" class="hidden">
            </div>

            {{-- Time List --}}
            <div class="grid grid-cols-7 gap-2 mt-4">
                @foreach ($slots as $slot)
                    <div class="p-2 rounded-4xl text-center
                        {{ (!$slot->is_available || $slot->is_disabled)
                            ? 'bg-gray-300 text-gray-500'
                            : 'bg-gray-300 text-black hover:opacity-90'
                        }}"
                    >
                        {{ \Carbon\Carbon::parse($slot->waktu)->format('H:i') }}
                    </div>
                @endforeach
            </div>

            {{-- Booking --}}
            <div class="flex mt-4 gap-4 items-center">
                {{-- Start --}}
                <div class="border-b-[2px] border-b-mainGray">
                    <p>Mulai</p>
                    <div class="flex">
                        <div>10:30</div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <g fill="none" fill-rule="evenodd">
                                <path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                <path fill="currentColor" d="M13.06 16.06a1.5 1.5 0 0 1-2.12 0l-5.658-5.656a1.5 1.5 0 1 1 2.122-2.121L12 12.879l4.596-4.596a1.5 1.5 0 0 1 2.122 2.12l-5.657 5.658Z" />
                            </g>
                        </svg>
                    </div>
                </div>

                {{-- Arrow --}}
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="m18 8l4 4l-4 4M2 12h20" />
                    </svg>
                </div>

                {{-- Finished --}}
                <div class="border-b-[2px] border-b-mainGray">
                    <p>Selesai</p>
                    <div class="flex">
                        <div>11:30</div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <g fill="none" fill-rule="evenodd">
                                <path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                <path fill="currentColor" d="M13.06 16.06a1.5 1.5 0 0 1-2.12 0l-5.658-5.656a1.5 1.5 0 1 1 2.122-2.121L12 12.879l4.596-4.596a1.5 1.5 0 0 1 2.122 2.12l-5.657 5.658Z" />
                            </g>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Book Button --}}
            <div class="mt-6 w-1/3">
                <button
                    type="submit"
                    class="flex w-full justify-center items-center gap-3 px-5 py-2 text-lg rounded-full bg-linear-to-br from-mainColor to-thirdColor cursor-pointer hover:shadow-md transition duration-300"
                >
                    Pesan
                </button>
            </div>
        </div>

        {{-- Layanan --}}
        <div class="w-1/2 pl-5">
            <div class="flex w-full items-center border-b-[2px] border-b-mainGray">
                <p class="text-mainGray">Pilih Jenis Layanan</p>
            </div>
        </div>

    </div>
</div>
<script>
    const dbDates = @json($allDates ?? []);

    document.addEventListener("DOMContentLoaded", function () {

        const fp = flatpickr("#datepicker", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d F Y",
            enable: dbDates,
            minDate: new Date().fp_incr(1),
            locale: {
                firstDayOfWeek: 1,
                weekdays: {
                    shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                    longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
                },
                months: {
                    shorthand: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
                    longhand: ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
                },
            },
            onChange: function(selectedDates, dateStr) {
                window.location.href = "/?tanggal=" + dateStr + "#pesan";
            }
        });

        document.getElementById('openDatePicker').addEventListener('click', function () {
            fp.open();
        });
    });
</script>
