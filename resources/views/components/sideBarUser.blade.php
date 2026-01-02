<div class="w-full h-full rounded-lg bg-white border-r border-mainGray shadow-sm flex flex-col justify-between">
    <div>
        <div class="mx-6 py-6 border-b border-mainGray/50 flex justify-center">
            <a href="/">
                <img src="{{ asset('assets/LogoNIU.png') }}" alt="Logo" class="w-20 h-auto object-contain">
            </a>
        </div>

        <div class="px-6 py-6">
            <p class="text-sm text-gray-500 font-medium">Selamat Datang,</p>
            <h3 class="text-xl font-bold text-gray-800">{{ $short }}</h3>
        </div>

        <nav class="px-4 space-y-2">
            @php
                $activeClass = 'bg-mainColor text-white shadow-md';
                $inactiveClass = 'text-gray-600 hover:bg-thirdColor/30 hover:text-mainColor';
            @endphp

            <a href="{{ route('dashboard.profil') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-300 group {{ $currentTab === 'profil' ? $activeClass : $inactiveClass }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>Profil Pengguna</span>
            </a>

            <a href="{{ route('dashboard.histori') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-300 group {{ $currentTab === 'histori' ? $activeClass : $inactiveClass }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Riwayat Pemesanan</span>
            </a>
        </nav>
    </div>

    <div class="p-4 border-t border-mainGray/50">
        <form method="POST" action="{{ url('/logout') }}">
            @csrf
            <button class="w-full flex items-center justify-center gap-2 px-4 py-3 text-sm font-semibold text-red-500 bg-red-50 hover:bg-red-100 rounded-xl transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Keluar
            </button>
        </form>
    </div>
</div>
