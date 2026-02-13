<header class="fixed w-full top-0 z-[100] bg-white shadow-sm">
    <nav class="flex w-full justify-between items-center px-6 lg:px-28 py-4">
        {{-- LOGO --}}
        <a href="/" class="z-50">
            <img src="{{ asset('assets/LogoNIU.png') }}" alt="Logo" class="w-12 h-6">
        </a>

        {{-- Desktop Nav Link --}}
        <div id="navlink-desktop" class="hidden lg:flex gap-12">
            @php $links = [['Beranda', '/#beranda'], ['Layanan', '/#layanan'], ['Pesan', '/#pesan']]; @endphp
            @foreach($links as $link)
                <a href="{{ $link[1] }}" class="relative after:bg-mainColor after:absolute after:h-[2px] after:w-full after:bottom-0 after:left-0 after:scale-x-0 after:origin-right hover:after:scale-x-100 hover:after:origin-left after:transition-transform after:duration-300 cursor-pointer">
                    {{ $link[0] }}
                </a>
            @endforeach
        </div>

        {{-- Desktop Profile/Login --}}
        <div class="hidden lg:flex items-center">
            @if(Auth::check())
                @php
                    $user = auth()->user();
                    $full = $user->username;
                    $short = strlen($full) > 8 ? substr($full, 0, 8) . '..' : $full;
                @endphp
                <div class="relative">
                    <button id="profileDropdownBtn" type="button" class="flex items-center text-gray-800 focus:outline-none cursor-pointer">
                        Hai, {{ $short }}
                        <svg class="w-6 h-6 ml-1 transition-transform duration-300" id="dropdownArrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="m12 15l-4-4h8l-4 4"/></svg>
                    </button>
                    <div id="profileDropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl z-50 py-2 hidden border border-gray-200">
                        <a href="/dashboard/profil" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                        <form method="POST" action="{{ url('/logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="/login" class="hover:text-mainColor transition-colors">Login</a>
            @endif
        </div>

        {{-- Mobile Menu Button (Hamburger) --}}
        <button id="mobileMenuBtn" class="lg:hidden flex flex-col justify-between w-6 h-5 z-50 focus:outline-none">
            <span id="line1" class="w-full h-0.5 bg-gray-800 transition-all duration-300 origin-left"></span>
            <span id="line2" class="w-full h-0.5 bg-gray-800 transition-all duration-300"></span>
            <span id="line3" class="w-full h-0.5 bg-gray-800 transition-all duration-300 origin-left"></span>
        </button>
    </nav>

    {{-- Mobile Menu Dropdown --}}
    <div id="mobileMenu" class="lg:hidden overflow-hidden max-h-0 bg-white border-t border-gray-100 transition-all duration-500 ease-in-out">
        <div class="flex flex-col p-6 gap-6">
            <a href="/#beranda" class="text-lg font-medium text-gray-700">Beranda</a>
            <a href="/#layanan" class="text-lg font-medium text-gray-700">Layanan</a>
            <a href="/#pesan" class="text-lg font-medium text-gray-700">Pesan</a>
            <hr class="border-gray-100">
            @if(Auth::check())
                <a href="/dashboard/profil" class="text-lg font-medium text-gray-700">Dashboard</a>
                <form method="POST" action="{{ url('/logout') }}">
                    @csrf
                    <button type="submit" class="text-lg font-medium text-red-600">Logout</button>
                </form>
            @else
                <a href="/login" class="text-lg font-medium text-mainColor">Login</a>
            @endif
        </div>
    </div>
</header>
