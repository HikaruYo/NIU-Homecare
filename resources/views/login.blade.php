<!doctype html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk | Niu Homecare</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset("LogoNIU.png") }}">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .bg-mint-gradient {
            background: linear-gradient(135deg, #67BF6E 0%, #73C479 100%);
        }
    </style>
</head>
<body class="bg-gray-50 antialiased">

@if (session('successRegister'))
    <div id="popup" class="fixed top-20 right-4 bg-green-500 text-white px-6 py-3 rounded-xl shadow-2xl z-50 animate-bounce">
        {{ session('successRegister') }}
    </div>
@endif

@if ($errors->any())
    <div id="popup-error" class="fixed top-20 right-4 bg-red-500 text-white px-6 py-3 rounded-xl shadow-2xl z-50">
        {{ $errors->first() }}
    </div>
@endif

@include('layout.header')

<main class="flex h-screen overflow-hidden">

    {{-- Left Content: Image & Branding --}}
    <div class="hidden lg:flex lg:w-7/12 relative items-center justify-center bg-gray-900">
        <div class="absolute inset-0 z-10 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
        <img src="{{ asset('assets/hair-spa.jpeg') }}" alt="Hair Spa" class="absolute inset-0 w-full h-full object-cover">

        <div class="relative z-20 p-12 text-white">
            <h1 class="text-5xl font-bold leading-tight">Manjakan Diri Anda <br> <span class="text-thirdColor">Di Rumah Saja.</span></h1>
            <p class="mt-4 text-lg text-gray-200 max-w-md">Layanan perawatan kecantikan profesional yang datang langsung ke pintu rumah Anda.</p>
        </div>
    </div>

    {{-- Right Content: Login Form --}}
    <div class="w-full lg:w-5/12 flex flex-col justify-center items-center p-8 lg:p-16 bg-white">
        <div class="w-full max-w-md">
            <div class="mb-6 text-center lg:text-left">
                <h2 class="text-3xl font-bold text-gray-800">Selamat Datang</h2>
                <p class="text-gray-500 mt-1">Silakan masuk untuk melanjutkan pesanan Anda.</p>
            </div>

            <form method="POST" action="/login" class="space-y-6">
                @csrf

                {{-- Email Field --}}
                <div class="space-y-2">
                    <label for="email" class="text-sm font-medium text-gray-700 ml-1">Email</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-focus-within:text-mainColor transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                            </svg>
                        </div>
                        <input
                            id="email" type="email" name="email" required
                            placeholder="nama@email.com"
                            class="block w-full pl-10 pr-3 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-mainColor focus:border-transparent transition-all"
                        />
                    </div>
                </div>

                {{-- Password Field --}}
                <div class="space-y-2">
                    <label for="password" class="text-sm font-medium text-gray-700 ml-1">Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-focus-within:text-mainColor transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input
                            id="password" type="password" name="password" required autocomplete="current-password"
                            placeholder="••••••••"
                            class="block w-full pl-10 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-mainColor focus:border-transparent transition-all"
                        />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center z-30">
                            <svg id="eye-open" class="cursor-pointer text-gray-400 hover:text-mainColor" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 12a3 3 0 1 1-6 0a3 3 0 0 1 6 0"/><path d="M2 12c1.6-4.097 5.336-7 10-7s8.4 2.903 10 7c-1.6 4.097-5.336 7-10 7s-8.4-2.903-10-7"/></svg>
                            <svg id="eye-closed" class="cursor-pointer hidden text-gray-400 hover:text-mainColor" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path stroke-linejoin="round" d="M10.73 5.073A11 11 0 0 1 12 5c4.664 0 8.4 2.903 10 7a11.6 11.6 0 0 1-1.555 2.788M6.52 6.519C4.48 7.764 2.9 9.693 2 12c1.6 4.097 5.336 7 10 7a10.44 10.44 0 0 0 5.48-1.52m-7.6-7.6a3 3 0 1 0 4.243 4.243"/><path d="m4 4l16 16"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Button Login --}}
                <button
                    type="submit"
                    class="w-full py-3 px-4 bg-mint-gradient text-white font-semibold rounded-xl shadow-lg hover:shadow-green-200 transition-all duration-300 active:scale-95 cursor-pointer"
                >
                    Masuk Sekarang
                </button>

                <p class="text-center text-sm text-gray-600">
                    Belum punya akun?
                    <a href="/register" class="font-bold text-mainColor hover:text-secondaryColor transition-colors">Daftar Gratis</a>
                </p>

                <div class="relative py-4">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200"></div></div>
                    <div class="relative flex justify-center text-xs uppercase"><span class="bg-white px-2 text-gray-500">Atau</span></div>
                </div>
            </form>
        </div>
    </div>
</main>

</body>
</html>
