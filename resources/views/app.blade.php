<!doctype html>
<html lang="en" class="scroll-smooth overscroll-none no-scrollbar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Niu Homecare</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="w-full bg-gray-50 ">
    @if (session('successLogin'))
        <div id="popup"
             class="fixed top-16 right-4 bg-green-600 text-white px-4 py-2 rounded shadow-lg z-50 transition-opacity duration-500">
            {{ session('successLogin') }}
        </div>
    @endif

    @if ($errors->any())
        <div id="popup-error"
             class="fixed top-4 right-4 bg-red-600 text-white px-4 py-2 rounded shadow-lg z-50 transition-opacity duration-500">
            {{ $errors->first() }}
        </div>
    @endif

    @include('layout.header')

    {{-- TODO: masukkan gambar sebagai background dengan slider otomatis --}}
    <div id="beranda" class="h-screen bg-gray-50"
        style="
            {{--background-image: url('{{ asset('assets/potong-rambut.jpeg') }}');--}}
            background-size: cover;
            background-position: center;
        "
    >
        @include('layout.homepage')
    </div>

    <div id="layanan" class="h-sreen bg-mainColor">
        @include('layout.layanan', ['layanans' => $layanans])
    </div>
    <div id="pesan" class="h-screen bg-gray-50">
        @include('layout.pesan', ['slots' => $slots])
    </div>

    @include('layout.scrollUpButton')

    @include('layout.footer')

    <script>
        window.addEventListener("storage", function(event) {
            if (event.key === "logout") {
                window.location.href = "/login";
            }
        });
    </script>

</body>

</html>
