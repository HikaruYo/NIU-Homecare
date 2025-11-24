<header class="fixed w-full top-0 z-10 bg-white">
    <div class="flex w-full justify-between px-28 py-4 shadow-sm">
        {{-- LOGO --}}
        <a href="/">
            <img src="{{ asset('assets/LogoNIU.png') }}" alt="Logo" class="w-12 h-6">
        </a>

        {{-- Nav Link --}}
        <div id="navlink" class="flex gap-12">
            <a href="/#beranda"
               class="relative
              after:bg-mainColor
              after:absolute
              after:h-[2px]
              after:w-full
              after:bottom-0
              after:left-0
              after:scale-x-0
              after:origin-right
              hover:after:scale-x-100
              hover:after:origin-left
              after:transition-transform
              after:duration-300
              cursor-pointer"
            >
                Beranda
            </a>
            <a href="/#layanan"
               class="relative
              after:bg-mainColor
              after:absolute
              after:h-[2px]
              after:w-full
              after:bottom-0
              after:left-0
              after:scale-x-0
              after:origin-right
              hover:after:scale-x-100
              hover:after:origin-left
              after:transition-transform
              after:duration-300
              cursor-pointer"
            >
                Layanan
            </a>
            <a href="/#pesan"
               class="relative
              after:bg-mainColor
              after:absolute
              after:h-[2px]
              after:w-full
              after:bottom-0
              after:left-0
              after:scale-x-0
              after:origin-right
              hover:after:scale-x-100
              hover:after:origin-left
              after:transition-transform
              after:duration-300
              cursor-pointer"
            >
                Pesan
            </a>
        </div>

        {{-- Profile --}}
        <div class="flex items-center">
            @if(Auth::check())
                @php
                    $user = auth()->user();
                    $full = $user->username;
                    $short = strlen($full) > 8 ? substr($full, 0, 8) . '..' : $full;
                @endphp

                {{-- Dropdown Container --}}
                <div class="relative">
                    {{-- Trigger --}}
                    <button
                        id="profileDropdownBtn"
                        type="button"
                        class="flex items-center text-gray-800 focus:outline-none cursor-pointer"
                    >
                        Hai, {{ $short }}
                        <svg class="w-6 h-6 ml-1 transition-transform duration-300" id="dropdownArrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="m12 15l-4-4h8l-4 4"/></svg>
                    </button>

                    {{-- Dropdown Menu --}}
                    <div
                        id="profileDropdownMenu"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl z-50 py-2 hidden border border-gray-200"
                    >
                        <a href="/dashboard/profil" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">
                            Dashboard
                        </a>

                        <form method="POST" action="{{ url('/logout') }}">
                            @csrf
                            <button
                                type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 cursor-pointer"
                            >
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="/login" class="hover:underline">
                    Login
                </a>
            @endif
        </div>
    </div>
</header>
