<!doctype html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Niu Homecare</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="w-full bg-gray-50">

@include('layout.header')

<main class="flex h-screen">

    {{-- Left Content --}}
    <div class="min-w-7/12 bg-white pt-20"
         style="
                background-image: linear-gradient(rgba(0,0,0,0.1), rgba(0,0,0,0.4)), url('{{ asset('assets/hair-spa.jpeg') }}');
                background-size: cover;
                background-position: center;
            "
    >
        {{-- TODO: buat automatic carousel untuk beberapa gambar --}}
    </div>

    {{-- Right Content --}}
    <div class="flex flex-col w-full justify-center items-center">
        <div class="flex flex-col w-3/4 p-4 bg-mainColor items-center rounded-xl space-y-8">
            <div class="">
                <h2 class="text-2xl font-semibold">Buat Akun</h2>
            </div>

            <div class="">
                <form method="POST" action="/register" class="flex flex-col mb-4 space-y-2">
                    @csrf
                    {{-- Name Field --}}
                    <div class="flex flex-col items-start text-left">
                        <label for="name" class="block">
                            Nama
                        </label>
                        <div class="flex w-full rounded-md bg-gray-200 px-3 py-1.5 text-base text-gray-600 outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus-within:outline-2 focus-within:-outline-offset-2">
                            <input
                                id="name"
                                type="text"
                                name="username"
                                required autocomplete="name"
                                class="w-full bg-transparent focus:outline-none"
                            />
                        </div>
                    </div>

                    {{-- Email Field --}}
                    <div class="flex flex-col items-start text-left">
                        <label for="email" class="block">
                            Email
                        </label>
                        <div class="flex w-full rounded-md bg-gray-200 px-3 py-1.5 text-base text-gray-600 outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus-within:outline-2 focus-within:-outline-offset-2">
                            <input
                                id="email"
                                type="email"
                                name="email"
                                required autocomplete="email"
                                class="w-full bg-transparent focus:outline-none"
                            />
                        </div>
                    </div>

                    {{-- Password Field --}}
                    <div class="flex flex-col items-start text-left">
                        <label for="password" class="block">
                            Password
                        </label>
                        <div class="flex items-center rounded-md bg-gray-200 px-3 py-1.5 text-base text-gray-600 outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus-within:outline-2 focus-within:-outline-offset-2"
                        >
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required autocomplete="password"
                                class="w-full bg-transparent focus:outline-none"
                            />
                            {{-- Eye Icon --}}
                            <svg id="eye-open" class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M15 12a3 3 0 1 1-6 0a3 3 0 0 1 6 0"/><path d="M2 12c1.6-4.097 5.336-7 10-7s8.4 2.903 10 7c-1.6 4.097-5.336 7-10 7s-8.4-2.903-10-7"/></g></svg>
                            <svg id="eye-closed" class="cursor-pointer hidden" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2"><path stroke-linejoin="round" d="M10.73 5.073A11 11 0 0 1 12 5c4.664 0 8.4 2.903 10 7a11.6 11.6 0 0 1-1.555 2.788M6.52 6.519C4.48 7.764 2.9 9.693 2 12c1.6 4.097 5.336 7 10 7a10.44 10.44 0 0 0 5.48-1.52m-7.6-7.6a3 3 0 1 0 4.243 4.243"/><path d="m4 4l16 16"/></g></svg>
                        </div>
                    </div>

                    {{-- Password Confirmation Field --}}
                    <div class="flex flex-col items-start text-left">
                        <label for="password_confirmation" class="block">
                            Konfirmasi Password
                        </label>
                        <div class="flex items-center rounded-md bg-gray-200 px-3 py-1.5 text-base text-gray-600 outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus-within:outline-2 focus-within:-outline-offset-2"
                        >
                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                required autocomplete="password"
                                class="w-full bg-transparent focus:outline-none"
                            />
                            {{-- Eye Icon --}}
                            <svg id="eye-open-conf" class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M15 12a3 3 0 1 1-6 0a3 3 0 0 1 6 0"/><path d="M2 12c1.6-4.097 5.336-7 10-7s8.4 2.903 10 7c-1.6 4.097-5.336 7-10 7s-8.4-2.903-10-7"/></g></svg>
                            <svg id="eye-closed-conf" class="cursor-pointer hidden" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2"><path stroke-linejoin="round" d="M10.73 5.073A11 11 0 0 1 12 5c4.664 0 8.4 2.903 10 7a11.6 11.6 0 0 1-1.555 2.788M6.52 6.519C4.48 7.764 2.9 9.693 2 12c1.6 4.097 5.336 7 10 7a10.44 10.44 0 0 0 5.48-1.52m-7.6-7.6a3 3 0 1 0 4.243 4.243"/><path d="m4 4l16 16"/></g></svg>
                        </div>
                    </div>

                    {{-- Button Register --}}
                    <div class="flex items-center mt-6">
                        <button
                            type="submit"
                            class="w-full p-1 bg-mainGray rounded-lg hover:shadow-md hover:bg-gray-300 cursor-pointer transition duration-300"
                        >
                            Buat Akun
                        </button>
                    </div>

                    <div class="flex justify-center mt-2">
                        <p class="text-sm">Suda punya akun? <a href="/login" class="text-blue-800 hover:text-blue-700">Masuk</a></p>
                    </div>
                </form>
            </div>
        </div>

    </div>

</main>

</body>
</html>
