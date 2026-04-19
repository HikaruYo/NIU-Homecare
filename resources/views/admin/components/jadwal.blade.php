<div class="flex flex-col w-full h-full gap-4 bg-mainGray shadow-lg rounded-lg">
    @if (session('status'))
        <div id="status-alert"
            class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg right-2 absolute mb-4 transition-opacity duration-1000 ease-out"
            role="alert">
            <span class="block sm:inline">{{ session('status') }}</span>
        </div>
    @endif

    <div class="mx-6 py-3 border-b-2 border-gray-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
            <h1 class="text-4xl font-semibold text-gray-800">Jadwal Booking</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola hari libur dan slot manual untuk kebutuhan operasional.</p>
        </div>

        <form method="GET" action="{{ route('admin.dashboard.jadwal') }}" class="flex items-center gap-2">
            <label for="tanggal" class="text-sm text-gray-500">Tanggal:</label>
            <select id="tanggal" name="tanggal" onchange="this.form.submit()"
                class="rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-mainColor">
                @foreach ($availableDates as $date)
                    <option value="{{ $date }}" {{ $selectedDate === $date ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::parse($date)->locale('id')->isoFormat('D MMM Y') }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="mx-6 grid grid-cols-2 xl:grid-cols-4 gap-3">
        <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm">
            <p class="text-xs text-gray-400">Total Slot</p>
            <p class="text-2xl font-bold text-mainColor mt-1">{{ $totalSlots }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm">
            <p class="text-xs text-gray-400">Tersedia</p>
            <p class="text-2xl font-bold text-green-600 mt-1">{{ $availableSlots }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm">
            <p class="text-xs text-gray-400">Terisi Booking</p>
            <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $bookedSlots }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm">
            <p class="text-xs text-gray-400">Dinonaktifkan Admin</p>
            <p class="text-2xl font-bold text-gray-700 mt-1">{{ $disabledSlots }}</p>
        </div>
    </div>

    <div class="mx-6 grid grid-cols-1 xl:grid-cols-5 gap-4">
        <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm xl:col-span-2">
            <h3 class="text-lg font-semibold text-gray-800">Atur Hari Libur</h3>
            <p class="text-sm text-gray-500 mt-1">Nonaktifkan seluruh slot di tanggal {{ $selectedDateLabel }}.</p>

            <div class="mt-4 flex gap-2">
                <form method="POST" action="{{ route('admin.dashboard.jadwal.day') }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="tanggal" value="{{ $selectedDate }}">
                    <input type="hidden" name="action" value="disable">
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-gray-700 text-white text-sm font-medium hover:bg-gray-800 transition cursor-pointer">
                        Nonaktifkan Seharian
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.dashboard.jadwal.day') }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="tanggal" value="{{ $selectedDate }}">
                    <input type="hidden" name="action" value="enable">
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-mainColor text-white text-sm font-medium hover:opacity-90 transition cursor-pointer">
                        Aktifkan Kembali
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm xl:col-span-3">
            <h3 class="text-lg font-semibold text-gray-800">Atur Rentang Jam</h3>
            <p class="text-sm text-gray-500 mt-1">Kosongkan manual slot tertentu untuk kebutuhan booking offline.</p>

            <form method="POST" action="{{ route('admin.dashboard.jadwal.range') }}"
                class="mt-4 flex flex-wrap items-end gap-1 ">
                @csrf
                @method('PATCH')
                <input type="hidden" name="tanggal" value="{{ $selectedDate }}">

                <div>
                    <label class="block text-xs text-gray-500 mb-1">Mulai</label>
                    <select name="start_time"
                        class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-mainColor cursor-pointer"
                        required>
                        @foreach ($timeOptions as $time)
                            <option value="{{ $time }}">{{ $time }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs text-gray-500 mb-1">Selesai</label>
                    <select name="end_time"
                        class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-mainColor cursor-pointer"
                        required>
                        @foreach ($timeOptions as $time)
                            <option value="{{ $time }}">{{ $time }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" name="action" value="disable"
                    class="px-4 py-2 rounded-lg bg-gray-700 text-white text-sm font-medium hover:bg-gray-800 transition cursor-pointer">
                    Nonaktifkan Rentang
                </button>

                <button type="submit" name="action" value="enable"
                    class="px-4 py-2 rounded-lg bg-mainColor text-white text-sm font-medium hover:opacity-90 transition cursor-pointer">
                    Aktifkan Rentang
                </button>
            </form>
        </div>
    </div>

    <div
        class="mx-6 mb-4 bg-white rounded-xl border border-gray-100 shadow-sm p-4 flex-1 min-h-0 overflow-hidden flex flex-col">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-lg font-semibold text-gray-800">Slot Tanggal {{ $selectedDateLabel }}</h3>
            <span class="text-xs text-gray-500">Klik aksi per jam untuk kontrol detail</span>
        </div>

        <div class="overflow-y-auto flex-1 min-h-0 pr-1">
            <div class="grid grid-cols-1 md:grid-cols-3 2xl:grid-cols-4 gap-3">
                @forelse($slots as $slot)
                    @php
                        $slotTime = \Carbon\Carbon::parse($slot->waktu)->format('H:i');
                        $isDisabled = (bool) $slot->is_disabled;
                        $isBooked = !$isDisabled && !(bool) $slot->is_available;
                        $statusLabel = $isDisabled
                            ? 'Dinonaktifkan Admin'
                            : ($isBooked
                                ? 'Terisi Booking'
                                : 'Tersedia');
                        $statusClass = $isDisabled
                            ? 'bg-gray-100 text-gray-700'
                            : ($isBooked
                                ? 'bg-yellow-100 text-yellow-700'
                                : 'bg-green-100 text-green-700');
                    @endphp

                    <div
                        class="rounded-xl border border-gray-100 p-3 bg-gray-50/70 flex items-center justify-between gap-3">
                        <div>
                            <p class="text-lg font-bold text-gray-800">{{ $slotTime }}</p>
                            <span
                                class="inline-flex mt-1 px-2 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </div>

                        <form method="POST"
                            action="{{ route('admin.dashboard.jadwal.slot', $slot->slot_jadwal_id) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="tanggal" value="{{ $selectedDate }}">
                            <input type="hidden" name="action" value="{{ $isDisabled ? 'enable' : 'disable' }}">
                            <button type="submit"
                                class="px-3 py-2 rounded-lg text-xs font-semibold transition cursor-pointer {{ $isDisabled ? 'bg-mainColor text-white hover:opacity-90' : 'bg-gray-700 text-white hover:bg-gray-800' }}">
                                {{ $isDisabled ? 'Aktifkan' : 'Nonaktifkan' }}
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 py-10">
                        Slot untuk tanggal ini belum tersedia.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
