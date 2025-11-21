<div class="w-full h-full bg-mainColor shadow-lg rounded-lg flex flex-col justify-between">
    <div>
        <div class="mx-4 py-4 text-xl border-b-[2px] border-b-mainGray">
            <a href="/">LOGO</a>
        </div>

        <div class="font-light text-lg px-4 py-3 mt-5">
            Hi, {{ $short }}
        </div>

        @php
            $active = 'bg-thirdColor shadow-lg';
            $inactive = 'text-gray-700 hover:bg-gray-300';
        @endphp

        <a href="{{ route('dashboard.profil') }}"
           class="flex m-3 items-center p-3 rounded-lg transition duration-300
           {{ $currentTab === 'profil' ? $active : $inactive }}">
            Profil Pengguna
        </a>

        <a href="{{ route('dashboard.histori') }}"
           class="flex m-3 items-center p-3 rounded-lg transition duration-300
           {{ $currentTab === 'histori' ? $active : $inactive }}">
            Riwayat Pemesanan
        </a>
    </div>

    <div class="p-4">
        <form method="POST" action="{{ url('/logout') }}">
            @csrf
            <button class="w-full px-4 py-2 text-lg text-red-600 rounded-lg hover:bg-gray-100 shadow transition">
                Logout
            </button>
        </form>
    </div>
</div>
