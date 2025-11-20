<div class="flex flex-col justify-between h-full bg-mainColor shadow-lg rounded-lg">
    @php
        $activeClass = 'bg-thirdColor shadow-lg ';
        $inactiveClass = 'text-gray-700 hover:bg-gray-300';
    @endphp

    <div>
        <div class="mx-4 py-4 text-xl border-b-[2px] border-b-mainGray">
            <a href="/" >
                LOGO
            </a>
        </div>

        <div class="font-light text-lg px-4 py-3 mt-5">
            Hi, {{ $short }}
        </div>

        {{-- Content --}}
        <a href="{{ url('/dashboard?tab=profil') }}"
           class="flex m-3 items-center p-3 rounded-lg transition duration-300
           {{ $currentTab === 'profil' ? $activeClass : $inactiveClass }}"
        >
            Profil Pengguna
        </a>
        <a href="{{ url('/dashboard?tab=histori') }}"
           class="flex m-3 items-center p-3 rounded-lg transition duration-300
           {{ $currentTab === 'histori' ? $activeClass : $inactiveClass }}"
        >
            Riwayat Pemesanan
        </a>
    </div>

    <div class="p-4">
        <form method="POST" action="{{ url('/logout') }}">
            @csrf
            <button
                type="submit"
                class="block w-full text-center rounded-lg px-4 py-2 text-lg text-red-600 hover:shadow-md hover:bg-gray-100 transition duration-300 cursor-pointer"
            >
                Logout
            </button>
        </form>
    </div>

</div>
