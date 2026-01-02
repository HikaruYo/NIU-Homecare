<!doctype html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar | Niu Homecare</title>
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

@include('layout.header')

<main class="flex h-screen overflow-hidden">

    {{-- Left Content --}}
    <div class="hidden lg:flex lg:w-7/12 relative items-center justify-center bg-gray-900">
        <div class="absolute inset-0 z-10 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
        <img src="{{ asset('assets/hair-spa.jpeg') }}" alt="Hair Spa" class="absolute inset-0 w-full h-full object-cover">

        <div class="relative z-20 p-12 text-white">
            <h1 class="text-5xl font-bold leading-tight">Bergabunglah dengan <br> <span class="text-thirdColor">Niu Homecare.</span></h1>
            <p class="mt-4 text-lg text-gray-200 max-w-md">Dapatkan akses ke berbagai layanan kecantikan profesional langsung di rumah Anda.</p>
        </div>
    </div>

    {{-- Right Content--}}
    <div class="w-full lg:w-5/12 flex flex-col justify-center items-center p-8 bg-white">
        <div class="w-full max-w-md my-auto">
            <div class="mb-6 text-center lg:text-left">
                <h2 class="text-3xl font-bold text-gray-800">Buat Akun</h2>
                <p class="text-gray-500 mt-1">Lengkapi data diri Anda untuk mulai memesan.</p>
            </div>

            <form method="POST" action="/register" class="space-y-2">
                @csrf

                {{-- Name Field --}}
                <div class="space-y-1">
                    <label for="name" class=" font-medium text-gray-700">Nama Lengkap</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-focus-within:text-mainColor transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input
                            id="name" type="text" name="username" required autocomplete="name"
                            placeholder="Masukkan nama lengkap"
                            class="block w-full pl-10 pr-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-mainColor focus:border-transparent transition-all"
                        />
                    </div>
                </div>

                {{-- Email Field --}}
                <div class="space-y-1">
                    <label for="email" class=" font-medium text-gray-700">Email</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-focus-within:text-mainColor transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                            </svg>
                        </div>
                        <input
                            id="email" type="email" name="email" required autocomplete="email"
                            placeholder="nama@email.com"
                            class="block w-full pl-10 pr-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-mainColor focus:border-transparent transition-all"
                        />
                    </div>
                </div>

                {{-- Password Field --}}
                <div class="space-y-1">
                    <label for="password" class=" font-medium text-gray-700">Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-focus-within:text-mainColor transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input
                            id="password" type="password" name="password" required autocomplete="new-password"
                            placeholder="••••••••"
                            class="block w-full pl-10 pr-12 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-mainColor focus:border-transparent transition-all"
                        />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg id="eye-open" class="cursor-pointer text-gray-400 hover:text-mainColor" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 12a3 3 0 1 1-6 0a3 3 0 0 1 6 0"/><path d="M2 12c1.6-4.097 5.336-7 10-7s8.4 2.903 10 7c-1.6 4.097-5.336 7-10 7s-8.4-2.903-10-7"/></svg>
                            <svg id="eye-closed" class="cursor-pointer hidden text-gray-400 hover:text-mainColor" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path stroke-linejoin="round" d="M10.73 5.073A11 11 0 0 1 12 5c4.664 0 8.4 2.903 10 7a11.6 11.6 0 0 1-1.555 2.788M6.52 6.519C4.48 7.764 2.9 9.693 2 12c1.6 4.097 5.336 7 10 7a10.44 10.44 0 0 0 5.48-1.52m-7.6-7.6a3 3 0 1 0 4.243 4.243"/><path d="m4 4l16 16"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Password Confirmation Field --}}
                <div class="space-y-1">
                    <label for="password_confirmation" class=" font-medium text-gray-700">Konfirmasi Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-focus-within:text-mainColor transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <input
                            id="password_confirmation" type="password" name="password_confirmation" required
                            placeholder="Ulangi password"
                            class="block w-full pl-10 pr-12 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-mainColor focus:border-transparent transition-all"
                        />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg id="eye-open-conf" class="cursor-pointer text-gray-400 hover:text-mainColor" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 12a3 3 0 1 1-6 0a3 3 0 0 1 6 0"/><path d="M2 12c1.6-4.097 5.336-7 10-7s8.4 2.903 10 7c-1.6 4.097-5.336 7-10 7s-8.4-2.903-10-7"/></svg>
                            <svg id="eye-closed-conf" class="cursor-pointer hidden text-gray-400 hover:text-mainColor" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path stroke-linejoin="round" d="M10.73 5.073A11 11 0 0 1 12 5c4.664 0 8.4 2.903 10 7a11.6 11.6 0 0 1-1.555 2.788M6.52 6.519C4.48 7.764 2.9 9.693 2 12c1.6 4.097 5.336 7 10 7a10.44 10.44 0 0 0 5.48-1.52m-7.6-7.6a3 3 0 1 0 4.243 4.243"/><path d="m4 4l16 16"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Button Register --}}
                <div class="pt-4">
                    <button
                        type="submit"
                        class="w-full py-3 px-4 bg-mint-gradient text-white font-semibold rounded-xl shadow-lg hover:shadow-green-200 transition-all duration-300 active:scale-95 cursor-pointer"
                    >
                        Buat Akun Sekarang
                    </button>
                </div>

                <p class="text-center text-sm text-gray-600 pt-2">
                    Sudah punya akun?
                    <a href="/login" class="font-bold text-mainColor hover:text-secondaryColor transition-colors">Masuk</a>
                </p>
            </form>
        </div>
    </div>

</main>

</body>
</html>
