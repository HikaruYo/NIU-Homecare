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
