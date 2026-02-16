<div class="flex flex-col gap-4 px-28 pt-28">
    <div class="flex text-center gap-3 w-fit px-8 py-1 mb-4 rounded-full bg-linear-to-br from-mainColor to-thirdColor">
        <svg class="h-auto" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
            <path class="justify-center" fill="none" stroke="currentColor" stroke-linecap="round"
                  stroke-linejoin="round" stroke-width="2"
                  d="m2 2l20 20M8.35 2.69A10 10 0 0 1 21.3 15.65m-2.22 3.43A10 10 0 1 1 4.92 4.92"/>
        </svg>
        Pesan Sekarang
    </div>

    <div class="w-1/2">
        Pesan layanan kami sekarang juga! <span class="text-gray-500 italic">* Syarat dan ketentuan berlaku</span>
    </div>

    {{-- Konten Utama --}}
    <div class="flex w-full justify-between relative">
        <form action="{{ route('booking.store') }}" method="POST" class="flex flex-col w-full" id="bookingForm">
            @csrf
            {{-- Input Tanggal dan Waktu Booking --}}
            <input type="hidden" name="start_time" id="start_time">
            <input type="hidden" name="end_time" id="end_time">
            <input type="hidden" name="tanggal_booking" value="{{ $tanggal }}">

            <div class="flex">
                @include('components.pilih-layanan')
                @include('components.jadwal')
            </div>

            {{-- Tombol Trigger Modal Konfirmasi Pembayaran --}}
            <div class="w-full flex h-fit items-center">
                <div class="mt-8 w-1/2 text-xl font-semibold">
                    Total: <span id="total-harga">Rp 0</span>
                </div>

                <div class="mt-8 w-1/2">
                    @auth
                        <button
                            type="button"
                            id="btn-pre-submit"
                            class="flex w-1/3 justify-center items-center gap-3 px-5 py-2 text-lg rounded-full bg-secondaryColor cursor-pointer hover:shadow-md transition duration-300 text-white"
                        >
                            Pesan
                        </button>
                    @endauth

                    @guest
                        <a
                            href="{{ route('login') }}"
                            class="flex w-1/2 justify-center items-center gap-3 px-2 py-1 text-lg rounded-full bg-gray-500 cursor-pointer hover:bg-gray-600 transition duration-300 text-white text-center"
                        >
                            Login untuk Memesan
                        </a>
                    @endguest
                </div>
            </div>

            {{-- Modal Konfirmasi Pembayaran --}}
            <div id="confirmationModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/50 backdrop-blur-sm">
                <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl p-6 relative animate-fade-in-up">

                    {{-- Header Modal --}}
                    <h3 class="text-2xl font-bold text-mainColor mb-4 border-b pb-2">Konfirmasi Pesanan</h3>

                    <div class="grid grid-cols-2 gap-6">
                        {{-- Kolom Kiri (Ringkasan Layanan) --}}
                        <div class="bg-gray-50 p-4 rounded-lg border">
                            <h4 class="font-semibold text-gray-700 mb-2">Detail Layanan</h4>
                            <div id="modal-summary-list" class="text-sm space-y-2 mb-3 max-h-40 overflow-y-auto">
                                {{-- List layanan akan di-inject dari JS --}}
                            </div>
                            <div class="border-t pt-2 flex justify-between font-bold text-lg">
                                <span>Total:</span>
                                <span id="modal-total-price" class="text-secondaryColor">Rp 0</span>
                            </div>
                            <div class="mt-2 text-sm text-gray-600">
                                <p>Tanggal: <span class="font-medium">{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</span></p>
                                <p>Waktu: <span id="modal-time-range" class="font-medium">--:-- s/d --:--</span></p>
                            </div>
                        </div>

                        {{-- Kolom Kanan: Input Alamat & No HP --}}
                        <div class="space-y-4">
                            <h4 class="font-semibold text-gray-700">Data Pemesan</h4>

                            {{-- Input No HP --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp<span class="text-red-500">*</span></label>
                                <input
                                    type="text"
                                    name="no_hp"
                                    class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-mainColor focus:outline-none"
                                    value="{{ optional(Auth::user())->no_hp }}"
                                    placeholder="08xxxxxxxxxx"
                                    required
                                >
                            </div>

                            {{-- Input Alamat --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <textarea
                                    name="alamat"
                                    rows="3"
                                    class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-mainColor focus:outline-none"
                                    placeholder="Jl. Contoh No. 123, Kelurahan, Kecamatan..."
                                    required
                                >{{ optional(Auth::user())->alamat }}</textarea>
                            </div>

                            <p class="text-xs text-gray-500 italic">
                                *Pastikan nomor aktif dan alamat sesuai untuk kedatangan petugas.
                            </p>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" id="btn-cancel-modal" class="px-5 py-2 rounded-lg text-gray-600 hover:bg-gray-100 transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2 rounded-lg bg-mainColor text-white font-semibold hover:bg-green-700 transition shadow-lg cursor-pointer">
                            Konfirmasi & Pesan
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>

    <div class="flex gap-8 mt-4 text-gray-700">
        <p>Syarat dan Ketentuan :</p>
        <div class="flex flex-col">
            <p>Minimal booking satu hari setelah pemesanan</p>
            <p>Minimal booking sebanyak Rp. 100.000,00</p>
            <p>Minimal pembatalan booking satu hari sebelum hari pemesanan</p>
        </div>
    </div>
</div>
<script>
    const dbDates = @json($allDates ?? []);
</script>
