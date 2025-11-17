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
    <div class="min-w-7/12 pt-20">
        Image
    </div>

    {{-- Right Content --}}
    <div class="flex flex-col w-full justify-center items-center">
        <div class="flex flex-col w-3/4 p-4 bg-mainColor items-center rounded-xl space-y-8">
            <div class="">
                <h2 class="text-2xl font-semibold">Masuk ke Akun Anda</h2>
            </div>

            <div class="">
                <form method="POST" class="space-y-2">
                    {{-- Email Field --}}
                    <div class="flex flex-col w-full items-start text-left">
                        <label for="email" class="block">
                            Email
                        </label>
                        <div class="mt-1">
                            <input
                                id="email"
                                type="email"
                                name="email"
                                required autocomplete="email"
                                class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-gray-600 outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2"
                            />
                        </div>
                    </div>

                    {{-- Password Field --}}
                    <div class="flex flex-col w-full items-start text-left">
                        <label for="email" class="block">
                            Password
                        </label>
                        <div class="mt-1">
                            <input
                                id="email"
                                type="email"
                                name="email"
                                required autocomplete="email"
                                class="block w-full rounded-md bg-gray-200 px-3 py-1.5 text-base text-gray-600 outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2"
                            />
                        </div>
                    </div>

                    {{-- Button Login --}}
                    <div>
                        <button
                            type="submit"
                            class="flex w-full bg-mainGray"
                        >
                            Masuk
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</main>

</body>
