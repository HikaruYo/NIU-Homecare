<div class="w-full h-full rounded-lg bg-white border-r border-mainGray shadow-sm flex flex-col justify-between">
    <div>
        <div class="mx-6 py-6 border-b-[2px] border-mainGray/50 flex justify-center">
            <a href="/">
                <img src="{{ asset('assets/LogoNIU.png') }}" alt="Logo" class="w-20 h-auto object-contain">
            </a>
        </div>

        <div class="px-6 py-6">
            <p class="text-sm text-gray-500 font-medium">Selamat Datang,</p>
            <h3 class="text-xl font-bold text-gray-800">Admin {{ $short }}</h3>
        </div>

        <nav class="px-4 space-y-2">
            @php
                $activeClass = 'bg-mainColor text-white shadow-md';
                $inactiveClass = 'text-gray-600 hover:bg-thirdColor/30 hover:text-mainColor';
            @endphp

            <a href="{{ route('admin.dashboard.laporan') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-300 group {{ $currentTab === 'laporan' ? $activeClass : $inactiveClass }}">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15v4m6-6v6m6-4v4m6-6v6M3 11l6-5 6 5 5.5-5.5"/>
                </svg>
                <span>Laporan Penghasilan</span>
            </a>

            <a href="{{ route('admin.dashboard.booking') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-300 group {{ $currentTab === 'booking' ? $activeClass : $inactiveClass }}">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16M8 14h8m-4-7V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z"/>
                </svg>
                <span>Daftar Booking</span>
            </a>

            <a href="{{ route('admin.dashboard.layanan') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-300 group {{ $currentTab === 'layanan' ? $activeClass : $inactiveClass }}">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 0 0-2 2v4m5-6h8M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m0 0h3a2 2 0 0 1 2 2v4m0 0v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-6m18 0s-4 2-9 2-9-2-9-2m9-2h.01"/>
                </svg>
                <span>Daftar Layanan</span>
            </a>
        </nav>
    </div>

    <div class="p-4 border-t border-mainGray/50">
        <form method="POST" action="{{ url('/logout') }}">
            @csrf
            <button class="w-full flex items-center justify-center gap-2 px-4 py-3 text-sm font-semibold text-red-500 bg-red-50 hover:bg-red-100 rounded-xl transition-colors duration-200 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Keluar
            </button>
        </form>
    </div>
</div>
